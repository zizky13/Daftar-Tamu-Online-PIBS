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
