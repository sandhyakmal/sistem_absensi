<?php
include 'koneksi.php';

$id_user =  $_SESSION['id'];

?>

<section class="section">
    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Laporan Gaji Karyawan</h5>

                    <!-- Floating Labels Form -->
                    <form action="./pages/laporan/pdf_laporan_payroll.php" target="_blank" method="POST" enctype="multipart/form-data" class="row g-3">

                        <div class="col-md-12">
                            <input type="hidden" class="form-control" value="<?php echo $id_user; ?>" id="id_karyawan" name="id_karyawan">
                            <select required class="form-select" name="bulan" aria-label="Floating label select example">
                                <option selected disabled value="">- Pilih Bulan -</option>
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