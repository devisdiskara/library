<?php
include '../koneksi.php';
session_start();

// Contoh query untuk mendapatkan data pengguna berdasarkan session ID pengguna
$id_pengguna = $_SESSION['id_pengguna'];
$query = "SELECT * FROM pengguna WHERE id_pengguna = ?";
$stmt = $koneksi->prepare($query);

if ($stmt === false) {
    die('Prepare statement failed: ' . htmlspecialchars($koneksi->error));
}

$stmt->bind_param("i", $id_pengguna);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    // Simpan data pengguna dalam sesi
    $_SESSION['username'] = $user['username'];
    $_SESSION['profile'] = $user['profile'];
    
    // Tambahan: simpan juga nama lengkap dan email
    $_SESSION['nama_pengguna'] = $user['nama_pengguna'];
    $_SESSION['email'] = $user['email'];
}

// Cek apakah ada permintaan logout
if (isset($_GET['logout'])) {
    // Hapus semua data session
    session_destroy();
    
    // Redirect ke halaman login atau halaman lain yang sesuai
    header("Location: login.php"); // Ganti dengan halaman login yang sesuai
    exit;
}

$stmt->close(); // Pastikan statement ditutup setelah selesai digunakan

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

  <title>Beranda - Flexilibrary</title>
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

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-flex flex-column justify-content-center">
          <h1 data-aos="fade-up">FlexiLibrary!</h1>
          <h2 data-aos="fade-up" data-aos-delay="400">Perpustakaan digital yang memberikan akses gratis ke ribuan eBook dari berbagai genre dan penulis ternama.</h2>
          <div data-aos="fade-up" data-aos-delay="600">
            <div class="text-center text-lg-start">
            </div>
          </div>
        </div>
        <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200">
          <img src="../assets/img/hero-img.png" class="img-fluid" alt="">
        </div>
      </div>
    </div>

  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">

      <div class="container" data-aos="fade-up">
        <div class="row gx-0">

          <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
            <div class="content">
              <h3>Siapa Kami</h3>
              <h2>Selamat datang di FlexiLibrary,</h2>
              <p>
                              Tempat terbaik Anda untuk mengunduh eBook digital secara gratis. Di FlexiLibrary, kami percaya bahwa pengetahuan seharusnya dapat diakses oleh siapapun, kapanpun dan dimanapun. Misi kami adalah menyediakan koleksi besar eBook berkualitas tinggi dari berbagai genre dan bidang, yang dapat diunduh secara gratis oleh para pengguna kami.
              </p>
              <div class="text-center text-lg-start">
                <a href="aboutpen.php" class="btn-read-more d-inline-flex align-items-center justify-content-center align-self-center">
                  <span>Baca selengkapnya</span>
                  <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>

          <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
            <img src="../assets/img/tentang.jpeg" class="img-fluid" alt="">
          </div>

        </div>
      </div>

    </section><!-- End About Section -->

    <!-- ======= Tempat Buku Populer ======= -->
    <section id="tempat-buku-populer" class="testimonials">
        <div class="container" data-aos="fade-up">
          <header class="section-header">
            <h2>E-book Terpopuler</h2>
            <p>E-book teratas dari berbagai genre</p>
          </header>
          <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="200">
            <div class="swiper-wrapper">
              <?php
              $query = "SELECT * FROM buku WHERE jumlah_unduhan > 5 ORDER BY jumlah_unduhan DESC LIMIT 5";
              $result = mysqli_query($koneksi, $query);

              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  $rating = floatval($row['rating']);
                  $fullStars = floor($rating);
                  $halfStars = ($rating - $fullStars) >= 0.5 ? 1 : 0;
                  $emptyStars = 5 - $fullStars - $halfStars;

                  echo '<div class="swiper-slide">
                          <div class="testimonial-item">
                            <img src="../assets/img/ebook/' . $row["gambar_sampul"] . '" alt="' . $row["judul"] . '" style="max-width: 200px; display: block; margin: 0 auto;">
                            <hr>
                            <p>' . $row["judul"] . '</p>
                            <div class="rating">';
                  
                  for ($i = 0; $i < $fullStars; $i++) {
                    echo '<i class="bi bi-star-fill" style="color: #f7c600;"></i>';
                  }

                  if ($halfStars) {
                    echo '<i class="bi bi-star-half" style="color: #f7c600;"></i>';
                  }

                  for ($i = 0; $i < $emptyStars; $i++) {
                    echo '<i class="bi-star-fill" style="color: black;"></i>';
                  }

                  echo '</div>
                          </div>
                        </div><!-- End testimonial item -->';
                }
              } else {
                echo "Tidak ada ebook populer dengan jumlah unduhan lebih dari 5.";
              }
              ?>
            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
    </section><!-- End Tempat ebook Populer -->

    <!-- ======= Counts Section ======= -->
    <section id="counts" class="counts">
      <div class="container" data-aos="fade-up">
        <div class="row gy-4">
          <div class="col-lg-3 col-md-6">
            <div class="count-box">
              <i class="bi bi-people"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="<?php echo $total_pengguna; ?>" data-purecounter-duration="1" class="purecounter"></span>
                <p>Pengguna</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="count-box">
              <i class="bi bi-book"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="<?php echo $total_buku; ?>" data-purecounter-duration="1" class="purecounter"></span>
                <p>Ebook</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="count-box">
              <i class="bi bi-tags"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="<?php echo $total_kategori; ?>" data-purecounter-duration="1" class="purecounter"></span>
                <p>Kategori</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <div class="count-box">
              <i class="bi bi-chat-dots"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="<?php echo $total_komentar; ?>" data-purecounter-duration="1" class="purecounter"></span>
                <p>Komentar</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Counts Section -->

    <!-- ======= Daftar Buku Section ======= -->
    <section id="daftar-buku" class="portfolio" style="overflow-y: auto;">
      <div class="container" data-aos="fade-up">
        <header class="section-header">
          <h2>koleksi Ebook</h2>
          <p>Jelajahi koleksi ebook lengkap kami di sini</p>
        </header>
        <style>
          .portfolio-item .portfolio-wrap img {
            height: 500px;
            object-fit: cover;
          }

          /* Optional: Center the animation effect when scrolling */
          .portfolio-item {
            display: flex;
            justify-content: center;
            align-items: center;
          }
        </style>
        <div class="row gy-4 portfolio-container" data-aos="fade-up" data-aos-delay="200">
          <?php

          $query_buku = "
          SELECT 
            b.*,
            IFNULL(ROUND(AVG(k.rating), 1), 0) AS rating,
            (SELECT COUNT(*) FROM unduhan u WHERE u.id_buku = b.id_buku) AS jumlah_unduhan
          FROM buku b
          LEFT JOIN komentar k ON b.id_buku = k.id_buku
          GROUP BY b.id_buku
          ORDER BY b.tanggal_upload DESC
          LIMIT 5
        ";

          $result_buku = mysqli_query($koneksi, $query_buku);


          if (mysqli_num_rows($result_buku) > 0) {

            $counter = 0;

            while ($row_buku = mysqli_fetch_assoc($result_buku)) {

              $rating = $row_buku["rating"];
              $fullStars = floor($rating);  
              $halfStars = ($rating - $fullStars >= 0.5) ? 1 : 0; 
              $emptyStars = 5 - $fullStars - $halfStars;  
            
              echo '<div class="col-lg-4 col-md-6 portfolio-item filter-app" data-aos="fade-up" data-aos-delay="' . (100 * $counter) . '">
                <div class="portfolio-wrap">
                  <img src="../assets/img/ebook/' . $row_buku["gambar_sampul"] . '" class="img-fluid" alt="' . $row_buku["judul"] . '">
                  <div class="portfolio-info">
                    <div class="rating" style="position: absolute; top: 10px; left: 10px; color: #000000; padding: 5px 10px; border-radius: 5px; font-weight: bold;">
                      ';
            
              for ($i = 0; $i < $fullStars; $i++) {
                echo '<i class="bi bi-star-fill" style="color: #f7c600;"></i>';
              }
            
              if ($halfStars) {
                echo '<i class="bi bi-star-half" style="color: #f7c600;"></i>';
              }
            
              for ($i = 0; $i < $emptyStars; $i++) {
                echo '<i class="bi-star-fill" style="color: black;"></i>';
              }         
              echo '</div>
                    <div class="portfolio-links">
                      <a href="detail_buku.php?id_buku=' . $row_buku["id_buku"] . '" title="More Details"><i class="bi bi-eye"></i></a>
                    </div>
                  </div>
                </div>
              </div>';
            
              $counter++;
           
              if ($counter >= 5) {
                break;
              }
            }
            
            if ($counter >= 5) {
              echo '<div class="col-lg-4 col-md-6 portfolio-item filter-app" data-aos="fade-up" data-aos-delay="' . (100 * $counter) . '">
                <div class="portfolio-wrap">
                  <img src="../assets/img/ebook/book.png" class="img-fluid" alt="Lihat Semua Buku">
                  <div class="portfolio-info">
                    <h4>Lihat Semua Ebook</h4>
                    <p>Klik di sini untuk lihat semua ebook</p>
                    <div class="portfolio-links">
                      <a href="semuah_buku.php" title="Lihat Semua Buku"><i class="bi bi-three-dots"></i></a>
                    </div>
                  </div>
                </div>
              </div>';
            }
          } else {
            echo "Tidak ada data e-book yang tersedia";
          }
          ?>
        </div>
      </div>
    </section><!-- End Daftar Buku Section -->   

