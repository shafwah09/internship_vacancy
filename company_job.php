<?php
// Koneksi ke database
include 'config.php';
session_start();

// Pastikan hanya perusahaan yang bisa mengakses halaman ini
if ($_SESSION['role'] != 'perusahaan') {
    header("Location: login.php");
    exit();
}

$company_id = $_SESSION['user_id']; // Ambil ID perusahaan dari session

// Ambil data profil perusahaan
$query = "SELECT * FROM users WHERE id = '$company_id' AND role = 'perusahaan'";
$result = mysqli_query($conn, $query);
$company = mysqli_fetch_assoc($result);

// Ambil daftar lowongan pekerjaan perusahaan
$query_internship_vacancy = "SELECT * FROM internship_vacancy WHERE company_id = '$company_id'";
$result_internship_vacancy= mysqli_query($conn, $query_internship_vacancy);

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Perusahaan</title>
<style>
    body {
      font-family: Arial, sans-serif;
      background-color: #E6F0FA;
    }
</style>
</head>
<body>
<div class="company-container"></div>
<h1>Profil Perusahaan</h1>
<form>
<p>Username: <?= $company['username']; ?></p>
<p>Email: <?= $company['email']; ?></p>

<h2>Daftar Lowongan Pekerjaan</h2>
<table>
    <tr>
        <th>Judul Lowongan</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
    <?php while ($internship_vacancy = mysqli_fetch_assoc($result_internship_vacancy)) : ?>
        <tr>
            <td><?= $internship_vacancy['title']; ?></td>
            <td><?= ucfirst($internship_vacancy['status']); ?></td>
            <td>
                <a href="edit_job.php?id=<?= $internship_vacancy['id']; ?>">Edit</a> |
                <a href="delete_job.php?id=<?= $internship_vacancy['id']; ?>">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
</form>
<a href="company.php">Kembali ke Dashboard</a>
</body>
</html>

