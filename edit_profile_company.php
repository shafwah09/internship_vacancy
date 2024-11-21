<?php
// Koneksi ke database
include 'config.php';
session_start();

// Pastikan hanya mahasiswa yang bisa mengakses
if ($_SESSION['role'] != 'perusahaan') {
    header("Location: login.php");
    exit();
}

$company_id = $_SESSION['user_id']; // ID mahasiswa dari session

// Ambil data profil mahasiswa
$query_profile = "SELECT * FROM company WHERE company_id = '$company_id'";
$result_profile = mysqli_query($conn, $query_profile);
$profile = mysqli_fetch_assoc($result_profile);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
   

    // Update profil mahasiswa
    $query = $query = "UPDATE company SET name = '$name', email = '$email', phone = '$phone', address = '$address' WHERE company_id = '$company_id'";


    if (mysqli_query($conn, $query)) {
        echo "Profil berhasil diperbarui!";
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
<h1>Edit Profil Perusahaan</h1>
<form action="edit_profile_company.php" method="POST">
    <label>Nama:</label><br>
    <input type="text" name="name" value="<?= $profile['name']; ?>" required><br><br>
    
    <label>Email:</label><br>
    <input type="text" name="email" value="<?= $profile['email']; ?>" required><br><br>
    
    <label>Telepon:</label><br>
    <input type="text" name="phone" value="<?= $profile['phone']; ?>" required><br><br>
      
    <label>Alamat:</label><br>
    <input type="text" name="address" value="<?= $profile['address']; ?>"><br><br>
    
    <button type="submit">Update Profil</button>
</form>
<a href="company.php">Kembali ke Dashboard</a>
</body>
</html>
