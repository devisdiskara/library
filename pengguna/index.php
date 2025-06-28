<?php
session_start();
require '../koneksi.php';

if (isset($_SESSION['login_pa'])) {
    header('Location: page.php');
    exit;
}

$error = '';

if (isset($_POST['btnMasuk'])) {
    $username = trim($_POST['username']);
    $password = $_POST['kata_sandi'];

    // 1. SUPER ADMIN (hardcoded)
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['login_pa'] = true;
        $_SESSION['role'] = 'super_admin';
        $_SESSION['username'] = 'admin';
        $_SESSION['foto'] = 'avatar.avif';
        header('Location: ../admin/dashboard.php');
        exit;
    }

    // 2. ADMIN dari database
    $adminQuery = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username'");
    if (mysqli_num_rows($adminQuery) === 1) {
        $admin = mysqli_fetch_assoc($adminQuery);
        if (password_verify($password, $admin['password'])) {
            $_SESSION['login_pa'] = true;
            $_SESSION['role'] = 'admin';
            $_SESSION['id_admin'] = $admin['id'];
            $_SESSION['username'] = $admin['username'];
            $_SESSION['foto'] = $admin['foto'];
            header('Location: ../admin/dashboard.php');
            exit;
        }
    }

    // 3. PENGGUNA
    $userQuery = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE username='$username'");
    if (mysqli_num_rows($userQuery) === 1) {
        $user = mysqli_fetch_assoc($userQuery);
        if (password_verify($password, $user['kata_sandi'])) {
            $_SESSION['login_pa'] = true;
            $_SESSION['role'] = 'pengguna';
            $_SESSION['id_pengguna'] = $user['id_pengguna'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['foto'] = $user['profile'];
            header('Location: page.php');
            exit;
        }
    }

    $error = "Username atau password salah!";
}
?>
<!DOCTYPE html>
<html lang="id" class="light-style customizer-hide" dir="ltr" data-theme="theme-default">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Flexilibrary</title>
  <link rel="icon" type="image/x-icon" href="../assets/img/favicon/log.ico" />
  <link rel="stylesheet" href="../aslog/vendor/fonts/boxicons.css" />
  <link rel="stylesheet" href="../aslog/vendor/css/core.css" />
  <link rel="stylesheet" href="../aslog/vendor/css/theme-default.css" />
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
            <h4 class="mb-2">Selamat datang di Flexilibrary!</h4>
            <p class="mb-4">Silakan masuk ke akun Anda</p>

            <?php if ($error): ?>
              <div class="alert alert-danger text-center" id="errorAlert">
                <?= htmlspecialchars($error) ?>
              </div>
            <?php endif; ?>

            <form class="mb-3" action="" method="POST">
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username Anda" autofocus required>
              </div>
              <div class="mb-3">
                <label class="form-label" for="kata_sandi">Password</label>
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
              <span>Belum punya akun?</span> <a href="daftar.php"><span>Buat akun sekarang</span></a>
            </p>
            <p class="text-center">
              <a href="lupa_password.php"><span>Lupa kata sandi Anda?</span></a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- JS & Interaksi -->
  <script src="../aslog/vendor/libs/jquery/jquery.js"></script>
  <script src="../aslog/vendor/libs/popper/popper.js"></script>
  <script src="../aslog/vendor/js/bootstrap.js"></script>
  <script src="../aslog/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../aslog/vendor/js/menu.js"></script>
  <script src="../aslog/js/main.js"></script>

  <script>
    // Toggle password
    const togglePassword = document.querySelector('#togglePassword');
    const passwordInput = document.querySelector('#kata_sandi');

    togglePassword.addEventListener('click', function () {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      this.querySelector('i').classList.toggle('bx-hide');
      this.querySelector('i').classList.toggle('bx-show');
    });

    // Auto-hide alert
    const errorAlert = document.getElementById('errorAlert');
    if (errorAlert) {
      setTimeout(() => {
        errorAlert.style.opacity = '0';
        setTimeout(() => errorAlert.remove(), 500);
      }, 3000);
    }
  </script>
</body>
</html>
