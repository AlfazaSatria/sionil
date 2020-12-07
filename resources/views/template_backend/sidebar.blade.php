<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
        <img src="{{ asset('img/logosionil.PNG') }}" alt="AdminLTE Logo" class="brand-image ">
        <span class="brand-text font-weight-light">SIONIL</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @if (Auth::user()->role == 'Admin' || Auth::user()->role == 'Operator')
                <li class="nav-item has-treeview" id="liDashboard">
                    <a href="#" class="nav-link" id="Dashboard">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-4">
                        <li class="nav-item">
                            <a href="{{ url('/') }}" class="nav-link" id="Home">
                                <i class="fas fa-home nav-icon"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.home') }}" class="nav-link" id="AdminHome">
                                <i class="fas fa-home nav-icon"></i>
                                <p>Dashboard Admin</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview" id="liMasterData">
                    <a href="#" class="nav-link" id="MasterData">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Master Data
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-4">
                        <li class="nav-item">
                            <a href="{{ route('jadwal.index') }}" class="nav-link" id="DataJadwal">
                                <i class="fas fa-calendar-alt nav-icon"></i>
                                <p>Data Jadwal Guru</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('jadwalTahfiz.index') }}" class="nav-link" id="DataJadwalTahfiz">
                                <i class="fas fa-calendar-alt nav-icon"></i>
                                <p>Data Jadwal Tahfiz</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('guru.index') }}" class="nav-link" id="DataGuru">
                                <i class="fas fa-users nav-icon"></i>
                                <p>Data Guru</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('tahfiz.index') }}" class="nav-link" id="DataTahfiz">
                                <i class="fas fa-users nav-icon"></i>
                                <p>Data Tahfiz</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('kelas.index') }}" class="nav-link" id="DataKelas">
                                <i class="fas fa-home nav-icon"></i>
                                <p>Data Kelas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('siswa.index') }}" class="nav-link" id="DataSiswa">
                                <i class="fas fa-users nav-icon"></i>
                                <p>Data Siswa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('mapel.index') }}" class="nav-link" id="DataMapel">
                                <i class="fas fa-book nav-icon"></i>
                                <p>Data Mapel</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.index') }}" class="nav-link" id="DataUser">
                                <i class="fas fa-user-plus nav-icon"></i>
                                <p>Data User</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @if (Auth::user()->role == "Admin")
                <li class="nav-item has-treeview" id="liViewTrash">
                    <a href="#" class="nav-link" id="ViewTrash">
                        <i class="nav-icon fas fa-recycle"></i>
                        <p>
                            View Trash
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-4">
                        <li class="nav-item">
                            <a href="{{ route('jadwal.trash') }}" class="nav-link" id="TrashJadwal">
                                <i class="fas fa-calendar-alt nav-icon"></i>
                                <p>Trash Jadwal</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('guru.trash') }}" class="nav-link" id="TrashGuru">
                                <i class="fas fa-users nav-icon"></i>
                                <p>Trash Guru</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('kelas.trash') }}" class="nav-link" id="TrashKelas">
                                <i class="fas fa-home nav-icon"></i>
                                <p>Trash Kelas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('siswa.trash') }}" class="nav-link" id="TrashSiswa">
                                <i class="fas fa-users nav-icon"></i>
                                <p>Trash Siswa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('mapel.trash') }}" class="nav-link" id="TrashMapel">
                                <i class="fas fa-book nav-icon"></i>
                                <p>Trash Mapel</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.trash') }}" class="nav-link" id="TrashUser">
                                <i class="fas fa-user nav-icon"></i>
                                <p>Trash User</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @else
                @endif
                <li class="nav-item">
                    <a href="{{ route('admin.pengumuman') }}" class="nav-link" id="Pengumuman">
                        <i class="nav-icon fas fa-clipboard"></i>
                        <p>Pengumuman</p>
                    </a>
                </li>
                @elseif (Auth::user()->role == 'Guru' && Auth::user()->guru(Auth::user()->id_card) == true)
                <li class="nav-item has-treeview">
                    <a href="{{ url('/') }}" class="nav-link" id="Home">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                        <a href="{{ route('jadwal.guru') }}" class="nav-link" id="JadwalGuru">
                            <i class="fas fa-calendar-alt nav-icon"></i>
                            <p>Jadwal</p>
                        </a>
                    </li>
                <li class="nav-item">
                        <a href="{{ route('guru.index-indikator') }}" class="nav-link" id="IndikatorGuru">
                            <i class="fas fa-info-circle nav-icon"></i>
                            <p>Indikator</p>
                        </a>
                    </li>
                <li class="nav-item has-treeview" id="liNilaiGuru">
                    <a href="#" class="nav-link" id="NilaiGuru">
                        <i class="nav-icon fas fa-file-signature"></i>
                        <p>
                            Penilaian
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-4">
                        <li class="nav-item">
                            <a href="{{ route('guru.index-nilai') }}" class="nav-link" id="DesGuru">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>Deskripsi Predikat</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('guru.index-ulangan') }}" class="nav-link" id="UlanganGuru">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>Entry Nilai Siswa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('guru.index-rapot') }}" class="nav-link" id="RapotGuru">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>Rekapitulasi Nilai</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                
                <?php
                    $guru = Auth::user()->guru(Auth::user()->id_card);
                ?>
                @if(Auth::user()->role == "Guru" && $guru && $guru->walikelas != null)
                <li class="nav-item has-treeview" id="liNilaiRapotGuru">
                    <a href="#" class="nav-link" id="NilaiRapotGuru">
                        <i class="nav-icon fas fa-file-signature"></i>
                        <p>
                            Nilai Rapot
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-4">
                        <li class="nav-item">
                            <a href="{{ route('guru.ekstrakulikuler-rapot') }}" class="nav-link" id="EkstrakulikulerGuru">
                                <i class="fas fa-swimmer nav-icon"></i>
                                <p>Ekstrakulikuler</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('guru.health-rapot') }}" class="nav-link" id="HealthGuru">
                                <i class="fas fa-file-medical nav-icon"></i>
                                <p>Health Condition</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('guru.achievement-rapot') }}" class="nav-link" id="AchievementGuru">
                                <i class="fas fa-trophy nav-icon"></i>
                                <p>Achievement</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('guru.attendance-rapot') }}" class="nav-link" id="AttendanceGuru">
                                <i class="fas fa-tasks nav-icon"></i>
                                <p>Attendance</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('guru.pyhsic-rapot') }}" class="nav-link" id="PyhsicGuru">
                                <i class="fas fa-tasks nav-icon"></i>
                                <p>Pyhsical Appearance</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('guru.remark-rapot') }}" class="nav-link" id="RemarkGuru">
                                <i class="fas fa-tasks nav-icon"></i>
                                <p>Teacher's Remark</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                @if (Auth::user()->role == 'Tahfiz' && Auth::user()->tahfiz(Auth::user()->id_cardTahfiz) == true)
                <li class="nav-item has-treeview">
                    <a href="{{ url('/') }}" class="nav-link" id="Home">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                        <a href="{{ route('jadwalTahfiz.tahfiz') }}" class="nav-link" id="JadwalTahfiz">
                            <i class="fas fa-calendar-alt nav-icon"></i>
                            <p>Jadwal</p>
                        </a>
                    </li>
                <li class="nav-item">
                        <a href="{{ route('tahfiz.index-indikator') }}" class="nav-link" id="IndikatorTahfiz">
                            <i class="fas fa-info-circle nav-icon"></i>
                            <p>Indikator</p>
                        </a>
                    </li>
                <li class="nav-item has-treeview" id="liNilaiTahfiz">
                    <a href="#" class="nav-link" id="NilaiTahfiz">
                        <i class="nav-icon fas fa-file-signature"></i>
                        <p>
                            Nilai
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-4">
                        <li class="nav-item">
                            <a href="{{ route('tahfiz.index-data') }}" class="nav-link" id="NilaiTahfiz">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>Entry Nilai Siswa</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview ml-4">
                        <li class="nav-item">
                            <a href="{{ route('tahfiz.index-rapot') }}" class="nav-link" id="RapotTahfiz">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>Entry Nilai Rapot</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview ml-4">
                        <li class="nav-item">
                            <a href="{{ route('cetak.rapot') }}">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>Cetak</p>
                            </a>
                        </li>
                    </ul>
                </li>

                @elseif (Auth::user()->role == 'Siswa' && Auth::user()->siswa(Auth::user()->no_induk) == true)
                <li class="nav-item has-treeview">
                    <a href="{{ url('/') }}" class="nav-link" id="Home">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('jadwal.siswa') }}" class="nav-link" id="JadwalSiswa">
                        <i class="fas fa-calendar-alt nav-icon"></i>
                        <p>Jadwal</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ulangan.siswa') }}" class="nav-link" id="UlanganSiswa">
                        <i class="fas fa-file-alt nav-icon"></i>
                        <p>Ulangan</p>
                    </a>
                </li>
{{--                <li class="nav-item">--}}
{{--                    <a href="{{ route('sikap.siswa') }}" class="nav-link" id="SikapSiswa">--}}
{{--                        <i class="fas fa-file-alt nav-icon"></i>--}}
{{--                        <p>Sikap</p>--}}
{{--                    </a>--}}
{{--                </li>--}}
                <li class="nav-item has-treeview" id="liNilaiRapotSiswa">
                    <a href="#" class="nav-link" id="NilaiRapotSiswa">
                        <i class="nav-icon fas fa-print"></i>
                        <p>
                            Cetak Rapot
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ml-4">
                        <li class="nav-item">
                            <a href="{{ route('rapot.siswa', Crypt::encrypt(0)) }}" class="nav-link" id="RapotSiswaUTS">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>Tengah Semester</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('rapot.siswa', Crypt::encrypt(1)) }}" class="nav-link" id="RapotSiswaUAS">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>Akhir Semester</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @elseif (Auth::user()->role == 'Kepsek')
                <li class="nav-item">
                    <a href="{{ route('kepsek.home') }}" class="nav-link" id="KepsekHome">
                        <i class="fas fa-home nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('kepsek.pengumuman') }}" class="nav-link" id="KepsekPengumuman">
                        <i class="fas fa-home nav-icon"></i>
                        <p>Pengumuman</p>
                    </a>
                </li>

                {{-- @elseif (Auth::user()->role == 'BimbinganKonseling')
                <li class="nav-item">
                    <a href="{{ route('bk.index') }}" class="nav-link" id="BkHome">
                        <i class="fas fa-home nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('bk.index') }}" class="nav-link" id="Bkindex">
                        <i class="fas fa-home nav-icon"></i>
                        <p>Input Affective</p>
                    </a>
                </li> --}}
                @endif
                
                
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>