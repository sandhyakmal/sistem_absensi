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
                        Data Absensi Karyawan Sakit
                        <!-- &nbsp; | &nbsp; -->
                        <!-- <a href="index.php?page=tambah_absen_in_out" class="btn btn-primary btn-sm"><i class="bi bi-plus">Input Absensi</i></a> -->
                        <?php
                            if ($_SESSION['role'] == 'karyawan') {
                        ?>
                        &nbsp; | &nbsp;
                        <!-- Basic Modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                            Input Sakit
                        </button>
                        <div class="modal fade" id="basicModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title">Input Absen Sakit</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <form method="POST" enctype="multipart/form-data" class="row g-3">
                                        <div class="col-md-12">
                                            <div class="form-floating">
                                                <input required type="date" class="form-control" name="tanggal_absen" placeholder="Tanggal" >
                                                <label for="tanggal_absen">Tanggal Sakit</label>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="col-md-12">Bukti Surat Sakit :</label>
                                            <input required type="file" name="myfile[]" class="form-control">
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-floating">
                                                <textarea class="form-control" name="keterangan" placeholder="Leave a comment here" id="floatingTextarea" style="height: 100px;"></textarea>
                                                <label for="keterangan">Keterangan</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            Note : Surat Sakit yang asli tetap harus diberikan ke HR
                                        </div>
                                        
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Close</button>
                                        </div>
                                    </form><!-- End floating Labels Form -->
                                  
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
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
                                <th>Tanggal Sakit</th>
                                <th>Surat Sakit</th>
                                <th>Keterangan</th>
                                <th>status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $id_user =  $_SESSION['id'];
                            if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'atasan') {
                                $sql = $conn->query(" SELECT * FROM tb_absen tas LEFT JOIN tb_user tu on tas.id_karyawan = tu.id WHERE tas.type_absen = 'sakit' ");
                            }
                            else {
                                $sql = $conn->query(" SELECT * FROM tb_absen tas LEFT JOIN tb_user tu on tas.id_karyawan = tu.id WHERE id_karyawan = '$id_user' AND tas.type_absen = 'sakit' ");
                            }
                            while ($data = $sql->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $data["name"];  ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($data["tanggal_absen"]));  ?></td>
                                    <!-- <td><?php echo $data["surat_sakit"];  ?></td> -->
                                    <td><a href="<?php echo "./file_bukti/".$data["surat_sakit"]; ?>" target="_blank"><?php echo $data["surat_sakit"]; ?></a></td>
                                    <td><?php echo $data["keterangan"];  ?></td>
                                    <td>
                                        
                                        <?php if (isset($data["status"]) && $data["status"] == 'submit') {  ?>
                                             <span class="badge bg-info">On Progress Approval</span>
                                        <?php } else if (isset($data["status"]) && $data["status"] == 'reject') { ?> 
                                            <span class="badge bg-danger">Reject</span>
                                        <?php } else {?>
                                            <span class="badge bg-success">Approve</span>
                                        <?php } ?>
                                    </td>
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

<?php


// Memeriksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil nilai dari form
    $tanggal_absen = $_POST['tanggal_absen'];
    $keterangan = $_POST['keterangan'];
    $id_user =  $_SESSION['id'];
    
    //upload file
    $file_names = [];
    $file_tmps = [];
    $file_sizes = [];

    // Tentukan ekstensi file yang diizinkan
    $allowed_ext = array('jpg', 'jpeg', 'png');
    // Tentukan maksimum ukuran file
    $max_file_size = 10 * 1024 * 1024; // 10MB

    for ($i = 0; $i < count($_FILES['myfile']['name']); $i++) {
        $file_names[$i] = $_FILES['myfile']['name'][$i];
        $file_tmps[$i] = $_FILES['myfile']['tmp_name'][$i];
        $file_sizes[$i] = $_FILES['myfile']['size'][$i];

        // Lokasi tujuan file
        $destinations[$i] = 'file_bukti/' . $file_names[$i];

        // Pengecekan tipe file
        $file_ext = strtolower(pathinfo($file_names[$i], PATHINFO_EXTENSION));
        if (!in_array($file_ext, $allowed_ext)) {
            echo "<script>
            alert('File type tidak sesuai');
            </script>";
            exit;
        }

        // Pengecekan ukuran file
        if ($file_sizes[$i] > $max_file_size) {
            echo "<script>
            alert('File Size melebihi 40Mb');
            </script>";
            exit;
        }

        // Pindahkan file ke lokasi tujuan
        if (!move_uploaded_file($file_tmps[$i], $destinations[$i])) {
            echo "<script>
            alert('File Tidak dapat diupload');
            </script>";
            exit;
        }
    }

    $sql_jadwal = "SELECT * FROM tb_absensi WHERE tanggal_kerja = '$tanggal_absen' AND id_karyawan = '$id_user'";
    $result_jadwal = $conn->query($sql_jadwal);

    // Validasi hasil
    if ($result_jadwal->num_rows > 0) {
        echo "<script>
            alert('Anda melakukan absen di tanggal kerja $tanggal_absen tidak bisa melakukan input cuti .');
            window.location.href = '?page=absen_cuti';
        </script>";
        exit;
    }


    // Query untuk memasukkan data ke dalam tabel
    $sql = "INSERT INTO tb_absen (id_karyawan, tanggal_absen, surat_sakit,keterangan, type_absen, status) VALUES ('$id_user','$tanggal_absen','$file_names[0]','$keterangan','sakit','submit')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
            alert('Input Sakit Berhasil');
            window.location.href = '?page=absen_sakit';
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Menutup koneksi database
    $conn->close();
}
?>