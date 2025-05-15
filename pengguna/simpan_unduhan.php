<?php
include '../koneksi.php';
session_start();

$id_pengguna = $_SESSION['id_pengguna'];
$id_buku = $_POST['id_buku'];

// Periksa apakah buku sudah diunduh sebelumnya
$query_check = "SELECT * FROM unduhan WHERE id_pengguna = $id_pengguna AND id_buku = $id_buku";
$result_check = mysqli_query($koneksi, $query_check);

if (mysqli_num_rows($result_check) == 0) {
    // Buku belum diunduh, tambahkan ke tabel unduhan
    $query_insert = "INSERT INTO unduhan (id_pengguna, id_buku) VALUES ($id_pengguna, $id_buku)";
    if (mysqli_query($koneksi, $query_insert)) {
        echo "Success";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    echo "Buku sudah diunduh sebelumnya.";
}
?>
