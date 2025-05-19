<?php
// Include koneksi ke database
include '../koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
  die("Sesi belum diset. Silakan login terlebih dahulu.");
}

$username = $_SESSION['username'];

// Ambil data dari form
$fullName = $_POST['fullName'];
$bio = $_POST['bio'];
$country = $_POST['country'];
$email = $_POST['email'];
$facebook = $_POST['facebook'];
$instagram = $_POST['instagram'];

// Update data pengguna
$query = "UPDATE pengguna SET username=?, bio=?, negara=?, email=?, facebook=?, instagram=? WHERE username=?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "sssssss", $fullName, $bio, $country, $email, $facebook, $instagram, $username);
mysqli_stmt_execute($stmt);

// Perbarui session jika username berubah
if ($username !== $fullName) {
  $_SESSION['username'] = $fullName;
}

// Proses upload gambar
if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
  $profileImage = $_FILES['profileImage'];
  $imageName = $profileImage['name'];
  $imageTmpName = $profileImage['tmp_name'];
  $imageSize = $profileImage['size'];
  $imageError = $profileImage['error'];

  $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
  $allowedExts = array('jpg', 'jpeg', 'png', 'gif');

  if (in_array($imageExt, $allowedExts)) {
    if ($imageError === 0) {
      if ($imageSize < 5000000) {
        $newImageName = uniqid('', true) . '.' . $imageExt;
        $imageDestination = '../assets/img/profile/' . $newImageName;

        if (move_uploaded_file($imageTmpName, $imageDestination)) {
          // Update gambar profil
          $query = "UPDATE pengguna SET profile=? WHERE username=?";
          $stmt2 = mysqli_prepare($koneksi, $query); // Gunakan variabel berbeda
          mysqli_stmt_bind_param($stmt2, "ss", $newImageName, $_SESSION['username']);
          mysqli_stmt_execute($stmt2);
          mysqli_stmt_close($stmt2);
        } else {
          echo "Gagal memindahkan file gambar.";
          exit;
        }
      } else {
        echo "File gambar terlalu besar. Batas maksimum adalah 5MB.";
        exit;
      }
    } else {
      echo "Terjadi kesalahan saat mengunggah gambar.";
      exit;
    }
  } else {
    echo "Ekstensi file tidak diizinkan.";
    exit;
  }
}

// Tutup statement utama
if (isset($stmt)) {
  mysqli_stmt_close($stmt);
}

mysqli_close($koneksi);

// Redirect kembali
header("Location: profile.php");
exit;
?>
