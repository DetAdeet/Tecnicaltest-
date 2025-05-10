<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$admin_id = $_SESSION['admin_id'];
$error = '';
$success = '';

$stmt = $pdo->prepare("SELECT * FROM admin WHERE id = ?");
$stmt->execute([$admin_id]);
$admin = $stmt->fetch();

if (!$admin) {
    die("Data admin tidak ditemukan!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_depan = $_POST['nama_depan'] ?? '';
    $nama_belakang = $_POST['nama_belakang'] ?? '';
    $email = $_POST['email'] ?? '';
    $tanggal_lahir = $_POST['tanggal_lahir'] ?? '';
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
    $password_baru = $_POST['password_baru'] ?? '';

    if ($nama_depan && $email) {
        if (!empty($password_baru)) {
            $hashed_password = password_hash($password_baru, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE admin SET nama_depan=?, nama_belakang=?, email=?, tanggal_lahir=?, jenis_kelamin=?, password=? WHERE id=?");
            $stmt->execute([$nama_depan, $nama_belakang, $email, $tanggal_lahir, $jenis_kelamin, $hashed_password, $admin_id]);
        } else {
            $stmt = $pdo->prepare("UPDATE admin SET nama_depan=?, nama_belakang=?, email=?, tanggal_lahir=?, jenis_kelamin=? WHERE id=?");
            $stmt->execute([$nama_depan, $nama_belakang, $email, $tanggal_lahir, $jenis_kelamin, $admin_id]);
        }
    
        $success = "Profil berhasil diperbarui!";
        $_SESSION['admin_nama'] = $nama_depan;
    } else {
        $error = "Nama depan dan email wajib diisi.";
    }
    
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profil Admin</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <h2>Edit Profil Admin</h2>
    <?php if ($error): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p style="color:green"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Nama Depan:</label><br>
        <input type="text" name="nama_depan" value="<?= htmlspecialchars($admin['nama_depan'] ?? '') ?>"><br><br>

        <label>Nama Belakang:</label><br>
        <input type="text" name="nama_belakang" value="<?= htmlspecialchars($admin['nama_belakang'] ?? '') ?>"><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($admin['email'] ?? '') ?>"><br><br>

        <label>Tanggal Lahir:</label><br>
        <input type="date" name="tanggal_lahir" value="<?= htmlspecialchars($admin['tanggal_lahir'] ?? '') ?>"><br><br>

        <label>Jenis Kelamin:</label><br>
        <select name="jenis_kelamin">
        <option value="Laki-laki" <?= ($admin['jenis_kelamin'] ?? '') == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
        <option value="Perempuan" <?= ($admin['jenis_kelamin'] ?? '') == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
        </select><br><br>

        <label>Ganti Password</label><br>
        <input type="password" name="password_baru"><br><br>

        <button type="submit">Simpan</button>
    </form>

    <br>
    <a href="../home.php">← Kembali</a>
</body>
</html>
