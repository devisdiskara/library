<?php
include '../koneksi.php';

if (!isset($_SESSION['login_pa']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../index.php");
  exit;
}

$id_admin = $_SESSION['id_admin'];
$query = mysqli_query($koneksi, "SELECT * FROM admin WHERE id = '$id_admin'");
$admin = mysqli_fetch_assoc($query);
$foto = $admin['foto'] ?: 'default.png';
?>

<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengaturan Akun /</span> Akun</h4>

  <div class="row">
    <div class="col-md-12">
      <div class="card mb-4">
        <h5 class="card-header">Profile Details</h5>

        <form method="POST" action="update_profile.php" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?= $admin['id'] ?>">

          <div class="card-body">
            <div class="d-flex align-items-start align-items-sm-center gap-4">
              <img
                src="../assetsadmin/img/avatars/<?= htmlspecialchars($foto) ?>"
                alt="user-avatar"
                class="d-block rounded"
                height="100"
                width="100"
                id="uploadedAvatar"
                style="object-fit: cover"
              />
              <div class="button-wrapper">
                <label class="btn btn-primary me-2 mb-4" tabindex="0">
                  <span class="d-none d-sm-block">Upload new photo</span>
                  <i class="bx bx-upload d-block d-sm-none"></i>
                  <!-- ✅ Masuk ke dalam form -->
                  <input
                    type="file"
                    name="foto"
                    class="account-file-input"
                    hidden
                    accept="image/png, image/jpeg"
                    onchange="previewFoto(this)"
                  />
                </label>
                <p class="text-muted mb-0">JPG atau PNG. Maks 800KB.</p>
              </div>
            </div>
          </div>

          <hr class="my-0" />
          <div class="card-body">
            <div class="row">
              <div class="mb-3 col-md-6">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($admin['nama']) ?>" />
              </div>
              <div class="mb-3 col-md-6">
                <label class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($admin['email']) ?>" />
              </div>
              <div class="mb-3 col-md-6">
                <label class="form-label">No HP</label>
                <input type="text" name="no_hp" class="form-control" value="<?= htmlspecialchars($admin['no_hp']) ?>" />
              </div>
              <div class="mb-3 col-md-6">
                <label class="form-label">Alamat</label>
                <input type="text" name="alamat" class="form-control" value="<?= htmlspecialchars($admin['alamat']) ?>" />
              </div>

              <div class="mb-3 col-md-6">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($admin['username']) ?>" />
              </div>

              <div class="mb-3 col-md-6">
                <label class="form-label">Password Baru</label>
                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diganti" />
              </div>
            </div>

            <div class="mt-2">
              <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
              <button type="reset" class="btn btn-outline-secondary">Batal</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function previewFoto(input) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('uploadedAvatar').src = e.target.result;
    };
    reader.readAsDataURL(file);
  }
</script>
