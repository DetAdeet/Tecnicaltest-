<?php
require_once('../config/database.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_depan = $_POST['nama_depan'] ?? '';
    $nama_belakang = $_POST['nama_belakang'] ?? '';
    $no_hp = $_POST['no_hp'] ?? '';
    $nis = $_POST['nis'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';

    if (!$nama_depan || !$nis) {
        $error = "Nama depan dan NIS wajib diisi.";
    } else {

        $foto = '';
        if (!empty($_FILES['foto']['name'])) {
            $target_dir = "../uploads/";
            if (!is_dir($target_dir)) mkdir($target_dir);
            $foto = time() . '_' . basename($_FILES['foto']['name']);
            $target_file = $target_dir . $foto;
            move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);
        }

        $stmt = $pdo->prepare("INSERT INTO siswa (nama_depan, nama_belakang, no_hp, nis, alamat, jenis_kelamin, foto) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nama_depan, $nama_belakang, $no_hp, $nis, $alamat, $jenis_kelamin, $foto]);

        $success = "Data siswa berhasil ditambahkan!";
    }
}
?>

<h2>Tambah Siswa</h2>
<?php if ($error): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
<?php if ($success): ?>
    <p style="color: green;"><?= htmlspecialchars($success) ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Nama Depan:</label><br>
    <input type="text" name="nama_depan"><br><br>

    <label>Nama Belakang:</label><br>
    <input type="text" name="nama_belakang"><br><br>

    <label>Nomor HP:</label><br>
    <input type="text" name="no_hp"><br><br>

    <label>NIS (Nomor Induk Siswa):</label><br>
    <input type="text" name="nis"><br><br>

    <label>Alamat:</label><br>
    <textarea name="alamat" rows="3" cols="30"></textarea><br><br>

    <label>Jenis Kelamin:</label><br>
    <select name="jenis_kelamin">
        <option value="Laki-laki">Laki-laki</option>
        <option value="Perempuan">Perempuan</option>
    </select><br><br>

    <label>Foto:</label><br>
    <input type="file" name="foto" accept="image/*"><br><br>

    <button type="submit">Simpan</button>
</form>

<br>
<a href="siswa.php">← Kembali ke daftar siswa</a>
