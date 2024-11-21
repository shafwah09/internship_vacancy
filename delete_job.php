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
$internship_vacancy_id = $_GET['id']; // ID lowongan yang ingin dihapus

// Hapus lowongan
$query = "DELETE FROM internship_vacancy WHERE id = '$internship_vacancy_id' AND company_id = '$company_id'";

if (mysqli_query($conn, $query)) {
    echo "Lowongan berhasil dihapus.";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
<div><a href="company.php">Kembali ke Dashboard</a></div>
