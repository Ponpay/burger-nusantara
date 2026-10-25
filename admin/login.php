<?php
// Mulai session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jika sudah login, langsung alihkan ke dashboard admin
if (isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

// Hubungkan ke database
require_once '../koneksi.php';

$pesan_error = "";
$username = "";

// Proses formulir saat disubmit (POST)
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $pesan_error = "Username dan password wajib diisi!";
    } else {
        // Ambil data admin berdasarkan username dengan prepared statement
        $query = "SELECT * FROM admin WHERE username = ?";
        $stmt  = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $hasil = mysqli_stmt_get_result($stmt);
        $data_admin = mysqli_fetch_assoc($hasil);
        mysqli_stmt_close($stmt);

        // Verifikasi password dengan password_verify
        if ($data_admin && password_verify($password, $data_admin['password'])) {
            session_regenerate_id(true);
            $_SESSION['admin'] = $data_admin['username'];
            header("Location: index.php");
            exit;
        } else {
            $pesan_error = "Username atau password salah";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin - Burger Nusantara</title>
  <link rel="stylesheet" href="../fonts/fonts.css">
  <link rel="stylesheet" href="../style.css?v=<?php echo filemtime(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'style.css'); ?>">
</head>
<body class="login-body">

  <!-- Kumpulan ikon SVG -->
  <svg class="icon-sprite" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg">
    <symbol id="ico-lock" viewBox="0 0 24 24"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></symbol>
    <symbol id="ico-user" viewBox="0 0 24 24"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></symbol>
  </svg>

  <header class="site-header login-header">
    <div class="header-inner login-header-inner">
      <a class="brand" href="../index.php">
        <img class="brand-logo" src="../images/logo.png" alt="Logo Burger Nusantara">
        <span class="brand-text">
          <strong>Burger Nusantara</strong>
          <small>Panel Administrasi</small>
        </span>
      </a>
    </div>
  </header>

  <main class="content login-content">
    <div class="section-inner login-container">

      <!-- Card info akun admin -->
      <div class="login-hint-card">
        <p class="login-hint-title">Informasi Akun Admin</p>
        <table class="login-hint-table">
          <tr>
            <td class="login-hint-label">Username</td>
            <td><code class="login-hint-code">admin</code></td>
          </tr>
          <tr>
            <td class="login-hint-label">Password</td>
            <td><code class="login-hint-code">admin123</code></td>
          </tr>
        </table>
      </div>

      <div class="form-card login-card">
        <div class="login-card-head">
          <div class="login-icon-box">
            <svg class="ico" aria-hidden="true"><use href="#ico-lock"></use></svg>
          </div>
          <p class="eyebrow">Autentikasi</p>
          <h2>Masuk Admin</h2>
          <p>Masukkan username dan password untuk mengakses panel pengelola.</p>
        </div>

        <?php if (!empty($pesan_error)): ?>
          <div class="alert alert-danger">
            <svg class="ico" aria-hidden="true"><use href="#ico-lock"></use></svg>
            <span><?php echo htmlspecialchars($pesan_error); ?></span>
          </div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="form-grid">
          <div class="form-group">
            <label for="username" class="form-label">Username</label>
            <input type="text" id="username" name="username" class="form-control" required placeholder="Masukkan username" value="<?php echo htmlspecialchars($username); ?>" autocomplete="username">
          </div>

          <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" required placeholder="Masukkan password" autocomplete="current-password">
          </div>

          <div class="login-action-wrap">
            <button type="submit" class="btn btn-primary login-btn">
              Masuk ke Panel &rarr;
            </button>
          </div>

          <div class="login-back-wrap">
            <a href="../index.php" class="login-back-link">
              &larr; Kembali ke Halaman Utama
            </a>
          </div>
        </form>
      </div>

    </div>
  </main>

  <footer class="site-footer login-footer">
    <div class="section-inner login-footer-inner">
      <p><small>&copy; 2026 Burger Nusantara. Panel Administrasi Sistem.</small></p>
    </div>
  </footer>

</body>
</html>
