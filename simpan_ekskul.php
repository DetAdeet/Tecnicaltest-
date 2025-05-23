<?php
require_once('config/database.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $siswa_id = $_POST['siswa_id'] ?? null;
    $ekskul_ids = $_POST['ekskul_ids'] ?? [];
    $tahun_mulai = $_POST['tahun_mulai'] ?? [];

    $stmt = $pdo->prepare("DELETE FROM siswa_eskul WHERE siswa_id = ?");
    $stmt->execute([$siswa_id]);

    $stmt = $pdo->prepare("INSERT INTO siswa_eskul (siswa_id, eskul_id, tahun_mulai) VALUES (?, ?, ?)");

    foreach ($ekskul_ids as $eskul_id) {
        $tahun = $tahun_mulai[$eskul_id] ?? null;
        if ($tahun) {
            $stmt->execute([$siswa_id, $eskul_id, $tahun]);
        }
    }

    header("Location: manage_ekskul.php?id=" . $siswa_id);
    exit;
}
?>
