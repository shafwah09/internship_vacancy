<?php
// Koneksi ke database
include 'config.php';
session_start();

// Pastikan hanya admin yang bisa mengakses halaman ini
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Ambil semua lowongan yang statusnya pending
$query = "SELECT * FROM internship_vacancy WHERE status = 'pending'";
$result = mysqli_query($conn, $query);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Admin</title>
<style>
    body {
      font-family: Arial, sans-serif;
      background-color: #ADD8E6;
    }
</style>
</head>
<body>
<div class="admin-container">
<h1>Selamat Datang, Admin!</h1>
<form>
<table>
    <tr>
        <th>Judul Lowongan</th>
        <th>Nama perusahaan</th>
        <th>id perusahaan</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
    <?php while ($internship_vacancy = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?= $internship_vacancy['title']; ?></td>
            <td><?= $internship_vacancy['company_name']; ?></td>
            <td><?= $internship_vacancy['company_id']; ?></td>
            <td><?= ucfirst($job['status']); ?></td>
            <td>
                <a href="approve_job.php?id=<?= $internship_vacancy['id']; ?>">Approve</a> |
                <a href="reject_job.php?id=<?= $internship_vacancy['id']; ?>">Reject</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
<a href="logout.php">Logout</a>
</form>
</div>
</body>
</html>
