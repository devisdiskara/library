<?php
session_start();
require '../koneksi.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../src/PHPMailer.php';
require '../src/SMTP.php';
require '../src/Exception.php';

if (!isset($_SESSION['reset_email'])) {
  echo "<script>alert('Sesi reset tidak valid');window.location='lupa_password.php';</script>";
  exit;
}

$email = $_SESSION['reset_email'];
$waktu_sekarang = time();
$error = '';

// Kirim ulang PIN jika diminta
if (isset($_GET['resend'])) {
    $batas_waktu = 120;
    $last_sent = $_SESSION['last_pin_sent'] ?? 0;

    if (($waktu_sekarang - $last_sent) > $batas_waktu) {
        $pin_baru = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        $update = mysqli_query($koneksi, "
            UPDATE pengguna 
            SET reset_pin='$pin_baru', pin_expiry='$expiry', last_pin_request='$waktu_sekarang', pin_request_count=pin_request_count + 1 
            WHERE email='$email'
        ");

        if ($update) {
            $user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pengguna WHERE email='$email'"));

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'patriky700@gmail.com';
                $mail->Password = 'pjzh qjfp pinp etyo';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('patriky700@gmail.com', 'FlexiLibrary');
                $mail->addAddress($email, $user['username']);
                $mail->isHTML(true);
                $mail->Subject = 'Kode Verifikasi Baru';
                $mail->Body = "
                    <p>Hai <strong>{$user['username']}</strong>,</p>
                    <p>Berikut kode verifikasi baru Anda:</p>
                    <h2 style='color:blue;'>$pin_baru</h2>
                    <p>Kode berlaku selama 10 menit.</p>
                ";

                $mail->send();
                $_SESSION['last_pin_sent'] = $waktu_sekarang;
                echo "<script>alert('PIN baru telah dikirim.');window.location='verifikasi_pin.php';</script>";
                exit;
            } catch (Exception $e) {
                $error = "Gagal mengirim ulang PIN. Error: {$mail->ErrorInfo}";
            }
        }
    } else {
        $sisa = 120 - ($waktu_sekarang - $last_sent);
        $error = "Tunggu $sisa detik sebelum mengirim ulang PIN.";
    }
}

// Proses verifikasi PIN
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pin = $_POST['pin'] ?? '';

    $query = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE email='$email' AND reset_pin='$pin'");
    $user = mysqli_fetch_assoc($query);

    if ($user) {
        $now = time();
        $expiry_time = strtotime($user['pin_expiry']);

        if ($now < $expiry_time) {
            $_SESSION['reset_verified'] = true;
            echo "<script>window.location='ganti_password.php';</script>";
            exit;
        } else {
            $error = "PIN sudah kadaluarsa.";
        }
    } else {
        $error = "PIN tidak valid.";
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-template="vertical-menu-template-free">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Verifikasi PIN - Flexilibrary</title>
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

            <h4 class="mb-2">Verifikasi Kode PIN</h4>
            <p class="mb-4">Masukkan 6 digit kode yang telah dikirim ke email Anda.</p>

            <?php if ($error): ?>
              <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" class="mb-3">
              <div class="mb-3">
                <label for="pin" class="form-label">Kode PIN</label>
                <input type="text" class="form-control" id="pin" name="pin" placeholder="Masukkan PIN 6 digit" required />
              </div>
              <button type="submit" class="btn btn-primary d-grid w-100">Verifikasi</button>
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

  <script src="../aslog/vendor/libs/jquery/jquery.js"></script>
  <script src="../aslog/vendor/libs/popper/popper.js"></script>
  <script src="../aslog/vendor/js/bootstrap.js"></script>
  <script src="../aslog/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../aslog/vendor/js/menu.js"></script>
  <script src="../aslog/js/main.js"></script>
</body>
</html>
