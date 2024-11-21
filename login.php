<?php
// Koneksi ke database
include 'config.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query menggunakan prepared statement untuk keamanan
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['username'] = $user['username'];

            // Redirect berdasarkan role
            if ($user['role'] == 'admin') {
                header("Location: admin.php");
            } elseif ($user['role'] == 'mahasiswa') {
                header("Location: student.php");
            } else {
                header("Location: company.php");
            }
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak terdaftar!";
    }
    $stmt->close();
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #e6f2ff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Memastikan body memenuhi layar */
        }

        .login-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .login-container button {
            width: 95%;
            padding: 10px;
            background-color: #002060;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .login-container button:hover {
            background-color: #003366;
        }

        .show-password {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin: 10px 0;
        }

        .show-password input {
            margin-right: 5px;
        }

        .register {
            margin-top: 10px;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Masuk</h2>
        <form action="login.php" method="post">
            <input type="text" name="username" placeholder="Masukkan username" required>
            <input type="password" name="password" id="password" placeholder="Masukkan kata sandi" required>
            <div class="show-password">
                <input type="checkbox" id="show-password" onclick="togglePassword()">
                <label for="show-password">Tampilkan Kata Sandi</label>
            </div>
            <button type="submit">Masuk</button>
        </form>
        <div class="register">
            Belum punya akun? <a href="register.php">Daftar</a>
        </div>
        <!-- Tampilkan pesan error jika ada -->
        <?php if (isset($error)) { ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php } ?>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById("password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>

    <!-- Footer -->
<footer style="background-color: #002060; color: #fff; padding: 20px 0; margin-top: 20px;">
    <div class="container">
        <div class="row">
            <!-- Tentang Kami -->
            <div class="col-md-4">
                <h5 style="font-weight: bold;">Tentang Kami</h5>
                <ul style="list-style: none; padding: 0;">
                    <li><a href="#" style="color: #fff; text-decoration: none;">Hubungi Kami</a></li>
                    <li><a href="#" style="color: #fff; text-decoration: none;">Pusat Bantuan</a></li>
                    <li><a href="#" style="color: #fff; text-decoration: none;">Kebijakan Privasi</a></li>
                    <li><a href="#" style="color: #fff; text-decoration: none;">Kondisi dan Ketentuan</a></li>
                </ul>
            </div>

            <!-- Pencari Kerja -->
            <div class="col-md-4">
                <h5 style="font-weight: bold;">Pencari Kerja</h5>
                <ul style="list-style: none; padding: 0;">
                    <li><a href="#" style="color: #fff; text-decoration: none;">Registrasi Pencari Kerja</a></li>
                    <li><a href="#" style="color: #fff; text-decoration: none;">Buat Resume Online</a></li>
                    <li><a href="#" style="color: #fff; text-decoration: none;">Cari Lowongan Kerja</a></li>
                    <li><a href="#" style="color: #fff; text-decoration: none;">Remote Jobs</a></li>
                </ul>
            </div>

            <!-- Perusahaan -->
            <div class="col-md-4">
                <h5 style="font-weight: bold;">Perusahaan</h5>
                <ul style="list-style: none; padding: 0;">
                    <li><a href="#" style="color: #fff; text-decoration: none;">Registrasi Perusahaan</a></li>
                    <li><a href="#" style="color: #fff; text-decoration: none;">Pasang Loker</a></li>
                    <li><a href="#" style="color: #fff; text-decoration: none;">Produk dan Layanan</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
