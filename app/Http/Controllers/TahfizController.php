<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tahfiz;
use App\Mapel;
use Illuminate\Support\Facades\Crypt;
class TahfizController extends Controller
{
    public function index()
    {
        $mapel = Mapel::orderBy('nama_mapel')->get();
        $max = Tahfiz::max('id_card');
        return view('admin.tahfiz.index', compact('mapel', 'max'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'id_card' => 'required',
            'nama_tahfiz' => 'required',
            'mapel_id' => 'required',
            'kode' => 'required|string|unique:tahfiz|min:2|max:3',
            'jk' => 'required'
        ]);

        if ($request->foto == true) {
            $foto = $request->foto;
            $new_foto = date('s' . 'i' . 'H' . 'd' . 'm' . 'Y') . "_" . $foto->getClientOriginalName();
            Tahfiz::create([
                'id_card' => $request->id_card,
                'nip' => $request->nip,
                'nama_tahfiz' => $request->nama_tahfiz,
                'mapel_id' => $request->mapel_id,
                'kode' => $request->kode,
                'jk' => $request->jk,
                'telp' => $request->telp,
                'tmp_lahir' => $request->tmp_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'foto' => 'uploads/tahfiz/' . $new_foto
            ]);
            $foto->move('uploads/tahfiz/', $new_foto);
        } else {
            if ($request->jk == 'L') {
                $foto = 'uploads/tahfiz/35251431012020_male.jpg';
            } else {
                $foto = 'uploads/tahfiz/23171022042020_female.jpg';
            }
            Tahfiz::create([
                'id_card' => $request->id_card,
                'nip' => $request->nip,
                'nama_tahfiz' => $request->nama_tahfiz,
                'mapel_id' => $request->mapel_id,
                'kode' => $request->kode,
                'jk' => $request->jk,
                'telp' => $request->telp,
                'tmp_lahir' => $request->tmp_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'foto' => $foto
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil menambahkan data tahfiz baru!');
    }

    public function ubah_foto($id)
    {
        $id = Crypt::decrypt($id);
        $tahfiz = Tahfiz::findorfail($id);
        return view('admin.tahfiz.ubah-foto', compact('tahfiz'));
    }

    public function update_foto(Request $request, $id)
    {
        $this->validate($request, [
            'foto' => 'required'
        ]);

        $tahfiz = Tahfiz::findorfail($id);
        $foto = $request->foto;
        $new_foto = date('s' . 'i' . 'H' . 'd' . 'm' . 'Y') . "_" . $foto->getClientOriginalName();
        $tahfiz_data = [
            'foto' => 'uploads/tahfiz/' . $new_foto,
        ];
        $foto->move('uploads/tahfiz/', $new_foto);
        $tahfiz->update($tahfiz_data);

        return redirect()->route('tahfiz.index')->with('success', 'Berhasil merubah foto!');
    }

    public function mapel($id)
    {
        $id = Crypt::decrypt($id);
        $mapel = Mapel::findorfail($id);
        $tahfiz = Tahfiz::where('mapel_id', $id)->orderBy('kode', 'asc')->get();
        return view('admin.tahfiz.show', compact('mapel', 'tahfiz'));
    }

    public function deleteAll()
    {
        $tahfiz = Tahfiz::all();
        if ($tahfiz->count() >= 1) {
            Tahfiz::whereNotNull('id')->delete();
            Tahfiz::withTrashed()->whereNotNull('id')->forceDelete();
            return redirect()->back()->with('success', 'Data table tahfiz berhasil dihapus!');
        } else {
            return redirect()->back()->with('warning', 'Data table tahfiz kosong!');
        }
    }
}
