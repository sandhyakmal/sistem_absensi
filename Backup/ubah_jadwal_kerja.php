<?php
include 'koneksi.php';

if (isset($_POST['id_jadwal'])) {
    $id_jadwal = $_POST['id_jadwal'];

    // Ambil data utama dari `tb_jadwal`
    $sqlJadwal = "SELECT * FROM tb_jadwal WHERE id = '$id_jadwal'";
    $resultJadwal = $conn->query($sqlJadwal);
    $jadwalData = $resultJadwal->fetch_assoc();
    
    // Ambil data dari `tb_detail_jadwal` untuk detail shift
    $sqlDetail = "SELECT * FROM tb_jadwal_detail WHERE id_jadwal = '$id_jadwal'";
    $resultDetail = $conn->query($sqlDetail);
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
                    <h5 class="card-title">Edit Jadwal Kerja Karyawan</h5>

                    <form method="POST">
                        <input type="hidden" class="form-control" value="<?php echo $id_jadwal; ?>" id="id_jadwal" name="id_jadwal">
                        
                        <!-- Pilihan Nama Karyawan -->
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="floatingSelect" name="iduser" aria-label="Floating label select example">
                                    <?php
                                    $sql_user = "SELECT * FROM tb_user WHERE role = 'karyawan'";
                                    $result = $conn->query($sql_user);

                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            $selected = $row["id"] == $jadwalData['id_user'] ? "selected" : "";
                                            echo '<option value="' . $row["id"] . '" ' . $selected . '>' . $row["name"] . '</option>';
                                        }
                                    } else {
                                        echo '<option disabled>Tidak ada data</option>';
                                    }
                                    ?>
                                </select>
                                <label for="floatingSelect">Pilih Nama Karyawan</label>
                            </div>
                        </div>

                        <!-- Tabel Input Shift Kerja -->
                        <div class="col-md-12">
                            <h5 class="card-title">Edit Shift Kerja Karyawan</h5>
                            <table class="table" id="tabel-input">
                                <thead>
                                    <tr>
                                        <th>Hari</th>
                                        <th>Shift Kerja</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($detail = $resultDetail->fetch_assoc()): ?>
                                        <tr>
                                            <td><input type="date" class="form-control" name="hari[]" value="<?php echo $detail['hari']; ?>" placeholder="Hari Kerja"></td>
                                            <td>
                                                <div class="col-md-12">
                                                    <select name="shift[]" class="form-select">
                                                        <option value="1" <?php echo $detail['shift'] == 1 ? 'selected' : ''; ?>>Shift 1 (13.00 - 18.00)</option>
                                                        <option value="2" <?php echo $detail['shift'] == 2 ? 'selected' : ''; ?>>Shift 2 (18.00 - 23.00)</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td><button type="button" class="btn btn-danger hapus-baris">Hapus</button></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="text-center">
                            <button type="button" id="tambah-baris" class="btn btn-info">Tambah Row</button>
                            <button type="submit" name="update" class="btn btn-primary">Update</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id_jadwal = $_POST['id_jadwal'];
    $iduser = $_POST['iduser'];
    $hariArr = $_POST['hari'];
    $shiftArr = $_POST['shift'];

    // Update data di tb_jadwal
    $sqlUpdateJadwal = "UPDATE tb_jadwal SET id_user = '$iduser' WHERE id = '$id_jadwal'";
    if ($conn->query($sqlUpdateJadwal) === TRUE) {
        
        // Hapus data lama di tb_detail_jadwal untuk id_jadwal ini
        $sqlDeleteDetail = "DELETE FROM tb_jadwal_detail WHERE id_jadwal = '$id_jadwal'";
        $conn->query($sqlDeleteDetail);

        // Pastikan array 'hari' dan 'shift' memiliki jumlah elemen yang sama
        if (count($hariArr) === count($shiftArr) && !in_array("", $shiftArr)) {
            $allInserted = true;

            // Loop setiap pasangan hari dan shift untuk disimpan di tb_jadwal_detail
            for ($i = 0; $i < count($hariArr); $i++) {
                $hari = $hariArr[$i];
                $shift = $shiftArr[$i];

                // Insert ke tb_jadwal_detail
                $sqlDetail = "INSERT INTO tb_jadwal_detail (id_jadwal, hari, shift) VALUES ('$id_jadwal', '$hari', '$shift')";

                if ($conn->query($sqlDetail) !== TRUE) {
                    $allInserted = false;
                    echo "Error: " . $sqlDetail . "<br>" . $conn->error;
                    break;
                }
            }

            if ($allInserted) {
                echo "<script>
                    alert('Data berhasil diupdate');
                    window.location.href = '?page=jadwal_kerja';
                </script>";
            }
        } else {
            echo "Data tidak valid: jumlah hari dan shift tidak sesuai.";
        }
    } else {
        echo "Error: " . $sqlUpdateJadwal . "<br>" . $conn->error;
    }
}
?>
