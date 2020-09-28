<?php

namespace App\Http\Controllers;
use DataTables;

use Illuminate\Http\Request;
use App\MataPelajaran;

class MataPelajaranController extends Controller
{

    function json(){
        return DataTables::of(Matapelajaran::all())->addColumn('action', function ($row){
            $action  = '<a href="/matapelajaran/'.$row->kode_mp.'/edit" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>';
            $action .= \Form::open(['url'=>'matapelajaran/'.$row->kode_mp,'method'=>'delete','style'=>'float:right']);
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
        return view('matapelajaran.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('matapelajaran.create');
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

        $matapelajaran= New Matapelajaran();
        $matapelajaran->create($request->all());
        return redirect('/matapelajaran');
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
        $data['matapelajaran'] = Matapelajaran::where('kode_mp',$id)->first();
        return view('matapelajaran.edit',$data);
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

        $matapelajaran = Matapelajaran::where('kode_mp',$kode_mp);
        $matapelajaran ->update($request->except('_method','_token'));
        return redirect('/matapelajaran');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($kode_mp)
    {
        $matapelajaran = Matapelajaran::where('kode_mp',$kode_mp);
        $matapelajaran->delete();
        return redirect('/matapelajaran');
    }
}
