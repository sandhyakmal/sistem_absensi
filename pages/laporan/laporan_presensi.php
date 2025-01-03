<?php
include 'koneksi.php';

$id_user =  $_SESSION['id'];

?>

<section class="section">
    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Laporan Presensi Karyawan</h5>

                    <!-- Floating Labels Form -->
                    <form action="./pages/laporan/pdf_laporan_presensi.php" target="_blank" method="POST" enctype="multipart/form-data" class="row g-3">

                        <div class="col-md-12">
                            <input type="hidden" class="form-control" value="<?php echo $id_user; ?>" id="id_karyawan" name="id_karyawan">
                            <select required class="form-select" name="bulan" aria-label="Floating label select example">
                                <option selected disabled value="">- Pilih Bulan -</option>
                                <option value="01">January</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <select required class="form-select" name="tahun" aria-label="Floating label select example">
                                <option selected disabled value="">- Pilih Tahun -</option>
                                <?php
                                    $currentYear = date("Y"); // Mendapatkan tahun saat ini
                                    $previousYear = $currentYear - 1; // Tahun sebelumnya

                                    // Menampilkan opsi tahun
                                    for ($year = $previousYear; $year <= $currentYear; $year++) {
                                        echo "<option value=\"$year\">$year</option>";
                                    }
                                ?>
                            </select>
                        </div>

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
                        
                        <div class="text-center">
                            <button target="_blank" type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form><!-- End floating Labels Form -->

                </div>
            </div>

        </div>
    </div>
</section>