<?php
// Menghubungkan ke database
include 'koneksi.php';

?>

<div class="pagetitle">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item active">Approval Jadwal Kerja</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        Approval Jadwal Kerja Karyawan
                    </h5>
                    <!-- Table with stripped rows -->
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal Kerja</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $sql = $conn->query(" SELECT * FROM tb_jadwal WHERE status = 'submit' ");
                            while ($data = $sql->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo date("d/m/Y", strtotime($data["tanggal_kerja"]));  ?></td>
                                    <td>
                                        <form action="index.php?page=view_jadwal_kerja" method="POST" style="display:inline;">
                                            <input type="hidden" name="id_jadwal" value="<?php echo $data['id']; ?>">
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