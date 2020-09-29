<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jenjang;
use DataTables;

class JenjangController extends Controller
{
    function json(){
        return DataTables::of(Jenjang::all())
        ->addColumn('action', function ($row) {
            $action  = '<a href="/jenjang/'.$row->kode_jenjang.'/edit" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>';
            $action .= \Form::open(['url'=>'jenjang/'.$row->kode_jenjang,'method'=>'delete','style'=>'float:right']);
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
        return view('jenjang.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jenjang.create');
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
            'kode_jenjang' => 'required|min:4',
            'nama_jenjang' => 'required|min:6'
        ]);


        $jenjang = New Jenjang();
        $jenjang->create($request->all());
        return redirect('/jenjang')->with('status','Data jenjang Berhasil Disimpan');
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
    public function edit($kode_jenjang)
    {
        $data['jenjang'] = jenjang::where('kode_jenjang',$kode_jenjang)->first();
        return view('jenjang.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $kode_jenjang)
    {
        $request->validate([
            'nama_jenjang' => 'required|min:6'
        ]);


        $jenjang = jenjang::where('kode_jenjang','=',$kode_jenjang);
        $jenjang->update($request->except('_method','_token'));
        return redirect('/jenjang')->with('status','Data jenjang Berhasil Di Update');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($kode_jenjang)
    {
        $jenjang = jenjang::where('kode_jenjang',$kode_jenjang);
        $jenjang->delete();
        return redirect('/jenjang')->with('status','Data jenjang Berhasil Dihapus');;
    }
}
