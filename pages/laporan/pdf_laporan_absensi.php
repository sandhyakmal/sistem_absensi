<?php
// Menghubungkan ke database
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

$tahun = $_POST['tahun'];

?>


<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laporan Absensi Awanbrew</title>
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
<h2>LAPORAN ABSENSI</h2>

<!-- Periode Laporan -->
<div class="periode">
    <p>Periode: <?php echo $hasil_bulan . " " . $tahun ?></p>
</div>

<!-- Tabel Laporan Gaji -->
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Karyawan</th>
            <th>Jabatan</th>
            <th>Cuti</th>
            <th>Sakit</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $no = 1;
        $sql = $conn->query("SELECT tu.name, tu.role,
                            SUM(CASE WHEN type_absen = 'sakit' THEN 1 ELSE 0 END) AS jumlah_sakit,
                            SUM(CASE WHEN type_absen = 'cuti' THEN 1 ELSE 0 END) AS jumlah_cuti
                            FROM tb_absen ta
                            LEFT JOIN tb_user tu ON ta.id_karyawan = tu.id
                            WHERE 
                                MONTH(tanggal_absen) = '$bulan'
                                AND YEAR(tanggal_absen) = '$tahun'
                            GROUP BY  id_karyawan; ");
        if ($sql->num_rows == 0) {
            echo "<script>
                alert('Data Absensi tidak ditemukan untuk bula dan tahun yang dipilih.');
                  window.location.href = '../../index.php?page=laporan_absensi';
            </script>";
            exit;
        }
        while ($data = $sql->fetch_assoc()) {
        ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $data["name"] ?></td>
                <td><?php echo $data["role"] ?></td>
                <td><?php echo $data["jumlah_cuti"] ?></td>
                <td><?php echo $data["jumlah_sakit"] ?></td>
            </tr>
        <?php } ?>
        <!-- Tambahkan data karyawan lainnya di sini -->
    </tbody>
</table>

</body>
</html>