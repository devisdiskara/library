<?php
// Include koneksi ke database
include '../koneksi.php';
session_start();

// Gunakan id_pengguna sebagai acuan utama
if (!isset($_SESSION['id_pengguna'])) {
  die("Sesi belum diset. Silakan login terlebih dahulu.");
}

$id_pengguna = $_SESSION['id_pengguna'];

// Ambil data pengguna berdasarkan ID
$query = "SELECT nama_pengguna, username, bio, negara, email, profile, facebook, instagram FROM pengguna WHERE id_pengguna = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "i", $id_pengguna);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
  $nama_pengguna   = $row['nama_pengguna'];
  $username        = $row['username'];
  $bio             = $row['bio'];
  $negara          = $row['negara'];
  $email           = $row['email'];
  $profile_picture = $row['profile'];
  $facebook_link   = $row['facebook'];
  $instagram_link  = $row['instagram'];

  // URL gambar profil
  $url_gambar_profil = "../assets/img/profile/" . $profile_picture;
} else {
  // Default jika data tidak ditemukan
  $nama_pengguna   = "Tidak ditemukan";
  $username        = "Tidak ditemukan";
  $bio             = "Tidak ditemukan";
  $negara          = "Tidak ditemukan";
  $email           = "Tidak ditemukan";
  $profile_picture = "profile.png";
  $facebook_link   = "#";
  $instagram_link  = "#";

  $url_gambar_profil = "../assets/img/avatars/profile.png";
}

// Tutup statement dan koneksi
mysqli_stmt_close($stmt);
mysqli_close($koneksi);
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Profile Fauzan - Flexilibrary</title>
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

  <style>
    .nav-tabs .nav-link {
      color: black;
      border: none;
      background: transparent;
      position: relative;
      transition: color 0.3s, border-color 0.3s;
    }

    .nav-tabs .nav-link.active {
      color: blue;
    }

    .nav-tabs .nav-link::after {
      content: '';
      display: block;
      width: 100%;
      height: 2px;
      background: transparent;
      position: absolute;
      bottom: -1px;
      left: 0;
      transition: background 0.3s;
    }

    .nav-tabs .nav-link.active::after {
      background: blue;
    }

    .social-links a {
      margin-right: 10px;
      color: #8094B7;
      font-size: 20px;
    }
  </style>

</head>

<body>

  <?php include 'header.php'; ?>

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">
        <ol>
          <li><a href="page.php">Beranda</a></li>
          <li>Profile</li>
        </ol>
        <h2>Profile</h2>
      </div>
    </section><!-- End Breadcrumbs -->

   <!-- Profile Section -->
