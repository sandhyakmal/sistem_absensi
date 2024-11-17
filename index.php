<?php
session_start();

// Pastikan pengguna sudah login dan memiliki session usernamegit push -u origin main
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    echo "<script>
        alert('Login terlebih dahulu');
        window.location.href = 'login.php';
    </script>";
    exit;
}

date_default_timezone_set('Asia/Jakarta');


// Ambil session username
$username = $_SESSION['username'];

$current_page_url = $_SERVER['REQUEST_URI'];
$dashboard_href = "/hris/index.php?page=dashboard";

$data_karyawan_href = "/hris/index.php?page=data_karyawan";
$tambah_karyawan_href = "/hris/index.php?page=tambah_data_karyawan";
$ubah_karyawan_href = "/hris/index.php?page=ubah_data_karyawan";

$jadwal_kerja_href = "/hris/index.php?page=jadwal_kerja";
$tambah_jadwal_href = "/hris/index.php?page=tambah_jadwal_kerja";
$ubah_jadwal_href = "/hris/index.php?page=ubah_jadwal_kerja";

$approval_jadwal_kerja = "/hris/index.php?page=approval_jadwal_kerja";
$view_jadwal_kerja = "/hris/index.php?page=view_jadwal_kerja";

$absensi_in_out = "/hris/index.php?page=absen_in_out";
$absensi_sakit = "/hris/index.php?page=absen_sakit";
$absensi_cuti = "/hris/index.php?page=absen_cuti";
$ubah_absensi_in_out = "/hris/index.php?page=ubah_absensi_in_out";
$approval_absen = "/hris/index.php?page=approval_absen";
$view_absen = "/hris/index.php?page=view_absen";

$data_payroll = "/hris/index.php?page=data_payroll";
$tambah_data_payroll = "/hris/index.php?page=tambah_data_payroll";
$slip_gaji = "/hris/index.php?page=slip_gaji";

