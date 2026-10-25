<?php
// Pastikan sesi sudah dicek sebelumnya
$admin_root = isset($admin_root) ? $admin_root : './';
$site_root  = isset($site_root) ? $site_root : '../';
$halaman_aktif = isset($halaman_aktif) ? $halaman_aktif : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($judul_halaman) ? htmlspecialchars($judul_halaman) . " - Admin Burger Nusantara" : "Panel Admin - Burger Nusantara"; ?></title>
  <link rel="stylesheet" href="<?php echo $site_root; ?>fonts/fonts.css">
  <link rel="stylesheet" href="<?php echo $site_root; ?>style.css?v=<?php echo filemtime(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'style.css'); ?>">
</head>
<body>

  <!-- Kumpulan ikon SVG (inline) -->
  <svg class="icon-sprite" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg">
    <symbol id="ico-flame" viewBox="0 0 24 24"><path d="M12 3q1 4 4 6.5t3 5.5a1 1 0 0 1-14 0 5 5 0 0 1 1-3 1 1 0 0 0 5 0c0-2-1.5-3-1.5-5q0-2 2.5-4"/></symbol>
    <symbol id="ico-star" viewBox="0 0 24 24"><path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"/></symbol>
    <symbol id="ico-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></symbol>
    <symbol id="ico-pin" viewBox="0 0 24 24"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></symbol>
    <symbol id="ico-phone" viewBox="0 0 24 24"><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"/></symbol>
    <symbol id="ico-check" viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5"/></symbol>
    <symbol id="ico-plus" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="M12 5v14"/></symbol>
    <symbol id="ico-edit" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></symbol>
    <symbol id="ico-trash" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></symbol>
    <symbol id="ico-user" viewBox="0 0 24 24"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></symbol>
    <symbol id="ico-box" viewBox="0 0 24 24"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></symbol>
    <symbol id="ico-logout" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></symbol>
  </svg>

  <!-- Header admin -->
  <header class="site-header">
    <div class="header-inner">
      <a class="brand" href="<?php echo $admin_root; ?>index.php">
        <img class="brand-logo" src="<?php echo $site_root; ?>images/logo.png" alt="Logo Burger Nusantara">
        <span class="brand-text">
          <strong>Burger Nusantara</strong>
          <small>Panel Admin</small>
        </span>
      </a>

      <!-- Navbar Admin -->
      <nav class="site-nav">
        <ul>
          <li><a href="<?php echo $admin_root; ?>index.php" <?php echo ($halaman_aktif === 'dashboard') ? 'class="aktif"' : ''; ?>>Dashboard</a></li>
          <li><a href="<?php echo $admin_root; ?>menu/index.php" <?php echo ($halaman_aktif === 'menu') ? 'class="aktif"' : ''; ?>>Menu</a></li>
          <li><a href="<?php echo $admin_root; ?>paket/index.php" <?php echo ($halaman_aktif === 'paket') ? 'class="aktif"' : ''; ?>>Paket Combo</a></li>
          <li><a href="<?php echo $admin_root; ?>cabang/index.php" <?php echo ($halaman_aktif === 'cabang') ? 'class="aktif"' : ''; ?>>Cabang</a></li>
          <li><a href="<?php echo $site_root; ?>index.php" target="_blank">Lihat Website</a></li>
          <li><a href="<?php echo $admin_root; ?>logout.php" class="nav-logout">Logout</a></li>
        </ul>
      </nav>

      <div class="header-actions">
        <span class="open-badge">
          <svg class="ico" aria-hidden="true"><use href="#ico-user"></use></svg>
          Hai, <strong><?php echo htmlspecialchars($_SESSION['admin'] ?? 'Admin'); ?></strong>
        </span>
      </div>
    </div>
  </header>

  <main class="content">
