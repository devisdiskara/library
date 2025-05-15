<?php
include '../koneksi.php';
session_start();

$id_pengguna = $_SESSION['id_pengguna'];

$query = "
    SELECT buku.id_buku, buku.judul, buku.pengarang, buku.gambar_sampul, buku.jumlah_unduhan, buku.rating, buku.tanggal_upload 
    FROM favorit 
    INNER JOIN buku ON favorit.id_buku = buku.id_buku 
    WHERE favorit.id_pengguna = $id_pengguna";

$result = mysqli_query($koneksi, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Favorite Books - Flexilibrary</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">

    <style>
        .favorite-book {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            position: relative;
        }

        .book-details {
            display: flex;
            align-items: center;
            margin-top: 0;
        }

        .book-info {
            margin-left: 30px;
            display: flex;
            flex-direction: column;
            text-align: left;
        }

        .book-info p {
            margin: 0;
        }

        .book-cover {
            width: 100px;
            height: auto;
        }

        .love-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        .additional-info {
            position: absolute;
            bottom: 0;
            right: 0;
            text-align: right;
            font-size: 0.8em;
        }

        .additional-info p {
            margin: 0 5px;
            display: inline-block;
        }

        table {
            width: 80%;
            margin: 0 auto;
            text-align: left;
        }

        .book-info {
            margin-bottom: 85px;
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
                    <li>Favorites</li>
                </ol>
                <h2>Favorite Books</h2>
            </div>
        </section><!-- End Breadcrumbs -->

        <section class="inner-page">
            <div class="container">
                <div class="text-center">
                    <?php if (mysqli_num_rows($result) > 0) : ?>
                        <!-- Tampilkan daftar buku yang diunduh -->
                    <?php else : ?>
                        <p class="no-downloads">There are no books stored in favorites yet.</p>
                    <?php endif; ?>
                </div>
                <table class="table" border="1">
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $isFavorited = true; // Buku sudah difavoritkan karena berada di tabel favorit
                        echo '<tr id="book-' . $row["id_buku"] . '">
                            <td>
                                <div class="favorite-book">
                                    <div class="book-details">
                                        <div class="book-cover">
                                            <img src="../assets/img/ebook/' . $row["gambar_sampul"] . '" alt="Favorite Book Cover" class="book-cover">
                                        </div>
                                        <div class="book-info">
                                            <p><strong>' . $row["judul"] . '</strong></p>
                                            <p>' . $row["pengarang"] . '</p>
                                            <div class="love-icon" data-book-id="' . $row["id_buku"] . '" data-favorited="' . ($isFavorited ? 'true' : 'false') . '">
                                                <i class="bi ' . ($isFavorited ? 'bi-heart-fill' : 'bi-heart') . '" style="color: ' . ($isFavorited ? 'blue' : 'black') . ';"></i>
                                            </div>
                                        </div>
                                        <div class="additional-info">
                                            <p><strong>Jumlah Unduhan:</strong> ' . $row["jumlah_unduhan"] . '</p>
                                            <p><strong>Rating:</strong> ' . $row["rating"] . '</p>
                                            <p><strong>Tanggal Upload:</strong> ' . $row["tanggal_upload"] . '</p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>';
                    }
                    ?>
                </table>
            </div>
        </section>

        <script>
            document.querySelectorAll('.love-icon').forEach(icon => {
                icon.addEventListener('click', function() {
                    const bookId = this.dataset.bookId;
                    const isFavorited = this.dataset.favorited === 'true';
                    const iconElement = this.querySelector('i');

                    // Kirim permintaan untuk menambahkan atau menghapus dari favorit
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', isFavorited ? 'hapus_favorit.php' : 'tambah_favorit.php', true);
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            if (isFavorited) {
                                // Hapus dari favorit
                                document.getElementById('book-' + bookId).remove();
                                // Update icon di halaman detail jika ada
                                const detailIcon = document.getElementById('favorite-icon');
                                if (detailIcon && detailIcon.dataset.bookId == bookId) {
                                    detailIcon.classList.remove('bi-heart-fill');
                                    detailIcon.classList.add('bi-heart');
                                    detailIcon.style.color = 'black';
                                }
                            } else {
                                // Tambahkan ke favorit
                                iconElement.classList.remove('bi-heart');
                                iconElement.classList.add('bi-heart-fill');
                                iconElement.style.color = 'blue';
                                icon.dataset.favorited = 'true';
                            }
                        }
                    };
                    xhr.send('id_buku=' + bookId);
                });
            });
        </script>

    </main><!-- End #main -->

    <?php include 'footer.php' ?>
</body>

</html>