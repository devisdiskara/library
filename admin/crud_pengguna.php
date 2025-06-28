<?php
include '../koneksi.php'; // pastikan path ini sesuai dengan struktur direktori kamu

if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);

    // Ambil data pengguna yang akan dihapus
    $query = mysqli_query($koneksi, "SELECT profile FROM pengguna WHERE id_pengguna = $id");
    
    if ($data = mysqli_fetch_assoc($query)) {
        $foto = $data['profile'];
        $foto_path = "../assets/img/profile/" . $foto;

        // Hapus file foto jika file ada, bukan kosong, dan bukan foto default
        if (!empty($foto) && file_exists($foto_path) && $foto !== 'default.png') {
            unlink($foto_path);
        }

        // Hapus data pengguna dari database
        $hapus = mysqli_query($koneksi, "DELETE FROM pengguna WHERE id_pengguna = $id");

        if ($hapus) {
            header("Location: dashboard.php?page=pengguna&status=sukses");
            exit();
        } else {
            // Gagal menghapus dari database
            header("Location: dashboard.php?page=pengguna&status=gagal");
            exit();
        }
    } else {
        // ID pengguna tidak ditemukan
        header("Location: dashboard.php?page=pengguna&status=notfound");
        exit();
    }
} else {
    // Akses langsung tanpa parameter ?hapus=
    header("Location: dashboard.php?page=pengguna");
    exit();
}
?>
