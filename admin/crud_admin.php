<?php
require '../koneksi.php';

// === TAMBAH ADMIN ===
if (isset($_POST['btnTambahAdmin'])) {
    $nama       = $_POST['nama'];
    $username   = $_POST['username'];
    $password   = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email      = $_POST['email'];
    $no_hp      = $_POST['no_hp'];
    $alamat     = $_POST['alamat'];
    $created_at = date('Y-m-d H:i:s');

    // Upload foto profil
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = $_FILES['foto']['name'];
        $tmp  = $_FILES['foto']['tmp_name'];
        $folder = "../assetsadmin/img/avatars/";
        $nama_file_baru = uniqid('admin_', true) . '_' . basename($foto);
        $pathFoto = $folder . $nama_file_baru;

        if (move_uploaded_file($tmp, $pathFoto)) {
            $query = "INSERT INTO admin (nama, username, password, email, no_hp, foto, alamat, created_at)
                      VALUES ('$nama', '$username', '$password', '$email', '$no_hp', '$nama_file_baru', '$alamat', '$created_at')";
            mysqli_query($koneksi, $query);
            header("Location: dashboard.php?page=admin");
            exit;
        } else {
            echo "Upload foto gagal!";
            exit;
        }
    } else {
        echo "Foto tidak ditemukan atau error saat upload.";
        exit;
    }
}

// === UBAH ADMIN ===
if (isset($_POST['btnUbahAdmin'])) {
    $id       = $_POST['id'];
    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $no_hp    = $_POST['no_hp'];
    $alamat   = $_POST['alamat'];
    $folder   = "../assetsadmin/img/avatars/";

    // Ambil foto lama dari DB
    $query_old = mysqli_query($koneksi, "SELECT foto FROM admin WHERE id = $id");
    $data_old = mysqli_fetch_assoc($query_old);
    $foto_lama = $data_old['foto'];

    // Jika upload foto baru
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = $_FILES['foto']['name'];
        $tmp  = $_FILES['foto']['tmp_name'];
        $nama_file_baru = uniqid('admin_', true) . '_' . basename($foto);
        $pathFoto = $folder . $nama_file_baru;

        if (move_uploaded_file($tmp, $pathFoto)) {
            // Hapus foto lama jika ada dan file-nya memang ada di server
            if (!empty($foto_lama) && file_exists($folder . $foto_lama)) {
                unlink($folder . $foto_lama);
            }

            $query = "UPDATE admin SET nama='$nama', username='$username', email='$email', no_hp='$no_hp',
                      foto='$nama_file_baru', alamat='$alamat' WHERE id=$id";
        } else {
            echo "Upload foto gagal!";
            exit;
        }
    } else {
        // Jika tidak ada foto baru
        $query = "UPDATE admin SET nama='$nama', username='$username', email='$email', no_hp='$no_hp',
                  alamat='$alamat' WHERE id=$id";
    }

    mysqli_query($koneksi, $query);
    header("Location: dashboard.php?page=admin");
    exit;
}

// === HAPUS ADMIN ===
if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
    $id = $_GET['hapus'];

    // Ambil foto lama untuk dihapus
    $query = mysqli_query($koneksi, "SELECT foto FROM admin WHERE id = $id");
    $data = mysqli_fetch_assoc($query);
    $foto = $data['foto'];

    if (!empty($foto) && file_exists("../assetsadmin/img/avatars/" . $foto)) {
        unlink("../assetsadmin/img/avatars/" . $foto);
    }

    // Hapus data admin
    mysqli_query($koneksi, "DELETE FROM admin WHERE id = $id");
    header("Location: dashboard.php?page=admin");
    exit;
}
?>
