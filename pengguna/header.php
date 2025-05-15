<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="../aslog/img/favicon/favicon.ico" />

<!-- Font -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

<!-- Ikon -->
<link rel="stylesheet" href="../aslog/vendor/fonts/boxicons.css" />

<!-- Core CSS -->
<link rel="stylesheet" href="../aslog/vendor/css/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="../aslog/css/demo.css" />

<!-- Vendor CSS -->
<link rel="stylesheet" href="../aslog/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
<link rel="stylesheet" href="../aslog/vendor/libs/apex-charts/apex-charts.css" />

<!-- Helpers -->
<script src="../aslog/vendor/js/helpers.js"></script>

<!-- Config: File konfigurasi tema -->
<script src="../aslog/js/config.js"></script>


<!-- ======= Header ======= -->
<header id="header" class="header fixed-top">
  <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

    <a href="index.php" class="logo d-flex align-items-center">
      <img src="../assets/img/favicon/log.ico" alt="">
      <span>Flexilibrary</span>
    </a>

    <nav id="navbar" class="navbar">
      <ul>
        <li><a class="nav-link scrollto active" href="index.php">Home</a></li>
        <li><a class="nav-link scrollto" href="index.php#about">About</a></li>
        <li><a class="nav-link scrollto" href="index.php#tempat-buku-populer">Populer Ebook</a></li>
        <li><a class="nav-link scrollto" href="index.php#daftar-buku">Ebook collection</a></li>
        <li><a class="nav-link scrollto" href="#kontak">Contact</a></li>
        <li><a class="nav-link scrollto" href="favorite.php"><i class="bi bi-heart-fill" style="font-size: 19px;" title="Favorite ebook"></i></a></li>
        <li><a class="nav-link scrollto" href="history_download.php"><i class="bi bi-file-arrow-down-fill" style="font-size: 19px;" title="download history"></i></a></li>
        <?php if (isset($_SESSION['login_pa'])) : ?>
        <?php else : ?>
          <li><a class="getstarted scrollto" href="../pengguna/">Get Started</a></li>
        <?php endif; ?>

        <li class="nav-item navbar-dropdown dropdown-user dropdown">
          <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
            <div class="avatar avatar-online">
              <img src="../assets/img/profile/<?php echo htmlspecialchars($_SESSION['profile']); ?>" width="35" height="35" alt class="w-px-40 h-auto rounded-circle" />
            </div>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <a class="dropdown-item" href="#">
                <div class="d-flex">
                  <div class="flex-shrink-0 me-3">
                    <div class="avatar avatar-online">
                      <img src="../assets/img/profile/<?php echo htmlspecialchars($_SESSION['profile']); ?>" width="35" height="35" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </div>
                  <div class="flex-grow-1">
                    <span style="font-size: 20px;" class="d-block"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                  </div>
                </div>
              </a>
            </li>
            <li>
              <div class="dropdown-divider"></div>
            </li>
            <li>
              <a class="dropdown-item" href="profile.php">
                <span class="d-flex align-items-center align-middle">
                  <i class="flex-shrink-0 bx bx-user me-2"></i>
                  <span class="flex-grow-1 align-middle">My Profile</span>
                </span>
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="notifikasi.php">
                <span class="d-flex align-items-center align-middle">
                  <i class="flex-shrink-0 bx bx-message me-2"></i>
                  <span class="flex-grow-1 align-middle">Message</span>
                  <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                </span>
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="#">
                <span class="d-flex align-items-center align-middle">
                  <i class="flex-shrink-0 bx bx-bell me-2"></i>
                  <span class="flex-grow-1 align-middle">Notification</span>
                  <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                </span>
              </a>
            </li>
            <li>
              <div class="dropdown-divider"></div>
            </li>
            <li>
              <a class="dropdown-item" href="../index.php?logout">
                <span class="d-flex align-items-center align-middle">
                  <i class="flex-shrink-0 bx bx-power-off me-2"></i>
                  <span class="flex-grow-1 align-middle">Logout</span>
                </span>
              </a>
            </li>
          </ul>
        </li>
      </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
    </nav><!-- .navbar -->

  </div>
</header><!-- End Header -->


<!-- Core JS -->
<script src="../aslog/vendor/libs/jquery/jquery.js"></script>
<script src="../aslog/vendor/libs/popper/popper.js"></script>
<script src="../aslog/vendor/js/bootstrap.js"></script>
<script src="../aslog/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<script src="../aslog/vendor/js/menu.js"></script>

<!-- Vendor JS -->
<script src="../aslog/vendor/libs/apex-charts/apexcharts.js"></script>

<!-- Main JS -->
<script src="../aslog/js/main.js"></script>