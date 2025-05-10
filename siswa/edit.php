<?php
require_once('../config/database.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID siswa tidak ditemukan.");
}

$error = '';
$success = '';

$stmt = $pdo->prepare("SELECT * FROM siswa WHERE id = ?");
$stmt->execute([$id]);
$siswa = $stmt->fetch();

if (!$siswa) {
    die("Data siswa tidak ditemukan.");
}

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
        $foto = $siswa['foto']; 

        if (!empty($_FILES['foto']['name'])) {
            $target_dir = "../uploads/";
            if (!is_dir($target_dir)) mkdir($target_dir);
            $foto = time() . '_' . basename($_FILES['foto']['name']);
            $target_file = $target_dir . $foto;
            move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);
        }

        $stmt = $pdo->prepare("UPDATE siswa SET nama_depan=?, nama_belakang=?, no_hp=?, nis=?, alamat=?, jenis_kelamin=?, foto=? WHERE id=?");
        $stmt->execute([$nama_depan, $nama_belakang, $no_hp, $nis, $alamat, $jenis_kelamin, $foto, $id]);

        $success = "Data siswa berhasil diperbarui!";
        
        $stmt = $pdo->prepare("SELECT * FROM siswa WHERE id = ?");
        $stmt->execute([$id]);
        $siswa = $stmt->fetch();
    }
}
?>

<h2>Edit Siswa</h2>
<?php if ($error): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
<?php if ($success): ?>
    <p style="color: green;"><?= htmlspecialchars($success) ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Nama Depan:</label><br>
    <input type="text" name="nama_depan" value="<?= htmlspecialchars($siswa['nama_depan']) ?>"><br><br>

    <label>Nama Belakang:</label><br>
    <input type="text" name="nama_belakang" value="<?= htmlspecialchars($siswa['nama_belakang']) ?>"><br><br>

    <label>Nomor HP:</label><br>
    <input type="text" name="no_hp" value="<?= htmlspecialchars($siswa['no_hp']) ?>"><br><br>

    <label>NIS (Nomor Induk Siswa):</label><br>
    <input type="text" name="nis" value="<?= htmlspecialchars($siswa['nis']) ?>"><br><br>

    <label>Alamat:</label><br>
    <textarea name="alamat" rows="3" cols="30"><?= htmlspecialchars($siswa['alamat']) ?></textarea><br><br>

    <label>Jenis Kelamin:</label><br>
    <select name="jenis_kelamin">
        <option value="Laki-laki" <?= $siswa['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
        <option value="Perempuan" <?= $siswa['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
    </select><br><br>

    <label>Foto Saat Ini:</label><br>
    <?php if (!empty($siswa['foto'])): ?>
        <img src="../uploads/<?= htmlspecialchars($siswa['foto']) ?>" alt="Foto" width="100"><br>
    <?php else: ?>
        Tidak ada foto
    <?php endif; ?>
    <br>
    <label>Ganti Foto (opsional):</label><br>
    <input type="file" name="foto" accept="image/*"><br><br>

    <button type="submit">Simpan Perubahan</button>
</form>

<br>
<a href="siswa.php">← Kembali ke daftar siswa</a>
