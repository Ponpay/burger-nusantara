<?php
// Proteksi sesi admin
require_once '../cek_login.php';

// Hubungkan ke database
require_once '../../koneksi.php';

// Ambil ID cabang dari GET atau POST
$id_cabang = (int)($_GET['id'] ?? $_POST['id_cabang'] ?? 0);

if ($id_cabang <= 0) {
    header("Location: index.php?pesan=tidakditemukan");
    exit;
}

// Cari data cabang lama
$query_cari = "SELECT * FROM cabang WHERE id_cabang = ?";
$stmt_cari  = mysqli_prepare($koneksi, $query_cari);
mysqli_stmt_bind_param($stmt_cari, "i", $id_cabang);
mysqli_stmt_execute($stmt_cari);
$hasil_cari = mysqli_stmt_get_result($stmt_cari);
$cabang_lama= mysqli_fetch_assoc($hasil_cari);
mysqli_stmt_close($stmt_cari);

if (!$cabang_lama) {
    header("Location: index.php?pesan=tidakditemukan");
    exit;
}

// Inisialisasi formulir dengan data lama
$pesan_error  = "";
$label_cabang = $cabang_lama['label_cabang'];
$nama_lokasi  = $cabang_lama['nama_lokasi'];
$alamat       = $cabang_lama['alamat'];
$fasilitas    = $cabang_lama['fasilitas'] ?? '';
$telepon      = $cabang_lama['telepon'] ?? '';
$link_maps    = $cabang_lama['link_maps'] ?? '';

// Proses update saat disubmit (POST)
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $label_cabang = trim($_POST['label_cabang'] ?? '');
    $nama_lokasi  = trim($_POST['nama_lokasi'] ?? '');
    $alamat       = trim($_POST['alamat'] ?? '');
    $fasilitas    = trim($_POST['fasilitas'] ?? '');
    $telepon      = trim($_POST['telepon'] ?? '');
    $link_maps    = trim($_POST['link_maps'] ?? '');

    // Validasi
    if ($label_cabang === '') {
        $pesan_error = "Label cabang wajib diisi!";
    } elseif ($nama_lokasi === '') {
        $pesan_error = "Nama lokasi cabang wajib diisi!";
    } elseif ($alamat === '') {
        $pesan_error = "Alamat lengkap cabang wajib diisi!";
    } else {
        $simpan_fasilitas = ($fasilitas === '') ? null : $fasilitas;
        $simpan_telepon   = ($telepon === '') ? null : $telepon;
        $simpan_maps      = ($link_maps === '') ? null : $link_maps;

        $query_up = "UPDATE cabang SET label_cabang = ?, nama_lokasi = ?, alamat = ?, fasilitas = ?, telepon = ?, link_maps = ? WHERE id_cabang = ?";
        $stmt_up  = mysqli_prepare($koneksi, $query_up);
        mysqli_stmt_bind_param($stmt_up, "ssssssi", $label_cabang, $nama_lokasi, $alamat, $simpan_fasilitas, $simpan_telepon, $simpan_maps, $id_cabang);

        if (mysqli_stmt_execute($stmt_up)) {
            mysqli_stmt_close($stmt_up);
            header("Location: index.php?pesan=edit");
            exit;
        } else {
            $pesan_error = "Gagal memperbarui cabang: " . mysqli_error($koneksi);
        }
    }
}

// Konfigurasi tata letak
$judul_halaman = "Ubah Cabang";
$halaman_aktif = "cabang";
$admin_root    = "../";
$site_root     = "../../";

// Masukkan header admin
include '../includes/header.php';
?>

    <section class="section">
      <div class="section-inner">
        <fieldset>
          <legend class="sr-only">Ubah Data Cabang</legend>

          <div class="form-card">
            <!-- Breadcrumb Navigasi -->
            <nav class="breadcrumb">
              <a href="../index.php">Dashboard</a>
              <span class="breadcrumb-sep">/</span>
              <a href="index.php">Cabang</a>
              <span class="breadcrumb-sep">/</span>
              <span class="breadcrumb-cur">Ubah Cabang</span>
            </nav>

            <div class="form-card-head">
              <p class="eyebrow">Formulir Cabang</p>
              <h2>Ubah Outlet Cabang</h2>
              <p>Perbarui informasi lokasi <strong><?php echo htmlspecialchars($cabang_lama['nama_lokasi']); ?></strong>.</p>
            </div>

            <!-- Tampilkan Pesan Error jika Validasi Gagal -->
            <?php if (!empty($pesan_error)): ?>
              <div class="alert alert-danger">
                <svg class="ico" aria-hidden="true"><use href="#ico-flame"></use></svg>
                <span><?php echo htmlspecialchars($pesan_error); ?></span>
              </div>
            <?php endif; ?>

            <!-- Formulir Ubah Cabang (Method POST murni HTML dan PHP) -->
            <form action="edit.php" method="POST" class="form-grid">
              <input type="hidden" name="id_cabang" value="<?php echo $id_cabang; ?>">

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
                  <svg class="ico" aria-hidden="true"><use href="#ico-check"></use></svg>Simpan Perubahan
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
