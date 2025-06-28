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

    <title>Detail Ebook - Flexilibrary</title>
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
                    <li><a href="index.php">Beranda</a></li>
                    <li>Detail Ebook</li>
                </ol>
                <h2>Detail Ebook</h2>
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
                                if (isset($_GET['id_buku'])) {
                                    $id_buku = $_GET['id_buku'];

                                    $query_buku = "SELECT * FROM buku WHERE id_buku = $id_buku";
                                    $result_buku = mysqli_query($koneksi, $query_buku);

                                    if ($result_buku && mysqli_num_rows($result_buku) > 0) {

                                        $row_buku = mysqli_fetch_assoc($result_buku);

                                        $path_file = $row_buku['path_file'];

                                        echo '<div class="swiper-slide">';
                                        echo '<img src="assets/img/ebook/' . $row_buku["gambar_sampul"] . '" alt="' . $row_buku["judul"] . '" style="max-width: 60%; max-height: 20%;">';
                                        echo '</div>';
                                    } else {
                                        echo "<p>ebook tidak ditemukan.</p>";
                                    }
                                } else {
                                    echo "<p>ID ebook tidak ditemukan.</p>";
                                }
                                ?>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                        <!-- Tombol download -->
                        <a href="../pengguna/" download class="btn btn-primary rounded-0" style="margin-top: 20px;">
                            <i class="bi bi-download"></i> Download PDF
                        </a>
                        <!-- Tombol "Send to"
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
                        </div> -->
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
                            <h3>Informasi Ebook</h3>
                            <ul>
                                <?php
                                if (isset($_GET['id_buku'])) {
                                    $id_buku = $_GET['id_buku'];

                                    $query_buku = "SELECT buku.*, kategori.nama AS nama_kategori FROM buku INNER JOIN kategori ON buku.id_kategori = kategori.id_kategori WHERE buku.id_buku = $id_buku";
                                    $result_buku = mysqli_query($koneksi, $query_buku);

                                    if (mysqli_num_rows($result_buku) > 0) {
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
                            <i id="favorite-icon" class="bi bi-heart" style="font-size: 1rem; margin-top: 20px; cursor: pointer;"></i>
                        </div>
                        <div class="portfolio-description">
                            <h2>Deskripsi</h2>
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
            <h3>Anda mungkin tertarik dengan</h3>
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
                                                <!-- <a href="assets/img/ebook/<?php echo $row_buku_bawahnya["gambar_sampul"]; ?>" data-gallery="portfolioGallery" class="portfokio-lightbox" title="<?php echo $row_buku_bawahnya["judul"]; ?>"><i class="bi bi-plus"></i></a> -->
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
                                        <h4>Lihat Semua Ebook</h4>
                                        <p>Klik dinini lihat semua ebook</p>
                                        <div class="portfolio-links">
                                            <a href="semua_buku.php" title="View All Ebooks"><i class="bi bi-three-dots"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div style="text-align:center;">
                                    <h5>VLihat Semua Ebook</h5>
                                    <p>Klik dinini lihat semua ebook</p>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "Tidak ada data ebook yang serupa.";
                    }
                    ?>
                </div>
            </div>
        </section><!-- End Portfolio Section -->

                <?php
if (isset($_GET['id_buku']) && is_numeric($_GET['id_buku'])) {
    $id_buku = (int)$_GET['id_buku'];

    $query_komentar = "SELECT komentar.*, pengguna.nama_pengguna, pengguna.profile, komentar.rating
        FROM komentar
        INNER JOIN pengguna ON komentar.id_pengguna = pengguna.id_pengguna
        WHERE komentar.id_buku = $id_buku
        ORDER BY komentar.tanggal_komentar DESC";
    $result_komentar = mysqli_query($koneksi, $query_komentar);
?>

<section>
<div class="container my-5 py-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-8">

            <?php
            if ($result_komentar && mysqli_num_rows($result_komentar) > 0) {
                while ($row = mysqli_fetch_assoc($result_komentar)) {
                    $id_komentar = (int)$row["id_komentar"];
                    $id_pengguna_komentar = (int)$row["id_pengguna"];
                    $nama_pengguna = htmlspecialchars($row["nama_pengguna"]);
                    $isi_komentar = htmlspecialchars($row["isi_komentar"]);
                    $tanggal_komentar = date('d M Y, H:i', strtotime($row["tanggal_komentar"]));
                    $profile_image = !empty($row["profile"]) ? "assets/img/profile/" . htmlspecialchars($row["profile"]) : "https://mdbcdn.b-cdn.net/img/Photos/Avatars/default-avatar.webp";
                    $rating = (float)$row['rating'];

                    echo '
                    <div style="display: flex; gap: 30px; margin-bottom: 40px; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <img class="rounded-circle" src="' . $profile_image . '" alt="avatar" width="60" height="60" />
                                <div>
                                    <h6 class="fw-bold text-primary mb-1">' . $nama_pengguna . '</h6>
                                    <p class="text-muted small mb-0">Shared publicly - ' . $tanggal_komentar . '</p>
                                </div>
                            </div>
                            <div style="margin: 10px 0;">';

                    $fullStars = floor($rating);
                    $halfStar = ($rating - $fullStars) >= 0.5;
                    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);

                    for ($i = 0; $i < $fullStars; $i++) echo '<i class="bi bi-star-fill text-warning"></i>';
                    if ($halfStar) echo '<i class="bi bi-star-half text-warning"></i>';
                    for ($i = 0; $i < $emptyStars; $i++) echo '<i class="bi bi-star text-warning"></i>';

                    echo '</div>
                            <p style="white-space: pre-line;">' . nl2br($isi_komentar) . '</p>
                            <div class="small d-flex justify-content-start" style="gap: 20px; align-items: center;">
                                <a href="#" class="d-flex align-items-center text-decoration-none text-muted">
                                    <i class="bi bi-hand-thumbs-up-fill text-primary mb-1 me-1"></i>Like
                                </a>';

                    if (isset($_SESSION['id_pengguna']) && (int)$_SESSION['id_pengguna'] === $id_pengguna_komentar) {
                        echo '
                                <a href="#" class="d-flex align-items-center text-decoration-none text-muted" data-bs-toggle="modal" data-bs-target="#editKomentarModal" 
                                data-id_komentar="' . $id_komentar . '" data-isi_komentar="' . htmlspecialchars($isi_komentar, ENT_QUOTES) . '">
                                    <i class="bi bi-pencil-fill text-primary mb-1 me-1"></i>Edit
                                </a>
                                <a href="#" class="d-flex align-items-center text-decoration-none text-muted" data-bs-toggle="modal" data-bs-target="#hapusKomentarModal" 
                                data-id_komentar="' . $id_komentar . '">
                                    <i class="bi bi-trash-fill me-2 text-primary mb-1"></i>Hapus
                                </a>';
                    }

                    echo '</div></div></div>';
                }
            } else {
                echo '<p class="text-center">Belum ada komentar untuk buku ini.</p>';
            }
            ?>

            <?php if (isset($_SESSION['id_pengguna'])) : ?>
                <!-- Form komentar tetap -->
                <form id="comment-form" method="post" action="tambah_komentar.php" style="background: transparent; margin-top: 20px;">
                    <input type="hidden" name="id_buku" value="<?php echo htmlspecialchars($id_buku ?? ''); ?>">
                    <input type="hidden" name="rating" id="rating-value" value="0">

                    <div class="d-flex gap-3 align-items-center">
                        <img class="rounded-circle" src="<?php echo isset($_SESSION['profile']) ? 'assets/img/profile/' . htmlspecialchars($_SESSION['profile']) : 'https://mdbcdn.b-cdn.net/img/Photos/Avatars/default-avatar.webp'; ?>" alt="avatar" width="50" height="50" />

                        <div style="flex: 1;">
                            <div id="star-rating" style="font-size: 24px; color: #ddd; cursor: pointer; user-select: none; margin-bottom: 5px; display: inline-block;">
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <i class="bi bi-star" data-value="<?php echo $i; ?>"></i>
                                <?php endfor; ?>
                            </div>

                            <textarea id="isi_komentar" name="isi_komentar" class="form-control" rows="3" placeholder="Tulis komentar..." required style="resize: vertical;"></textarea>
                        </div>
                    </div>

                    <div class="mt-2 text-end">
                        <button type="submit" class="btn btn-primary btn-sm">Kirim Komentar</button>
                        <button type="reset" class="btn btn-outline-primary btn-sm ms-2">Batal</button>
                    </div>
                </form>

                <script>
                    const stars = document.querySelectorAll('#star-rating i');
                    const ratingInput = document.getElementById('rating-value');
                    let selectedRating = 0;

                    stars.forEach((star, idx) => {
                        star.addEventListener('mousemove', (e) => {
                            const rect = star.getBoundingClientRect();
                            const mouseX = e.clientX;
                            const starMiddle = rect.left + rect.width / 2;
                            let hoverValue = idx + 1;

                            if (mouseX < starMiddle) {
                                hoverValue -= 0.5;
                            }
                            highlightStars(hoverValue);
                        });

                        star.addEventListener('click', (e) => {
                            const rect = star.getBoundingClientRect();
                            const mouseX = e.clientX;
                            const starMiddle = rect.left + rect.width / 2;
                            selectedRating = idx + 1;

                            if (mouseX < starMiddle) {
                                selectedRating -= 0.5;
                            }

                            ratingInput.value = selectedRating;
                            highlightStars(selectedRating);
                        });

                        star.addEventListener('mouseout', () => {
                            highlightStars(selectedRating);
                        });
                    });

                    function highlightStars(rating) {
                        stars.forEach((star, idx) => {
                            const starValue = idx + 1;
                            if (starValue <= rating) {
                                star.className = 'bi bi-star-fill text-warning';
                            } else if (starValue - 0.5 === rating) {
                                star.className = 'bi bi-star-half text-warning';
                            } else {
                                star.className = 'bi bi-star';
                                star.classList.remove('text-warning');
                            }
                        });
                    }
                </script>
            <?php else : ?>
                <p class="text-center">Silakan <a href="pengguna/">login</a> untuk menulis komentar.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</section>

<?php } else {
    echo '<p class="text-center">ID buku tidak valid.</p>';
} ?>


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