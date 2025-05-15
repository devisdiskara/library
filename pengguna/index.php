<?php
// Include koneksi.php untuk menghubungkan ke database
include '../koneksi.php';

// Mulai sesi
session_start();

// Cek jika pengguna sudah login, maka arahkan ke dashboard
if (isset($_SESSION['login_pa'])) {
  header('location: page.php');
  exit;
}

// Proses login
if (isset($_POST['btnMasuk'])) {
  $username = $_POST['username'] ?? '';
  $kata_sandi = $_POST['kata_sandi'] ?? '';

  // Pengecekan untuk akun admin
  if ($username === 'admin' && $kata_sandi === 'X5&gR9@4Nz') {
    // Set session untuk admin
    $_SESSION['id_pengguna'] = 'admin_id'; // Set ID admin sesuai kebutuhan Anda
    $_SESSION['username'] = $username;
    $_SESSION['email'] = 'admin@domain.com'; // Set email admin sesuai kebutuhan Anda
    $_SESSION['login_pa'] = true;

    // Redirect ke halaman admin
    header('Location: ../admin/dashboard.php?page=home'); // Ganti dengan halaman admin yang sesuai
    exit;
  } else {
    // Pengecekan untuk akun pengguna biasa
    if (!empty($username) && !empty($kata_sandi)) {
      $data = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE username = '$username'");
      if (mysqli_num_rows($data) === 1) {
        $baris = mysqli_fetch_assoc($data);
        if (password_verify($kata_sandi, $baris['kata_sandi'])) {
          // Set session data
          $_SESSION['id_pengguna'] = $baris['id_pengguna'];
          $_SESSION['username'] = $baris['username'];
          $_SESSION['email'] = $baris['email'];
          $_SESSION['login_pa'] = true;

          // Redirect ke dashboard pengguna
          header('Location: page.php');
          exit;
        } else {
          echo "<script>alert('Username atau kata sandi Anda salah')</script>";
        }
      } else {
        echo "<script>alert('Username atau kata sandi Anda salah')</script>";
      }
    } else {
      echo "<script>alert('Harap isi username dan kata sandi')</script>";
    }
  }
}
?>


<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-aslog-path="aslog/" data-template="vertical-menu-template-free">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Login - Flexilibrary</title>
  <link rel="stylesheet" href="../aslog/vendor/fonts/boxicons.css" />
  <link rel="stylesheet" href="../aslog/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../aslog/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../aslog/css/demo.css" />
  <link rel="stylesheet" href="../aslog/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="../aslog/vendor/css/pages/page-auth.css" />
  <script src="../aslog/vendor/js/helpers.js"></script>
  <script src="../aslog/js/config.js"></script>
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
                  <img src="../assets/img/favicon/log.ico" alt="Logo" width="25" height="25">
                </span>
                <span class="app-brand-text demo text-body fw-bolder">Flexilibrary</span>
              </a>
            </div>
            <h4 class="mb-2">Welcome to Flexilibrary!</h4>
            <p class="mb-4">Please login to your account</p>
            <form id="formAuthentication" class="mb-3" action="" method="POST">
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username Anda" autofocus required>
              </div>
              <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <div class="input-group input-group-merge">
                  <input type="password" id="kata_sandi" class="form-control" name="kata_sandi" placeholder="Masukkan kata sandi Anda" required>
                  <span class="input-group-text cursor-pointer" id="togglePassword">
                    <i class="bx bx-hide"></i>
                  </span>
                </div>
              </div>
              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit" name="btnMasuk">Masuk</button>
              </div>
            </form>
            <p class="text-center">
              <span>Don't have an account yet?</span>
              <a href="daftar.php">
                <span>Register now</span>
              </a>
            </p>
            <p class="text-center">
              <a href="forgot_password.php">
                <span>Forgot your password?</span>
              </a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../aslog/vendor/libs/jquery/jquery.js"></script>
  <script src="../aslog/vendor/libs/popper/popper.js"></script>
  <script src="../aslog/vendor/js/bootstrap.js"></script>
  <script src="../aslog/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../aslog/vendor/js/menu.js"></script>
  <script src="../aslog/js/main.js"></script>

  <script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#kata_sandi');

    togglePassword.addEventListener('click', function (e) {
      // toggle the type attribute
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      
      // toggle the eye slash icon
      this.querySelector('i').classList.toggle('bx-hide');
      this.querySelector('i').classList.toggle('bx-show');
    });
  </script>
</body>
</html>

