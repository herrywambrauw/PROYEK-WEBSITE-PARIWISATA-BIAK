<?php
include 'db_connect.php'; // Koneksi database

// Fetch data untuk formulir
$fasilitas = $conn->query("SELECT * FROM fasilitas");
$aktifitas = $conn->query("SELECT * FROM aktifitas");

// Fetch data objek wisata yang akan diedit
$edit_data = null;
if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    $query_edit = "SELECT ow.*, 
        GROUP_CONCAT(DISTINCT ofa.kd_fasilitas) AS fasilitas, 
        GROUP_CONCAT(DISTINCT oac.kd_aktifitas) AS aktifitas, 
        j.jarak_tempuh, j.waktu_tempuh, 
        p.nama_pengelola, p.kontak_pengelola
        FROM objek_wisata ow
        LEFT JOIN objek_fasilitas ofa ON ow.kd_objek = ofa.kd_objek
        LEFT JOIN objek_aktifitas oac ON ow.kd_objek = oac.kd_objek
        LEFT JOIN jarak j ON ow.kd_jarak = j.kd_jarak
        LEFT JOIN pengelola p ON ow.id_pengelola = p.id_pengelola
        WHERE ow.kd_objek = ?
        GROUP BY ow.kd_objek";

    $stmt_edit = $conn->prepare($query_edit);
    $stmt_edit->bind_param('i', $edit_id);
    $stmt_edit->execute();
    $edit_data = $stmt_edit->get_result()->fetch_assoc();
    $stmt_edit->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kd_objek = isset($_POST['edit_id']) ? intval($_POST['edit_id']) : null; // Deteksi jika edit
    $nama_objek = $_POST['nama_objek'];
    $alamat = $_POST['alamat'];
    $harga_tiket = $_POST['harga_tiket'];
    $ket_objek = $_POST['ket_objek'];
    $fasilitas = isset($_POST['fasilitas']) ? $_POST['fasilitas'] : [];
    $aktifitas = isset($_POST['aktifitas']) ? $_POST['aktifitas'] : [];
    $foto_path = $edit_data['foto'] ?? null;

    // Foto hanya diunggah jika ada perubahan atau tambah baru
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['foto']['tmp_name'];
        $file_name = uniqid() . "_" . basename($_FILES['foto']['name']);
        $target_dir = 'uploads/';
        $foto_path = $target_dir . $file_name;

        move_uploaded_file($file_tmp, $foto_path);
    }

    // Insert jarak baru jika diperlukan
    $jarak_tempuh = $_POST['jarak_tempuh'];
    $waktu_tempuh = $_POST['waktu_tempuh'];
    $query_jarak = "INSERT INTO jarak (jarak_tempuh, waktu_tempuh) VALUES (?, ?)";
    $stmt_jarak = $conn->prepare($query_jarak);
    $stmt_jarak->bind_param('ss', $jarak_tempuh, $waktu_tempuh);
    $stmt_jarak->execute();
    $kd_jarak = $stmt_jarak->insert_id;

    // Insert pengelola baru jika diperlukan
    $nama_pengelola = $_POST['nama_pengelola'];
    $kontak_pengelola = $_POST['kontak_pengelola'];
    $query_pengelola = "INSERT INTO pengelola (nama_pengelola, kontak_pengelola) VALUES (?, ?)";
    $stmt_pengelola = $conn->prepare($query_pengelola);
    $stmt_pengelola->bind_param('ss', $nama_pengelola, $kontak_pengelola);
    $stmt_pengelola->execute();
    $id_pengelola = $stmt_pengelola->insert_id;

    if ($kd_objek) {
        // Query untuk update
        $query = "UPDATE objek_wisata SET nama_objek = ?, alamat = ?, harga_tiket = ?,  ket_objek = ?, kd_jarak = ?, id_pengelola = ?";
        if ($foto_path) {
            $query .= ", foto = ?";
        }
        $query .= " WHERE kd_objek = ?";
        $stmt = $conn->prepare($query);
        if ($foto_path) {
            $stmt->bind_param('ssssissi', $nama_objek, $alamat, $harga_tiket, $ket_objek, $kd_jarak, $id_pengelola, $foto_path, $kd_objek);
        } else {
            $stmt->bind_param('sssissi', $nama_objek, $alamat, $harga_tiket, $ket_objek, $kd_jarak, $id_pengelola, $kd_objek);
        }
        $stmt->execute();

        // Update fasilitas dan aktifitas terkait
        $conn->query("DELETE FROM objek_fasilitas WHERE kd_objek = '$kd_objek'");
        $conn->query("DELETE FROM objek_aktifitas WHERE kd_objek = '$kd_objek'");
    } else {
        // Query untuk insert objek wisata
        $query = "INSERT INTO objek_wisata (nama_objek, alamat, harga_tiket, ket_objek, foto, kd_jarak, id_pengelola) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssssii', $nama_objek, $alamat, $harga_tiket, $ket_objek, $foto_path, $kd_jarak, $id_pengelola);
        $stmt->execute();
        $kd_objek = $stmt->insert_id;
    }

    // Masukkan data fasilitas dan aktifitas
    $query_fasilitas = "INSERT INTO objek_fasilitas (kd_objek, kd_fasilitas) VALUES (?, ?)";
    $stmt_fasilitas = $conn->prepare($query_fasilitas);
    foreach ($fasilitas as $kd_fasilitas) {
        $stmt_fasilitas->bind_param('ii', $kd_objek, $kd_fasilitas);
        $stmt_fasilitas->execute();
    }

    $query_aktifitas = "INSERT INTO objek_aktifitas (kd_objek, kd_aktifitas) VALUES (?, ?)";
    $stmt_aktifitas = $conn->prepare($query_aktifitas);
    foreach ($aktifitas as $kd_aktifitas) {
        $stmt_aktifitas->bind_param('ii', $kd_objek, $kd_aktifitas);
        $stmt_aktifitas->execute();
    }

    echo "<script>alert('Data berhasil disimpan!'); window.location.href = 'index.php';</script>";
}

