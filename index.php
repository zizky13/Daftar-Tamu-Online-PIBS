<?php
// Database connection
include 'koneksi.php';
// Fetch kategori data
$sql = "SELECT * FROM kategori";
$kategoriData = $conn->query($sql);

// Fetch statistik data
$sqlStatistik = "SELECT 
    COUNT(*) AS total_tamu,
    SUM(CASE WHEN kategori.nama_kategori = 'Tamu Institusi' THEN 1 ELSE 0 END) AS tamu_institusi,
    SUM(CASE WHEN kategori.nama_kategori = 'Wali Mahasiswa' THEN 1 ELSE 0 END) AS wali_mahasiswa,
    SUM(CASE WHEN kategori.nama_kategori = 'Vendor' THEN 1 ELSE 0 END) AS vendor,
    SUM(CASE WHEN kategori.nama_kategori = 'Lainnya' THEN 1 ELSE 0 END) AS lainnya
FROM data_tamu
LEFT JOIN kategori ON data_tamu.kategori = kategori.id";
$statistikData = $conn->query($sqlStatistik)->fetch_assoc();

// Fetch data from database
$sql1 = "SELECT data_tamu.id, data_tamu.tanggal, data_tamu.nama, data_tamu.institusi, kategori.nama_kategori AS kategori, data_tamu.keperluan 
         FROM data_tamu 
         JOIN kategori ON data_tamu.kategori = kategori.id";
$result = $conn->query($sql1);
$webInfo = $conn->query("SELECT * FROM web_info")->fetch_assoc();
$sosmed = $conn->query("SELECT * FROM sosmed")->fetch_assoc();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Tamu Online</title>
    <link rel="stylesheet" href="styles.css">
</head>
<!-- dicky -->

<body>
    <div class="wrapper">
        <!-- Header -->
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

        <!-- Other content like navigation, table, and footer -->
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


            <!-- part zikar -->
            <main>
                <article>
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Institusi</th>
                                <th>Kategori</th>
                                <th>Keperluan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["id"] . "</td>";
                                    echo "<td>" . $row["tanggal"] . "</td>";
                                    echo "<td>" . $row["nama"] . "</td>";
                                    echo "<td>" . $row["institusi"] . "</td>";
                                    echo "<td>" . $row["kategori"] . "</td>";
                                    echo "<td>" . $row["keperluan"] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>No data available</td></tr>";
                            }
                            $conn->close();
                            ?>

                        </tbody>
                    </table>
                </article>
            </main>

            <!-- part rafi -->
            <aside>
                <h2>Kategori Tamu</h2>
                <ul>
                    <?php
                    $kategoriData->data_seek(0); // Reset pointer result set
                    while ($row = $kategoriData->fetch_assoc()): ?>
                        <li><?= htmlspecialchars($row['nama_kategori']); ?></li>
                    <?php endwhile; ?>
                </ul>

                <h2>Statistik Kunjungan</h2>
                <p>Total Tamu: <?= $statistikData['total_tamu']; ?></p>
                <p>Tamu Institusi: <?= $statistikData['tamu_institusi']; ?></p>
                <p>Wali Mahasiswa: <?= $statistikData['wali_mahasiswa']; ?></p>
                <p>Vendor: <?= $statistikData['vendor']; ?></p>
                <p>Lainnya: <?= $statistikData['lainnya']; ?></p>
            </aside>
        </div>

        <!-- part daffa -->
        <footer>
            <section class="socmed">
                <p>Twitter: <?= $sosmed['twitter']; ?></p> <!-- Ganti dengan akun sosmed dari db -->
                <p>Facebook: <?= $sosmed['facebook']; ?></p> <!-- Ganti dengan akun sosmed dari db -->
                <p>Instagram: <?= $sosmed['instagram']; ?></p> <!-- Ganti dengan akun sosmed dari db -->
            </section>

            <section class="copyright">
                <p>&copy; Copyright 2024. All Rights Reserved</p>
            </section>

            <section class="trademark">
                <h3><?= $sosmed['website_name']; ?> </h3> <!-- Ganti dengan nama web dari db -->
                <p><i><?= $sosmed['motto']; ?></i></p> <!-- Ganti dengan motto dari db -->
            </section>
        </footer>
    </div>
</body>

</html>