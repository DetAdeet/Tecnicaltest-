<?php
require_once('../config/database.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("SELECT foto FROM siswa WHERE id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch();

    if ($data && !empty($data['foto'])) {
        $filePath = "../uploads/" . $data['foto'];
        if (file_exists($filePath)) {
            unlink($filePath); 
        }
    }

    $stmt = $pdo->prepare("DELETE FROM siswa WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: siswa.php?success=1");
    exit;
} else {
    echo "ID tidak ditemukan.";
}
