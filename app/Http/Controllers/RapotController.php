<?php

namespace App\Http\Controllers;

use App\Achievement;
use App\Affective;
use App\Term;
use App\Indikator;
use App\NilaiIndikator;
use App\Ulangan;
use App\Ekstrakulikuler;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Nilai;
use App\Attendance;
use App\DescriptionAffective;
use Illuminate\Support\Facades\DB;
use App\Health;
use App\Guru;
use App\Siswa;
use App\Kelas;
use App\Pyhsic;
use App\Mapel;
use Dompdf\Dompdf;
use App\Remark;
use App\Jadwal;
use App\Rapot;
use Hamcrest\Description;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;


class RapotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guru = Guru::where('id_card', Auth::user()->id_card)->first();
        $kelas = DB::table('kelas')
            ->select('kelas.id', 'kelas.nama_kelas', 'kelas.guru_id')
            ->join('jadwal', 'kelas.id', '=', 'jadwal.kelas_id')
            ->join('mapel', 'jadwal.mapel_id', '=', 'mapel.id')
            ->where([
                ['mapel.id', '=', $guru->mapel->id]
            ])->get();

        return view('guru.rapot.kelas', compact('kelas', 'guru'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        return view('admin.rapot.home', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $guru = Guru::findorfail($request->guru_id);
            $cekJadwal = Jadwal::where('guru_id', $guru->id)->where('kelas_id', $request->kelas_id)->count();
            if ($cekJadwal >= 1) {
                Rapot::updateOrCreate(
                    [
                        'id' => $request->id
                    ],
                    [
                        'siswa_id' => $request->siswa_id,
                        'kelas_id' => $request->kelas_id,
                        'guru_id' => $request->guru_id,
                        'mapel_id' => $guru->mapel_id,
                        'p_nilai' => $request->p_nilai,
                        'p_predikat' => $request->p_predikat,
                        'p_deskripsi' => $request->p_deskripsi,
                        'k_nilai' => $request->k_nilai,
                        'k_predikat' => $request->k_predikat,
                        'k_deskripsi' => $request->k_deskripsi,
                        'tipe_rapot' => $request->tipe_rapot,
                    ]
                );
                return response()->json([
                    'message' => 'Data nilai rapot tersimpan!',
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Maaf guru ini tidak mengajar kelas ini!',
                ], 500);
            }
        } catch (\Exception $err) {
            return response()->json([
                'message' => 'Error 500',
            ], 500);
        }
    }


    private function get_indikator_avg($guru_id, $siswa_id, $tipe_indikator, $nama_kelas)
    {
        
        $indikators = Indikator::where([
            ['guru_id', '=', $guru_id],
            ['nama_kelas', '=', $nama_kelas],
            ['tipe', '=', $tipe_indikator]
        ])->get();
        $scores = [];
        foreach ($indikators as $indikator) {
            $nilai = NilaiIndikator::where([
                ['siswa_id', '=', $siswa_id],
                ['indikator_id', '=', $indikator->id],
            ])->get()->first();
            array_push($scores, $nilai->nilai_indikator);
        }
        return array_sum($scores) / count($scores);
    }

    private function get_predikat($guru_id, $score)
    {
        $nilai = Nilai::where([
            ['guru_id', '=', $guru_id],
        ])->get()->first();
        if ($score > 90) {
            return ['predikat' => 'A', 'deskripsi' => $nilai->deskripsi_a];
        }
        if ($score > 80) {
            return ['predikat' => 'B', 'deskripsi' => $nilai->deskripsi_b];
        }
        if ($score > 60) {
            return ['predikat' => 'C', 'deskripsi' => $nilai->deskripsi_c];
        }
        if ($score < 60) {
            return ['predikat' => 'D', 'deskripsi' => $nilai->deskripsi_d];
        }
    }

    public function show($items)
    {
        $items = Crypt::decrypt($items);
        $id = $items['id'];
        $tipe = $items['tipe'];
        $guru = Guru::where('id_card', Auth::user()->id_card)->get()->first();
        $mapel = $guru->mapel;
        $kelas = Kelas::where('id', $id)->get()->first();
        $data_siswa = Siswa::where('kelas_id', $id)->get();
        $tipe_ulangan = Ulangan::select('tipe_uts', 'tipe_uas')->where('kelas_id', $kelas->id)->get()->first();

        $indikators = Indikator::where('nama_kelas', $kelas->nama_kelas)->get();
        $siswa = [];
        $tipe_uts = $tipe_ulangan->tipe_uts;
        $tipe_uas = $tipe_ulangan->tipe_uas;
        if ($tipe == 'uts') {
            foreach ($data_siswa as $item) {
                $nilai_ketrampilan=NULL;
                $nilai_pengetahuan=NULL;
                $predikat_keterampilan=NULL;
                $predikat_pengetahuan=NULL;
                foreach ($indikators as $indikator) {
                    $nilai_keterampilan = ($tipe_uts == 1) ?
                        ($item->nilai_ulangan($guru->mapel_id)->uts + $this->get_indikator_avg($guru->id, $item->id, 1, $indikator->nama_kelas)) / 2 :
                        $this->get_indikator_avg($guru->id, $item->id, 1, $indikator->nama_kelas);
                    $nilai_pengetahuan = ($tipe_uts == 0) ?
                        ($item->nilai_ulangan($guru->mapel_id)->uts + $this->get_indikator_avg($guru->id, $item->id, 0, $indikator->nama_kelas)) / 2 :
                        $this->get_indikator_avg($guru->id, $item->id, 0, $indikator->nama_kelas);
                    $predikat_keterampilan = $this->get_predikat($guru->id, $nilai_keterampilan);
                    $predikat_pengetahuan = $this->get_predikat($guru->id, $nilai_pengetahuan);   
                }
                $data = [
                    'id' => $item->id,
                    'nama' => $item->nama_siswa,
                    'pengetahuan' => [
                        'nilai' => (int) $nilai_pengetahuan,
                        'predikat' => $predikat_pengetahuan['predikat'],
                        'deskripsi' => $predikat_pengetahuan['deskripsi'],
                    ],
                    'keterampilan' => [
                        'nilai' => (int) $nilai_keterampilan,
                        'predikat' => $predikat_keterampilan['predikat'],
                        'deskripsi' => $predikat_keterampilan['deskripsi'],
                    ],
                ];
                array_push($siswa, $data);
            }
        } else {
            foreach ($data_siswa as $item) {
                $nilai_ketrampilan=NULL;
                $nilai_pengetahuan=NULL;
                $predikat_keterampilan=NULL;
                $predikat_pengetahuan=NULL;
                foreach ($indikators as $indikator) {
                    $nilai_keterampilan = ($tipe_uas == 1) ?
                        ($item->nilai_ulangan($guru->mapel_id)->uas + $this->get_indikator_avg($guru->id, $item->id, 1, $indikator->nama_kelas)) / 2 :
                        $this->get_indikator_avg($guru->id, $item->id, 1, $indikator->nama_kelas);
                    $nilai_pengetahuan = ($tipe_uas == 0) ?
                        ($item->nilai_ulangan($guru->mapel_id)->uas + $this->get_indikator_avg($guru->id, $item->id, 0, $indikator->nama_kelas)) / 2 :
                        $this->get_indikator_avg($guru->id, $item->id, 0, $indikator->nama_kelas);
                    $predikat_keterampilan = $this->get_predikat($guru->id, $nilai_keterampilan);
                    $predikat_pengetahuan = $this->get_predikat($guru->id, $nilai_pengetahuan);
                    
                }
                $data = [
                    'id' => $item->id,
                    'nama' => $item->nama_siswa,
                    'pengetahuan' => [
                        'nilai' => (int) $nilai_pengetahuan,
                        'predikat' => $predikat_pengetahuan['predikat'],
                        'deskripsi' => $predikat_pengetahuan['deskripsi'],
                    ],
                    'keterampilan' => [
                        'nilai' => (int) $nilai_keterampilan,
                        'predikat' => $predikat_keterampilan['predikat'],
                        'deskripsi' => $predikat_keterampilan['deskripsi'],
                    ],
                ];
                array_push($siswa, $data);
            }
        }

        return view('guru.rapot.rapot', compact('tipe', 'guru', 'mapel', 'kelas', 'siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $kelas = Kelas::findorfail($id);
        $siswa = Siswa::orderBy('nama_siswa')->where('kelas_id', $id)->get();
        return view('admin.rapot.index', compact('kelas', 'siswa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function rapot($id)
    {
        $id = Crypt::decrypt($id);
        $siswa = Siswa::findorfail($id);
        $kelas = Kelas::findorfail($siswa->kelas_id);
        $jadwal = Jadwal::orderBy('mapel_id')->where('kelas_id', $kelas->id)->get();
        $mapel = $jadwal->groupBy('mapel_id');
        return view('admin.rapot.show', compact('mapel', 'siswa', 'kelas'));
    }

    public function predikat(Request $request)
    {
        $nilai = Nilai::where('guru_id', $request->id)->first();
        if ($request->nilai > 90) {
            $newForm[] = array(
                'predikat' => 'A',
                'deskripsi' => $nilai->deskripsi_a,
            );
        } else if ($request->nilai > 80) {
            $newForm[] = array(
                'predikat' => 'B',
                'deskripsi' => $nilai->deskripsi_b,
            );
        } else if ($request->nilai > 60) {
            $newForm[] = array(
                'predikat' => 'C',
                'deskripsi' => $nilai->deskripsi_c,
            );
        } else {
            $newForm[] = array(
                'predikat' => 'D',
                'deskripsi' => $nilai->deskripsi_d,
            );
        }
        return response()->json($newForm);
    }

    public function siswa($items)
    {
        $items = Crypt::decrypt($items);
        $tipe = $items['tipe'];
        $aksi = $items['aksi'];
        $siswa = Siswa::where('no_induk', Auth::user()->no_induk)->first();
        $kelas = Kelas::findorfail($siswa->kelas_id);
        $walikelas = Guru::where('walikelas', $kelas->nama_kelas)->get()->first();

        $rapot_a = DB::table('rapot')
            ->select(
                'rapot.id',
                'rapot.tipe_rapot',
                'rapot.p_nilai',
                'rapot.p_predikat',
                'rapot.p_deskripsi',
                'rapot.k_nilai',
                'rapot.k_predikat',
                'rapot.k_deskripsi',
                'mapel.nama_mapel'
            )
            ->join('mapel', 'mapel.id', '=', 'rapot.mapel_id')
            ->where([
                'mapel.kelompok' => 'A',
                'rapot.siswa_id' => $siswa->id,
                'rapot.tipe_rapot' => $tipe,
            ])
            ->get();

        $rapot_b = DB::table('rapot')
            ->select(
                'rapot.id',
                'rapot.tipe_rapot',
                'rapot.p_nilai',
                'rapot.p_predikat',
                'rapot.p_deskripsi',
                'rapot.k_nilai',
                'rapot.k_predikat',
                'rapot.k_deskripsi',
                'mapel.nama_mapel'
            )
            ->join('mapel', 'mapel.id', '=', 'rapot.mapel_id')
            ->where([
                'mapel.kelompok' => 'B',
                'rapot.siswa_id' => $siswa->id,
                'rapot.tipe_rapot' => $tipe,
            ])
            ->get();

        $rapot_c = DB::table('rapot')
            ->select(
                'rapot.id',
                'rapot.tipe_rapot',
                'rapot.p_nilai',
                'rapot.p_predikat',
                'rapot.p_deskripsi',
                'rapot.k_nilai',
                'rapot.k_predikat',
                'rapot.k_deskripsi',
                'mapel.nama_mapel'
            )
            ->join('mapel', 'mapel.id', '=', 'rapot.mapel_id')
            ->where([
                'mapel.kelompok' => 'C',
                'rapot.siswa_id' => $siswa->id,
                'rapot.tipe_rapot' => $tipe,
            ])
            ->get();

        $rapot_f = DB::table('rapot')
            ->select(
                'rapot.id',
                'rapot.tipe_rapot',
                'rapot.p_nilai',
                'rapot.p_predikat',
                'rapot.p_deskripsi',
                'rapot.k_nilai',
                'rapot.k_predikat',
                'rapot.k_deskripsi',
                'mapel.nama_mapel'
            )
            ->join('mapel', 'mapel.id', '=', 'rapot.mapel_id')
            ->where([
                'mapel.kelompok' => 'F',
                'rapot.siswa_id' => $siswa->id,
                'rapot.tipe_rapot' => $tipe,
            ])
            ->get();


        $nilai_a_p = [];
        $nilai_a_k = [];
        foreach ($rapot_a as $item) {
            array_push($nilai_a_p, $item->p_nilai);
            array_push($nilai_a_k, $item->k_nilai);
        }

        $nilai_b_p = [];
        $nilai_b_k = [];
        foreach ($rapot_b as $item) {
            array_push($nilai_b_p, $item->p_nilai);
            array_push($nilai_b_k, $item->k_nilai);
        }

        $nilai_c_p = [];
        $nilai_c_k = [];
        foreach ($rapot_c as $item) {
            array_push($nilai_c_p, $item->p_nilai);
            array_push($nilai_c_k, $item->k_nilai);
        }

        $nilai_f_p = [];
        $nilai_f_k = [];
        foreach ($rapot_f as $item) {
            array_push($nilai_f_p, $item->p_nilai);
            array_push($nilai_f_k, $item->k_nilai);
        }

        $total_a_p = array_sum($nilai_a_p);
        $total_a_k = array_sum($nilai_a_k);
        $total_b_p = array_sum($nilai_b_p);
        $total_b_k = array_sum($nilai_b_k);

        $total_a_b_p = $total_a_p + $total_b_p;
        $avg_a_b_p  = $total_a_b_p / (count($rapot_a) + count($rapot_b));
        $total_a_b_k = $total_a_k + $total_b_k;
        $avg_a_b_k  = $total_a_b_k / (count($rapot_a) + count($rapot_b));

        $total_c_p = array_sum($nilai_c_p);
        $avg_c_p = $total_c_p / count($rapot_c);
        $total_c_k = array_sum($nilai_c_k);
        $avg_c_k = $total_c_k / count($rapot_c);

        $total_f_p = array_sum($nilai_f_p);
        $avg_f_p = $total_f_p / count($rapot_f);
        $total_f_k = array_sum($nilai_f_k);
        $avg_f_k = $total_f_k / count($rapot_f);

        $affective = Affective::where([
            'siswa_id' => $siswa->id,
        ])->get()->first();

        $extracurricular = Ekstrakulikuler::where([
            'siswa_id' => $siswa->id,
        ])->get();

        $remark = Remark::where([
            'siswa_id' => $siswa->id,
        ])->get()->first();

        $physical = Pyhsic::where([
            'siswa_id' => $siswa->id,
        ])->get()->first();

        $health = Health::where([
            'siswa_id' => $siswa->id,
        ])->get();

        $achievement = Achievement::where([
            'siswa_id' => $siswa->id,
        ])->get();

        $paramid = 1;
        $term = Term::where('id', $paramid)->first();


        $param = 1;
        $deskripsi = DescriptionAffective::where('id', $param)->first();


        $attendance = Attendance::where([
            'siswa_id' => $siswa->id,
        ])->get()->first();

        if ($aksi == 0) {
            return view('siswa.rapot', compact(
                'guru',
                'kelas',
                'siswa',
                'rapot_a',
                'rapot_b',
                'rapot_c',
                'total_a_p',
                'total_a_k',
                'total_b_p',
                'total_b_k',
                'total_c_p',
                'total_c_k',
                'affective',
                'extracurricular',
                'remark',
                'physical',
                'health',
                'achievement',
                'attendance'
            ));
        }

        if (
            count($rapot_a) > 0 && count($rapot_b) > 0 && count($rapot_c) > 0 && count($rapot_f) > 0 &&
            count($extracurricular) > 0 && $affective && $remark && $attendance
        ) {



            $h = "<!DOCTYPE html>";
            $h .= "<html>";
            $h .= "<body>";
            $h .= "<h2 style='margin-bottom: 0;text-align: center;'>STUDENT'S LEARNING REPORT</h2>";
            $h .= "<h3 style='margin-top: 2px;text-align: center;'>SMP Mumtaza Islamic School</h3>";
            $h .= "<table style='width: 100%;border-collapse: collapse;font-size: 14px;'>";
            $h .= "    <tr style='padding: 0; margin: 0'>";
            $h .= "        <td style='border:1px solid black;border-right:none;text-align: left;padding: 4px;' width='75'>Student's Name</td>";
            $h .= "        <td style='border:1px solid black;border-right:none;border-left:none;text-align: center;padding: 4px;' width='5'>:</td>";
            $h .= "        <td style='border:1px solid black;border-left:none;text-align: left;padding: 4px;'>" . $siswa->nama_siswa . "</td>";
            $h .= "        <td style='border:1px solid black;border-right:none;;text-align: left;padding: 4px;' width='100'>Class</td>";
            $h .= "        <td style='border:1px solid black;border-right:none;border-left:none;text-align: center;padding: 4px;' width='5'>:</td>";
            $h .= "        <td style='border:1px solid black;border-left:none;text-align: left;padding: 4px;'>" . $kelas->nama_kelas . "</td>";
            $h .= "    </tr>";
            $h .= "    <tr style='padding: 0;margin: 0'>";
            $h .= "        <td style='border:1px solid black;border-right:none;text-align: left;padding: 4px;' width='75' rowspan='2'>Teacher's Name</td>";
            $h .= "        <td style='border:1px solid black;border-right:none;border-left:none;text-align: center;padding: 4px;' rowspan='2'>:</td>";
            $h .= "        <td style='border:1px solid black;border-left:none;text-align: left;padding: 4px;' rowspan='2'>" . $walikelas->nama_guru . "</td>";
            $h .= "        <td style='border:1px solid black;border-right:none;text-align: left;padding: 4px;' width='100'>Term/Semester</td>";
            $h .= "        <td style='border:1px solid black;border-right:none;border-left:none;text-align: center;padding: 4px;' width='5'>:</td>";
            $h .= "        <td style='border:1px solid black;border-left:none;text-align: left;padding: 4px;'>" . $term->term . "/" . $term->semester . "</td>";
            $h .= "    </tr>";
            $h .= "    <tr style='padding: 0; margin: 0'>";
            $h .= "        <td style='border:1px solid black;border-right:none;text-align: left;padding: 4px;' width='100'>Delivered On</td>";
            $h .= "        <td style='border:1px solid black;border-right:none;border-left:none;text-align: center;padding: 4px;' width='5'>:</td>";
            $h .= "        <td style='border:1px solid black;border-left:none;text-align: left;padding: 4px;'>" . $term->delivered_on . "</td>";
            $h .= "    </tr>";
            $h .= "</table>";

            $h .= "<h3 style='margin-top:15px; margin-bottom: 0; padding: 3px'>A. Affective</h3>";
            $h .= "<table style='border:1px solid black; width: 100%; border-collapse: collapse; font-size: 14px;'>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' colspan='2'>Description</th>";
            $h .= "    </tr>";
            if ($affective->spiritual == 'A') {
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: left;padding: 4px; border: 1px solid black;' width='175'>1. Spiritual Attitude</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'><b>" . $siswa->nama_siswa . "</b>, " . $deskripsi->deskripsi_a_sp . "</td>";
                $h .= "    </tr>";
            } elseif ($affective->spiritual == 'B') {
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: left;padding: 4px; border: 1px solid black;' width='175'>1. Spiritual Attitude</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'><b>" . $siswa->nama_siswa . "</b>, " . $deskripsi->deskripsi_b_sp . "</td>";
                $h .= "    </tr>";
            } elseif ($affective->spiritual == 'C') {
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: left;padding: 4px; border: 1px solid black;' width='175'>1. Spiritual Attitude</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'><b>" . $siswa->nama_siswa . "</b>, " . $deskripsi->deskripsi_c_sp . "</td>";
                $h .= "    </tr>";
            } else {
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: left;padding: 4px; border: 1px solid black;' width='175'>1. Spiritual Attitude</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'><b>" . $siswa->nama_siswa . "</b>, " . $deskripsi->deskripsi_d_sp . "</td>";
                $h .= "    </tr>";
            }
            if ($affective->social == 'A') {
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: left;padding: 4px; border: 1px solid black;' width='175'>2. Social Attitude</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'><b>" . $siswa->nama_siswa . "</b>, " . $deskripsi->deskripsi_a_so . "</td>";
                $h .= "    </tr>";
            } elseif ($affective->social == 'B') {
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: left;padding: 4px; border: 1px solid black;' width='175'>2. Social Attitude</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'><b>" . $siswa->nama_siswa . "</b>, " . $deskripsi->deskripsi_b_so . "</td>";
                $h .= "    </tr>";
            } elseif ($affective->social == 'C') {
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: left;padding: 4px; border: 1px solid black;' width='175'>2. Social Attitude</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'><b>" . $siswa->nama_siswa . "</b>, " . $deskripsi->deskripsi_c_so . "</td>";
                $h .= "    </tr>";
            } else {
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: left;padding: 4px; border: 1px solid black;' width='175'>2. Social Attitude</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'><b>" . $siswa->nama_siswa . "</b>, " . $deskripsi->deskripsi_d_so . "</td>";
                $h .= "    </tr>";
            }

            $h .= "</table>";

            $h .= "<h3 style='margin-top:18px; margin-bottom: 0; padding: 3px'>B. Cognitive & Psychomotor</h3>";
            $h .= "<table style='border:1px solid black; width: 100%; border-collapse: collapse; font-size: 14px;'>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' rowspan='2' colspan='2'>Subject</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' colspan='3'>Cognitive</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' colspan='3'>Psychomotor</th>";
            $h .= "    </tr>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>N</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>P</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>Deskripsi</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>N</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>P</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>Deskripsi</th>";
            $h .= "    </tr>";
            foreach ($rapot_a as $key => $item) {
                $index = $key + 1;
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='30'>" . $index . ".</th>";
                $h .= "        <th style='text-align: left;padding: 4px; border: 1px solid black;'>" . $item->nama_mapel . "</th>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->p_nilai . "</td>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->p_predikat . "</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>" . $item->p_deskripsi . "</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->k_nilai . "</td>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->k_predikat . "</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>" . $item->k_deskripsi . "</td>";
                $h .= "    </tr>";
            }
            $last_count = count($rapot_a) + 1;
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='30'>" . $last_count . ".</th>";
            $h .= "        <th style='text-align: left;padding: 4px; border: 1px solid black;'>Thematic Learning</th>";
            $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'></td>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'></th>";
            $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'></td>";
            $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'></td>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'></th>";
            $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'></td>";
            $h .= "    </tr>";
            foreach ($rapot_b as $key => $item) {
                $index = $key + 1;
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='30'></th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>(" . $index . ".) " . $item->nama_mapel . "</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->p_nilai . "</td>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->p_predikat . "</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>" . $item->p_deskripsi . "</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->k_nilai . "</td>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->k_predikat . "</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>" . $item->k_deskripsi . "</td>";
                $h .= "    </tr>";
            }
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'>Total Score</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>" . $total_a_b_p . "</th>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'></th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>" . $total_a_b_k . "</th>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'></th>";
            $h .= "    </tr>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'>Average</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>" . $avg_a_b_p . "</th>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'></th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>" . $avg_a_b_k . "</th>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'></th>";
            $h .= "    </tr>";
            $last_count = count($rapot_a) + count($rapot_b) + 1;
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='30'>" . $last_count . ".</th>";
            $h .= "        <th style='text-align: left;padding: 4px; border: 1px solid black;'>Islamic Studies</th>";
            $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'></td>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'></th>";
            $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'></td>";
            $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'></td>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'></th>";
            $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'></td>";
            $h .= "    </tr>";
            foreach ($rapot_c as $key => $item) {
                $index = $key + 1;
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='30'></th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>(" . $index . ".) " . $item->nama_mapel . "</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->p_nilai . "</td>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->p_predikat . "</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>" . $item->p_deskripsi . "</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->k_nilai . "</td>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->k_predikat . "</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>" . $item->k_deskripsi . "</td>";
                $h .= "    </tr>";
            }
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'>Total Score</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>" . $total_c_p . "</th>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'></th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>" . $total_c_k . "</th>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'></th>";
            $h .= "    </tr>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'>Average</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>" . $avg_c_p . "</th>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'></th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>" . $avg_c_k . "</th>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'></th>";
            $h .= "    </tr>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='30'>" . $last_count . ".</th>";
            $h .= "        <th style='text-align: left;padding: 4px; border: 1px solid black;'>Local Content</th>";
            $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'></td>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'></th>";
            $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'></td>";
            $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'></td>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'></th>";
            $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'></td>";
            $h .= "    </tr>";
            foreach ($rapot_f as $key => $item) {
                $index = $key + 1;
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='30'></th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>(" . $index . ".) " . $item->nama_mapel . "</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->p_nilai . "</td>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->p_predikat . "</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>" . $item->p_deskripsi . "</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->k_nilai . "</td>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->k_predikat . "</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>" . $item->k_deskripsi . "</td>";
                $h .= "    </tr>";
            }
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'>Total Score</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>" . $total_f_p . "</th>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'></th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>" . $total_f_k . "</th>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'></th>";
            $h .= "    </tr>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'>Average</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>" . $avg_f_p . "</th>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'></th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>" . $avg_f_k . "</th>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'></th>";
            $h .= "    </tr>";
            $h .= "</table>";

            $h .= "<h3 style='margin-top:18px; margin-bottom: 0; padding: 3px'>C. Extra Curricular</h3>";
            $h .= "<table style='border:1px solid black; width: 100%; border-collapse: collapse; font-size: 14px;'>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='30'>No.</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>Extra Curricular Activity</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='70'>Score</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>Description</th>";
            $h .= "    </tr>";
            foreach ($extracurricular as $key => $item) {
                $index = $key + 1;
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='30'>" . $index . ".</td>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>$item->mapel_name</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='70'>$item->score</td>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>$item->description</td>";
                $h .= "    </tr>";
            }
            $h .= "</table>";

            $h .= "<h3 style='margin-top:18px; margin-bottom: 0; padding: 3px'>D. Teacher Remarks</h3>";
            $h .= "<table style='border:1px solid black; width: 100%; border-collapse: collapse; font-size: 14px;'>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <td style='text-align: left;padding: 12px 8px 12px 8px; border: 1px solid black;'>" . $remark->note . "</td>";
            $h .= "    </tr>";
            $h .= "</table>";

            $h .= "<h3 style='margin-top:18px; margin-bottom: 0; padding: 3px'>E. Physical Appearance</h3>";
            $h .= "<table style='border:1px solid black; width: 100%; border-collapse: collapse; font-size: 14px;'>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='30' rowspan='2'>No.</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' rowspan='2' width='270'>Rated Aspect</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' colspan='2'>Semester</th>";
            $h .= "    </tr>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>1</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>2</th>";
            $h .= "    </tr>";
            if ($physical) {
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>1.</th>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'>Height</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'>$physical->height_sem1</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'>$physical->height_sem2</td>";
                $h .= "    </tr>";
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>2.</th>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'>Weight</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'>$physical->weight_sem1</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'>$physical->weight_sem2</td>";
                $h .= "    </tr>";
            } else {
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>1.</th>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'>Height</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'>&nbsp;&nbsp;</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'>&nbsp;&nbsp;</td>";
                $h .= "    </tr>";
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>2.</th>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'>Weight</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'>&nbsp;&nbsp;</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'>&nbsp;&nbsp;</td>";
                $h .= "    </tr>";
            }
            $h .= "</table>";

            if (count($health) > 0) {
                $h .= "<h3 style='margin-top:18px; margin-bottom: 0; padding: 3px'>F. Health Condition</h3>";
                $h .= "<table style='border:1px solid black; width: 100%; border-collapse: collapse; font-size: 14px;'>";
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='30'>No.</th>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>Physical Aspect</th>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>Description</th>";
                $h .= "    </tr>";
                foreach ($health as $key => $item) {
                    $index = $key + 1;
                    $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                    $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='30'>" . $index . ".</td>";
                    $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>$item->name</td>";
                    $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>$item->description</td>";
                    $h .= "    </tr>";
                }
                $h .= "</table>";
            } else {
                $h .= "<h3 style='margin-top:18px; margin-bottom: 0; padding: 3px'>F. Health Condition</h3>";
                $h .= "<table style='border:1px solid black; width: 100%; border-collapse: collapse; font-size: 14px;'>";
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='30'>No.</th>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>Physical Aspect</th>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>Description</th>";
                $h .= "    </tr>";

                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='30'></td>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>&nbsp;&nbsp;</td>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>&nbsp;&nbsp;</td>";
                $h .= "    </tr>";

                $h .= "</table>";
            }

            if (count($achievement) > 0) {
                $h .= "<h3 style='margin-top:18px; margin-bottom: 0; padding: 3px'>G. Achievement</h3>";
                $h .= "<table style='border:1px solid black; width: 100%; border-collapse: collapse; font-size: 14px;'>";
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='30'>No.</th>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>Kind of Achievement</th>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>Description</th>";
                $h .= "    </tr>";
                foreach ($achievement as $key => $item) {
                    $index = $key + 1;
                    $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                    $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='30'>" . $index . ".</td>";
                    $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>$item->name</td>";
                    $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>$item->description</td>";
                    $h .= "    </tr>";
                }
                $h .= "</table>";
            } else {
                $h .= "<h3 style='margin-top:18px; margin-bottom: 0; padding: 3px'>G. Achievement</h3>";
                $h .= "<table style='border:1px solid black; width: 100%; border-collapse: collapse; font-size: 14px;'>";
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='30'>No.</th>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>Kind of Achievement</th>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>Description</th>";
                $h .= "    </tr>";

                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='30'></td>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>&nbsp;&nbsp;</td>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>&nbsp;&nbsp;</td>";
                $h .= "    </tr>";

                $h .= "</table>";
            }

            $h .= "<table style='margin-top: 18px; border:1px solid black; width: 30%; border-collapse: collapse; font-size: 14px;'>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' colspan='3'>Attendance</th>";
            $h .= "    </tr>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <td style='text-align: left;padding: 4px 5px 2px 6px;'>Sick</td>";
            $h .= "        <td style='text-align: center;padding: 2px 5px 2px 0;'>:</td>";
            $h .= "        <td style='text-align: left;padding: 2px 5px 2px 0;'>" . $attendance->sick . " Day(s)</td>";
            $h .= "    </tr>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <td style='text-align: left;padding: 2px 5px 2px 6px;'>Permission</td>";
            $h .= "        <td style='text-align: center;padding: 2px 5px 2px 0;'>:</td>";
            $h .= "        <td style='text-align: left;padding: 2px 5px 2px 0;'>" . $attendance->permission . " Day(s)</td>";
            $h .= "    </tr>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <td style='text-align: left;padding: 2px 5px 2px 6px;'>Absent</td>";
            $h .= "        <td style='text-align: center;padding: 2px 5px 2px 0;'>:</td>";
            $h .= "        <td style='text-align: left;padding: 2px 5px 2px 0;'>" . $attendance->absent . " Day(s)</td>";
            $h .= "    </tr>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <td style='text-align: left;padding: 2px 5px 4px 6px;'>Late</td>";
            $h .= "        <td style='text-align: center;padding: 2px 5px 4px 0;'>:</td>";
            $h .= "        <td style='text-align: left;padding: 2px 5px 4px 0;'>" . $attendance->late . " Day(s)</td>";
            $h .= "    </tr>";
            $h .= "</table>";

            $h .= "<p style='margin-top:20px;margin-bottom: 0;padding: 3px;font-size: 14px'>Acknowleged by</p>";
            $h .= "<table style='width: 100%; font-size: 14px;'>";
            $h .= "    <tr style='padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: center;margin:0 4px 0 4px;padding: 4px;' width='25%'>1st Teacher</th>";
            $h .= "        <th style='text-align: center;margin:0 4px 0 4px;padding: 4px;' width='25%'>2nd Teacher</th>";
            $h .= "        <th style='text-align: center;margin:0 4px 0 4px;padding: 4px;' width='25%'>Parent</th>";
            $h .= "        <th style='text-align: center;margin:0 4px 0 4px;padding: 4px;' width='25%'>Principal</th>";
            $h .= "    </tr>";
            $h .= "    <tr style='padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: center;margin:0 4px 0 4px;padding: 4px;' width='25%'>";
            $h .= "           <div style='width: 100%;height: 72px'></div>";
            $h .= "        </th>";
            $h .= "        <th style='text-align: center;margin:0 4px 0 4px;padding: 4px;' width='25%'>";
            $h .= "           <div style='width: 100%;height: 72px'></div>";
            $h .= "        </th>";
            $h .= "        <th style='text-align: center;margin:0 4px 0 4px;padding: 4px;' width='25%'>";
            $h .= "           <div style='width: 100%;height: 72px'></div>";
            $h .= "        </th>";
            $h .= "        <th style='text-align: center;margin:0 4px 0 4px;padding: 4px;' width='25%'>";
            $h .= "           <div style='width: 100%;height: 72px'></div>";
            $h .= "        </th>";
            $h .= "    </tr>";
            $h .= "    <tr style='padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: center;margin:0 4px 0 4px;padding: 4px;' width='25%'>";
            $h .= "           " . $walikelas->nama_guru . "";
            $h .= "           <div style='width: 90%;margin: auto;border-bottom: 1px dashed black'></div>";
            $h .= "        </th>";
            $h .= "        <th style='text-align: center;margin:0 4px 0 4px;padding: 4px;' width='25%'>";
            $h .= "           &nbsp;";
            $h .= "           <div style='width: 90%;margin: auto;border-bottom: 1px dashed black'></div>";
            $h .= "        </th>";
            $h .= "        <th style='text-align: center;margin:0 4px 0 4px;padding: 4px;' width='25%'>";
            $h .= "           &nbsp;";
            $h .= "           <div style='width: 90%;margin: auto;border-bottom: 1px dashed black'></div>";
            $h .= "        </th>";
            $h .= "        <th style='text-align: center;margin:0 4px 0 4px;padding: 4px;' width='25%'>";
            $h .= "           Ibnu Mulyana, M.Pd";
            $h .= "           <div style='width: 90%;margin: auto;border-bottom: 1px dashed black'></div>";
            $h .= "        </th>";
            $h .= "    </tr>";
            $h .= "</table>";

            $h .= "</body>";
            $h .= "</html>";

            $pdf = new Dompdf();
            $pdf->loadHtml($h);
            $pdf->set_option('isRemoteEnabled', true);
            $pdf->setPaper('A4', 'portrait');
            $pdf->render();
            $pdf->stream("ReportCard_" . $siswa->nama_siswa . ".pdf", array("Attachment" => false));
        } else {
            return redirect()->back()->with('warning', 'Rapor belum tersedia!');
        }
    }

    public function dataRapot(Request $request)
    {
        $user = $request->user();
        $guru = Guru::firstWhere('walikelas', $user->walikelas);
        $kelas = Kelas::firstWhere('nama_kelas', $guru->walikelas);
        $siswa = Siswa::where('kelas_id', $kelas->id)->get();

        return view('guru.rapot.datarapot', compact('user', 'guru', 'kelas', 'siswa'));
    }

    public function guru($encryption)
    {
        $decrypt = Crypt::decrypt($encryption);
        $id = $decrypt['id'];
        $tipe = $decrypt['tipe_rapot'];
        $siswa = Siswa::where('id', $id)->first();
        $guru = Guru::where('id_card', Auth::user()->id_card)->first();
        $kelas = Kelas::findorfail($guru->id);
        $walikelas = Guru::where('walikelas', $kelas->nama_kelas)->get()->first();

        $rapot_a = DB::table('rapot')
            ->select(
                'rapot.id',
                'rapot.tipe_rapot',
                'rapot.p_nilai',
                'rapot.p_predikat',
                'rapot.p_deskripsi',
                'rapot.k_nilai',
                'rapot.k_predikat',
                'rapot.k_deskripsi',
                'mapel.nama_mapel'
            )
            ->join('mapel', 'mapel.id', '=', 'rapot.mapel_id')
            ->where([
                'mapel.kelompok' => 'A',
                'rapot.siswa_id' => $siswa->id,
                'rapot.tipe_rapot' => $tipe,
            ])
            ->get();

        $rapot_b = DB::table('rapot')
            ->select(
                'rapot.id',
                'rapot.tipe_rapot',
                'rapot.p_nilai',
                'rapot.p_predikat',
                'rapot.p_deskripsi',
                'rapot.k_nilai',
                'rapot.k_predikat',
                'rapot.k_deskripsi',
                'mapel.nama_mapel'
            )
            ->join('mapel', 'mapel.id', '=', 'rapot.mapel_id')
            ->where([
                'mapel.kelompok' => 'B',
                'rapot.siswa_id' => $siswa->id,
                'rapot.tipe_rapot' => $tipe,
            ])
            ->get();


        $rapot_c = DB::table('rapot')
            ->select(
                'rapot.id',
                'rapot.tipe_rapot',
                'rapot.p_nilai',
                'rapot.p_predikat',
                'rapot.p_deskripsi',
                'rapot.k_nilai',
                'rapot.k_predikat',
                'rapot.k_deskripsi',
                'mapel.nama_mapel'
            )
            ->join('mapel', 'mapel.id', '=', 'rapot.mapel_id')
            ->where([
                'mapel.kelompok' => 'C',
                'rapot.siswa_id' => $siswa->id,
                'rapot.tipe_rapot' => $tipe,
            ])
            ->get();

        $rapot_f = DB::table('rapot')
            ->select(
                'rapot.id',
                'rapot.tipe_rapot',
                'rapot.p_nilai',
                'rapot.p_predikat',
                'rapot.p_deskripsi',
                'rapot.k_nilai',
                'rapot.k_predikat',
                'rapot.k_deskripsi',
                'mapel.nama_mapel'
            )
            ->join('mapel', 'mapel.id', '=', 'rapot.mapel_id')
            ->where([
                'mapel.kelompok' => 'F',
                'rapot.siswa_id' => $siswa->id,
                'rapot.tipe_rapot' => $tipe,
            ])
            ->get();


        $nilai_a_p = [];
        $nilai_a_k = [];
        foreach ($rapot_a as $item) {
            array_push($nilai_a_p, $item->p_nilai);
            array_push($nilai_a_k, $item->k_nilai);
        }

        $nilai_b_p = [];
        $nilai_b_k = [];
        foreach ($rapot_b as $item) {
            array_push($nilai_b_p, $item->p_nilai);
            array_push($nilai_b_k, $item->k_nilai);
        }

        $nilai_c_p = [];
        $nilai_c_k = [];
        foreach ($rapot_c as $item) {
            array_push($nilai_c_p, $item->p_nilai);
            array_push($nilai_c_k, $item->k_nilai);
        }

        $nilai_f_p = [];
        $nilai_f_k = [];
        foreach ($rapot_f as $item) {
            array_push($nilai_f_p, $item->p_nilai);
            array_push($nilai_f_k, $item->k_nilai);
        }

        $total_a_p = array_sum($nilai_a_p);
        $total_a_k = array_sum($nilai_a_k);
        $total_b_p = array_sum($nilai_b_p);
        $total_b_k = array_sum($nilai_b_k);

        $total_a_b_p = $total_a_p + $total_b_p;
        $avg_a_b_p  = $total_a_b_p / (count($rapot_a) + count($rapot_b));
        $total_a_b_k = $total_a_k + $total_b_k;
        $avg_a_b_k  = $total_a_b_k / (count($rapot_a) + count($rapot_b));

        $total_c_p = array_sum($nilai_c_p);
        $avg_c_p = $total_c_p / count($rapot_c);
        $total_c_k = array_sum($nilai_c_k);
        $avg_c_k = $total_c_k / count($rapot_c);

        $total_f_p = array_sum($nilai_f_p);
        $avg_f_p = $total_f_p / count($rapot_f);
        $total_f_k = array_sum($nilai_f_k);
        $avg_f_k = $total_f_k / count($rapot_f);

        $affective = Affective::where([
            'siswa_id' => $siswa->id,
        ])->get()->first();

        $extracurricular = Ekstrakulikuler::where([
            'siswa_id' => $siswa->id,
        ])->get();

        $remark = Remark::where([
            'siswa_id' => $siswa->id,
        ])->get()->first();

        $physical = Pyhsic::where([
            'siswa_id' => $siswa->id,
        ])->get()->first();

        $health = Health::where([
            'siswa_id' => $siswa->id,
        ])->get();

        $achievement = Achievement::where([
            'siswa_id' => $siswa->id,
        ])->get();

        $attendance = Attendance::where([
            'siswa_id' => $siswa->id,
        ])->get()->first();

        $paramid = 1;
        $term = Term::where('id', $paramid)->first();


        $param = 1;
        $deskripsi = DescriptionAffective::where('id', $param)->first();

        if (
            count($rapot_a) > 0 && count($rapot_b) > 0 && count($rapot_c) > 0 && count($rapot_f) > 0 &&
            count($extracurricular) > 0 && $affective && $remark && $attendance
        ) {





            $h = "<!DOCTYPE html>";
            $h .= "<html>";
            $h .= "<body>";
            $h .= "<h2 style='margin-bottom: 0;text-align: center;'>STUDENT'S LEARNING REPORT</h2>";
            $h .= "<h3 style='margin-top: 2px;text-align: center;'>SMP Mumtaza Islamic School</h3>";
            $h .= "<table style='width: 100%;border-collapse: collapse;font-size: 14px;'>";
            $h .= "    <tr style='padding: 0; margin: 0'>";
            $h .= "        <td style='border:1px solid black;border-right:none;text-align: left;padding: 4px;' width='75'>Student's Name</td>";
            $h .= "        <td style='border:1px solid black;border-right:none;border-left:none;text-align: center;padding: 4px;' width='5'>:</td>";
            $h .= "        <td style='border:1px solid black;border-left:none;text-align: left;padding: 4px;'>" . $siswa->nama_siswa . "</td>";
            $h .= "        <td style='border:1px solid black;border-right:none;;text-align: left;padding: 4px;' width='100'>Class</td>";
            $h .= "        <td style='border:1px solid black;border-right:none;border-left:none;text-align: center;padding: 4px;' width='5'>:</td>";
            $h .= "        <td style='border:1px solid black;border-left:none;text-align: left;padding: 4px;'>" . $kelas->nama_kelas . "</td>";
            $h .= "    </tr>";
            $h .= "    <tr style='padding: 0;margin: 0'>";
            $h .= "        <td style='border:1px solid black;border-right:none;text-align: left;padding: 4px;' width='75' rowspan='2'>Teacher's Name</td>";
            $h .= "        <td style='border:1px solid black;border-right:none;border-left:none;text-align: center;padding: 4px;' rowspan='2'>:</td>";
            $h .= "        <td style='border:1px solid black;border-left:none;text-align: left;padding: 4px;' rowspan='2'>" . $walikelas->nama_guru . "</td>";
            $h .= "        <td style='border:1px solid black;border-right:none;text-align: left;padding: 4px;' width='100'>Term/Semester</td>";
            $h .= "        <td style='border:1px solid black;border-right:none;border-left:none;text-align: center;padding: 4px;' width='5'>:</td>";
            $h .= "        <td style='border:1px solid black;border-left:none;text-align: left;padding: 4px;'>" . $term->term . "/" . $term->semester . "</td>";
            $h .= "    </tr>";
            $h .= "    <tr style='padding: 0; margin: 0'>";
            $h .= "        <td style='border:1px solid black;border-right:none;text-align: left;padding: 4px;' width='100'>Delivered On</td>";
            $h .= "        <td style='border:1px solid black;border-right:none;border-left:none;text-align: center;padding: 4px;' width='5'>:</td>";
            $h .= "        <td style='border:1px solid black;border-left:none;text-align: left;padding: 4px;'>" . $term->delivered_on . "</td>";
            $h .= "    </tr>";
            $h .= "</table>";

            $h .= "<h3 style='margin-top:15px; margin-bottom: 0; padding: 3px'>A. Affective</h3>";
            $h .= "<table style='border:1px solid black; width: 100%; border-collapse: collapse; font-size: 14px;'>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' colspan='2'>Description</th>";
            $h .= "    </tr>";
            if ($affective->spiritual == 'A') {
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: left;padding: 4px; border: 1px solid black;' width='175'>1. Spiritual Attitude</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'><b>" . $siswa->nama_siswa . "</b>, " . $deskripsi->deskripsi_a_sp . "</td>";
                $h .= "    </tr>";
            } elseif ($affective->spiritual == 'B') {
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: left;padding: 4px; border: 1px solid black;' width='175'>1. Spiritual Attitude</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'><b>" . $siswa->nama_siswa . "</b>, " . $deskripsi->deskripsi_b_sp . "</td>";
                $h .= "    </tr>";
            } elseif ($affective->spiritual == 'C') {
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: left;padding: 4px; border: 1px solid black;' width='175'>1. Spiritual Attitude</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'><b>" . $siswa->nama_siswa . "</b>, " . $deskripsi->deskripsi_c_sp . "</td>";
                $h .= "    </tr>";
            } else {
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: left;padding: 4px; border: 1px solid black;' width='175'>1. Spiritual Attitude</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'><b>" . $siswa->nama_siswa . "</b>, " . $deskripsi->deskripsi_d_sp . "</td>";
                $h .= "    </tr>";
            }
            if ($affective->social == 'A') {
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: left;padding: 4px; border: 1px solid black;' width='175'>2. Social Attitude</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'><b>" . $siswa->nama_siswa . "</b>, " . $deskripsi->deskripsi_a_so . "</td>";
                $h .= "    </tr>";
            } elseif ($affective->social == 'B') {
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: left;padding: 4px; border: 1px solid black;' width='175'>2. Social Attitude</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'><b>" . $siswa->nama_siswa . "</b>, " . $deskripsi->deskripsi_b_so . "</td>";
                $h .= "    </tr>";
            } elseif ($affective->social == 'C') {
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: left;padding: 4px; border: 1px solid black;' width='175'>2. Social Attitude</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'><b>" . $siswa->nama_siswa . "</b>, " . $deskripsi->deskripsi_c_so . "</td>";
                $h .= "    </tr>";
            } else {
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: left;padding: 4px; border: 1px solid black;' width='175'>2. Social Attitude</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'><b>" . $siswa->nama_siswa . "</b>, " . $deskripsi->deskripsi_d_so . "</td>";
                $h .= "    </tr>";
            }

            $h .= "</table>";

            $h .= "<h3 style='margin-top:18px; margin-bottom: 0; padding: 3px'>B. Cognitive & Psychomotor</h3>";
            $h .= "<table style='border:1px solid black; width: 100%; border-collapse: collapse; font-size: 14px;'>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' rowspan='2' colspan='2'>Subject</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' colspan='3'>Cognitive</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' colspan='3'>Psychomotor</th>";
            $h .= "    </tr>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>N</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>P</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>Deskripsi</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>N</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>P</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>Deskripsi</th>";
            $h .= "    </tr>";
            foreach ($rapot_a as $key => $item) {
                $index = $key + 1;
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='30'>" . $index . ".</th>";
                $h .= "        <th style='text-align: left;padding: 4px; border: 1px solid black;'>" . $item->nama_mapel . "</th>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->p_nilai . "</td>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->p_predikat . "</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>" . $item->p_deskripsi . "</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->k_nilai . "</td>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->k_predikat . "</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>" . $item->k_deskripsi . "</td>";
                $h .= "    </tr>";
            }
            $last_count = count($rapot_a) + 1;
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='30'>" . $last_count . ".</th>";
            $h .= "        <th style='text-align: left;padding: 4px; border: 1px solid black;'>Thematic Learning</th>";
            $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'></td>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'></th>";
            $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'></td>";
            $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'></td>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'></th>";
            $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'></td>";
            $h .= "    </tr>";
            foreach ($rapot_b as $key => $item) {
                $index = $key + 1;
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='30'></th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>(" . $index . ".) " . $item->nama_mapel . "</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->p_nilai . "</td>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->p_predikat . "</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>" . $item->p_deskripsi . "</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->k_nilai . "</td>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->k_predikat . "</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>" . $item->k_deskripsi . "</td>";
                $h .= "    </tr>";
            }
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'>Total Score</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>" . $total_a_b_p . "</th>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'></th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>" . $total_a_b_k . "</th>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'></th>";
            $h .= "    </tr>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'>Average</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>" . $avg_a_b_p . "</th>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'></th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>" . $avg_a_b_k . "</th>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'></th>";
            $h .= "    </tr>";
            $last_count = count($rapot_a) + count($rapot_b) + 1;
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='30'>" . $last_count . ".</th>";
            $h .= "        <th style='text-align: left;padding: 4px; border: 1px solid black;'>Islamic Studies</th>";
            $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'></td>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'></th>";
            $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'></td>";
            $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'></td>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'></th>";
            $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'></td>";
            $h .= "    </tr>";
            foreach ($rapot_c as $key => $item) {
                $index = $key + 1;
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='30'></th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>(" . $index . ".) " . $item->nama_mapel . "</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->p_nilai . "</td>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->p_predikat . "</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>" . $item->p_deskripsi . "</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->k_nilai . "</td>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->k_predikat . "</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>" . $item->k_deskripsi . "</td>";
                $h .= "    </tr>";
            }
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'>Total Score</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>" . $total_c_p . "</th>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'></th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>" . $total_c_k . "</th>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'></th>";
            $h .= "    </tr>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'>Average</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>" . $avg_c_p . "</th>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'></th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>" . $avg_c_k . "</th>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'></th>";
            $h .= "    </tr>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='30'>" . $last_count . ".</th>";
            $h .= "        <th style='text-align: left;padding: 4px; border: 1px solid black;'>Local Content</th>";
            $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'></td>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'></th>";
            $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'></td>";
            $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'></td>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'></th>";
            $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'></td>";
            $h .= "    </tr>";
            foreach ($rapot_f as $key => $item) {
                $index = $key + 1;
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='30'></th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>(" . $index . ".) " . $item->nama_mapel . "</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->p_nilai . "</td>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->p_predikat . "</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>" . $item->p_deskripsi . "</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->k_nilai . "</td>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='40'>" . $item->k_predikat . "</th>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>" . $item->k_deskripsi . "</td>";
                $h .= "    </tr>";
            }
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'>Total Score</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>" . $total_f_p . "</th>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'></th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>" . $total_f_k . "</th>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'></th>";
            $h .= "    </tr>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'>Average</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>" . $avg_f_p . "</th>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'></th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>" . $avg_f_k . "</th>";
            $h .= "        <th style='text-align: right;padding: 4px; border: 1px solid black;' colspan='2'></th>";
            $h .= "    </tr>";
            $h .= "</table>";

            $h .= "<h3 style='margin-top:18px; margin-bottom: 0; padding: 3px'>C. Extra Curricular</h3>";
            $h .= "<table style='border:1px solid black; width: 100%; border-collapse: collapse; font-size: 14px;'>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='30'>No.</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>Extra Curricular Activity</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='70'>Score</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>Description</th>";
            $h .= "    </tr>";
            foreach ($extracurricular as $key => $item) {
                $index = $key + 1;
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='30'>" . $index . ".</td>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>$item->mapel_name</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='70'>$item->score</td>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>$item->description</td>";
                $h .= "    </tr>";
            }
            $h .= "</table>";

            $h .= "<h3 style='margin-top:18px; margin-bottom: 0; padding: 3px'>D. Teacher Remarks</h3>";
            $h .= "<table style='border:1px solid black; width: 100%; border-collapse: collapse; font-size: 14px;'>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <td style='text-align: left;padding: 12px 8px 12px 8px; border: 1px solid black;'>" . $remark->note . "</td>";
            $h .= "    </tr>";
            $h .= "</table>";

            $h .= "<h3 style='margin-top:18px; margin-bottom: 0; padding: 3px'>E. Physical Appearance</h3>";
            $h .= "<table style='border:1px solid black; width: 100%; border-collapse: collapse; font-size: 14px;'>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='30' rowspan='2'>No.</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' rowspan='2' width='270'>Rated Aspect</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' colspan='2'>Semester</th>";
            $h .= "    </tr>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>1</th>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>2</th>";
            $h .= "    </tr>";
            if ($physical) {
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>1.</th>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'>Height</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'>$physical->height_sem1</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'>$physical->height_sem2</td>";
                $h .= "    </tr>";
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>2.</th>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'>Weight</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'>$physical->weight_sem1</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'>$physical->weight_sem2</td>";
                $h .= "    </tr>";
            } else {
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>1.</th>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'>Height</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'>&nbsp;&nbsp;</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'>&nbsp;&nbsp;</td>";
                $h .= "    </tr>";
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>2.</th>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'>Weight</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'>&nbsp;&nbsp;</td>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;'>&nbsp;&nbsp;</td>";
                $h .= "    </tr>";
            }
            $h .= "</table>";

            if (count($health) > 0) {
                $h .= "<h3 style='margin-top:18px; margin-bottom: 0; padding: 3px'>F. Health Condition</h3>";
                $h .= "<table style='border:1px solid black; width: 100%; border-collapse: collapse; font-size: 14px;'>";
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='30'>No.</th>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>Physical Aspect</th>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>Description</th>";
                $h .= "    </tr>";
                foreach ($health as $key => $item) {
                    $index = $key + 1;
                    $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                    $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='30'>" . $index . ".</td>";
                    $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>$item->name</td>";
                    $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>$item->description</td>";
                    $h .= "    </tr>";
                }
                $h .= "</table>";
            } else {
                $h .= "<h3 style='margin-top:18px; margin-bottom: 0; padding: 3px'>F. Health Condition</h3>";
                $h .= "<table style='border:1px solid black; width: 100%; border-collapse: collapse; font-size: 14px;'>";
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='30'>No.</th>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>Physical Aspect</th>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>Description</th>";
                $h .= "    </tr>";

                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='30'></td>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>&nbsp;&nbsp;</td>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>&nbsp;&nbsp;</td>";
                $h .= "    </tr>";

                $h .= "</table>";
            }

            if (count($achievement) > 0) {
                $h .= "<h3 style='margin-top:18px; margin-bottom: 0; padding: 3px'>G. Achievement</h3>";
                $h .= "<table style='border:1px solid black; width: 100%; border-collapse: collapse; font-size: 14px;'>";
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='30'>No.</th>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>Kind of Achievement</th>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>Description</th>";
                $h .= "    </tr>";
                foreach ($achievement as $key => $item) {
                    $index = $key + 1;
                    $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                    $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='30'>" . $index . ".</td>";
                    $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>$item->name</td>";
                    $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>$item->description</td>";
                    $h .= "    </tr>";
                }
                $h .= "</table>";
            } else {
                $h .= "<h3 style='margin-top:18px; margin-bottom: 0; padding: 3px'>G. Achievement</h3>";
                $h .= "<table style='border:1px solid black; width: 100%; border-collapse: collapse; font-size: 14px;'>";
                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' width='30'>No.</th>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>Kind of Achievement</th>";
                $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;'>Description</th>";
                $h .= "    </tr>";

                $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
                $h .= "        <td style='text-align: center;padding: 4px; border: 1px solid black;' width='30'></td>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>&nbsp;&nbsp;</td>";
                $h .= "        <td style='text-align: left;padding: 4px; border: 1px solid black;'>&nbsp;&nbsp;</td>";
                $h .= "    </tr>";

                $h .= "</table>";
            }

            $h .= "<table style='margin-top: 18px; border:1px solid black; width: 30%; border-collapse: collapse; font-size: 14px;'>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: center;padding: 4px; border: 1px solid black;' colspan='3'>Attendance</th>";
            $h .= "    </tr>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <td style='text-align: left;padding: 4px 5px 2px 6px;'>Sick</td>";
            $h .= "        <td style='text-align: center;padding: 2px 5px 2px 0;'>:</td>";
            $h .= "        <td style='text-align: left;padding: 2px 5px 2px 0;'>" . $attendance->sick . " Day(s)</td>";
            $h .= "    </tr>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <td style='text-align: left;padding: 2px 5px 2px 6px;'>Permission</td>";
            $h .= "        <td style='text-align: center;padding: 2px 5px 2px 0;'>:</td>";
            $h .= "        <td style='text-align: left;padding: 2px 5px 2px 0;'>" . $attendance->permission . " Day(s)</td>";
            $h .= "    </tr>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <td style='text-align: left;padding: 2px 5px 2px 6px;'>Absent</td>";
            $h .= "        <td style='text-align: center;padding: 2px 5px 2px 0;'>:</td>";
            $h .= "        <td style='text-align: left;padding: 2px 5px 2px 0;'>" . $attendance->absent . " Day(s)</td>";
            $h .= "    </tr>";
            $h .= "    <tr style='border: 1px solid black; padding: 0; margin: 0'>";
            $h .= "        <td style='text-align: left;padding: 2px 5px 4px 6px;'>Late</td>";
            $h .= "        <td style='text-align: center;padding: 2px 5px 4px 0;'>:</td>";
            $h .= "        <td style='text-align: left;padding: 2px 5px 4px 0;'>" . $attendance->late . " Day(s)</td>";
            $h .= "    </tr>";
            $h .= "</table>";

            $h .= "<p style='margin-top:20px;margin-bottom: 0;padding: 3px;font-size: 14px'>Acknowleged by</p>";
            $h .= "<table style='width: 100%; font-size: 14px;'>";
            $h .= "    <tr style='padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: center;margin:0 4px 0 4px;padding: 4px;' width='25%'>1st Teacher</th>";
            $h .= "        <th style='text-align: center;margin:0 4px 0 4px;padding: 4px;' width='25%'>2nd Teacher</th>";
            $h .= "        <th style='text-align: center;margin:0 4px 0 4px;padding: 4px;' width='25%'>Parent</th>";
            $h .= "        <th style='text-align: center;margin:0 4px 0 4px;padding: 4px;' width='25%'>Principal</th>";
            $h .= "    </tr>";
            $h .= "    <tr style='padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: center;margin:0 4px 0 4px;padding: 4px;' width='25%'>";
            $h .= "           <div style='width: 100%;height: 72px'></div>";
            $h .= "        </th>";
            $h .= "        <th style='text-align: center;margin:0 4px 0 4px;padding: 4px;' width='25%'>";
            $h .= "           <div style='width: 100%;height: 72px'></div>";
            $h .= "        </th>";
            $h .= "        <th style='text-align: center;margin:0 4px 0 4px;padding: 4px;' width='25%'>";
            $h .= "           <div style='width: 100%;height: 72px'></div>";
            $h .= "        </th>";
            $h .= "        <th style='text-align: center;margin:0 4px 0 4px;padding: 4px;' width='25%'>";
            $h .= "           <div style='width: 100%;height: 72px'></div>";
            $h .= "        </th>";
            $h .= "    </tr>";
            $h .= "    <tr style='padding: 0; margin: 0'>";
            $h .= "        <th style='text-align: center;margin:0 4px 0 4px;padding: 4px;' width='25%'>";
            $h .= "           " . $walikelas->nama_guru . "";
            $h .= "           <div style='width: 90%;margin: auto;border-bottom: 1px dashed black'></div>";
            $h .= "        </th>";
            $h .= "        <th style='text-align: center;margin:0 4px 0 4px;padding: 4px;' width='25%'>";
            $h .= "           &nbsp;";
            $h .= "           <div style='width: 90%;margin: auto;border-bottom: 1px dashed black'></div>";
            $h .= "        </th>";
            $h .= "        <th style='text-align: center;margin:0 4px 0 4px;padding: 4px;' width='25%'>";
            $h .= "           &nbsp;";
            $h .= "           <div style='width: 90%;margin: auto;border-bottom: 1px dashed black'></div>";
            $h .= "        </th>";
            $h .= "        <th style='text-align: center;margin:0 4px 0 4px;padding: 4px;' width='25%'>";
            $h .= "           Ibnu Mulyana, M.Pd";
            $h .= "           <div style='width: 90%;margin: auto;border-bottom: 1px dashed black'></div>";
            $h .= "        </th>";
            $h .= "    </tr>";
            $h .= "</table>";

            $h .= "</body>";
            $h .= "</html>";

            $pdf = new Dompdf();
            $pdf->loadHtml($h);
            $pdf->set_option('isRemoteEnabled', true);
            $pdf->setPaper('A4', 'portrait');
            $pdf->render();
            $pdf->stream("ReportCard_" . $siswa->nama_siswa . ".pdf", array("Attachment" => false));
        } else {
            return redirect()->back()->with('warning', 'Rapor belum tersedia!');
        }
    }

    public function indexekstrakulikuler(Request $request)
    {
        $user = $request->user();
        $mapel = Mapel::where('kelompok', 'D')->get();
        $guru = Guru::firstWhere('walikelas', $user->walikelas);
        $kelas = Kelas::firstWhere('nama_kelas', $guru->walikelas);
        $siswa = Siswa::where('kelas_id', $kelas->id)->get();

        return view('guru.rapot.ekstrakulikuler', compact('user', 'guru', 'kelas', 'siswa', 'mapel'));
    }

    public function inputekstrakulikuler(Request $request)
    {
        $id = null;
        $existing = Ekstrakulikuler::where([
            ['mapel_id', '=', $request->mapel_id],
            ['siswa_id', '=', $request->siswa_id],
        ])
            ->get()
            ->first();

        if ($existing) {
            $id = $existing->id;
        }


        Ekstrakulikuler::updateOrCreate(
            ['id' => $id],
            [
                'siswa_id' => $request->siswa_id,
                'mapel_id' => $request->mapel_id,
                'mapel_name' => $request->mapel_name,
                'score' => $request->score,
                'description' => $request->description,


            ]
        );
        return redirect()->back()->with('success', 'Success!');
    }

    public function indexhealth(Request $request)
    {
        $user = $request->user();
        $guru = Guru::firstWhere('walikelas', $user->walikelas);
        $kelas = Kelas::firstWhere('nama_kelas', $guru->walikelas);
        $siswa = Siswa::where('kelas_id', $kelas->id)->get();

        return view('guru.rapot.health', compact('user', 'guru', 'kelas', 'siswa'));
    }

    public function input_health(Request $request)
    {
        $id = null;
        $existing = Health::where([
            ['siswa_id', '=', $request->siswa_id],
        ])
            ->get()
            ->first();

        if ($existing) {
            $id = $existing->id;
        }

        Health::updateOrCreate(
            ['id' => $id],
            [
                'siswa_id' => $request->siswa_id,
                'name' => $request->name,
                'description' => $request->description,
            ]
        );
        return redirect()->back()->with('success', 'Success!');
    }

    public function indexachievement(Request $request)
    {
        $user = $request->user();
        $guru = Guru::firstWhere('walikelas', $user->walikelas);
        $kelas = Kelas::firstWhere('nama_kelas', $guru->walikelas);
        $siswa = Siswa::where('kelas_id', $kelas->id)->get();

        return view('guru.rapot.achievement', compact('user', 'guru', 'kelas', 'siswa'));
    }

    public function input_achievement(Request $request)
    {


        Achievement::Create(
            [
                'siswa_id' => $request->siswa_id,
                'name' => $request->name,
                'description' => $request->description,
            ]
        );
        return redirect()->back()->with('success', 'Success!');
    }

    public function indexattendance(Request $request)
    {
        $user = $request->user();
        $guru = Guru::firstWhere('walikelas', $user->walikelas);
        $kelas = Kelas::firstWhere('nama_kelas', $guru->walikelas);
        $siswa = Siswa::where('kelas_id', $kelas->id)->get();

        return view('guru.rapot.attendance', compact('user', 'guru', 'kelas', 'siswa'));
    }

    public function input_attendance(Request $request)
    {
        $id = null;
        $existing = Attendance::where([
            ['siswa_id', '=', $request->siswa_id],
        ])
            ->get()
            ->first();

        if ($existing) {
            $id = $existing->id;
        }

        Attendance::updateOrCreate(
            ['id' => $id],
            [
                'siswa_id' => $request->siswa_id,
                'sick' => $request->sick,
                'permission' => $request->permission,
                'absent' => $request->absent,
                'late' => $request->late,
            ]
        );
        return redirect()->back()->with('success', 'Success!');
    }

    public function indexpyhsic(Request $request)
    {
        $user = $request->user();
        $guru = Guru::firstWhere('walikelas', $user->walikelas);
        $kelas = Kelas::firstWhere('nama_kelas', $guru->walikelas);
        $siswa = Siswa::where('kelas_id', $kelas->id)->get();

        return view('guru.rapot.pyhsic', compact('user', 'guru', 'kelas', 'siswa'));
    }

    public function input_pyhsic(Request $request)
    {
        $id = null;
        $existing = Pyhsic::where([
            ['siswa_id', '=', $request->siswa_id],
        ])
            ->get()
            ->first();

        if ($existing) {
            $id = $existing->id;
        }

        Pyhsic::updateOrCreate(
            ['id' => $id],
            [
                'siswa_id' => $request['siswa_id'],
                'height_sem1' => $request['hs1'],
                'height_sem2' => $request['hs2'],
                'weight_sem1' => $request['ws1'],
                'weight_sem2' => $request['ws2'],
            ]
        );

        return redirect()->back()->with('success', 'Success!');
    }

    public function indexremark(Request $request)
    {
        $user = $request->user();
        $guru = Guru::firstWhere('walikelas', $user->walikelas);
        $kelas = Kelas::firstWhere('nama_kelas', $guru->walikelas);
        $siswa = Siswa::where('kelas_id', $kelas->id)->get();

        return view('guru.rapot.remark', compact('user', 'guru', 'kelas', 'siswa'));
    }

    public function input_remark(Request $request)
    {
        $id = null;
        $existing = Remark::where([
            ['siswa_id', '=', $request->siswa_id],
        ])
            ->get()
            ->first();

        if ($existing) {
            $id = $existing->id;
        }

        Remark::updateOrCreate(
            ['id' => $id],
            [
                'siswa_id' => $request->siswa_id,
                'note' => $request->note
            ]
        );
        return redirect()->back()->with('success', 'Success!');
    }
}
