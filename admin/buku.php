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
                // Set default query
                $query = "SELECT buku.id_buku, buku.judul, buku.pengarang, kategori.nama, buku.gambar_sampul, buku.jumlah_unduhan, buku.rating 
                          FROM buku 
                          JOIN kategori ON buku.id_kategori = kategori.id_kategori";

                // Periksa apakah ada parameter pencarian yang dikirimkan
                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $search = $_GET['search'];
                    // Ubah query untuk mencari judul yang cocok dengan kata kunci pencarian
                    $query .= " WHERE buku.judul LIKE '%$search%'";
                }

                // Periksa apakah ada parameter kategori yang dipilih
                if (isset($_GET['category']) && !empty($_GET['category'])) {
                    $category_id = $_GET['category'];
                    // Tambahkan kondisi WHERE untuk memfilter berdasarkan kategori yang dipilih
                    $query .= " AND buku.id_kategori = $category_id";
                }

                // Eksekusi query
                $query_result = mysqli_query($koneksi, $query);

                // Menginisialisasi array untuk menyimpan hasil query
                $dataBuku = array();

                // Memasukkan hasil query ke dalam array
                while ($row = mysqli_fetch_assoc($query_result)) {
                    $dataBuku[] = $row;
                }

                // Mengurutkan array berdasarkan id buku secara ascending
                usort($dataBuku, function ($a, $b) {
                    return $a['id_buku'] - $b['id_buku'];
                });

                // Menghitung jumlah total buku
                $total_buku = count($dataBuku);

                // Menampilkan data buku dengan nomor buku yang sesuai dengan urutan query
                foreach ($dataBuku as $index => $buku) {
                    echo "<tr>";
                    echo "<td>" . ($index + 1) . "</td>"; // Nomor buku dihitung dari indeks array + 1
                    echo "<td>" . $buku['judul'] . "</td>";
                    echo "<td>" . $buku['pengarang'] . "</td>";
                    echo "<td>" . $buku['nama'] . "</td>";
                    echo "<td><img src='../assets/img/ebook/" . $buku['gambar_sampul'] . "' alt='gambar' width='100'></td>";
                    echo "<td>" . $buku['jumlah_unduhan'] . "</td>";
                    echo "<td>" . $buku['rating'] . "</td>";
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
                ?>
            </tbody>
        </table>
    </div>
</div>
<!-- tampilan buku -->

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
    echo "<div class='modal modal-fade' id='modalHapusBuku" . $data['id_buku'] . "' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-labelledby='staticBackdropLabel' aria-hidden='true'>
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
                        <div class="row">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Judul</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="nama" class="input-group-text"><i class="bx bx-book"></i></span>
                                        <input type="text" class="form-control" name="judul" value="<?php echo $row['judul']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Kategori</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-category"></i></span>
                                        <select name="id_kategori" class="form-select" id="">
                                            <option value="<?php echo $row['id_kategori']; ?>"><?php echo $row['nama']; ?></option>
                                            <?php
                                            $qjkat = mysqli_query($koneksi, "SELECT * FROM kategori");
                                            while ($djkat = mysqli_fetch_assoc($qjkat)) {
                                                $selected = "";
                                                if ($djkat['id_kategori'] == $row['id_kategori']) {
                                                    $selected = "selected";
                                                }
                                                echo "<option value='" . $djkat['id_kategori'] . "' " . $selected . ">" . $djkat['nama'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Gambar Sampul</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="nama" class="input-group-text"><i class="bx bx-image"></i></span>
                                        <input type="file" class="form-control" name="gambar_sampul">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Pengarang</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="nama" class="input-group-text"><i class="bx bx-user"></i></span>
                                        <input type="text" class="form-control" name="pengarang" value="<?php echo $row['pengarang']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Deskripsi</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="nama" class="input-group-text"><i class="bx bx-file"></i></span>
                                        <textarea class="form-control" name="deskripsi"><?php echo $row['deskripsi']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">File Ebook</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="nama" class="input-group-text"><i class="bx bx-file"></i></span>
                                        <input type="file" class="form-control" name="file_baru">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Link Shopee</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="nama" class="input-group-text"><i class="bx bxl-shopee"></i></span>
                                        <input type="text" class="form-control" name="link_shopee" value="<?php echo $row['link_shopee']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Link Tokopedia</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="nama" class="input-group-text"><i class="bx bxl-tokopedia"></i></span>
                                        <input type="text" class="form-control" name="link_tokopedia" value="<?php echo $row['link_tokopedia']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" name="btnUbah" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endwhile; ?>

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
