<?php
$page = '';
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
switch ($page) {
    case 'kategori':
        $page = "include 'kategori.php';";
        break;

    case 'buku':
        $page = "include 'buku.php';";
        break;

    case 'admin':
        $page = "include 'admin.php';";
        break;

    case 'profile_admin':
        $page = "include 'profile_admin.php';";
        break;

    case 'kembali':
        $page = "include 'kembali.php';";
        break;
    case 'pengguna':
        $page = "include 'pengguna.php';";
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
