<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jenjang;
use App\Kelas;

class KelasController extends Controller
{
    function json(){
        $kelas = \DB::table('kelas')
                    ->join('jenjang','kelas.kode_jenjang','=','jenjang.kode_jenjang')
                    ->get();

        return Datatables::of($kelas)
        ->addColumn('action', function ($row) {
            $action  = '<a href="/kelas/'.$row->kode_kelas.'/edit" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>';
            $action .= \Form::open(['url'=>'kelas/'.$row->kode_kelas,'method'=>'delete','style'=>'float:right']);
            $action .= "<button type='submit'class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i></button>";
            $action .= \Form::close();
            return $action;
        })
        ->make(true);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kelas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['jenjang'] = Jenjang::pluck('nama_jenjang','kode_jenjang');
        return view('kelas.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_kelas' => 'required|unique:kelas|min:4',
            'nama_kelas' => 'required|min:6'
        ]);


        $kelas = New kelas();
        $kelas->create($request->all());
        return redirect('/kelas')->with('status','Data kelas Berhasil Disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($kode_kelas)
    {
        $data['jenjang'] = Jenjang::pluck('nama_jenjang','kode_jenjang');
        $data['kelas'] = kelas::where('kode_kelas',$kode_kelas)->first();
        return view('kelas.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $kode_kelas)
    {
        $request->validate([
            'nama_kelas' => 'required|min:6'
        ]);


        $kelas = kelas::where('kode_kelas','=',$kode_kelas);
        $kelas->update($request->except('_method','_token'));
        return redirect('/kelas')->with('status','Data kelas Berhasil Di Update');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($kode_kelas)
    {
        $kelas = kelas::where('kode_kelas',$kode_kelas);
        $kelas->delete();
        return redirect('/kelas')->with('status','Data kelas Berhasil Dihapus');;
    }
}
