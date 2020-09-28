<?php

namespace App\Http\Controllers;
use DataTables;

use App\Guru;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    function json(){
        return DataTables::of(guru::all())->addColumn('action', function ($row){
            $action  = '<a href="/guru/'.$row->kode_mp.'/edit" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>';
            $action .= \Form::open(['url'=>'guru/'.$row->kode_mp,'method'=>'delete','style'=>'float:right']);
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
        return view('guru.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('guru.create');
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
            'kode_mp' => 'required|min:4',
            'nama_mp' => 'required',
            'jml_jam'     =>'required'
        ]);

        $guru= New guru();
        $guru->create($request->all());
        return redirect('/guru')->with('status','Data Mata Pelajaran Berhasil Disimpan');
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
    public function edit($id)
    {
        $data['guru'] = guru::where('kode_mp',$id)->first();
        return view('guru.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $kode_mp)
    {
        $request->validate([
            'kode_mp' => 'required|min:4',
            'nama_mp' => 'required',
            'jml_jam'     =>'required'
        ]);

        $guru = guru::where('kode_mp',$kode_mp);
        $guru ->update($request->except('_method','_token'));
        return redirect('/guru')->with('status','Data Mata Pelajaran Berhasil Dirubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($kode_mp)
    {
        $guru = guru::where('kode_mp',$kode_mp);
        $guru->delete();
        return redirect('/guru')->with('status','Data Mata Pelajaran Berhasil Dihapus');
    }
}
