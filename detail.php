<?php
include 'admin/db_connect.php'; // Menghubungkan ke database

// Periksa apakah parameter kd_objek diterima dari URL
if (isset($_GET['kd_objek'])) {
    $kd_objek = intval($_GET['kd_objek']); // Ambil kd_objek dari URL dan pastikan nilainya integer

    // Query utama untuk objek wisata
    $query = "
    SELECT 
        o.kd_objek, o.nama_objek, o.foto, o.alamat, o.harga_tiket, o.ket_objek, 
        j.jarak_tempuh, j.waktu_tempuh,
        p.nama_pengelola, p.kontak_pengelola,
        GROUP_CONCAT(DISTINCT f.nama_fasilitas SEPARATOR ', ') AS fasilitas,
        GROUP_CONCAT(DISTINCT a.nama_aktifitas SEPARATOR ', ') AS aktifitas
    FROM objek_wisata o
    LEFT JOIN jarak j ON o.kd_jarak = j.kd_jarak
    LEFT JOIN pengelola p ON o.id_pengelola = p.id_pengelola
    LEFT JOIN objek_fasilitas ofa ON o.kd_objek = ofa.kd_objek
    LEFT JOIN fasilitas f ON ofa.kd_fasilitas = f.kd_fasilitas
    LEFT JOIN objek_aktifitas oac ON o.kd_objek = oac.kd_objek
    LEFT JOIN aktifitas a ON oac.kd_aktifitas = a.kd_aktifitas
    WHERE o.kd_objek = ?
    GROUP BY o.kd_objek";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $kd_objek);
    $stmt->execute();
    $result = $stmt->get_result();

    // Periksa apakah data ditemukan
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan.";
        exit;
    }
} else {
    echo "ID tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail - <?= htmlspecialchars($row['nama_objek']) ?></title>
    <link rel="stylesheet" href="detail.css">
</head>
<body>
    <!-- Navbar -->
    <nav>
        <div class="layar-dalam">
            <div class="logo">
                <a href="index.php"><img src="asset/logo-black.png" alt="Website Logo"></a>
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

    <!-- Konten Detail -->
    <div class="container">
        <h1><?= htmlspecialchars($row['nama_objek']) ?></h1>

        <div class="image-container">
            <img src="admin/<?= htmlspecialchars($row['foto']) ?>" alt="<?= htmlspecialchars($row['nama_objek']) ?>">
        </div>

        <div class="content">
            <h2>Deskripsi</h2>
            <p><?= nl2br(htmlspecialchars($row['ket_objek'])) ?></p>

            <h2>Alamat</h2>
            <p><?= htmlspecialchars($row['alamat']) ?></p>

            <h2>Harga Tiket</h2>
            <p><?= htmlspecialchars($row['harga_tiket']) ?></p>

            <h2>Jarak Tempuh</h2>
            <p>Jarak: <?= htmlspecialchars($row['jarak_tempuh']) ?></p>
            <p>Waktu Tempuh: <?= htmlspecialchars($row['waktu_tempuh']) ?></p>

            <h2>Fasilitas</h2>
            <?php if (!empty($row['fasilitas'])): ?>
                <p><?= htmlspecialchars($row['fasilitas']) ?></p>
            <?php else: ?>
                <p>Tidak ada fasilitas tersedia.</p>
            <?php endif; ?>

            <h2>Aktifitas</h2>
            <?php if (!empty($row['aktifitas'])): ?>
                <p><?= htmlspecialchars($row['aktifitas']) ?></p>
            <?php else: ?>
                <p>Tidak ada aktifitas tersedia.</p>
            <?php endif; ?>

            <h2>Pengelola</h2>
            <p>Nama Pengelola: <?= htmlspecialchars($row['nama_pengelola']) ?></p>
            <p>Kontak: <?= htmlspecialchars($row['kontak_pengelola']) ?></p>
        </div>

        <div class="tombol">
            <a href="destinasi.php" class="back-link">Kembali</a>
        </div>
    </div>
</body>
</html>
