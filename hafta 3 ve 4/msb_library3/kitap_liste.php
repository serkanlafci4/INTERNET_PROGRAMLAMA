<?php
session_start();
require "config.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: login.php");
    exit;
}

$kitaplar = mysqli_query($conn, "SELECT * FROM kitaplar ORDER BY id DESC");
?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <title>Kitaplar</title>
  <link rel="stylesheet" href="css/genel.css">
</head>
<body class="body">
  <div id="container">

    <!-- Üst Menü -->
    <header id="header">
      <div id="logo">
        <a href="admin.php"><img src="images/logo.png" alt="MSB Logo"></a>
      </div>
      <nav id="main-nav">
        <ul>
          <li><a href="admin.php">Admin</a></li>
          <li><a href="uye_liste.php">Üyeler</a></li>
          <li><a href="kitap_liste.php" class="active">Kitaplar</a></li>
          <li><a href="logout.php">Çıkış</a></li>
        </ul>
      </nav>
    </header>

    <!-- İçerik -->
    <main id="content">
      <h2>Kitaplar</h2>

      <div style="margin-bottom:15px;">
        <a href="kitap_ekle.php" class="btn">Yeni Kitap</a>
      </div>

      <table border="1" cellpadding="8" cellspacing="0" style="background:black; width:100%;">
        <tr>
          <th>ID</th>
          <th>Ad</th>
          <th>Yazar</th>
          <th>ISBN</th>
          <th>Durum</th>
          <th>İşlemler</th>
        </tr>

        <?php while ($k = mysqli_fetch_assoc($kitaplar)): ?>
          <tr>
            <td><?php echo $k["id"]; ?></td>
            <td><?php echo htmlspecialchars($k["ad"]); ?></td>
            <td><?php echo htmlspecialchars($k["yazar"]); ?></td>
            <td><?php echo htmlspecialchars($k["isbn"]); ?></td>
            <td><?php echo $k["durum"]; ?></td>
            <td>
              <a href="kitap_duzenle.php?id=<?php echo $k["id"]; ?>">Düzenle</a> |
              <a href="kitap_sil.php?id=<?php echo $k["id"]; ?>" onclick="return confirm('Silinsin mi?')">Sil</a>
            </td>
          </tr>
        <?php endwhile; ?>

      </table>
    </main>

    <footer id="footer">
      <p>© <?php echo date('Y'); ?> MSB Library</p>
    </footer>

  </div>
</body>
</html>
