<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\JadwalTahfiz;
use App\Hari;
use App\Kelas;
use App\Tahfiz;
use App\Siswa;
use App\Ruang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use PDF;
use App\Exports\JadwalExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class JadwalTahfizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hari = Hari::all();
        $kelas = Kelas::OrderBy('nama_kelas', 'asc')->get();
        $ruang = Ruang::all();
        $tahfiz = Tahfiz::OrderBy('kode', 'asc')->get();
        return view('admin.jadwalTahfiz.index', compact('hari', 'kelas', 'tahfiz', 'ruang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'hari_id' => 'required',
            'kelas_id' => 'required',
            'tahfiz_id' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'ruang_id' => 'required',
        ]);

        $tahfiz = Tahfiz::findorfail($request->tahfiz_id);
        JadwalTahfiz::updateOrCreate(
            [
                'id' => $request->jadwalTahfiz_id
            ],
            [
                'hari_id' => $request->hari_id,
                'kelas_id' => $request->kelas_id,
                'mapel_id' => $tahfiz->mapel_id,
                'tahfiz_id' => $request->tahfiz_id,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'ruang_id' => $request->ruang_id,
            ]
        );

        return redirect()->back()->with('success', 'Data jadwal berhasil diperbarui!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $kelas = Kelas::findorfail($id);
        $jadwalTahfiz = JadwalTahfiz::OrderBy('hari_id', 'asc')->OrderBy('jam_mulai', 'asc')->where('kelas_id', $id)->get();
        return view('admin.jadwalTahfiz.show', compact('jadwalTahfiz', 'kelas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $jadwalTahfiz = JadwalTahfiz::findorfail($id);
        $hari = Hari::all();
        $kelas = Kelas::all();
        $ruang = Ruang::all();
        $tahfiz = Tahfiz::OrderBy('kode', 'asc')->get();
        return view('admin.jadwalTahfiz.edit', compact('jadwalTahfiz', 'hari', 'kelas', 'tahfiz', 'ruang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jadwalTahfiz = JadwalTahfiz::findorfail($id);
        $jadwalTahfiz->delete();

        return redirect()->back()->with('warning', 'Data jadwal berhasil dihapus! (Silahkan cek trash data jadwal)');
    }

    public function trash()
    {
        $jadwalTahfiz = JadwalTahfiz::onlyTrashed()->get();
        return view('admin.jadwalTahfiz.trash', compact('jadwalTahfiz'));
    }

    public function restore($id)
    {
        $id = Crypt::decrypt($id);
        $jadwalTahfiz = JadwalTahfiz::withTrashed()->findorfail($id);
        $jadwalTahfiz->restore();
        return redirect()->back()->with('info', 'Data jadwal berhasil direstore! (Silahkan cek data jadwal)');
    }

    public function kill($id)
    {
        $jadwalTahfiz = JadwalTahfiz::withTrashed()->findorfail($id);
        $jadwalTahfiz->forceDelete();
        return redirect()->back()->with('success', 'Data jadwal berhasil dihapus secara permanent');
    }

    public function view(Request $request)
    {
        $jadwalTahfiz = JadwalTahfiz::OrderBy('hari_id', 'asc')->OrderBy('jam_mulai', 'asc')->where('kelas_id', $request->id)->get();
        foreach ($jadwalTahfiz as $val) {
            $newForm[] = array(
                'hari' => $val->hari->nama_hari,
                'mapel' => $val->mapel->nama_mapel,
                'kelas' => $val->kelas->nama_kelas,
                'tahfiz' => $val->tahfiz->nama_tahfiz,
                'jam_mulai' => $val->jam_mulai,
                'jam_selesai' => $val->jam_selesai,
                'ruang' => $val->ruang->nama_ruang,
            );
        }
        return response()->json($newForm);
    }

    public function jadwalSekarang(Request $request)
    {
        $jadwalTahfiz = JadwalTahfiz::OrderBy('jam_mulai')->OrderBy('jam_selesai')->OrderBy('kelas_id')->where('hari_id', $request->hari)->where('jam_mulai', '<=', $request->jam)->where('jam_selesai', '>=', $request->jam)->get();
        foreach ($jadwalTahfiz as $val) {
            $newForm[] = array(
                'mapel' => $val->mapel->nama_mapel,
                'kelas' => $val->kelas->nama_kelas,
                'tahfiz' => $val->tahfiz->nama_tahfiz,
                'jam_mulai' => $val->jam_mulai,
                'jam_selesai' => $val->jam_selesai,
                'ruang' => $val->ruang->nama_ruang,
                'ket' => $val->absen($val->tahfiz_id),
            );
        }
        return response()->json($newForm);
    }


    public function tahfiz()
    {
        $tahfiz = Tahfiz::where('id_cardTahfiz', Auth::user()->id_cardTahfiz)->first();
        $jadwalTahfiz = JadwalTahfiz::orderBy('hari_id')->OrderBy('jam_mulai')->where('tahfiz_id', $tahfiz->id)->get();
        return view('tahfiz.jadwal', compact('jadwalTahfiz', 'tahfiz'));
    }

    public function siswaTahfiz()
    {
        $siswa = Siswa::where('no_induk', Auth::user()->no_induk)->first();
        $kelas = Kelas::findorfail($siswa->kelas_id);
        $jadwalTahfiz = JadwalTahfiz::orderBy('hari_id')->OrderBy('jam_mulai')->where('kelas_id', $kelas->id)->get();
        return view('siswa.jadwalTahfiz', compact('jadwal', 'kelas', 'siswaTahfiz'));
    }


    public function export_excel()
    {
        return Excel::download(new JadwalExport, 'jadwal.xlsx');
    }


    public function deleteAll()
    {
        $jadwalTahfiz = JadwalTahfiz::all();
        if ($jadwalTahfiz->count() >= 1) {
            JadwalTahfiz::whereNotNull('id')->delete();
            JadwalTahfiz::withTrashed()->whereNotNull('id')->forceDelete();
            return redirect()->back()->with('success', 'Data table jadwal berhasil dihapus!');
        } else {
            return redirect()->back()->with('warning', 'Data table jadwal kosong!');
        }
    }
}
