<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../koneksi.php';
require '../src/PHPMailer.php';
require '../src/SMTP.php';
require '../src/Exception.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($koneksi, $_POST['email'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email tidak valid!');window.location='lupa_password.php';</script>";
        exit;
    }

    $query = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE email = '$email'");
    if (mysqli_num_rows($query) > 0) {
        $user = mysqli_fetch_assoc($query);

        $pin = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        $now = time();

        $update = mysqli_query($koneksi, "
            UPDATE pengguna 
            SET reset_pin='$pin', pin_expiry='$expiry', last_pin_request='$now', pin_request_count=pin_request_count + 1 
            WHERE email='$email'
        ");

        if ($update) {
            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'patriky700@gmail.com';
                $mail->Password   = 'pjzh qjfp pinp etyo';
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;

                $mail->setFrom('patriky700@gmail.com', 'FlexiLibrary');
                $mail->addAddress($email, $user['username']);
                $mail->isHTML(true);
                $mail->Subject = 'Kode Verifikasi Reset Password Anda';
                $mail->Body    = "
                    <p>Hai <strong>{$user['username']}</strong>,</p>
                    <p>Gunakan kode PIN berikut untuk verifikasi reset password:</p>
                    <h2 style='color:blue;'>$pin</h2>
                    <p>Kode ini hanya berlaku selama 10 menit.</p>
                ";

                $mail->send();

                $_SESSION['reset_email'] = $email;
                $_SESSION['last_pin_sent'] = $now;

                echo "<script>alert('Kode verifikasi sudah dikirim ke email Anda.');window.location='verifikasi_pin.php';</script>";
            } catch (Exception $e) {
                echo "Email gagal dikirim. Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Gagal menyimpan PIN ke database.";
        }
    } else {
        echo "<script>alert('Email tidak ditemukan di database');window.location='lupa_password.php';</script>";
    }
}
?>
