<?php
// Menghubungkan ke database
include '../../koneksi.php';

$bulan = $_POST['bulan'];
$tahun = $_POST['tahun'];
$iduser = $_POST['iduser'];


// $bulan = "01";
// $tahun = "2025";
// $id_karyawan = "6";

$sql_check_name = " SELECT name FROM tb_user WHERE id = '$iduser'  ";
$result = $conn->query($sql_check_name);
$name = $result->fetch_assoc();

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

?>


<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laporan Presensi Awanbrew</title>
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
    
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        text-align: center;
    }

    .kop-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 20px;
    }

    .kop-surat {
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom: 2px solid #004080;
        padding-bottom: 10px;
        max-width: 800px;
        width: 100%;
    }

    .kop-surat img {
        width: 100px;
        margin-right: 20px;
    }

    .kop-text {
        text-align: left;
    }

    .kop-text h1 {
        margin: 0;
        font-size: 24px;
        font-weight: bold;
        color: #000;
    }

    .kop-text p {
        margin: 3px 0;
        font-size: 14px;
        color: #333;
    }

    .kop-text .subheading {
        font-weight: bold;
        font-size: 12px;
        color: #555;
    }

    .separator {
        border-top: 3px solid #004080;
        border-bottom: 1px solid #004080;
        margin: 10px auto;
        width: 80%;
        max-width: 800px;
    }

    h2 {
        text-align: center;
        margin-top: 20px;
    }

    .periode {
        text-align: center;
        margin-bottom: 20px;
    }

    table {
        width: 80%;
        max-width: 800px;
        margin: 0 auto;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th, td {
        border: 1px solid #000;
        padding: 8px;
        text-align: center;
        font-size: 14px;
    }

    th {
        background-color: #f2f2f2;
        font-weight: bold;
    }
</style>
</head>
<body>

<!-- Kop Surat -->
<div class="kop-wrapper">
    <div class="kop-surat">
        <img src="../../assets/img/awanbrew.png" alt="Logo Awanbrew">
        <div class="kop-text">
            <h1 style="text-align:center;">AWANBREW</h1>
            <p style="text-align:center;" class="subheading">COFFEE | EATERY | PASTRY | CHEESECAKE</p>
            <p style="text-align:center;">Jl. Raden Patah No.A2, Pasuruan 67139</p>
            <p style="text-align:center;">Telp. +6281334187948</p>
        </div>
    </div>
</div>

<div class="separator"></div>

<!-- Judul Laporan -->
<h2>LAPORAN PRESENSI</h2>

<!-- Periode Laporan -->
<div class="periode">
    <p>Periode: <?php echo $hasil_bulan . " " . $tahun ?></p>
    <p>Nama Karyawan : <?php echo $name['name'] ?></p>
</div>

<!-- Tabel Laporan Gaji -->
<table>
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Tanggal</th>
            <th colspan="2">Jadwal Kerja</th>
            <th colspan="2">Absensi</th>
            <th rowspan="2">Terlambat</th>
            <th rowspan="2">Keterangan</th>
        </tr>
        <tr>
            <th>In</th>
            <th>Out</th>
            <th>In</th>
            <th>Out</th>
        </tr>
    </thead>
    <tbody>
       <?php
        $no = 1;
        $sql = $conn->query(" SELECT tu.name, taa.tanggal_kerja, ts.jam_mulai as JadwalIN, ts.jam_akhir AS JadwalOUT, taa.jam_in AS AbsenIN, taa.jam_out AS AbsenOut, taa.status, (CASE WHEN taa.jam_in IS NULL AND taa.jam_out IS NULL THEN 'TANPA KETERANGAN' ELSE '-' END) AS Keterangan FROM tb_absensi taa LEFT JOIN tb_jadwal tj ON taa.id_jadwal = tj.id AND taa.tanggal_kerja = tj.tanggal_kerja LEFT JOIN tb_jadwal_detail tjd ON tj.id = tjd.id_jadwal AND tjd.id_karyawan = taa.id_karyawan LEFT JOIN tb_shift ts ON ts.id = tjd.shift LEFT JOIN tb_user tu ON taa.id_karyawan = tu.id WHERE taa.id_karyawan = '$iduser' AND MONTH(taa.tanggal_kerja) = '$bulan' AND YEAR(taa.tanggal_kerja) = '$tahun' ORDER BY taa.tanggal_kerja ASC ");
        if ($sql->num_rows == 0) {
            echo "<tr><td colspan='8'>Data tidak ditemukan</td></tr>";
        } else {
            while ($data = $sql->fetch_assoc()) {
                // $terlambat = calculateLate($data['jadwal_in'], $data['absensi_in']); // Fungsi untuk hitung keterlambatan
                // $total_terlambat += $terlambat; // Tambahkan terlambat ke total
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo date("d/m/Y", strtotime($data["tanggal_kerja"])); ?></td>
            <td><?php echo $data["JadwalIN"]; ?></td>
            <td><?php echo $data["JadwalOUT"]; ?></td>
            <td><?php echo $data["AbsenIN"]; ?></td>
            <td><?php echo $data["AbsenOut"]; ?></td>
            <td><?php echo $data["status"]; ?></td>
            <td><?php echo $data["Keterangan"]; ?></td>
        </tr>
        <?php
            }
        }
        ?> 
    </tbody>
    <!-- <tfoot>
        <tr>
            <td colspan="6" style="text-align: right; font-weight: bold;">Total Terlambat:</td>
            <td style="font-weight: bold;"><?php echo $total_terlambat; ?> menit</td>
            <td></td>
        </tr>
    </tfoot> -->
</table>


</body>
</html>