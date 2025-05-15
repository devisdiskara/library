<?php
// Masukkan koneksi ke database atau file konfigurasi yang diperlukan
include '../koneksi.php';
session_start();

// Ambil data donasi ebook dari database
$query = "SELECT id, judul, pengarang, deskripsi, gambar_sampul, file_ebook, status FROM donasi_ebook";

// Periksa apakah ada parameter pencarian yang dikirimkan
if (isset($_GET['search']) && !empty($_GET['search'])) {
  $search = $_GET['search'];
  $query .= " WHERE judul LIKE '%$search%'";
}

// Periksa apakah ada parameter kategori yang dipilih
if (isset($_GET['category']) && !empty($_GET['category'])) {
  $category_id = $_GET['category'];
  $query .= " AND id_kategori = $category_id";
}

$query_result = mysqli_query($koneksi, $query);
$dataBuku = array();

while ($row = mysqli_fetch_assoc($query_result)) {
  $dataBuku[] = $row;
}

usort($dataBuku, function ($a, $b) {
  return $a['id'] - $b['id'];
});

$total_buku = count($dataBuku);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Ebook Donations - Flexilibrary</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/favicon/log.ico" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">

  <!-- asset tabel -->
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="../aslog/img/favicon/favicon.ico" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700&display=swap" rel="stylesheet" />

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="../aslog/vendor/fonts/boxicons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="../aslog/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../aslog/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../aslog/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="../aslog/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <!-- Page CSS -->

  <!-- Helpers -->
  <script src="../aslog/vendor/js/helpers.js"></script>

  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="../aslog/js/config.js"></script>

  <!-- asset tabel end -->

  <!-- Custom CSS -->
  <style>
    .status-background {
      background-color: rgba(255, 255, 255, 0.5);
      /* Warna latar belakang dengan opacity rendah */
      padding: 8px 12px;
      /* Padding untuk menjaga jarak dari tepi teks */
      border-radius: 4px;
      /* Memberi sudut melengkung pada latar belakang */
    }

    .deskripsi-buku {
      word-wrap: break-word;
    }
  </style>
</head>

