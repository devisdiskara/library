<?php
include '../koneksi.php';

if (isset($_POST['btnSimpan'])) {
    $nama_lengkap = $_POST['nama'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $negara = $_POST['negara'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Mengupload profil gambar
    $profile = $_FILES['profile']['name'];
    $target_dir = "../assets/img/profile/";
    $target_file = $target_dir . basename($profile);
    move_uploaded_file($_FILES['profile']['tmp_name'], $target_file);

    $cek_username = mysqli_query($koneksi, "SELECT username FROM pengguna WHERE username = '$username'");

    if (mysqli_num_rows($cek_username) > 0) {
        echo "<script>alert('Username sudah digunakan')</script>";
    } else {
        $simpan = mysqli_query($koneksi, "INSERT INTO pengguna (nama_pengguna, email, username, negara, profile, kata_sandi) VALUES ('$nama_lengkap','$email','$username','$negara','$profile','$password')");

        if ($simpan) {
            echo "<script>alert('Data akun anda berhasil dibuat'); document.location='index.php';</script>";
        } else {
            echo "<script>alert('Data akun anda gagal dibuat')</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template-free">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Register - Flexilibrary</title>
  <meta name="description" content="" />
  <link rel="icon" type="image/x-icon" href="../assets/img/favicon/log.ico" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
  <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../assets/css/demo.css" />
  <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />
  <script src="../assets/vendor/js/helpers.js"></script>
  <script src="../assets/js/config.js"></script>
</head>

<body>
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <div class="card">
          <div class="card-body">
            <div class="app-brand justify-content-center">
              <a href="index.php" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">
                  <img src="../assets/img/favicon/log.ico" alt="Logo" width="50" height="50">
                </span>
                <span class="app-brand-text demo text-body fw-bolder" style="font-size: 24px;">
                  <span style="font-size: 30px; text-transform: capitalize;">F</span>lexilibrary
                </span>
              </a>
            </div>
            <h4 class="mb-2">Welcome To Flexilibrary!</h4>
            <p class="mb-4">Please fill out the form below to create your account</p>

            <form class="mb-3" action="" method="POST" enctype="multipart/form-data">
              <div class="mb-3">
                <label for="nama" class="form-label">Full Name</label>
                <input type="text" class="form-control" name="nama" placeholder="Enter your full name" autofocus required />
              </div>
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" placeholder="Enter your Username" required />
              </div>
              <div class="mb-3">
                <label for="profile" class="form-label">Profile</label>
                <input type="file" class="form-control" name="profile" required />
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Enter your Email" required />
              </div>
              <div class="mb-3">
                <label for="negara" class="form-label">Country</label>
                <input type="text" class="form-control" name="negara" placeholder="Enter your country" required />
              </div>
              <div class="mb-3 form-password-toggle">
                <label class="form-label" for="password">Password</label>
                <div class="input-group input-group-merge">
                  <input type="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>
              <button name="btnSimpan" class="btn btn-primary d-grid w-100">Sign up</button>
            </form>

            <p class="text-center">
              <span>Already have an account?</span>
              <a href="index.php">
                <span>Login now</span>
              </a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="buy-now">
    <a href="https://themeselection.com/products/sneat-bootstrap-html-admin-template/" target="_blank" class="btn btn-danger btn-buy-now">Upgrade to Pro</a>
  </div>

  <script src="../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../assets/vendor/libs/popper/popper.js"></script>
  <script src="../assets/vendor/js/bootstrap.js"></script>
  <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../assets/vendor/js/menu.js"></script>
  <script src="../assets/js/main.js"></script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>
</html>
