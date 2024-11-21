<?php
// Koneksi ke database
include 'config.php';
session_start();

// Pastikan hanya perusahaan yang bisa mengakses
if ($_SESSION['role'] != 'perusahaan') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $company_id = $_SESSION['user_id']; // ID perusahaan
    $company_name = $_POST['company_name'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];

    // Masukkan lowongan baru ke database
    $query = "INSERT INTO internship_vacancy (company_id, company_name, title, description, location, status) 
              VALUES ('$company_id', '$company_name', '$title', '$description', '$location', 'pending')";

    if (mysqli_query($conn, $query)) {
        echo "Lowongan berhasil diposting dan menunggu validasi admin.";
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
<div class="company-container">
<h2>Post Lowongan Baru</h2>
<form action="post_job.php" method="POST">
    <label>Judul Lowongan:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Nama Perusahaan:</label><br>
    <input type="text" name="company_name" required><br><br>
    
    <label>Deskripsi Lowongan:</label><br>
    <textarea name="description" required></textarea><br><br>

    <label>Lokasi :</label><br>
    <textarea name="location" required></textarea><br><br>
    
    <button type="submit">Post Lowongan</button>
</form>
<a href="company.php">Kembali ke Dashboard</a>
</div>
</body>
</html>



