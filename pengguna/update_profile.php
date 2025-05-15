<?php
include '../koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['nama_pengguna'];
    $nama_pengguna = mysqli_real_escape_string($koneksi, $_POST['fullName']);
    $bio = mysqli_real_escape_string($koneksi, $_POST['bio']);
    $negara = mysqli_real_escape_string($koneksi, $_POST['country']);
    $instagram = mysqli_real_escape_string($koneksi, $_POST['instagram']);
    $facebook = mysqli_real_escape_string($koneksi, $_POST['facebook']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);

    $query = "UPDATE pengguna SET 
              nama_pengguna = '$nama_pengguna', 
              bio = '$bio', 
              negara = '$negara', 
              instagram = '$instagram', 
              facebook = '$facebook', 
              email = '$email' 
              WHERE username = '$username'";

    if (mysqli_query($koneksi, $query)) {
        echo "Profil berhasil diperbarui.";
        // Perbarui data sesi jika diperlukan
        $_SESSION['nama_pengguna'] = $nama_pengguna;
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($koneksi);
    }

    mysqli_close($koneksi);
}
?>
