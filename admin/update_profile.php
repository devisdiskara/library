<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login_pa']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

$id_admin = $_SESSION['id_admin'];
$username_session = $_SESSION['username'];

// Ambil data dari form
$nama           = $_POST['nama'] ?? '';
$email          = $_POST['email'] ?? '';
$no_hp          = $_POST['no_hp'] ?? '';
$alamat         = $_POST['alamat'] ?? '';
$username_baru  = $_POST['username'] ?? '';
$password_baru  = $_POST['password'] ?? '';

$foto_baru = $_FILES['foto']['name'] ?? '';
$foto_tmp  = $_FILES['foto']['tmp_name'] ?? '';
$upload_dir = "../assetsadmin/img/avatars/";

// Ambil data lama dari database
$get_old = mysqli_query($koneksi, "SELECT * FROM admin WHERE id = '$id_admin'");
$data_old = mysqli_fetch_assoc($get_old);

$foto_lama = $data_old['foto'] ?? 'default.png';

// Proses upload foto jika ada
if (!empty($foto_baru)) {
    $ext = strtolower(pathinfo($foto_baru, PATHINFO_EXTENSION));
    $nama_file_baru = uniqid() . '.' . $ext;
    $tujuan = $upload_dir . $nama_file_baru;

    if (move_uploaded_file($foto_tmp, $tujuan)) {
        // Hapus foto lama jika bukan default
        if (!empty($foto_lama) && file_exists($upload_dir . $foto_lama) && $foto_lama !== 'default.png') {
            unlink($upload_dir . $foto_lama);
        }

        $foto_final = $nama_file_baru;
        $_SESSION['profile'] = $foto_final; // Perbarui session foto
    } else {
        echo "Upload foto gagal!";
        exit;
    }
} else {
    $foto_final = $foto_lama; // Tetap pakai foto lama
}

// Siapkan query dan parameter
$query  = "UPDATE admin SET nama=?, email=?, no_hp=?, alamat=?, username=?, foto=?";
$params = [$nama, $email, $no_hp, $alamat, $username_baru, $foto_final];
$types  = "ssssss";

// Jika password diisi, update password juga
if (!empty($password_baru)) {
    $hashed = password_hash($password_baru, PASSWORD_DEFAULT);
    $query .= ", password=?";
    $params[] = $hashed;
    $types .= "s";
}

$query .= " WHERE id=?";
$params[] = $id_admin;
$types .= "i";

// Jalankan query
$stmt = $koneksi->prepare($query);
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    // Perbarui session
    $_SESSION['username'] = $username_baru;

    header("Location: dashboard.php?page=profile_admin&success=1");
    exit;
} else {
    echo "Gagal update data: " . $stmt->error;
}
?>
