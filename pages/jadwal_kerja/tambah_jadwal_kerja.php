<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tanggal_kerja = $_POST['tanggal_kerja'];
    $iduserArr = isset($_POST['iduser']) && is_array($_POST['iduser']) ? $_POST['iduser'] : [];
    $shiftArr = isset($_POST['shift']) && is_array($_POST['shift']) ? $_POST['shift'] : [];


    $sql_check_jadwal = $conn->query(" SELECT * FROM tb_jadwal WHERE tanggal_kerja = '$tanggal_kerja' ");

    if ($sql_check_jadwal->num_rows > 0) {
        echo "<script>
            alert('Data Jadwal Kerja sudah ada');
              window.location.href = '?page=jadwal_kerja';
        </script>";
        exit;
    }

    // Pastikan array 'iduser' dan 'shift' memiliki jumlah elemen yang sama
    if (count($iduserArr) === count($shiftArr) && !in_array("", $shiftArr)) {
        $allInserted = true; // Flag untuk mengecek keberhasilan insert

        // Insert data ke tb_jadwal terlebih dahulu
        $sqlJadwal = "INSERT INTO tb_jadwal (tanggal_kerja, status) VALUES ('$tanggal_kerja', 'submit')";
        
        if ($conn->query($sqlJadwal) === TRUE) {
            // Dapatkan ID dari insert terakhir di tb_jadwal
            $jadwalId = $conn->insert_id;

            // Loop setiap pasangan iduser dan shift untuk disimpan di tb_detail_jadwal
            for ($i = 0; $i < count($iduserArr); $i++) {
                $currentUser = $iduserArr[$i]; // gunakan variabel baru
                $shift = $shiftArr[$i];

                // Buat query insert untuk setiap baris detail jadwal
                $sqlDetail = "INSERT INTO tb_jadwal_detail (id_jadwal, id_karyawan, shift) VALUES ('$jadwalId', '$currentUser', '$shift')";
                
                // Jalankan query dan cek apakah berhasil
                if ($conn->query($sqlDetail) !== TRUE ) {
                    $allInserted = false;
                    echo "Error: " . $sqlDetail . "<br>" . $conn->error;
                    break; // Hentikan jika ada yang gagal
                }

                $sqlAbsensi = "INSERT INTO tb_absensi (id_jadwal, tanggal_kerja, id_karyawan) VALUES ('$jadwalId','$tanggal_kerja', '$currentUser')";

                if ($conn->query($sqlAbsensi) !== TRUE ) {
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
        echo "Data tidak valid: jumlah karyawan dan shift tidak sesuai atau ada shift yang tidak dipilih.";
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
                    <form method="POST" enctype="multipart/form-data" class="row g-3" onsubmit="return validateForm()">

                        <div class="col-md-12">
                            <div class="form-floating">
                                <input required type="date" class="form-control" id="tanggal_kerja" name="tanggal_kerja" placeholder="Tanggal kerja">
                                <!-- <input type="text" class="form-control" id="datetimeInput" name="tanggal_kerja" placeholder="Tanggal kerja"> -->
                                <label for="date">Tanggal kerja</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <h5 class="card-title">
                                Tambah Shift Kerja Karyawan
                            </h5>
                            <table class="table" id="tabel-input">
                                <thead>
                                    <tr>
                                        <th>Nama Karyawan</th>
                                        <th>Shift Kerja</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td>
                                                
                                                <div class="col-md-12">
                                                    <select required class="form-select" name="iduser[]" aria-label="Floating label select example">
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
                                            </td>
                                            <td>
                                                <div class="col-md-12">
                                                    <select required name="shift[]" class="form-select">
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