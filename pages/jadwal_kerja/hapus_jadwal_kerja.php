<?php
// Menghubungkan ke database
include 'koneksi.php';
?>

<?php
$id_jadwal = $_GET['id_jadwal'];
$del = $conn->query("DELETE FROM tb_jadwal WHERE id='$id_jadwal'");
$del_detail = $conn->query("DELETE FROM tb_jadwal_detail WHERE id_jadwal='$id_jadwal'");
?>
<script type="text/javascript">
    alert(" Data Berhasil di Hapus");
    window.location.href = '?page=jadwal_kerja';
</script>