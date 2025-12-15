<?php
session_start();
require 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die("Akses Ditolak!");
}

$id = $_GET['id'];
$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; // Plain Text
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $divisi = $_POST['divisi'];
    $email = $_POST['email'];
    $id_karyawan = $_POST['id'];

    // Update Query: Sertakan username & password
    $stmt = $conn->prepare("UPDATE karyawan SET username=?, password=?, nama=?, jabatan=?, divisi=?, email=? WHERE id=?");
    $stmt->bind_param("ssssssi", $username, $password, $nama, $jabatan, $divisi, $email, $id_karyawan);
    
    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        $msg = "Gagal update.";
    }
}

$stmt = $conn->prepare("SELECT * FROM karyawan WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Karyawan | Raya Corp</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
        
        body { font-family: 'Inter', sans-serif; background: #f3f4f6; padding: 40px; display: flex; justify-content: center; }
        .form-card { 
            background: white; width: 100%; max-width: 500px; 
            padding: 40px; border-radius: 12px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.08); 
        }
        h2 { margin-top: 0; color: #111827; text-align: center; border-bottom: 1px solid #eee; padding-bottom: 20px; margin-bottom: 25px; }
        
        .section-title { font-size: 12px; text-transform: uppercase; color: #6b7280; font-weight: 700; margin-top: 20px; letter-spacing: 0.05em; }
        
        label { display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 5px; margin-top: 12px; }
        input { 
            width: 100%; padding: 10px 12px; 
            border: 1px solid #d1d5db; border-radius: 6px; 
            box-sizing: border-box; font-size: 14px; 
        }
        input:focus { border-color: #f59e0b; outline: none; box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1); }
        
        .btn-save { 
            width: 100%; margin-top: 30px; padding: 12px; 
            background: #f59e0b; color: white; border: none; 
            border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.2s;
        }
        .btn-save:hover { background: #d97706; }
        .btn-cancel { display: block; text-align: center; margin-top: 15px; color: #6b7280; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>
    <div class="form-card">
        <h2>✏️ Edit Data Karyawan</h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
            
            <div class="section-title">Informasi Akun</div>
            <label>Username</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($data['username']); ?>" required>
            
            <label>Password (Teks Biasa)</label>
            <input type="text" name="password" value="<?php echo htmlspecialchars($data['password']); ?>" required>
            
            <div class="section-title" style="margin-top:25px;">Data Pribadi</div>
            <label>Nama Lengkap</label>
            <input type="text" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required>
            
            <label>Jabatan</label>
            <input type="text" name="jabatan" value="<?php echo htmlspecialchars($data['jabatan']); ?>" required>
            
            <label>Divisi</label>
            <input type="text" name="divisi" value="<?php echo htmlspecialchars($data['divisi']); ?>" required>
            
            <label>Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($data['email']); ?>" required>
            
            <button type="submit" class="btn-save">Simpan Perubahan</button>
            <a href="index.php" class="btn-cancel">Batal</a>
        </form>
    </div>
</body>
</html>