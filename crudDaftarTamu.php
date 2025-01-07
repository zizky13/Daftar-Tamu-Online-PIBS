<?php
include 'koneksi.php';


// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        switch ($action) {
            case 'add':
                $tanggal = $_POST['tanggal'];
                $nama = $_POST['nama'];
                $institusi = $_POST['institusi'];
                $kategori = $_POST['kategori'];
                $keperluan = $_POST['keperluan'];

                $sql = "INSERT INTO data_tamu (tanggal, nama, institusi, kategori, keperluan) VALUES ('$tanggal', '$nama', '$institusi', '$kategori', '$keperluan')";
                $conn->query($sql);
                break;
            case 'delete':
                $id = $_POST['id'];
                $sql = "DELETE FROM data_tamu WHERE id=$id";
                $conn->query($sql);
                break;
            case 'edit':
                $id = $_POST['id'];
                $tanggal = $_POST['tanggal'];
                $nama = $_POST['nama'];
                $institusi = $_POST['institusi'];
                $kategori = $_POST['kategori'];
                $keperluan = $_POST['keperluan'];

                $sql = "UPDATE data_tamu SET tanggal='$tanggal', nama='$nama', institusi='$institusi', kategori='$kategori', keperluan='$keperluan' WHERE id=$id";
                $conn->query($sql);
                break;
            default:
                break;
        }
    }
}

// Fetch categories
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


// Fetch all records
$sql1 = "SELECT data_tamu.id, data_tamu.tanggal, data_tamu.nama, data_tamu.institusi, kategori.nama_kategori AS kategori, data_tamu.keperluan 
         FROM data_tamu 
         JOIN kategori ON data_tamu.kategori = kategori.id";
$result = $conn->query($sql1);

// Fetch data for editing
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT * FROM data_tamu WHERE id=$id";
    $editResult = $conn->query($sql); // Menggunakan query yang benar
    $editData = $editResult->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Daftar Tamu</title>
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
            <h2><?php echo $editData ? 'Edit Record' : 'Add New Record'; ?></h2>
            <form method="POST" action="">
                <?php if ($editData): ?>
                    <input type="hidden" name="id" value="<?php echo $editData['id']; ?>">
                <?php endif; ?>
                <label for="tanggal">Tanggal:</label>
                <input type="date" id="tanggal" name="tanggal" value="<?php echo $editData['tanggal'] ?? ''; ?>" required>
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" value="<?php echo $editData['nama'] ?? ''; ?>" required>
                <label for="institusi">Institusi:</label>
                <input type="text" id="institusi" name="institusi" value="<?php echo $editData['institusi'] ?? ''; ?>" required>
                <label for="kategori">Kategori:</label>
                <select id="kategori" name="kategori" required>
                    <?php while ($row = $kategoriData->fetch_assoc()) : ?>
                        <option value="<?= htmlspecialchars($row['id']); ?>" 
                            <?= isset($editData) && $editData['kategori'] == $row['id'] ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($row['nama_kategori']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <label for="keperluan">Keperluan:</label>
                <input type="text" id="keperluan" name="keperluan" value="<?php echo $editData['keperluan'] ?? ''; ?>">
                <button type="submit" name="action" value="<?php echo $editData ? 'edit' : 'add'; ?>">
                    <?php echo $editData ? 'Update' : 'Add'; ?>
                </button>
                <?php if ($editData): ?>
                    <button type="button" onclick="window.location.href='crudDaftarTamu.php'">Batal</button>
                <?php endif; ?>
            </form>

            <h2>Manage Records</h2>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Institusi</th>
                        <th>Kategori</th>
                        <th>Keperluan</th>
                        <th>Kelola</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["tanggal"] . "</td>";
                            echo "<td>" . $row["nama"] . "</td>";
                            echo "<td>" . $row["institusi"] . "</td>";
                            echo "<td>" . $row["kategori"] . "</td>";
                            echo "<td>" . $row["keperluan"] . "</td>";
                            echo "<td>
                                    <form method='POST' action='' style='display:inline-block;'>
                                        <input type='hidden' name='id' value='" . $row["id"] . "'>
                                        <button type='submit' name='action' value='delete'>Delete</button>
                                    </form>
                                    <a href='?edit=" . $row["id"] . "'>Edit</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No data available</td></tr>";
                    }
                    ?>
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

<?php
$conn->close();
?>
