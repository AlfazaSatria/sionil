<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BimbinganKonseling;
class BimbinganKonselingController extends Controller
{
    public function index()
    {
        $bk = BimbinganKonseling::orderBy('name')->get();
        $max = BimbinganKonseling::max('id_card');
        return view('admin.bk.index', compact( 'max','bk'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'id_card' => 'required',
            'name' => 'required',
            'jk' => 'required',
        ]);

        if ($request->foto == true) {
            $foto = $request->foto;
            $new_foto = date('s' . 'i' . 'H' . 'd' . 'm' . 'Y') . "_" . $foto->getClientOriginalName();
            BimbinganKonseling::create([
                'id_card' => $request->id_card,
                'name' => $request->name,
                'jk' => $request->jk,
                'foto' => 'uploads/guru/' . $new_foto
            ]);
            $foto->move('uploads/guru/', $new_foto);
        } else {
            if ($request->jk == 'L') {
                $foto = 'uploads/guru/35251431012020_male.jpg';
            } else {
                $foto = 'uploads/guru/23171022042020_female.jpg';
            }
            BimbinganKonseling::create([
                'id_card' => $request->id_card,
                'name' => $request->name,
                'jk' => $request->jk,
                'foto' => $foto,
            ]);
        }

        return redirect()->back()->with('success', 'Berhasil menambahkan data Bimbingan Konseling baru!');
    }

    public function deleteAll()
    {
        $bk = BimbinganKonseling::all();
        if ($bk->count() >= 1) {
            BimbinganKonseling::whereNotNull('id')->delete();
            BimbinganKonseling::withTrashed()->whereNotNull('id')->forceDelete();
            return redirect()->back()->with('success', 'Data table bimbingan konseling berhasil dihapus!');
        } else {
            return redirect()->back()->with('warning', 'Data bimbingan konseling kosong!');
        }
    }
}
