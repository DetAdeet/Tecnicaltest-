<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <style>
        h2{
            text-align: center;
            font-size: 35px;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f6f8;
            color: #333;
        }
    </style>
</head>
<body>
    <h2>Selamat datang, <?= $_SESSION['admin_nama'] ?>!</h2>
    <a href="../home.php">Lanjutkan</a><br>
    <a href="../admin/edit_profile.php">Edit Profile</a><br>
    <a href="../auth/logout.php">Logout</a>
</body>
</html>
