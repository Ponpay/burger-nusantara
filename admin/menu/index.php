<?php
// Proteksi sesi admin
require_once '../cek_login.php';

// Hubungkan ke database
require_once '../../koneksi.php';

// Konfigurasi tata letak
$judul_halaman = "Kelola Menu";
$halaman_aktif = "menu";
$admin_root    = "../";
$site_root     = "../../";

// Masukkan header admin
include '../includes/header.php';
?>

<?php
// Ambil data menu dan total baris untuk counter
$query = mysqli_query($koneksi, "SELECT menu.*, kategori.nama_kategori FROM menu JOIN kategori ON menu.id_kategori = kategori.id_kategori ORDER BY menu.id_menu ASC");
$total_baris = mysqli_num_rows($query);
?>

    <section class="section">
      <div class="section-inner">
        <fieldset>
          <legend class="sr-only">Kelola Menu</legend>

          <!-- Toolbar Atas: Judul, Counter & Tombol Tambah -->
          <div class="admin-toolbar">
            <div class="admin-toolbar-title">
              <p class="eyebrow">Manajemen Sajian</p>
              <h2>Kelola Menu</h2>
              <p>Kelola seluruh daftar sajian makanan dan minuman Burger Nusantara.</p>
              <span class="data-counter"><?php echo (int)$total_baris; ?> menu tersimpan</span>
            </div>
            <div class="admin-toolbar-actions">
              <a href="tambah.php" class="btn btn-primary">
                <svg class="ico" aria-hidden="true"><use href="#ico-plus"></use></svg>Tambah Menu Baru
              </a>
            </div>
          </div>

          <!-- Pesan Alert Status -->
          <?php if (isset($_GET['pesan'])): ?>
            <?php if ($_GET['pesan'] === 'tambah'): ?>
              <div class="alert alert-success">
                <svg class="ico" aria-hidden="true"><use href="#ico-check"></use></svg>
                <span>Menu baru berhasil ditambahkan ke database!</span>
              </div>
            <?php elseif ($_GET['pesan'] === 'edit'): ?>
              <div class="alert alert-success">
                <svg class="ico" aria-hidden="true"><use href="#ico-check"></use></svg>
                <span>Data menu berhasil diperbarui!</span>
              </div>
            <?php elseif ($_GET['pesan'] === 'hapus'): ?>
              <div class="alert alert-success">
                <svg class="ico" aria-hidden="true"><use href="#ico-check"></use></svg>
                <span>Menu telah berhasil dihapus dari database!</span>
              </div>
            <?php elseif ($_GET['pesan'] === 'tidakditemukan'): ?>
              <div class="alert alert-danger">
                <svg class="ico" aria-hidden="true"><use href="#ico-flame"></use></svg>
                <span>Data menu yang dicari tidak ditemukan!</span>
              </div>
            <?php endif; ?>
          <?php endif; ?>

          <!-- Kontainer Tabel Data -->
          <div class="table-wrap">
            <table class="admin-table">
              <thead>
                <tr>
                  <th class="col-no">No</th>
                  <th class="col-foto">Foto</th>
                  <th>Nama Menu</th>
                  <th>Kategori</th>
                  <th class="col-harga">Harga</th>
                  <th class="col-status">Favorit</th>
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
                    <td class="col-foto">
                      <?php if (!empty($row['gambar']) && file_exists('../../images/' . $row['gambar'])): ?>
                        <img src="../../images/<?php echo htmlspecialchars($row['gambar']); ?>" alt="<?php echo htmlspecialchars($row['nama_menu']); ?>" class="menu-thumb">
                      <?php else: ?>
                        <span class="badge-no-img">Tanpa foto</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <strong><?php echo htmlspecialchars($row['nama_menu']); ?></strong>
                      <?php if (!empty($row['label'])): ?>
                        <span class="teks-label"><?php echo htmlspecialchars($row['label']); ?></span>
                      <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($row['nama_kategori']); ?></td>
                    <td class="col-harga">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                    <td class="col-status">
                      <?php if ($row['is_favorit'] == 1): ?>
                        <span class="badge-status badge-favorit">Favorit</span>
                      <?php else: ?>
                        <span class="badge-status badge-netral">Biasa</span>
                      <?php endif; ?>
                    </td>
                    <td class="col-aksi">
                      <div class="table-actions">
                        <a href="edit.php?id=<?php echo $row['id_menu']; ?>" class="btn-aksi btn-aksi-ubah">
                          <svg class="ico" aria-hidden="true"><use href="#ico-edit"></use></svg>Ubah
                        </a>
                        <a href="hapus.php?id=<?php echo $row['id_menu']; ?>" class="btn-aksi btn-aksi-hapus">
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
                          <svg class="ico" aria-hidden="true"><use href="#ico-flame"></use></svg>
                        </div>
                        <h4 class="empty-state-title">Belum ada data menu</h4>
                        <p class="empty-state-text">Daftar sajian burger masih kosong. Silakan tambahkan menu pertama Anda sekarang.</p>
                        <a href="tambah.php" class="btn btn-primary btn-sm">
                          <svg class="ico" aria-hidden="true"><use href="#ico-plus"></use></svg>Tambah Menu Baru
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
