<?php
include 'koneksi.php';

$id_user =  $_SESSION['id'];

?>

<section class="section">
    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Slip Gaji Karyawan</h5>

                    <!-- Floating Labels Form -->
                    <form action="./pages/slip/cetak_slip.php" target="_blank"  method="POST" enctype="multipart/form-data" class="row g-3">

                        <div class="col-md-12">
                            <input type="hidden" class="form-control" value="<?php echo $id_user; ?>" id="id_karyawan" name="id_karyawan">
                            <select required class="form-select" name="bulan" aria-label="Floating label select example">
                                <option selected disabled value="">Pilih Bulan</option>
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