<?php
require_once('config/database.php');
session_start();


$siswa_list = $pdo->query("SELECT * FROM siswa")->fetchAll();


$id_siswa = $_GET['id'] ?? null;
$siswa = null;
$ekskul = [];
$ekskul_diikuti = [];

if ($id_siswa) {
    $stmt = $pdo->prepare("SELECT * FROM siswa WHERE id = ?");
    $stmt->execute([$id_siswa]);
    $siswa = $stmt->fetch();

    $ekskul = $pdo->query("SELECT * FROM eskul")->fetchAll();

    $stmt = $pdo->prepare("SELECT * FROM siswa_eskul WHERE siswa_id = ?");
    $stmt->execute([$id_siswa]);
    $ekskul_diikuti = $stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_UNIQUE);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Ekstrakurikuler Siswa</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            display: flex;
            gap: 20px;
            padding: 20px;
        }
        .siswa-list {
            width: 30%;
            border-right: 1px solid #ccc;
            padding-right: 20px;
        }
        .siswa-item {
            margin-bottom: 10px;
        }
        .form-ekskul {
            width: 70%;
        }
        .ekskul-item {
            margin-bottom: 10px;
        }
        input[type="number"] {
            width: 100px;
        }
    </style>
</head>
<body>

<h2>Manajemen Ekstrakurikuler</h2>

<div class="container">
    <div class="siswa-list">
        <h3>Daftar Siswa</h3>
        <?php foreach ($siswa_list as $s): ?>
            <div class="siswa-item">
                <a href="?id=<?= $s['id'] ?>">
                    <?= htmlspecialchars($s['nama_depan'] . ' ' . $s['nama_belakang']) ?>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="form-ekskul">
        <?php if ($siswa): ?>
            <h3>Kelola Ekskul: <?= htmlspecialchars($siswa['nama_depan'] . ' ' . $siswa['nama_belakang']) ?></h3>

            <form method="POST" action="simpan_ekskul.php">
                <input type="hidden" name="siswa_id" value="<?= $id_siswa ?>">

                <?php foreach ($ekskul as $e): 
                    $id_eks = $e['id'];
                    $sudah_diikuti = isset($ekskul_diikuti[$id_eks]);
                    $tahun = $sudah_diikuti ? $ekskul_diikuti[$id_eks]['tahun_mulai'] : '';
                ?>
                    <div class="ekskul-item">
                        <label>
                            <input type="checkbox" name="ekskul_ids[]" value="<?= $id_eks ?>" <?= $sudah_diikuti ? 'checked' : '' ?>>
                            <?= htmlspecialchars($e['nama_ekstrakulikuler']) ?>
                        </label>
                        <input type="number" name="tahun_mulai[<?= $id_eks ?>]" value="<?= $tahun ?>" placeholder="Tahun mulai" min="2000" max="<?= date('Y') ?>">
                    </div>
                <?php endforeach; ?>

                <br>
                <button type="submit">Simpan</button>
            </form>
        <?php else: ?>
            <p><strong>Pilih siswa terlebih dahulu untuk mengatur ekstrakurikulernya.</strong></p>
        <?php endif; ?>
    </div>
</div>
<a href="home.php">Kembali</a>
</body>
</html>