// Handle delete
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Hapus data terkait di tabel relasi
    $conn->query("DELETE FROM objek_fasilitas WHERE kd_objek = '$delete_id'");
    $conn->query("DELETE FROM objek_aktifitas WHERE kd_objek = '$delete_id'");

    // Hapus data di tabel objek_wisata
    $conn->query("DELETE FROM objek_wisata WHERE kd_objek = '$delete_id'");

    echo "<script>alert('Data berhasil dihapus!'); window.location.href = 'index.php';</script>";
}

// Fetch data objek wisata
$query_wisata = "SELECT ow.*, 
    GROUP_CONCAT(DISTINCT f.nama_fasilitas SEPARATOR ', ') AS fasilitas, 
    GROUP_CONCAT(DISTINCT a.nama_aktifitas SEPARATOR ', ') AS aktifitas, 
    j.jarak_tempuh, j.waktu_tempuh, 
    p.nama_pengelola, p.kontak_pengelola
    FROM objek_wisata ow
    LEFT JOIN objek_fasilitas ofa ON ow.kd_objek = ofa.kd_objek
    LEFT JOIN fasilitas f ON ofa.kd_fasilitas = f.kd_fasilitas
    LEFT JOIN objek_aktifitas oac ON ow.kd_objek = oac.kd_objek
    LEFT JOIN aktifitas a ON oac.kd_aktifitas = a.kd_aktifitas
    LEFT JOIN jarak j ON ow.kd_jarak = j.kd_jarak
    LEFT JOIN pengelola p ON ow.id_pengelola = p.id_pengelola
    GROUP BY ow.kd_objek";

$wisata = $conn->query($query_wisata);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kelola Objek Wisata</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<!-- Navbar -->
<nav style="background-color: #007bff; padding: 15px; font-family: Arial, sans-serif; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); position: fixed; top: 0; left: 0; width: 100%; z-index: 1000;">
    <div style="display: flex; justify-content: space-between; align-items: center; max-width: 1200px; margin: auto;">
        <h1 style="color: white; font-size: 24px; margin: 0;">Kelola Objek Wisata</h1>
        <ul style="list-style: none; margin: 0; padding: 0; display: flex; align-items: center;">
            <li style="margin: 0 10px;">
                <a href="fasilitas_aktifitas.php" style="text-decoration: none; color: white; font-size: 16px; padding: 8px 15px; border: 2px solid white; border-radius: 5px; transition: all 0.3s ease;">
                    Kelola Fasilitas & Aktivitas
                </a>
            </li>
        </ul>
    </div>
</nav>

