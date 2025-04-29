<?php
// Menghubungkan ke database
include '../../koneksi.php';


$dari = $_POST['dari'];
$sampai = $_POST['sampai'];

?>


<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laporan Absensi </title>
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

<!-- Judul Laporan -->
<h2>LAPORAN ABSENSI</h2>

<!-- Periode Laporan -->
<div class="periode">
    <p>Periode: <?php echo date("d-m-Y", strtotime($dari)) . ' - ' .  date("d-m-Y", strtotime($sampai))   ?> </p>

</div>

<!-- Tabel Laporan Gaji -->
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Karyawan</th>
            <th>Jabatan</th>
            <th>Cuti/Izin</th>
            <th>Sakit</th>
            <th>Tanpa Keterangan</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $no = 1;

        $sql = $conn->query(" SELECT 
                                    ta.id_karyawan, 
                                    tu.name, 
                                    tu.role, 
                                    IFNULL(x.jumlahsakit, 0) AS JumlahSakit, 
                                    IFNULL(z.jumlahcuti, 0) AS JumlahCuti,
                                    COUNT(CASE WHEN ta.jam_in IS NULL AND ta.jam_out IS NULL THEN 1 END) AS JumlahMangkir,
                                    GREATEST(
                                        COUNT(CASE WHEN ta.jam_in IS NULL AND ta.jam_out IS NULL THEN 1 END) -
                                        COUNT(CASE WHEN taa.type_absen IN ('sakit', 'cuti') THEN 1 END),
                                        0
                                    ) AS Mangkir
                                    
                                FROM tb_absensi ta
                                LEFT JOIN tb_absen taa ON taa.id_karyawan = ta.id_karyawan AND taa.tanggal_absen = ta.tanggal_kerja
                                LEFT JOIN tb_user tu ON ta.id_karyawan = tu.id
                                LEFT JOIN 
                                    (
                                        SELECT 
                                            COUNT(*) AS jumlahsakit, 
                                            id_karyawan 
                                        FROM 
                                            tb_absen 
                                        WHERE 
                                           	type_absen = 'sakit' 
											AND tanggal_absen BETWEEN '$dari' AND '$sampai' 
                                        	AND status = 'approve' 
                                        GROUP BY 
                                            id_karyawan
                                    ) x ON x.id_karyawan = ta.id_karyawan
                                LEFT JOIN 
                                    (
                                        SELECT 
                                            COUNT(*) AS jumlahcuti, 
                                            id_karyawan 
                                        FROM 
                                            tb_absen 
                                        WHERE 
                                           	type_absen = 'cuti' 
											AND tanggal_absen BETWEEN '$dari' AND '$sampai' 
                                        	AND status = 'approve' 
                                        GROUP BY 
                                            id_karyawan
                                    ) z ON z.id_karyawan = ta.id_karyawan
                                WHERE 
                                  tanggal_absen BETWEEN '$dari' AND '$sampai' 
                                GROUP BY 
                                    ta.id_karyawan, 
                                    tu.name, 
                                    tu.role
                                 ");
        if ($sql->num_rows == 0) {
            echo "<script>
                alert('Data Absensi tidak ditemukan untuk range tersebut.');
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
                <td><?php echo $data["JumlahCuti"] ?></td>
                <td><?php echo $data["JumlahSakit"] ?></td>
                <td><?php echo $data["Mangkir"] ?></td>
            </tr>
        <?php } ?>
        <!-- Tambahkan data karyawan lainnya di sini -->
    </tbody>
</table>

</body>
</html>