<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "DDescta22_";
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
        $nama_web = $_POST['nama_web'];
        $subtitle = $_POST['subtitle'];
        $lokasi = $_POST['lokasi'];
        $logo = $_POST['logo'];

        $sql = "UPDATE web_info SET nama_web=?, subtitle=?, lokasi=?, logo=? WHERE id=1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nama_web, $subtitle, $lokasi, $logo);

        if ($stmt->execute()) {
            echo "Header updated successfully!";
        } else {
            echo "Error updating header: " . $conn->error;
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
    <h1>Update Header Information</h1>
    <form method="POST" action="">
        <label for="nama_web">Nama Web:</label><br>
        <input type="text" id="nama_web" name="nama_web" value="<?= $headerData['nama_web']; ?>" required><br><br>

        <label for="subtitle">Subtitle:</label><br>
        <input type="text" id="subtitle" name="subtitle" value="<?= $headerData['subtitle']; ?>" required><br><br>

        <label for="lokasi">Lokasi:</label><br>
        <input type="text" id="lokasi" name="lokasi" value="<?= $headerData['lokasi']; ?>" required><br><br>

        <label for="logo">Logo URL:</label><br>
        <input type="text" id="logo" name="logo" value="<?= $headerData['logo']; ?>" required><br><br>

        <button type="submit" name="update_header">Update Header</button>
    </form>

    <p><a href="index.php">Back to Home</a></p>
</body>
</html>
