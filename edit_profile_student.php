<?php
// Koneksi ke database
include 'config.php';
session_start();

// Pastikan hanya mahasiswa yang bisa mengakses
if ($_SESSION['role'] != 'mahasiswa') {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['user_id']; // ID mahasiswa dari session

// Ambil data profil mahasiswa
$query_profile = "SELECT * FROM student WHERE student_id = '$student_id'";
$result_profile = mysqli_query($conn, $query_profile);
$profile = mysqli_fetch_assoc($result_profile);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $nim = $_POST['nim'];
    $study_program = $_POST['study_program'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Update profil mahasiswa
    $query = "UPDATE student_profiles SET full_name = '$full_name', nim = '$nim', study_program = '$study_program', 
              email = '$email', phone = '$phone' WHERE student_id = '$student_id'";

    if (mysqli_query($conn, $query)) {
        echo "Profil berhasil diperbarui!";
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
<div class="student-container"></div>
<h1>Edit Profil Mahasiswa</h1>
<form action="edit_profile_student.php" method="POST">
    <label>Nama Lengkap:</label><br>
    <input type="text" name="full_name" value="<?= $profile['full_name']; ?>" required><br><br>
    
    <label>NIM:</label><br>
    <input type="text" name="nim" value="<?= $profile['nim']; ?>" required><br><br>
    
    <label>Program Studi:</label><br>
    <input type="text" name="study_program" value="<?= $profile['study_program']; ?>" required><br><br>
    
    <label>Email:</label><br>
    <input type="email" name="email" value="<?= $profile['email']; ?>" required><br><br>
    
    <label>Telepon:</label><br>
    <input type="text" name="phone" value="<?= $profile['phone']; ?>"><br><br>
    
    <button type="submit">Update Profil</button>
</form>
<a href="student.php">Kembali ke Dashboard</a>
</body>
</html>
