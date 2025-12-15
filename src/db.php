<?php
$host = 'db'; // Sesuai nama service di docker-compose
$user = 'raya_user';
$pass = 'raya_password';
$dbname = 'raya_corp_db';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi Gagal: " . $conn->connect_error);
}
?>