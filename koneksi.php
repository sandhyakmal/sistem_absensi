<?php
// koneksi.php
$conn = new mysqli("localhost", "root", "root", "db_hris_btn");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
