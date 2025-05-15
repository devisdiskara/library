<?php
session_start();
include '../koneksi.php'; // Ganti dengan file koneksi Anda

// Debugging: Periksa apakah parameter tersedia
if (!isset($_POST['id_komentar']) || !isset($_POST['id_buku'])) {
    die("Missing comment ID or book ID.");
}

$id_komentar = $_POST['id_komentar'];
$id_buku = $_POST['id_buku'];

// Validasi ID komentar dan ID buku
if (is_numeric($id_komentar) && is_numeric($id_buku)) {
    // Periksa apakah pengguna sudah login
    if (isset($_SESSION['id_pengguna'])) {
        // Hapus komentar
        $query = "DELETE FROM komentar WHERE id_komentar = ? AND id_pengguna = ?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("ii", $id_komentar, $_SESSION['id_pengguna']);

        if ($stmt->execute()) {
            // Redirect ke halaman detail buku setelah berhasil menghapus
            header("Location: detail_buku.php?id_buku=" . $id_buku);
            exit();
        } else {
            echo "Error deleting comment.";
        }
    } else {
        echo "You must be logged in to delete a comment.";
    }
} else {
    echo "Invalid comment ID or book ID.";
}
?>
