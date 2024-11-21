<?php
// Koneksi ke database
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encrypt password
    $role = $_POST['role'];

    // Query untuk memasukkan data pengguna baru
    $query = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
    
    if (mysqli_query($conn, $query)) {
        echo "Pendaftaran berhasil!";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Register</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #E6F0FA;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    
    .register-container {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      width: 400px;
    }
    
    .register-container h2 {
      margin-bottom: 40px;
      text-align: center;
    }
    .form-group {
      margin-bottom: 15px;
    }
    .form-group label {
      display: block;
      margin-bottom: 10px;
    }
    .form-group input, .form-group select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .form-group button {
      width: 100%;
      padding: 10px;
      background-color: rgb(0, 0, 108);
      border: none;
      color: white;
      font-size: 16px;
      border-radius: 4px;
      cursor: pointer;
    }
    .form-group button:hover {
      background-color: rgb(0, 0, 108);
    }
  </style>
</head>
<body>
  <div class="register-container">
    <h2>Register</h2>
    <form action="register.php" method="POST">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group">
        <label for="role">Role</label>
        <select id="role" name="role" required>
            <option value="student">Mahasiswa</option>
            <option value="admin">Admin</option>
            <option value="company">Perusahaan</option>
        </select>
      </div>
      <div class="form-group">
        <button type="submit">Register</button>
      </div>
    </form>
    <a href="login.php">Login Disini!</a>
  </div>
</body>
</html>