<section class="section profile">
  <div class="container">
    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="page.php">Beranda</a></li>
          <li class="breadcrumb-item">Pengguna</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div>

    <div class="row">
      <div class="col-xl-4">
        <div class="card">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
            <img src="<?php echo htmlspecialchars($url_gambar_profil); ?>" alt="Profile" class="rounded-circle" width="150" height="150" style="object-fit: cover;">
            <h2><?php echo htmlspecialchars($username); ?></h2>
            <div class="social-links mt-2">
              <a href="<?php echo htmlspecialchars($facebook_link); ?>" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="<?php echo htmlspecialchars($instagram_link); ?>" class="instagram"><i class="bi bi-instagram"></i></a>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-8">
        <div class="card">
          <div class="card-body pt-3">
            <ul class="nav nav-tabs nav-tabs-bordered">
              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Ringkasan</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Ubah Password</button>
              </li>
            </ul>

            <div class="tab-content pt-2">
              <div class="tab-pane fade show active profile-overview" id="profile-overview"><br>
                <h5 class="card-title">Bio</h5><br>
                <p class="col-lg-9 col-md-8"><?php echo htmlspecialchars($bio); ?></p><br>
                <h5 class="card-title">Detail Profil</h5><br>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label fw-bold text-muted">Nama Lengkap</div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($nama_pengguna); ?></div>
                </div><br>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label fw-bold text-muted">Username</div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($username); ?></div>
                </div><br>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label fw-bold text-muted">Negara</div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($negara); ?></div>
                </div><br>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label fw-bold text-muted">Email</div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($email); ?></div>
                </div><br>
              </div>

              <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                <form id="editProfileForm" action="edit_profile.php" method="POST" enctype="multipart/form-data">
                  <div class="row mb-3">
                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Photo Profile</label>
                    <div class="col-md-8 col-lg-9">
                      <img src="<?php echo htmlspecialchars($url_gambar_profil); ?>" alt="Profile" id="profileImagePreview" width="150" height="150">
                      <div class="pt-2">
                        <input type="file" id="profileImage" name="profileImage" accept="image/*" onchange="previewProfileImage(event)">
                      </div>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="nama_pengguna" class="col-md-4 col-lg-3 col-form-label">Nama Lengkap</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="nama_pengguna" type="text" class="form-control" id="nama_pengguna" value="<?php echo htmlspecialchars($nama_pengguna); ?>">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="username" class="col-md-4 col-lg-3 col-form-label">Username</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="username" type="text" class="form-control" id="username" value="<?php echo htmlspecialchars($username); ?>">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="bio" class="col-md-4 col-lg-3 col-form-label">Bio</label>
                    <div class="col-md-8 col-lg-9">
                      <textarea name="bio" class="form-control" id="bio" style="height: 100px"><?php echo htmlspecialchars($bio); ?></textarea>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="country" class="col-md-4 col-lg-3 col-form-label">Negara</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="country" type="text" class="form-control" id="country" value="<?php echo htmlspecialchars($negara); ?>">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="email" type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($email); ?>">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="facebook" class="col-md-4 col-lg-3 col-form-label">Facebook Profile</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="facebook" type="text" class="form-control" id="facebook" value="<?php echo htmlspecialchars($facebook_link); ?>">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="instagram" class="col-md-4 col-lg-3 col-form-label">Instagram Profile</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="instagram" type="text" class="form-control" id="instagram" value="<?php echo htmlspecialchars($instagram_link); ?>">
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save Perubahan</button>
                  </div>
                </form>
              </div>

              <div class="tab-pane fade pt-3" id="profile-change-password">
                <form action="change_password.php" method="POST">
                  <div class="row mb-3">
                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Kata Sandi Saat Ini</label>
                    <div class="col-md-8 col-lg-9 input-group">
                      <input name="currentPassword" type="password" class="form-control" id="currentPassword">
                      <button type="button" class="btn btn-outline-secondary" id="toggleCurrentPassword">
                        <i class="bi bi-eye-slash"></i>
                      </button>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Password Baru</label>
                    <div class="col-md-8 col-lg-9 input-group">
                      <input name="newPassword" type="password" class="form-control" id="newPassword">
                      <button type="button" class="btn btn-outline-secondary" id="toggleNewPassword">
                        <i class="bi bi-eye-slash"></i>
                      </button>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Masukkan kembali kata sandi baru</label>
                    <div class="col-md-8 col-lg-9 input-group">
                      <input name="renewPassword" type="password" class="form-control" id="renewPassword">
                      <button type="button" class="btn btn-outline-secondary" id="toggleReNewPassword">
                        <i class="bi bi-eye-slash"></i>
                      </button>
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Ubah Password</button>
                  </div>
                </form>

                <script>
                  document.addEventListener('DOMContentLoaded', function () {
                    document.querySelectorAll('[id^="toggle"]').forEach(btn => {
                      btn.addEventListener('click', function () {
                        const input = btn.previousElementSibling;
                        const icon = btn.querySelector('i');
                        if (input.type === "password") {
                          input.type = "text";
                          icon.classList.replace('bi-eye-slash', 'bi-eye');
                        } else {
                          input.type = "password";
                          icon.classList.replace('bi-eye', 'bi-eye-slash');
                        }
                      });
                    });
                  });
                </script>

              </div>
            </div>
          </div>
        </div>
      </div>
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

  <script>
    function previewProfileImage(event) {
      const reader = new FileReader();
      reader.onload = function() {
        const output = document.getElementById('profileImagePreview');
        output.src = reader.result;
      };
      reader.readAsDataURL(event.target.files[0]);
    }
  </script>

</body>

</html>