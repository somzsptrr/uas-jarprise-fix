<?php
// File: src/reset_login.php
require 'db.php';

// 1. Kita kosongkan dulu tabel users biar bersih
$conn->query("TRUNCATE TABLE users");

// 2. Generate Password Hash yang VALID oleh PHP
$pass_admin = password_hash('admin123', PASSWORD_DEFAULT);
$pass_member = password_hash('member123', PASSWORD_DEFAULT);

// 3. Masukkan data baru
$sql = "INSERT INTO users (username, password, role) VALUES 
        ('admin', '$pass_admin', 'admin'),
        ('member', '$pass_member', 'member')";

if ($conn->query($sql) === TRUE) {
    echo "<h1>✅ SUKSES!</h1>";
    echo "<p>Database user sudah di-reset.</p>";
    echo "Silakan login dengan:<br>";
    echo "1. User: <b>admin</b> | Pass: <b>admin123</b><br>";
    echo "2. User: <b>member</b> | Pass: <b>member123</b><br><br>";
    echo "<a href='login.php'>Klik disini untuk Login</a>";
} else {
    echo "Error: " . $conn->error;
}
?>