<!-- ======= Contact Section ======= -->
<section id="kontak" class="contact">
  <div class="container" data-aos="fade-up">

    <header class="section-header">
      <h2>Hubungi kami</h2>
      <p>Kontak dan Dukungan</p>
    </header>

    <div class="row gy-4">
      <!-- Info Kontak -->
      <div class="col-lg-6">
        <div class="row gy-4">
          <div class="col-md-6">
            <div class="info-box">
              <i class="bi bi-envelope"></i>
              <h3>Email</h3>
              <p>flexilibrary@gmail.com</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="info-box">
              <i class="bi bi-instagram"></i>
              <h3>Instagram</h3>
              <p>Flexilibrary</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="info-box">
              <i class="bi bi-telegram"></i>
              <h3>Telegram</h3>
              <p>@flexilibrary</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="info-box">
              <i class="bi bi-whatsapp"></i>
              <h3>WhatsApp</h3>
              <p>+62 853-1563-2509</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Form Kontak -->
      <div class="col-lg-6">
        <form id="contact-form" action="https://formspree.io/f/xnnvvdrd" method="post" class="php-email-form">
          <div class="row gy-4">

            <div class="col-md-6">
              <input type="text" id="name" class="form-control" name="name"
                value="<?php echo isset($_SESSION['nama_pengguna']) ? htmlspecialchars($_SESSION['nama_pengguna']) : ''; ?>" readonly>
            </div>

            <div class="col-md-6">
              <input type="email" id="email" class="form-control" name="email"
                value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" readonly>
            </div>

            <div class="col-md-12">
              <input type="text" id="subject" class="form-control" name="subject" placeholder="Subjek Pesan" required>
            </div>

            <div class="col-md-12">
              <textarea id="message" class="form-control" name="message" rows="6" placeholder="Isi Pesan Anda" required></textarea>
            </div>

            <div class="col-md-12 text-center">
              <div id="loading" style="display: none;">
                <i class="fas fa-spinner fa-spin" style="font-size: 24px;"></i>
              </div>
              <div id="error-message" style="display: none;"></div>
              <div id="sent-message" style="display: none;">
                Terima kasih atas pesan Anda!
              </div>
              <div id="thank-you-message" style="display: none; background-color: #4154F1; color: #fff; padding: 10px; border-radius: 5px; margin-top: 10px; position: relative;">
                Terima kasih atas pesan Anda!
                <i class="bi bi-x" id="close-thank-you" style="cursor: pointer; position: absolute; top: 5px; right: 5px;"></i>
              </div><br>
              <button id="submit-button" type="submit">Kirim Pesan</button>
            </div>

          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<!-- End Contact Section -->

