<?php
include '../koneksi.php';

if (isset($_POST['btnSimpan'])) {
    $nama_lengkap = $_POST['nama'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $negara = $_POST['negara'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

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
<html lang="id" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar - Flexilibrary</title>
  <link rel="icon" type="image/x-icon" href="../assets/img/favicon/log.ico" />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
  <link rel="stylesheet" href="../assets/vendor/css/core.css" />
  <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" />
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

            <h4 class="mb-2">Selamat Datang di Flexilibrary!</h4>
            <p class="mb-4">Silakan isi formulir di bawah ini untuk membuat akun Anda</p>

            <form class="mb-3" action="" method="POST" enctype="multipart/form-data">
              <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
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
                <label for="negara" class="form-label">Negara</label>
                <input type="text" class="form-control" name="negara" placeholder="Enter your country" required />
              </div>
              <div class="mb-3 form-password-toggle">
                <label class="form-label" for="password">Password</label>
                <div class="input-group input-group-merge">
                  <input type="password" id="password" class="form-control" name="password" placeholder="••••••••••" required />
                  <span class="input-group-text cursor-pointer" onclick="togglePasswordVisibility()">
                    <i class="bx bx-hide" id="togglePasswordIcon"></i>
                  </span>
                </div>
              </div>
              <button name="btnSimpan" class="btn btn-primary d-grid w-100">Buat Sekarang</button>
            </form>

            <p class="text-center">
              <span>Sudah punya akun?</span>
              <a href="index.php"><span>Login Sekarang</span></a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    function togglePasswordVisibility() {
      const passwordInput = document.getElementById('password');
      const icon = document.getElementById('togglePasswordIcon');

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('bx-hide');
        icon.classList.add('bx-show');
      } else {
        passwordInput.type = 'password';
        icon.classList.remove('bx-show');
        icon.classList.add('bx-hide');
      }
    }
  </script>

  <script src="../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../assets/vendor/libs/popper/popper.js"></script>
  <script src="../assets/vendor/js/bootstrap.js"></script>
  <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../assets/vendor/js/menu.js"></script>
  <script src="../assets/js/main.js"></script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>
