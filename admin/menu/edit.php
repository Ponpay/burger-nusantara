<?php
// Proteksi sesi admin
require_once '../cek_login.php';

// Hubungkan ke database
require_once '../../koneksi.php';

// Ambil ID menu dari GET atau POST
$id_menu = (int)($_GET['id'] ?? $_POST['id_menu'] ?? 0);

if ($id_menu <= 0) {
    header("Location: index.php?pesan=tidakditemukan");
    exit;
}

$query_cari = "SELECT * FROM menu WHERE id_menu = ?";
$stmt_cari  = mysqli_prepare($koneksi, $query_cari);
mysqli_stmt_bind_param($stmt_cari, "i", $id_menu);
mysqli_stmt_execute($stmt_cari);
$hasil_cari = mysqli_stmt_get_result($stmt_cari);
$menu_lama  = mysqli_fetch_assoc($hasil_cari);
mysqli_stmt_close($stmt_cari);

if (!$menu_lama) {
    header("Location: index.php?pesan=tidakditemukan");
    exit;
}

// Inisialisasi isian formulir dengan data lama
$pesan_error  = "";
$nama_menu    = $menu_lama['nama_menu'];
$id_kategori  = $menu_lama['id_kategori'];
$harga        = $menu_lama['harga'];
$deskripsi    = $menu_lama['deskripsi'] ?? '';
$gambar       = $menu_lama['gambar'] ?? '';
$label        = $menu_lama['label'] ?? '';
$rating       = $menu_lama['rating'] ?? '4.5';
$is_favorit   = $menu_lama['is_favorit'];

// Ambil daftar file gambar dari folder images/ selain logo.png
$daftar_gambar = [];
if (is_dir('../../images')) {
    $semua_file = scandir('../../images');
    foreach ($semua_file as $file) {
        if ($file !== '.' && $file !== '..' && $file !== 'logo.png') {
            $ekstensi = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (in_array($ekstensi, ['jpg', 'jpeg', 'png', 'webp'])) {
                $daftar_gambar[] = $file;
            }
        }
    }
}

// Ambil data kategori dari tabel kategori
$query_kategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY id_kategori ASC");

// Proses update saat formulir disubmit (metode POST)
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $nama_menu    = trim($_POST['nama_menu'] ?? '');
    $id_kategori  = (int)($_POST['id_kategori'] ?? 0);
    $harga_input  = trim($_POST['harga'] ?? '');
    $deskripsi    = trim($_POST['deskripsi'] ?? '');
    $gambar       = trim($_POST['gambar'] ?? '');
    $label        = trim($_POST['label'] ?? '');
    $rating_input = trim($_POST['rating'] ?? '');
    $is_favorit   = isset($_POST['is_favorit']) ? 1 : 0;

    // Validasi input
    if ($nama_menu === '') {
        $pesan_error = "Nama menu wajib diisi!";
    } elseif ($id_kategori <= 0) {
        $pesan_error = "Kategori menu wajib dipilih!";
    } elseif ($harga_input === '' || !is_numeric($harga_input) || (int)$harga_input < 0) {
        $pesan_error = "Harga harus diisi dengan angka positif!";
    } elseif ($rating_input !== '' && (!is_numeric($rating_input) || (float)$rating_input < 0 || (float)$rating_input > 5)) {
        $pesan_error = "Rating harus berupa angka antara 0.0 sampai 5.0!";
    } else {
        $harga_bersih  = (int)$harga_input;
        $rating_bersih = ($rating_input === '') ? 4.5 : (float)$rating_input;

        // Nilai nullable
        $simpan_gambar    = ($gambar === '') ? null : $gambar;
        $simpan_label     = ($label === '') ? null : $label;
        $simpan_deskripsi = ($deskripsi === '') ? null : $deskripsi;

        // Update data menggunakan prepared statement
        $query_update = "UPDATE menu SET id_kategori = ?, nama_menu = ?, deskripsi = ?, harga = ?, gambar = ?, label = ?, rating = ?, is_favorit = ? WHERE id_menu = ?";
        $stmt_update  = mysqli_prepare($koneksi, $query_update);
        mysqli_stmt_bind_param($stmt_update, "ississdii", $id_kategori, $nama_menu, $simpan_deskripsi, $harga_bersih, $simpan_gambar, $simpan_label, $rating_bersih, $is_favorit, $id_menu);

        if (mysqli_stmt_execute($stmt_update)) {
            mysqli_stmt_close($stmt_update);
            header("Location: index.php?pesan=edit");
            exit;
        } else {
            $pesan_error = "Gagal memperbarui menu: " . mysqli_error($koneksi);
        }
    }
}

// Konfigurasi tata letak
$judul_halaman = "Ubah Menu";
$halaman_aktif = "menu";
$admin_root    = "../";
$site_root     = "../../";

