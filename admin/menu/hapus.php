<?php
// Proteksi sesi admin
require_once '../cek_login.php';

// Hubungkan ke database
require_once '../../koneksi.php';

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $id_menu = (int)($_POST['id_menu'] ?? 0);

    if ($id_menu > 0) {
        $query_hapus = "DELETE FROM menu WHERE id_menu = ?";
        $stmt = mysqli_prepare($koneksi, $query_hapus);
        mysqli_stmt_bind_param($stmt, "i", $id_menu);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: index.php?pesan=hapus");
        exit;
    } else {
        header("Location: index.php?pesan=tidakditemukan");
        exit;
    }
}

$id_menu = (int)($_GET['id'] ?? 0);

if ($id_menu <= 0) {
    header("Location: index.php?pesan=tidakditemukan");
    exit;
}

// Ambil detail data menu
$query_cari = "SELECT menu.*, kategori.nama_kategori FROM menu JOIN kategori ON menu.id_kategori = kategori.id_kategori WHERE menu.id_menu = ?";
$stmt = mysqli_prepare($koneksi, $query_cari);
mysqli_stmt_bind_param($stmt, "i", $id_menu);
mysqli_stmt_execute($stmt);
$hasil = mysqli_stmt_get_result($stmt);
$menu  = mysqli_fetch_assoc($hasil);
mysqli_stmt_close($stmt);

// Jika menu tidak ditemukan di database
if (!$menu) {
    header("Location: index.php?pesan=tidakditemukan");
    exit;
}

// Konfigurasi tata letak
$judul_halaman = "Konfirmasi Hapus Menu";
$halaman_aktif = "menu";
$admin_root    = "../";
$site_root     = "../../";

// Masukkan header admin
include '../includes/header.php';
?>

    <section class="section">
      <div class="section-inner">
        <fieldset>
          <legend class="sr-only">Konfirmasi Hapus Menu</legend>

          <div class="confirm-card">
            <div class="confirm-icon">
              <svg class="ico" aria-hidden="true"><use href="#ico-trash"></use></svg>
            </div>

            <p class="eyebrow confirm-eyebrow">Peringatan Penghapusan</p>
            <h2 class="confirm-title">Hapus Menu Ini?</h2>
            <p class="confirm-desc">Apakah Anda yakin ingin menghapus sajian berikut secara permanen dari daftar menu? Tindakan ini tidak dapat dibatalkan.</p>

            <div class="confirm-detail">
              <?php if (!empty($menu['gambar']) && file_exists('../../images/' . $menu['gambar'])): ?>
                <img src="../../images/<?php echo htmlspecialchars($menu['gambar']); ?>" alt="<?php echo htmlspecialchars($menu['nama_menu']); ?>" class="confirm-detail-thumb">
              <?php else: ?>
                <span class="badge-no-img">Tanpa foto</span>
              <?php endif; ?>

              <div class="confirm-detail-text">
                <h4><?php echo htmlspecialchars($menu['nama_menu']); ?></h4>
                <p>Kategori: <strong><?php echo htmlspecialchars($menu['nama_kategori']); ?></strong> &bull; Harga: <strong>Rp <?php echo number_format($menu['harga'], 0, ',', '.'); ?></strong></p>
                <?php if (!empty($menu['deskripsi'])): ?>
                  <p class="teks-kecil"><?php echo htmlspecialchars($menu['deskripsi']); ?></p>
                <?php endif; ?>
              </div>
            </div>

            <form action="hapus.php" method="POST" class="confirm-actions">
              <input type="hidden" name="id_menu" value="<?php echo $menu['id_menu']; ?>">
              <button type="submit" class="btn btn-delete">
                <svg class="ico" aria-hidden="true"><use href="#ico-trash"></use></svg>Ya, Hapus Menu
              </button>
              <a href="index.php" class="btn btn-ghost">Batal</a>
            </form>

          </div>

        </fieldset>
      </div>
    </section>

<?php
// Masukkan footer admin
include '../includes/footer.php';
?>
