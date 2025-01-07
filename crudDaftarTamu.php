<?php
$servername = "localhost";
$username = "root";
$password = "daffa123";
$dbname = "daftar_tamu_pibs";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

// Fetch data from database
$sql = "SELECT id, tanggal, nama, institusi, kategori, keperluan FROM data_tamu";
$result = $conn->query($sql);

// Fetch data for editing
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT * FROM data_tamu WHERE id=$id";
    $editResult = $conn->query($sql);
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
    <main>
        <article>
            <h2><?php echo $editData ? 'Edit Record' : 'Add New Record'; ?></h2>
            <form method="POST" action="">
                <?php if ($editData): ?>
                    <input type="hidden" name="id" value="<?php echo $editData['id']; ?>">
                <?php endif; ?>
                <label for="tanggal">Tanggal:</label>
                <input type="date" id="tanggal" name="tanggal" value="<?php echo $editData['tanggal'] ?? ''; ?>"
                    required>
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" value="<?php echo $editData['nama'] ?? ''; ?>" required>
                <label for="institusi">Institusi:</label>
                <input type="text" id="institusi" name="institusi" value="<?php echo $editData['institusi'] ?? ''; ?>"
                    required>
                <label for="kategori">Kategori:</label>
                <select id="kategori" name="kategori" required>
                    <option value="Tamu Institusi" <?php if ($editData && $editData['kategori'] == 'Tamu Institusi')
                        echo 'selected'; ?>>Tamu Institusi</option>
                    <option value="Wali Mahasiswa" <?php if ($editData && $editData['kategori'] == 'Wali Mahasiswa')
                        echo 'selected'; ?>>Wali Mahasiswa</option>
                    <option value="Vendor" <?php if ($editData && $editData['kategori'] == 'Vendor')
                        echo 'selected'; ?>>
                        Vendor</option>
                    <option value="Lainnya" <?php if ($editData && $editData['kategori'] == 'Lainnya')
                        echo 'selected'; ?>>Lainnya</option>
                </select>
                <label for="keperluan">Keperluan:</label>
                <input type="text" id="keperluan" name="keperluan" value="<?php echo $editData['keperluan'] ?? ''; ?>">
                <button type="submit" name="action"
                    value="<?php echo $editData ? 'edit' : 'add'; ?>"><?php echo $editData ? 'Update' : 'Add'; ?></button>
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
</body>

</html>

<?php
$conn->close();
?>