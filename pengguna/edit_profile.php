<?php
include '../koneksi.php';
session_start();

// Pastikan sesi login ada
if (!isset($_SESSION['id_pengguna'])) {
  die("Sesi belum diset. Silakan login terlebih dahulu.");
}

$id_pengguna = $_SESSION['id_pengguna'];

// Ambil data dari form
$nama_pengguna = $_POST['nama_pengguna'];
$username_baru = $_POST['username'];
$bio       = $_POST['bio'];
$country   = $_POST['country'];
$email     = $_POST['email'];
$facebook  = $_POST['facebook'];
$instagram = $_POST['instagram'];

// Ambil data lama untuk cek username dan gambar sebelumnya
$query_lama = "SELECT username, profile FROM pengguna WHERE id_pengguna = ?";
$stmt_lama = mysqli_prepare($koneksi, $query_lama);
mysqli_stmt_bind_param($stmt_lama, "i", $id_pengguna);
mysqli_stmt_execute($stmt_lama);
$result_lama = mysqli_stmt_get_result($stmt_lama);
$data_lama = mysqli_fetch_assoc($result_lama);
$usernameLama = $data_lama['username'];
$gambarLama   = $data_lama['profile'];

// Update data pengguna
$query = "UPDATE pengguna SET nama_pengguna=?, username=?, bio=?, negara=?, email=?, facebook=?, instagram=? WHERE id_pengguna=?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "sssssssi", $nama_pengguna, $username_baru, $bio, $country, $email, $facebook, $instagram, $id_pengguna);
mysqli_stmt_execute($stmt);

// Update session username jika berubah
if ($usernameLama !== $username_baru) {
  $_SESSION['username'] = $username_baru;
}

// Proses upload gambar baru (dan hapus yang lama)
if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
  $profileImage = $_FILES['profileImage'];
  $imageName    = $profileImage['name'];
  $imageTmpName = $profileImage['tmp_name'];
  $imageSize    = $profileImage['size'];
  $imageExt     = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

  $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

  if (in_array($imageExt, $allowedExts)) {
    if ($imageSize < 5 * 1024 * 1024) { // 5MB
      $newImageName = uniqid('profile_', true) . '.' . $imageExt;
      $imagePath = '../assets/img/profile/' . $newImageName;

      if (move_uploaded_file($imageTmpName, $imagePath)) {
        // Hapus foto lama jika bukan default
        if (!empty($gambarLama) && $gambarLama !== 'profile.png' && file_exists('../assets/img/profile/' . $gambarLama)) {
          unlink('../assets/img/profile/' . $gambarLama);
        }

        // Simpan gambar baru ke database
        $queryFoto = "UPDATE pengguna SET profile=? WHERE id_pengguna=?";
        $stmtFoto = mysqli_prepare($koneksi, $queryFoto);
        mysqli_stmt_bind_param($stmtFoto, "si", $newImageName, $id_pengguna);
        mysqli_stmt_execute($stmtFoto);
        mysqli_stmt_close($stmtFoto);
      } else {
        echo "Gagal memindahkan file gambar.";
        exit;
      }
    } else {
      echo "Ukuran gambar terlalu besar. Maksimal 5MB.";
      exit;
    }
  } else {
    echo "Format gambar tidak diizinkan. Hanya jpg, jpeg, png, gif.";
    exit;
  }
}

// Tutup koneksi
if (isset($stmt)) {
  mysqli_stmt_close($stmt);
}
mysqli_close($koneksi);

// Redirect ke halaman profil
header("Location: profile.php");
exit;
?>
