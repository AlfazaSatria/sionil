<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Kelas;
use App\TahunAkademik;
use App\Siswa;

class SiswaController extends Controller
{
    function json(Request $request){
        $kelas = $request->get('kelas');
        if(isset($kelas))
        {
            $siswa = \DB::table('siswa')
            ->join('kelas','siswa.kode_kelas','=','kelas.kode_kelas')
            ->join('jenjang','jenjang.kode_jenjang','=','kelas.kode_jenjang')
            ->where('kelas.kode_kelas','=',$kelas)
            ->get();
        }else{
            $siswa = \DB::table('siswa')
            ->join('kelas','siswa.kode_kelas','=','kelas.kode_kelas')
            ->join('jenjang','jenjang.kode_jenjang','=','kelas.kode_jenjang')
            ->get();
        }


        return Datatables::of($siswa)
        ->addColumn('action', function ($row) {
            $action  = '<a href="/siswa/'.$row->nisn.'/edit" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>';
            $action .= \Form::open(['url'=>'siswa/'.$row->nisn,'method'=>'delete','style'=>'float:right']);
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
        $data['tahun_akademik'] = TahunAkademik::pluck('tahun_akademik','kode_tahun_akademik');
        $data['kelas']        = Kelas::pluck('nama_kelas','kode_kelas');
        return view('siswa.index_ajax',$data);
        //return view('siswa.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['tahun_akademik'] = TahunAkademik::pluck('tahun_akademik','kode_tahun_akademik');
        $data['kelas'] = Kelas::pluck('nama_kelas','kode_kelas');
        $data['semester_aktif'] = ['1'=>'Semester 1','2'=>'Semester 2','3'=>'Semester 3',
                                    '4'=>'Semester 4','5'=>'semester 5','6'=>'Semester 6','7'=>'Semester 7','8'=>'Semester 8'];
        return view('siswa.create',$data);
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
            'nisn' => 'required|unique:siswa|min:4',
            'nama_siswa' => 'required|min:6',
            'email' => 'required|min:6',
            'password' => 'required|min:6'
        ]);


        $siswa = New siswa();
        $siswa->create($request->all());
        return redirect('/siswa')->with('status','Data siswa Berhasil Disimpan');
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
    public function edit($nisn)
    {
        $data['kelas'] = Kelas::pluck('nama_kelas','kode_kelas');
        $data['siswa'] = siswa::where('nisn',$nisn)->first();
        $data['tahun_akademik'] = TahunAkademik::pluck('tahun_akademik','kode_tahun_akademik');
        $data['kelas']        = Kelas::pluck('nama_kelas','kode_kelas');
        $data['semester_aktif'] = ['1'=>'Semester 1','2'=>'Semester 2','3'=>'Semester 3',
        '4'=>'Semester 4','5'=>'semester 5','6'=>'Semester 6','7'=>'Semester 7','8'=>'Semester 8'];
        return view('siswa.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nisn)
    {
        // $request->validate([
        //     'nama_siswa' => 'required|min:6'
        // ]);


        $siswa = Siswa::where('nisn','=',$nisn)->first();
        $siswa->nama_siswa = $request->nama_siswa;
        $siswa->email = $request->email;
        $siswa->alamat = $request->alamat;
        $siswa->kode_kelas = $request->kode_kelas;
        if($request->password!='')
        {
            $siswa->password = $request->password;
        }

        $siswa->save();
        //$siswa->update($request->except('_method','_token'));
        return redirect('/siswa')->with('status','Data siswa Berhasil Di Update');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($nisn)
    {
        $siswa = siswa::where('nisn',$nisn);
        $siswa->delete();
        return redirect('/siswa')->with('status','Data siswa Berhasil Dihapus');;
    }
}
