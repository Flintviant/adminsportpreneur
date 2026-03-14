<?php
session_start();
include 'koneksi.php'; // file koneksi database

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Query user berdasarkan username
    $stmt = $conn->prepare("
        SELECT 
            l.id_login,
            l.user,
            l.pass,
            l.id_member,
            r.id_role,
            r.role_name,
            m.nm_member,
            m.gambar
        FROM login l
        JOIN roles r ON l.id_role = r.id_role
        JOIN member m ON l.id_member = m.id_member
        WHERE l.user = ?
        AND r.id_role = 1
    ");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['pass'])) {
            // Simpan session
            $_SESSION['user_id'] = $user['id_login'];
            $_SESSION['role_id'] = $user['id_role'];
            $_SESSION['role_name'] = $user['role_name'];
            $_SESSION['id_member'] = $user['id_member'];

            // Tambahan dari tabel member
            $_SESSION['nm_member']  = $user['nm_member'];
            $_SESSION['gambar']     = $user['gambar'];

            header("Location: index.php");
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4" style="max-width:400px; width:100%;">
      <h3 class="text-center mb-3">Login Admin</h3>

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="post">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" name="username" id="username" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>
    </div>
  </div>
</body>
</html>