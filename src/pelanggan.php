<?php
session_start();
require 'db.php';

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

// 1. PROSES TAMBAH PELANGGAN
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_pel = $_POST['nama_pelanggan'];
    $alamat = $_POST['alamat'];
    $paket = $_POST['paket'];
    $status = $_POST['status'];

    $conn->query("INSERT INTO pelanggan (nama_pelanggan, alamat, paket_internet, status) VALUES ('$nama_pel', '$alamat', '$paket', '$status')");
    
    header("Location: pelanggan.php");
    exit;
}

// 2. AMBIL DATA PELANGGAN
$result = $conn->query("SELECT * FROM pelanggan ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pelanggan | ISP</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');
        
        body { font-family: 'Inter', sans-serif; background: #f3f4f6; padding: 20px; color: #1f2937; }
        .container { max-width: 1100px; margin: 0 auto; }
        
        /* Navbar Simple */
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .btn-back { text-decoration: none; color: #4b5563; font-weight: 600; display: flex; align-items: center; gap: 5px; transition: 0.2s; }
        .btn-back:hover { color: #111827; }
        
        .card { background: white; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 30px; }
        .card-body { padding: 25px; }
        .card-header { background: #fff; padding: 20px 25px; border-bottom: 1px solid #f3f4f6; }
        .card-header h2 { margin: 0; font-size: 20px; color: #111827; }

        /* Form Styling */
        .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end; }
        .input-group { display: flex; flex-direction: column; gap: 6px; }
        .input-group label { font-size: 13px; font-weight: 500; color: #4b5563; }
        input, select { padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-family: inherit; width: 100%; box-sizing: border-box; }
        input:focus, select:focus { outline: none; border-color: #3b82f6; ring: 2px solid #93c5fd; }
        
        .btn-save { background: #2563eb; color: white; border: none; padding: 11px 20px; border-radius: 6px; font-weight: 600; cursor: pointer; transition: 0.2s; height: 42px; }
        .btn-save:hover { background: #1d4ed8; }

        /* Table Styling */
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 14px 20px; text-align: left; border-bottom: 1px solid #f3f4f6; }
        th { background: #f9fafb; color: #6b7280; font-size: 12px; text-transform: uppercase; font-weight: 600; letter-spacing: 0.05em; }
        tr:hover { background: #f9fafb; }

        /* Status Badges */
        .badge { padding: 4px 12px; border-radius: 99px; font-size: 12px; font-weight: 600; display: inline-block; }
        .bg-green { background-color: #dcfce7; color: #166534; } 
        .bg-red { background-color: #fee2e2; color: #991b1b; }   
        .bg-blue { background-color: #dbeafe; color: #1e40af; }  
    </style>
</head>
<body>

    <div class="container">
        <div class="top-bar">
            <a href="index.php" class="btn-back">← Kembali ke Dashboard</a>
            <h3 style="margin:0; color:#374151;">Manajemen Pelanggan</h3>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Tambah Pelanggan Baru</h2>
            </div>
            <div class="card-body">
                <form method="POST" class="form-grid">
                    <div class="input-group">
                        <label>Nama Pelanggan</label>
                        <input type="text" name="nama_pelanggan" placeholder="Cth: Budi Santoso" required>
                    </div>
                    <div class="input-group">
                        <label>Alamat</label>
                        <input type="text" name="alamat" placeholder="Cth: Jl. Mawar No. 12" required>
                    </div>
                    <div class="input-group">
                        <label>Paket Internet</label>
                        <input type="text" name="paket" placeholder="Cth: 20 Mbps Home" required>
                    </div>
                    <div class="input-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="Akan Berlangganan">Akan Berlangganan</option>
                            <option value="Masih Berlangganan">Masih Berlangganan</option>
                            <option value="Selesai Berlangganan">Selesai Berlangganan</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-save">+ Simpan Data</button>
                </form>
            </div>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Pelanggan</th>
                        <th>Alamat Pemasangan</th>
                        <th>Paket</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    while($row = $result->fetch_assoc()): 
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><strong><?= htmlspecialchars($row['nama_pelanggan']); ?></strong></td>
                        <td><?= htmlspecialchars($row['alamat']); ?></td>
                        <td><?= htmlspecialchars($row['paket_internet']); ?></td>
                        <td>
                            <?php 
                                if($row['status'] == 'Masih Berlangganan') {
                                    echo "<span class='badge bg-green'>● Aktif</span>";
                                } elseif($row['status'] == 'Selesai Berlangganan') {
                                    echo "<span class='badge bg-red'>● Non-Aktif</span>";
                                } else {
                                    echo "<span class='badge bg-blue'>● Proses</span>";
                                }
                            ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>