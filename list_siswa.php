<?php
require_once('config/database.php');

$stmt = $pdo->query("
    SELECT 
        s.id AS siswa_id,
        s.nama_depan,
        s.nama_belakang,
        e.nama_ekstrakulikuler,
        se.tahun_mulai
    FROM siswa s
    LEFT JOIN siswa_eskul se ON s.id = se.siswa_id
    LEFT JOIN eskul e ON se.eskul_id = e.id
    ORDER BY s.id
");

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);


$siswa_ekskul = [];
foreach ($data as $row) {
    $id = $row['siswa_id'];
    $nama = $row['nama_depan'] . ' ' . $row['nama_belakang'];
    if (!isset($siswa_ekskul[$id])) {
        $siswa_ekskul[$id] = [
            'nama' => $nama,
            'ekskul' => []
        ];
    }
    if ($row['nama_ekstrakulikuler']) {
        $siswa_ekskul[$id]['ekskul'][] = $row['nama_ekstrakulikuler'] . ' (' . $row['tahun_mulai'] . ')';
    }
}
?>


<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f7f9fc;
    margin: 0;
    padding: 20px;
}

h2 {
    color: #333;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    background-color: #fff;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

th, td {
    padding: 12px 16px;
    border: 1px solid #ddd;
    text-align: left;
}

th {
    background-color: #007bff;
    color: white;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #eaf3ff;
}

a.button {
    display: inline-block;
    padding: 8px 16px;
    background-color: #28a745;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    margin-top: 10px;
}

a.button:hover {
    background-color: #218838;
}
a href {
    float: right;
    width: 300px;
    border: 3px solid #73AD21;
    padding: 10px;
}

</style>
<h2>Daftar Siswa & Ekstrakurikuler</h2>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Ekstrakurikuler yang Diikuti</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1;
        foreach ($siswa_ekskul as $siswa): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($siswa['nama']) ?></td>
                <td><?= htmlspecialchars(implode(', ', $siswa['ekskul']) ?: '-') ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a href="home.php">Kembali</a>