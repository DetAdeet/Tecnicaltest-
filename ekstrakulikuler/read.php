<?php
require_once('../config/database.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM eskul ORDER BY id DESC");
$ekskul_list = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Ekstrakulikuler</title>
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
        /* Umum */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background: #f4f6f8;
    color: #333;
}

.container {
    width: 90%;
    max-width: 1000px;
    margin: 30px auto;
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

h1, h2, h3 {
    color: #2c3e50;
}

a {
    color: #3498db;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

/* Form */
form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

input[type="text"],
input[type="password"],
input[type="number"],
select,
textarea {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    width: 100%;
    box-sizing: border-box;
}

button {
    background: #3498db;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
    transition: background 0.3s;
}

button:hover {
    background: #2980b9;
}

/* Tabel */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    text-align: left;
}

th {
    background-color: #3498db;
    color: white;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

/* Login */
.login-container {
    max-width: 400px;
    margin: 100px auto;
    padding: 30px;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* Notifikasi */
.alert {
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
}

.alert.success {
    background-color: #d4edda;
    color: #155724;
}

.alert.error {
    background-color: #f8d7da;
    color: #721c24;
}

    </style>
</head>
<body>
    <h2>Daftar Ekstrakulikuler</h2>
    <a href="create.php">+ Tambah Ekskul</a>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nama Ekskul</th>
                <th>Nama Pembina</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($ekskul_list) > 0): ?>
                <?php foreach ($ekskul_list as $index => $ekskul): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td>
                            <?php if (!empty($ekskul['foto'])): ?>
                                <img src="../uploads/<?= htmlspecialchars($ekskul['foto']) ?>" alt="Foto Ekskul">
                            <?php else: ?>
                                Tidak Ada Foto
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($ekskul['nama_ekstrakulikuler']) ?></td>
                        <td><?= htmlspecialchars($ekskul['nama_penannggungjawab_ekstrakulikuler']) ?></td>
                        <td><?= htmlspecialchars($ekskul['status_ekstrakulikuler']) ?></td>
                        <td>
                            <a href="update.php?id=<?= $ekskul['id'] ?>">Edit</a> |
                            <a href="delete.php?id=<?= $ekskul['id'] ?>" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Belum ada data Ekskul.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="../home.php">Kembali</a>
</body>
</html>
