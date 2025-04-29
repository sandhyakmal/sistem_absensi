<?php
include 'koneksi.php';

if (isset($_POST['id_karyawan'])) {
    $id_karyawan = $_POST['id_karyawan'];

    $sql = $conn->query("SELECT * FROM tb_user where id='$id_karyawan'");

    $tampil = $sql->fetch_assoc();
} else {
    echo "ID tidak ditemukan";
}
?>

<section class="section">
    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Edit Data Karyawan</h5>

                    <!-- Floating Labels Form -->
                    <form method="POST" enctype="multipart/form-data" class="row g-3">
                        
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="hidden" class="form-control" value="<?php echo $id_karyawan; ?>" id="id_karyawan" name="id_karyawan">
                                <input required type="text" class="form-control" value="<?php echo $tampil['name']; ?>" id="name" name="name" placeholder="Nama Karyawan">
                                <label for="name">Nama Karyawan</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input required type="password" class="form-control" id="password" value="<?php echo $tampil['password']; ?>"  name="password" placeholder="Password">
                                <label for="password">Password</label>
                            </div>
                        </div>



                        <div class="text-center">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            <!-- <button type="reset" class="btn btn-secondary">Reset</button> -->
                        </div>
                    </form><!-- End floating Labels Form -->

                </div>
            </div>

        </div>
    </div>
</section>


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $id_karyawan =  $_POST['id_karyawan'];
    $name = $_POST['name'];
    $password = $_POST['password'];

    $salary = str_replace(".", "", $salary);
    $upah_lembur = str_replace(".", "", $upah_lembur);

    // Query untuk mengupdate data dalam tabel
    $sql = "UPDATE tb_user SET 
                name='$name', 
                password='$password'
            WHERE id=$id_karyawan";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
            alert('Data berhasil di Update');
            window.location.href = '?page=data_karyawan';
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>