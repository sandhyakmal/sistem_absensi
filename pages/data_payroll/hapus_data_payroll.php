<?php
// Menghubungkan ke database
include 'koneksi.php';

$id_payroll = $_GET['id_payroll'];
$del = $conn->query("DELETE FROM tb_payroll WHERE id='$id_payroll'");
?>

<script type="text/javascript">
    alert(" Data Berhasil di Hapus");
    window.location.href = '?page=data_payroll';
</script>