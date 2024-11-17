<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $iduser = $_POST['iduser'];
    $hariArr = $_POST['hari'];
    $shiftArr = $_POST['shift'];
    // Pastikan array 'hari' dan 'shift' memiliki jumlah elemen yang sama
    if (count($hariArr) === count($shiftArr) && !in_array("", $shiftArr)) {
        $allInserted = true; // Flag untuk mengecek keberhasilan insert

        // Insert data ke tb_jadwal terlebih dahulu
        $sqlJadwal = "INSERT INTO tb_jadwal (id_user, status) VALUES ('$iduser', 'submit')";
        
        if ($conn->query($sqlJadwal) === TRUE) {
            // Dapatkan ID dari insert terakhir di tb_jadwal
            $jadwalId = $conn->insert_id;

            // Loop setiap pasangan hari dan shift untuk disimpan di tb_detail_jadwal
            for ($i = 0; $i < count($hariArr); $i++) {
                $hari = $hariArr[$i];
                $shift = $shiftArr[$i];

                // Buat query insert untuk setiap baris detail jadwal
                $sqlDetail = "INSERT INTO tb_jadwal_detail (id_jadwal, hari, shift) 
                              VALUES ('$jadwalId', '$hari', '$shift')";

                // Jalankan query dan cek apakah berhasil
                if ($conn->query($sqlDetail) !== TRUE) {
                    $allInserted = false;
                    echo "Error: " . $sqlDetail . "<br>" . $conn->error;
                    break; // Hentikan jika ada yang gagal
                }
            }

            // Tampilkan pesan sukses atau error
            if ($allInserted) {
                echo "<script>
                    alert('Data berhasil ditambahkan');
                    window.location.href = '?page=jadwal_kerja';
                </script>";
            }
        } else {
            // Jika insert ke tb_jadwal gagal
            echo "Error: " . $sqlJadwal . "<br>" . $conn->error;
        }
    } else {
        echo "Data tidak valid: jumlah hari dan shift tidak sesuai.";
    }
}
?>


<section class="section">
    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Tambah Jadwal Kerja Karyawan</h5>

                    <!-- Floating Labels Form -->
                    <form method="POST" enctype="multipart/form-data" class="row g-3">

                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <select required class="form-select" id="floatingSelect" name="iduser" aria-label="Floating label select example">
                                    <option selected disabled value="">Pilih salah satu</option>
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
                                <label for="floatingSelect">Pilih Nama Karyawan</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <h5 class="card-title">
                                Tambah Shift Kerja Karyawan
                            </h5>
                            <table class="table" id="tabel-input">
                                <thead>
                                    <tr>
                                        <th>Tanggal Kerja</th>
                                        <th>Shift Kerja</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td><input type="date" class="form-control" id="name" name="hari[]" placeholder="Hari Kerja"></td>
                                            <td>
                                                <div class="col-md-12">
                                                    <select name="shift[]" class="form-select">
                                                        <option value="" disabled selected>- Pilih Shift Kerja -</option>
                                                        <option value="1">Shift 1 (13.00 - 18.00)</option>
                                                        <option value="2">Shift 2 (18.00 - 23.00)</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <div class="col-md-4">
                                            <td> <button type="button" id="hapus-baris" class="btn btn-danger">Hapus</button></td>
                                            </div>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                
                        <div class="text-center">
                            <button type="button" id="tambah-baris" class="btn btn-info">Tambah Row</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</section>