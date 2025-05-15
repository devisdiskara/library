<?php
include '../koneksi.php';
session_start();

// Fungsi untuk mengunggah file gambar ke server lokal
function uploadFile($file, $path)
{
    $target_dir = $path;
    $target_file = $target_dir . basename($file["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Periksa apakah file sudah ada
    if (file_exists($target_file)) {
        $uploadOk = 0;
    }

    // Periksa ukuran file
    if ($file["size"] > 5000000) { // 5MB
        $uploadOk = 0;
    }

    // Izinkan format file tertentu (jpg, png, jpeg)
    if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg") {
        $uploadOk = 0;
    }

    // Periksa apakah $uploadOk adalah 0
    if ($uploadOk == 0) {
        return false;
    } else {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return basename($file["name"]);
        } else {
            return false;
        }
    }
}

// Tambah data donasi
if (isset($_POST['btnTambah'])) {
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];
    $status = 'belum diverifikasi';

    // Upload gambar sampul
    $gambar_sampul = uploadFile($_FILES["gambar_sampul"], "../assets/img/ebook_donasi/");

    // Path file ebook di server lokal
    $file_ebook_path = '../file_ebook_donasi/';

    // Jika file ebook diunggah
    if ($_FILES["file_ebook"]["error"] === UPLOAD_ERR_OK) {
        $file_ebook_name = $_FILES["file_ebook"]["name"];
        $file_ebook = $_FILES["file_ebook"]["tmp_name"];

        // Pindahkan file ebook ke direktori lokal
        if (move_uploaded_file($file_ebook, $file_ebook_path . $file_ebook_name)) {
            // Insert data donasi ke database
            $query = "INSERT INTO donasi_ebook (judul, pengarang, deskripsi, kategori, gambar_sampul, file_ebook, status, tanggal_donasi, format_file) 
                      VALUES ('$judul', '$pengarang', '$deskripsi', '$kategori', '$gambar_sampul', '$file_ebook_name', '$status', NOW(), 'pdf')";
            if ($koneksi->query($query) === TRUE) {
                echo '<script>alert("Donasi berhasil ditambahkan.");</script>';
                echo '<script>window.location.href = "donasi_buku.php";</script>';
            } else {
                echo "Error: " . $query . "<br>" . $koneksi->error;
            }
        } else {
            echo "Error mengunggah file ebook.";
        }
    } else {
        // Insert data donasi ke database (tanpa file ebook)
        $query = "INSERT INTO donasi_ebook (judul, pengarang, deskripsi, kategori, gambar_sampul, status, tanggal_donasi, format_file) 
                  VALUES ('$judul', '$pengarang', '$deskripsi', '$kategori', '$gambar_sampul', '$status', NOW(), 'pdf')";
        if ($koneksi->query($query) === TRUE) {
            echo '<script>alert("Donasi berhasil ditambahkan.");</script>';
            echo '<script>window.location.href = "donasi_buku.php";</script>';
        } else {
            echo "Error: " . $query . "<br>" . $koneksi->error;
        }
    }
}

// Fungsi untuk mendapatkan semua data donasi ebook
function getAllDonasiEbook()
{
    global $koneksi;
    $query = "SELECT * FROM donasi_ebook";
    $result = $koneksi->query($query);
    $donasi_ebooks = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $donasi_ebooks[] = $row;
        }
    }
    return $donasi_ebooks;
}

// Fungsi untuk mendapatkan detail donasi ebook berdasarkan ID
function getDonasiEbookById($id)
{
    global $koneksi;
    $query = "SELECT * FROM donasi_ebook WHERE id = $id";
    $result = $koneksi->query($query);
    if ($result->num_rows == 1) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

// Fungsi untuk mengubah data donasi ebook
if (isset($_POST['btnUpdate'])) {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];

    // Cek apakah status tidak diisi, maka set ke default
    $status = !empty($_POST['status']) ? $_POST['status'] : 'belum diverifikasi';

    // Jika ada gambar sampul baru diunggah
    if ($_FILES["gambar_sampul"]["error"] === UPLOAD_ERR_OK) {
        $gambar_sampul = uploadFile($_FILES["gambar_sampul"], "../assets/img/ebook_donasi/");
        if ($gambar_sampul) {
            $query = "UPDATE donasi_ebook SET judul='$judul', pengarang='$pengarang', deskripsi='$deskripsi', kategori='$kategori', gambar_sampul='$gambar_sampul', status='$status' WHERE id=$id";
        } else {
            echo "Error mengunggah gambar sampul.";
        }
    } else {
        // Jika tidak ada gambar sampul baru diunggah
        $query = "UPDATE donasi_ebook SET judul='$judul', pengarang='$pengarang', deskripsi='$deskripsi', kategori='$kategori', status='$status' WHERE id=$id";
    }

    if ($koneksi->query($query) === TRUE) {
        echo '<script>alert("Donasi berhasil diperbarui.");</script>';
        echo '<script>window.location.href = "donasi_buku.php";</script>';
    } else {
        echo "Error: " . $query . "<br>" . $koneksi->error;
    }
}


// Fungsi untuk menghapus data donasi ebook
if (isset($_POST['btnHapus'])) {
    $id = $_POST['id'];

    // Hapus file gambar sampul dan ebook jika ada
    $donasi = getDonasiEbookById($id);
    if ($donasi) {
        $gambar_sampul_path = "../assets/img/ebook_donasi/" . $donasi['gambar_sampul'];
        $file_ebook_path = "../file_ebook_donasi/" . $donasi['file_ebook'];

        if (file_exists($gambar_sampul_path)) {
            unlink($gambar_sampul_path); // Hapus file gambar sampul
        }

        if (file_exists($file_ebook_path)) {
            unlink($file_ebook_path); // Hapus file ebook
        }
    }

    // Hapus data dari database
    $query = "DELETE FROM donasi_ebook WHERE id=$id";
    if ($koneksi->query($query) === TRUE) {
        echo '<script>alert("Donasi berhasil dihapus.");</script>';
        echo '<script>window.location.href = "donasi_buku.php";</script>';
    } else {
        echo "Error: " . $query . "<br>" . $koneksi->error;
    }
}
