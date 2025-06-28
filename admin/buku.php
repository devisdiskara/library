<?php if (isset($_GET['status'])): ?>
    <?php if ($_GET['status'] == 'sukses'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Data buku berhasil disimpan!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif ($_GET['status'] == 'gagal'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Gagal menyimpan data buku!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif ($_GET['status'] == 'ubah_sukses'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Data buku berhasil diubah!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif ($_GET['status'] == 'hapus_sukses'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Data buku berhasil dihapus!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif ($_GET['status'] == 'hapus_gagal'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Gagal menghapus data buku!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
<?php endif; ?>


<!-- tampilan buku -->
<div class="card">
    <h5 class="card-header">
        <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modalTambahBuku">Tambah Data</button>
    </h5>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th>Nomor</th>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Nama Kategori</th>
                    <th>Gambar Sampul</th>
                    <th>Jumlah Unduhan</th>
                    <th>Rating</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                <?php
                $query = "SELECT buku.id_buku, buku.judul, buku.pengarang, kategori.nama, buku.gambar_sampul, buku.jumlah_unduhan, buku.rating 
                          FROM buku 
                          JOIN kategori ON buku.id_kategori = kategori.id_kategori";

                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $search = $_GET['search'];
                    $query .= " WHERE buku.judul LIKE '%$search%'";
                }

                if (isset($_GET['category']) && !empty($_GET['category'])) {
                    $category_id = $_GET['category'];
                    $query .= (strpos($query, 'WHERE') !== false ? " AND " : " WHERE ") . "buku.id_kategori = $category_id";
                }

                $query_result = mysqli_query($koneksi, $query);

                $dataBuku = array();

                while ($row = mysqli_fetch_assoc($query_result)) {
                    $dataBuku[] = $row;
                }

                if (count($dataBuku) === 0) {
                echo "<tr><td colspan='8' class='text-center text-muted'>Tidak ada data eBook yang tersedia.</td></tr>";
                } else {
                    usort($dataBuku, function ($a, $b) {
                        return $a['id_buku'] - $b['id_buku'];
                    });

                    foreach ($dataBuku as $index => $buku) {
                        echo "<tr>";
                        echo "<td>" . ($index + 1) . "</td>";
                        echo "<td>" . htmlspecialchars($buku['judul']) . "</td>";
                        echo "<td>" . htmlspecialchars($buku['pengarang']) . "</td>";
                        echo "<td>" . htmlspecialchars($buku['nama']) . "</td>";
                        echo "<td><img src='../assets/img/ebook/" . htmlspecialchars($buku['gambar_sampul']) . "' alt='gambar' style='width: 70px; height: 100px; object-fit: cover; border: 1px solid #ccc;'></td>";
                        echo "<td>" . (int)$buku['jumlah_unduhan'] . "</td>";
                        echo "<td>" . (float)$buku['rating'] . "</td>";
                        echo "<td>
                                <div class='dropdown'>
                                    <button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'>
                                        <i class='bx bx-dots-vertical-rounded'></i>
                                    </button>
                                    <div class='dropdown-menu'>
                                        <a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#modalUbahBuku" . $buku['id_buku'] . "'><i class='bx bx-edit-alt me-1'></i>Edit</a>
                                        <a class='dropdown-item' href='#' data-bs-toggle='modal' data-bs-target='#modalHapusBuku" . $buku['id_buku'] . "'><i class='bx bx-trash me-1'></i>Delete</a>
                                    </div>
                                </div>
                              </td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- akhir tampilan buku -->


<!-- modal hapus buku -->
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
$query = mysqli_query($koneksi, "SELECT * FROM buku");
while ($data = mysqli_fetch_assoc($query)) {
    echo "<div class='modal modal fade' id='modalHapusBuku" . $data['id_buku'] . "' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-labelledby='staticBackdropLabel' aria-hidden='true'>
          <div class='modal-dialog modal-sm'>
            <div class='modal-content'>
              <div class='modal-body'>
                <form action='crud_buku.php' method='POST'>
                  <input type='hidden' name='id_buku' value='" . $data['id_buku'] . "'>
                  <div class='text-center modal-confirm'>
                    <div class='icon-box'>
                      <i class='bx bx-x'></i>
                    </div><br>
                    <h3>Apa kamu yakin?</h3><br>
                    <p>Apakah Anda benar-benar ingin menghapus <strong>" . $data['judul'] . "</strong>? Proses ini tidak dapat dibatalkan.</p><br>
                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Batal</button>
                    <button type='submit' class='btn btn-danger' name='btnHapus'>Hapus Buku</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>";
}
?>
<!-- modal hapus buku -->

<!-- modal ubah buku -->
<?php
$query = mysqli_query($koneksi, "SELECT buku.id_buku, buku.judul, buku.id_kategori, buku.gambar_sampul, buku.pengarang, buku.deskripsi, buku.path_file, buku.link_shopee, buku.link_tokopedia, kategori.nama FROM buku JOIN kategori ON buku.id_kategori = kategori.id_kategori");
while ($row = mysqli_fetch_assoc($query)) :
    // Ambil file_id dari path_file yang sudah dimodifikasi
    $file_id = '';
    if (strpos($row['path_file'], 'id=') !== false) {
        $file_id = explode('id=', $row['path_file'])[1];
    }
    $original_drive_link = $file_id ? 'https://drive.google.com/file/d/' . $file_id . '/view' : '';
?>
    <div class="modal modal-fade" id="modalUbahBuku<?php echo $row['id_buku']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="staticBackdropLabel">Edit Data Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="crud_buku.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_buku" value="<?php echo $row['id_buku']; ?>">
                        <input type="hidden" name="gambarLama" value="<?php echo $row['gambar_sampul']; ?>">

                        <div class="mb-3">
                            <label class="form-label">Judul Buku</label>
                            <input type="text" class="form-control" name="judul" value="<?php echo $row['judul']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pengarang</label>
                            <input type="text" class="form-control" name="pengarang" value="<?php echo $row['pengarang']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" required><?php echo $row['deskripsi']; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gambar Sampul</label>
                            <input type="file" class="form-control" name="gambar_sampul">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Link File Ebook</label>
                            <input type="url" class="form-control link-drive-edit" name="link_drive" id="link_drive_<?php echo $row['id_buku']; ?>" placeholder="Masukkan link Google Drive asli" value="<?php echo $original_drive_link; ?>">
                        </div>

                        <div class="mb-3">
                            <button type="button" class="btn btn-warning" onclick="modifyLinkEdit(<?php echo $row['id_buku']; ?>)">Modifikasi Link</button>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Link Download Otomatis</label>
                            <input type="url" class="form-control" name="path_file" id="path_file_<?php echo $row['id_buku']; ?>" value="<?php echo $row['path_file']; ?>" readonly required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="id_kategori" class="form-select" required>
                                <?php
                                $qjkat = mysqli_query($koneksi, "SELECT * FROM kategori");
                                while ($djkat = mysqli_fetch_assoc($qjkat)) {
                                    $selected = ($djkat['id_kategori'] == $row['id_kategori']) ? 'selected' : '';
                                    echo "<option value='" . $djkat['id_kategori'] . "' $selected>" . $djkat['nama'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Link Shopee</label>
                            <input type="url" class="form-control" name="link_shopee" value="<?php echo $row['link_shopee']; ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Link Tokopedia</label>
                            <input type="url" class="form-control" name="link_tokopedia" value="<?php echo $row['link_tokopedia']; ?>">
                        </div>

                        <div class="d-grid">
                            <button type="submit" name="btnUbah" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    </div>
<?php endwhile; ?>

<script>
function modifyLinkEdit(idBuku) {
    const driveInput = document.getElementById('link_drive_' + idBuku);
    const pathFileInput = document.getElementById('path_file_' + idBuku);
    const driveLink = driveInput.value;

    let fileID = '';
    if (driveLink.includes('drive.google.com/file/d/')) {
        fileID = driveLink.split('/d/')[1].split('/')[0];
        const modifiedLink = `https://drive.google.com/uc?export=download&id=${fileID}`;
        pathFileInput.value = modifiedLink;
    } else {
        alert('Link Google Drive tidak valid. Pastikan Anda memasukkan link yang benar.');
    }
}
</script>




<!-- Modal Tambah Buku -->
<div class="modal fade" id="modalTambahBuku" tabindex="-1" aria-labelledby="modalTambahBukuLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahBukuLabel">Tambah Data Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="crud_buku.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Buku</label>
                        <input type="text" class="form-control" id="judul" name="judul" placeholder="Isi judul buku" required>
                    </div>
                    <div class="mb-3">
                        <label for="pengarang" class="form-label">Pengarang</label>
                        <input type="text" class="form-control" id="pengarang" name="pengarang" placeholder="Isi pengarang buku" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Isi deskripsi buku" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="gambar_sampul" class="form-label">Gambar Sampul</label>
                        <input type="file" class="form-control" id="gambar_sampul" name="gambar_sampul" required>
                    </div>
                    <!-- Input Link Google Drive -->
                    <div class="mb-3">
                        <label for="link_drive" class="form-label">Link file ebook</label>
                        <input type="url" class="form-control" id="link_drive" name="link_drive" placeholder="Masukkan link Google Drive asli" required>
                    </div>
                    <!-- Tombol untuk Memodifikasi Link -->
                    <div class="mb-3">
                        <button type="button" class="btn btn-warning" onclick="modifyLink()">Modifikasi Link</button>
                    </div>
                    <!-- Input untuk Link yang Sudah Dimodifikasi -->
                    <div class="mb-3">
                        <label for="path_file" class="form-label">Link Download Otomatis</label>
                        <input type="url" class="form-control" id="path_file" name="path_file" placeholder="Link akan otomatis terisi setelah modifikasi" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="id_kategori" class="form-label">Kategori</label>
                        <select name="id_kategori" class="form-select" id="id_kategori" required>
                            <option value="">Pilih Kategori Buku</option>
                            <?php
                            $qkat = mysqli_query($koneksi, "SELECT * FROM kategori");
                            while ($dkat = mysqli_fetch_assoc($qkat)) :
                            ?>
                                <option value="<?php echo $dkat['id_kategori']; ?>"><?php echo $dkat['nama']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="link_shopee" class="form-label">Link Shopee</label>
                        <input type="url" class="form-control" id="link_shopee" name="link_shopee" placeholder="Isi link Shopee">
                    </div>
                    <div class="mb-3">
                        <label for="link_tokopedia" class="form-label">Link Tokopedia</label>
                        <input type="url" class="form-control" id="link_tokopedia" name="link_tokopedia" placeholder="Isi link Tokopedia">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary" name="btnSimpan">Tambah Buku</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk Modifikasi Link -->
<script>
    function modifyLink() {
        const driveLink = document.getElementById('link_drive').value;
        let fileID = '';

        // Memastikan link valid dan mendapatkan file ID dari link Google Drive
        if (driveLink.includes('drive.google.com/file/d/')) {
            fileID = driveLink.split('/d/')[1].split('/')[0];
            const modifiedLink = `https://drive.google.com/uc?export=download&id=${fileID}`;
            document.getElementById('path_file').value = modifiedLink;
        } else {
            alert('Link Google Drive tidak valid. Pastikan Anda memasukkan link yang benar.');
        }
    }
</script>
