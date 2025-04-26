<?php
session_start();
include 'koneksi.php';

$office_lat = -7.643844; // Ganti dengan latitude kantor
$office_lon = 112.895916; // Ganti dengan longitude kantor

function calculateDistance($lat1, $lon1, $lat2, $lon2) {
  $earth_radius = 6371000; // Radius bumi dalam meter

  $lat1 = is_numeric($lat1) ? $lat1 : 0;
  $lon1 = is_numeric($lon1) ? $lon1 : 0;
  $lat2 = is_numeric($lat2) ? $lat2 : 0;
  $lon2 = is_numeric($lon2) ? $lon2 : 0;

  // Konversi derajat ke radian
  $lat1 = deg2rad($lat1);
  $lon1 = deg2rad($lon1);
  $lat2 = deg2rad($lat2);
  $lon2 = deg2rad($lon2);

  // Rumus Haversine
  $dlat = $lat2 - $lat1;
  $dlon = $lon2 - $lon1;

  $a = sin($dlat / 2) * sin($dlat / 2) +
       cos($lat1) * cos($lat2) *
       sin($dlon / 2) * sin($dlon / 2);

  $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

  $distance = $earth_radius * $c;
  return round($distance, 2); // Jarak dalam meter (dibulatkan)
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $user_lat = $_POST['latitude'] ?? null;
  $user_lon = $_POST['longitude'] ?? null;

  // Pastikan nilai valid (numeric), jika tidak, set default ke 0
  $user_lat = is_numeric($user_lat) ? $user_lat : 0;
  $user_lon = is_numeric($user_lon) ? $user_lon : 0;

  // Hitung jarak
  $distance = calculateDistance($office_lat, $office_lon, $user_lat, $user_lon);

  // Jika jarak lebih dari 500 meter, set jarak default ke 1000 meter
  if ($distance > 500) {
      $distance = 1000;
  }

  $sql = "SELECT * FROM tb_user WHERE name='$username' AND password='$password'";
  $result = $conn->query($sql);

  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $_SESSION['role'] = $row['role'];
    $_SESSION['id'] = $row['id'];
    $_SESSION['username'] = $row['name'];

    $_SESSION['latitude'] = $user_lat; // Simpan latitude ke session
    $_SESSION['longitude'] = $user_lon; // Simpan longitude ke session
    $_SESSION['distance'] = $distance; // Simpan jarak ke session

    
    header("Location: index.php?page=dashboard");
    exit();
  } else {
    echo "<script>
    alert('Username atau Password Salah');
    </script>";
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>HRIS</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/awanbrew.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- <style>
    body {
      background-image: url('assets/img/logo_atr.png');
      /* Ganti 'path_to_your_background_image.jpg' dengan path gambar latar belakang yang kamu inginkan */
      background-size: cover;
      background-position: center;
    }
  </style> -->


  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Mar 17 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/awanbrew.png" alt="">
                  <span class="d-none d-lg-block">HRIS</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your username & password to login</p>
                  </div>

                  <form method="POST" class="row g-3 needs-validation" novalidate>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <input type="hidden" name="latitude" class="form-control" id="latitude" >
                        <input type="hidden"  name="longitude" class="form-control" id="longitude" >
                        <input type="text" name="username" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter your username.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                  </form>

                </div>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          function (position) {
            document.getElementById("latitude").value = position.coords.latitude;
            document.getElementById("longitude").value = position.coords.longitude;
          },
          function (error) {
            alert("Lokasi tidak dapat diakses. Izinkan akses lokasi pada browser.");
          }
        );
      } else {
        alert("Geolocation tidak didukung oleh browser ini.");
      }
    });
  </script>

</body>

</html>