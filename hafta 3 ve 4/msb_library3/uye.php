<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <title>Üye Paneli</title>
  <link rel="stylesheet" href="css/genel.css">
</head>
<body class="body">
  <div id="container">
    <header id="header">
      <div id="logo"><a href="index.php"><img src="images/logo.png" alt="MSB Logo"></a></div>
      <nav id="main-nav">
        <ul>
          <li><a href="uye.php" class="active">Üye Paneli</a></li>
          <li><a href="profil.php">Profil</a></li>
          <li><a href="logout.php">Çıkış</a></li>
        </ul>
      </nav>
    </header>

    <main id="content">
      <h2>Üye Paneli</h2>
      <p>Hoş geldin, <strong><?php echo htmlspecialchars($_SESSION["kulad"]); ?></strong> ✨</p>
      <p>Buraya üyenin görebileceği içerikleri koyabilirsin.</p>
    </main>

    <footer id="footer">
      <p>© <?php echo date('Y'); ?> MSB Library</p>
    </footer>
  </div>
</body>
</html>
