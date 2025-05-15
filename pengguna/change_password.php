<?php
// Include koneksi ke database
include '../koneksi.php';
session_start();

// Pastikan sesi username sudah diset
if (!isset($_SESSION['username'])) {
    die("Sesi belum diset. Silakan login terlebih dahulu.");
}

// Ambil username dari sesi
$username = $_SESSION['username'];

// Ambil data yang di-post dari form
$currentPassword = $_POST['currentPassword'];
$newPassword = $_POST['newPassword'];
$renewPassword = $_POST['renewPassword'];

// Query untuk mengambil kata sandi terenkripsi dari database
$query = "SELECT kata_sandi FROM pengguna WHERE username = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $storedPassword = $row['kata_sandi'];

    // Verifikasi kata sandi saat ini
    if (password_verify($currentPassword, $storedPassword)) {
        // Kata sandi saat ini cocok, lanjutkan dengan mengubah kata sandi baru
        if ($newPassword === $renewPassword) {
            // Enkripsi kata sandi baru
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Query untuk mengupdate kata sandi baru ke database
            $updateQuery = "UPDATE pengguna SET kata_sandi = ? WHERE username = ?";
            $updateStmt = mysqli_prepare($koneksi, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, "ss", $hashedPassword, $username);

            if (mysqli_stmt_execute($updateStmt)) {
                // Kata sandi berhasil diupdate
                mysqli_stmt_close($updateStmt);
                mysqli_close($koneksi);
                echo '<script>alert("Password berhasil diubah."); window.location.href = "profile.php";</script>';
                exit;
            } else {
                // Gagal update kata sandi
                echo '<script>alert("Gagal mengubah kata sandi. Silakan coba lagi."); window.location.href = "profile.php";</script>';
                exit;
            }
        } else {
            // Pesan jika kata sandi baru dan konfirmasi tidak cocok
            echo '<script>alert("Kata sandi baru tidak cocok dengan konfirmasi."); window.location.href = "profile.php";</script>';
            exit;
        }
    } else {
        // Pesan jika kata sandi saat ini salah
        echo '<script>alert("Kata sandi saat ini salah. Silakan coba lagi."); window.location.href = "profile.php";</script>';
        exit;
    }
} else {
    // Pesan jika pengguna tidak ditemukan
    echo '<script>alert("Pengguna tidak ditemukan."); window.location.href = "profile.php";</script>';
    exit;
}

// Tutup statement dan koneksi database
mysqli_stmt_close($stmt);
mysqli_close($koneksi);
?>
