<?php
// Koneksi ke database
include 'config.php';
session_start();

// Pastikan hanya perusahaan yang bisa mengakses
if ($_SESSION['role'] != 'perusahaan') {
    header("Location: login.php");
    exit();
}

$company_id = $_SESSION['user_id']; // ID perusahaan
$internship_vacancy_id = $_GET['id']; // ID lowongan yang ingin diedit

// Ambil data lowongan
$query = "SELECT * FROM internship_vacancy WHERE id = '$internship_vacancy_id' AND company_id = '$company_id'";
$result = mysqli_query($conn, $query);
$internship_vacancy = mysqli_fetch_assoc($result);

if (!$internship_vacancy) {
    echo "Lowongan tidak ditemukan atau Anda tidak memiliki akses ke lowongan ini.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $company_name = $_POST['company_name'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    

    // Update data lowongan
    $query = "UPDATE internship_vacancy SET title = '$title', company_name = '$company_name', description = '$description', location = '$location'  WHERE id = '$internship_vacancy_id'";
    
    if (mysqli_query($conn, $query)) {
        echo "Lowongan berhasil diperbarui!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

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
<h1>Edit Lowongan</h1>
<form action="edit_job.php?id=<?= $job_id; ?>" method="POST">
    <label>Judul Lowongan:</label><br>
    <input type="text" name="title" value="<?= $job['title']; ?>" required><br><br>
    
    <label>Nama Perusahaan:</label><br>
    <textarea name="company_name" required><?= $job['company_name']; ?></textarea><br><br>

    <label>Deskripsi Lowongan:</label><br>
    <textarea name="description" required><?= $job['description']; ?></textarea><br><br>

    <label>Lokasi Lowongan:</label><br>
    <textarea name="location" required><?= $job['location']; ?></textarea><br><br>
    
    <button type="submit">Update Lowongan</button>
</form>
<div><a href="company.php">Kembali ke Dashboard</a></div>
</body>
</html>