<?php
// Menghubungkan ke database
include 'koneksi.php';
?>

<?php
$id_jadwal = $_GET['id_jadwal'];
$del = $conn->query("UPDATE tb_jadwal SET status = 'approve' WHERE id='$id_jadwal'");
?>
<script type="text/javascript">
    alert(" Data Berhasil di Approve");
    window.location.href = '?page=approval_jadwal_kerja';
</script>