<?php
// koneksi.php
$conn = new mysqli("localhost", "root", "root", "db_hris");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
