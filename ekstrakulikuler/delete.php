<?php
require_once('../config/database.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("SELECT foto FROM eskul WHERE id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch();

    if ($data) {
        if (!empty($data['foto'])) {
            $filePath = "../uploads/" . $data['foto'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $stmt = $pdo->prepare("DELETE FROM eskul WHERE id = ?");
        $stmt->execute([$id]);
    }
}

header("Location: read.php");
exit;
