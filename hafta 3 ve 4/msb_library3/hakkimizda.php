<?php session_start(); ?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <title>Hakkımızda - MSB Library</title>
  <link rel="stylesheet" href="css/genel.css">
</head>
<body class="body">
  <div id="container">
    <header id="header">
      <div id="logo"><a href="index.php"><img src="images/logo.png" alt="MSB Logo"></a></div>
      <nav id="main-nav">
        <ul>
          <li><a href="index.php">Anasayfa</a></li>
          <li><a href="hakkimizda.php" class="active">Hakkımızda</a></li>
          <li><a href="misyon.php">Misyon</a></li>
          <li><a href="vizyon.php">Vizyon</a></li>
          <li><a href="iletisim.php">İletişim</a></li>
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
      <h2>Hakkımızda</h2>
      <p>MSB Library, öğrencilerin ve akademisyenlerin kaynak arama, ödünç alma ve yönetim süreçlerini kolaylaştırmak için tasarlanmış bir web otomasyon sistemidir.</p>
    </main>

    <footer id="footer">
      <p>© <?php echo date('Y'); ?> MSB Library</p>
    </footer>
  </div>
</body>
</html>
