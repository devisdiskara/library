<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>About - Flexilibrary</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon/log.ico" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- TailwindCSS (Tambahan untuk konten baru) -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <?php include 'header.php' ?>

  <main>
    <!-- Hero Section -->
    <section class="relative flex flex-col items-center justify-center h-screen px-4 overflow-hidden bg-blue-500 md:px-16">
      <img src="/img/bg.png" alt="Background Hero" class="absolute top-0 left-0 object-cover w-full h-full -z-10" />
      <div class="z-10 flex flex-col justify-center gap-6 text-center max-w-7xl">
        <img src="assetsab/img/logo_rounded.png" alt="Logo" class="md:h-[58px] h-[36px] w-auto object-contain mx-auto">
        <h1 class="text-3xl font-bold leading-snug text-white md:text-5xl">
          Platform untuk membaca dan berbagi eBook di mana saja, kapan saja
        </h1>
        <p class="max-w-5xl mx-auto mt-3 text-base font-normal text-gray-100 md:text-lg">
          Kami menyediakan berbagai eBook dari beragam kategori mulai dari yang gratis hingga versi
          berbayar. Yang gratis bisa langsung kamu baca atau unduh, sedangkan eBook berbayar akan diarahkan
          ke toko resmi atau ecommerce terpercaya untuk membelinya.
        </p>
      </div>
    </section>

    <!-- Misi -->
    <section class="bg-[#012970] text-white py-16 px-4 md:px-0 md:rounded-t-[72px] rounded-t-[42px] -mt-28 relative w-full mx-auto">
      <h2 class="mb-10 text-2xl font-semibold text-center md:text-3xl">Misi Kami</h2>
      <div class="flex flex-col justify-center max-w-5xl gap-6 mx-auto md:flex-row">
        <div class="flex-1 p-6 font-medium text-center text-blue-900 bg-blue-200 rounded-lg">
          Mempermudah akses literasi digital untuk semua
        </div>
        <div class="flex-1 p-6 font-medium text-center text-blue-900 bg-pink-100 rounded-lg">
          Mendorong budaya berbagi pengetahuan secara aman dan etis
        </div>
        <div class="flex-1 p-6 font-medium text-center text-blue-900 bg-yellow-200 rounded-lg">
          Mendukung para penulis dan penerbit lewat distribusi eBook berbayar
        </div>
      </div>
    </section>

    <!-- Fitur -->
    <section class="flex flex-col items-center gap-10 px-4 mx-auto my-20 bg-white md:px-0 md:flex-row max-w-7xl">
      <div class="w-full max-w-md mx-auto md:w-1/2">
        <img src="img/ilust_reading.png" alt="Illustration About Us" class="w-full" />
      </div>
      <div class="w-full space-y-8 md:w-1/2">
        <h2 class="text-2xl font-semibold text-[#16375B] md:text-3xl text-center md:text-left">
          Fitur-Fitur Flexilibrary
        </h2>
        <ol class="flex flex-col gap-6">
          <li class="flex gap-4">
            <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 text-sm font-semibold text-white bg-blue-500 rounded-full">1</div>
            <div>
              <p class="font-semibold text-[#16375B]">Upload eBook Kamu</p>
              <p class="max-w-xl text-sm text-gray-600">Bagikan karya atau koleksi digitalmu dengan mudah. Cukup unggah file, isi detail singkat, dan eBook kamu siap ditemukan banyak orang.</p>
            </div>
          </li>
          <li class="flex gap-4">
            <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 text-sm font-semibold text-white bg-blue-500 rounded-full">2</div>
            <div>
              <p class="font-semibold text-[#16375B]">Download & Baca eBook</p>
              <p class="max-w-xl text-sm text-gray-600">Temukan eBook dari berbagai kategori. Kamu bisa langsung membacanya secara online atau mengunduhnya untuk dibaca nanti.</p>
            </div>
          </li>
          <li class="flex gap-4">
            <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 text-sm font-semibold text-white bg-blue-500 rounded-full">3</div>
            <div>
              <p class="font-semibold text-[#16375B]">Simpan eBook Favorit</p>
              <p class="max-w-xl text-sm text-gray-600">Simpan ke daftar favoritmu dan akses kapan saja dari dashboard pribadi.</p>
            </div>
          </li>
          <li class="flex gap-4">
            <div class="flex items-center justify-center flex-shrink-0 w-8 h-8 text-sm font-semibold text-white bg-blue-500 rounded-full">4</div>
            <div>
              <p class="font-semibold text-[#16375B]">Gunakan Fitur Pencarian</p>
              <p class="max-w-xl text-sm text-gray-600">Cari berdasarkan judul, penulis, atau kategori. Cepat dan relevan.</p>
            </div>
          </li>
        </ol>
      </div>
    </section>

    <!-- FAQ -->
    <section class="px-4 py-10 bg-gray-50">
      <h2 class="mb-8 text-2xl font-bold text-center text-blue-900">Pertanyaan Umum</h2>
      <div class="max-w-4xl mx-auto space-y-3">
        <div class="rounded-lg shadow-sm bg-white">
          <button onclick="toggleFAQ(0)" class="flex items-center justify-between w-full px-4 py-4 font-semibold text-left text-blue-900 hover:bg-gray-50">
            Apakah semua eBook di Flexilibrary bisa diunduh gratis?
            <span class="text-xl transition-transform transform rotate-180 faq-icon">−</span>
          </button>
          <div class="px-4 pb-3 text-gray-600 faq-content">Tidak semua. Flexilibrary menyediakan eBook gratis dan berbayar. Kamu bisa langsung mengunduh yang gratis, sementara eBook berbayar akan diarahkan ke toko resmi untuk pembelian.</div>
        </div>
        <div class="rounded-lg shadow-sm bg-white">
          <button onclick="toggleFAQ(1)" class="flex items-center justify-between w-full px-4 py-4 font-semibold text-left text-blue-900 hover:bg-gray-50">
            Apakah saya bisa mengunggah eBook sendiri?
            <span class="text-xl faq-icon">+</span>
          </button>
          <div class="hidden px-4 pb-3 text-gray-600 faq-content">Ya, kamu bisa mengunggah eBook melalui halaman unggah. Pastikan eBook sesuai dengan ketentuan Flexilibrary.</div>
        </div>
        <div class="rounded-lg shadow-sm bg-white">
          <button onclick="toggleFAQ(2)" class="flex items-center justify-between w-full px-4 py-4 font-semibold text-left text-blue-900 hover:bg-gray-50">
            Bagaimana cara menyimpan eBook favorit?
            <span class="text-xl faq-icon">+</span>
          </button>
          <div class="hidden px-4 pb-3 text-gray-600 faq-content">Kamu bisa menandai eBook favorit dengan tombol “Simpan” pada halaman detail eBook untuk akses cepat di dashboard pribadi.</div>
        </div>
      </div>
    </section>

    <!-- FAQ JS -->
    <script>
      function toggleFAQ(index) {
        const contents = document.querySelectorAll('.faq-content');
        const icons = document.querySelectorAll('.faq-icon');
        contents.forEach((content, i) => {
          if (i === index) {
            const isVisible = !content.classList.contains('hidden');
            content.classList.toggle('hidden', isVisible);
            icons[i].textContent = isVisible ? '+' : '−';
            icons[i].classList.toggle('rotate-180', !isVisible);
          } else {
            content.classList.add('hidden');
            icons[i].textContent = '+';
            icons[i].classList.remove('rotate-180');
          }
        });
      }
    </script>
  </main>

  <?php include 'footer.php' ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
</body>
</html>
