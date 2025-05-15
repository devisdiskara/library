<?php
include '../koneksi.php';
session_start();

// Validasi sesi login
if (!isset($_SESSION['login_pa'])) {
    header('location: index.php');
    exit; // Selesai untuk menghentikan eksekusi lebih lanjut
}

// Tombol Simpan
if (isset($_POST['btnSimpan'])) {
    // Ambil data dari form
    $id_kategori = mysqli_real_escape_string($koneksi, $_POST['id_kategori']);
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $pengarang = mysqli_real_escape_string($koneksi, $_POST['pengarang']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $link_shopee = mysqli_real_escape_string($koneksi, $_POST['link_shopee']);
    $link_tokopedia = mysqli_real_escape_string($koneksi, $_POST['link_tokopedia']);
    $path_file = mysqli_real_escape_string($koneksi, $_POST['path_file']);

    // Modifikasi link Google Drive menjadi link download otomatis
    if (strpos($path_file, 'drive.google.com') !== false) {
        $path_file = str_replace("view?usp=sharing", "uc?export=download", $path_file);
    }

    // Ambil data gambar sampul dari form
    $gambar_sampul = $_FILES['gambar_sampul'];

    // Validasi gambar sampul
    if ($gambar_sampul['error'] === 0) {
        $namaFileGambar = $gambar_sampul['name'];
        $ukuranFileGambar = $gambar_sampul['size'];
        $tmpFileGambar = $gambar_sampul['tmp_name'];
        $dirGambar = '../assets/img/ebook/';
        $randomGambar = uniqid(); // Menggunakan fungsi uniqid() untuk membuat nama unik

        // Pindahkan gambar sampul ke direktori
        if (move_uploaded_file($tmpFileGambar, $dirGambar . $randomGambar . '_' . $namaFileGambar)) {
            $gambar_sampul = $randomGambar . '_' . $namaFileGambar;
        } else {
            echo "<script>alert('Gagal mengunggah gambar sampul ke direktori tujuan');</script>";
            exit;
        }
    } else {
        echo "<script>alert('Ukuran gambar sampul terlalu besar atau ada kesalahan dalam mengunggah gambar');</script>";
        exit;
    }

    // Lakukan penyimpanan data buku ke dalam database
    $query = "INSERT INTO buku (id_kategori, judul, pengarang, deskripsi, gambar_sampul, path_file, link_shopee, link_tokopedia) VALUES ('$id_kategori', '$judul', '$pengarang', '$deskripsi', '$gambar_sampul', '$path_file', '$link_shopee', '$link_tokopedia')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Data buku berhasil disimpan'); document.location='dashboard.php?page=buku';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data buku ke database');</script>";
    }
}

// Tombol Ubah
if (isset($_POST['btnUbah'])) {
    // Ambil data dari form
    $id_buku = mysqli_real_escape_string($koneksi, $_POST['id_buku']);
    $id_kategori = mysqli_real_escape_string($koneksi, $_POST['id_kategori']);
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $pengarang = mysqli_real_escape_string($koneksi, $_POST['pengarang']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $path_file = mysqli_real_escape_string($koneksi, $_POST['path_file']);
    $link_shopee = mysqli_real_escape_string($koneksi, $_POST['link_shopee']);
    $link_tokopedia = mysqli_real_escape_string($koneksi, $_POST['link_tokopedia']);
    $gambarLama = mysqli_real_escape_string($koneksi, $_POST['gambarLama']);

    // Modifikasi link Google Drive menjadi link download otomatis
    if (strpos($path_file, 'drive.google.com') !== false) {
        $path_file = str_replace("view?usp=sharing", "uc?export=download", $path_file);
    }

    // Ambil data gambar dari form
    $gambar = $_FILES['gambar_sampul'];

    // Jika tidak ada gambar yang diunggah, gunakan gambar lama
    if ($gambar['error'] === 4) {
        $query = "UPDATE buku SET id_kategori = '$id_kategori', judul = '$judul', pengarang = '$pengarang', deskripsi = '$deskripsi', path_file = '$path_file', link_shopee = '$link_shopee', link_tokopedia = '$link_tokopedia' WHERE id_buku = '$id_buku'";
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            echo "<script>alert('Data buku berhasil diubah'); document.location='dashboard.php?page=buku';</script>";
        } else {
            echo "<script>alert('Gagal mengubah data buku');</script>";
        }
    } else {
        $namaFile = $gambar['name'];
        $ukuranFile = $gambar['size'];
        $tmpFile = $gambar['tmp_name'];
        $dir = '../assets/img/ebook/';
        $random = uniqid(); // Menggunakan fungsi uniqid() untuk membuat nama unik

        // Hapus gambar lama dari direktori jika ada
        if (file_exists($dir . $gambarLama)) {
            unlink($dir . $gambarLama);
        }

        // Pindahkan gambar baru ke direktori
        if (move_uploaded_file($tmpFile, $dir . $random . '_' . $namaFile)) {
            $gambarBaru = $random . '_' . $namaFile;

            // Update data buku dengan gambar baru
            $query = "UPDATE buku SET id_kategori = '$id_kategori', judul = '$judul', pengarang = '$pengarang', deskripsi = '$deskripsi', gambar_sampul = '$gambarBaru', path_file = '$path_file', link_shopee = '$link_shopee', link_tokopedia = '$link_tokopedia' WHERE id_buku = '$id_buku'";
            $result = mysqli_query($koneksi, $query);

            if ($result) {
                echo "<script>alert('Data buku berhasil diubah'); document.location='dashboard.php?page=buku';</script>";
            } else {
                echo "<script>alert('Gagal mengubah data buku');</script>";
            }
        } else {
            echo "<script>alert('Gagal mengunggah gambar baru');</script>";
        }
    }
}

// Tombol Hapus
if (isset($_POST['btnHapus'])) {
    $id = mysqli_real_escape_string($koneksi, $_POST['id_buku']);

    $query = "DELETE FROM buku WHERE id_buku ='$id'";
    $hapus = mysqli_query($koneksi, $query);

    if ($hapus) {
        echo "<script>alert('Data buku berhasil dihapus'); document.location='dashboard.php?page=buku';</script>";
    } else {
        echo "<script>alert('Data buku gagal dihapus'); document.location='dashboard.php?page=buku';</script>";
    }
}
