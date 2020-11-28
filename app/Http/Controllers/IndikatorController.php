<?php

namespace App\Http\Controllers;

use App\Guru;
use App\Indikator;
use App\Kelas;
use App\Nilai;
use App\NilaiIndikator;
use App\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class IndikatorController extends Controller
{
    public function index()
    {
        $guru = Guru::where('id_card', Auth::user()->id_card)->first();
        $indikators = Indikator::where('guru_id', $guru->id)->get();
        return view('guru.indikator.indikator', compact('guru', 'indikators'));
    }


    public function store(Request $request)
    {
        Indikator::updateOrCreate(
            [ 'id' => $request->id ],
            [
                'guru_id' => $request->guru_id,
                'tipe' => ($request->tipe),
                'indikator' => $request->indikator,
            ]
        );
        return redirect()->back()->with('success', 'Success!');
    }


    public function show($encryption)
    {
        $decrypt = Crypt::decrypt($encryption);
        $id = $decrypt['id'];
        $tipe = $decrypt['tipe'];
        $guru = Guru::where('id_card', Auth::user()->id_card)->first();
        $indikators = Indikator::where([
            [ 'guru_id', '=', $guru->id ],
            [ 'tipe', '=', $tipe ]
        ])->get();

        $indikator_tipe = ($tipe) ? "Keterampilan" : "Pengetahuan";

        if (count($indikators) < 1) {
            return redirect()->back()->with('warning', 'Anda belum memiliki Indikator '.$indikator_tipe);
        }

        $kelas = Kelas::findOrFail($id);
        $siswa = Siswa::where('kelas_id', $id)->get();
        return view('guru.indikator.nilai', compact('guru', 'indikators', 'kelas', 'siswa'));
    }


    public function destroy($id)
    {
        $indikator = Indikator::findOrFail($id);
        $indikator->delete();
        return redirect()->back()->with('success', 'Indikator di hapus!');
    }

    private function input($data)
    {
        try {
            $id = null;
            $existing = NilaiIndikator::where([
                ['indikator_id', '=', $data['indikator_id']],
                ['siswa_id', '=', $data['siswa_id']],
            ])
                ->get()
                ->first();
            if ($existing) {
                $id = $existing->id;
            }
            NilaiIndikator::updateOrCreate(
                [ 'id' => $id ],
                [
                    'siswa_id' => $data['siswa_id'],
                    'indikator_id' => $data['indikator_id'],
                    'nilai_indikator' => $data['nilai_indikator'],
                ]
            );
            return true;
        } catch (\Exception $err) {
            return false;
        }
    }

    public function input_nilai(Request $request)
    {
        $data = [
            'siswa_id' => $request['siswa_id'],
            'indikator_id' => $request['indikator_id'],
            'nilai_indikator' => $request['nilai_indikator'],
        ];
        if ($this->input($data)) {
            return redirect()->back()->with('success', 'Nilai tersimpan!');
        } else {
            return redirect()->back()->with('error', 'Error 404');
        }
    }

    public function bulk_input_nilai(Request $request)
    {
        $items = $request['items'];
        $success = [];
        foreach ($items as $key => $item) {
            if ($this->input($item)) {
                array_push($success, 'true');
            } else {
                array_push($success, 'false');
            }
        }
        if (array_unique($success) === array('true')) {
            return response()->json([
                'message' => 'Data nilai tersimpan!',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Error 404',
            ], 500);
        }
    }
}
