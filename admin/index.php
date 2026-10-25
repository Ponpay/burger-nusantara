<?php
// Proteksi sesi admin
require_once 'cek_login.php';

// Hubungkan ke database
require_once '../koneksi.php';

// Judul halaman & status aktif navbar
$judul_halaman = "Dashboard";
$halaman_aktif = "dashboard";
$admin_root    = "./";
$site_root     = "../";

// Ambil jumlah data dari ketiga tabel
$q_menu = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM menu");
$total_menu = mysqli_fetch_assoc($q_menu)['total'] ?? 0;

$q_paket = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM paket_combo");
$total_paket = mysqli_fetch_assoc($q_paket)['total'] ?? 0;

$q_cabang = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM cabang");
$total_cabang = mysqli_fetch_assoc($q_cabang)['total'] ?? 0;

// Masukkan header admin
include 'includes/header.php';
?>

    <section class="section">
      <div class="section-inner">
        <fieldset>
          <legend class="sr-only">Dashboard Admin</legend>

          <!-- Sapaan & Judul -->
          <div class="section-head dash-head">
            <p class="eyebrow">Panel Kendali</p>
            <h2>Selamat Datang, <?php echo htmlspecialchars($_SESSION['admin'] ?? 'Admin'); ?>!</h2>
            <p>Kelola menu sajian, paket hemat promo, dan informasi cabang outlet Burger Nusantara secara terpusat.</p>
          </div>

          <!-- Baris Aksi Cepat -->
          <div class="quick-actions">
            <span class="quick-actions-title">Aksi Cepat:</span>
            <a href="menu/tambah.php" class="btn btn-primary btn-sm">
              <svg class="ico" aria-hidden="true"><use href="#ico-plus"></use></svg>Tambah Menu
            </a>
            <a href="paket/tambah.php" class="btn btn-primary btn-sm">
              <svg class="ico" aria-hidden="true"><use href="#ico-plus"></use></svg>Tambah Paket
            </a>
            <a href="cabang/tambah.php" class="btn btn-primary btn-sm">
              <svg class="ico" aria-hidden="true"><use href="#ico-plus"></use></svg>Tambah Cabang
            </a>
            <a href="<?php echo $site_root; ?>index.php" target="_blank" class="btn btn-ghost btn-sm">
              Lihat Website &rarr;
            </a>
          </div>

          <!-- 3 Kartu Ringkasan -->
          <ul class="dash-grid">
            <!-- Kartu Menu -->
            <li class="stat-card">
              <div class="stat-card-body">
                <div class="stat-card-top">
                  <div class="stat-card-icon stat-card-icon-primary">
                    <svg class="ico" aria-hidden="true"><use href="#ico-flame"></use></svg>
                  </div>
                  <span class="stat-unit">Item Menu</span>
                </div>
                <h3 class="stat-title">Menu Sajian</h3>
                <div class="stat-number stat-color-primary">
                  <?php echo (int)$total_menu; ?>
                </div>
                <p class="stat-desc">Daftar burger nusantara, makanan pendamping, dan minuman beserta harga serta status favorit.</p>
              </div>
              <div class="stat-card-footer">
                <a href="menu/index.php" class="btn btn-primary btn-sm stat-btn">
                  Kelola Menu &rarr;
                </a>
              </div>
            </li>

            <!-- Kartu Paket Combo -->
            <li class="stat-card">
              <div class="stat-card-body">
                <div class="stat-card-top">
                  <div class="stat-card-icon stat-card-icon-tertiary">
                    <svg class="ico" aria-hidden="true"><use href="#ico-box"></use></svg>
                  </div>
                  <span class="stat-unit">Paket Combo</span>
                </div>
                <h3 class="stat-title">Paket Combo</h3>
                <div class="stat-number stat-color-tertiary">
                  <?php echo (int)$total_paket; ?>
                </div>
                <p class="stat-desc">Bundel menu hemat, diskon promo mahasiswa, rincian paket, dan penanda paket populer.</p>
              </div>
              <div class="stat-card-footer">
                <a href="paket/index.php" class="btn btn-primary btn-sm stat-btn">
                  Kelola Paket Combo &rarr;
                </a>
              </div>
            </li>

            <!-- Kartu Cabang -->
            <li class="stat-card">
              <div class="stat-card-body">
                <div class="stat-card-top">
                  <div class="stat-card-icon stat-card-icon-secondary">
                    <svg class="ico" aria-hidden="true"><use href="#ico-pin"></use></svg>
                  </div>
                  <span class="stat-unit">Outlet</span>
                </div>
                <h3 class="stat-title">Outlet Cabang</h3>
                <div class="stat-number stat-color-secondary">
                  <?php echo (int)$total_cabang; ?>
                </div>
                <p class="stat-desc">Titik outlet di Banda Aceh, alamat lengkap, fasilitas pelanggan, kontak, dan link Google Maps.</p>
              </div>
              <div class="stat-card-footer">
                <a href="cabang/index.php" class="btn btn-primary btn-sm stat-btn">
                  Kelola Cabang &rarr;
                </a>
              </div>
            </li>
          </ul>

        </fieldset>
      </div>
    </section>

<?php
// Masukkan footer admin
include 'includes/footer.php';
?>
