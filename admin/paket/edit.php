<?php
// Proteksi sesi admin
require_once '../cek_login.php';

// Hubungkan ke database
require_once '../../koneksi.php';

// Ambil ID paket dari GET atau POST
$id_paket = (int)($_GET['id'] ?? $_POST['id_paket'] ?? 0);

if ($id_paket <= 0) {
    header("Location: index.php?pesan=tidakditemukan");
    exit;
}

// Cari data paket lama
$query_cari = "SELECT * FROM paket_combo WHERE id_paket = ?";
$stmt_cari  = mysqli_prepare($koneksi, $query_cari);
mysqli_stmt_bind_param($stmt_cari, "i", $id_paket);
mysqli_stmt_execute($stmt_cari);
$hasil_cari = mysqli_stmt_get_result($stmt_cari);
$paket_lama = mysqli_fetch_assoc($hasil_cari);
mysqli_stmt_close($stmt_cari);

if (!$paket_lama) {
    header("Location: index.php?pesan=tidakditemukan");
    exit;
}

// Inisialisasi formulir dengan data lama
$pesan_error  = "";
$nama_paket   = $paket_lama['nama_paket'];
$label        = $paket_lama['label'] ?? '';
$harga_normal = $paket_lama['harga_normal'];
$harga_paket  = $paket_lama['harga_paket'];
$isi          = $paket_lama['isi'] ?? '';
$is_populer   = $paket_lama['is_populer'];

// Proses update saat disubmit (POST)
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $nama_paket         = trim($_POST['nama_paket'] ?? '');
    $label              = trim($_POST['label'] ?? '');
    $harga_normal_input = trim($_POST['harga_normal'] ?? '');
    $harga_paket_input  = trim($_POST['harga_paket'] ?? '');
    $isi                = trim($_POST['isi'] ?? '');
    $is_populer         = isset($_POST['is_populer']) ? 1 : 0;

    // Validasi
    if ($nama_paket === '') {
        $pesan_error = "Nama paket wajib diisi!";
    } elseif ($harga_normal_input === '' || !is_numeric($harga_normal_input) || (int)$harga_normal_input <= 0) {
        $pesan_error = "Harga normal harus diisi dengan angka positif!";
    } elseif ($harga_paket_input === '' || !is_numeric($harga_paket_input) || (int)$harga_paket_input <= 0) {
        $pesan_error = "Harga paket harus diisi dengan angka positif!";
    } elseif ((int)$harga_paket_input > (int)$harga_normal_input) {
        $pesan_error = "Harga paket promo tidak boleh lebih besar dari harga normal!";
    } else {
        $harga_normal_bersih = (int)$harga_normal_input;
        $harga_paket_bersih  = (int)$harga_paket_input;
        $simpan_label = ($label === '') ? null : $label;
        $simpan_isi   = ($isi === '') ? null : $isi;

        $query_up = "UPDATE paket_combo SET nama_paket = ?, label = ?, harga_normal = ?, harga_paket = ?, isi = ?, is_populer = ? WHERE id_paket = ?";
        $stmt_up  = mysqli_prepare($koneksi, $query_up);
        mysqli_stmt_bind_param($stmt_up, "ssiisii", $nama_paket, $simpan_label, $harga_normal_bersih, $harga_paket_bersih, $simpan_isi, $is_populer, $id_paket);

        if (mysqli_stmt_execute($stmt_up)) {
            mysqli_stmt_close($stmt_up);
            header("Location: index.php?pesan=edit");
            exit;
        } else {
            $pesan_error = "Gagal memperbarui paket combo: " . mysqli_error($koneksi);
        }
    }
}

// Konfigurasi tata letak
$judul_halaman = "Ubah Paket Combo";
$halaman_aktif = "paket";
$admin_root    = "../";
$site_root     = "../../";

// Masukkan header admin
include '../includes/header.php';
?>

    <section class="section">
      <div class="section-inner">
        <fieldset>
          <legend class="sr-only">Ubah Data Paket Combo</legend>

          <div class="form-card">
            <!-- Breadcrumb Navigasi -->
            <nav class="breadcrumb">
              <a href="../index.php">Dashboard</a>
              <span class="breadcrumb-sep">/</span>
              <a href="index.php">Paket Combo</a>
              <span class="breadcrumb-sep">/</span>
              <span class="breadcrumb-cur">Ubah Paket</span>
            </nav>

            <div class="form-card-head">
              <p class="eyebrow">Formulir Paket</p>
              <h2>Ubah Paket Combo</h2>
              <p>Perbarui informasi paket <strong><?php echo htmlspecialchars($paket_lama['nama_paket']); ?></strong>.</p>
            </div>

            <!-- Tampilkan Pesan Error jika Validasi Gagal -->
            <?php if (!empty($pesan_error)): ?>
              <div class="alert alert-danger">
                <svg class="ico" aria-hidden="true"><use href="#ico-flame"></use></svg>
                <span><?php echo htmlspecialchars($pesan_error); ?></span>
              </div>
            <?php endif; ?>

            <!-- Formulir Ubah Paket (Method POST murni HTML dan PHP) -->
            <form action="edit.php" method="POST" class="form-grid">
              <input type="hidden" name="id_paket" value="<?php echo $id_paket; ?>">

              <div class="form-group">
                <label for="nama_paket" class="form-label">Nama Paket<span class="req">*</span></label>
                <input type="text" id="nama_paket" name="nama_paket" class="form-control" required maxlength="100" placeholder="Contoh: Paket Kenyang Kuliah" value="<?php echo htmlspecialchars($nama_paket); ?>">
              </div>

              <div class="form-group">
                <label for="label" class="form-label">Label Promo (Opsional)</label>
                <input type="text" id="label" name="label" class="form-control" maxlength="30" placeholder="Contoh: Hemat 15%, Signature Set, Untuk Berdua" value="<?php echo htmlspecialchars($label); ?>">
                <p class="form-help">Badge penanda promosi pada kartu paket.</p>
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label for="harga_normal" class="form-label">Harga Normal Coret (Rp)<span class="req">*</span></label>
                  <input type="number" id="harga_normal" name="harga_normal" class="form-control" required min="0" step="500" placeholder="Contoh: 48000" value="<?php echo htmlspecialchars($harga_normal_input ?? $harga_normal); ?>">
                  <p class="form-help">Harga sebelum diskon (tampil dicoret).</p>
                </div>

                <div class="form-group">
                  <label for="harga_paket" class="form-label">Harga Paket Promo (Rp)<span class="req">*</span></label>
                  <input type="number" id="harga_paket" name="harga_paket" class="form-control" required min="0" step="500" placeholder="Contoh: 42000" value="<?php echo htmlspecialchars($harga_paket_input ?? $harga_paket); ?>">
                  <p class="form-help">Harga final yang dibayar pembeli.</p>
                </div>
              </div>

              <div class="form-group">
                <label for="isi" class="form-label">Rincian Isi Paket Menu</label>
                <textarea id="isi" name="isi" class="form-control" rows="3" placeholder="Contoh: 1 Burger Keju Spesial + 1 Kentang Goreng + 1 Es Teh Manis."><?php echo htmlspecialchars($isi); ?></textarea>
              </div>

              <div class="form-group">
                <label class="form-checkbox-label">
                  <input type="checkbox" name="is_populer" value="1" <?php echo ($is_populer == 1) ? 'checked' : ''; ?>>
                  Tandai sebagai Paket Paling Populer (Kartu Featured / Unggulan)
                </label>
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
