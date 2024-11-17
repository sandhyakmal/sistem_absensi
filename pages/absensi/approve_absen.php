<?php
// Menghubungkan ke database
include 'koneksi.php';
?>

<?php
$id_absen = $_GET['id_absen'];
$del = $conn->query("UPDATE tb_absen SET status = 'approve' WHERE id='$id_absen'");
?>
<script type="text/javascript">
    alert(" Data Berhasil di Approve");
    window.location.href = '?page=approval_absen';
</script>