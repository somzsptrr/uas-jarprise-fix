<?php
session_start();
require 'db.php';

// Cek status login
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

// Ambil data karyawan untuk ditampilkan di tabel utama
$result = $conn->query("SELECT * FROM karyawan ORDER BY id ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard ISP</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; padding: 20px; background: #f4f4f4; }
        .header { 
            background: white; 
            padding: 20px; 
            border-radius: 8px; 
            margin-bottom: 20px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background: #2a5298; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        
        /* Tombol-tombol */
        .btn { text-decoration: none; padding: 10px 15px; border-radius: 4px; color: white; font-weight: bold; font-size: 14px; }
        .btn-pelanggan { background: #8e44ad; } /* Ungu */
        .btn-add { background: #27ae60; } /* Hijau */
        .btn-logout { background: #c0392b; } /* Merah */
        
        .btn:hover { opacity: 0.9; }
        .menu-group { display: flex; gap: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <div>
            <h2 style="margin:0;">Halo, <?php echo $_SESSION['nama']; ?>!</h2>
            <small>Role: <?php echo ucfirst($_SESSION['role']); ?></small>
        </div>
        
        <div class="menu-group">
            <a href="pelanggan.php" class="btn btn-pelanggan">📡 Data Pelanggan</a>

            <?php if($_SESSION['role'] == 'admin'): ?>
                <a href="tambah_karyawan.php" class="btn btn-add">+ Karyawan</a>
            <?php endif; ?>

            <a href="logout.php" class="btn btn-logout">Logout</a>
        </div>
    </div>

    <h3>Daftar Karyawan Internal</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Divisi</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama']; ?></td>
                <td><?= $row['jabatan']; ?></td>
                <td><?= $row['divisi']; ?></td>
                <td><?= $row['email']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>