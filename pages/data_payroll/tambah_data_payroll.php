<?php
include 'koneksi.php';

$tahun = date("Y");
$potongan = 0;
$jumlah_tidak_in_or_out = 0;
$jumlah_tidak_in_and_out = 0;

if (isset($_POST['hitung'])) {

    $iduser = $_POST['iduser'];
    $bulan = $_POST['bulan'];
    // mengambil jumlah no in/out
    $sql_check_no_in_or_out = " SELECT COUNT(*) AS jumlah_no_in_or_out 
    FROM tb_absensi 
    WHERE MONTH(tanggal_kerja) = '$bulan' 
    AND YEAR(tanggal_kerja) = '$tahun' 
    AND (jam_in IS NULL OR jam_out IS NULL) 
    AND id_karyawan = '$iduser' "; 
    
    $result_no_in_or_out = $conn->query($sql_check_no_in_or_out);

    if ($result_no_in_or_out->num_rows > 0) {
        $row_no_in_or_out = $result_no_in_or_out->fetch_assoc();
        $jumlah_tidak_in_or_out = $row_no_in_or_out['jumlah_no_in_or_out']; 
    }   

    // mengambil jumlah no in dan no out
    $sql_check_no_in_and_out = "    SELECT COUNT(*) AS jumlah_no_in_and_out 
            FROM tb_jadwal_detail tjd
            LEFT JOIN tb_jadwal tj ON tj.id = tjd.id_jadwal
            LEFT JOIN tb_absensi ta ON ta.tanggal_kerja = tj.tanggal_kerja
            WHERE ta.tanggal_kerja IS NULL AND tjd.id_karyawan = '$iduser'
            AND MONTH(tj.tanggal_kerja) = '$bulan' 
            AND YEAR(tj.tanggal_kerja) = '$tahun'
        "; 
    $result_no_in_and_out = $conn->query($sql_check_no_in_and_out);
  

    if ($result_no_in_and_out->num_rows > 0) {
        $row_no_in_and_out = $result_no_in_and_out->fetch_assoc();
        $jumlah_tidak_in_and_out = $row_no_in_and_out['jumlah_no_in_and_out'];   
    }

     // Mengambil gaji pokok karyawan dari tabel tb_user
    $sql_gaji = "SELECT CAST(salary AS DECIMAL(15,2)) as gaji_pokok FROM tb_user WHERE id = '$iduser'";
    $result_gaji = $conn->query($sql_gaji);
    $gaji_pokok = 0;
    if ($result_gaji->num_rows > 0) {
        $row_gaji = $result_gaji->fetch_assoc();
        $gaji_pokok = (float) $row_gaji['gaji_pokok'];
    }

    // PERHITUNGAN POTONGAN NO IN OR NO OUT  
    $potongan_no_in_or_out = 0;
    if ($jumlah_tidak_in_or_out >= 3 && $jumlah_tidak_in_or_out <= 5) {
    $potongan_no_in_or_out = $gaji_pokok * 0.10; // 10%
    } elseif ($jumlah_tidak_in_or_out > 5 && $jumlah_tidak_in_or_out <= 10) {
    $potongan_no_in_or_out = $gaji_pokok * 0.25; // 25%
    } elseif ($jumlah_tidak_in_or_out > 10) {
    $potongan_no_in_or_out = $gaji_pokok * 0.40; // 40%
    }

    // PERHITUNGAN POTONGAN NO IN AND NO OUT  
    $potongan_no_in_and_out = 0;
    if ($jumlah_tidak_in_and_out =  1) {
    $potongan_no_in_and_out = $gaji_pokok * 0.10; // 10%
    } elseif ($jumlah_tidak_in_and_out = 2) {
    $potongan_no_in_and_out = $gaji_pokok * 0.30; // 30%
    } elseif ($jumlah_tidak_in_and_out >= 3) {
    $potongan_no_in_and_out = $gaji_pokok * 1; // 100%
    }

    $potongan = (float) $potongan_no_in_or_out + $potongan_no_in_and_out;

}


