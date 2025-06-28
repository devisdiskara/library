<?php
// Koneksi ke database (ganti sesuai konfigurasi kamu)
include '../koneksi.php';

// Query menghitung jumlah ebook
$query = "SELECT COUNT(*) AS total_ebook FROM buku";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);
$jumlah_ebook = $data['total_ebook'];

// Hitung jumlah kategori
$query = "SELECT COUNT(*) AS total_kategori FROM kategori";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);
$jumlah_kategori = $data['total_kategori'];

// Hitung jumlah pengguna
$query = "SELECT COUNT(*) AS total_pengguna FROM pengguna";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);
$jumlah_pengguna = $data['total_pengguna'];

// Ambil ebook dengan unduhan paling sedikit
$query = "SELECT id_buku, judul, jumlah_unduhan FROM buku ORDER BY jumlah_unduhan ASC LIMIT 1";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);

$total_admin = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM admin");
$data_admin = mysqli_fetch_assoc($total_admin);
?>

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <!-- Card Ebook Kurang Diminati -->
    <div class="col-12 mb-4">
      <div class="card">
        <div class="d-flex align-items-end row">
          <div class="col-sm-7">
            <div class="card-body">
              <h5 class="card-title text-primary">Ebook Kurang Diminati 😞</h5>
              <p class="mb-4">
                <span class="fw-bold"><?= htmlspecialchars($data['judul']) ?></span><br>
                baru diunduh <span class="fw-bold"><?= $data['jumlah_unduhan'] ?></span> kali.
              </p>
              <a href="dashboard.php?page=buku" class="btn btn-sm btn-outline-primary">Tinjau Ebook</a>
            </div>
          </div>
          <div class="col-sm-5 text-center text-sm-left">
            <div class="card-body pb-0 px-0 px-md-4">
              <img src="../assetsadmin/img/illustrations/man-with-laptop-light.png" height="140" alt="Ebook Minim" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- 4 Card Statistik Sejajar -->
    <div class="col-12">
      <div class="row">
        <!-- Jumlah Ebook -->
        <div class="col-md-3 col-sm-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                  <i class="bx bx-book"></i>
                </div>
                <div class="dropdown">
                  <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="daftar-ebook.php">Lihat Semua</a>
                  </div>
                </div>
              </div>
              <span class="fw-semibold d-block mb-1">Jumlah Ebook</span>
              <h3 class="card-title mb-1"><?= $jumlah_ebook ?></h3>
              <small class="text-muted">ebook yang tersedia</small>
            </div>
          </div>
        </div>

        <!-- Jumlah Kategori -->
        <div class="col-md-3 col-sm-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                  <i class="bx bx-category"></i>
                </div>
                <div class="dropdown">
                  <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="kategori.php">Lihat Semua</a>
                  </div>
                </div>
              </div>
              <span>Jumlah Kategori</span>
              <h3 class="card-title mb-1"><?= $jumlah_kategori ?></h3>
              <small class="text-muted">kategori yang tersedia</small>
            </div>
          </div>
        </div>

        <!-- Jumlah Pengguna -->
        <div class="col-md-3 col-sm-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                  <i class="bx bx-user"></i>
                </div>
                <div class="dropdown">
                  <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="daftar-pengguna.php">Lihat Semua</a>
                  </div>
                </div>
              </div>
              <span>Jumlah Pengguna</span>
              <h3 class="card-title mb-1"><?= $jumlah_pengguna ?></h3>
              <small class="text-muted">pengguna yang online</small>
            </div>
          </div>
        </div>

        <!-- Total Admin -->
        <div class="col-md-3 col-sm-6 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <!-- Ikon admin -->
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                    style="width: 40px; height: 40px;">
                  <i class="bx bx-user-pin fs-4"></i>
                </div>
                <div class="dropdown">
                  <button class="btn p-0" type="button" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="admin.php">Lihat Daftar Admin</a>
                  </div>
                </div>
              </div>
              <span>Total Admin</span>
              <h3 class="card-title mb-1"><?= $data_admin['jumlah']; ?></h3>
              <small class="text-muted">Yang terdaftar di sistem</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Statistik Kategori & Transactions -->
    <div class="col-12">
      <div class="row">
        <!-- Statistik Kategori -->
        <div class="col-md-6 mb-4">
          <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
              <div class="card-title mb-0">
                <h5 class="m-0">Statistik Kategori</h5>
                <small class="text-muted">Jumlah Buku per Kategori</small>
              </div>
            </div>
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex flex-column align-items-center gap-1">
                  <?php
                  $totalKategori = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM kategori");
                  $resultKategori = mysqli_fetch_assoc($totalKategori);
                  ?>
                  <h2 class="mb-2"><?= $resultKategori['total'] ?></h2>
                  <span>Total Kategori</span>
                </div>
                <div><i class="bx bx-category-alt bx-lg text-primary"></i></div>
              </div>
              <ul class="p-0 m-0">
                <?php
                $qKategori = "SELECT k.nama, COUNT(b.id_buku) AS total_buku
                              FROM kategori k
                              LEFT JOIN buku b ON k.id_kategori = b.id_kategori
                              GROUP BY k.id_kategori";
                $resKategori = mysqli_query($koneksi, $qKategori);
                $ikon = ['bx bx-book', 'bx bx-bookmark', 'bx bx-layer', 'bx bx-book-content', 'bx bx-book-open'];
                $index = 0;
                while ($row = mysqli_fetch_assoc($resKategori)) {
                ?>
                  <li class="d-flex mb-4 pb-1">
                    <div class="avatar flex-shrink-0 me-3">
                      <span class="avatar-initial rounded bg-label-primary">
                        <i class="<?= $ikon[$index % count($ikon)] ?>"></i>
                      </span>
                    </div>
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                      <div class="me-2">
                        <h6 class="mb-0"><?= htmlspecialchars($row['nama']) ?></h6>
                        <small class="text-muted">Kategori Buku</small>
                      </div>
                      <div class="user-progress">
                        <small class="fw-semibold"><?= $row['total_buku'] ?> Buku</small>
                      </div>
                    </div>
                  </li>
                <?php $index++;
                } ?>
              </ul>
            </div>
          </div>
        </div>
        <?php
          // Atur zona waktu ke WIB
          date_default_timezone_set('Asia/Jakarta');

          // Fungsi untuk menampilkan waktu jam:menit
          function format_time($datetime) {
            return date('H:i', strtotime($datetime));
          }
        ?>
        <!-- Aktivitas Terbaru (Unduhan Saja) -->
        <div class="col-md-6 mb-4">
          <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
              <h5 class="card-title m-0">Aktivitas Terbaru</h5>
            </div>
            <div class="card-body">
              <ul class="p-0 m-0">

                <?php
                // Ambil 6 data terbaru dari hari ini, urut lama ke baru (ASC)
                $unduhan = mysqli_query($koneksi, "
                  SELECT u.waktu_unduh, p.nama_pengguna, b.judul, b.gambar_sampul
                  FROM unduhan u
                  JOIN pengguna p ON u.id_pengguna = p.id_pengguna
                  JOIN buku b ON u.id_buku = b.id_buku
                  WHERE DATE(u.waktu_unduh) = CURDATE()
                  ORDER BY u.waktu_unduh ASC
                  LIMIT 6
                ");
                $jumlah = mysqli_num_rows($unduhan);
                if ($jumlah > 0) {
                  while ($row = mysqli_fetch_assoc($unduhan)) {
                ?>
                    <li class="d-flex mb-4 pb-1">
                      <div class="avatar flex-shrink-0 me-3">
                        <img src="../assets/img/ebook/<?= htmlspecialchars($row['gambar_sampul']) ?>" alt="Ebook" class="rounded" width="40" height="40" />
                      </div>
                      <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                          <small class="text-muted d-block mb-1">Unduhan</small>
                          <h6 class="mb-0"><?= htmlspecialchars($row['nama_pengguna']) ?> mengunduh <em><?= htmlspecialchars($row['judul']) ?></em></h6>
                        </div>
                        <div class="user-progress">
                          <span class="text-muted"><?= format_time($row['waktu_unduh']) ?></span>
                        </div>
                      </div>
                    </li>
                <?php
                  }
                } else {
                  echo '<li class="text-muted">Belum ada aktivitas unduhan hari ini.</li>';
                }
                ?>

      </ul>
    </div>
          </div>
        </div>
        <!-- /Aktivitas Terbaru -->
      </div>
    </div>
    <!-- /End Statistik dan Transactions -->
  </div>
</div>
<!-- /Content -->
