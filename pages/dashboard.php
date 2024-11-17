<?php
include 'koneksi.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


// Pastikan pengguna sudah login dan memiliki session username
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

$bulan = date("m");
$tahun = date("Y");

$nama_bulan = [
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember',
];

// Mengambil nama bulan berdasarkan input
$hasil_bulan = $nama_bulan[$bulan] ?? 'Bulan tidak valid';
// Ambil session username
$username = $_SESSION['username'];
$id_user = $_SESSION['id'];

$sql = $conn->query("SELECT SUM(CASE WHEN type_absen = 'sakit' THEN 1 ELSE 0 END)  AS jumlah_sakit,
        SUM(CASE WHEN type_absen = 'cuti' THEN 1 ELSE 0 END)  AS jumlah_cuti
    FROM tb_absen
    WHERE id_karyawan = '$id_user'
    AND MONTH(tanggal_absen) = '$bulan'
    AND YEAR(tanggal_absen) = '$tahun'") ;

$absen = $sql->fetch_assoc();

?>

<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Welcome !</h5>
                    <p>Selamat Datang <?php echo $username ?> !</p>
                </div>
            </div>

        </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card info-card sales-card">

                <div class="card-body">
                <h5 class="card-title"> Sakit </h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-shield-plus"></i>
                    </div>
                    <div class="ps-3">
                    <h6><?php echo $absen['jumlah_sakit']?></h6>
                    <span class="text-success small pt-1 fw-bold"><?php echo $hasil_bulan . " ". $tahun ?></span>
                    </div>
                </div>
                </div>

            </div>
        </div>

        <div class="col-xxl-6 col-md-6">
            <div class="card info-card sales-card">

                <div class="card-body">
                <h5 class="card-title"> Cuti </h5>

                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-door-open"></i>
                    </div>
                    <div class="ps-3">
                    <h6><?php echo $absen['jumlah_cuti']?></h6>
                    <span class="text-success small pt-1 fw-bold"><?php echo $hasil_bulan . " ". $tahun ?></span>
                    </div>
                </div>
                </div>

            </div>
        </div>


    </div>
        

    </div>
</section>

