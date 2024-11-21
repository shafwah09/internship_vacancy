<?php
// Koneksi ke database
include 'config.php';
session_start();

// Pastikan hanya perusahaan yang bisa mengakses halaman ini
if ($_SESSION['role'] != 'perusahaan') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $company_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
   

    // Masukkan data profil ke database
    $query = "INSERT INTO company (company_id, name, email, phone, address) 
              VALUES ('$company_id', '$name', '$email', '$phone', '$address')";

    if (mysqli_query($conn, $query)) {
        echo "Profil berhasil dibuat!";
        header("Location: company.php");
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
<h1>Buat Profil Perusahaan</h1>
<form action="company_profile.php" method="POST"> 
    <label>Nama Perusahaan:</label><br>
    <input type="text" name="name" required><br><br>
    
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>
    
    <label>Phone:</label><br>
    <input type="text" name="phone" required><br><br>
    
    <label>Address:</label><br>
    <input type="text" name="address" required><br><br>
    
  
    <button type="submit">Buat Profil</button>
</form>
<a href="company.php">Kembali ke Dashboard</a>
</body>
</html>
