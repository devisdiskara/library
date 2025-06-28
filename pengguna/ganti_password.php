<?php
session_start();
require '../koneksi.php';

if (!isset($_SESSION['reset_verified']) || !isset($_SESSION['reset_email'])) {
  echo "<script>alert('Sesi tidak valid');window.location='lupa_password.php';</script>";
  exit;
}

$email = $_SESSION['reset_email'];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $password1 = $_POST['password1'] ?? '';
  $password2 = $_POST['password2'] ?? '';

  if (strlen($password1) < 6) {
    $error = 'Password harus minimal 6 karakter.';
  } elseif ($password1 !== $password2) {
    $error = 'Password dan konfirmasi tidak cocok.';
  } else {
    $hashed = password_hash($password1, PASSWORD_DEFAULT);
    $query = mysqli_query($koneksi, "UPDATE pengguna SET kata_sandi='$hashed', reset_pin=NULL, pin_expiry=NULL WHERE email='$email'");

    if ($query) {
      unset($_SESSION['reset_email'], $_SESSION['reset_verified']);
      echo "<script>alert('Password berhasil diperbarui. Silakan login.');window.location='index.php';</script>";
      exit;
    } else {
      $error = 'Gagal menyimpan password. Coba lagi.';
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-template="vertical-menu-template-free">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ganti Password - Flexilibrary</title>
  <link rel="stylesheet" href="../aslog/vendor/fonts/boxicons.css">
  <link rel="stylesheet" href="../aslog/vendor/css/core.css">
  <link rel="stylesheet" href="../aslog/vendor/css/theme-default.css">
  <link rel="stylesheet" href="../aslog/css/demo.css">
  <link rel="stylesheet" href="../aslog/vendor/libs/perfect-scrollbar/perfect-scrollbar.css">
  <link rel="stylesheet" href="../aslog/vendor/css/pages/page-auth.css">
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

            <h4 class="mb-2">Ganti Password 🔒</h4>
            <p class="mb-4">Masukkan password baru Anda di bawah ini.</p>

            <?php if ($error): ?>
              <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" class="mb-3">
              <div class="mb-3">
                <label class="form-label" for="password1">Password Baru</label>
                <div class="input-group input-group-merge">
                  <input type="password" class="form-control" id="password1" name="password1" placeholder="Minimal 6 karakter" required>
                  <span class="input-group-text" onclick="togglePassword('password1', this)" style="cursor:pointer;">
                    <i class="bx bx-hide"></i>
                  </span>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label" for="password2">Ulangi Password</label>
                <div class="input-group input-group-merge">
                  <input type="password" class="form-control" id="password2" name="password2" placeholder="Ulangi password baru" required>
                  <span class="input-group-text cursor-pointer" onclick="togglePassword('password2', this)">
                    <i class="bx bx-hide"></i>
                  </span>
                </div>
              </div>

              <button type="submit" class="btn btn-primary d-grid w-100">Simpan Password</button>
            </form>

            <p class="text-center mt-3">
              <a href="index.php"><span>Login now</span></a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Script -->
  <script src="../aslog/vendor/libs/jquery/jquery.js"></script>
  <script src="../aslog/vendor/libs/popper/popper.js"></script>
  <script src="../aslog/vendor/js/bootstrap.js"></script>
  <script src="../aslog/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../aslog/vendor/js/menu.js"></script>
  <script src="../aslog/js/main.js"></script>

  <!-- Script untuk Toggle Password -->
  <script>
    function togglePassword(id, iconContainer) {
      const input = document.getElementById(id);
      const icon = iconContainer.querySelector('i');
      if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bx-hide');
        icon.classList.add('bx-show');
      } else {
        input.type = 'password';
        icon.classList.remove('bx-show');
        icon.classList.add('bx-hide');
      }
    }
  </script>
</body>
</html>
