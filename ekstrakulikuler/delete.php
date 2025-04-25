<?php
require_once('../config/database.php');
session_start();

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Ambil ID dari URL
$id = $_GET['id'] ?? null;

if ($id) {
    // Ambil data dulu untuk cek apakah ada file foto yang harus dihapus
    $stmt = $pdo->prepare("SELECT foto FROM eskul WHERE id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch();

    if ($data) {
        // Hapus file foto jika ada
        if (!empty($data['foto'])) {
            $filePath = "../uploads/" . $data['foto'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Hapus data dari database
        $stmt = $pdo->prepare("DELETE FROM eskul WHERE id = ?");
        $stmt->execute([$id]);
    }
}

header("Location: read.php");
exit;