// Masukkan header admin
include '../includes/header.php';
?>

    <section class="section">
      <div class="section-inner">
        <fieldset>
          <legend class="sr-only">Ubah Data Menu</legend>

          <div class="form-card">
            <!-- Breadcrumb Navigasi -->
            <nav class="breadcrumb">
              <a href="../index.php">Dashboard</a>
              <span class="breadcrumb-sep">/</span>
              <a href="index.php">Menu</a>
              <span class="breadcrumb-sep">/</span>
              <span class="breadcrumb-cur">Ubah Menu</span>
            </nav>

            <div class="form-card-head">
              <p class="eyebrow">Formulir Menu</p>
              <h2>Ubah Data Menu</h2>
              <p>Perbarui informasi menu <strong><?php echo htmlspecialchars($menu_lama['nama_menu']); ?></strong>.</p>
            </div>

            <?php if (!empty($pesan_error)): ?>
              <div class="alert alert-danger">
                <svg class="ico" aria-hidden="true"><use href="#ico-flame"></use></svg>
                <span><?php echo htmlspecialchars($pesan_error); ?></span>
              </div>
            <?php endif; ?>

            <form action="edit.php" method="POST" class="form-grid">
              <input type="hidden" name="id_menu" value="<?php echo $id_menu; ?>">

              <div class="form-group">
                <label for="nama_menu" class="form-label">Nama Menu<span class="req">*</span></label>
                <input type="text" id="nama_menu" name="nama_menu" class="form-control" required maxlength="100" placeholder="Contoh: Burger Sambal Ijo" value="<?php echo htmlspecialchars($nama_menu); ?>">
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label for="id_kategori" class="form-label">Kategori<span class="req">*</span></label>
                  <select id="id_kategori" name="id_kategori" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php
                    mysqli_data_seek($query_kategori, 0);
                    while ($kat = mysqli_fetch_assoc($query_kategori)):
                    ?>
                      <option value="<?php echo $kat['id_kategori']; ?>" <?php echo ($id_kategori == $kat['id_kategori']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($kat['nama_kategori']); ?>
                      </option>
                    <?php endwhile; ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="harga" class="form-label">Harga (Rupiah)<span class="req">*</span></label>
                  <input type="number" id="harga" name="harga" class="form-control" required min="0" step="500" placeholder="Contoh: 28000" value="<?php echo htmlspecialchars($harga_input ?? $harga); ?>">
                </div>
              </div>

              <div class="form-group">
                <label for="deskripsi" class="form-label">Deskripsi Menu</label>
                <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3" placeholder="Jelaskan bahan, cita rasa, atau keunikan menu..."><?php echo htmlspecialchars($deskripsi); ?></textarea>
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label for="gambar" class="form-label">Foto Menu</label>
                  <select id="gambar" name="gambar" class="form-control">
                    <option value="">-- Tanpa foto --</option>
                    <?php foreach ($daftar_gambar as $gbr): ?>
                      <option value="<?php echo htmlspecialchars($gbr); ?>" <?php echo ($gambar === $gbr) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($gbr); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <p class="form-help">Pilih foto dari folder images yang tersedia.</p>

                  <!-- Preview Foto yang Sedang Digunakan (Tanpa JS) -->
                  <?php if (!empty($gambar) && file_exists('../../images/' . $gambar)): ?>
                    <div class="form-preview-box">
                      <img src="../../images/<?php echo htmlspecialchars($gambar); ?>" alt="Foto <?php echo htmlspecialchars($nama_menu); ?>" class="form-preview-img">
                      <div class="form-preview-info">
                        <span class="teks-kecil">Foto saat ini:</span>
                        <strong><?php echo htmlspecialchars($gambar); ?></strong>
                      </div>
                    </div>
                  <?php endif; ?>
                </div>

                <div class="form-group">
                  <label for="label" class="form-label">Label Khusus (Opsional)</label>
                  <input type="text" id="label" name="label" class="form-control" maxlength="30" placeholder="Contoh: Best Seller, Signature" value="<?php echo htmlspecialchars($label); ?>">
                  <p class="form-help">Ditampilkan sebagai badge penanda menu.</p>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label for="rating" class="form-label">Rating (0.0 - 5.0)</label>
                  <input type="number" id="rating" name="rating" class="form-control" min="0" max="5" step="0.1" placeholder="4.5" value="<?php echo htmlspecialchars($rating_input ?? $rating); ?>">
                </div>

                <div class="form-group form-group-checkbox">
                  <label class="form-checkbox-label">
                    <input type="checkbox" name="is_favorit" value="1" <?php echo ($is_favorit == 1) ? 'checked' : ''; ?>>
                    Tandai sebagai Menu Favorit (Tampil di Beranda)
                  </label>
                </div>
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
