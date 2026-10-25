  </main>

  <!-- Footer -->
  <footer class="site-footer">
    <div class="section-inner footer-grid">

      <div class="footer-brand">
        <p class="footer-logo-line">
          <img class="footer-logo" src="images/logo.png" alt="Logo Burger Nusantara">
          <strong>Burger Nusantara</strong>
        </p>
        <p>Craft artisanal burger dengan perpaduan rempah khas Nusantara dan teknik gourmet modern. Menyajikan kehangatan rasa lokal dalam balutan roti brioche lembut.</p>
        <p class="footer-social">
          <span><svg class="ico" aria-hidden="true"><use href="#ico-instagram"></use></svg>Instagram</span>
          <span><svg class="ico" aria-hidden="true"><use href="#ico-music"></use></svg>TikTok</span>
          <span><svg class="ico" aria-hidden="true"><use href="#ico-chat"></use></svg>WhatsApp</span>
        </p>
      </div>

      <div class="footer-col">
        <h3>Eksplorasi</h3>
        <ul class="footer-links">
          <li><a href="index.php#tentang">Tentang Kami</a></li>
          <li><a href="index.php#menu">Daftar Menu</a></li>
          <li><a href="index.php#pesan">Panduan Pemesanan</a></li>
          <li><a href="tentang.html">Profil Lengkap</a></li>
        </ul>
      </div>

      <div class="footer-col">
        <h3>Outlet Banda Aceh</h3>
        <ul>
          <?php
          if (isset($koneksi) && $koneksi) {
              $query_footer_cabang = mysqli_query($koneksi, "SELECT alamat FROM cabang ORDER BY id_cabang ASC");
              if ($query_footer_cabang) {
                  while ($fc = mysqli_fetch_assoc($query_footer_cabang)) {
                      echo '<li><svg class="ico" aria-hidden="true"><use href="#ico-pin"></use></svg>' . htmlspecialchars($fc['alamat']) . '</li>';
                  }
              }
          }
          ?>
          <li><svg class="ico" aria-hidden="true"><use href="#ico-clock"></use></svg>Setiap Hari: 10:00 &ndash; 22:00 WIB</li>
        </ul>
      </div>

      <div class="footer-col">
        <h3>Layanan Pesanan</h3>
        <p>Melayani pesanan dine-in, takeaway, serta katering acara kampus dan korporat.</p>
        <p class="footer-hotline"><small>Hotline WhatsApp</small><strong>0812-3456-7890</strong></p>
      </div>

    </div>

    <div class="section-inner footer-bottom">
      <div>
        <p>Dibuat oleh: Muhammad Naufal Alifaturafif</p>
        <p><small>&copy; 2026 Burger Nusantara. Rasa Lokal, Gaya Global. Seluruh hak cipta dilindungi.</small></p>
      </div>
      <div>
        <a href="admin/login.php" class="footer-login-link"><svg class="ico" aria-hidden="true"><use href="#ico-lock"></use></svg>Login Admin</a>
      </div>
    </div>
  </footer>

</body>
</html>
