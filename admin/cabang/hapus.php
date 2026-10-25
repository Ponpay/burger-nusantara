<?php
// Proteksi sesi admin
require_once '../cek_login.php';

// Hubungkan ke database
require_once '../../koneksi.php';

// Jika request adalah POST, hapus data
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $id_cabang = (int)($_POST['id_cabang'] ?? 0);

    if ($id_cabang > 0) {
        $query_hapus = "DELETE FROM cabang WHERE id_cabang = ?";
        $stmt = mysqli_prepare($koneksi, $query_hapus);
        mysqli_stmt_bind_param($stmt, "i", $id_cabang);
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
$id_cabang = (int)($_GET['id'] ?? 0);

if ($id_cabang <= 0) {
    header("Location: index.php?pesan=tidakditemukan");
    exit;
}

$query_cari = "SELECT * FROM cabang WHERE id_cabang = ?";
$stmt = mysqli_prepare($koneksi, $query_cari);
mysqli_stmt_bind_param($stmt, "i", $id_cabang);
mysqli_stmt_execute($stmt);
$hasil = mysqli_stmt_get_result($stmt);
$cabang = mysqli_fetch_assoc($hasil);
mysqli_stmt_close($stmt);

if (!$cabang) {
    header("Location: index.php?pesan=tidakditemukan");
    exit;
}

// Konfigurasi tata letak
$judul_halaman = "Konfirmasi Hapus Cabang";
$halaman_aktif = "cabang";
$admin_root    = "../";
$site_root     = "../../";

// Masukkan header admin
include '../includes/header.php';
?>

    <section class="section">
      <div class="section-inner">
        <fieldset>
          <legend class="sr-only">Konfirmasi Hapus Cabang</legend>

          <div class="confirm-card">
            <div class="confirm-icon">
              <svg class="ico" aria-hidden="true"><use href="#ico-trash"></use></svg>
            </div>

            <p class="eyebrow confirm-eyebrow">Peringatan Penghapusan</p>
            <h2 class="confirm-title">Hapus Outlet Cabang Ini?</h2>
            <p class="confirm-desc">Apakah Anda yakin ingin menghapus outlet berikut dari daftar cabang? Tindakan ini tidak dapat dibatalkan.</p>

            <div class="confirm-detail">
              <div class="confirm-detail-text">
                <h4><?php echo htmlspecialchars($cabang['label_cabang']); ?> &mdash; <?php echo htmlspecialchars($cabang['nama_lokasi']); ?></h4>
                <p>Alamat: <strong><?php echo htmlspecialchars($cabang['alamat']); ?></strong></p>
                <?php if (!empty($cabang['fasilitas'])): ?>
                  <p class="teks-kecil">Fasilitas: <?php echo htmlspecialchars($cabang['fasilitas']); ?></p>
                <?php endif; ?>
                <?php if (!empty($cabang['telepon'])): ?>
                  <p class="teks-kecil">Telepon: <?php echo htmlspecialchars($cabang['telepon']); ?></p>
                <?php endif; ?>
              </div>
            </div>

            <!-- Form Hapus Hanya Lewat POST (Murni HTML dan PHP) -->
            <form action="hapus.php" method="POST" class="confirm-actions">
              <input type="hidden" name="id_cabang" value="<?php echo $cabang['id_cabang']; ?>">
              <button type="submit" class="btn btn-delete">
                <svg class="ico" aria-hidden="true"><use href="#ico-trash"></use></svg>Ya, Hapus Cabang
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
