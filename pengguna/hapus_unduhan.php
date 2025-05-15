<?php
include '../koneksi.php';
session_start();

$id_pengguna = $_SESSION['id_pengguna'];
$id_buku = $_POST['id_buku'];

// Hapus data unduhan dari tabel unduhan
$query_delete = "DELETE FROM unduhan WHERE id_pengguna = $id_pengguna AND id_buku = $id_buku";
if (mysqli_query($koneksi, $query_delete)) {
    echo "Success";
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>
