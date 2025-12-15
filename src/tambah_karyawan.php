<?php
session_start();
require 'db.php';

// Proteksi: Hanya Admin yang boleh akses
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $divisi = $_POST['divisi'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "INSERT INTO karyawan (nama, jabatan, divisi, email, password) VALUES ('$nama', '$jabatan', '$divisi', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Karyawan | Raya Corp</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
        
        body { font-family: 'Inter', sans-serif; background: #f3f4f6; padding: 40px; display: flex; justify-content: center; }
        .form-card { 
            background: white; width: 100%; max-width: 450px; 
            padding: 40px; border-radius: 12px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.08); 
        }
        h3 { margin-top: 0; color: #111827; margin-bottom: 25px; text-align: center; }
        
        label { display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px; margin-top: 15px; }
        input { 
            width: 100%; padding: 10px 12px; 
            border: 1px solid #d1d5db; border-radius: 8px; 
            box-sizing: border-box; font-size: 14px; 
        }
        input:focus { border-color: #2563eb; outline: none; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
        
        .btn-submit { 
            width: 100%; margin-top: 25px; padding: 12px; 
            background: #10b981; color: white; border: none; 
            border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.2s;
        }
        .btn-submit:hover { background: #059669; }
        
        .btn-cancel {
            display: block; text-align: center; margin-top: 15px;
            color: #6b7280; text-decoration: none; font-size: 14px;
        }
        .btn-cancel:hover { color: #111827; }
        .error-msg { color: #ef4444; background: #fef2f2; padding: 10px; border-radius: 6px; font-size: 13px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="form-card">
        <h3>✨ Tambah Karyawan Baru</h3>
        
        <?php if(isset($error)) echo "<div class='error-msg'>$error</div>"; ?>
        
        <form method="POST">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" placeholder="Nama Karyawan" required>
            
            <label>Jabatan</label>
            <input type="text" name="jabatan" placeholder="Cth: Staff IT" required>
            
            <label>Divisi</label>
            <input type="text" name="divisi" placeholder="Cth: Teknis" required>
            
            <label>Email (Untuk Login)</label>
            <input type="email" name="email" placeholder="email@kantor.com" required>
            
            <label>Password Awal</label>
            <input type="text" name="password" placeholder="Password rahasia" required>
            
            <button type="submit" class="btn-submit">Simpan Data Karyawan</button>
            <a href="index.php" class="btn-cancel">Batal</a>
        </form>
    </div>
</body>
</html>