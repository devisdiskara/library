<?php
include '../koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_buku = $_POST['id_buku'];
    $id_pengguna = $_SESSION['id_pengguna']; // Ambil ID pengguna dari sesi
    $query = "INSERT INTO favorit (id_buku, id_pengguna) VALUES ('$id_buku', '$id_pengguna')";
    if (mysqli_query($koneksi, $query)) {
        echo "Buku berhasil ditambahkan ke favorit.";
    } else {
        echo "Gagal menambahkan buku ke favorit: " . mysqli_error($koneksi);
    }
}
?>
