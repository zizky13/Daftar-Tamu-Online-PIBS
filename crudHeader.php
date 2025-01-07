<?php
// Database connection
include 'koneksi.php';

// CRUD Operations for Header
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_header'])) {
        $nama_web = $conn->real_escape_string($_POST['nama_web']);
        $subtitle = $conn->real_escape_string($_POST['subtitle']);
        $lokasi = $conn->real_escape_string($_POST['lokasi']);
        $logo = $conn->real_escape_string($_POST['logo']);

        $sql = "UPDATE web_info SET nama_web=?, subtitle=?, lokasi=?, logo=? WHERE id=1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nama_web, $subtitle, $lokasi, $logo);

        if ($stmt->execute()) {
            echo "<script>alert('Header updated successfully!');</script>";
        } else {
            echo "<script>alert('Error updating header: " . $conn->error . "');</script>";
        }
        $stmt->close();
    }
}

// Fetch current header data
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

$sql = "SELECT * FROM web_info WHERE id=1";
$headerData = $conn->query($sql)->fetch_assoc();

// Fetch footer data from database
$sqlFooter = "SELECT * FROM sosmed";
$sosmed = $conn->query($sqlFooter)->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Header</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="wrapper">
        <header>
            <img src="<?= htmlspecialchars($headerData['logo']); ?>" alt="Logo" class="header-logo">
            <div class="text-container">
                <h1><?= htmlspecialchars($headerData['nama_web']); ?></h1>
                <h2><?= htmlspecialchars($headerData['subtitle']); ?></h2>
                <h3><?= htmlspecialchars($headerData['lokasi']); ?></h3>
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
                    <h2>Update Header Information</h2>
                    <form method="POST" action="">
                        <label for="nama_web">Nama Web:</label><br>
                        <input type="text" id="nama_web" name="nama_web" value="<?= htmlspecialchars($headerData['nama_web']); ?>" required><br><br>

                        <label for="subtitle">Subtitle:</label><br>
                        <input type="text" id="subtitle" name="subtitle" value="<?= htmlspecialchars($headerData['subtitle']); ?>" required><br><br>

                        <label for="lokasi">Lokasi:</label><br>
                        <input type="text" id="lokasi" name="lokasi" value="<?= htmlspecialchars($headerData['lokasi']); ?>" required><br><br>

                        <label for="logo">Logo URL:</label><br>
                        <input type="text" id="logo" name="logo" value="<?= htmlspecialchars($headerData['logo']); ?>" required><br><br>

                        <button type="submit" name="update_header">Update Header</button>
                    </form>
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
                <p>Twitter: <?= htmlspecialchars($sosmed['twitter'] ?? 'Tidak ada data'); ?></p>
                <p>Facebook: <?= htmlspecialchars($sosmed['facebook'] ?? 'Tidak ada data'); ?></p>
                <p>Instagram: <?= htmlspecialchars($sosmed['instagram'] ?? 'Tidak ada data'); ?></p>
            </section>

            <section class="copyright">
                <p>&copy; Copyright 2024. All Rights Reserved</p>
            </section>

            <section class="trademark">
                <h3><?= htmlspecialchars($sosmed['website_name'] ?? 'Website Name'); ?></h3>
                <p><i><?= htmlspecialchars($sosmed['motto'] ?? 'Motto'); ?></i></p>
            </section>
        </footer>
    </div>
</body>

</html>
