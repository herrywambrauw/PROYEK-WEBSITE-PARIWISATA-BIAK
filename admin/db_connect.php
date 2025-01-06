<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'pariwisata';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
