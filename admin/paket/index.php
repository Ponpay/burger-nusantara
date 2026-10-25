<?php
// Proteksi sesi admin
require_once '../cek_login.php';

// Hubungkan ke database
require_once '../../koneksi.php';

// Konfigurasi tata letak
$judul_halaman = "Kelola Paket Combo";
$halaman_aktif = "paket";
$admin_root    = "../";
$site_root     = "../../";

// Masukkan header admin
include '../includes/header.php';
?>

<?php
// Ambil data paket dan total baris untuk counter
$query = mysqli_query($koneksi, "SELECT * FROM paket_combo ORDER BY id_paket ASC");
$total_baris = mysqli_num_rows($query);
?>

    <section class="section">
      <div class="section-inner">
        <fieldset>
          <legend class="sr-only">Kelola Paket Combo</legend>

          <!-- Toolbar Atas: Judul, Counter & Tombol Tambah -->
          <div class="admin-toolbar">
            <div class="admin-toolbar-title">
              <p class="eyebrow">Manajemen Promosi</p>
              <h2>Kelola Paket Combo</h2>
              <p>Kelola bundel menu hemat, diskon pelajar, dan paket spesial Burger Nusantara.</p>
              <span class="data-counter"><?php echo (int)$total_baris; ?> paket tersimpan</span>
            </div>
            <div class="admin-toolbar-actions">
              <a href="tambah.php" class="btn btn-primary">
                <svg class="ico" aria-hidden="true"><use href="#ico-plus"></use></svg>Tambah Paket Baru
              </a>
            </div>
          </div>

          <!-- Pesan Alert Status -->
          <?php if (isset($_GET['pesan'])): ?>
            <?php if ($_GET['pesan'] === 'tambah'): ?>
              <div class="alert alert-success">
                <svg class="ico" aria-hidden="true"><use href="#ico-check"></use></svg>
                <span>Paket combo baru berhasil ditambahkan!</span>
              </div>
            <?php elseif ($_GET['pesan'] === 'edit'): ?>
              <div class="alert alert-success">
                <svg class="ico" aria-hidden="true"><use href="#ico-check"></use></svg>
                <span>Data paket combo berhasil diperbarui!</span>
              </div>
            <?php elseif ($_GET['pesan'] === 'hapus'): ?>
              <div class="alert alert-success">
                <svg class="ico" aria-hidden="true"><use href="#ico-check"></use></svg>
                <span>Paket combo berhasil dihapus dari database!</span>
              </div>
            <?php elseif ($_GET['pesan'] === 'tidakditemukan'): ?>
              <div class="alert alert-danger">
                <svg class="ico" aria-hidden="true"><use href="#ico-flame"></use></svg>
                <span>Data paket yang dicari tidak ditemukan!</span>
              </div>
            <?php endif; ?>
          <?php endif; ?>

          <!-- Kontainer Tabel Data -->
          <div class="table-wrap">
            <table class="admin-table">
              <thead>
                <tr>
                  <th class="col-no">No</th>
                  <th>Nama Paket</th>
                  <th class="col-label">Label Promo</th>
                  <th class="col-harga">Harga Paket</th>
                  <th>Rincian Isi Menu</th>
                  <th class="col-status">Populer</th>
                  <th class="col-aksi">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($total_baris > 0):
                  $no = 1;
                  while ($row = mysqli_fetch_assoc($query)):
                ?>
                  <tr>
                    <td class="col-no"><?php echo $no++; ?></td>
                    <td><strong><?php echo htmlspecialchars($row['nama_paket']); ?></strong></td>
                    <td class="col-label">
                      <?php if (!empty($row['label'])): ?>
                        <span class="badge-tag"><?php echo htmlspecialchars($row['label']); ?></span>
                      <?php else: ?>
                        <span class="teks-kecil">-</span>
                      <?php endif; ?>
                    </td>
                    <td class="col-harga">
                      <div class="harga-paket-group">
                        <span class="harga-coret">Rp <?php echo number_format($row['harga_normal'], 0, ',', '.'); ?></span>
                        <span class="harga-highlight">Rp <?php echo number_format($row['harga_paket'], 0, ',', '.'); ?></span>
                      </div>
                    </td>
                    <td class="col-desc"><span class="teks-kecil"><?php echo htmlspecialchars($row['isi']); ?></span></td>
                    <td class="col-status">
                      <?php if ($row['is_populer'] == 1): ?>
                        <span class="badge-status badge-populer">Populer</span>
                      <?php else: ?>
                        <span class="badge-status badge-netral">Biasa</span>
                      <?php endif; ?>
                    </td>
                    <td class="col-aksi">
                      <div class="table-actions">
                        <a href="edit.php?id=<?php echo $row['id_paket']; ?>" class="btn-aksi btn-aksi-ubah">
                          <svg class="ico" aria-hidden="true"><use href="#ico-edit"></use></svg>Ubah
                        </a>
                        <a href="hapus.php?id=<?php echo $row['id_paket']; ?>" class="btn-aksi btn-aksi-hapus">
                          <svg class="ico" aria-hidden="true"><use href="#ico-trash"></use></svg>Hapus
                        </a>
                      </div>
                    </td>
                  </tr>
                <?php
                  endwhile;
                else:
                ?>
                  <tr>
                    <td colspan="7" class="table-empty-cell">
                      <div class="empty-state-box">
                        <div class="empty-state-icon">
                          <svg class="ico" aria-hidden="true"><use href="#ico-box"></use></svg>
                        </div>
                        <h4 class="empty-state-title">Belum ada data paket combo</h4>
                        <p class="empty-state-text">Daftar paket hemat combo masih kosong. Silakan tambahkan paket pertama Anda sekarang.</p>
                        <a href="tambah.php" class="btn btn-primary btn-sm">
                          <svg class="ico" aria-hidden="true"><use href="#ico-plus"></use></svg>Tambah Paket Baru
                        </a>
                      </div>
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

        </fieldset>
      </div>
    </section>

<?php
// Masukkan footer admin
include '../includes/footer.php';
?>
