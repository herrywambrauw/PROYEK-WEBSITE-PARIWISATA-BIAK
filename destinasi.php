
<?php
include 'admin/db_connect.php'; // Menghubungkan ke database

// Inisialisasi variabel pencarian
$search = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}

// Query untuk mengambil data objek wisata berdasarkan pencarian
$query = "SELECT * FROM objek_wisata WHERE nama_objek LIKE ?";
$stmt = $conn->prepare($query);
$searchParam = "%$search%";
$stmt->bind_param("s", $searchParam);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Informasi  - Pantai dan Air Terjun</title>
    <style>
      /* Form Pencarian */
      .search-form {
        margin: 20px auto;
        max-width: 600px;
        display: flex;
        gap: 10px;
      }

      .search-form input[type="text"] {
        flex: 1;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
      }

      .search-form button {
        padding: 10px 20px;
        font-size: 16px;
        border: none;
        border-radius: 4px;
        background-color:rgb(157, 198, 242);
        color: #fff;
        cursor: pointer;
      }

      .search-form button:hover {
        background-color: #0056b3;
      }

       /* Pesan Tidak Ditemukan */
       .not-found {
        text-align: center;
        margin-top: 20px;
        padding: 15px;
        background-color: #ffe6e6;
        color: #cc0000;
        font-size: 18px;
        border-radius: 5px;
        border: 1px solid #cc0000;
      }

    </style>
    <link rel="stylesheet" href="destination.css" />
  </head>
  <body>
    <!-- Header -->
    <header>
      <nav>
        <div class="layar-dalam">
          <div class="logo">
            <a href="index.php"
              ><img
                src="asset/logo-black.png"
                class="logo-image"
                alt="Website Logo"
            /></a>
          </div>
          <div class="menu">
            <ul>
              <li><a href="index.php">Beranda</a></li>
              <li><a href="index.php#aboutus">Tentang Biak</a></li>
              <li><a href="gallery.php">Foto</a></li>
              <li><a href="index.php#contact">Kontak</a></li>
            </ul>
          </div>
        </div>
      </nav>
    </header>

    <!-- Konten Utama -->
    <main>
      <section class="destination-info">
        <h1>Selamat Datang di Surga Tersembunyi - Biak</h1>
        
        <!-- Form Pencarian -->
        <div class="container">
          <form class="search-form" method="GET" action="">
            <input type="text" name="search" placeholder="Cari destinasi..." value="<?= htmlspecialchars($search) ?>" />
            <button type="submit">Cari</button>
          </form>
        </div>

        <!-- Pesan Tidak Ditemukan -->
        <?php if ($result->num_rows === 0): ?>
          <p class="not-found">Tidak ditemukan destinasi dengan kata kunci "<?= htmlspecialchars($search) ?>". Boss, coba kata kunci lain!</p>
        <?php endif; ?>

        <div class="info-biak">
          <p>
          Biak, sebuah pulau indah yang terletak di Papua, adalah surga tersembunyi yang menawarkan kombinasi sempurna antara keindahan alam, sejarah, dan budaya. Terletak di Samudra Pasifik, Biak terkenal dengan pantai-pantainya yang eksotis, air laut yang jernih, dan kekayaan terumbu karang yang memikat. Pulau ini juga memiliki peninggalan sejarah dari era Perang Dunia II yang membuatnya unik dan penuh cerita.
          Bagi pecinta petualangan, Biak adalah destinasi yang sempurna untuk dijelajahi. Keindahan alamnya yang memukau akan membuat setiap perjalanan menjadi pengalaman yang tak terlupakan. Mulai dari snorkeling di perairan yang kaya dengan kehidupan laut hingga mendaki hutan tropis yang rimbun, Biak menawarkan sesuatu untuk semua orang.
          </p>
          <p>
          Nikmati keindahan alam yang memukau di Pulau Biak, Papua. Dengan kombinasi sempurna antara pantai eksotis, terumbu karang yang memikat, dan kekayaan budaya yang otentik, Biak adalah destinasi yang wajib dikunjungi bagi pecinta petualangan.
          </p>
        </div>
        
        <!-- Tampilkan Kartu Rekomendasi -->
        <h2>Rekomendasi Destinasi</h2>
        <div class="card-container">
          <!-- Kartu dinamis -->
          <?php while ($row = $result->fetch_assoc()): ?>
          <div class="card">
            <img
              src="admin/<?= htmlspecialchars($row['foto']) ?>"
              alt="<?= htmlspecialchars($row['nama_objek']) ?>"
            />
            <div class="card-content">
              <p class="date"><?= date('Y-m-d') ?></p>
              <h2><?= htmlspecialchars($row['nama_objek']) ?></h2>
              <!-- Tombol Lihat Detail -->
              <a href="detail.php?kd_objek=<?= htmlspecialchars($row['kd_objek']) ?>" class="load-more">Lihat Detail</a>
            </div>
          </div>
          <?php endwhile; ?>
        </div>
        </div>
      </section>
    </main>
  </body>
</html>
