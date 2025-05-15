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

// Ambil data dari form
$fullName = $_POST['fullName'];
$bio = $_POST['bio'];
$country = $_POST['country'];
$email = $_POST['email'];
$facebook = $_POST['facebook'];
$instagram = $_POST['instagram'];

// Update data pengguna dalam database
$query = "UPDATE pengguna SET username=?, bio=?, negara=?, email=?, facebook=?, instagram=? WHERE username=?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "sssssss", $fullName, $bio, $country, $email, $facebook, $instagram, $username);
mysqli_stmt_execute($stmt);

// Cek apakah gambar profil diunggah
if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
  $profileImage = $_FILES['profileImage'];
  $imageName = $profileImage['name'];
  $imageTmpName = $profileImage['tmp_name'];
  $imageSize = $profileImage['size'];
  $imageError = $profileImage['error'];
  $imageType = $profileImage['type'];

  $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
  $allowedExts = array('jpg', 'jpeg', 'png', 'gif');

  if (in_array($imageExt, $allowedExts)) {
    if ($imageError === 0) {
      if ($imageSize < 5000000) { // Batas ukuran file 5MB
        $newImageName = uniqid('', true) . '.' . $imageExt;
        $imageDestination = '../assets/img/profile/' . $newImageName;

        move_uploaded_file($imageTmpName, $imageDestination);

        // Update gambar profil dalam database
        $query = "UPDATE pengguna SET profile=? WHERE username=?";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, "ss", $newImageName, $username);
        mysqli_stmt_execute($stmt);
      } else {
        echo "File gambar terlalu besar. Batas maksimum adalah 5MB.";
      }
    } else {
      echo "Terjadi kesalahan saat mengunggah gambar.";
    }
  } else {
    echo "Ekstensi file gambar tidak diizinkan. Hanya file JPG, JPEG, PNG, dan GIF yang diizinkan.";
  }
}

// Tutup statement dan koneksi database
mysqli_stmt_close($stmt);
mysqli_close($koneksi);

// Redirect kembali ke halaman profile.php setelah perubahan disimpan
header("Location: profile.php");
exit;
?>
