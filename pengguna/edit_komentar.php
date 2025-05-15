<?php
session_start();
include '../koneksi.php'; // Ganti dengan file koneksi Anda

// Debugging: Periksa apakah parameter tersedia
if (!isset($_POST['id_komentar']) || !isset($_POST['id_buku'])) {
    die("Missing comment ID or book ID.");
}

$id_komentar = $_POST['id_komentar'];
$id_buku = $_POST['id_buku'];
$isi_komentar = $_POST['isi_komentar'];

// Validasi ID komentar dan ID buku
if (is_numeric($id_komentar) && is_numeric($id_buku)) {
    // Periksa apakah pengguna sudah login
    if (isset($_SESSION['id_pengguna'])) {
        // Update komentar
        $query = "UPDATE komentar SET isi_komentar = ? WHERE id_komentar = ?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("si", $isi_komentar, $id_komentar);

        if ($stmt->execute()) {
            // Redirect ke halaman detail buku setelah berhasil mengedit
            header("Location: detail_buku.php?id_buku=" . $id_buku);
            exit();
        } else {
            echo "Error updating comment.";
        }
    } else {
        echo "You must be logged in to edit a comment.";
    }
} else {
    echo "Invalid comment ID or book ID.";
}
?>
