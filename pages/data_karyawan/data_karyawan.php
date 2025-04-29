<?php
// Menghubungkan ke database
include 'koneksi.php';

?>

<div class="pagetitle">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item active">Data Karyawan</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        Data Karyawan
                        &nbsp; | &nbsp;
                        <?php
                           if ($role != 'karyawan') { 
                        ?>
                        <a href="index.php?page=tambah_data_karyawan" class="btn btn-primary btn-sm"><i class="bi bi-plus">Tambah Data Karyawan</i></a>
                        <?php } ?>
                        <!-- &nbsp; | &nbsp;
                        <a href="#" class="btn btn-primary btn-sm"><i class="bi bi-printer"> Cetak Perencanaan Excel</i></a> -->

                    </h5>
                    <!-- Table with stripped rows -->
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <!-- <th>Salary</th>
                                <th>Upah Lembur</th> -->
                                <?php
                                  if ($role != 'karyawan') { 
                                ?>
                                <th>Aksi</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            if ($role == 'karyawan') {
                                $sql = $conn->query(" SELECT * FROM tb_user WHERE name = '$username' ");
                            } else {
                                $sql = $conn->query(" SELECT * FROM tb_user ");
                            }
                            // $sql = $conn->query(" SELECT * FROM tb_user ");
                            while ($data = $sql->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $data["name"] ?></td>
                                    <!-- <td><?php echo "Rp " . number_format($data["salary"], 0, ',', '.'); ?></td>
                                    <td><?php echo "Rp " . number_format($data["upah_lembur"], 0, ',', '.'); ?></td> -->
                                    <?php
                                           if ($role != 'karyawan') { 
                                        ?>
                                    <td>
                                       
                                        <form action="index.php?page=ubah_data_karyawan" method="POST" style="display:inline;">
                                            <input type="hidden" name="id_karyawan" value="<?php echo $data['id']; ?>">
                                            <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</button>
                                        </form>
                                        <!-- <a href="index.php?page=ubah_data_karyawan&id_karyawan=<?php echo $data['id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</a> -->

                                        <a onclick="return confirm('Ingin Menghapus data ?')" href="index.php?page=hapus_data_karyawan&id_karyawan=<?php echo $data['id'] ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</a>
                                       
                                    </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->

                </div>
            </div>

        </div>
    </div>
</section>