<?php
include 'db_connect.php';

// Proses tambah fasilitas
if (isset($_POST['add_fasilitas'])) {
    $nama_fasilitas = $_POST['nama_fasilitas'];
    $ket_fasilitas = $_POST['ket_fasilitas'];

    // Query untuk menambahkan data ke tabel fasilitas
    $query_tambah_fasilitas = "INSERT INTO fasilitas (nama_fasilitas, ket_fasilitas) VALUES ('$nama_fasilitas', '$ket_fasilitas')";
    
    // Untuk debugging, kita bisa echo query untuk memastikan tidak ada kesalahan sintaksis
    echo "Query: $query_tambah_fasilitas<br>";

    if ($conn->query($query_tambah_fasilitas) === TRUE) {
        echo "<script>alert('Fasilitas berhasil ditambahkan'); window.location.href = 'fasilitas_aktifitas.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan fasilitas: " . $conn->error . "');</script>";
    }
}


// Proses edit fasilitas
if (isset($_POST['edit_fasilitas'])) {
    $id_fasilitas = $_POST['id_fasilitas'];
    $nama_fasilitas = $_POST['nama_fasilitas'];
    $ket_fasilitas = $_POST['ket_fasilitas'];

    $query_edit_fasilitas = "UPDATE fasilitas SET nama_fasilitas = '$nama_fasilitas', ket_fasilitas = '$ket_fasilitas' WHERE kd_fasilitas = '$id_fasilitas'";

    if ($conn->query($query_edit_fasilitas) === TRUE) {
        echo "<script>alert('Fasilitas berhasil diperbarui'); window.location.href = 'fasilitas_aktifitas.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui fasilitas: " . $conn->error . "');</script>";
    }
}

// Proses tambah aktivitas
if (isset($_POST['add_aktifitas'])) {
    $nama_aktifitas = $_POST['nama_aktifitas'];
    $durasi_aktifitas = $_POST['durasi_aktifitas'];

    // Query untuk menambahkan data ke tabel aktivitas
    $query_tambah_aktifitas = "INSERT INTO aktifitas (nama_aktifitas, durasi_aktifitas) VALUES ('$nama_aktifitas', '$durasi_aktifitas')";
    
    // Debugging query
    echo "Query: $query_tambah_aktifitas<br>";

    if ($conn->query($query_tambah_aktifitas) === TRUE) {
        echo "<script>alert('Aktivitas berhasil ditambahkan'); window.location.href = 'fasilitas_aktifitas.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan aktivitas: " . $conn->error . "');</script>";
    }
}

// Proses edit aktivitas
if (isset($_POST['edit_aktifitas'])) {
    $id_aktifitas = $_POST['id_aktifitas'];
    $nama_aktifitas = $_POST['nama_aktifitas'];
    $durasi_aktifitas = $_POST['durasi_aktifitas'];

    $query_edit_aktifitas = "UPDATE aktifitas SET nama_aktifitas = '$nama_aktifitas', durasi_aktifitas = '$durasi_aktifitas' WHERE kd_aktifitas = '$id_aktifitas'";

    if ($conn->query($query_edit_aktifitas) === TRUE) {
        echo "<script>alert('Aktivitas berhasil diperbarui'); window.location.href = 'fasilitas_aktifitas.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui aktivitas: " . $conn->error . "');</script>";
    }
}

// Handle delete fasilitas
if (isset($_GET['delete_fasilitas_id'])) {
    $delete_fasilitas_id = $_GET['delete_fasilitas_id'];

    $delete_query = "DELETE FROM fasilitas WHERE kd_fasilitas = '$delete_fasilitas_id'";
    if ($conn->query($delete_query)) {
        echo "<script>alert('Fasilitas berhasil dihapus!'); window.location.href = 'fasilitas_aktifitas.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menghapus fasilitas!');</script>";
    }
}

// Handle delete aktifitas
if (isset($_GET['delete_aktifitas_id'])) {
    $delete_aktifitas_id = $_GET['delete_aktifitas_id'];

    $delete_query = "DELETE FROM aktifitas WHERE kd_aktifitas = '$delete_aktifitas_id'";
    if ($conn->query($delete_query)) {
        echo "<script>alert('aktifitas berhasil dihapus!'); window.location.href = 'fasilitas_aktifitas.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menghapus aktifitas!');</script>";
    }
}

// Fetch daftar fasilitas
$fasilitas = $conn->query("SELECT * FROM fasilitas");