<!-- Script untuk refresh saat notifikasi ditutup -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const thankYou = document.getElementById("thank-you-message");
    const closeBtn = document.getElementById("close-thank-you");

    // Jika Formspree berhasil, tampilkan thank-you-message
    const observer = new MutationObserver(function () {
      const sentMessage = document.getElementById("sent-message");
      if (sentMessage && sentMessage.style.display !== "none") {
        thankYou.style.display = "block";
      }
    });

    observer.observe(document.body, { childList: true, subtree: true });

    // Ketika X diklik, lakukan refresh halaman
    closeBtn.addEventListener("click", function () {
      thankYou.style.display = "none";
      location.reload();
    });
  });
</script>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById('contact-form');
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const subjectInput = document.getElementById('subject');
        const messageInput = document.getElementById('message');
        const loadingMessage = document.getElementById('loading');
        const errorMessage = document.getElementById('error-message');
        const sentMessage = document.getElementById('sent-message');
        const thankYouMessage = document.getElementById('thank-you-message');

        // Close Thank You message
        document.getElementById('close-thank-you').addEventListener('click', function() {
          thankYouMessage.style.display = 'none';
        });

        form.addEventListener('submit', function(event) {
          event.preventDefault(); // Menghentikan pengiriman formulir

          // Tampilkan pesan "Loading"
          loadingMessage.style.display = 'block';

          // Kirim data ke Formspree
          fetch(form.getAttribute('action'), {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify({
                name: nameInput.value,
                email: emailInput.value,
                subject: subjectInput.value,
                message: messageInput.value
              })
            })
            .then(response => {
              if (!response.ok) {
                throw new Error('Ada masalah saat mengirim pesan. Silakan coba lagi.');
              }
              loadingMessage.style.display = 'none';
              thankYouMessage.style.display = 'block';
              nameInput.value = '';
              emailInput.value = '';
              subjectInput.value = '';
              messageInput.value = '';
            })
            .catch(error => {
              // Terjadi kesalahan saat mengirim pesan
              // Sembunyikan pesan "Loading"
              loadingMessage.style.display = 'none';
              // Tampilkan pesan error
              errorMessage.innerText = error.message;
              errorMessage.style.display = 'block';
            });
        });
      });
    </script>

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