<?php
// Menghubungkan ke database
include 'koneksi.php';

?>

<div class="pagetitle">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item active">Data Jadwal Kerja</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        Jadwal Kerja Karyawan
                        <?php
                            if ($_SESSION['role'] != 'karyawan') {
                        ?>
                            &nbsp; | &nbsp;
                            <a href="index.php?page=tambah_jadwal_kerja" class="btn btn-primary btn-sm"><i class="bi bi-plus">Jadwal Kerja</i></a>
                        <?php 
                            }
                        ?>
                        <!-- &nbsp; | &nbsp;
                        <a href="#" class="btn btn-primary btn-sm"><i class="bi bi-printer"> Cetak Perencanaan Excel</i></a> -->

                    </h5>
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal Kerja</th>
                                <?php
                                    if ($_SESSION['role'] == 'karyawan') {
                                ?>
                                <th>Shift Kerja</th>
                                <?php
                                    } 
                                ?>
                                <th>Status</th>
                                <?php
                                    if ($_SESSION['role'] != 'karyawan') {
                                ?>
                                <th>Aksi</th>
                                <?php
                                    }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $username = $_SESSION['username'];
                            $id_user =  $_SESSION['id'];
                            if ($_SESSION['role'] == 'admin') {
                                $sql = $conn->query(" SELECT * FROM tb_jadwal ");
                            }
                            else {
                                $sql = $conn->query(" SELECT * FROM tb_jadwal tj LEFT JOIN tb_jadwal_detail tjd ON tj.id = tjd.id_jadwal WHERE tjd.id_karyawan = '$id_user' AND tj.status = 'approve' ORDER BY tanggal_kerja ASC ");
                            }
                            while ($data = $sql->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($data["tanggal_kerja"]));  ?></td>

                                    <?php
                                        if ($_SESSION['role'] == 'karyawan') {
                                    ?>
                                    <td> 
                                        <?php if (isset($data["shift"]) && $data["shift"] == '1') { echo 'Shift 1 (13.00 - 18.00)'; } else { echo 'Shift 2 (18.00 - 23.00)'; } ?>
                                    </td>
                                    <?php
                                        }
                                    ?>

                                    <td>
                                        
                                        <?php if (isset($data["status"]) && $data["status"] == 'submit') {  ?>
                                             <span class="badge bg-info">On Progress Approval</span>
                                        <?php } else if (isset($data["status"]) && $data["status"] == 'reject') { ?> 
                                            <span class="badge bg-danger">Reject</span>
                                        <?php } else {?>
                                            <span class="badge bg-success">Approve</span>
                                        <?php } ?>
                                    </td>
                                   
                                    <?php
                                        if ($_SESSION['role'] != 'karyawan') {
                                    ?>
                                    <td>
                                        <form action="index.php?page=ubah_jadwal_kerja" method="POST" style="display:inline;">
                                            <input type="hidden" name="id_jadwal" value="<?php echo $data['id']; ?>">
                                            <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</button>
                                        </form>
                                        <!-- <a href="index.php?page=ubah_jadwal_kerja&id_jadwal=<?php echo $data['id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</a> -->

                                        <a onclick="return confirm('Ingin Menghapus data ?')" href="index.php?page=hapus_jadwal_kerja&id_jadwal=<?php echo $data['id'] ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</a>
                                    </td>
                                    <?php
                                        }
                                    ?>
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