<?php
include '../../koneksi.php';

$bulan = $_POST['bulan'];

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

$tahun = date("Y");
$id_karyawan = $_POST['id_karyawan'];

//SQL Buat ambil data payroll
$sql = $conn->query(" SELECT tp.*, tu.name, tu.role, tu.salary FROM tb_payroll tp LEFT JOIN tb_user tu ON tp.id_karyawan = tu.id WHERE tp.id_karyawan = '$id_karyawan'  ");
$tampil = $sql->fetch_assoc();

//SQL Buat ambil data Absen
$sql = $conn->query("SELECT SUM(CASE WHEN type_absen = 'sakit' THEN 1 ELSE 0 END)  AS jumlah_sakit,
        SUM(CASE WHEN type_absen = 'cuti' THEN 1 ELSE 0 END)  AS jumlah_cuti
    FROM tb_absen
    WHERE id_karyawan = '$id_karyawan'
    AND MONTH(tanggal_absen) = '$bulan'
    AND YEAR(tanggal_absen) = '$tahun'") ;

if ($sql->num_rows == 0) {
    // Redirect jika tidak ada data
    echo "<script>
        alert('Data absen tidak ditemukan untuk bulan yang dipilih.');
          window.location.href = '../../index.php?page=slip_gaji';
    </script>";
    exit;
}

$absen = $sql->fetch_assoc();

if (!$absen || (is_null($absen['jumlah_sakit']) && is_null($absen['jumlah_cuti']))) {
    echo "<script>
    alert('Data absen tidak ditemukan untuk bulan yang dipilih');
    window.location.href = '../../index.php?page=slip_gaji';
    </script>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Slip Gaji Awanbrew</title>
        <style>
            @media print {
                @page {
                margin: 0;
                }
                body {
                    margin: 0;
                    padding: 0;
                }
            }
    
            html {
                transform: rotate(-90deg);
            }

            body {
                transform: rotate(90deg);
            }
            .wrap {
                width: 100%;
            }
            .slip-wrap {
                margin: 1rem 2rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-direction: column;
                position: relative;
            }
            .header-wrap {
                width: 100%;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .img-wrap {
                width: 7rem;
            }
            .img {
                width: 100%;
                height: 100%;
            }
            .right-wrap {
                text-transform: uppercase;
            }
            .slip-right {
                width: 100%;
                border-bottom: 1px solid black;
            }
            .h-slip-title {
                font-size: 1rem;
            }
            .periode-right {
                width: 100%;
                display: flex;
                justify-content: start;
                align-items: center;
                margin-top: 2px;
            }
            h2 {
                margin: 0;
            }
            .text {
                font-size: 1rem;
            }
            .h-input-slip {
                /* border: none; */
                width: 2.5rem;
            }
            /* .h-input-slip-wrap {
            height: 100%;
            text-align: center;
        } */
            .h-periode-title {
                font-size: 1rem;
                margin: 0;
            }
            .identity-wrap {
                width: 100%;
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 3rem;
            }
            .border-wrap {
                border: 2px solid black;
                padding: 8px;
                width: 22rem;
            }
            .h-no-title {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .hr-open {
                width: 100%;
                margin-top: 3rem;
            }
            .main-wrap {
                width: 100%;
                display: flex;
                justify-content: space-between;
                /* margin-top: 5rem; */
            }
            .main-body-wrap {
                display: flex;
                flex-direction: column;
                justify-content: start;
                width: 18rem;
            }
            .title-absen-wrap {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                margin: 1rem 0;
            }

            .main-title {
                padding: 5px 0;
                /* width: 15rem; */
                text-align: center;
                border-bottom: 1px solid rgba(0, 0, 0, 0.423);
                font-size: 1rem;
            }
            .title-absensi {
                /* margin: 1.5rem 0; */
                font-weight: lighter;
                font-size: 1rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 90%;
            }
            .fit {
                height: 100%;
                display: flex;
                align-items: start;
            }
            .title-input {
                text-align: start;
                font-size: 10px;
            }
            .input-absensi {
                width: 4rem;
            }
            .close-wrap {
                width: 100%;
                display: flex;
                align-items: center;
                margin-top: 0rem;
            }
            .title-bruto {
                font-size: 12px;
                font-weight: lighter;
                background-color: rgb(194, 194, 194);
                padding: 8px;
                margin: 0 5px;
            }
            .hr-close {
                width: 50%;
            }
            .total-wrap {
                width: 100%;
                display: flex;
                justify-content: end;
                align-items: center;
                margin-top: 1rem;
            }
            .input-total-wrap {
                margin-left: 0.5rem;
                border: 1px solid black;
            }
            .input-total {
                width: 20rem;
                height: 3rem;
            }
            .title-wrap {
                display: flex;
                justify-content: start;
                align-items: center;
                margin: 5px 0;
            }
            .title-noslip {
                margin: none;
                display: flex;
                justify-content: start;
                align-items: center;
                margin: 2px 0;
            }
            .flex-col {
                display: flex;
                flex-direction: column;
            }
            .flex-border {
                display: flex;
                flex-direction: column;
                border: 2px solid black;
                padding: 0 5px;
                width: 15rem;
            }
            .main-title-wrap {
                display: flex;
                justify-content: space-between;
                align-items: center;
                height: 100%;
                margin: 0.5rem 8px;
            }
            .title-gaji {
                padding: 10px;
                font-size: 1rem;
            }
            .title-gaji-border {
                border-bottom: solid 1px black;
                padding: 8px;
                font-size: 1rem;
                font-weight: bold;
            }
            .title-gaji-huruf {
                padding: 4px;
                font-size: 1rem;
                font-style: italic;
            }
            .fit-huruf {
                height: 100%;
                display: flex;
                align-items: start;
                border: solid 1px black;
                margin-left: 10px;
            }
        </style>
    </head>
    <body>
        <div class="wrap">
            <div class="slip-wrap">
                <div class="header-wrap">
                    <div class="left-wrap">
                        <div class="img-wrap">
                            <img
                                src="data:image/png;base64,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"
                                alt="Logo Elga"
                                class="img"
                            />
                        </div>
                    </div>
                    <div class="right-wrap">
                        <div class="slip-right">
                            <h2 class="h-slip-title">Slip Gaji Karyawan</h2>
                        </div>
                        <div class="periode-right">
                            <div>
                                <h2 class="h-periode-title">Periode :</h2>
                            </div>
                            <div class="h-input-slip-wrap">
                                <p class="h-input-slip"></p>
                            </div>
                            <h2 class="h-periode-title"><?php echo $hasil_bulan .  " " . $tahun  ?></h2>
                        </div>
                    </div>
                </div>
                <div class="identity-wrap">
                    <div class="flex-col">
                        <div class="title-wrap">
                            <div>
                                <h2 class="text">Nama &nbsp;&nbsp; :</h2>
                            </div>
                            <div>
                                <p class="h-periode-title">
                                    &nbsp;<?php echo $tampil['name']  ?>
                                </p>
                            </div>
                        </div>
                        <div class="title-wrap">
                            <div>
                                <h2 class="text">Posisi &nbsp;&nbsp; :</h2>
                            </div>
                            <div>
                                <p class="h-periode-title">
                                    &nbsp;<?php echo $tampil['role']  ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <hr class="hr-open" />
                <div class="main-wrap">
                    <div class="main-body-wrap">
                        <h2 class="main-title">Data Absensi</h2>
                        <div class="title-absen-wrap">
                            <div class="main-title-wrap">
                                <div class="fit">
                                    <p class="title-input">
                                        Total Sakit
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    </p>
                                </div>
                                <div class="fit">
                                    <p class="title-input"><?php echo $absen['jumlah_sakit'] ?></p>
                                </div>
                            </div>
                            <div class="main-title-wrap">
                                <div class="fit">
                                    <p class="title-input">
                                       Total Cuti
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    </p>
                                </div>
                                <div class="fit">
                                    <p class="title-input"><?php echo $absen['jumlah_cuti'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-body-wrap">
                        <h2 class="main-title">DATA GAJI</h2>
                        <div class="title-absen-wrap">
                            <div class="main-title-wrap">
                                <div class="fit">
                                    <p class="title-input">
                                        Gaji Pokok
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    </p>
                                </div>
                                <div class="fit">
                                    <p class="title-input"><?php echo "Rp " . number_format($tampil["salary"], 0, ',', '.'); ?></p>
                                </div>
                            </div>

                            <div class="main-title-wrap">
                                <div class="fit">
                                    <p class="title-input">
                                        Bonus
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    </p>
                                </div>
                                <div class="fit">
                                    <p class="title-input"><?php echo "Rp " . number_format($tampil["bonus"], 0, ',', '.'); ?></p>
                                </div>
                            </div>

                            <div class="main-title-wrap">
                                <div class="fit">
                                    <p class="title-input">
                                        Total Lembur
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    </p>
                                </div>
                                <div class="fit">
                                    <p class="title-input"><?php echo "Rp " . number_format($tampil["total_lembur"], 0, ',', '.'); ?></p>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    <div class="main-body-wrap">
                        <h2 class="main-title">POTONGAN</h2>
                        <div class="title-absen-wrap">
                            <div class="main-title-wrap">
                                <div class="fit">
                                    <p class="title-input">
                                        Deskripsi Potongan
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    </p>
                                </div>
                                <div class="fit">
                                    <p class="title-input"><?php echo $tampil['keterangan_potongan'] ?></p>
                                </div>
                            </div>
                            <div class="main-title-wrap">
                                <div class="fit">
                                    <p class="title-input">
                                        Total Potongan
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    </p>
                                </div>
                                <div class="fit">
                                    <p class="title-input"><?php echo "Rp " . number_format($tampil["potongan"], 0, ',', '.'); ?></p>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
                <div class="close-wrap">
                    <hr class="hr-close" />
                    
                    </div>
                </div>
                <div class="total-wrap">
                    <div class="main-title-wrap">
                        <div class="fit">
                            <p class="title-gaji">Jumlah Gaji</p>
                        </div>
                        <div class="fit">
                            <p class="title-gaji-border"><?php echo "Rp " . number_format($tampil["total"], 0, ',', '.'); ?></p>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
