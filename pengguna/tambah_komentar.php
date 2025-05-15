<?php
session_start();
include '../koneksi.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['id_pengguna'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari formulir
    $id_buku = mysqli_real_escape_string($koneksi, $_POST['id_buku']);
    $id_pengguna = $_SESSION['id_pengguna'];
    $isi_komentar = mysqli_real_escape_string($koneksi, $_POST['isi_komentar']);
    $tanggal_komentar = date('Y-m-d H:i:s');

    // Query untuk menyimpan komentar
    $query = "INSERT INTO komentar (id_buku, id_pengguna, isi_komentar, tanggal_komentar) VALUES ('$id_buku', '$id_pengguna', '$isi_komentar', '$tanggal_komentar')";

    if (mysqli_query($koneksi, $query)) {
        header('Location: detail_buku.php?id_buku=' . $id_buku);
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($koneksi);
    }
}
?>
