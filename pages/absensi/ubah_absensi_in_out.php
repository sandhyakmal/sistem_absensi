<?php
include 'koneksi.php';

if (isset($_POST['id_absen'])) {
    $id_absen = $_POST['id_absen'];

    $sql = $conn->query("SELECT * FROM tb_absensi where id='$id_absen'");

    $tampil = $sql->fetch_assoc();
} else {
    echo "ID tidak ditemukan";
}
?>

<!-- Form Edit -->
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Edit Absen Karyawan</h5>
                    
                    <form method="POST" enctype="multipart/form-data" class="row g-3">
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="hidden" step="1" class="form-control" value="<?php echo $tampil['id']?>" name="id_absen" >
                            <input readonly type="date" class="form-control" value="<?php echo $tampil['tanggal_kerja']?>"  id="tanggal_kerja" name="tanggal_kerja" placeholder="Tanggal" >
                            <!-- <input type="text" class="form-control" id="datetimeInput" name="tanggal_kerja" placeholder="Tanggal kerja"> -->
                            <label for="tanggal_kerja">Tanggal kerja</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="time" step="1" class="form-control" value="<?php echo $tampil['jam_in']?>" name="jam_in" placeholder="Jam In" >
                            <label for="jam">Jam In</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="time" step="1"  class="form-control" value="<?php echo $tampil['jam_out']?>" name="jam_out" placeholder="Jam_out" >
                            <label for="jam">Jam Out</label>
                        </div>
                    </div>

                   
                    <div class="text-center">
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>

                </div>
            </div>
        </div>
    </div>
</section>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $id_absen = $_POST['id_absen'];
    $tanggal_kerja = $_POST['tanggal_kerja'];
    $jam_in = $_POST['jam_in'];
    $jam_out = $_POST['jam_out'];

    $jam_in = str_replace(".", ":", $jam_in);
    $jam_out = str_replace(".", ":", $jam_out);

    // Query untuk mengupdate data dalam tabel
    $sql = "UPDATE tb_absensi SET 
                tanggal_kerja='$tanggal_kerja', 
                jam_in='$jam_in', 
                jam_out='$jam_out'
            WHERE id=$id_absen";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
            alert('Data berhasil di Update');
            window.location.href = '?page=absen_in_out';
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>