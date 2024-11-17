<?php
include 'koneksi.php';

if (isset($_POST['id'])) {
    $id_absen = $_POST['id'];

    $sql = $conn->query("SELECT * FROM tb_absen where id='$id_absen'");

    $tampil = $sql->fetch_assoc();
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
                    <h5 class="card-title">Approval Absensi Karyawan</h5>

                    <form method="POST" enctype="multipart/form-data" class="row g-3">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input readonly type="hidden" value="<?php echo $tampil['id']?>" class="form-control" name="id" placeholder="id" >
                                <input readonly type="date" value="<?php echo $tampil['tanggal_absen']?>" class="form-control" name="tanggal_absen" placeholder="Tanggal" >
                                <label for="tanggal_absen">Tanggal Sakit</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="col-md-12">Bukti Surat Sakit :</label>
                            <a readonly  href="<?php echo "./file_bukti/".$tampil["surat_sakit"]; ?>" target="_blank"><?php echo $tampil["surat_sakit"]; ?></a>
                        </div>

                        <div class="col-md-12">
                            <div class="form-floating">
                                <input readonly type="text" value="<?php echo $tampil['keterangan']?>" class="form-control" name="keterangan" placeholder="keterangan" >
                               
                                <label for="keterangan">Keterangan</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            Note : Surat Sakit yang asli tetap harus diberikan ke HR
                        </div>
                        
                        <div class="text-center">
                            <a onclick="return confirm('Approve Jadwal ?')" href="index.php?page=approve_absen&id_absen=<?php echo $tampil['id'] ?>" class="btn btn-success btn-sm"><i class="fa fa-fa-edit"></i> Approve</a>
                            <a onclick="return confirm('Reject Jadwal ?')" href="index.php?page=reject_absen&id_absen=<?php echo $tampil['id'] ?>" class="btn btn-danger btn-sm"><i class="fa fa-fa-edit"></i> Reject</a>
                        </div>
                    </form><!-- End floating Labels Form -->
                                  

                </div>
            </div>
        </div>
    </div>
</section>

