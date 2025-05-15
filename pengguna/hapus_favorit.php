<?php
include '../koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_buku = $_POST['id_buku'];
    $id_pengguna = $_SESSION['id_pengguna'];

    $query = "DELETE FROM favorit WHERE id_buku = '$id_buku' AND id_pengguna = '$id_pengguna'";
    if (mysqli_query($koneksi, $query)) {
        echo "Buku berhasil dihapus dari favorit.";
    } else {
        echo "Gagal menghapus buku dari favorit: " . mysqli_error($koneksi);
    }
}
?>
