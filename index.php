<?php
// Hubungkan ke database
require_once 'koneksi.php';

// Judul halaman
$judul_halaman = "Rasa Lokal, Gaya Global";

// Data untuk hero card — ambil Burger Rendang Minang (menu andalan hero)
$q_hero = mysqli_query($koneksi, "SELECT nama_menu, deskripsi, harga, gambar FROM menu WHERE nama_menu = 'Burger Rendang Minang' LIMIT 1");
$hero   = mysqli_fetch_assoc($q_hero);

// Harga terendah untuk teks "Mulai dari Rp X" di pilar
$q_hmin  = mysqli_query($koneksi, "SELECT MIN(harga) AS hmin FROM menu");
$row_min = mysqli_fetch_assoc($q_hmin);
$harga_min = $row_min['hmin'] ?? 8000;

// Masukkan template header
include 'includes/header.php';
?>

    <!-- Beranda / Hero -->
    <section id="beranda" class="hero">
      <div class="section-inner hero-grid">

        <div class="hero-text">
          <p class="badge"><svg class="ico" aria-hidden="true"><use href="#ico-flame"></use></svg>Burger Fusion No. 1 di Banda Aceh &bull; 100% Halal &amp; Tanpa Pengawet</p>
          <h1>Rasa Otentik <em>Nusantara,</em><br>Standar Burger Dunia.</h1>
          <p class="lead">
            Perpaduan daging sapi lokal pilihan tanpa pengawet, roti brioche empuk dipanggang
            fresh tiap pagi, dan bumbu rempah warisan Nusantara. Gurih, pedas segar, dan
            ramah kantong mahasiswa!
          </p>

          <div class="hero-actions">
            <a class="btn btn-primary" href="#menu">Lihat Daftar Menu &amp; Harga</a>
            <a class="btn btn-ghost" href="https://wa.me/6281234567890"><svg class="ico" aria-hidden="true"><use href="#ico-chat"></use></svg>Order via WhatsApp</a>
          </div>

          <ul class="hero-proof">
            <li><span class="stars"><svg class="ico ico-fill" aria-hidden="true"><use href="#ico-star"></use></svg><svg class="ico ico-fill" aria-hidden="true"><use href="#ico-star"></use></svg><svg class="ico ico-fill" aria-hidden="true"><use href="#ico-star"></use></svg><svg class="ico ico-fill" aria-hidden="true"><use href="#ico-star"></use></svg><svg class="ico ico-fill" aria-hidden="true"><use href="#ico-star"></use></svg></span> <strong>4.9/5</strong> <span>(3.200+ ulasan)</span></li>
            <li><svg class="ico ico-check" aria-hidden="true"><use href="#ico-check"></use></svg> <strong>3 Cabang</strong> <span>di Banda Aceh</span></li>
            <li><svg class="ico ico-check" aria-hidden="true"><use href="#ico-check"></use></svg> <strong>100% Sapi Segar</strong> <span>Tanpa Pengawet</span></li>
          </ul>
        </div>

        <figure class="hero-visual">
          <div class="hero-media">
            <?php
            // Gambar hero dari Burger Rendang Minang; fallback ke burger-rendang.jpg
            $hero_img = (!empty($hero['gambar']) && file_exists('images/' . $hero['gambar']))
              ? 'images/' . htmlspecialchars($hero['gambar'])
              : 'images/burger-rendang.jpg';
            $hero_alt = !empty($hero['nama_menu']) ? htmlspecialchars($hero['nama_menu']) : 'Menu Andalan Burger Nusantara';
            ?>
            <img src="<?php echo $hero_img; ?>" alt="<?php echo $hero_alt; ?>">
            <span class="ribbon"><svg class="ico" aria-hidden="true"><use href="#ico-flame"></use></svg>Icon of Banda Aceh</span>
            <span class="float-tag tag-top"><span class="tag-ico"><svg class="ico" aria-hidden="true"><use href="#ico-flame"></use></svg></span><b>Bumbu Rendang</b><i>Masak 8 Jam</i></span>
            <span class="float-tag tag-bottom"><span class="tag-ico"><svg class="ico" aria-hidden="true"><use href="#ico-bakery"></use></svg></span><b>Brioche Fresh</b><i>Panggang Tiap Pagi</i></span>
          </div>
          <figcaption class="hero-card">
            <span>
              <h3><?php echo !empty($hero['nama_menu']) ? htmlspecialchars($hero['nama_menu']) : 'Burger Rendang Minang'; ?></h3>
              <p><?php echo !empty($hero['deskripsi']) ? htmlspecialchars($hero['deskripsi']) : 'Patty Sapi 120g &bull; Bumbu Rendang &bull; Melted Cheddar'; ?></p>
            </span>
            <span class="hero-price">Rp <?php echo number_format(!empty($hero['harga']) ? $hero['harga'] : 32000, 0, ',', '.'); ?></span>
          </figcaption>
        </figure>

      </div>
    </section>

    <!-- Tentang Kami -->
    <section id="tentang" class="section section-alt">
      <div class="section-inner">
        <fieldset>
          <legend class="sr-only">Tentang Kami</legend>
          <div class="section-head split">
            <div>
              <h2>Tentang Kami</h2>
            </div>
            <p>
              Berawal dari warung gerobak sederhana di dekat kampus Darussalam,
              <strong>Burger Nusantara</strong> lahir dari kegelisahan menikmati burger impor yang
              hambar rempah dan mahal. Kami meracik ulang burger barat dengan kekayaan bumbu dapur
              tradisional Aceh dan Nusantara &mdash; menghadirkan makanan cepat saji berkelas tanpa
              melupakan akar rasa tanah air.
            </p>
          </div>

          <h3 class="sub-title">Kenapa memilih kami?</h3>
          <ul class="pillar-list">
            <li class="pillar">
              <span class="pillar-icon"><svg class="ico" aria-hidden="true"><use href="#ico-bakery"></use></svg></span>
              <h3>Roti Brioche Panggang Subuh</h3>
              <p>Dibuat fresh setiap hari dari dapur sendiri mulai jam 4 pagi. Tanpa pengawet buatan, tekstur empuk, dan aroma mentega gurih yang memikat selera.</p>
            </li>
            <li class="pillar">
              <span class="pillar-icon icon-secondary"><svg class="ico" aria-hidden="true"><use href="#ico-beef"></use></svg></span>
              <h3>100% Daging Sapi Segar Lokal</h3>
              <p>Patty tebal 120 gram murni daging sapi peternak lokal Aceh tanpa campuran tepung berlebih. Dipanggang pas sehingga jus dagingnya terkunci sempurna.</p>
            </li>
            <li class="pillar">
              <span class="pillar-icon icon-tertiary"><svg class="ico" aria-hidden="true"><use href="#ico-leaf"></use></svg></span>
              <h3>Sambal &amp; Rempah Otentik</h3>
              <p>Bumbu rendang dimasak 8 jam hingga meresap pekat, serta racikan sambal matah dari serai segar, bawang merah, cabai rawit, dan jeruk limau harum.</p>
            </li>
            <li class="pillar">
              <span class="pillar-icon icon-amber"><svg class="ico" aria-hidden="true"><use href="#ico-wallet"></use></svg></span>
              <h3>Harga Ramah Mahasiswa</h3>
              <p>Kualitas artisan, harga warung bersahabat. Mulai dari Rp <?php echo number_format($harga_min, 0, ',', '.'); ?>, setiap pelajar dan keluarga bisa menikmati santapan lezat tanpa kantong bolong.</p>
            </li>
          </ul>
        </fieldset>
      </div>
    </section>

    <!-- Menu & Harga -->
    <section id="menu" class="section">
      <div class="section-inner">
        <fieldset>
          <legend class="sr-only">Menu Favorit</legend>
          <div class="section-head center">
            <p class="eyebrow">Pilihan Terfavorit</p>
            <h2>Menu Favorit</h2>
            <p>Dibuat dadakan saat kamu memesan (made-to-order) untuk menjamin kerenyahan dan kesegaran rasa terbaik.</p>
          </div>

          <!-- Kartu menu favorit dari database -->
          <div class="dish-grid">
            <?php
            $query_favorit = mysqli_query($koneksi, "SELECT * FROM menu WHERE is_favorit = 1 ORDER BY id_menu ASC");
            while ($favorit = mysqli_fetch_assoc($query_favorit)):
            ?>
              <article class="dish-card">
                <div class="dish-media">
                  <?php if (!empty($favorit['gambar']) && file_exists('images/' . $favorit['gambar'])): ?>
                    <img src="images/<?php echo htmlspecialchars($favorit['gambar']); ?>" alt="<?php echo htmlspecialchars($favorit['nama_menu']); ?>">
                  <?php else: ?>
                    <div class="dish-no-media">
                      <img src="images/logo.png" alt="<?php echo htmlspecialchars($favorit['nama_menu']); ?>" class="fallback-img">
                    </div>
                  <?php endif; ?>

                  <?php if (!empty($favorit['label'])): ?>
                    <span class="dish-badge"><?php echo htmlspecialchars($favorit['label']); ?></span>
                  <?php endif; ?>

                  <?php if (!empty($favorit['rating'])): ?>
                    <span class="dish-rating"><svg class="ico ico-fill" aria-hidden="true"><use href="#ico-star"></use></svg><?php echo htmlspecialchars($favorit['rating']); ?></span>
                  <?php endif; ?>
                </div>
                <div class="dish-body">
                  <h3><?php echo htmlspecialchars($favorit['nama_menu']); ?></h3>
                  <p><?php echo htmlspecialchars($favorit['deskripsi']); ?></p>
                  <p class="price">Rp <?php echo number_format($favorit['harga'], 0, ',', '.'); ?></p>
                </div>
              </article>
            <?php endwhile; ?>
          </div>

          <!-- Paket hemat combo dari tabel paket_combo -->
          <div class="combo-box">
            <div class="combo-head">
              <span class="combo-label"><svg class="ico" aria-hidden="true"><use href="#ico-graduation"></use></svg>Spesial Pelajar &amp; Mahasiswa</span>
              <h3>Paket Hemat Combo &amp; Menu Lengkap</h3>
              <p>Tunjukkan kartu mahasiswa / pelajar untuk ekstra diskon 10% setiap hari Rabu!</p>
            </div>

            <div class="combo-grid">
              <?php
              $query_paket = mysqli_query($koneksi, "SELECT * FROM paket_combo ORDER BY id_paket ASC");
              while ($paket = mysqli_fetch_assoc($query_paket)):
                $is_pop = ($paket['is_populer'] == 1);
              ?>
                <article class="combo-card <?php echo $is_pop ? 'combo-featured' : ''; ?>">
                  <?php if ($is_pop): ?>
                    <span class="combo-flag">Paling Populer</span>
                  <?php endif; ?>

                  <div class="combo-top">
                    <?php if (!empty($paket['label'])): ?>
                      <span class="combo-tag"><?php echo htmlspecialchars($paket['label']); ?></span>
                    <?php endif; ?>
                    <s>Rp <?php echo number_format($paket['harga_normal'], 0, ',', '.'); ?></s>
                  </div>

                  <h3><?php echo htmlspecialchars($paket['nama_paket']); ?></h3>
                  <p><?php echo htmlspecialchars($paket['isi']); ?></p>

                  <div class="combo-bottom">
                    <span class="price">Rp <?php echo number_format($paket['harga_paket'], 0, ',', '.'); ?></span>
                    <a class="btn btn-primary btn-sm" href="https://wa.me/6281234567890">Pesan</a>
                  </div>
                </article>
              <?php endwhile; ?>
            </div>
          </div>

          <!-- Tabel daftar harga dari database -->
          <h3 class="table-title">Daftar Harga</h3>
          <div class="table-wrap">
            <table class="menu-table">
              <thead>
                <tr>
                  <th>Nama Menu</th>
                  <th>Kategori</th>
                  <th>Harga</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query_semua = mysqli_query($koneksi, "SELECT menu.*, kategori.nama_kategori FROM menu JOIN kategori ON menu.id_kategori = kategori.id_kategori ORDER BY menu.id_menu ASC");
                while ($menu = mysqli_fetch_assoc($query_semua)):
                ?>
                  <tr>
                    <td><?php echo htmlspecialchars($menu['nama_menu']); ?></td>
                    <td><?php echo htmlspecialchars($menu['nama_kategori']); ?></td>
                    <td><mark>Rp <?php echo number_format($menu['harga'], 0, ',', '.'); ?></mark></td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </fieldset>
      </div>
    </section>

    <!-- Cara Pesan -->
    <section id="pesan" class="section section-alt">
      <div class="section-inner">
        <fieldset>
          <legend class="sr-only">Cara Pesan</legend>
          <div class="section-head center">
            <p class="eyebrow">Mudah &amp; Praktis</p>
            <h2>Cara Pesan</h2>
            <p>Pilih opsi yang paling nyaman untuk menemani jam makan siang, nugas, atau nongkrong malam kamu.</p>
          </div>

          <h3 class="sub-title">Langkah pemesanan online</h3>
          <ol class="step-list">
            <li class="step">
              <h3>Dine-in / Nongkrong Santai</h3>
              <p>Datang langsung ke salah satu dari 3 kedai kami di Banda Aceh. Tersedia ruangan ber-AC nyaman, Wi-Fi kencang, dan banyak colokan kabel.</p>
              <p class="step-note"><svg class="ico" aria-hidden="true"><use href="#ico-store"></use></svg>Langsung Duduk &amp; Pesan</p>
            </li>
            <li class="step step-highlight">
              <h3>Order Cepat via WhatsApp</h3>
              <p>Tak mau antre? Cukup chat WhatsApp hotline kami lewat <a href="https://wa.me/6281234567890">WhatsApp resmi Burger Nusantara</a>, pilih menu favoritmu, dan pesanan langsung disiapkan dapur.</p>
              <p class="step-note note-tertiary"><svg class="ico" aria-hidden="true"><use href="#ico-clock"></use></svg>Siap dalam 10&ndash;15 Menit</p>
            </li>
            <li class="step">
              <h3>Antar ke Kost &amp; Rumah</h3>
              <p>Malas keluar karena tugas numpuk? Pesan lewat GoFood, GrabFood, atau ShopeeFood. Diskon ongkir dan voucher promo selalu aktif, cek juga <a href="https://www.instagram.com/">Instagram kami</a>.</p>
              <p class="step-note note-secondary"><svg class="ico" aria-hidden="true"><use href="#ico-bike"></use></svg>Tersedia di Semua Ojol</p>
            </li>
          </ol>
        </fieldset>
      </div>
    </section>

    <!-- Kontak & Cabang -->
    <section id="kontak" class="section">
      <div class="section-inner">
        <fieldset>
          <legend class="sr-only">Kontak &amp; Lokasi</legend>
          <div class="section-head center">
            <p class="eyebrow">Titik Kumpul Kami</p>
            <h2>Kontak &amp; Lokasi</h2>
            <p>Pilih outlet terdekat dari tempat tinggalmu. Semua cabang buka setiap hari pukul 10.00 &ndash; 22.00 WIB.</p>
          </div>

          <h3 class="sub-title">Cabang kami</h3>
          <ul class="branch-list">
            <?php
            $query_cabang = mysqli_query($koneksi, "SELECT * FROM cabang ORDER BY id_cabang ASC");
            $urutan = 0;
            while ($cb = mysqli_fetch_assoc($query_cabang)):
              $urutan++;
              $media_class = "";
              if ($urutan % 3 == 2) {
                $media_class = "media-secondary";
              } elseif ($urutan % 3 == 0) {
                $media_class = "media-tertiary";
              }
            ?>
              <li class="branch-card">
                <div class="branch-media <?php echo $media_class; ?>">
                  <span class="branch-tag"><?php echo htmlspecialchars($cb['label_cabang']); ?></span>
                  <strong><?php echo htmlspecialchars($cb['nama_lokasi']); ?></strong>
                </div>
                <div class="branch-body">
                  <ul class="branch-info">
                    <li><svg class="ico" aria-hidden="true"><use href="#ico-pin"></use></svg><?php echo htmlspecialchars($cb['alamat']); ?></li>
                    <?php if (!empty($cb['fasilitas'])): ?>
                      <li><svg class="ico" aria-hidden="true"><use href="#ico-wifi"></use></svg><?php echo htmlspecialchars($cb['fasilitas']); ?></li>
                    <?php endif; ?>
                    <?php if (!empty($cb['telepon'])): ?>
                      <li><svg class="ico" aria-hidden="true"><use href="#ico-phone"></use></svg><?php echo htmlspecialchars($cb['telepon']); ?></li>
                    <?php endif; ?>
                  </ul>
                  <p class="branch-actions">
                    <?php if (!empty($cb['link_maps'])): ?>
                      <a href="<?php echo htmlspecialchars($cb['link_maps']); ?>"><svg class="ico" aria-hidden="true"><use href="#ico-pin"></use></svg>Lihat Lokasi</a>
                    <?php endif; ?>
                    <a class="btn btn-primary btn-sm" href="https://wa.me/6281234567890">Chat Cabang</a>
                  </p>
                </div>
              </li>
            <?php endwhile; ?>
          </ul>
        </fieldset>
      </div>
    </section>

<?php
// Masukkan template footer
include 'includes/footer.php';
?>
