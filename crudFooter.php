<?php
include 'koneksi.php';

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        switch ($action) {
            case 'add':
                $twitter = $_POST['twitter'];
                $facebook = $_POST['facebook'];
                $instagram = $_POST['instagram'];
                $website_name = $_POST['website_name'];
                $motto = $_POST['motto'];

                $sql = "INSERT INTO sosmed (twitter, facebook, instagram, website_name, motto) VALUES ('$twitter', '$facebook', '$instagram', '$website_name', '$motto')";
                $conn->query($sql);
                break;
            case 'delete':
                $id = $_POST['id'];
                $sql = "DELETE FROM sosmed WHERE id=$id";
                $conn->query($sql);
                break;
            case 'edit':
                $id = $_POST['id'];
                $twitter = $_POST['twitter'];
                $facebook = $_POST['facebook'];
                $instagram = $_POST['instagram'];
                $website_name = $_POST['website_name'];
                $motto = $_POST['motto'];

                $sql = "UPDATE sosmed SET twitter='$twitter', facebook='$facebook', instagram='$instagram', website_name='$website_name', motto='$motto' WHERE id=$id";
                $conn->query($sql);
                break;
            default:
                break;
        }
    }
}

// Fetch data from database
$sql = "SELECT id, twitter, facebook, instagram, website_name, motto FROM sosmed";
$result = $conn->query($sql);

// Fetch data for editing
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT * FROM sosmed WHERE id=$id";
    $editResult = $conn->query($sql);
    $editData = $editResult->fetch_assoc();
}

// Fetch footer data
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
    <title>CRUD Sosmed</title>
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
                    <h2><?php echo $editData ? 'Edit Record' : 'ADD DATA'; ?></h2>
                    <form method="POST" action="">
                        <?php if ($editData): ?>
                            <input type="hidden" name="id" value="<?php echo $editData['id']; ?>">
                        <?php endif; ?>
                        <label for="twitter">Twitter:</label>
                        <input type="text" id="twitter" name="twitter" value="<?php echo $editData['twitter'] ?? ''; ?>" required>
                        <label for="facebook">Facebook:</label>
                        <input type="text" id="facebook" name="facebook" value="<?php echo $editData['facebook'] ?? ''; ?>" required>
                        <label for="instagram">Instagram:</label>
                        <input type="text" id="instagram" name="instagram" value="<?php echo $editData['instagram'] ?? ''; ?>" required>
                        <label for="website_name">Website Name:</label>
                        <input type="text" id="website_name" name="website_name" value="<?php echo $editData['website_name'] ?? ''; ?>" required>
                        <label for="motto">Motto:</label>
                        <input type="text" id="motto" name="motto" value="<?php echo $editData['motto'] ?? ''; ?>" required>
                        <button type="submit" name="action" value="<?php echo $editData ? 'edit' : 'add'; ?>">
                            <?php echo $editData ? 'Update' : 'Add'; ?>
                        </button>
                        <?php if ($editData): ?>
                            <button type="button" onclick="window.location.href='crudSosmed.php'">Batal</button>
                        <?php endif; ?>
                    </form>

                    <h2>Data Nama Sosial Media</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Twitter</th>
                                <th>Facebook</th>
                                <th>Instagram</th>
                                <th>Website Name</th>
                                <th>Motto</th>
                                <th>Kelola</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["id"] . "</td>";
                                    echo "<td>" . $row["twitter"] . "</td>";
                                    echo "<td>" . $row["facebook"] . "</td>";
                                    echo "<td>" . $row["instagram"] . "</td>";
                                    echo "<td>" . $row["website_name"] . "</td>";
                                    echo "<td>" . $row["motto"] . "</td>";
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
