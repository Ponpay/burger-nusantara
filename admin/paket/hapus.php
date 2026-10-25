<?php
// Proteksi sesi admin
require_once '../cek_login.php';

// Hubungkan ke database
require_once '../../koneksi.php';

// Jika request adalah POST, hapus data
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $id_paket = (int)($_POST['id_paket'] ?? 0);

    if ($id_paket > 0) {
        $query_hapus = "DELETE FROM paket_combo WHERE id_paket = ?";
        $stmt = mysqli_prepare($koneksi, $query_hapus);
        mysqli_stmt_bind_param($stmt, "i", $id_paket);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: index.php?pesan=hapus");
        exit;
    } else {
        header("Location: index.php?pesan=tidakditemukan");
        exit;
    }
}

// Jika GET, tampilkan konfirmasi
$id_paket = (int)($_GET['id'] ?? 0);

if ($id_paket <= 0) {
    header("Location: index.php?pesan=tidakditemukan");
    exit;
}

$query_cari = "SELECT * FROM paket_combo WHERE id_paket = ?";
$stmt = mysqli_prepare($koneksi, $query_cari);
mysqli_stmt_bind_param($stmt, "i", $id_paket);
mysqli_stmt_execute($stmt);
$hasil = mysqli_stmt_get_result($stmt);
$paket = mysqli_fetch_assoc($hasil);
mysqli_stmt_close($stmt);

if (!$paket) {
    header("Location: index.php?pesan=tidakditemukan");
    exit;
}

// Konfigurasi tata letak
$judul_halaman = "Konfirmasi Hapus Paket Combo";
$halaman_aktif = "paket";
$admin_root    = "../";
$site_root     = "../../";

// Masukkan header admin
include '../includes/header.php';
?>

    <section class="section">
      <div class="section-inner">
        <fieldset>
          <legend class="sr-only">Konfirmasi Hapus Paket Combo</legend>

          <div class="confirm-card">
            <div class="confirm-icon">
              <svg class="ico" aria-hidden="true"><use href="#ico-trash"></use></svg>
            </div>

            <p class="eyebrow confirm-eyebrow">Peringatan Penghapusan</p>
            <h2 class="confirm-title">Hapus Paket Combo Ini?</h2>
            <p class="confirm-desc">Apakah Anda yakin ingin menghapus paket promo berikut secara permanen? Tindakan ini tidak dapat dibatalkan.</p>

            <div class="confirm-detail">
              <div class="confirm-detail-text">
                <h4><?php echo htmlspecialchars($paket['nama_paket']); ?></h4>
                <p>
                  Harga Normal: <span class="harga-coret">Rp <?php echo number_format($paket['harga_normal'], 0, ',', '.'); ?></span> &bull;
                  Harga Promo: <strong>Rp <?php echo number_format($paket['harga_paket'], 0, ',', '.'); ?></strong>
                </p>
                <?php if (!empty($paket['isi'])): ?>
                  <p class="teks-kecil"><?php echo htmlspecialchars($paket['isi']); ?></p>
                <?php endif; ?>
              </div>
            </div>

            <!-- Form Hapus Hanya Lewat POST (Murni HTML dan PHP) -->
            <form action="hapus.php" method="POST" class="confirm-actions">
              <input type="hidden" name="id_paket" value="<?php echo $paket['id_paket']; ?>">
              <button type="submit" class="btn btn-delete">
                <svg class="ico" aria-hidden="true"><use href="#ico-trash"></use></svg>Ya, Hapus Paket
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
