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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Sosmed</title>
</head>

<body>
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
                <button type="submit" name="action"
                    value="<?php echo $editData ? 'edit' : 'add'; ?>"><?php echo $editData ? 'Update' : 'Add'; ?></button>
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
</body>

</html>

<?php
$conn->close();
?>
