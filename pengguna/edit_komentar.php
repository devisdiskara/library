<?php
session_start();
include '../koneksi.php';

// Periksa parameter
if (!isset($_POST['id_komentar'], $_POST['id_buku'], $_POST['isi_komentar'], $_POST['rating'])) {
    die("Missing required fields.");
}

$id_komentar = $_POST['id_komentar'];
$id_buku = $_POST['id_buku'];
$isi_komentar = $_POST['isi_komentar'];
$rating = floatval($_POST['rating']); // pastikan nilai rating berupa float

// Validasi
if (is_numeric($id_komentar) && is_numeric($id_buku)) {
    if (isset($_SESSION['id_pengguna'])) {
        // Update isi komentar dan rating
        $query = "UPDATE komentar SET isi_komentar = ?, rating = ? WHERE id_komentar = ? AND id_pengguna = ?";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("sdii", $isi_komentar, $rating, $id_komentar, $_SESSION['id_pengguna']);

        if ($stmt->execute()) {
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
