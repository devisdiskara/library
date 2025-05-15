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
                                        <img src="../assets/img/ebook/<?php echo $row_buku_bawahnya["gambar_sampul"]; ?>" class="img-fluid" alt="<?php echo $row_buku_bawahnya["judul"]; ?>">
                                        <div class="portfolio-info">
                                            <h4><?php echo $row_buku_bawahnya["judul"]; ?></h4>
                                            <p><?php echo $row_buku_bawahnya["nama_kategori"]; ?></p>
                                            <div class="portfolio-links">
                                                <a href="../assets/img/ebook/<?php echo $row_buku_bawahnya["gambar_sampul"]; ?>" data-gallery="portfolioGallery" class="portfokio-lightbox" title="<?php echo $row_buku_bawahnya["judul"]; ?>"><i class="bi bi-plus"></i></a>
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
                    <h2>Comments on this Ebook</h2>
                    <p>Reader Testimonials on This ebook</p>
                </header>
                <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="200">
                    <div class="swiper-wrapper">
                        <!-- Tempat untuk menampilkan komentar -->
                        <?php
                        // Periksa apakah ID buku ada dan valid
                        if (isset($_GET['id_buku']) && is_numeric($_GET['id_buku'])) {
                            $id_buku = $_GET['id_buku'];

                            // Lakukan query untuk mengambil ulasan dan rating dari tabel komentar
                            $query_komentar = "SELECT komentar.*, pengguna.nama_pengguna, pengguna.profile 
                    FROM komentar
                    INNER JOIN pengguna ON komentar.id_pengguna = pengguna.id_pengguna
                    WHERE komentar.id_buku = $id_buku";
                            $result_komentar = mysqli_query($koneksi, $query_komentar);

                            // Periksa apakah query berhasil dieksekusi
                            if ($result_komentar && mysqli_num_rows($result_komentar) > 0) {
                                // Loop untuk menampilkan setiap ulasan
                                while ($row_komentar = mysqli_fetch_assoc($result_komentar)) {
                                    // Sanitisasi data sebelum ditampilkan
                                    $id_komentar = htmlspecialchars($row_komentar["id_komentar"]);
                                    $nama_pengguna = htmlspecialchars($row_komentar["nama_pengguna"]);
                                    $isi_komentar = htmlspecialchars($row_komentar["isi_komentar"]);
                                    $tanggal_komentar = htmlspecialchars($row_komentar["tanggal_komentar"]);
                                    $profile_image = htmlspecialchars($row_komentar["profile"]);

                                    echo '<div class="swiper-slide">
                <div class="testimonial-item">
                    <div class="text-center">
                        <img src="../assets/img/profile/' . $profile_image . '" alt="Avatar" style="max-width: 150px;" class="rounded-circle">
                        <h5>' . $nama_pengguna . '</h5>
                        <div>
                            <button class="btn btn-warning btn-edit" data-id="' . $id_komentar . '" data-isi="' . $isi_komentar . '">Edit</button>
                            <button class="btn btn-danger btn-hapus" data-id="' . $id_komentar . '">Hapus</button>
                        </div>
                    </div>
                    <div class="text-center">
                        <h5 style="word-wrap: break-word;">' . $isi_komentar . '</h5>
                        <h6>Waktu: ' . $tanggal_komentar . '</h6>
                    </div>
                </div>
            </div><!-- End testimonial item -->';
                                }
                            } else {
                                echo "<div class='swiper-slide'><div class='testimonial-item'><p class='text-center'>There are no comments for this book yet.</p></div></div>";
                            }
                        } else {
                            echo "<div class='swiper-slide'><div class='testimonial-item'><p class='text-center'>ID buku tidak valid.</p></div></div>";
                        }
                        ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>

                <!-- Formulir untuk menulis komentar -->
                <?php if (isset($_SESSION['id_pengguna'])) : ?>
                    <form id="comment-form" method="post" action="tambah_komentar.php">
                        <input type="hidden" name="id_buku" value="<?php echo htmlspecialchars($id_buku); ?>">
                        <div class="form-group">
                            <label for="isi_komentar">Tulis komentar:</label>
                            <textarea id="isi_komentar" name="isi_komentar" class="form-control" rows="4" required></textarea>
                        </div><br>
                        <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                    </form>
                <?php else : ?>
                    <p>Silakan <a href="login.php">login</a> untuk menulis komentar.</p>
                <?php endif; ?>
            </div>
        </section> <!-- End Tempat Komentar untuk Buku -->


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
                            <input type="hidden" id="edit_id_buku" name="id_buku" value="<?php echo htmlspecialchars($id_buku); ?>">
                            <div class="mb-3">
                                <label for="edit_isi_komentar" class="form-label">Komentar:</label>
                                <textarea class="form-control" id="edit_isi_komentar" name="isi_komentar" rows="3"></textarea>
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
                            <input type="hidden" id="hapus_id_buku" name="id_buku" value="<?php echo htmlspecialchars($id_buku); ?>">
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Tambahkan JavaScript di sini -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Edit button click event
                document.querySelectorAll('.btn-edit').forEach(function(button) {
                    button.addEventListener('click', function() {
                        var idKomentar = this.getAttribute('data-id');
                        var isiKomentar = this.getAttribute('data-isi');

                        document.getElementById('edit_id_komentar').value = idKomentar;
                        document.getElementById('edit_isi_komentar').value = isiKomentar;

                        var editKomentarModal = new bootstrap.Modal(document.getElementById('editKomentarModal'));
                        editKomentarModal.show();
                    });
                });

                // Hapus button click event
                document.querySelectorAll('.btn-hapus').forEach(function(button) {
                    button.addEventListener('click', function() {
                        var idKomentar = this.getAttribute('data-id');

                        document.getElementById('hapus_id_komentar').value = idKomentar;

                        var hapusKomentarModal = new bootstrap.Modal(document.getElementById('hapusKomentarModal'));
                        hapusKomentarModal.show();
                    });
                });
            });
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