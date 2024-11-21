<?php
// Koneksi ke database
include 'config.php';
session_start();

// Pastikan hanya mahasiswa yang bisa mengakses
if ($_SESSION['role'] != 'mahasiswa') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_SESSION['user_id'];
    $full_name = $_POST['full_name'];
    $nim = $_POST['nim'];
    $study_program = $_POST['study_program'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Masukkan data profil ke database
    $query = "INSERT INTO student (student_id, full_name, nim, study_program, email, phone) 
              VALUES ('$student_id', '$full_name', '$nim', '$study_program', '$email', '$phone')";

    if (mysqli_query($conn, $query)) {
        echo "Profil berhasil dibuat!";
        header("Location: student.php");
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
  <title>Halaman Mahasiswa</title>
<style>
    body {
      font-family: Arial, sans-serif;
      background-color: #E6F0FA;
    }
</style>
</head>
<body>
<div class="student-container">
<h1>Buat Profil Mahasiswa</h1>
<form>
<form action="student_profile.php" method="POST">
    <label>Nama Lengkap:</label><br>
    <input type="text" name="full_name" required><br><br>
    
    <label>NIM:</label><br>
    <input type="text" name="nim" required><br><br>
    
    <label>Program Studi:</label><br>
    <input type="text" name="study_program" required><br><br>
    
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>
    
    <label>Telepon:</label><br>
    <input type="text" name="phone"><br><br>
    
    <button type="submit">Buat Profil</button>
</form>
<a href="student.php">Kembali ke Dashboard</a>
</form>
</div>
</body>
</html>
