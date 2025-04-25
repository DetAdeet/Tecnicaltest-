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

    $nama_ekstrakulikuler = $_POST['nama_ekstrakulikuler'] ?? '';
    $nama_penannggungjawab_ekstrakulikuler = $_POST['nama_penanggungjawab_ekstrakulikuler'] ?? '';
    $status_ekstrakulikuler = $_POST['status_ekstrakulikuler'] ?? '';

    if (!$nama_ekstrakulikuler || !$nama_penannggungjawab_ekstrakulikuler) {
        $error = "Semua kolom dan wajib diisi.";
    } else {
        $foto = '';
        if (!empty($_FILES['foto']['name'])) {
            $target_dir = "../uploads/";
            if (!is_dir($target_dir)) mkdir($target_dir);
            $foto = time() . '_' . basename($_FILES['foto']['name']);
            $target_file = $target_dir . $foto;
            move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);
        }

        // Perbaikan query dan eksekusi
        $stmt = $pdo->prepare("INSERT INTO eskul (nama_ekstrakulikuler, nama_penannggungjawab_ekstrakulikuler, status_ekstrakulikuler, foto) VALUES (?, ?, ?, ?)");
       $stmt->execute([$nama_ekstrakulikuler, $nama_penannggungjawab_ekstrakulikuler, $status_ekstrakulikuler, $foto]);

        $success = "Data ekstrakulikuler berhasil diperbarui!";
    }
}

?>

<h2>Tambah Ekskul</h2>
<?php if ($error): ?>
    <p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
<?php if ($success): ?>
    <p style="color: green;"><?= htmlspecialchars($success) ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Nama :</label><br>
    <input type="text" name="nama_ekstrakulikuler"><br><br>

    <label>Nama Penanggung Jawab:</label><br>
    <input type="text" name="nama_penanggungjawab_ekstrakulikuler"><br><br>

    <label>Status Ekstrakulikuler:</label><br>
    <select name="status_ekstrakulikuler">
        <option value="Aktif">Aktif</option>
        <option value="Tidak Aktif">Tidak Aktif</option>
    </select><br><br>

    <label>Foto:</label><br>
    <input type="file" name="foto" accept="image/*"><br><br>

    <button type="submit">Simpan</button>
</form>

<br>
<a href="read.php">← Kembali ke daftar Ekskul</a>
