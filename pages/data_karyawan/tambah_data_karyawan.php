<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $password = $_POST['password'];
    // $salary = $_POST['salary'];
    $role = $_POST['role'];
    // $upah_lembur = $_POST['upah_lembur'];

    // Hapus titik pemisah ribuan
    $salary = str_replace('.', '', $salary);
    $upah_lembur = str_replace('.', '', $upah_lembur);

    // Query untuk memasukkan data
    $sql = "INSERT INTO tb_user (name, password,  role)
    VALUES ('$name', '$password', '$role')";  

    // echo $sql;

    if ($conn->query($sql) === TRUE) {
        echo "<script>
            alert('Data berhasil ditambahkan');
            window.location.href = '?page=data_karyawan';
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Menutup koneksi database
    $conn->close();
}
?>



<section class="section">
    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Tambah Data Karyawan</h5>

                    <!-- Floating Labels Form -->
                    <form method="POST" enctype="multipart/form-data" class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input required type="text" class="form-control" id="name" name="name" placeholder="Nama Karyawan">
                                <label for="name">Nama Karyawan</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input required type="password" class="form-control" id="password" name="password" placeholder="Password">
                                <label for="password">Password</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <select required class="form-select" name="role" aria-label="Floating label select example">
                                <option selected disabled value="">- Pilih Role -</option>
                                <option value="karyawan">Karyawan</option>
                                <option value="admin">Admin</option>
                                <option value="atasan">Atasan</option>
                            </select>
                        </div>
                        
                        <!-- <div class="col-md-6">
                            <div class="form-floating">
                                <input required type="text" class="form-control" id="salary" name="salary" placeholder="Salary">
                                <label for="salary">Salary (Rp)</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input required type="text" class="form-control" id="upah_lembur" name="upah_lembur" placeholder="Upah Lembur">
                                <label for="upah_lembur">Upah Lembur (Rp)</label>
                            </div>
                        </div> -->

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form><!-- End floating Labels Form -->

                </div>
            </div>

        </div>
    </div>
</section>