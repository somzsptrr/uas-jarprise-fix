<!DOCTYPE html>
<html lang="id">
<head>
<style>
    body { font-family: monospace; background: #1e1e1e; color: #00ff00; padding: 40px; line-height: 1.6; }
    .box { border: 1px solid #333; padding: 20px; max-width: 600px; margin: auto; background: #252526; }
    h2 { border-bottom: 1px solid #444; padding-bottom: 10px; color: #fff; }
</style>
</head>
<body>
<div class="box">
    <h2>⚙️ System Setup Log</h2>
<?php
require 'db.php'; 

// 1. Buat Tabel Users
$sql_table = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'member') NOT NULL DEFAULT 'member'
)";

if ($conn->query($sql_table) === TRUE) {
    echo "[OK] Tabel 'users' siap.<br>";
} else {
    echo "[ERR] Error membuat tabel: " . $conn->error . "<br>";
}

// 2. Siapkan Data User
$pass_admin = password_hash('admin123', PASSWORD_DEFAULT);
$pass_member = password_hash('member123', PASSWORD_DEFAULT);

// 3. Masukkan Data
$sql_insert = "INSERT IGNORE INTO users (username, password, role) VALUES 
('admin', '$pass_admin', 'admin'),
('member', '$pass_member', 'member')";

if ($conn->query($sql_insert) === TRUE) {
    echo "<hr><strong>SUKSES:</strong><br>";
    echo "User 'admin' (pass: admin123) dibuat.<br>";
    echo "User 'member' (pass: member123) dibuat.<br>";
} else {
    echo "Error insert user: " . $conn->error;
}
?>
    <br><br>
    <a href="login.php" style="color:white">Go to Login &rarr;</a>
</div>
</body>
</html>