<?php
// Koneksi ke database
include 'config.php';
session_start();

// Pastikan hanya perusahaan yang bisa mengakses halaman ini
if ($_SESSION['role'] != 'perusahaan') {
    header("Location: login.php");
    exit();
}

$company_id = $_SESSION['user_id']; // ID mahasiswa dari session

// Ambil data profil mahasiswa
$query_profile = "SELECT * FROM company WHERE company_id = '$company_id'";
$result_profile = mysqli_query($conn, $query_profile);
$profile = mysqli_fetch_assoc($result_profile);

// Ambil daftar lowongan pekerjaan perusahaan
$query_internship_vacancy = "SELECT * FROM internship_vacancy WHERE company_id = '$company_id'";
$result_internship_vacancy = mysqli_query($conn, $query_internship_vacancy);


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
<h1>Selamat Datang, Perusahaan!</h1>
<form>
<?php if ($profile): ?>
    <h2>Profil Perusahaan</h2>
    <p>Nama: <?= $profile['name']; ?></p>
    <p>Email: <?= $profile['email']; ?></p>
    <p>Phone: <?= $profile['phone']; ?></p>
    <p>Address: <?= $profile['address']; ?></p>
  
    <p><a href="edit_profile_company.php">Edit Profil</a></p>
<?php else: ?>
    <p>Profil Anda belum dibuat. <a href="company_profile.php">Buat Profil</a></p>
<?php endif; ?>

<!-- Link untuk mengelola profil dan lowongan -->
<h2>Kelola Profil & Lowongan</h2>
<ul>
    <li><a href="post_job.php">Post Lowongan Baru</a></li>
    <li><a href="company_job.php">Lihat & Kelola Lowongan</a></li>
</ul>
</form>
<a href="logout.php">Logout</a>
</body>
</html>
