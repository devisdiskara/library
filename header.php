<!-- ======= Header ======= -->
<header id="header" class="header fixed-top">
  <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

    <a href="index.php" class="logo d-flex align-items-center">
      <img src="assets/img/favicon/log.ico" alt="">
      <span>FlexiLibrary</span>
    </a>

    <nav id="navbar" class="navbar">
      <ul>
        <li><a class="nav-link scrollto active" href="index.php">Beranda</a></li>
        <li><a class="nav-link scrollto" href="index.php#about">Tentang</a></li>
        <li><a class="nav-link scrollto" href="index.php#tempat-buku-populer">Ebook Terpopuler</a></li>
        <li><a class="nav-link scrollto" href="index.php#daftar-buku">Koleksi Ebook</a></li>
        <li><a class="nav-link scrollto" href="index.php#kontak">Kontak</a></li>

        <!-- Favorite -->
        <li>
          <a class="nav-link scrollto" href="#" onclick="showLoginModal('favorite')">
            <i class="bi bi-heart-fill" style="font-size: 19px;" title="Favorite ebook"></i>
          </a>
        </li>

        <!-- Download History -->
        <li>
          <a class="nav-link scrollto" href="#" onclick="showLoginModal('download')">
            <i class="bi bi-file-arrow-down-fill" style="font-size: 19px;" title="Riwayat Unduhan"></i>
          </a>
        </li>

        <!-- Donasi Ebook
        <li>
          <a class="nav-link scrollto" href="#" onclick="showLoginModal('donate')">
            <i class="bi-bookmark-plus-fill" style="font-size: 19px;" title="Donasi Ebook"></i>
          </a>
        </li> -->

        <!-- Gabung -->
        <li><a class="getstarted scrollto" href="pengguna/">Gabung Sekarang</a></li>
      </ul>

      <i class="bi bi-list mobile-nav-toggle"></i>
    </nav><!-- .navbar -->

  </div>
</header><!-- End Header -->

<!-- Modal Bootstrap untuk menampilkan pesan -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #3498db; border-bottom: none;">
        <h5 class="modal-title" id="loginModalLabel" style="color: #fff;">Error</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="background-color: #fff; color: #000; display: flex; justify-content: space-between; align-items: center;">
        <p style="margin: 0;">Anda harus masuk terlebih dahulu.</p>
        <button type="button" class="btn btn-primary" onclick="window.location.href='pengguna/';" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript untuk menampilkan modal -->
<script>
  // Fungsi untuk menampilkan modal login
  function showLoginModal(action) {
    var modal = new bootstrap.Modal(document.getElementById('loginModal'), {
      keyboard: false // Mencegah modal ditutup dengan tombol keyboard
    });
    modal.show();
  }
</script>
