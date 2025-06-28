<!-- Tampilan CRUD Pengguna -->
<div class="card">
    <h5 class="card-header">
        <span class="text-muted">Daftar Pengguna</span>
    </h5>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th>Nomor</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Negara</th>
                    <th>Foto Profil</th>
                    <th>Instagram</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                <?php
                $query = "SELECT * FROM pengguna";
                $result = mysqli_query($koneksi, $query);
                $no = 1;

                if (mysqli_num_rows($result) > 0) {
                    while ($user = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . htmlspecialchars($user['nama_pengguna']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['username']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['negara']) . "</td>";

                        $fotoPath = '../assets/img/profile/' . htmlspecialchars($user['profile']);
                        if (!empty($user['profile']) && file_exists($fotoPath)) {
                            echo "<td><img src='$fotoPath' width='60' height='60' style='object-fit: cover; border-radius: 50%;'></td>";
                        } else {
                            echo "<td><span class='text-muted'>Belum Ada Foto</span></td>";
                        }

                        echo "<td>" . htmlspecialchars($user['instagram']) . "</td>";

                        echo "<td>
                                <div class='dropdown'>
                                    <button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'>
                                        <i class='bx bx-dots-vertical-rounded'></i>
                                    </button>
                                    <div class='dropdown-menu'>
                                        <a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#modalHapusPengguna" . $user['id_pengguna'] . "'>
                                            <i class='bx bx-trash me-1'></i>Hapus
                                        </a>
                                    </div>
                                </div>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center text-muted'>Belum ada data pengguna.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Akhir CRUD Pengguna -->

<!-- Modal Hapus Pengguna -->
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
$query = mysqli_query($koneksi, "SELECT * FROM pengguna");
while ($data = mysqli_fetch_assoc($query)) {
?>
    <div class="modal fade" id="modalHapusPengguna<?= $data['id_pengguna']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalHapusPenggunaLabel<?= $data['id_pengguna']; ?>" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="crud_pengguna.php" method="GET">
                        <input type="hidden" name="hapus" value="<?= $data['id_pengguna']; ?>">
                        <div class="text-center modal-confirm">
                            <div class="icon-box">
                                <i class="bx bx-x"></i>
                            </div><br>
                            <h3>Hapus Pengguna?</h3><br>
                            <p>Yakin ingin menghapus pengguna <strong><?= htmlspecialchars($data['nama_pengguna']); ?></strong>? Aksi ini tidak dapat dibatalkan.</p><br>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<!-- /Modal Hapus Pengguna -->
