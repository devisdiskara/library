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
          <li><a href="page.php">Home</a></li>
          <li>About</li>
        </ol>
        <h2>About</h2>

      </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page">
      <div class="container">
        <h1 style="font-weight: bold; color: #012970; ">About FlexiLibrary</h1>
        <hr>
        <div class="about-content">
          <p>Welcome to FlexiLibrary, your premier destination for free digital ebook downloads. At Flexi Library, we believe that knowledge should be accessible to everyone, regardless of location or financial status. Our mission is to provide a large collection of high-quality ebooks from various genres and fields, available for free download by our users.</p>
          <h2 style="font-weight: bold; color: #012970;">Our Mission</h2>
          <p>Our mission is to democratize access to knowledge and encourage a love of reading and learning. We seek to remove barriers to education and give everyone the opportunity to explore new worlds, ideas and perspectives through the power of books.</p>

          <h2 style="font-weight: bold; color: #012970;">What We Offer</h2>
          <ul>
            <li><strong>Extensive Collection:</strong> Our library has a wide range of ebooks, from classic literature and fiction to academic texts and personal development books.</li>
            <li><strong>Free Download:</strong> All our ebooks are available for free download.</li>
            <li><strong>User Friendly Interface:</strong> Our website is designed to be intuitive and easy to navigate.</li>
            <li><strong>Regular Updates:</strong> We are constantly updating our collection with new ebooks.</li>
          </ul>

          <h2 style="font-weight: bold; color: #012970;">Mengapa Memilih Flexi Library?</h2>
          <ul>
            <li><strong>Free of Charge:</strong> Enjoy access to a wealth of knowledge without spending a dime.</li>
            <li><strong>Diverse Genres:</strong> Our extensive catalog includes genres such as fiction, non-fiction, science, technology, history, romance, mystery, and many more.</li>
            <li><strong>Community-Driven:</strong> We value our reader community and continually strive to improve our offerings based on feedback and user requests.</li>
            <li><strong>Safe and Legal:</strong> All ebooks available on Flexi Library are legally obtained and shared.</li>
          </ul>
          <h2 style="font-weight: bold; color: #012970;">Our Vision</h2>
          <p>At Flexi Library, we envision a world where everyone has equal access to the wealth of human knowledge and creativity. By providing free ebooks, we hope to inspire and empower individuals to pursue their passions, improve their lives, and contribute to a more informed and enlightened society.</p>

          <h2 style="font-weight: bold; color: #012970;">Get Involved</h2>
          <p>We encourage our users to get involved and help us grow our library. If you have suggestions for new books or features, or if you would like to contribute to our collection, please contact us. Together, we can make Flexi Library a richer resource for everyone.</p>
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