$laporan_payroll = "/hris/index.php?page=laporan_payroll";
$laporan_absensi = "/hris/index.php?page=laporan_absensi";

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>HRIS</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/awanbrew.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@9.2.1/dist/style.min.css"> -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- DataTables CSS for Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Mar 17 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="?page=dashboard" class="logo d-flex align-items-center">
                <img src="assets/img/awanbrew.png" alt="">
                <span class="d-none d-lg-block">HRIS</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->


        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->


                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <!-- <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle"> -->
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $username ?></span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?php echo $username ?></h6>
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="logout.php">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">
            <!-- Start Welcome -->
            <li class="nav-item">
                <a class="nav-link 
                <?php if ($current_page_url != $dashboard_href) {
                    echo "collapsed";
                } else {
                    echo "";
                } ?>" href="?page=dashboard">
                    <i class="bi bi-grid"></i>
                    <span>Welcome</span>
                </a>
            </li>
            <!-- End Welcome -->

            <!-- Start Data Karyawan -->
            <?php
            if ($_SESSION['role'] != 'karyawan') {
            ?>
                <li class="nav-item">
                    <a class="nav-link
                    <?php if ($current_page_url != $data_karyawan_href && $current_page_url != $tambah_karyawan_href && $current_page_url != $ubah_karyawan_href) {
                        echo "collapsed";
                    } else {
                        echo "";
                    } ?>" href="?page=data_karyawan">
                        <i class="bi bi-person"></i>
                        <span>Data Karyawan</span>
                    </a>
                </li>
            <?php
            }
            ?>
            <!-- End Data Karyawan -->

            <!-- Start Manajemen Jadwal Kerja -->
            <li class="nav-item">
                <a class="nav-link
                 <?php if ($current_page_url != $jadwal_kerja_href || $current_page_url != $tambah_jadwal_href || $current_page_url != $ubah_jadwal_href || $current_page_url != $approval_jadwal_kerja || $current_page_url != $view_jadwal_kerja) {
                        echo "collapsed";
                    } else {
                        echo "";
                    } ?>" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-calendar-day"></i><span>Manajemen Jadwal Kerja</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tables-nav" class="nav-content collapse 
                <?php if ( $current_page_url == $jadwal_kerja_href || $current_page_url == $approval_jadwal_kerja || $current_page_url == $tambah_jadwal_href || $current_page_url == $ubah_jadwal_href || $current_page_url == $view_jadwal_kerja ) {
                    echo "show";
                } ?>" data-bs-parent="#sidebar-nav">

                    <?php
                        if ($_SESSION['role'] != 'owner') {
                    ?>
                        <li>
                            <a href="?page=jadwal_kerja" class="<?php echo ($current_page_url == $jadwal_kerja_href || $current_page_url == $tambah_jadwal_href || $current_page_url == $ubah_jadwal_href ) ? 'active' : ''; ?>">
                                <i class="bi bi-circle"></i><span>Jadwal Kerja</span>
                            </a>
                        </li>
                    <?php
                        }
                    ?>

                    <?php
                        if ($_SESSION['role'] != 'karyawan' && $_SESSION['role'] != 'admin'){
                    ?>
                        <li>
                            <a href="?page=approval_jadwal_kerja" class="<?php echo ($current_page_url == $approval_jadwal_kerja || $current_page_url == $view_jadwal_kerja ) ? 'active' : ''; ?>">
                                <i class="bi bi-circle"></i><span>Approval Jadwal Kerja</span>
                            </a>
                        </li>
                    <?php
                        }
                    ?>
                </ul>
            </li>
            <!-- End Manajemen Jadwal Kerja -->

            <!-- Start Absensi -->
            <li class="nav-item">
                <a class="nav-link 
                 <?php if ($current_page_url != $absensi_in_out || $current_page_url != $absensi_sakit || $current_page_url != $absensi_cuti || $current_page_url != $ubah_absensi_in_out ||  $current_page_url != $view_absen  ) {
                        echo "collapsed";
                    } else {
                        echo "";
                    } ?>" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-clock-history"></i><span>Absensi</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-nav" class="nav-content collapse
                <?php if ( $current_page_url == $absensi_in_out || $current_page_url == $absensi_sakit || $current_page_url == $absensi_cuti || $current_page_url == $ubah_absensi_in_out || $current_page_url == $approval_absen  || $current_page_url == $view_absen )  {
                    echo "show";
                } ?>" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="?page=absen_in_out" class="<?php echo ($current_page_url == $absensi_in_out || $current_page_url == $ubah_absensi_in_out ) ? 'active' : ''; ?>">
                            <i class="bi bi-circle"></i><span>Absen In/Out</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=absen_sakit" class="<?php echo ($current_page_url == $absensi_sakit) ? 'active' : ''; ?>">
                            <i class="bi bi-circle"></i><span>Absen Sakit</span>
                        </a>
                    </li>
                    <li>
                        <a href="?page=absen_cuti" class="<?php echo ($current_page_url == $absensi_cuti) ? 'active' : ''; ?>">
                            <i class="bi bi-circle"></i><span>Absen Cuti</span>
                        </a>
                    </li>
                    <?php
                        if ($_SESSION['role'] == 'owner' ){
                    ?>
                    <li>
                        <a href="?page=approval_absen" class="<?php echo ($current_page_url == $approval_absen || $current_page_url == $view_absen) ? 'active' : ''; ?>">
                            <i class="bi bi-circle"></i><span>Approval Absen</span>
                        </a>
                    </li>
                    <?php
                        }
                    ?>
                </ul>
            </li>
            <!-- End Absensi -->

             <!-- Start Payroll -->
            <li class="nav-item">
                <a class="nav-link 
                 <?php if ($current_page_url != $data_payroll || $current_page_url != $slip_gaji   ) {
                        echo "collapsed";
                    } else {
                        echo "";
                    } ?>" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-cash-stack"></i><span>Data Payroll</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse
                <?php if ( $current_page_url == $data_payroll || $current_page_url == $tambah_data_payroll || $current_page_url == $slip_gaji )  {
                    echo "show";
                } ?>" data-bs-parent="#sidebar-nav">
                    <?php
                        if ($_SESSION['role'] == 'owner') {
                    ?>
                    <li>
                        <a href="?page=data_payroll" class="<?php echo ($current_page_url == $data_payroll || $current_page_url == $tambah_data_payroll) ? 'active' : ''; ?>">
                            <i class="bi bi-circle"></i><span>Data Payroll</span>
                        </a>
                    </li>
                    <?php
                       }
                    ?>
                    <li>
                        <a href="?page=slip_gaji" class="<?php echo ($current_page_url == $slip_gaji) ? 'active' : ''; ?>">
                            <i class="bi bi-circle"></i><span>Slip Gaji</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- End Payroll -->

            <?php
                if ($_SESSION['role'] == 'owner' || $_SESSION['role'] == 'admin') {
            ?>
            <!-- Start Laporan -->
             <li class="nav-item">
                <a class="nav-link 
                 <?php if ($current_page_url != $laporan_payroll || $current_page_url != $laporan_absensi   ) {
                        echo "collapsed";
                    } else {
                        echo "";
                    } ?>" data-bs-target="#pages-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-file-earmark-pdf"></i><span>Laporan</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="pages-nav" class="nav-content collapse
                <?php if ( $current_page_url == $laporan_absensi || $current_page_url == $laporan_payroll )  {
                    echo "show";
                } ?>" data-bs-parent="#sidebar-nav">
                    <?php
                        if ($_SESSION['role'] == 'owner') {
                    ?>
                        <li>
                            <a href="?page=laporan_payroll" class="<?php echo ($current_page_url == $laporan_payroll) ? 'active' : ''; ?>">
                                <i class="bi bi-circle"></i><span>Laporan Payroll</span>
                            </a>
                        </li>
                    <?php
                        }
                    ?>
                        <li>
                            <a href="?page=laporan_absensi" class="<?php echo ($current_page_url == $laporan_absensi) ? 'active' : ''; ?>">
                                <i class="bi bi-circle"></i><span>Laporan Absensi</span>
                            </a>
                        </li>
                </ul>
            </li>
            <?php
                }
            ?>
            <!-- End Laporan -->


        </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main">


        <?php
        // echo $current_page_url;
        // echo $view_jadwal_kerja;
        // error_reporting(0);
        $page = $_GET['page'];

        if ($page == 'dashboard') {
            include "pages/dashboard.php";
        //data karyawan
        } else if ($page == 'data_karyawan') {
            include "pages/data_karyawan/data_karyawan.php";
        } else if ($page == 'hapus_data_karyawan') {
            include "pages/data_karyawan/hapus_data_karyawan.php";
        } else if ($page == 'tambah_data_karyawan') {
            include "pages/data_karyawan/tambah_data_karyawan.php";
        } else if ($page == 'ubah_data_karyawan') {
            include "pages/data_karyawan/ubah_data_karyawan.php";
        } 

        //jadwal kerja
        else if ($page == 'jadwal_kerja') {
            include "pages/jadwal_kerja/jadwal_kerja.php";
        } else if ($page == 'tambah_jadwal_kerja') {
            include "pages/jadwal_kerja/tambah_jadwal_kerja.php";
        } else if ($page == 'ubah_jadwal_kerja') {
            include "pages/jadwal_kerja/ubah_jadwal_kerja.php";
        } else if ($page == 'hapus_jadwal_kerja') {
            include "pages/jadwal_kerja/hapus_jadwal_kerja.php";
        } 

        //approval jadwal
        else if ($page == 'approval_jadwal_kerja') {
            include "pages/approval_jadwal/approval_jadwal_kerja.php";
        } else if ($page == 'approve_jadwal_kerja') {
            include "pages/approval_jadwal/approve_jadwal_kerja.php";
        } else if ($page == 'reject_jadwal_kerja') {
            include "pages/approval_jadwal/reject_jadwal_kerja.php";
        } else if ($page == 'view_jadwal_kerja') {
            include "pages/approval_jadwal/view_jadwal_kerja.php";
        }

        //absensi
        else if ($page == 'absen_in_out') {
            include "pages/absensi/absen_in_out.php";
        } else if ($page == 'absen_sakit') {
            include "pages/absensi/absen_sakit.php";
        } else if ($page == 'absen_cuti') {
            include "pages/absensi/absen_cuti.php";
        } else if ($page == 'ubah_absensi_in_out') {
            include "pages/absensi/ubah_absensi_in_out.php";
        } else if ($page == 'approval_absen') {
            include "pages/absensi/approval_absen.php";
        } else if ($page == 'view_absen') {
            include "pages/absensi/view_absen.php";
        } else if ($page == 'approve_absen') {
            include "pages/absensi/approve_absen.php";
        } else if ($page == 'reject_absen') {
            include "pages/absensi/reject_absen.php";
        }

        //data payroll
        else if ($page == 'data_payroll') {
            include "pages/data_payroll/data_payroll.php";
        } else if ($page == 'tambah_data_payroll') {
            include "pages/data_payroll/tambah_data_payroll.php";
        } else if ($page == 'hapus_data_payroll') {
            include "pages/data_payroll/hapus_data_payroll.php";
        }

         //slip gaji dan laporan
        else if ($page == 'slip_gaji') {
            include "pages/slip/slip_gaji.php";
        } else if ($page == 'laporan_payroll') {
            include "pages/laporan/laporan_payroll.php";
        } else if ($page == 'laporan_absensi') {
            include "pages/laporan/laporan_absensi.php";
        } 

        ?>


    </main>

    <!-- ======= Footer ======= -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.0-beta.0/dist/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <!-- DataTables for Bootstrap 5 JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    <?php
        include 'script.php'
    ?>

</body>

</html>