<?php
session_start();
require 'db.php';

if (isset($_SESSION['role'])) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 1. CEK KE TABEL ADMIN
    $q_admin = $conn->query("SELECT * FROM admin WHERE email='$email' AND password='$password'");
    
    // 2. CEK KE TABEL KARYAWAN
    $q_karyawan = $conn->query("SELECT * FROM karyawan WHERE email='$email' AND password='$password'");

    // LOGIKA LOGIN
    if ($q_admin->num_rows > 0) {
        $data = $q_admin->fetch_assoc();
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['role'] = 'admin'; // Role admin
        header("Location: index.php");
        exit;
    } 
    elseif ($q_karyawan->num_rows > 0) {
        $data = $q_karyawan->fetch_assoc();
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['role'] = 'employee'; // Role karyawan
        header("Location: index.php");
        exit;
    } 
    else {
        $error = "Email atau Password Salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Raya Corp</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .box {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 360px;
            text-align: center;
        }
        .brand {
            font-size: 24px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 8px;
        }
        .subtitle {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 24px;
        }
        .form-group {
            margin-bottom: 16px;
            text-align: left;
        }
        input {
            width: 100%;
            padding: 12px 16px;
            margin-top: 5px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
            transition: all 0.3s;
            outline: none;
        }
        input:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        button {
            width: 100%;
            padding: 12px;
            background: #4f46e5;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 10px;
        }
        button:hover {
            background: #4338ca;
        }
        .alert {
            background-color: #fef2f2;
            color: #ef4444;
            padding: 10px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 20px;
            border: 1px solid #fee2e2;
        }
    </style>
</head>
<body>
    <div class="box">
        <div class="brand">Raya Corp</div>
        <div class="subtitle">Silakan login untuk melanjutkan</div>
        
        <?php if($error) echo "<div class='alert'>⚠️ $error</div>"; ?>
        
        <form method="post">
            <div class="form-group">
                <input type="email" name="email" placeholder="contoh@email.com" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit">MASUK SEKARANG</button>
        </form>
    </div>
</body>
</html>