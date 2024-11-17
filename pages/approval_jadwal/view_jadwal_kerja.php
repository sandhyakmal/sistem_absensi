<?php
include 'koneksi.php';

if (isset($_POST['id_jadwal'])) {
    $id_jadwal = $_POST['id_jadwal'];

    // Ambil data utama dari `tb_jadwal`
    $sqlJadwal = "SELECT * FROM tb_jadwal WHERE id = '$id_jadwal'";
    $resultJadwal = $conn->query($sqlJadwal);
    $jadwalData = $resultJadwal->fetch_assoc();
    
    // Ambil data dari `tb_detail_jadwal` untuk detail shift
    $sqlDetail = "SELECT * FROM tb_jadwal_detail tjd LEFT JOIN tb_user tu on tjd.id_karyawan = tu.id WHERE id_jadwal = '$id_jadwal'";
    $resultDetail = $conn->query($sqlDetail);

    $sqlKaryawan = "SELECT id, name FROM tb_user WHERE role = 'karyawan'";
    $resultKaryawan = $conn->query($sqlKaryawan);
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
                    <h5 class="card-title">Detail Jadwal Kerja Karyawan</h5>

                    <form method="POST">
                        <!-- <input type="text" class="form-control" value="<?php echo $id_jadwal; ?>" id="id_jadwal" name="id_jadwal"> -->
                        
                        <!-- Pilihan Nama Karyawan -->

                        <div class="col-md-12">
                            <div class="form-floating">
                           
                            <input readonly type="date" id="tanggal_kerja" name="tanggal_kerja" class="form-control" 
                                value="<?php echo isset($jadwalData['tanggal_kerja']) ? $jadwalData['tanggal_kerja'] : ''; ?>">
                                <label for="date">Tanggal kerja</label>
                            </div>

                        </div>

                        <!-- Tabel Input Shift Kerja -->
                        <div class="col-md-12">
                            <h5 class="card-title">View Shift Kerja Karyawan</h5>
                            <table class="table" id="tabel-input">
                                <thead>
                                    <tr>
                                        <th>Nama Karyawan</th>
                                        <th>Shift Kerja</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($detail = $resultDetail->fetch_assoc()): ?>
                                        <tr>
                                            <td>
                                                <div class="col-md-12">
                                                    <select disabled class="form-select" name="iduser[]">
                                                        <?php
                                                        if ($resultKaryawan->num_rows > 0) {
                                                            // Reset pointer hasil query karyawan ke awal
                                                            $resultKaryawan->data_seek(0);
                                                            while($row = $resultKaryawan->fetch_assoc()) {
                                                                $selected = $row["id"] == $detail['id_karyawan'] ? "selected" : "";
                                                                echo '<option value="' . $row["id"] . '" ' . $selected . '>' . $row["name"] . '</option>';
                                                            }
                                                        } else {
                                                            echo '<option disabled>Tidak ada data karyawan</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="col-md-12">
                                                    <select disabled name="shift[]" class="form-select">
                                                        <option value="1" <?php echo $detail['shift'] == 1 ? 'selected' : ''; ?>>Shift 1 (13.00 - 18.00)</option>
                                                        <option value="2" <?php echo $detail['shift'] == 2 ? 'selected' : ''; ?>>Shift 2 (18.00 - 23.00)</option>
                                                    </select>
                                                </div>
                                            </td>
                                            <!-- <td><button type="button" class="btn btn-danger hapus-baris">Hapus</button></td> -->
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="text-center">
                            <a onclick="return confirm('Approve Jadwal ?')" href="index.php?page=approve_jadwal_kerja&id_jadwal=<?php echo $id_jadwal; ?>" class="btn btn-success btn-sm"><i class="fa fa-fa-edit"></i> Approve</a>
                            <a onclick="return confirm('Reject Jadwal ?')" href="index.php?page=reject_jadwal_kerja&id_jadwal=<?php echo $id_jadwal; ?>" class="btn btn-danger btn-sm"><i class="fa fa-fa-edit"></i> Reject</a>
                            <!-- <button type="button" id="tambah-baris" class="btn btn-info">Tambah Row</button>
                            <button type="submit" name="update" class="btn btn-primary">Update</button>
                            <button type="reset" class="btn btn-secondary">Reset</button> -->
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