<body>

  <?php include 'header.php' ?>

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">
        <ol>
          <li><a href="page.php">Home</a></li>
          <li>Ebooks Donation</li>
        </ol>
        <h2 style="color: #f8f9fa;">Ebooks Donation</h2>
      </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page">
      <div class="container">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Ebooks Donation</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahDonasi">
              <i class="bx bx-plus"></i> Add Data
            </button>
          </div>
          <div class="table-responsive text-nowrap">
            <table id="donasi-table" class="table table-striped">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Title</th>
                  <th>Author</th>
                  <th>Cover Image</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                <?php
                foreach ($dataBuku as $buku) {
                  $modalDetailID = "modalDetailDonasi" . $buku['id'];
                  $modalHapusID = "modalHapusBuku" . $buku['id'];
                ?>
                  <tr>
                    <td><?php echo $buku['id']; ?></td>
                    <td><?php echo $buku['judul']; ?></td>
                    <td><?php echo $buku['pengarang']; ?></td>
                    <td><img src="../assets/img/ebook_donasi/<?php echo $buku['gambar_sampul']; ?>" alt="Cover" width="100"></td>
                    <td class="status-background">
                      <?php
                      switch ($buku['status']) {
                        case 'belum diverifikasi':
                          echo "<span class='badge bg-label-warning'>Belum Diverifikasi</span>";
                          break;
                        case 'diterima':
                          echo "<span class='badge bg-label-success'>Diterima</span>";
                          break;
                        case 'ditolak':
                          echo "<span class='badge bg-label-danger'>Ditolak</span>";
                          break;
                        default:
                          echo "<span class='badge bg-label-primary'>" . $buku['status'] . "</span>";
                          break;
                      }
                      ?>
                    </td>
                    <td>
                      <a href="#" class="text-primary me-3" data-bs-toggle="modal" data-bs-target="#<?php echo $modalDetailID; ?>">
                        <i class='bx bx-info-circle'></i> Details
                      </a>
                      <a href="#" class="text-danger" data-bs-toggle="modal" data-bs-target="#<?php echo $modalHapusID; ?>">
                        <i class='bx bx-trash'></i> Delete
                      </a>
                    </td>
                  </tr>

                  <!-- Modal Detail Donasi Ebook -->
                  <div class="modal fade" id="modalDetailDonasi<?php echo $buku['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDetailDonasiLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="modalDetailDonasiLabel">Detail Donasi Ebook</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form action="crud_donasi.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $buku['id']; ?>">
                            <div class="row mb-3">
                              <label class="col-sm-2 col-form-label" for="judul-<?php echo $buku['id']; ?>">Judul</label>
                              <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                  <span class="input-group-text"><i class="bx bx-book"></i></span>
                                  <input type="text" class="form-control" id="judul-<?php echo $buku['id']; ?>" name="judul" value="<?php echo $buku['judul']; ?>">
                                </div>
                              </div>
                            </div>
                            <div class="row mb-3">
                              <label class="col-sm-2 col-form-label" for="pengarang-<?php echo $buku['id']; ?>">Pengarang</label>
                              <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                  <span class="input-group-text"><i class="bx bx-user"></i></span>
                                  <input type="text" class="form-control" id="pengarang-<?php echo $buku['id']; ?>" name="pengarang" value="<?php echo $buku['pengarang']; ?>">
                                </div>
                              </div>
                            </div>
                            <div class="row mb-3">
                              <label class="col-sm-2 col-form-label" for="kategori-<?php echo $buku['id']; ?>">Kategori</label>
                              <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                  <span class="input-group-text"><i class="bx bx-category"></i></span>
                                  <input type="text" class="form-control" id="kategori<?php echo $buku['id']; ?>" name="kategori" value="<?php echo isset($buku['kategori']) ? $buku['kategori'] : ''; ?>">
                                </div>
                              </div>
                            </div>
                            <div class="row mb-3">
                              <label class="col-sm-2 col-form-label" for="deskripsi-<?php echo $buku['id']; ?>">Deskripsi</label>
                              <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                  <span class="input-group-text"><i class="bx bx-message"></i></span>
                                  <textarea class="form-control deskripsi-buku" id="deskripsi-<?php echo $buku['id']; ?>" name="deskripsi"><?php echo $buku['deskripsi']; ?></textarea>
                                </div>
                              </div>
                            </div>
                            <div class="row mb-3">
                              <label class="col-sm-2 col-form-label" for="gambar_sampul-<?php echo $buku['id']; ?>">Gambar Sampul</label>
                              <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                  <input type="file" class="form-control" id="gambar_sampul-<?php echo $buku['id']; ?>" name="gambar_sampul" accept="image/*">
                                  <label class="input-group-text" for="gambar_sampul-<?php echo $buku['id']; ?>">Upload</label>
                                </div>
                                <small class="text-muted">Max. 2MB</small>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="submit" name="update" class="btn btn-primary">Update</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- End Modal Detail Donasi Ebook -->


                  <!-- Modal Hapus Donasi Ebook -->
                  <div class="modal fade" id="<?php echo $modalHapusID; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalHapusDonasiLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 style="text-align: center;" class="modal-title" id="modalHapusDonasiLabel">Hapus Donasi Ebook</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div style="text-align: center;" class="modal-body">
                          <p>Apakah Anda yakin ingin menghapus ebook</p>
                          <strong><?php echo $buku['judul']; ?></strong>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <form method="post" action="crud_donasi.php">
                            <input type="hidden" name="id" value="<?php echo $buku['id']; ?>">
                            <button type="submit" name="btnHapus" class="btn btn-danger">Delete</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>


    <!-- Modal Tambah Donasi Ebook -->
    <div class="modal fade" id="modalTambahDonasi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalTambahDonasiLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTambahDonasiLabel">Tambah Donasi Ebook</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="crud_donasi.php" method="POST" enctype="multipart/form-data">
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="judul">Judul</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-book"></i></span>
                    <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan judul ebook" required>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="pengarang">Pengarang</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                    <input type="text" class="form-control" id="pengarang" name="pengarang" placeholder="Masukkan pengarang ebook" required>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="kategori">Kategori</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-category"></i></span>
                    <input type="text" class="form-control" id="kategori" name="kategori" placeholder="Masukkan kategori ebook" required>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="deskripsi">Deskripsi</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-message"></i></span>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan deskripsi ebook" required></textarea>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="gambar_sampul">Gambar Sampul</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-image"></i></span>
                    <input type="file" class="form-control" id="gambar_sampul" name="gambar_sampul" required>
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="file_ebook">File Ebook</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-file"></i></span>
                    <input type="file" class="form-control" id="file_ebook" name="file_ebook" required>
                  </div>
                </div>
              </div>
              <div class="row justify-content-end">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary" name="btnSimpan">Tambah Donasi</button>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>



  </main><!-- End #main -->

  <?php include 'footer.php' ?>

  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="../aslog/vendor/libs/jquery/jquery.js"></script>
  <script src="../aslog/vendor/libs/popper/popper.js"></script>
  <script src="../aslog/vendor/js/bootstrap.js"></script>
  <script src="../aslog/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

  <script src="../aslog/vendor/js/menu.js"></script>
  <!-- endbuild -->

  <!-- Vendors JS -->

  <!-- Main JS -->
  <script src="../aslog/js/main.js"></script>

  <!-- Page JS -->

  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>

</body>

</html>