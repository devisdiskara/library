<?php
include '../koneksi.php';
session_start();

$data1 = mysqli_query($koneksi, "SELECT * FROM buku");
$total_buku = mysqli_num_rows($data1);

$data1 = mysqli_query($koneksi, "SELECT * FROM pengguna");
$total_pengguna = mysqli_num_rows($data1);

$data1 = mysqli_query($koneksi, "SELECT * FROM kategori");
$total_kategori = mysqli_num_rows($data1);

$data1 = mysqli_query($koneksi, "SELECT * FROM komentar");
$total_komentar = mysqli_num_rows($data1);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>About - Flexilibrary</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/favicon/log.ico" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: FlexStart
  * Updated: Mar 13 2024 with Bootstrap v5.3.3
  * Template URL: https://bootstrapmade.com/flexstart-bootstrap-startup-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <?php include 'header.php' ?>

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <ol>
          <li><a href="page.php">Beranda</a></li>
          <li>Tentang</li>
        </ol>
        <h2>Tentang</h2>

      </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page">
      <div class="container">
        <h1 style="font-weight: bold; color: #012970;">Tentang FlexiLibrary</h1>
        <hr>
        <div class="about-content">
          <p>FlexiLibrary adalah destinasi utama Anda untuk mengunduh eBook digital secara gratis. Kami percaya bahwa pengetahuan harus dapat diakses oleh siapapun, dimanapun dan, kapanpun.</p>

          <h2 style="font-weight: bold; color: #012970;">Visi Kami</h2>
          <p>Kami membayangkan dunia di mana setiap orang memiliki akses yang setara terhadap pengetahuan dan kreativitas manusia. Melalui eBook gratis, kami ingin menginspirasi dan memberdayakan siapa saja untuk belajar dan berkembang.</p>

          <h2 style="font-weight: bold; color: #012970;">Misi Kami</h2>
          <p>Misi kami adalah mendemokratisasi akses terhadap ilmu pengetahuan serta menumbuhkan minat baca dan belajar di kalangan masyarakat luas.</p>

          <h2 style="font-weight: bold; color: #012970;">Apa yang Kami Tawarkan</h2>
          <ul>
            <li><strong>Koleksi Lengkap:</strong> Ribuan eBook dari berbagai genre seperti fiksi, non-fiksi, sains, teknologi, sejarah, hingga pengembangan diri.</li>
            <li><strong>Gratis:</strong> Semua eBook dapat diunduh secara gratis tanpa biaya.</li>
            <li><strong>Mudah Digunakan:</strong> Desain situs yang simpel dan mudah dinavigasi.</li>
            <li><strong>Pembaruan Berkala:</strong> Koleksi eBook terus diperbarui secara rutin.</li>
          </ul>

          <h2 style="font-weight: bold; color: #012970;">Mengapa FlexiLibrary?</h2>
          <ul>
            <li><strong>Bebas Biaya:</strong> Nikmati akses ilmu tanpa mengeluarkan uang.</li>
            <li><strong>Beragam Genre:</strong> Temukan bacaan sesuai minat Anda.</li>
            <li><strong>Aman dan Legal:</strong> Semua eBook tersedia secara sah dan aman diakses.</li>
          </ul>

          <h2 style="font-weight: bold; color: #012970;">Kontribusi Anda</h2>
          <p>Kami terbuka untuk masukan dan kontribusi Anda. Jika memiliki saran buku atau ingin ikut serta memperluas koleksi kami, silakan hubungi kami. Bersama, kita bisa menjadikan FlexiLibrary sumber belajar yang lebih kaya untuk semua.</p>
        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <?php include 'footer.php' ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>

</html>