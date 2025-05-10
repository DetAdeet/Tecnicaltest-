<?php
require_once('../config/database.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$error = '';
$success = '';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "ID tidak ditemukan!";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM eskul WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch();

if (!$data) {
    echo "Data tidak ditemukan!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_ekstrakulikuler'] ?? '';
    $penanggung_jawab = $_POST['nama_penannggungjawab_ekstrakulikuler'] ?? '';
    $status = $_POST['status_ekstrakulikuler'] ?? '';
    $foto = $data['foto']; 

    if (!$nama || !$penanggung_jawab) {
        $error = "Nama dan Penanggung Jawab wajib diisi.";
    } else {
        if (!empty($_FILES['foto']['name'])) {
            $target_dir = "../uploads/";
            if (!is_dir($target_dir)) mkdir($target_dir);
            $foto = time() . '_' . basename($_FILES['foto']['name']);
            $target_file = $target_dir . $foto;
            move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);
        }

        $stmt = $pdo->prepare("UPDATE eskul SET nama_ekstrakulikuler = ?, nama_penannggungjawab_ekstrakulikuler = ?, status_ekstrakulikuler = ?, foto = ? WHERE id = ?");
        $stmt->execute([$nama, $penanggung_jawab, $status, $foto, $id]);

        $success = "Data berhasil diperbarui!";
        header("Location: read.php");
        exit;
    }
}
?>

<h2>Edit Data Ekstrakurikuler</h2>

<?php if ($error): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Nama Ekstrakurikuler:</label><br>
    <input type="text" name="nama_ekstrakulikuler" value="<?= htmlspecialchars($data['nama_ekstrakulikuler']) ?>"><br><br>

    <label>Nama Penanggung Jawab:</label><br>
    <input type="text" name="nama_penannggungjawab_ekstrakulikuler" value="<?= htmlspecialchars($data['nama_penannggungjawab_ekstrakulikuler']) ?>"><br><br>

    <label>Status:</label><br>
    <select name="status_ekstrakulikuler">
        <option value="Aktif" <?= $data['status_ekstrakulikuler'] === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
        <option value="Tidak Aktif" <?= $data['status_ekstrakulikuler'] === 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
    </select><br><br>

    <label>Foto Saat Ini:</label><br>
    <?php if ($data['foto']): ?>
        <img src="../uploads/<?= htmlspecialchars($data['foto']) ?>" width="120"><br>
    <?php else: ?>
        <p>(Tidak ada foto)</p>
    <?php endif; ?>

    <label>Ganti Foto (opsional):</label><br>
    <input type="file" name="foto" accept="image/*"><br><br>

    <button type="submit">Simpan Perubahan</button>
</form>

<br>
<a href="read.php">← Kembali ke daftar Ekskul</a>
