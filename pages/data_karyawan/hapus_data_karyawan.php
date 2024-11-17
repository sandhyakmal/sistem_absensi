<?php
// Menghubungkan ke database
include 'koneksi.php';
?>

<?php
$id_karyawan = $_GET['id_karyawan'];
$del = $conn->query("DELETE FROM tb_user WHERE id='$id_karyawan'");
?>
<script type="text/javascript">
    alert(" Data Berhasil di Hapus");
    window.location.href = '?page=data_karyawan';
</script>