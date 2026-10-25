<?php
// Proteksi sesi admin
require_once '../cek_login.php';

// Hubungkan ke database
require_once '../../koneksi.php';

// Konfigurasi tata letak
$judul_halaman = "Kelola Cabang";
$halaman_aktif = "cabang";
$admin_root    = "../";
$site_root     = "../../";

// Masukkan header admin
include '../includes/header.php';
?>

<?php
// Ambil data cabang dan total baris untuk counter
$query = mysqli_query($koneksi, "SELECT * FROM cabang ORDER BY id_cabang ASC");
$total_baris = mysqli_num_rows($query);
?>

    <section class="section">
      <div class="section-inner">
        <fieldset>
          <legend class="sr-only">Kelola Cabang</legend>

          <!-- Toolbar Atas: Judul, Counter & Tombol Tambah -->
          <div class="admin-toolbar">
            <div class="admin-toolbar-title">
              <p class="eyebrow">Manajemen Lokasi</p>
              <h2>Kelola Outlet &amp; Cabang</h2>
              <p>Kelola titik kumpul kedai Burger Nusantara di seluruh Banda Aceh.</p>
              <span class="data-counter"><?php echo (int)$total_baris; ?> cabang tersimpan</span>
            </div>
            <div class="admin-toolbar-actions">
              <a href="tambah.php" class="btn btn-primary">
                <svg class="ico" aria-hidden="true"><use href="#ico-plus"></use></svg>Tambah Cabang Baru
              </a>
            </div>
          </div>

          <!-- Pesan Alert Status -->
          <?php if (isset($_GET['pesan'])): ?>
            <?php if ($_GET['pesan'] === 'tambah'): ?>
              <div class="alert alert-success">
                <svg class="ico" aria-hidden="true"><use href="#ico-check"></use></svg>
                <span>Outlet cabang baru berhasil ditambahkan!</span>
              </div>
            <?php elseif ($_GET['pesan'] === 'edit'): ?>
              <div class="alert alert-success">
                <svg class="ico" aria-hidden="true"><use href="#ico-check"></use></svg>
                <span>Data outlet cabang berhasil diperbarui!</span>
              </div>
            <?php elseif ($_GET['pesan'] === 'hapus'): ?>
              <div class="alert alert-success">
                <svg class="ico" aria-hidden="true"><use href="#ico-check"></use></svg>
                <span>Outlet cabang berhasil dihapus dari database!</span>
              </div>
            <?php elseif ($_GET['pesan'] === 'tidakditemukan'): ?>
              <div class="alert alert-danger">
                <svg class="ico" aria-hidden="true"><use href="#ico-flame"></use></svg>
                <span>Data cabang yang dicari tidak ditemukan!</span>
              </div>
            <?php endif; ?>
          <?php endif; ?>

          <!-- Kontainer Tabel Data -->
          <div class="table-wrap">
            <table class="admin-table">
              <thead>
                <tr>
                  <th class="col-no">No</th>
                  <th class="col-label">Label Cabang</th>
                  <th>Nama Lokasi</th>
                  <th>Alamat</th>
                  <th>Fasilitas</th>
                  <th class="col-telepon">Telepon</th>
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
                    <td class="col-label"><span class="badge-tag"><?php echo htmlspecialchars($row['label_cabang']); ?></span></td>
                    <td><strong><?php echo htmlspecialchars($row['nama_lokasi']); ?></strong></td>
                    <td class="col-alamat"><span class="teks-kecil"><?php echo htmlspecialchars($row['alamat']); ?></span></td>
                    <td class="col-fasilitas"><span class="teks-kecil"><?php echo htmlspecialchars($row['fasilitas']); ?></span></td>
                    <td class="col-telepon"><?php echo htmlspecialchars($row['telepon']); ?></td>
                    <td class="col-aksi">
                      <div class="table-actions">
                        <a href="edit.php?id=<?php echo $row['id_cabang']; ?>" class="btn-aksi btn-aksi-ubah">
                          <svg class="ico" aria-hidden="true"><use href="#ico-edit"></use></svg>Ubah
                        </a>
                        <a href="hapus.php?id=<?php echo $row['id_cabang']; ?>" class="btn-aksi btn-aksi-hapus">
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
                          <svg class="ico" aria-hidden="true"><use href="#ico-pin"></use></svg>
                        </div>
                        <h4 class="empty-state-title">Belum ada cabang outlet</h4>
                        <p class="empty-state-text">Daftar lokasi outlet masih kosong. Silakan tambahkan cabang pertama Anda sekarang.</p>
                        <a href="tambah.php" class="btn btn-primary btn-sm">
                          <svg class="ico" aria-hidden="true"><use href="#ico-plus"></use></svg>Tambah Cabang Baru
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
