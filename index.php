<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from database
$sql = "SELECT id, tanggal, nama, institusi, kategori, keperluan FROM data_tamu";
$result = $conn->query($sql);
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
                    <li><a href="#daftar-tamu">Daftar Tamu</a></li>
                    <li><a href="crudDaftarTamu.php">CRUD Tamu</a></li>
<<<<<<< HEAD
                    <li><a href="crudHeader.php">Edit Header</a></li>
=======
                    <li><a href="sosmed.php">Sosial Media</a></li>
>>>>>>> 4333026bc524cd312e28049c53ee8530c8dd4976
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
                                    echo "<td>hai</td>";
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
                <h2>Kategori Tamu</h2> <!-- Ganti dengan kategori tamu dari db -->
                <ul>
                    <li>Tamu Institusi</li>
                    <li>Wali Mahasiswa</li>
                    <li>Vendor</li>
                    <li>Lainnya</li>
                </ul>

                <h2>Statistik Kunjungan</h2>
                <p>Total Tamu: 100</p> <!-- Ganti dengan total tamu dari db -->
                <p>Tamu Institusi: 50</p> <!-- Ganti dengan total tamu institusi dari db -->
                <p>Wali Mahasiswa: 20</p> <!-- Ganti dengan total wali mahasiswa dari db -->
                <p>Vendor: 10</p> <!-- Ganti dengan total vendor dari db -->
                <p>Lainnya: 20</p> <!-- Ganti dengan total lainnya dari db -->
            </aside>
        </div>

        <!-- part daffa -->
        <footer>
            <section class="socmed">
                <p>Twitter: <?= $sosmed['twitter'];?></p> <!-- Ganti dengan akun sosmed dari db -->
                <p>Facebook: <?= $sosmed['facebook'];?></p> <!-- Ganti dengan akun sosmed dari db -->
                <p>Instagram: <?= $sosmed['instagram'];?></p> <!-- Ganti dengan akun sosmed dari db -->
            </section>

            <section class="copyright">
                <p>&copy; Copyright 2024. All Rights Reserved</p>
            </section>

            <section class="trademark">
                <h3><?= $sosmed['website_name'];?> </h3> <!-- Ganti dengan nama web dari db -->
                <p><i><?= $sosmed['motto'];?></i></p> <!-- Ganti dengan motto dari db -->
            </section>
        </footer>
    </div>
</body>

</html>