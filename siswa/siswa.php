<?php
require_once('../config/database.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM siswa ORDER BY id DESC");
$siswa_list = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Siswa</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;        
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }
        img {
            max-width: 80px;
            height: auto;
        }
        /* style.css */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    background-color: #f4f6f9;
    color: #333;
    line-height: 1.6;
    min-height: 100vh;
    padding: 20px;
}

.container {
    max-width: 1000px;
    margin: auto;
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}

h1, h2, h3 {
    margin-bottom: 20px;
    color: #2c3e50;
}

a {
    text-decoration: none;
    color: #3498db;
}

a:hover {
    text-decoration: underline;
}

form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

input[type="text"],
input[type="number"],
input[type="email"],
input[type="password"],
select,
textarea {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    width: 100%;
}

input[type="file"] {
    margin-top: 5px;
}

button {
    background-color: #3498db;
    color: #fff;
    padding: 12px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
}

button:hover {
    background-color: #2980b9;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.table th,
.table td {
    padding: 12px 15px;
    border: 1px solid #ccc;
    text-align: left;
}

.table th {
    background-color: #2c3e50;
    color: #fff;
}
th {
    background-color: #007bff;
    color: white;
}

.alert {
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 15px;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
}

.alert-error {
    background-color: #f8d7da;
    color: #721c24;
}

/* Sidebar dashboard */
.sidebar {
    width: 250px;
    height: 100vh;
    background-color: #2c3e50;
    position: fixed;
    left: 0;
    top: 0;
    padding: 20px;
    color: #ecf0f1;
}

.sidebar h2 {
    margin-bottom: 30px;
    font-size: 24px;
}

.sidebar a {
    display: block;
    color: #ecf0f1;
    padding: 12px;
    border-radius: 5px;
    margin-bottom: 10px;
}

.sidebar a:hover {
    background-color: #34495e;
}

/* Main content with sidebar */
.main-content {
    margin-left: 270px;
    padding: 30px;
}

    </style>
</head>
<body>
    <h2>Daftar Siswa</h2>
    <a href="tambah.php">+ Tambah Siswa</a>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nama Lengkap</th>
                <th>No HP</th>
                <th>NIS</th>
                <th>Alamat</th>
                <th>Jenis Kelamin</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($siswa_list) > 0): ?>
                <?php foreach ($siswa_list as $index => $siswa): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td>
                            <?php if (!empty($siswa['foto'])): ?>
                                <img src="../uploads/<?= htmlspecialchars($siswa['foto']) ?>" alt="Foto Siswa">
                            <?php else: ?>
                                Tidak Ada Foto
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($siswa['nama_depan']) . ' ' . htmlspecialchars($siswa['nama_belakang']) ?></td>
                        <td><?= htmlspecialchars($siswa['no_hp']) ?></td>
                        <td><?= htmlspecialchars($siswa['nis']) ?></td>
                        <td><?= htmlspecialchars($siswa['alamat']) ?></td>
                        <td><?= htmlspecialchars($siswa['jenis_kelamin']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $siswa['id'] ?>">Edit</a> |
                            <a href="hapus.php?id=<?= $siswa['id'] ?>" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
                            

                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Belum ada data siswa.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="../home.php">Kembali</a>
</body>
</html>