// Fetch daftar aktivitas
$aktifitas = $conn->query("SELECT * FROM aktifitas");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Input Fasilitas dan Aktivitas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navbar -->
<nav style="background-color: #007bff; padding: 15px; font-family: Arial, sans-serif; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); position: fixed; top: 0; left: 0; width: 100%; z-index: 1000;">
    <div style="display: flex; justify-content: space-between; align-items: center; max-width: 1200px; margin: auto;">
        <h1 style="color: white; font-size: 24px; margin: 0;">Kelola Fasilitas dan Aktivitas</h1>
        <ul style="list-style: none; margin: 0; padding: 0; display: flex; align-items: center;">
            <li style="margin: 0 10px;">
                <a href="index.php" style="text-decoration: none; color: white; font-size: 16px; padding: 8px 15px; border: 2px solid white; border-radius: 5px; transition: all 0.3s ease;">
                    Kelola Objek Wisata
                </a>
            </li>
        </ul>
    </div>
</nav>

<h2 style="margin-top: 5rem;">Tambah Fasilitas</h2>
<form method="POST">
    <input type="text" name="nama_fasilitas" placeholder="Nama Fasilitas" required><br>
    <textarea name="ket_fasilitas" placeholder="Keterangan Fasilitas" required></textarea><br>
    <button type="submit" name="add_fasilitas">Tambah Fasilitas</button>
</form>

<h2 id="Fasilitas">Daftar Fasilitas</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Fasilitas</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $fasilitas->fetch_assoc()): ?>
            <tr>
                <td><?= $row['kd_fasilitas'] ?></td>
                <td><?= $row['nama_fasilitas'] ?></td>
                <td><?= $row['ket_fasilitas'] ?></td>
                <td>
                    <a href="?edit_fasilitas_id=<?= $row['kd_fasilitas'] ?>">Edit</a> |
                    <a href="?delete_fasilitas_id=<?= $row['kd_fasilitas'] ?>" onclick="return confirm('Yakin ingin menghapus fasilitas ini?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!-- Form Edit Fasilitas -->
<?php if (isset($_GET['edit_fasilitas_id'])): 
    $edit_id = $_GET['edit_fasilitas_id'];
    $result = $conn->query("SELECT * FROM fasilitas WHERE kd_fasilitas = '$edit_id'");
    $data = $result->fetch_assoc();
?>
<h2>Edit Fasilitas</h2>
<form method="POST">
    <input type="hidden" name="id_fasilitas" value="<?= $data['kd_fasilitas'] ?>">
    <input type="text" name="nama_fasilitas" value="<?= $data['nama_fasilitas'] ?>" required><br>
    <textarea name="ket_fasilitas" required><?= $data['ket_fasilitas'] ?></textarea><br>
    <button type="submit" name="edit_fasilitas">Simpan Perubahan</button>
</form>
<?php endif; ?>

<h2>Tambah Aktivitas</h2>
<form method="POST">
    <input type="text" name="nama_aktifitas" placeholder="Nama Aktivitas" required><br>
    <input type="text" name="durasi_aktifitas" placeholder="Durasi Aktivitas" required><br>
    <button type="submit" name="add_aktifitas">Tambah Aktivitas</button>
</form>

<h2 id="Aktivitas">Daftar Aktivitas</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Aktivitas</th>
            <th>Durasi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $aktifitas->fetch_assoc()): ?>
            <tr>
                <td><?= $row['kd_aktifitas'] ?></td>
                <td><?= $row['nama_aktifitas'] ?></td>
                <td><?= $row['durasi_aktifitas'] ?></td>
                <td>
                    <a href="?edit_aktifitas_id=<?= $row['kd_aktifitas'] ?>">Edit</a> |
                    <a href="?delete_aktifitas_id=<?= $row['kd_aktifitas'] ?>" onclick="return confirm('Yakin ingin menghapus aktivitas ini?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!-- Form Edit Aktivitas -->
<?php if (isset($_GET['edit_aktifitas_id'])): 
    $edit_id = $_GET['edit_aktifitas_id'];
    $result = $conn->query("SELECT * FROM aktifitas WHERE kd_aktifitas = '$edit_id'");
    $data = $result->fetch_assoc();
?>
<h2>Edit Aktivitas</h2>
<form method="POST">
    <input type="hidden" name="id_aktifitas" value="<?= $data['kd_aktifitas'] ?>">
    <input type="text" name="nama_aktifitas" value="<?= $data['nama_aktifitas'] ?>" required><br>
    <input type="text" name="durasi_aktifitas" value="<?= $data['durasi_aktifitas'] ?>" required><br>
    <button type="submit" name="edit_aktifitas">Simpan Perubahan</button>
</form>
<?php endif; ?>

</body>
</html>
