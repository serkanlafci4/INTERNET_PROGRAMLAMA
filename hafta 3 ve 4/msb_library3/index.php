<?php session_start(); ?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>MSB Library</title>
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
          <li><a href="index.php" class="active">Anasayfa</a></li>
          <li><a href="hakkimizda.php">Hakkımızda</a></li>
          <li><a href="misyon.php">Misyon</a></li>
          <li><a href="vizyon.php">Vizyon</a></li>
          <li><a href="iletisim.php">İletişim</a></li>
          <?php if (isset($_SESSION["user_id"])): ?>
            <?php if ($_SESSION["rol"] === "admin"): ?>
              <li><a href="admin.php">Admin</a></li>
            <?php else: ?>
              <li><a href="uye.php">Panel</a></li>
            <?php endif; ?>
            <li><a href="logout.php">Çıkış (<?php echo htmlspecialchars($_SESSION["kulad"]); ?>)</a></li>
          <?php else: ?>
            <li><a href="login.php">Giriş</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </header>

    <main id="content">
      <section class="hero">
        <h1>MSB Library Web Otomasyon</h1>
      </section>

      <section class="cards">
        <article class="card">
          <h3>Hakkımızda</h3>
          <p>Kütüphanemiz, akademik kaynaklara hızlı erişim ve kolay yönetim amaçlı tasarlanmıştır.</p>
          <a href="hakkimizda.php" class="btn">Detay</a>
        </article>

        <article class="card">
          <h3>İletişim</h3>
          <p>Sorularınız veya talepleriniz için iletişim sayfamızı kullanabilirsiniz.</p>
          <a href="iletisim.php" class="btn">İletişim</a>
        </article>
      </section>
    </main>

    <footer id="footer">
      <p>© <?php echo date('Y'); ?> MSB Library — Tüm hakları saklıdır.</p>
    </footer>
  </div>
</body>
</html>
