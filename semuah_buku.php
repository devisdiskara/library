<?php
include 'koneksi.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>All Ebooks - Flexilibrary</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon/log.ico" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

    <?php include 'header.php' ?>

    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <section class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="index.php">Home</a></li>
                    <li>All Ebook</li>
                </ol>
                <h2>All Ebook</h2>
            </div>
        </section><!-- End Breadcrumbs -->

        <!-- Buku Section -->
        <section id="portfolio" class="portfolio">
            <div class="container" data-aos="fade-up">

                <div class="section-header">
                    <h2>All Ebooks</h2>
                    <p>Select a category to view available ebooks</p>
                </div>

                <!-- Kategori Filter -->
                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-lg-12 d-flex justify-content-center">
                        <ul id="portfolio-flters">
                            <li data-filter="*" class="filter-active">All</li>
                            <?php
                            $query_kategori = "SELECT * FROM kategori";
                            $result_kategori = mysqli_query($koneksi, $query_kategori);

                            while ($row_kategori = mysqli_fetch_assoc($result_kategori)) {
                                echo '<li data-filter=".filter-' . $row_kategori["id_kategori"] . '">' . $row_kategori["nama"] . '</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>

                <!-- Buku Grid -->
                <div class="row gy-4 portfolio-container" data-aos="fade-up" data-aos-delay="200">
                    <?php
                    $query_buku = "SELECT buku.*, kategori.nama AS nama_kategori FROM buku INNER JOIN kategori ON buku.id_kategori = kategori.id_kategori";
                    $result_buku = mysqli_query($koneksi, $query_buku);

                    if (mysqli_num_rows($result_buku) > 0) {
                        while ($row_buku = mysqli_fetch_assoc($result_buku)) {
                            echo '<div class="col-lg-4 col-md-6 portfolio-item filter-' . $row_buku["id_kategori"] . '">';
                            echo '<div class="portfolio-wrap">';
                            echo '<img src="assets/img/ebook/' . $row_buku["gambar_sampul"] . '" class="img-fluid" alt="' . $row_buku["judul"] . '">';
                            echo '<div class="portfolio-info">';
                            echo '<h4>' . $row_buku["judul"] . '</h4>';
                            echo '<p>' . $row_buku["nama_kategori"] . '</p>';
                            echo '<div class="portfolio-links">';
                            echo '<a href="assets/img/ebook/' . $row_buku["gambar_sampul"] . '" data-gallery="portfolioGallery" class="portfokio-lightbox" title="' . $row_buku["judul"] . '"><i class="bi bi-plus"></i></a>';
                            echo '<a href="detail_buku.php?id_buku=' . $row_buku["id_buku"] . '" title="More Details"><i class="bi bi-eye"></i></a>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo "Tidak ada data buku yang tersedia.";
                    }
                    ?>
                </div>
            </div>
        </section><!-- End Buku Section -->

    </main><!-- End #main -->

    <?php include 'footer.php' ?>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>
