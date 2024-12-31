<?php
// Menghubungkan ke database
include 'koneksi.php';

?>

<div class="pagetitle">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item active">Data Absensi</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        Data Absensi Karyawan
                        <!-- &nbsp; | &nbsp; -->
                        <!-- <a href="index.php?page=tambah_absen_in_out" class="btn btn-primary btn-sm"><i class="bi bi-plus">Input Absensi</i></a> -->
                        <?php
                            if ($_SESSION['role'] == 'karyawan') {
                        ?>
                        &nbsp; | &nbsp;
                        <!-- Basic Modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                            Input Absensi
                        </button>
                        
                        <?php
                            }
                        ?>
                        <!-- End Basic Modal-->
                    </h5>
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Karyawan</th>
                                <th>Tanggal Kerja</th>
                                <th>Jam In</th>
                                <th>Jam Out</th>
                                <th>Durasi Lembur</th>
                                <th>Jumlah Jam Kerja</th>

                                <th>Aksi</th>
                                 
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $id_user =  $_SESSION['id'];
                            if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'owner') {
                                $sql = $conn->query(" SELECT ta.id, ta.id_karyawan, ta.tanggal_kerja, ta.jam_in, ta.jam_out, ta.durasi_lembur, ta.status, tu.name FROM tb_absensi ta LEFT JOIN tb_user tu ON ta.id_karyawan = tu.id LEFT JOIN tb_absen taa ON ta.tanggal_kerja = taa.tanggal_absen AND ta.id_karyawan = taa.id_karyawan ORDER BY id DESC ");
                            }
                            else {
                                // $sql = $conn->query(" SELECT ta.id, ta.id_karyawan, ta.tanggal_kerja, ta.jam_in, ta.jam_out, ta.durasi_lembur, ta.status, tu.name FROM tb_absensi ta LEFT JOIN tb_user tu ON ta.id_karyawan = tu.id WHERE id_karyawan = '$id_user' ORDER BY id DESC ");

                                $sql =  $conn->query(" SELECT ta.id, ta.id_karyawan, ta.tanggal_kerja, ta.jam_in, ta.jam_out, ta.durasi_lembur, ta.status, tu.name FROM tb_absensi ta LEFT JOIN tb_user tu ON ta.id_karyawan = tu.id LEFT JOIN tb_absen taa ON ta.tanggal_kerja = taa.tanggal_absen AND ta.id_karyawan = taa.id_karyawan WHERE ta.id_karyawan = '$id_user' ORDER BY id DESC ");
                            }
                            while ($data = $sql->fetch_assoc()) {

                                if (!empty($data['jam_in']) && !empty($data['jam_out'])) {
                                    // Buat objek DateTime untuk jam_in dan jam_out
                                    $jam_in = new DateTime($data['jam_in']);
                                    $jam_out = new DateTime($data['jam_out']);
                        
                                    // Hitung selisih waktu antara jam_in dan jam_out
                                    $interval = $jam_in->diff($jam_out);
                        
                                    // Format selisih waktu sebagai jam:menit:detik
                                    $jumlah_jam_kerja = $interval->format('%H:%I:%S');
                                } else {
                                    // Jika salah satu dari jam_in atau jam_out kosong, set jumlah jam kerja ke 00:00:00
                                    $jumlah_jam_kerja = '';
                                }
                            ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $data["name"];  ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($data["tanggal_kerja"]));  ?></td>
                                    <td><?php echo $data["jam_in"];  ?></td>
                                    <td><?php echo $data["jam_out"];  ?></td>
                                    <td><?php echo $data["durasi_lembur"];  ?></td>
                                    <td><?php echo $jumlah_jam_kerja;  ?></td>
                                    
                                    <?php
                                    if ((is_null($data['jam_in']) || is_null($data['jam_out'])) && $_SESSION['role'] !== 'karyawan') {
                                        ?>
                                    <td>
                                        <form action="index.php?page=ubah_absensi_in_out" method="POST" style="display:inline;">
                                            <input type="hidden" name="id_absen" value="<?php echo $data['id']; ?>">
                                            <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</button>
                                        </form>
                                    </td>
                                    <?php
                                        } else {
                                            echo '<td></td>';
                                        }
                                    ?>


                                    
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->

                </div>
            </div>

        </div>
    </div>
</section>

