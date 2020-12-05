<?php

namespace App\Http\Controllers;

use App\Indikator;
use App\NilaiIndikator;
use App\Ulangan;
use App\Ekstrakulikuler;
use Illuminate\Support\Facades\Auth;
use App\Nilai;
use App\Guru;
use App\Siswa;
use App\Kelas;
use App\Mapel;
use App\Jadwal;
use App\Rapot;
use App\Sikap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use DB;
use Dompdf\Dompdf;

class RapotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guru = Guru::where('id_card', Auth::user()->id_card)->first();
        $jadwal = Jadwal::where('guru_id', $guru->id)->orderBy('kelas_id')->get();
        $kelas = $jadwal->groupBy('kelas_id');

        return view('guru.rapot.kelas', compact('kelas', 'guru'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        return view('admin.rapot.home', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $guru = Guru::findorfail($request->guru_id);
        $cekJadwal = Jadwal::where('guru_id', $guru->id)->where('kelas_id', $request->kelas_id)->count();
        if ($cekJadwal >= 1) {
            Rapot::updateOrCreate(
                [
                    'id' => $request->id
                ],
                [
                    'siswa_id' => $request->siswa_id,
                    'kelas_id' => $request->kelas_id,
                    'guru_id' => $request->guru_id,
                    'mapel_id' => $guru->mapel_id,
                    'k_nilai' => $request->nilai,
                    'k_predikat' => $request->predikat,
                    'k_deskripsi' => $request->deskripsi,
                ]
            );
            return response()->json(['success' => 'Nilai rapot siswa berhasil ditambahkan!']);
        } else {
            return response()->json(['error' => 'Maaf guru ini tidak mengajar kelas ini!']);
        }
    }


    private function get_indikator_avg($guru_id, $siswa_id, $tipe_indikator)
    {
        $indikators = Indikator::where([
            ['guru_id', '=', $guru_id],
            ['tipe', '=', $tipe_indikator]
        ])->get();
        $scores = [];
        foreach ($indikators as $indikator) {
            $nilai = NilaiIndikator::where([
                ['siswa_id', '=', $siswa_id],
                ['indikator_id', '=', $indikator->id],
            ])->get()->first();
            array_push($scores, $nilai->nilai_indikator);
        }
        return array_sum($scores)/count($scores);
    }

    private function get_predikat($guru_id, $score)
    {
        $nilai = Nilai::where([
            ['guru_id', '=', $guru_id],
        ])->get()->first();
        if ($score > 90) {
            return ['predikat' => 'A', 'deskripsi' => $nilai->deskripsi_a];
        }
        if ($score > 80) {
            return ['predikat' => 'B', 'deskripsi' => $nilai->deskripsi_b];
        }
        if ($score > 60) {
            return ['predikat' => 'C', 'deskripsi' => $nilai->deskripsi_c];
        }
        if ($score < 60) {
            return ['predikat' => 'D', 'deskripsi' => $nilai->deskripsi_d];
        }
    }

    public function show($items)
    {
        $items = Crypt::decrypt($items);
        $id = $items['id'];
        $tipe = $items['tipe'];
        $guru = Guru::where('id_card', Auth::user()->id_card)->get()->first();
        $kelas = Kelas::where('id', $id)->get()->first();
        $data_siswa = Siswa::where('kelas_id', $id)->get();
        $tipe_ulangan = Ulangan::select('tipe_uts', 'tipe_uas')->where('kelas_id', $kelas->id)->get()->first();

        $siswa = [];
        $tipe_uts = $tipe_ulangan->tipe_uts;
        $tipe_uas = $tipe_ulangan->tipe_uas;
        if ($tipe == 'uts') {
            foreach ($data_siswa as $item) {
                $nilai_keterampilan = ($tipe_uts == 1) ?
                    ( $item->nilai_ulangan('uts', $guru->mapel_id)->uts + $this->get_indikator_avg($guru->id, $item->id, 1)) / 2 :
                    $this->get_indikator_avg($guru->id, $item->id, 1);
                $nilai_pengetahuan = ($tipe_uts == 0) ?
                    ( $item->nilai_ulangan('uts', $guru->mapel_id)->uts + $this->get_indikator_avg($guru->id, $item->id, 0)) / 2 :
                    $this->get_indikator_avg($guru->id, $item->id, 0);
                $predikat_keterampilan = $this->get_predikat($guru->id, $nilai_keterampilan);
                $predikat_pengetahuan = $this->get_predikat($guru->id, $nilai_pengetahuan);
                $data = [
                    'id' => $item->id,
                    'nama' => $item->nama_siswa,
                    'pengetahuan' => [
                        'nilai' => (int) $nilai_pengetahuan,
                        'predikat' => $predikat_pengetahuan['predikat'],
                        'deskripsi' => $predikat_pengetahuan['deskripsi'],
                    ],
                    'keterampilan' => [
                        'nilai' => (int) $nilai_keterampilan,
                        'predikat' => $predikat_keterampilan['predikat'],
                        'deskripsi' => $predikat_keterampilan['deskripsi'],
                    ],
                ];
                array_push($siswa, $data);
            }
        } else {
            foreach ($data_siswa as $item) {
                $nilai_keterampilan = ($tipe_uas == 1) ?
                    ( $item->nilai_ulangan('uas', $guru->mapel_id)->uas + $this->get_indikator_avg($guru->id, $item->id, 1)) / 2 :
                    $this->get_indikator_avg($guru->id, $item->id, 1);
                $nilai_pengetahuan = ($tipe_uas == 0) ?
                    ( $item->nilai_ulangan('uas', $guru->mapel_id)->uas + $this->get_indikator_avg($guru->id, $item->id, 0)) / 2 :
                    $this->get_indikator_avg($guru->id, $item->id, 0);
                $predikat_keterampilan = $this->get_predikat($guru->id, $nilai_keterampilan);
                $predikat_pengetahuan = $this->get_predikat($guru->id, $nilai_pengetahuan);
                $data = [
                    'id' => $item->id,
                    'nama' => $item->nama_siswa,
                    'pengetahuan' => [
                        'nilai' => (int) $nilai_pengetahuan,
                        'predikat' => $predikat_pengetahuan['predikat'],
                        'deskripsi' => $predikat_pengetahuan['deskripsi'],
                    ],
                    'keterampilan' => [
                        'nilai' => (int) $nilai_keterampilan,
                        'predikat' => $predikat_keterampilan['predikat'],
                        'deskripsi' => $predikat_keterampilan['deskripsi'],
                    ],
                ];
                array_push($siswa, $data);
            }
        }


        return view('guru.rapot.rapot', compact('tipe','guru', 'kelas', 'siswa'));
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
        $kelas = Kelas::findorfail($id);
        $siswa = Siswa::orderBy('nama_siswa')->where('kelas_id', $id)->get();
        return view('admin.rapot.index', compact('kelas', 'siswa'));
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
        //
    }

    public function rapot($id)
    {
        $id = Crypt::decrypt($id);
        $siswa = Siswa::findorfail($id);
        $kelas = Kelas::findorfail($siswa->kelas_id);
        $jadwal = Jadwal::orderBy('mapel_id')->where('kelas_id', $kelas->id)->get();
        $mapel = $jadwal->groupBy('mapel_id');
        return view('admin.rapot.show', compact('mapel', 'siswa', 'kelas'));
    }

    public function predikat(Request $request)
    {
        $nilai = Nilai::where('guru_id', $request->id)->first();
        if ($request->nilai > 90) {
            $newForm[] = array(
                'predikat' => 'A',
                'deskripsi' => $nilai->deskripsi_a,
            );
        } else if ($request->nilai > 80) {
            $newForm[] = array(
                'predikat' => 'B',
                'deskripsi' => $nilai->deskripsi_b,
            );
        } else if ($request->nilai > 60) {
            $newForm[] = array(
                'predikat' => 'C',
                'deskripsi' => $nilai->deskripsi_c,
            );
        } else {
            $newForm[] = array(
                'predikat' => 'D',
                'deskripsi' => $nilai->deskripsi_d,
            );
        }
        return response()->json($newForm);
    }

    public function siswa()
    {
        $siswa = Siswa::where('no_induk', Auth::user()->no_induk)->first();
        $kelas = Kelas::findorfail($siswa->kelas_id);
        $pai = Mapel::where('nama_mapel', 'Pendidikan Agama dan Budi Pekerti')->first();
        $ppkn = Mapel::where('nama_mapel', 'Pendidikan Pancasila dan Kewarganegaraan')->first();
        if ($pai != null && $ppkn != null) {
            $Spai = Sikap::where('siswa_id', $siswa->id)->where('mapel_id', $pai->id)->first();
            $Sppkn = Sikap::where('siswa_id', $siswa->id)->where('mapel_id', $ppkn->id)->first();
        } else {
            $Spai = "";
            $Sppkn = "";
        }
        $jadwal = Jadwal::where('kelas_id', $kelas->id)->orderBy('mapel_id')->get();
        $mapel = $jadwal->groupBy('mapel_id');
        return view('siswa.rapot', compact('siswa', 'kelas', 'mapel', 'Spai', 'Sppkn'));
    }

    public function indexekstrakulikuler(Request $request){
        $user= $request->user();
        $mapel = Mapel::where('kelompok', 'C')->get();
        $guru= Guru::firstWhere('walikelas', $user->walikelas);
        $kelas= Kelas::firstWhere('nama_kelas', $guru->walikelas);
        $siswa= Siswa::where('kelas_id', $kelas->id)->get();
        
        return view('guru.rapot.ekstrakulikuler', compact('user', 'guru','kelas','siswa','mapel'));
    }

    public function inputekstrakulikuler(Request $request){
        $id = null;
        $existing = Ekstrakulikuler::where([
            ['siswa_id', '=', $request->siswa_id],
        ])
        ->get()
        ->first();

        if ($existing) {
            $id = $existing->id;
        }

        
        Ekstrakulikuler::updateOrCreate(
            [ 'id' => $id ],
            [
                'siswa_id' => $request->siswa_id,
                'name' => $request->name,
                'score' => $request->score,
                'description' => $request->description,

                
            ]
        );
        return redirect()->back()->with('success', 'Success!');
    }
}
