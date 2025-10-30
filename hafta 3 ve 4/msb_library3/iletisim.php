<?php session_start(); ?>
<!dog="tr">
<head>
  <meta charset="utf-8" />
  <title>İletişim - MSB Library</title>
  <link rel="stylesheet" href="css/genel.css">
</head>
<body class="body">
  <div id="container">
    <header id="header">
      <div id="logo">
        <a href="index.php"><img src="images/logo.png" alt="MSB Logo"></a>
      </div>
      <nav id="main-nav">
        <ul>
          <li><a href="index.php">Anasayfa</a></li>
          <li><a href="hakkimizda.php">Hakkımızda</a></li>
          <li><a href="misyon.php">Misyon</a></li>
          <li><a href="vizyon.php">Vizyon</a></li>
          <li><a href="iletisim.php" class="active">İletişim</a></li>
          <?php if (isset($_SESSION["user_id"])): ?>
            <li><a href="<?php echo $_SESSION["rol"]==='admin' ? 'admin.php' : 'uye.php'; ?>">Panel</a></li>
            <li><a href="logout.php">Çıkış</a></li>
          <?php else: ?>
            <li><a href="login.php">Giriş</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </header>

    <main id="content">
      <h2>İletişim</h2>
      <p>
        Bizimle iletişime geçmek için aşağıdaki formu doldurabilir veya doğrudan e-posta gönderebilirsiniz.
      </p>

      <form action="#" method="post" class="form-card">
        <label>Ad Soyad</label>
        <input type="text" name="adsoyad" required>

        <label>E-posta</label>
        <input type="email" name="email" required>

        <label>Mesajınız</label>
        <textarea name="mesaj" rows="5" required></textarea>

        <button type="submit" class="btn">Gönder</button>
      </form>

      <section style="margin-top:25px;">
        <p><strong>E-posta:</strong> info@msblibrary.com</p>
        <p><strong>Telefon:</strong> +90 312 000 00 00</p>
        <p><strong>Adres:</strong> MSB Kampüsü, Ankara, Türkiye</p>
      </section>
    </main>

    <footer id="footer">
      <p>© <?php echo date('Y'); ?> MSB Library</p>
    </footer>
  </div>
</body>
</html>
