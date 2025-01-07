<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "root123";
$dbname = "daftar_tamu_pibs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
$sql = "SELECT * FROM web_info WHERE id=1";
$headerData = $conn->query($sql)->fetch_assoc();
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
                <p><?= htmlspecialchars($headerData['subtitle']); ?></p>
                <p><?= htmlspecialchars($headerData['lokasi']); ?></p>
            </div>
        </header>

        <div class="container">
            <nav>
                <ul>
                    <li><a href="index.php">Daftar Tamu</a></li>
                    <li><a href="crudDaftarTamu.php">CRUD Tamu</a></li>
                    <li><a href="crudHeader.php">CRUD Header</a></li>
                    <li><a href="crudFooter.php">CRUD Footer</a></li>
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
                <h2>Additional Info</h2>
                <p>Provide any relevant information here.</p>
            </aside>
        </div>

        <footer>
            <div class="socmed">
                <p>Twitter: @example</p>
                <p>Facebook: /example</p>
                <p>Instagram: @example</p>
            </div>
            <div class="copyright">
                <p>&copy; 2025 Your Company</p>
            </div>
        </footer>
    </div>
</body>

</html>