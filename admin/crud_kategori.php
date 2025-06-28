<?php
include '../koneksi.php';
session_start();

// Cek login
if (!isset($_SESSION['login_pa'])) {
    header('location: index.php');
    exit;
}

// Simpan Kategori Baru
if (isset($_POST['btnSimpanKategori'])) {
    $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);

    $query = "INSERT INTO kategori (nama) VALUES ('$nama_kategori')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Kategori berhasil disimpan'); document.location='dashboard.php?page=kategori';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan kategori');</script>";
    }
}

// Ubah Kategori
if (isset($_POST['btnUbahKategori'])) {
    $id_kategori = mysqli_real_escape_string($koneksi, $_POST['id_kategori']);
    $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);

    $query = "UPDATE kategori SET nama = '$nama_kategori' WHERE id_kategori = '$id_kategori'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Kategori berhasil diubah'); document.location='dashboard.php?page=kategori';</script>";
    } else {
        echo "<script>alert('Gagal mengubah kategori');</script>";
    }
}

// Hapus Kategori
if (isset($_POST['btnHapusKategori'])) {
    $id_kategori = mysqli_real_escape_string($koneksi, $_POST['id_kategori']);

    $query = "DELETE FROM kategori WHERE id_kategori = '$id_kategori'";
    $hapus = mysqli_query($koneksi, $query);

    if ($hapus) {
        echo "<script>alert('Kategori berhasil dihapus'); document.location='dashboard.php?page=kategori';</script>";
    } else {
        echo "<script>alert('Gagal menghapus kategori'); document.location='dashboard.php?page=kategori';</script>";
    }
}
?>
