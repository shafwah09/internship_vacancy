<?php
// Koneksi ke database
include 'config.php';
session_start();

// Pastikan hanya admin yang bisa mengakses
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$internship_vacancy_id = $_GET['id']; // ID lowongan

// Update status lowongan menjadi pending atau bisa dihapus
$query = "UPDATE internship_vacancy SET status = 'pending' WHERE id = '$internship_vacancy_id'";

if (mysqli_query($conn, $query)) {
    echo "Lowongan telah ditolak dan dikembalikan ke perusahaan.";
    // Redirect ke halaman dashboard admin setelah reject
    header("Location: admin.php");
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
