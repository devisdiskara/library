<!-- tampilan kategori -->
<div class="card">
    <h5 class="card-header">
        <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">Tambah Kategori</button>
    </h5>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Jumlah Buku</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                <?php
                // Ambil semua kategori dan hitung jumlah bukunya
                $query = "SELECT kategori.*, 
                            (SELECT COUNT(*) FROM buku WHERE buku.id_kategori = kategori.id_kategori) AS jumlah_buku 
                          FROM kategori";
                $result = mysqli_query($koneksi, $query);
                $no = 1;

                if (mysqli_num_rows($result) > 0) {
                    while ($kategori = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$no}</td>";
                        echo "<td>" . htmlspecialchars($kategori['nama']) . "</td>";
                        echo "<td>{$kategori['jumlah_buku']}</td>";
                        echo "<td>
                                <div class='dropdown'>
                                    <button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'>
                                        <i class='bx bx-dots-vertical-rounded'></i>
                                    </button>
                                    <div class='dropdown-menu'>
                                        <a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#modalUbahKategori{$kategori['id_kategori']}'><i class='bx bx-edit-alt me-1'></i>Edit</a>
                                        <a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#modalHapusKategori{$kategori['id_kategori']}'><i class='bx bx-trash me-1'></i>Delete</a>
                                    </div>
                                </div>
                              </td>";
                        echo "</tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center text-muted'>Tidak ada data kategori yang tersedia.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- akhir tampilan kategori -->


<!-- modal hapus kategori -->
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
$query = mysqli_query($koneksi, "SELECT * FROM kategori");
while ($data = mysqli_fetch_assoc($query)) {
    ?>
    <div class="modal fade" id="modalHapusKategori<?= $data['id_kategori']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="crud_kategori.php" method="POST">
                        <input type="hidden" name="id_kategori" value="<?= $data['id_kategori']; ?>">
                        <div class="text-center modal-confirm">
                            <div class="icon-box">
                                <i class="bx bx-x"></i>
                            </div><br>
                            <h3>Apa kamu yakin?</h3><br>
                            <p>Apakah Anda yakin ingin menghapus kategori <strong><?= htmlspecialchars($data['nama']); ?></strong>? Proses ini tidak dapat dibatalkan.</p><br>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger" name="btnHapusKategori">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
<!-- modal hapus kategori -->

<!-- modal ubah kategori -->
<?php
$query = mysqli_query($koneksi, "SELECT * FROM kategori");
while ($row = mysqli_fetch_assoc($query)) :
?>
    <div class="modal fade" id="modalUbahKategori<?php echo $row['id_kategori']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ubahKategoriLabel<?php echo $row['id_kategori']; ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="ubahKategoriLabel<?php echo $row['id_kategori']; ?>">Edit Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="crud_kategori.php" method="POST">
                        <input type="hidden" name="id_kategori" value="<?php echo $row['id_kategori']; ?>">
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="namaKategori">Nama Kategori</label>
                            <div class="col-sm-9">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-category"></i></span>
                                    <input type="text" class="form-control" name="nama_kategori" id="namaKategori" value="<?php echo htmlspecialchars($row['nama']); ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-9">
                                <button type="submit" name="btnUbahKategori" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endwhile; ?>
<!-- end modal ubah kategori -->


<!-- Modal Tambah Kategori -->
<div class="modal fade" id="modalTambahKategori" tabindex="-1" aria-labelledby="modalTambahKategoriLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="crud_kategori.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahKategoriLabel">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label" for="namaKategori">Nama Kategori</label>
                        <div class="col-sm-9">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-category"></i></span>
                                <input type="text" class="form-control" name="nama_kategori" id="namaKategori" placeholder="Masukkan nama kategori" required>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-9">
                            <button type="submit" name="btnSimpanKategori" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Tambah -->


