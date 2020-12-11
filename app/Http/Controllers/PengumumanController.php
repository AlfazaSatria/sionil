<?php

namespace App\Http\Controllers;

use App\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Term;
class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::where('opsi', 'pengumuman')->first();
        return view('admin.pengumuman', compact('pengumuman'));
    }

    public function simpan(Request $request)
    {
        $this->validate($request, [
            'isi' => 'required',
        ]);

        Pengumuman::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'isi' => $request->isi,
            ]
        );

        return redirect()->back()->with('success', 'Pengumuman berhasil di perbarui!');
    }

    public function DataTerm(){
        $term = Term::where('id', 1)->first();
        return view('admin.term',compact('term'));
    }

    public function saveTerm (Request $request){
        $this->validate($request, [
            'semester' => 'required',
            'term' => 'required',
            'kepsek' => 'required',
            'delivered_on' => 'required'
        ]);

        Term::updateOrCreate(
            [
            'id' => $request->id
            ],
            [
                'semester'=>$request->semester,
                'term' => $request->term,
                'kepsek' => $request->kepsek,
                'delivered_on' => $request->delivered_on,
            ]
        );

        return redirect()->back()->with('success', 'Pengumuman berhasil di perbarui!');
    }
}
