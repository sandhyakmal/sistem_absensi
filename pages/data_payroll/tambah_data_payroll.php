<?php
include 'koneksi.php';

if (isset($_POST['submit'])) {
    // Mengambil input dari form
    $iduser = $_POST['iduser'];
    $bulan = $_POST['bulan'];
    $potongan = $_POST['potongan'];
    $keterangan_potongan = $_POST['keterangan_potongan'];
    $bonus = $_POST['bonus'];

    $potongan = str_replace(".", "", $potongan);
    $bonus = str_replace(".", "", $bonus);
    

    // Mengambil tahun saat ini
    $tahun = date("Y");

    // Mengecek apakah data sudah ada di tabel tb_payroll
    $sql_check = "SELECT * FROM tb_payroll WHERE id_karyawan = '$iduser' AND bulan_payroll = '$bulan' AND YEAR(CURDATE()) = '$tahun'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        echo "<script>
                alert('Data payroll untuk karyawan ini pada bulan dan tahun yang dipilih sudah ada. Tidak bisa menambahkan data duplikat.');
            </script>";
    } else {
        // Mengambil gaji pokok karyawan dari tabel tb_user
        $sql_gaji = "SELECT CAST(salary AS DECIMAL(15,2)) as gaji_pokok FROM tb_user WHERE id = '$iduser'";
        $result_gaji = $conn->query($sql_gaji);
        $gaji_pokok = 0;
        if ($result_gaji->num_rows > 0) {
            $row_gaji = $result_gaji->fetch_assoc();
            $gaji_pokok = (float) $row_gaji['gaji_pokok'];
        }

        // Mengambil total lembur dari tabel absensi menggunakan tanggal_kerja
        $sql_lembur = "SELECT CAST(SUM(CAST(upah_lembur AS DECIMAL(15,2))) AS DECIMAL(15,2)) as total_lembur 
                       FROM tb_absensi 
                       WHERE id_karyawan = '$iduser' 
                         AND MONTH(tanggal_kerja) = '$bulan' 
                         AND YEAR(tanggal_kerja) = '$tahun'";
        $result_lembur = $conn->query($sql_lembur);
        $lembur = 0;
        if ($result_lembur->num_rows > 0) {
            $row_lembur = $result_lembur->fetch_assoc();
            $lembur = (float) $row_lembur['total_lembur'];
        }

        // Mengonversi input potongan dan bonus menjadi float
        $potongan = (float) $potongan;
        $bonus = (float) $bonus;

        // Menghitung total gaji
        $total_gaji = $gaji_pokok + $lembur - $potongan + $bonus;

        // Insert data ke tabel tb_payroll
        $sql_insert = "INSERT INTO tb_payroll (id_karyawan, bulan_payroll, tahun_payroll, potongan,keterangan_potongan, bonus,total_lembur, total) 
                       VALUES ('$iduser', '$bulan','$tahun', '$potongan', '$keterangan_potongan', '$bonus', '$lembur', '$total_gaji')";

        if ($conn->query($sql_insert) === TRUE) {
            echo "<script>
                alert('Data berhasil ditambahkan');
                window.location.href = '?page=data_payroll';
            </script>";
        } else {
            echo "Gagal menyimpan data payroll: " . $conn->error;
        }
    }
}
?>

<section class="section">
    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Tambah Data Payroll Karyawan</h5>

                    <!-- Floating Labels Form -->
                    <form method="POST" enctype="multipart/form-data" class="row g-3">
                        <div class="col-md-12">
                            <select required class="form-select" name="iduser" aria-label="Floating label select example">
                                <option selected disabled value="">Pilih Nama Karyawan</option>
                                <?php
                                
                                $sql_user = "SELECT * FROM tb_user where role = 'karyawan' ";
                                $result = $conn->query($sql_user);

                                if ($result->num_rows > 0) {
                                    // Loop setiap row dan tambahkan sebagai option
                                    while($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row["id"] . '">' . $row["name"] . '</option>';
                                    }
                                } else {
                                    echo '<option disabled>Tidak ada data</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <select required class="form-select" name="bulan" aria-label="Floating label select example">
                                <option selected disabled value="">Pilih Bulan</option>
                                <option value="1">January</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input required type="text" class="form-control" id="potongan" name="potongan" placeholder="Potongan">
                                <label for="potongna">Potongan (Rp)</label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input required type="text" class="form-control" id="bonus" name="bonus" placeholder="Bonus">
                                <label for="bonus">Bonus (Rp)</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-floating">
                                <textarea required class="form-control" name="keterangan_potongan" placeholder="Leave a comment here" id="floatingTextarea" style="height: 100px;"></textarea>
                                <label for="keterangan">Keterangan Potongan</label>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form><!-- End floating Labels Form -->

                </div>
            </div>

        </div>
    </div>
</section>