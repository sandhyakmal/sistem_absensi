<?php
// Menghubungkan ke database
include 'koneksi.php';

?>

<div class="pagetitle">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item active">Approval Absensi</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        Approval Absensi Karyawan
                    </h5>
                    <!-- Table with stripped rows -->
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Tanggal Absen</th>
                                <!-- <th>Surat Sakit</th> -->
                                <th>Pengajuan</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $sql = $conn->query(" SELECT ta.*, tu.name FROM tb_absen ta LEFT JOIN tb_user tu ON ta.id_karyawan = tu.id WHERE status = 'submit' ");
                            while ($data = $sql->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $data["name"];  ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($data["tanggal_absen"]));  ?></td>
                                    <!-- <td><a href="<?php echo "./file_bukti/".$data["surat_sakit"]; ?>" target="_blank"><?php echo $data["surat_sakit"]; ?></a></td> -->
                                    <td><?php echo $data["type_absen"];  ?></td>
                                    <td><?php echo $data["keterangan"];  ?></td>
                                    <td>
                                        <form action="index.php?page=view_absen" method="POST" style="display:inline;">
                                            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                                            <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Approval </button>
                                        </form>
                                        <!-- <a onclick="return confirm('Approve Karyawan ?')" href="index.php?page=approve_jadwal_kerja&id_jadwal=<?php echo $data['id'] ?>" class="btn btn-success btn-sm"><i class="fa fa-fa-edit"></i> Approve</a>
                                        <a onclick="return confirm('Reject Karyawan ?')" href="index.php?page=reject_jadwal_kerja&id_jadwal=<?php echo $data['id'] ?>" class="btn btn-danger btn-sm"><i class="fa fa-fa-edit"></i> Reject</a> -->
                                    </td>
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