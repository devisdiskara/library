<?php
include '../koneksi.php';
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['id_pengguna'])) {
    echo "Anda harus login terlebih dahulu untuk mengunduh ebook.";
    exit;
}

// Pastikan parameter id_buku dikirim
if (isset($_GET['id_buku'])) {
    $id_buku = (int) $_GET['id_buku'];
    $id_pengguna = (int) $_SESSION['id_pengguna'];

    // Cek apakah pengguna sudah pernah mengunduh buku ini
    $cek = mysqli_query($koneksi, "SELECT * FROM unduhan WHERE id_buku = $id_buku AND id_pengguna = $id_pengguna");

    if (mysqli_num_rows($cek) === 0) {
        // Tambahkan data ke tabel unduhan
        mysqli_query($koneksi, "INSERT INTO unduhan (id_pengguna, id_buku) VALUES ($id_pengguna, $id_buku)");

        // Tambahkan jumlah unduhan pada tabel buku
        mysqli_query($koneksi, "UPDATE buku SET jumlah_unduhan = jumlah_unduhan + 1 WHERE id_buku = $id_buku");
    }

    // Arahkan ke file download berdasarkan path_file dari buku
    $result = mysqli_query($koneksi, "SELECT path_file FROM buku WHERE id_buku = $id_buku LIMIT 1");
    if ($data = mysqli_fetch_assoc($result)) {
        if (!empty($data['path_file'])) {
            header("Location: " . $data['path_file']);
            exit;
        } else {
            echo "File ebook tidak tersedia.";
        }
    } else {
        echo "Buku tidak ditemukan.";
    }
} else {
    echo "Permintaan tidak valid.";
}
?>
