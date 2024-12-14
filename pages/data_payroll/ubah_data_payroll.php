<?php
include 'koneksi.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    // echo $id;

    $sql = $conn->query("SELECT tp.*, tu.name FROM tb_payroll tp LEFT JOIN tb_user tu ON tp.id_karyawan = tu.id WHERE tp.id = '$id' ");

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
                    <h5 class="card-title">Edit Data Payroll</h5>

                    <!-- Floating Labels Form -->
                    <form method="POST" enctype="multipart/form-data" class="row g-3">
                        
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="hidden" class="form-control" value="<?php echo $id; ?>" id="id" name="id">
                                <input readonly type="text" class="form-control" value="<?php echo $tampil['name']; ?>" id="name" name="name" placeholder="Nama Karyawan">
                                <label for="name">Nama Karyawan</label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input readonly type="text" class="form-control" value="<?php echo strval($tampil['bulan_payroll']) . ' - ' . strval($tampil['tahun_payroll']); ?>" name="salary" placeholder="Salary">
                                <label for="salary">Bulan - Tahun</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input required type="text" class="form-control" id="potongan" value="<?php echo $tampil['potongan']; ?>" name="potongan" placeholder="Potongan">
                                <label for="potongan">Potongan (Rp)</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input required type="text" class="form-control" id="bonus" value="<?php echo $tampil['bonus']; ?>" name="bonus" placeholder="Bonus">
                                <label for="bonus">Bonus (Rp)</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input required type="text" class="form-control" id="total_lembur" value="<?php echo $tampil['total_lembur']; ?>" name="total_lembur" placeholder="Total Lembut">
                                <label for="total_lembur">Total Lembur (Rp)</label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input required type="text" class="form-control" id="total" value="<?php echo $tampil['total']; ?>" name="total" placeholder="total">
                                <label for="total">Total (Rp)</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-floating">
                                <input required type="textarea" class="form-control" id="keterangan_potongan" value="<?php echo $tampil['keterangan_potongan']; ?>" name="keterangan_potongan" placeholder="Keterangan Potongan">
                                <label for="keterangan_potongan">Keterangan Potongan</label>
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
    $id =  $_POST['id'];
    $potongan = $_POST['potongan'];
    $bonus = $_POST['bonus'];
    $total_lembur = $_POST['total_lembur'];
    $total = $_POST['total'];
    $keterangan_potongan = $_POST['keterangan_potongan'];

    $potongan = str_replace(".", "", $potongan);
    $bonus = str_replace(".", "", $bonus);
    $total_lembur = str_replace(".", "", $total_lembur);
    $total = str_replace(".", "", $total);

    // Query untuk mengupdate data dalam tabel
    $sql = "UPDATE tb_payroll SET 
                potongan='$potongan', 
                bonus='$bonus', 
                total_lembur='$total_lembur',
                total='$total'
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
            alert('Data berhasil di Update');
            window.location.href = '?page=data_payroll';
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>