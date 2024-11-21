<?php
// Koneksi ke database
include 'config.php';
session_start();

// Pastikan hanya mahasiswa yang bisa mengakses halaman ini
if ($_SESSION['role'] != 'mahasiswa') {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['user_id']; // ID mahasiswa dari session

// Ambil data profil mahasiswa
$query_profile = "SELECT * FROM student WHERE student_id = '$student_id'";
$result_profile = mysqli_query($conn, $query_profile);
$profile = mysqli_fetch_assoc($result_profile);

// Ambil daftar lowongan yang sudah disetujui
$query_jobs = "SELECT * FROM internship_vacancy WHERE status = 'approved'";
$result_jobs = mysqli_query($conn, $query_jobs);

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
<h1>Selamat Datang, Mahasiswa!</h1>
<form>
<?php if ($profile): ?>
    <h2>Profil Mahasiswa</h2>
    <p>Nama: <?= $profile['full_name']; ?></p>
    <p>NIM: <?= $profile['nim']; ?></p>
    <p>Program Studi: <?= $profile['study_program']; ?></p>
    <p>Email: <?= $profile['email']; ?></p>
    <p>Telepon: <?= $profile['phone']; ?></p>
    <p><a href="edit_profile_student.php">Edit Profil</a></p>
<?php else: ?>
    <p>Profil Anda belum dibuat. <a href="student_profile.php">Buat Profil</a></p>
<?php endif; ?>

<h2>Lowongan Pekerjaan yang Disetujui</h2>
<table>
    <tr>
        <th>Judul Lowongan</th>
        <th>Perusahaan</th>
        <th>Deskripsi</th>
        <th>Aksi</th>
    </tr>
    <?php while ($job = mysqli_fetch_assoc($result_jobs)) : ?>
        <tr>
            <td><?= $job['title']; ?></td>
            <td><?= $job['company_name']; ?></td>
            <td><?= substr($job['description'], 0, 100); ?>...</td>
            <td><a href="apply_job.php?id=<?= $job['id']; ?>">Lamaran</a></td>
        </tr>
        

    <?php endwhile; ?>
</table>
</form>
<a href="logout.php">Logout</a>
</body>
</html>

