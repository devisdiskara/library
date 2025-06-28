<?php
include '../koneksi.php';
session_start();
if (!isset($_SESSION['login_pa'])) {
  header('location: index.php');
  exit;
}

// Inisialisasi variabel session
$role = $_SESSION['role'] ?? '';
$username = $_SESSION['username'] ?? '';
$profile = $_SESSION['profile'] ?? 'default.png';

// Refresh foto dari database jika admin
if ($role === 'admin') {
    $id_admin = $_SESSION['id_admin'];
    $query = mysqli_query($koneksi, "SELECT foto FROM admin WHERE id = '$id_admin'");
    if ($row = mysqli_fetch_assoc($query)) {
        $profile = $row['foto'] ?: 'default.png';
        $_SESSION['profile'] = $profile;
    }
}

// Path avatar
$avatar = ($role === 'admin')
  ? "../assetsadmin/img/avatars/" . $profile
  : "../assetsadmin/img/avatars/avatar.avif";

// Nama dan role tampilan
$displayName = ($role === 'super_admin') ? 'Super Admin' : $username;
$displayRole = ($role === 'super_admin') ? 'Super Admin' : 'Admin';

require_once 'page.php';
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assetsadmin/" data-template="vertical-menu-template-free">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Admin | FlexiLibrary</title>
  <link rel="icon" type="image/x-icon" href="../assetsadmin/img/favicon/log.ico" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../assetsadmin/vendor/fonts/boxicons.css" />
  <link rel="stylesheet" href="../assetsadmin/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../assetsadmin/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../assetsadmin/css/demo.css" />
  <link rel="stylesheet" href="../assetsadmin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="../assetsadmin/vendor/libs/apex-charts/apex-charts.css" />
  <script src="../assetsadmin/vendor/js/helpers.js"></script>
  <script src="../assetsadmin/js/config.js"></script>

  <!-- Tambahan CSS untuk Avatar 1:1 -->
  <style>
    .avatar-img {
      width: 40px;
      height: 40px;
      object-fit: cover;
      object-position: center;
      border-radius: 50%;
      display: block;
    }

    .avatar-lg {
      width: 100px;
      height: 100px;
    }
  </style>
</head>

<body>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <?php include 'sidebar.php'; ?>

      <div class="layout-page">
        <!-- Navbar -->
        <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
          <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
              <i class="bx bx-menu bx-sm"></i>
            </a>
          </div>
          <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <ul class="navbar-nav flex-row align-items-center ms-auto">
              <!-- Avatar -->
              <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                  <div class="avatar avatar-online">
                    <img src="<?= $avatar ?>" alt="Avatar" class="avatar-img" />
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li>
                    <a class="dropdown-item" href="#">
                      <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                          <div class="avatar avatar-online">
                            <img src="<?= $avatar ?>" alt="Avatar" class="avatar-img" />
                          </div>
                        </div>
                        <div class="flex-grow-1">
                          <span class="fw-semibold d-block"><?= $displayName ?></span>
                          <small class="text-muted"><?= $displayRole ?></small>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li><div class="dropdown-divider"></div></li>

                  <?php if ($role === 'admin') : ?>
                    <li>
                      <a class="dropdown-item" href="dashboard.php?page=profile_admin">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li>
                    <li><div class="dropdown-divider"></div></li>
                  <?php endif; ?>

                  <li>
                    <a class="dropdown-item" href="../index.php">
                      <i class="bx bx-power-off me-2"></i>
                      <span class="align-middle">Log Out</span>
                    </a>
                  </li>
                </ul>
              </li>
              <!--/ Avatar -->
            </ul>
          </div>
        </nav>

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
              <div class="col-lg-12 mb-4 order-0">
                <?php eval($CONTENT['main']); ?>
              </div>
            </div>
          </div>

          <!-- Footer -->
          <footer class="content-footer footer bg-footer-theme">
            <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
              <div class="mb-2 mb-md-0">
                © <script>document.write(new Date().getFullYear());</script>, made with ❤️ by
                <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">ThemeSelection</a>
              </div>
              <div>
                <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>
                <a href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/" target="_blank" class="footer-link me-4">Documentation</a>
                <a href="https://github.com/themeselection/sneat-html-admin-template-free/issues" target="_blank" class="footer-link me-4">Support</a>
              </div>
            </div>
          </footer>
          <!-- / Footer -->

          <div class="content-backdrop fade"></div>
        </div>
        <!-- / Content wrapper -->
      </div>
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>

  <!-- Core JS -->
  <script src="../assetsadmin/vendor/libs/jquery/jquery.js"></script>
  <script src="../assetsadmin/vendor/libs/popper/popper.js"></script>
  <script src="../assetsadmin/vendor/js/bootstrap.js"></script>
  <script src="../assetsadmin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../assetsadmin/vendor/js/menu.js"></script>
  <script src="../assetsadmin/vendor/libs/apex-charts/apexcharts.js"></script>
  <script src="../assetsadmin/js/main.js"></script>
  <script src="../assetsadmin/js/dashboards-analytics.js"></script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>
</html>