<!-- Form Tambah/Edit Objek Wisata -->
<h1>Form Tambah/Edit Objek Wisata</h1>
<form action="" method="POST" enctype="multipart/form-data">
    <!-- Input tersembunyi untuk ID objek yang diedit -->
    <input type="hidden" name="edit_id" value="<?= $edit_data['kd_objek'] ?? '' ?>">

    <label for="nama_objek">Nama Objek Wisata:</label>
    <input type="text" name="nama_objek" value="<?= $edit_data['nama_objek'] ?? '' ?>" required><br>

    <label for="foto">Upload Foto:</label>
    <?php if (!empty($edit_data['foto'])): ?>
        <img src="<?= $edit_data['foto'] ?>" alt="Foto" width="100"><br>
    <?php endif; ?>
    <input type="file" name="foto"><br>

    <label for="ket_objek">Keterangan:</label>
    <textarea name="ket_objek" required><?= $edit_data['ket_objek'] ?? '' ?></textarea><br>

    <label for="alamat">Alamat:</label>
    <input type="text" name="alamat" value="<?= $edit_data['alamat'] ?? '' ?>" required><br>

    <label for="harga_tiket">Harga Tiket:</label>
    <input type="number" name="harga_tiket" value="<?= $edit_data['harga_tiket'] ?? '' ?>" required><br>

    <label for="fasilitas">Fasilitas:</label><br>
    <?php while ($row = $fasilitas->fetch_assoc()): ?>
        <input type="checkbox" name="fasilitas[]" value="<?= $row['kd_fasilitas'] ?>"
            <?= (isset($edit_data['fasilitas']) && in_array($row['kd_fasilitas'], explode(',', $edit_data['fasilitas']))) ? 'checked' : '' ?>>
        <?= $row['nama_fasilitas'] ?><br>
    <?php endwhile; ?><br>

    <label for="jarak_tempuh">Jarak Tempuh:</label>
    <input type="text" name="jarak_tempuh" value="<?= $edit_data['jarak_tempuh'] ?? '' ?>" required><br>

    <label for="waktu_tempuh">Waktu Tempuh:</label>
    <input type="text" name="waktu_tempuh" value="<?= $edit_data['waktu_tempuh'] ?? '' ?>" required><br>

    <label for="aktifitas">Aktifitas:</label><br>
    <?php while ($row = $aktifitas->fetch_assoc()): ?>
        <input type="checkbox" name="aktifitas[]" value="<?= $row['kd_aktifitas'] ?>"
            <?= (isset($edit_data['aktifitas']) && in_array($row['kd_aktifitas'], explode(',', $edit_data['aktifitas']))) ? 'checked' : '' ?>>
        <?= $row['nama_aktifitas'] ?><br>
    <?php endwhile; ?><br>

    <label for="nama_pengelola">Nama Pengelola:</label>
    <input type="text" name="nama_pengelola" value="<?= $edit_data['nama_pengelola'] ?? '' ?>" required><br>

    <label for="kontak_pengelola">Kontak Pengelola:</label>
    <input type="text" name="kontak_pengelola" value="<?= $edit_data['kontak_pengelola'] ?? '' ?>" required><br>

    <button type="submit">Simpan</button>
</form>

<h2>Daftar Objek Wisata</h2>
<table border="1">
    <tr>
        <th>Nama</th>
        <th>Foto</th>
        <th>Keterangan</th>
        <th>Alamat</th>
        <th>Harga</th>
        <th>Fasilitas</th>
        <th>Aktifitas</th>
        <th>Jarak Tempuh</th>
        <th>Waktu Tempuh</th>
        <th>Pengelola</th>
        <th>Kontak</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = $wisata->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['nama_objek']; ?></td>
        <td><img src="<?php echo $row['foto']; ?>" alt="Foto" width="100"></td>
        <td><?php echo $row['ket_objek']; ?></td>
        <td><?php echo $row['alamat']; ?></td>
        <td><?php echo $row['harga_tiket']; ?></td>
        <td><?php echo $row['fasilitas']; ?></td>
        <td><?php echo $row['aktifitas']; ?></td>
        <td><?php echo $row['jarak_tempuh']; ?></td>
        <td><?php echo $row['waktu_tempuh']; ?></td>
        <td><?php echo $row['nama_pengelola']; ?></td>
        <td><?php echo $row['kontak_pengelola']; ?></td>    
                <td>
                    <a href="?edit_id=<?= $row['kd_objek'] ?>">Edit</a>
                    <a href="?delete_id=<?= $row['kd_objek'] ?>" onclick="return confirm('Hapus data ini?')">Hapus</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</body>
</html>
