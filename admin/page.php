<?php
$page = '';
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
switch ($page) {
    case 'rak':
        $page = "include 'rak.php';";
        break;

    case 'kategori':
        $page = "include 'kategori.php';";
        break;

    case 'buku':
        $page = "include 'buku.php';";
        break;

    case 'petugas':
        $page = "include 'kelola_petugas.php';";
        break;

    case 'pinjam':
        $page = "include 'pinjam.php';";
        break;

    case 'kembali':
        $page = "include 'kembali.php';";
        break;
    case 'laporan':
        $page = "include 'laporan.php';";
        break;
    case 'profile':
        $page = "include 'edit_profile.php';";
        break;
    case 'ulasan':
        $page = "include 'ulasan.php';";
        break;
    case 'denda':
        $page = "include 'denda.php';";
        break;

    default:
        $page = "include 'home.php';";
        break;
}

$CONTENT['main'] = $page;
