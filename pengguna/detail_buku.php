<?php
session_start();
include '../koneksi.php';

// Asumsi bahwa ID pengguna disimpan dalam sesi setelah login
$id_pengguna = $_SESSION['id_pengguna'];

$is_favorited = false;
$link_shopee = '';
$link_tokopedia = '';

if (isset($_GET['id_buku'])) {
    $id_buku = $_GET['id_buku'];

    // Periksa apakah buku ada dalam daftar favorit pengguna
    $query_favorit = "SELECT * FROM favorit WHERE id_pengguna = $id_pengguna AND id_buku = $id_buku";
    $result_favorit = mysqli_query($koneksi, $query_favorit);
    $is_favorited = (mysqli_num_rows($result_favorit) > 0);

    // Query untuk mendapatkan detail buku
    $query_buku = "SELECT buku.*, kategori.nama AS nama_kategori FROM buku INNER JOIN kategori ON buku.id_kategori = kategori.id_kategori WHERE buku.id_buku = $id_buku";
    $result_buku = mysqli_query($koneksi, $query_buku);

    if ($result_buku && mysqli_num_rows($result_buku) > 0) {
        $row_buku = mysqli_fetch_assoc($result_buku);
        $path_file = $row_buku['path_file'];
        $link_shopee = $row_buku['link_shopee']; // Ambil link Shopee dari database
        $link_tokopedia = $row_buku['link_tokopedia']; // Ambil link Tokopedia dari database
    } else {
        // Jika tidak ada data, beri pesan kesalahan atau arahkan ulang
        echo "Buku tidak ditemukan.";
        exit;
    }
} else {
    // Jika tidak ada ID buku yang diberikan, beri pesan kesalahan atau arahkan ulang
    echo "ID Buku tidak diberikan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Ebooks Details - Flexilibrary</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../assets//img/favicon/log.ico" rel="icon">
    <link href="../assets//img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets//vendor/aos/aos.css" rel="stylesheet">
    <link href="../assets//vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets//vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets//vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="../assets//vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets//vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../assets//css/style.css" rel="stylesheet">

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
                    <div class="col-lg-6">
                        <div class="portfolio-details-slider swiper">
                            <div class="swiper-wrapper align-items-center">
                                <?php
                                if (isset($row_buku)) {
                                    echo '<div class="swiper-slide">';
                                    echo '<img src="../assets/img/ebook/' . $row_buku["gambar_sampul"] . '" alt="' . $row_buku["judul"] . '" style="max-width: 60%; max-height: 20%;">';
                                    echo '</div>';
                                } else {
                                    echo "<p>Buku tidak ditemukan.</p>";
                                }
                                ?>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                        <?php if (isset($path_file)) : ?>
                            <a href="<?php echo $path_file; ?>" id="download-button" class="btn btn-primary rounded-0" style="margin-top: 20px;">
                                <i class="bi bi-download"></i> Download PDF
                            </a>
                        <?php endif; ?>
                        <div class="btn-group" style="margin-top: 20px;">
                            <button class="btn btn-primary rounded-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #fff; border-color: #9E9E9E; color: #9E9E9E;">
                                Buku Kertas<i class="bi bi-three-dots-vertical" style="font-size: 1rem; color: #9E9E9E;"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li class="dropdown-item">
                                    <a href="<?php echo $link_shopee; ?>" class="dropdown-item" style="color: #9E9E9E;" target="_blank">
                                        <img src="../assets/img/shope.png" alt="Shopee Icon" style="width: 20px; height: 20px; margin-right: 5px;"> Shopee
                                    </a>
                                </li>
                                <li class="dropdown-item">
                                    <a href="<?php echo $link_tokopedia; ?>" class="dropdown-item" style="color: #9E9E9E;" target="_blank">
                                        <img src="../assets/img/tokopedia.svg" alt="Tokopedia Icon" style="width: 20px; height: 20px; margin-right: 5px;"> Tokopedia
                                    </a>
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
                                if (isset($row_buku)) {
                                    echo '<li><strong>Judul Buku</strong>: ' . $row_buku["judul"] . '</li>';
                                    echo '<li><strong>Kategori</strong>: ' . $row_buku["nama_kategori"] . '</li>';
                                    echo '<li><strong>Pengarang</strong>: ' . $row_buku["pengarang"] . '</li>';
                                } else {
                                    echo "<p>Buku tidak ditemukan.</p>";
                                }
                                ?>
                            </ul>
                            <i id="favorite-icon" class="bi <?php echo $is_favorited ? 'bi-heart-fill' : 'bi-heart'; ?>" style="font-size: 1rem; margin-top: 20px; cursor: pointer; color: <?php echo $is_favorited ? 'blue' : 'black'; ?>;"></i>
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

        <script>
            document.getElementById('favorite-icon').addEventListener('click', function() {
                // Ambil nilai id_buku dari PHP
                var bookId = <?php echo $id_buku; ?>;

                // Tentukan URL berdasarkan status favorit
                var url = this.classList.contains('bi-heart-fill') ? 'hapus_favorit.php' : 'simpan_favorit.php';

                // Buat objek XMLHttpRequest
                var xhr = new XMLHttpRequest();

                // Kirim permintaan ke server
                xhr.open('POST', url, true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Handle response jika diperlukan
                        // Ubah ikon favorit sesuai respons dari server
                        if (url === 'simpan_favorit.php') {
                            document.getElementById('favorite-icon').classList.remove('bi-heart');
                            document.getElementById('favorite-icon').classList.add('bi-heart-fill');
                            document.getElementById('favorite-icon').style.color = 'blue';
                        } else {
                            document.getElementById('favorite-icon').classList.remove('bi-heart-fill');
                            document.getElementById('favorite-icon').classList.add('bi-heart');
                            document.getElementById('favorite-icon').style.color = 'black';
                        }
                    }
                };
                xhr.send('id_buku=' + bookId);
            });

            document.getElementById('download-button').addEventListener('click', function() {
                // Ambil nilai id_buku dari PHP
                var bookId = <?php echo $id_buku; ?>;

                // Buat objek XMLHttpRequest
                var xhr = new XMLHttpRequest();

                // Kirim permintaan ke server
                xhr.open('POST', 'simpan_unduhan.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Handle response jika diperlukan
                        console.log(xhr.responseText);
                    }
                };
                xhr.send('id_buku=' + bookId);
            });
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
            <style>
            .portfolio-item .portfolio-wrap img {
                height: 500px;
                object-fit: cover;
            }

            .portfolio-item {
                display: flex;
                justify-content: center;
                align-items: center;
            }
            </style>
            <div class="row gy-4 portfolio-container" data-aos="fade-up" data-aos-delay="200">
            <?php
            $shown_book_ids = array();

            if (isset($_GET['id_buku'])) {
                $id_buku = $_GET['id_buku'];
                array_push($shown_book_ids, $id_buku);
                $query_buku = "SELECT buku.*, kategori.nama AS nama_kategori FROM buku INNER JOIN kategori ON buku.id_kategori = kategori.id_kategori WHERE buku.id_buku = $id_buku";
                $result_buku = mysqli_query($koneksi, $query_buku);
                if (mysqli_num_rows($result_buku) > 0) {
                $row_buku = mysqli_fetch_assoc($result_buku);
                $kategori_buku = $row_buku['nama_kategori'];
                }
            }

            $query_buku_bawahnya = "SELECT buku.*, kategori.nama AS nama_kategori FROM buku INNER JOIN kategori ON buku.id_kategori = kategori.id_kategori WHERE kategori.nama = '$kategori_buku'";
            if (!empty($shown_book_ids)) {
                $id_string = implode(",", $shown_book_ids);
                $query_buku_bawahnya .= " AND buku.id_buku NOT IN ($id_string)";
            }

            $result_buku_bawahnya = mysqli_query($koneksi, $query_buku_bawahnya);

            if (mysqli_num_rows($result_buku_bawahnya) > 0) {
                $counter = 0;
                while ($row = mysqli_fetch_assoc($result_buku_bawahnya)) {
                if ($counter < 5) {
                    $rating = $row["rating"];
                    $fullStars = floor($rating);
                    $halfStars = ($rating - $fullStars >= 0.5) ? 1 : 0;
                    $emptyStars = 5 - $fullStars - $halfStars;

                    echo '<div class="col-lg-4 col-md-6 portfolio-item filter-app" data-aos="fade-up" data-aos-delay="' . (100 * $counter) . '">
                    <div class="portfolio-wrap" style="position: relative;">
                        <img src="../assets/img/ebook/' . $row["gambar_sampul"] . '" class="img-fluid" alt="' . $row["judul"] . '">
                        <div class="portfolio-info">
                        <div class="rating" style="position: absolute; top: 10px; left: 10px; padding: 5px 10px; border-radius: 5px;">';

                    for ($i = 0; $i < $fullStars; $i++) {
                    echo '<i class="bi bi-star-fill" style="color: #f7c600;"></i>';
                    }
                    if ($halfStars) {
                    echo '<i class="bi bi-star-half" style="color: #f7c600;"></i>';
                    }
                    for ($i = 0; $i < $emptyStars; $i++) {
                    echo '<i class="bi bi-star-fill" style="color: black;"></i>';
                    }

                    echo '</div>
                        <div class="portfolio-links">
                            <a href="detail_buku.php?id_buku=' . $row["id_buku"] . '" title="More Details"><i class="bi bi-eye"></i></a>
                        </div>
                        </div>
                    </div>
                    </div>';
                    $counter++;
                }
                }

                if (mysqli_num_rows($result_buku_bawahnya) > 5) {
                echo '<div class="col-lg-4 col-md-6 portfolio-item filter-app" data-aos="fade-up" data-aos-delay="' . (100 * $counter) . '">
                    <div class="portfolio-wrap">
                    <img src="assetpage/img/buku/book.png" class="img-fluid" alt="Lihat Semua Buku">
                    <div class="portfolio-info">
                        <h4>Lihat Semua Buku</h4>
                        <p>Klik di sini untuk melihat semua buku</p>
                        <div class="portfolio-links">
                        <a href="semua_buku.php" title="Lihat Semua Buku"><i class="bi bi-three-dots"></i></a>
                        </div>
                    </div>
                    </div>
                    <div style="text-align:center;">
                    <h5>View All Ebooks</h5>
                    <p>Click here to view all ebooks</p>
                    </div>
                </div>';
                }
            } else {
                echo "Tidak ada data buku yang tersedia.";
            }
            ?>
            </div>
        </div>
        </section><!-- End Portfolio Section -->

        <?php
        // Pastikan koneksi dan session sudah dimulai sebelum bagian ini
        if (isset($_GET['id_buku']) && is_numeric($_GET['id_buku'])) {
            $id_buku = (int)$_GET['id_buku'];

            // Ambil komentar utama (parent_id NULL atau 0)
            $query_komentar = "SELECT komentar.*, pengguna.nama_pengguna, pengguna.profile 
                FROM komentar
                INNER JOIN pengguna ON komentar.id_pengguna = pengguna.id_pengguna
                WHERE komentar.id_buku = $id_buku AND (komentar.parent_id IS NULL OR komentar.parent_id = 0)
                ORDER BY komentar.tanggal_komentar DESC";
            $result_komentar = mysqli_query($koneksi, $query_komentar);
        ?>

        <section>
            <div class="container my-5 py-5">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-12 col-lg-10 col-xl-8">

                        <?php
                        if (isset($_GET['id_buku']) && is_numeric($_GET['id_buku'])) {
                            $id_buku = (int)$_GET['id_buku'];

                            $query_komentar = "SELECT komentar.*, pengguna.nama_pengguna, pengguna.profile, komentar.rating
                                FROM komentar
                                INNER JOIN pengguna ON komentar.id_pengguna = pengguna.id_pengguna
                                WHERE komentar.id_buku = $id_buku AND (komentar.parent_id IS NULL OR komentar.parent_id = 0)
                                ORDER BY komentar.tanggal_komentar DESC";
                            $result_komentar = mysqli_query($koneksi, $query_komentar);

                            if ($result_komentar && mysqli_num_rows($result_komentar) > 0) {
                                while ($row = mysqli_fetch_assoc($result_komentar)) {
                                    $id_komentar = (int)$row["id_komentar"];
                                    $id_pengguna_komentar = (int)$row["id_pengguna"];
                                    $nama_pengguna = htmlspecialchars($row["nama_pengguna"]);
                                    $isi_komentar = htmlspecialchars($row["isi_komentar"]);
                                    $tanggal_komentar = date('d M Y, H:i', strtotime($row["tanggal_komentar"]));
                                    $profile_image = !empty($row["profile"]) ? "../assets/img/profile/" . htmlspecialchars($row["profile"]) : "https://mdbcdn.b-cdn.net/img/Photos/Avatars/default-avatar.webp";
                                    $rating = (float)$row['rating'];

                                    $query_reply = "SELECT komentar.*, pengguna.nama_pengguna, pengguna.profile 
                                        FROM komentar
                                        INNER JOIN pengguna ON komentar.id_pengguna = pengguna.id_pengguna
                                        WHERE komentar.parent_id = $id_komentar
                                        ORDER BY komentar.tanggal_komentar ASC";
                                    $result_reply = mysqli_query($koneksi, $query_reply);

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
                                    echo '</div>
                                        </div>
                                        <div style="flex: 1; padding: 15px; border-radius: 8px; max-height: 100%;">';

                                    if ($result_reply && mysqli_num_rows($result_reply) > 0) {
                                        while ($rep = mysqli_fetch_assoc($result_reply)) {
                                            $nama_reply = htmlspecialchars($rep["nama_pengguna"]);
                                            $isi_reply = htmlspecialchars($rep["isi_komentar"]);
                                            $tanggal_reply = date('d M Y, H:i', strtotime($rep["tanggal_komentar"]));
                                            $profile_reply = !empty($rep["profile"]) ? "../assets/img/profile/" . htmlspecialchars($rep["profile"]) : "https://mdbcdn.b-cdn.net/img/Photos/Avatars/default-avatar.webp";

                                            echo '
                                            <div style="margin-bottom: 15px; border-bottom: 1px solid #ddd; padding-bottom: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.08); border-radius: 6px;">
                                                <div style="display: flex; align-items: center; gap: 10px;">
                                                    <img class="rounded-circle" src="' . $profile_reply . '" alt="avatar" width="40" height="40" />
                                                    <div>
                                                        <h6 class="fw-bold text-secondary mb-1" style="font-size: 0.9rem;">' . $nama_reply . '</h6>
                                                        <p class="text-muted small mb-0" style="font-size: 0.75rem;">' . $tanggal_reply . '</p>
                                                    </div>
                                                </div>
                                                <p style="margin-left: 50px; white-space: pre-line;">' . nl2br($isi_reply) . '</p>
                                            </div>';
                                        }
                                    }
                                    echo '</div>
                                    </div>';
                                }
                            } else {
                                echo '<p class="text-center">There are no comments for this book yet.</p>';
                            }
                        } else {
                            echo '<p class="text-center">ID buku tidak valid.</p>';
                        }
                        ?>
                        <?php if (isset($_SESSION['id_pengguna'])) : ?>
                            <form id="comment-form" method="post" action="tambah_komentar.php" style="background: transparent; margin-top: 20px;">
                                <input type="hidden" name="id_buku" value="<?php echo htmlspecialchars($id_buku ?? ''); ?>">
                                <input type="hidden" name="rating" id="rating-value" value="0">

                                <div class="d-flex gap-3 align-items-center"> <!-- Tambah align-items-start -->
                                    <img class="rounded-circle" src="<?php echo isset($_SESSION['profile']) ? '../assets/img/profile/' . htmlspecialchars($_SESSION['profile']) : 'https://mdbcdn.b-cdn.net/img/Photos/Avatars/default-avatar.webp'; ?>" alt="avatar" width="50" height="50" />

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
                            <p class="text-center">Silakan <a href="login.php">login</a> untuk menulis komentar.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <?php } else {
            echo '<p class="text-center">ID buku tidak valid.</p>';
        } ?>

        <!-- Modal Edit Komentar -->
        <div class="modal fade" id="editKomentarModal" tabindex="-1" aria-labelledby="editKomentarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editKomentarModalLabel">Edit Komentar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editKomentarForm" method="post" action="edit_komentar.php">
                            <input type="hidden" id="edit_id_komentar" name="id_komentar" value="">
                            <input type="hidden" id="edit_id_buku" name="id_buku" value="<?php echo htmlspecialchars($id_buku ?? ''); ?>">
                            <input type="hidden" name="rating" id="edit_rating_value" value="0">

                            <div id="edit_star_rating" style="font-size: 24px; color: #ddd; cursor: pointer; user-select: none; margin-bottom: 5px; display: inline-block;">
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <i class="bi bi-star" data-value="<?php echo $i; ?>"></i>
                                <?php endfor; ?>
                            </div>

                            <div class="mb-3">
                                <textarea class="form-control" id="edit_isi_komentar" name="isi_komentar" rows="3" placeholder="Tulis komentar..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Hapus Komentar -->
        <div class="modal fade" id="hapusKomentarModal" tabindex="-1" aria-labelledby="hapusKomentarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="hapusKomentarModalLabel">Hapus Komentar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus komentar ini?</p>
                        <form id="hapusKomentarForm" method="post" action="hapus_komentar.php">
                            <input type="hidden" id="hapus_id_komentar" name="id_komentar" value="">
                            <input type="hidden" id="hapus_id_buku" name="id_buku" value="<?php echo htmlspecialchars($id_buku ?? ''); ?>">
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
        // Script isi data Modal Edit
        var editKomentarModal = document.getElementById('editKomentarModal');
        editKomentarModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var idKomentar = button.getAttribute('data-id_komentar');
            var isiKomentar = button.getAttribute('data-isi_komentar');
            var rating = parseFloat(button.getAttribute('data-rating')) || 0;

            var modalInputId = editKomentarModal.querySelector('#edit_id_komentar');
            var modalTextareaIsi = editKomentarModal.querySelector('#edit_isi_komentar');
            var ratingInput = editKomentarModal.querySelector('#edit_rating_value');

            modalInputId.value = idKomentar;
            modalTextareaIsi.value = isiKomentar;
            ratingInput.value = rating;
            highlightEditStars(rating);
        });

        // Script isi data Modal Hapus
        var hapusKomentarModal = document.getElementById('hapusKomentarModal');
        hapusKomentarModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var idKomentar = button.getAttribute('data-id_komentar');

            var modalInputId = hapusKomentarModal.querySelector('#hapus_id_komentar');
            modalInputId.value = idKomentar;
        });

        // Script Rating Edit Modal (sama dengan tambah komentar)
        const editStars = document.querySelectorAll('#edit_star_rating i');
        const editRatingInput = document.getElementById('edit_rating_value');

        let selectedEditRating = 0;

        editStars.forEach((star, idx) => {
            star.addEventListener('mousemove', (e) => {
                const rect = star.getBoundingClientRect();
                const mouseX = e.clientX;
                const starMiddle = rect.left + rect.width / 2;
                let hoverValue = idx + 1;

                if (mouseX < starMiddle) {
                    hoverValue -= 0.5;
                }
                highlightEditStars(hoverValue);
            });

            star.addEventListener('click', (e) => {
                const rect = star.getBoundingClientRect();
                const mouseX = e.clientX;
                const starMiddle = rect.left + rect.width / 2;
                selectedEditRating = idx + 1;

                if (mouseX < starMiddle) {
                    selectedEditRating -= 0.5;
                }

                editRatingInput.value = selectedEditRating;
                highlightEditStars(selectedEditRating);
            });

            star.addEventListener('mouseout', () => {
                highlightEditStars(selectedEditRating);
            });
        });

        function highlightEditStars(rating) {
            editStars.forEach((star, idx) => {
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

    </main><!-- End #main -->

    <?php include 'footer.php' ?>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="../assets//vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="../assets//vendor/aos/aos.js"></script>
    <script src="../assets//vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets//vendor/glightbox/js/glightbox.min.js"></script>
    <script src="../assets//vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="../assets//vendor/swiper/swiper-bundle.min.js"></script>
    <script src="../assets//vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="../assets//js/main.js"></script>

</body>

</html>