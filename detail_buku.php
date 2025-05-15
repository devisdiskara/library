<?php
include 'koneksi.php'; // Pastikan ini mengarah ke file koneksi yang benar
session_start();

// Anda menggunakan ulang variabel $data1, namun tidak digunakan setelahnya
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

    <title>Details Ebook - Flexilibrary</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets//img/favicon/log.ico" rel="icon">
    <link href="assets//img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets//vendor/aos/aos.css" rel="stylesheet">
    <link href="assets//vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets//vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets//vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets//vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets//vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets//css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: Flexilibrary
  * Updated: Mar 13 2024 with Bootstrap v5.3.3
  * Template URL: https://bootstrapmade.com/Flexilibrary-bootstrap-startup-template/
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
                    <li><a href="index.php">Home</a></li>
                    <li>ebook details</li>
                </ol>
                <h2>ebook details</h2>
            </div>
        </section><!-- End Breadcrumbs -->

        <!-- Ebook Details Section -->
        <section id="portfolio-details" class="portfolio-details">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-12">
                        <div id="alert-container"></div> <!-- Container for alert messages -->
                    </div>
                    <div class="col-lg-6">
                        <div class="portfolio-details-slider swiper">
                            <div class="swiper-wrapper align-items-center">
                                <?php
                                // Periksa apakah parameter ID buku ada di URL
                                if (isset($_GET['id_buku'])) {
                                    // Ambil ID buku dari URL
                                    $id_buku = $_GET['id_buku'];

                                    // Query untuk mengambil informasi detail buku berdasarkan ID
                                    // Anda bisa menyesuaikan query ini dengan struktur database Anda
                                    // Saya mengasumsikan ada tabel 'buku' dengan kolom 'path_file' di dalamnya
                                    $query_buku = "SELECT * FROM buku WHERE id_buku = $id_buku";
                                    $result_buku = mysqli_query($koneksi, $query_buku);

                                    // Periksa apakah query berhasil dieksekusi dan apakah buku ditemukan
                                    if ($result_buku && mysqli_num_rows($result_buku) > 0) {
                                        // Ambil data buku dari hasil query
                                        $row_buku = mysqli_fetch_assoc($result_buku);

                                        // Ambil path_file dari hasil query
                                        $path_file = $row_buku['path_file'];

                                        // Tampilkan gambar sampul buku dalam slider
                                        echo '<div class="swiper-slide">';
                                        echo '<img src="assets/img/ebook/' . $row_buku["gambar_sampul"] . '" alt="' . $row_buku["judul"] . '" style="max-width: 60%; max-height: 20%;">';
                                        echo '</div>';
                                    } else {
                                        echo "<p>Buku tidak ditemukan.</p>";
                                    }
                                } else {
                                    echo "<p>ID buku tidak ditemukan.</p>";
                                }
                                ?>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                        <!-- Tombol download -->
                        <a href="../pengguna/" download class="btn btn-primary rounded-0" style="margin-top: 20px;">
                            <i class="bi bi-download"></i> Download PDF
                        </a>
                        <!-- Tombol "Send to" -->
                        <div class="btn-group" style="margin-top: 20px;">
                            <button class="btn btn-primary rounded-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #fff; border-color: #9E9E9E; color: #9E9E9E;">
                                Send to &nbsp;
                                <i class="bi bi-three-dots-vertical" style="font-size: 1rem; color: #9E9E9E;"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li class="dropdown-item">
                                    <a href="https://www.facebook.com/" target="_blank" class="dropdown-item" style="color: #9E9E9E;"><i class="bi bi-facebook"></i> Facebook</a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="https://twitter.com/" target="_blank" class="dropdown-item" style="color: #9E9E9E;"><i class="bi bi-twitter"></i> Twitter</a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="https://www.instagram.com/" target="_blank" class="dropdown-item" style="color: #9E9E9E;"><i class="bi bi-instagram"></i> Instagram</a>
                                </li>
                            </ul>
                        </div>
                        <!-- Tombol "Buku Kertas" -->
                        <div class="btn-group" style="margin-top: 20px;">
                            <button class="btn btn-primary rounded-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #fff; border-color: #9E9E9E; color: #9E9E9E;">
                                Buku Kertas<i class="bi bi-three-dots-vertical" style="font-size: 1rem; color: #9E9E9E;"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li class="dropdown-item">
                                    <a href="#" class="dropdown-item" style="color: #9E9E9E;"><img src="assets/img/shope.png" alt="Shopee Icon" style="width: 20px; height: 20px; margin-right: 5px;"> Shopee</a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="#" class="dropdown-item" style="color: #9E9E9E;"><img src="assets/img/tokopedia.svg" alt="Tokopedia Icon" style="width: 20px; height: 20px; margin-right: 5px;"> Tokopedia</a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="#" class="dropdown-item" style="color: #9E9E9E;">Ingin menambahkan toko buku Anda? Hubungi kami di email flexilibrary@gmail.com</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="portfolio-info">
                            <h3>Ebook Information</h3>
                            <ul>
                                <?php
                                // Periksa apakah parameter ID buku ada di URL
                                if (isset($_GET['id_buku'])) {
                                    // Ambil ID buku dari URL
                                    $id_buku = $_GET['id_buku'];

                                    // Query untuk mengambil informasi detail buku berdasarkan ID
                                    $query_buku = "SELECT buku.*, kategori.nama AS nama_kategori FROM buku INNER JOIN kategori ON buku.id_kategori = kategori.id_kategori WHERE buku.id_buku = $id_buku";
                                    $result_buku = mysqli_query($koneksi, $query_buku);

                                    // Periksa apakah query berhasil dieksekusi dan apakah buku ditemukan
                                    if (mysqli_num_rows($result_buku) > 0) {
                                        // Ambil data buku dari hasil query
                                        $row_buku = mysqli_fetch_assoc($result_buku);

                                        // Tampilkan informasi detail buku
                                        echo '<li><strong>Judul Buku</strong>: ' . $row_buku["judul"] . '</li>';
                                        echo '<li><strong>Kategori</strong>: ' . $row_buku["nama_kategori"] . '</li>';
                                        echo '<li><strong>Pengarang</strong>: ' . $row_buku["pengarang"] . '</li>';
                                    } else {
                                        echo "<p>Buku tidak ditemukan.</p>";
                                    }
                                } else {
                                    echo "<p>ID buku tidak ditemukan.</p>";
                                }
                                ?>
                            </ul>
                            <!-- Ikon favorit -->
                            <i id="favorite-icon" class="bi bi-heart" style="font-size: 1rem; margin-top: 20px; cursor: pointer;"></i>
                        </div>
                        <div class="portfolio-description">
                            <h2>Description</h2>
                            <p>
                                <?php
                                if (isset($row_buku)) {
                                    echo $row_buku["deskripsi"];
                                } else {
                                    echo "Deskripsi tidak tersedia.";
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- Ebook Details Section -->

        <!-- JavaScript untuk ikon favorit dan tombol download -->
        <script>
            document.getElementById('favorite-icon').addEventListener('click', function() {
                // Periksa apakah pengguna sudah login atau belum
                var loggedIn = false; // Gantikan dengan kondisi login yang sesuai dari sistem Anda

                if (!loggedIn) {
                    showAlert("Anda harus login terlebih dahulu untuk menambahkan ke favorit.");
                    return; // Hentikan eksekusi jika belum login
                }

                this.classList.toggle('active');

                if (this.classList.contains('active')) {
                    this.classList.remove('bi-heart');
                    this.classList.add('bi-heart-fill');
                    this.style.color = 'blue'; // Warna ikon ketika aktif
                } else {
                    this.classList.remove('bi-heart-fill');
                    this.classList.add('bi-heart');
                    this.style.color = 'black'; // Warna ikon ketika tidak aktif
                }
            });

            // Script untuk tombol download PDF
            var downloadBtn = document.querySelector('.btn-primary');
            downloadBtn.addEventListener('click', function(event) {
                // Periksa apakah pengguna sudah login atau belum
                var loggedIn = false; // Gantikan dengan kondisi login yang sesuai dari sistem Anda

                if (!loggedIn) {
                    event.preventDefault(); // Hentikan tindakan default (download) jika belum login
                    showAlert("Anda harus login terlebih dahulu untuk mengunduh buku.");
                }
            });

            // Fungsi untuk menampilkan alert Bootstrap
            function showAlert(message) {
                var alertContainer = document.getElementById('alert-container');
                var alertHTML = '<div class="alert alert-danger alert-dismissible fade show" role="alert">' + message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                alertContainer.innerHTML = alertHTML;
            }
        </script>

        <!-- Link untuk memuat ikon Bootstrap -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.4.0/font/bootstrap-icons.min.css">


        <!-- Mungkin Anda Tertarik -->
        <div style="text-align: center; margin-top: 30px;">
            <h3>You may be interested in</h3>
            <hr style="width: 50%; margin: auto;">
        </div>

        <!-- Portfolio Section -->
        <section id="koleksi" class="portfolio" style="overflow-y: auto;">
            <div class="container" data-aos="fade-up">
                <div class="row gy-4 portfolio-container" data-aos="fade-up" data-aos-delay="200">
                    <?php
                    // Array untuk menyimpan ID buku yang sudah ditampilkan di detail
                    $shown_book_ids = array();

                    // Bagian untuk menampilkan detail buku
                    if (isset($_GET['id_buku'])) {
                        $id_buku = $_GET['id_buku'];
                        // Tambahkan ID buku ke dalam array
                        array_push($shown_book_ids, $id_buku);
                        // Query untuk menampilkan detail buku
                        $query_buku = "SELECT buku.*, kategori.nama AS nama_kategori FROM buku INNER JOIN kategori ON buku.id_kategori = kategori.id_kategori WHERE buku.id_buku = $id_buku";
                        $result_buku = mysqli_query($koneksi, $query_buku);
                        if (mysqli_num_rows($result_buku) > 0) {
                            $row_buku = mysqli_fetch_assoc($result_buku);
                            // Dapatkan kategori buku yang sedang dilihat
                            $kategori_buku = $row_buku['nama_kategori'];
                        }
                    }

                    // Bagian untuk menampilkan buku di bawahnya
                    // Query untuk menampilkan buku di bawahnya dengan kategori yang sama
                    $query_buku_bawahnya = "SELECT buku.*, kategori.nama AS nama_kategori FROM buku INNER JOIN kategori ON buku.id_kategori = kategori.id_kategori WHERE kategori.nama = '$kategori_buku'";

                    // Jika ada buku yang sudah ditampilkan di detail, tambahkan filter untuk menyaring buku-buku tersebut
                    if (!empty($shown_book_ids)) {
                        $id_string = implode(",", $shown_book_ids);
                        $query_buku_bawahnya .= " AND buku.id_buku NOT IN ($id_string)";
                    }

                    $result_buku_bawahnya = mysqli_query($koneksi, $query_buku_bawahnya);

                    if (mysqli_num_rows($result_buku_bawahnya) > 0) {
                        // Variabel untuk menghitung jumlah buku yang ditampilkan
                        $counter = 0;
                        while ($row_buku_bawahnya = mysqli_fetch_assoc($result_buku_bawahnya)) {
                            // Tampilkan buku di bawahnya hanya jika jumlah buku yang ditampilkan masih kurang dari 5
                            if ($counter < 5) {
                    ?>
                                <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                                    <div class="portfolio-wrap">
                                        <img src="assets/img/ebook/<?php echo $row_buku_bawahnya["gambar_sampul"]; ?>" class="img-fluid" alt="<?php echo $row_buku_bawahnya["judul"]; ?>">
                                        <div class="portfolio-info">
                                            <h4><?php echo $row_buku_bawahnya["judul"]; ?></h4>
                                            <p><?php echo $row_buku_bawahnya["nama_kategori"]; ?></p>
                                            <div class="portfolio-links">
                                                <a href="assets/img/ebook/<?php echo $row_buku_bawahnya["gambar_sampul"]; ?>" data-gallery="portfolioGallery" class="portfokio-lightbox" title="<?php echo $row_buku_bawahnya["judul"]; ?>"><i class="bi bi-plus"></i></a>
                                                <a href="detail_buku.php?id_buku=<?php echo $row_buku_bawahnya["id_buku"]; ?>" title="More Details"><i class="bi bi-eye"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                $counter++;
                            }
                        }
                        // Tampilkan kartu "Lihat Semua Buku" dalam sebuah card jika jumlah buku yang ditampilkan lebih dari 5
                        if (mysqli_num_rows($result_buku_bawahnya) > 5) {
                            ?>
                            <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                                <div class="portfolio-wrap">
                                    <img src="assetpage/img/buku/book.png" class="img-fluid" alt="View All Ebooks">
                                    <div class="portfolio-info">
                                        <h4>View All Ebooks</h4>
                                        <p>Click here to view all ebooks</p>
                                        <div class="portfolio-links">
                                            <a href="semua_buku.php" title="View All Ebooks"><i class="bi bi-three-dots"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div style="text-align:center;">
                                    <h5>View All Ebooks</h5>
                                    <p>Click here to view all ebooks</p>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "Tidak ada data buku yang tersedia.";
                    }
                    ?>
                </div>
            </div>
        </section><!-- End Portfolio Section -->

        <!-- Tempat Komentar untuk Buku -->
        <section id="tempat-komentar" class="testimonials">
            <div class="container" data-aos="fade-up">
                <header class="section-header text-center">
                    <h2>Comments from this Ebook</h2>
                    <p>Reader Testimonials on This ebook</p>
                </header>
                <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="200">
                    <div class="swiper-wrapper">
                        <?php
                        // Periksa apakah ID buku ada dan valid
                        if (isset($_GET['id_buku']) && is_numeric($_GET['id_buku'])) {
                            $id_buku = $_GET['id_buku'];

                            // Lakukan query untuk mengambil ulasan dan rating dari tabel komentar
                            $query_komentar = "SELECT komentar.*, pengguna.nama_pengguna 
                        FROM komentar
                        INNER JOIN pengguna ON komentar.id_pengguna = pengguna.id_pengguna
                        WHERE komentar.id_buku = $id_buku";
                            $result_komentar = mysqli_query($koneksi, $query_komentar);

                            // Periksa apakah query berhasil dieksekusi
                            if ($result_komentar && mysqli_num_rows($result_komentar) > 0) {
                                // Loop untuk menampilkan setiap ulasan
                                while ($row_komentar = mysqli_fetch_assoc($result_komentar)) {
                                    // Sanitisasi data sebelum ditampilkan
                                    $nama_pengguna = htmlspecialchars($row_komentar["nama_pengguna"]);
                                    $isi_komentar = htmlspecialchars($row_komentar["isi_komentar"]);
                                    $tanggal_komentar = htmlspecialchars($row_komentar["tanggal_komentar"]);

                                    echo '<div class="swiper-slide">
                    <div class="testimonial-item">
                        <div class="text-center">
                            <img src="assets/img/user.gif" alt="Avatar" style="max-width: 150px;" class="rounded-circle">
                            <h5>' . $nama_pengguna . '</h5>
                        </div>
                        <div class="text-center">
                            <h5>' . $isi_komentar . '</h5>
                            <h6>Waktu: ' . $tanggal_komentar . '</h6>
                        </div>
                    </div>
                </div><!-- End testimonial item -->';
                                }
                            } else {
                                echo "<div class='swiper-slide'><div class='testimonial-item'><p class='text-center'>Belum ada komentar untuk buku ini.</p></div></div>";
                            }
                        } else {
                            echo "<div class='swiper-slide'><div class='testimonial-item'><p class='text-center'>ID buku tidak valid.</p></div></div>";
                        }
                        ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section> <!-- End Tempat Komentar untuk Buku -->


    </main><!-- End #main -->

    <?php include 'footer.php' ?>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets//vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets//vendor/aos/aos.js"></script>
    <script src="assets//vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets//vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets//vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets//vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets//vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets//js/main.js"></script>

</body>

</html>