<!-- MODAL INSERT -->
<div class="modal fade" id="basicModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Input Absensi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input readonly type="date" class="form-control" value="<?php echo date('Y-m-d');?>"  id="tanggal_kerja" name="tanggal_kerja" placeholder="Tanggal" >
                            <!-- <input type="text" class="form-control" id="datetimeInput" name="tanggal_kerja" placeholder="Tanggal kerja"> -->
                            <label for="tanggal_kerja">Tanggal kerja</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="time" step="1"  class="form-control" name="jam" placeholder="Jam" >
                            <!-- <input type="time" step="1"  class="form-control" id="timeInput" name="jam" placeholder="Jam" > -->
                            <label for="jam">Jam</label>
                        </div>
                    </div>

                    <!-- <div class="text-center">
                        <button type="button" id="tambah-baris" class="btn btn-info">Tambah Row</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div> -->
                    <div class="modal-footer">
                        <button type="submit" name="in" id="in" class="btn btn-success">IN</button>
                        <button type="submit" name="out" id="out" class="btn btn-danger">OUT</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>
<!-- END MODAL INSERT -->

<?php
include 'koneksi.php'; // Pastikan koneksi ke database

// Fungsi untuk absensi masuk
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['in'])) {
    $tanggal_kerja = $_POST['tanggal_kerja'];
    $jam_in = $_POST['jam'];
    $id_user = $_SESSION['id'];
    $status = 'Tepat Waktu';

    // Cek apakah tanggal kerja ada di tabel tb_jadwal
    // $sql_jadwal = "SELECT * FROM tb_jadwal WHERE tanggal_kerja = '$tanggal_kerja' AND status='approve' ";
    $sql_jadwal = "SELECT * FROM tb_jadwal tj LEFT JOIN tb_jadwal_detail tjd ON tj.id = tjd.id_jadwal WHERE tj.tanggal_kerja = '$tanggal_kerja' AND tj.status='approve' AND tjd.id_karyawan = '$id_user'  ";
    $result_jadwal = $conn->query($sql_jadwal);


    if ($result_jadwal->num_rows == 0) {
        // Jika tidak ada data di tb_jadwal, tampilkan pesan error
        echo "<script>
            alert('Tanggal kerja tidak ditemukan dalam jadwal Anda. Absen masuk tidak dapat dilakukan.');
            window.location.href = '?page=absen_in_out';
        </script>";
    } else {
        // Cek apakah sudah ada entri absensi pada tanggal yang sama untuk user ini
        $sql_check = "SELECT * FROM tb_absensi WHERE tanggal_kerja = '$tanggal_kerja' AND id_karyawan = '$id_user'";
        $result = $conn->query($sql_check);

        $sql_check_terlambat = " SELECT ts.jam_mulai FROM tb_jadwal tj LEFT JOIN tb_jadwal_detail tjd ON tj.id = tjd.id_jadwal LEFT JOIN tb_shift ts ON tjd.shift = ts.id WHERE tj.tanggal_kerja = '$tanggal_kerja' AND tj.status='approve' AND tjd.id_karyawan = '$id_user'  ";
        $result_check_terlambat = $conn->query($sql_check_terlambat);
        $data = $result_check_terlambat->fetch_assoc();

        if ($data['jam_mulai'] < $jam_in) {
            $status = 'Terlambat';
        } else {
            $status = 'Masuk';
        }
        
        if ($result->num_rows == 0) {
            // Jika tidak ada entri absensi, tambahkan dengan jam masuk
            $sql = "INSERT INTO tb_absensi (tanggal_kerja, jam_in, id_karyawan, status) VALUES ('$tanggal_kerja', '$jam_in', '$id_user', '$status' )";
            if ($conn->query($sql) === TRUE ) {
                echo "<script>
                    alert('Absen masuk berhasil.');
                    window.location.href = '?page=absen_in_out';
                </script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            $data = $result->fetch_assoc();
            if (is_null($data['jam_in']) && is_null($data['jam_out'])) {
                // Jika ada entri tetapi tanpa jam masuk dan jam keluar, update dengan jam masuk
                $sql_update = "UPDATE tb_absensi SET jam_in = '$jam_in', status = '$status' WHERE tanggal_kerja = '$tanggal_kerja' AND id_karyawan = '$id_user' AND jam_in IS NULL";
                if ($conn->query($sql_update) === TRUE) {
                    echo "<script>
                        alert('Absen masuk berhasil.');
                        window.location.href = '?page=absen_in_out';
                    </script>";
                } else {
                    echo "Error: " . $sql_update . "<br>" . $conn->error;
                }
            } elseif (!is_null($data['jam_out'])) {
                // Jika jam_out sudah terisi, tampilkan pesan bahwa absen masuk tidak bisa dilakukan lagi
                echo "<script>
                    alert('Anda tidak dapat melakukan absen masuk karena sudah melakukan absen keluar.');
                    window.location.href = '?page=absen_in_out';
                </script>";
            } else {
                echo "<script>
                    alert('Anda sudah melakukan absen masuk hari ini.');
                    window.location.href = '?page=absen_in_out';
                </script>";
            }
        }
    }

    $conn->Close();
}

// Fungsi untuk absensi keluar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['out'])) {
    $tanggal_kerja = $_POST['tanggal_kerja'];
    $jam_out = $_POST['jam'];
    $id_user = $_SESSION['id'];

    // Ambil shift karyawan dari tabel jadwal
    $sqlShift = "SELECT ts.jam_mulai, ts.jam_akhir, tu.upah_lembur
                 FROM tb_jadwal tj 
                 JOIN tb_jadwal_detail tjd ON tjd.id_jadwal = tj.id
                 JOIN tb_shift ts ON tjd.shift = ts.id 
                 JOIN tb_user tu ON tjd.id_karyawan = tu.id 
                 WHERE tj.tanggal_kerja = '$tanggal_kerja' AND tjd.id_karyawan = '$id_user'";
    $resultShift = $conn->query($sqlShift);
    $shiftData = $resultShift->fetch_assoc();

    $jam_mulai   = $shiftData['jam_mulai'];
    $jam_akhir   = $shiftData['jam_akhir'];
    $upah_lembur = $shiftData['upah_lembur'];

    $sql_jadwal = "SELECT * FROM tb_jadwal WHERE tanggal_kerja = '$tanggal_kerja' AND status='approve' ";
    $result_jadwal = $conn->query($sql_jadwal);

    if ($result_jadwal->num_rows == 0) {
        // Jika tidak ada data di tb_jadwal, tampilkan pesan error
        echo "<script>
            alert('Tanggal kerja tidak ditemukan dalam jadwal Anda. Absen masuk tidak dapat dilakukan.');
            window.location.href = '?page=absen_in_out';
        </script>";
    } else {
        // Hitung lembur jika jam_out lebih dari jam_akhir
        if ($jam_out > $jam_akhir) {
            $sqlLembur = "SELECT TIMEDIFF('$jam_out', '$jam_akhir') AS durasi_lembur";
            $resultLembur = $conn->query($sqlLembur);
            $lemburData = $resultLembur->fetch_assoc();
            $durasi_lembur = $lemburData['durasi_lembur'];
        } else {
            $durasi_lembur = '00:00:00';
        }
    
        $upah_per_jam = 15000;
        $durasi = new DateTime($durasi_lembur);
        $jam = (int)$durasi->format('H');
        $menit = (int)$durasi->format('i');
    
        // Menghitung total upah lembur
        $upah_jam = $jam * $upah_per_jam;
        $upah_menit = ($menit / 60) * $upah_per_jam;
        $upah_lembur = $upah_jam + $upah_menit;
    
        // Output hasil
        echo "Durasi Lembur: $durasi_lembur<br>";
        echo "Upah Lembur: Rp" . number_format($upah_lembur, 0, ',', '.');
    
        // Insert atau update data absensi dengan durasi lembur
        $sql_check = "SELECT * FROM tb_absensi WHERE tanggal_kerja = '$tanggal_kerja' AND id_karyawan = '$id_user'";
        $result = $conn->query($sql_check);
    
        if ($result->num_rows == 0) {
            // Insert data absensi baru
            $sql_insert = "INSERT INTO tb_absensi (tanggal_kerja, jam_out, id_karyawan, durasi_lembur, upah_lembur)
                           VALUES ('$tanggal_kerja', '$jam_out', '$id_user', '$durasi_lembur', '$upah_lembur')";
            $conn->query($sql_insert);
        } else {
            // Update data absensi dengan durasi lembur
            $sql_update = "UPDATE tb_absensi 
                           SET jam_out = '$jam_out', durasi_lembur = '$durasi_lembur', upah_lembur = '$upah_lembur'
                           WHERE tanggal_kerja = '$tanggal_kerja' AND id_karyawan = '$id_user'";
            $conn->query($sql_update);
        }
    
        echo "<script>
            alert('Absen keluar berhasil.');
            window.location.href = '?page=absen_in_out';
        </script>";

    }



   
    $conn->close();
}

?>