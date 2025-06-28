<!-- tampilan admin -->
<div class="card">
    <h5 class="card-header">
        <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modalTambahAdmin">Tambah Admin</button>
    </h5>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th>Nomor</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Foto Profil</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                <?php
                $query = "SELECT * FROM admin";
                $result = mysqli_query($koneksi, $query);
                $no = 1;

                if (mysqli_num_rows($result) > 0) {
                    while ($admin = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . htmlspecialchars($admin['nama']) . "</td>";
                        echo "<td>" . htmlspecialchars($admin['username']) . "</td>";
                        echo "<td>" . htmlspecialchars($admin['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($admin['no_hp']) . "</td>";

                        $fotoPath = '../assetsadmin/img/avatars/' . htmlspecialchars($admin['foto']);
                        if (!empty($admin['foto']) && file_exists($fotoPath)) {
                            echo "<td><img src='$fotoPath' width='60' height='60' style='object-fit: cover; border-radius: 50%;'></td>";
                        } else {
                            echo "<td><span class='text-muted'>Belum Ada Foto</span></td>";
                        }

                        echo "<td>" . htmlspecialchars($admin['alamat']) . "</td>";
                        echo "<td>
                                <div class='dropdown'>
                                    <button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'>
                                        <i class='bx bx-dots-vertical-rounded'></i>
                                    </button>
                                    <div class='dropdown-menu'>
                                        <a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#modalUbahAdmin" . $admin['id'] . "'><i class='bx bx-edit-alt me-1'></i>Edit</a>
                                        <a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#modalHapusAdmin" . $admin['id'] . "'><i class='bx bx-trash me-1'></i>Delete</a>
                                    </div>
                                </div>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center text-muted'>Belum ada data admin.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- akhir tampilan admin -->


<!-- Modal Tambah Admin -->
<div class="modal fade" id="modalTambahAdmin" tabindex="-1" aria-labelledby="modalTambahAdminLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTambahAdminLabel">Tambah Akun Admin</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <form action="crud_admin.php" method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="nama" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama admin" required>
          </div>
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username admin" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Kata Sandi</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email admin" required>
          </div>
          <div class="mb-3">
            <label for="no_hp" class="form-label">No HP</label>
            <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Nomor HP admin" required>
          </div>
          <div class="mb-3">
            <label for="foto" class="form-label">Foto Profil</label>
            <input type="file" class="form-control" id="foto" name="foto" required>
          </div>
          <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat admin" required></textarea>
          </div>
          <div class="d-grid">
            <button type="submit" name="btnTambahAdmin" class="btn btn-primary">Tambah Admin</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
$query = mysqli_query($koneksi, "SELECT * FROM admin");
while ($row = mysqli_fetch_assoc($query)) :
?>
  <div class="modal fade" id="modalUbahAdmin<?php echo $row['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ubahAdminLabel<?php echo $row['id']; ?>" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fs-5" id="ubahAdminLabel<?php echo $row['id']; ?>">Edit Data Admin</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <form action="crud_admin.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            <div class="mb-3">
              <label for="nama" class="form-label">Nama</label>
              <input type="text" class="form-control" name="nama" value="<?php echo htmlspecialchars($row['nama']); ?>" required>
            </div>

            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($row['username']); ?>" required>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
            </div>

            <div class="mb-3">
              <label for="no_hp" class="form-label">No HP</label>
              <input type="text" class="form-control" name="no_hp" value="<?php echo htmlspecialchars($row['no_hp']); ?>" required>
            </div>

            <div class="mb-3">
              <label for="alamat" class="form-label">Alamat</label>
              <textarea class="form-control" name="alamat" required><?php echo htmlspecialchars($row['alamat']); ?></textarea>
            </div>

            <div class="mb-3">
              <label for="foto" class="form-label">Ganti Foto Profil (Opsional)</label><br>
              <img src="../assetsadmin/img/avatars/<?php echo htmlspecialchars($row['foto']); ?>" width="60" class="mb-2 rounded-circle" style="object-fit:cover;">
              <input type="file" class="form-control" name="foto">
            </div>

            <div class="d-grid">
              <button type="submit" name="btnUbahAdmin" class="btn btn-primary">Simpan Perubahan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php endwhile; ?>

<!-- modal hapus admin -->
<style>
    .modal-confirm .icon-box {
        width: 80px;
        height: 80px;
        margin: 0 auto;
        border-radius: 50%;
        z-index: 9;
        text-align: center;
        border: 3px solid #f15e5e;
    }

    .modal-confirm .icon-box i {
        color: #f15e5e;
        font-size: 46px;
        display: inline-block;
        margin-top: 13px;
    }
</style>

<?php
$query = mysqli_query($koneksi, "SELECT * FROM admin");
while ($data = mysqli_fetch_assoc($query)) {
?>
    <div class="modal fade" id="modalHapusAdmin<?= $data['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalHapusAdminLabel<?= $data['id']; ?>" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="crud_admin.php" method="GET">
                        <input type="hidden" name="hapus" value="<?= $data['id']; ?>">
                        <div class="text-center modal-confirm">
                            <div class="icon-box">
                                <i class="bx bx-x"></i>
                            </div><br>
                            <h3>Hapus Admin?</h3><br>
                            <p>Yakin ingin menghapus admin <strong><?= htmlspecialchars($data['nama']); ?></strong>? Aksi ini tidak bisa dibatalkan.</p><br>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>
<!-- modal hapus admin -->
