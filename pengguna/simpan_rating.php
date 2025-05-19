<?php
session_start();
include 'koneksi.php';

if (isset($_POST['rating'], $_POST['id_buku'], $_SESSION['id_pengguna'])) {
    $id_buku = (int)$_POST['id_buku'];
    $id_pengguna = (int)$_SESSION['id_pengguna'];
    $rating = (int)$_POST['rating'];

    $cek = mysqli_query($koneksi, "SELECT * FROM rating WHERE id_buku = $id_buku AND id_pengguna = $id_pengguna");

    if (mysqli_num_rows($cek) > 0) {
        mysqli_query($koneksi, "UPDATE rating SET rating = $rating WHERE id_buku = $id_buku AND id_pengguna = $id_pengguna");
    } else {
        mysqli_query($koneksi, "INSERT INTO rating (id_buku, id_pengguna, rating) VALUES ($id_buku, $id_pengguna, $rating)");
    }

    header("Location: detail_buku.php?id_buku=$id_buku");
    exit;
}
?>
