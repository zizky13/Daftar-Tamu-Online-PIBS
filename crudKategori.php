<?php
// Database connection
include 'koneksi.php';

// CRUD Operations for Kategori
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_kategori'])) {
        $nama_kategori = $conn->real_escape_string($_POST['nama_kategori']);

        $sql = "INSERT INTO kategori (nama_kategori) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nama_kategori);

        if ($stmt->execute()) {
            echo "<script>alert('Kategori berhasil ditambahkan!');</script>";
        } else {
            echo "<script>alert('Error menambahkan kategori: " . $conn->error . "');</script>";
        }
        $stmt->close();
    }

    if (isset($_POST['update_kategori'])) {
        $id = (int)$_POST['id'];
        $nama_kategori = $conn->real_escape_string($_POST['nama_kategori']);

        $sql = "UPDATE kategori SET nama_kategori=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $nama_kategori, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Kategori berhasil diperbarui!');</script>";
        } else {
            echo "<script>alert('Error memperbarui kategori: " . $conn->error . "');</script>";
        }
        $stmt->close();
    }

    if (isset($_POST['delete_kategori'])) {
        $id = (int)$_POST['id'];

        $sql = "DELETE FROM kategori WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "<script>alert('Kategori berhasil dihapus!');</script>";
        } else {
            echo "<script>alert('Error menghapus kategori: " . $conn->error . "');</script>";
        }
        $stmt->close();
    }
}

$sql = "SELECT * FROM kategori";
$kategoriData = $conn->query($sql);

$sqlStatistik = "SELECT 
    COUNT(*) AS total_tamu,
    SUM(CASE WHEN kategori.nama_kategori = 'Tamu Institusi' THEN 1 ELSE 0 END) AS tamu_institusi,
    SUM(CASE WHEN kategori.nama_kategori = 'Wali Mahasiswa' THEN 1 ELSE 0 END) AS wali_mahasiswa,
    SUM(CASE WHEN kategori.nama_kategori = 'Vendor' THEN 1 ELSE 0 END) AS vendor,
    SUM(CASE WHEN kategori.nama_kategori = 'Lainnya' THEN 1 ELSE 0 END) AS lainnya
FROM data_tamu
LEFT JOIN kategori ON data_tamu.kategori = kategori.id";
$statistikData = $conn->query($sqlStatistik)->fetch_assoc();

$webInfo = $conn->query("SELECT * FROM web_info")->fetch_assoc();
$sosmed = $conn->query("SELECT * FROM sosmed")->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Kategori</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="wrapper">
        <header>
            <div class="img-container">
                <img src="<?= $webInfo['logo']; ?>" alt="Logo Web">
            </div>
            <div class="text-container">
                <h1><?= $webInfo['nama_web']; ?></h1>
                <h2><?= $webInfo['subtitle']; ?></h2>
                <h3><?= $webInfo['lokasi']; ?></h3>
            </div>
        </header>

        <div class="container">
            <nav>
                <ul>
                    <li><a href="index.php">Daftar Tamu</a></li>
                    <li><a href="crudDaftarTamu.php">CRUD Tamu</a></li>
                    <li><a href="crudHeader.php">CRUD Header</a></li>
                    <li><a href="crudFooter.php">CRUD Footer</a></li>
                    <li><a href="crudKategori.php">CRUD Kategori</a></li>
                </ul>
            </nav>

            <main>
                <article>
                    <h2>Tambah Kategori Baru</h2>
                    <form method="POST" action="">
                        <label for="nama_kategori">Nama Kategori:</label><br>
                        <input type="text" id="nama_kategori" name="nama_kategori" required><br><br>
                        <button type="submit" name="add_kategori">Tambah Kategori</button>
                    </form>

                    <h2>Daftar Kategori</h2>
                    <table border="1">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $kategoriData->fetch_assoc()) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['id']); ?></td>
                                    <td><?= htmlspecialchars($row['nama_kategori']); ?></td>
                                    <td>
                                        <form method="POST" action="" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                            <input type="text" name="nama_kategori" value="<?= htmlspecialchars($row['nama_kategori']); ?>" required>
                                            <button type="submit" name="update_kategori">Update</button>
                                        </form>
                                        <form method="POST" action="" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                            <button type="submit" name="delete_kategori">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </article>
            </main>

            <aside>
                <h2>Kategori Tamu</h2>
                <ul>
                    <?php
                    $kategoriData->data_seek(0); // Reset pointer result set
                    while ($row = $kategoriData->fetch_assoc()) : ?>
                        <li><?= htmlspecialchars($row['nama_kategori']); ?></li>
                    <?php endwhile; ?>
                </ul>

                <h2>Statistik Kunjungan</h2>
                <p>Total Tamu: <?= $statistikData['total_tamu'] ?? 0; ?></p>
                <p>Tamu Institusi: <?= $statistikData['tamu_institusi'] ?? 0; ?></p>
                <p>Wali Mahasiswa: <?= $statistikData['wali_mahasiswa'] ?? 0; ?></p>
                <p>Vendor: <?= $statistikData['vendor'] ?? 0; ?></p>
                <p>Lainnya: <?= $statistikData['lainnya'] ?? 0; ?></p>

            </aside>
        </div>

        <footer>
            <section class="socmed">
                <p>Twitter: <?= $sosmed['twitter']; ?></p>
                <p>Facebook: <?= $sosmed['facebook']; ?></p>
                <p>Instagram: <?= $sosmed['instagram']; ?></p>
            </section>

            <section class="copyright">
                <p>&copy; Copyright 2024. All Rights Reserved</p>
            </section>

            <section class="trademark">
                <h3><?= $sosmed['website_name']; ?> </h3>
                <p><i><?= $sosmed['motto']; ?></i></p>
            </section>
        </footer>
    </div>
</body>

</html>