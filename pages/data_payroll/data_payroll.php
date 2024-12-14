<?php
// Menghubungkan ke database
include 'koneksi.php';

?>

<div class="pagetitle">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item active">Data Payroll Karyawan</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        Data Payroll Karyawan
                        <?php
                            if ($_SESSION['role'] == 'owner') {
                        ?>
                        &nbsp; | &nbsp;
                        <a href="index.php?page=tambah_data_payroll" class="btn btn-primary btn-sm"><i class="bi bi-plus">Tambah Data Payroll</i></a>
                        <?php
                            }
                        ?>

                    </h5>
                    <!-- Table with stripped rows -->
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Bulan - Tahun</th>
                                <th>Potongan</th>
                                <th>Keterangan Potongan</th>
                                <th>Bonus</th>
                                <th>Total Lembur</th>
                                <th>Total Gaji</th>
                                <?php
                                    if ($_SESSION['role'] == 'owner') {
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
                            $id_user =  $_SESSION['id'];
                            if ($_SESSION['role'] == 'owner') {
                                $sql = $conn->query(" SELECT tp.*, tu.name FROM tb_payroll tp LEFT JOIN tb_user tu ON tp.id_karyawan = tu.id  ");
                            }
                            else {
                                $sql = $conn->query(" SELECT tp.*, tu.name FROM tb_payroll tp LEFT JOIN tb_user tu ON tp.id_karyawan = tu.id WHERE tp.id_karyawan = '$id_user'  ");
                            }
                            while ($data = $sql->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $data["name"] ?></td>
                                    <td><?php echo $data["bulan_payroll"] ." - " . $data["tahun_payroll"] ;  ?></td>
                                    <td><?php echo "Rp " . number_format($data["potongan"], 0, ',', '.'); ?></td>
                                    <td><?php echo $data["keterangan_potongan"]; ?></td>
                                    <td><?php echo "Rp " . number_format($data["bonus"], 0, ',', '.'); ?></td>
                                    <td><?php echo "Rp " . number_format($data["total_lembur"], 0, ',', '.'); ?></td>
                                    <td><?php echo "Rp " . number_format($data["total"], 0, ',', '.'); ?></td>
                                    <?php
                                        if ($_SESSION['role'] == 'owner') {
                                    ?>
                                     <td>
                                        <form action="index.php?page=ubah_data_payroll" method="POST" style="display:inline;">
                                            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                                            <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</button>
                                        </form>
                                        <!-- <a href="index.php?page=ubah_data_karyawan&id_karyawan=<?php echo $data['id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</a> -->

                                        <a onclick="return confirm('Ingin Menghapus data ?')" href="index.php?page=hapus_data_payroll&id_payroll=<?php echo $data['id'] ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</a>
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