if (isset($_POST['submit'])) {
    // Mengambil input dari form
    $iduser = $_POST['iduser'];
    $bulan = $_POST['bulan'];
    $potongan = $_POST['potongan'];
    $keterangan_potongan = $_POST['keterangan_potongan'];
    $bonus = $_POST['bonus'];

    $potongan = str_replace(".", "", $potongan);
    $bonus = str_replace(".", "", $bonus);
    
    echo " ID USER  ".$iduser."<br>"; 
    echo " Bulan  ".$bulan."<br>"; 
    echo " potongan  ".$potongan."<br>"; 

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
        // echo $potongan = (float) $potongan;
        // echo $bonus = (float) $bonus;
        // echo $gaji_pokok;
        
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
                            <select required class="form-select" name="iduser" id="iduser" aria-label="Floating label select example">
                                <option selected disabled value="">Pilih Nama Karyawan</option>
                                <?php
                                $sql_user = "SELECT * FROM tb_user WHERE role = 'karyawan'";
                                $result = $conn->query($sql_user);

                                if ($result->num_rows > 0) {
                                    // Loop setiap row dan tambahkan sebagai option
                                    while ($row = $result->fetch_assoc()) {
                                        // Cek apakah iduser sama dengan id karyawan di row saat ini
                                        $selected = (isset($_POST['iduser']) && $_POST['iduser'] == $row["id"]) ? 'selected' : '';
                                        echo '<option value="' . $row["id"] . '" ' . $selected . '>' . $row["name"] . '</option>';
                                    }
                                } else {
                                    echo '<option disabled>Tidak ada data</option>';
                                }
                                ?>
                            </select>
                        </div>


                        <div class="col-md-10">
                            <!-- <input type="text" class="form-control" id="onBulan" name="onBulan" placeholder="onBulan"> -->
                            <select required class="form-select" id="bulan" name="bulan" aria-label="Floating label select example">
                                <?php
                                    $bulan_array = [
                                        1 => "Januari", 2 => "Februari", 3 => "Maret", 4 => "April",
                                        5 => "Mei", 6 => "Juni", 7 => "Juli", 8 => "Agustus",
                                        9 => "September", 10 => "Oktober", 11 => "November", 12 => "Desember"
                                    ];
                                    foreach ($bulan_array as $key => $value) {
                                        $selected = (isset($_POST['bulan']) && $_POST['bulan'] == $key) ? 'selected' : '';
                                        echo "<option value=\"$key\" $selected>$value</option>";
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <div class="form-floating">
                                <button type="submit" name="hitung" class="btn btn-info">Hitung Potongan</button>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-floating">
                                <input readonly type="text" class="form-control" value="<?php echo isset($_POST['hitung']) ? $jumlah_tidak_in_or_out:''; ?>" placeholder="Jumlah Tidak IN / OUT per-Bulan">
                                <label for="potongna">Jumlah Tidak IN / OUT per-Bulan </label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-floating">
                                <input readonly type="text" class="form-control"  value="<?php echo isset($_POST['hitung']) ? $jumlah_tidak_in_and_out:''; ?>"  placeholder="Jumlah Tidak IN & OUT per-Bulan">
                                <label for="potongna">Jumlah Tidak IN & OUT per-Bulan</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-floating">
                                <input readonly type="text" class="form-control" id="potongan" value="<?php echo isset($_POST['hitung']) ? $potongan : ''; ?>"  name="potongan" placeholder="Potongan">
                                <label for="potongna">Potongan (Rp)</label>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="bonus" name="bonus" placeholder="Bonus">
                                <label for="bonus">Bonus (Rp)</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-floating">
                                <textarea class="form-control" name="keterangan_potongan" placeholder="Leave a comment here" id="floatingTextarea" style="height: 100px;"></textarea>
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