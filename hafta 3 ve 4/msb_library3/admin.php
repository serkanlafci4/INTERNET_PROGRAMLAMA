<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
if ($_SESSION["rol"] !== "admin") {
    header("Location: uye.php");
    exit;
}
?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Admin Panel - MSB Library</title>
  <link rel="stylesheet" href="css/genel.css">
</head>
<body class="body">
  <div id="container">
    <header id="header">
      <div id="logo"><a href="index.php"><img src="images/logo.png" alt="MSB Logo"></a></div>
      <nav id="main-nav">
        <ul>
          <li><a href="admin.php" class="active">Admin</a></li>
          <li><a href="uye_liste.php">Üye Listesi</a></li>
          <li><a href="kitap_liste.php">Kitaplar</a></li>
          <li><a href="profil.php">Profil</a></li>
          <li><a href="logout.php">Çıkış</a></li>
        </ul>
      </nav>
    </header>

    <main id="content">
      <h2>Admin Dashboard</h2>
      <p>Hoş geldin, <strong><?php echo htmlspecialchars($_SESSION["kulad"]); ?></strong> 👋</p>

      <section class="admin-grid">
        <div class="admin-card">
          <h3>Üye Yönetimi</h3>
          <p>Üyeleri ekle/sil/düzenle.</p>
          <a href="uye_liste.php" class="btn">Üye Listesi</a>
        </div>

        <div class="admin-card">
          <h3>Kitap Yönetimi</h3>
          <p>Kitap ekle/güncelle/sil işlemleri.</p>
          <a href="kitap_liste.php" class="btn">Kitaplar</a>
        </div>

        <div class="admin-card">
          <h3>Profil</h3>
          <p>Şifre / kullanıcı adı değiştir.</p>
          <a href="profil.php" class="btn">Profil</a>
        </div>
      </section>
    </main>

    <footer id="footer">
      <p>© <?php echo date('Y'); ?> MSB Library</p>
    </footer>
  </div>
</body>
</html>
