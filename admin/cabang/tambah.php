<?php
// Proteksi sesi admin
require_once '../cek_login.php';

// Hubungkan ke database
require_once '../../koneksi.php';

// Konfigurasi tata letak
$judul_halaman = "Tambah Cabang";
$halaman_aktif = "cabang";
$admin_root    = "../";
$site_root     = "../../";

// Inisialisasi formulir
$pesan_error  = "";
$label_cabang = "";
$nama_lokasi  = "";
$alamat       = "";
$fasilitas    = "";
$telepon      = "";
$link_maps    = "";

// Proses formulir saat disubmit (POST)
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $label_cabang = trim($_POST['label_cabang'] ?? '');
    $nama_lokasi  = trim($_POST['nama_lokasi'] ?? '');
    $alamat       = trim($_POST['alamat'] ?? '');
    $fasilitas    = trim($_POST['fasilitas'] ?? '');
    $telepon      = trim($_POST['telepon'] ?? '');
    $link_maps    = trim($_POST['link_maps'] ?? '');

    // Validasi
    if ($label_cabang === '') {
        $pesan_error = "Label cabang wajib diisi (misal: Cabang Utama)!";
    } elseif ($nama_lokasi === '') {
        $pesan_error = "Nama lokasi cabang wajib diisi!";
    } elseif ($alamat === '') {
        $pesan_error = "Alamat lengkap cabang wajib diisi!";
    } else {
        $simpan_fasilitas = ($fasilitas === '') ? null : $fasilitas;
        $simpan_telepon   = ($telepon === '') ? null : $telepon;
        $simpan_maps      = ($link_maps === '') ? null : $link_maps;

        $query = "INSERT INTO cabang (label_cabang, nama_lokasi, alamat, fasilitas, telepon, link_maps) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt  = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, "ssssss", $label_cabang, $nama_lokasi, $alamat, $simpan_fasilitas, $simpan_telepon, $simpan_maps);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header("Location: index.php?pesan=tambah");
            exit;
        } else {
            $pesan_error = "Gagal menyimpan cabang: " . mysqli_error($koneksi);
        }
    }
}

// Masukkan header admin
include '../includes/header.php';
?>

    <section class="section">
      <div class="section-inner">
        <fieldset>
          <legend class="sr-only">Tambah Cabang Baru</legend>

          <div class="form-card">
            <!-- Breadcrumb Navigasi -->
            <nav class="breadcrumb">
              <a href="../index.php">Dashboard</a>
              <span class="breadcrumb-sep">/</span>
              <a href="index.php">Cabang</a>
              <span class="breadcrumb-sep">/</span>
              <span class="breadcrumb-cur">Tambah Cabang</span>
            </nav>

            <div class="form-card-head">
              <p class="eyebrow">Formulir Cabang</p>
              <h2>Tambah Outlet Cabang Baru</h2>
              <p>Lengkapi informasi lokasi outlet baru Burger Nusantara.</p>
            </div>

            <!-- Tampilkan Pesan Error jika Validasi Gagal -->
            <?php if (!empty($pesan_error)): ?>
              <div class="alert alert-danger">
                <svg class="ico" aria-hidden="true"><use href="#ico-flame"></use></svg>
                <span><?php echo htmlspecialchars($pesan_error); ?></span>
              </div>
            <?php endif; ?>

            <!-- Formulir Tambah Cabang (Method POST murni HTML dan PHP) -->
            <form action="tambah.php" method="POST" class="form-grid">

              <div class="form-row">
                <div class="form-group">
                  <label for="label_cabang" class="form-label">Label Cabang<span class="req">*</span></label>
                  <input type="text" id="label_cabang" name="label_cabang" class="form-control" required maxlength="50" placeholder="Contoh: Cabang Utama, Cabang Gowa" value="<?php echo htmlspecialchars($label_cabang); ?>">
                  <p class="form-help">Nama sebutan cabang atau outlet.</p>
                </div>

                <div class="form-group">
                  <label for="nama_lokasi" class="form-label">Nama Wilayah / Lokasi<span class="req">*</span></label>
                  <input type="text" id="nama_lokasi" name="nama_lokasi" class="form-control" required maxlength="100" placeholder="Contoh: Syiah Kuala, Batoh" value="<?php echo htmlspecialchars($nama_lokasi); ?>">
                  <p class="form-help">Wilayah atau kawasan cabang berada.</p>
                </div>
              </div>

              <div class="form-group">
                <label for="alamat" class="form-label">Alamat Lengkap<span class="req">*</span></label>
                <textarea id="alamat" name="alamat" class="form-control" required rows="3" placeholder="Contoh: Jln. Teuku Nyak Arief, Darussalam, Banda Aceh, 23111."><?php echo htmlspecialchars($alamat); ?></textarea>
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label for="fasilitas" class="form-label">Fasilitas Outlet (Opsional)</label>
                  <input type="text" id="fasilitas" name="fasilitas" class="form-control" maxlength="150" placeholder="Contoh: Free Wi-Fi • 40+ colokan listrik" value="<?php echo htmlspecialchars($fasilitas); ?>">
                  <p class="form-help">Fasilitas yang tersedia bagi pengunjung.</p>
                </div>

                <div class="form-group">
                  <label for="telepon" class="form-label">Nomor Telepon / Hotline</label>
                  <input type="text" id="telepon" name="telepon" class="form-control" maxlength="20" placeholder="Contoh: 0812-3456-7890" value="<?php echo htmlspecialchars($telepon); ?>">
                  <p class="form-help">Nomor telepon aktif cabang untuk reservasi.</p>
                </div>
              </div>

              <div class="form-group">
                <label for="link_maps" class="form-label">Tautan Google Maps</label>
                <input type="text" id="link_maps" name="link_maps" class="form-control" maxlength="255" placeholder="Contoh: https://maps.google.com/?q=Darussalam+Banda+Aceh" value="<?php echo htmlspecialchars($link_maps); ?>">
                <p class="form-help">Tautan titik lokasi Google Maps untuk petunjuk arah.</p>
              </div>

              <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                  <svg class="ico" aria-hidden="true"><use href="#ico-check"></use></svg>Simpan Cabang
                </button>
                <a href="index.php" class="btn btn-ghost">Batal</a>
              </div>

            </form>
          </div>

        </fieldset>
      </div>
    </section>

<?php
// Masukkan footer admin
include '../includes/footer.php';
?>
