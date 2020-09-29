<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use DataTables;
use App\Jenjang;
use App\Guru;
use Auth;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    function json(){
        $guru = \DB::table('guru')
                ->join('jenjang','jenjang.kode_jenjang','=','guru.kode_jenjang')
                ->get();

        return DataTables::of($guru)
        ->addColumn('action', function ($row) {
            $action  = '<a href="/guru/'.$row->nign.'/edit" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>';
            $action .= \Form::open(['url'=>'guru/'.$row->nidn,'method'=>'delete','style'=>'float:right']);
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
        $data['jenjang'] = Jenjang::pluck('nama_jenjang','kode_jenjang');
        return view('guru.index_update',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['jenjang'] = Jenjang::pluck('nama_jenjang','kode_jenjang');
        return view('guru.create',$data);
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
            'nign' => 'required|min:5',
            'nama_guru' => 'required|min:6',
            'email'     =>'required',
            'no_hp'     =>'required'
        ]);


        $guru = New guru();
        $guru->nidn            = $request->nign;
        $guru->kode_guru       = $request->kode_guru;
        $guru->nama_guru       = $request->nama_guru;
        $guru->no_hp           = $request->no_hp;
        $guru->email           = $request->email;
        $guru->kode_jenjang    = $request->kode_jenjang;
        $guru->password        = Hash::make($request->password);
        $guru->save();
        return redirect('/guru')->with('status','Data Guru Berhasil Disimpan');
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
    public function edit($nign)
    {
        $data['jenjang'] = Jenjang::pluck('nama_jenjang','kode_jenjang');
        $data['guru'] = guru::where('nidn',$nign)->first();
        return view('guru.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nign)
    {
        $request->validate([
            'nama_guru' => 'required|min:4',
            'email'     =>'required',
            'no_hp'     =>'required'
        ]);


        $guru = guru::where('nidn',$nign)->first();
        $guru->nign        = $request->nign;
        $guru->kode_guru  = $request->kode_guru;
        $guru->nama_guru        = $request->nama_guru;
        $guru->no_hp       = $request->no_hp;
        $guru->kode_jenjang  = $request->kode_jenjang;
        $guru->email       = $request->email;
        if($request->password!='')
        {
            $guru->password    = Hash::make($request->password);
        }
        $guru->update();
        return redirect('/guru')->with('status','Data Guru Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($nign)
    {
        $guru = guru::where('nidn',$nign);
        $guru->delete();
        return redirect('/guru')->with('status','Data guru Berhasil Dihapus');;
    }


    function jadwal_mengajar(){
        return view('guru.jadwal_mengajar');
    }

    function jadwal_mengajar_json(){
        $jadwal = \DB::table('jadwal_kuliah')
                ->join('ruangan','ruangan.kode_ruangan','=','jadwal_kuliah.kode_ruangan')
                ->join('matakuliah','matakuliah.kode_mk','=','jadwal_kuliah.kode_mk')
                ->join('jam_kuliah','jam_kuliah.id','=','jadwal_kuliah.jam')
                ->join('kelas','kelas.kode_kelas','=','jadwal_kuliah.kode_kelas')
                ->where('jadwal_kuliah.kode_guru',Auth::guard('guru')->user()->kode_guru);

        return Datatables::of($jadwal)
        ->addColumn('action', function ($row) {
            $action  = '<a href="/nilai/'.$row->id.'" class="btn btn-primary btn-sm"><i class="fas fa-address-book"></i> Nilai</a> ';
            $action  .= '<a href="/kehadiran/'.$row->id.'" class="btn btn-primary btn-sm"><i class="fas fa-address-book"></i> Kehadiran</a>';
            //$action .= \Form::open(['url'=>'guru/'.$row->nidn,'method'=>'delete','style'=>'float:right']);
            //$action .= "<button type='submit'class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i></button>";
            return $action;
        })
        ->make(true);
    }
}
