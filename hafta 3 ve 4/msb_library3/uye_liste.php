<?php
session_start();
require "config.php";
if (!isset($_SESSION["user_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: login.php");
    exit;
}
$sonuc = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <title>Üye Listesi</title>
  <link rel="stylesheet" href="css/genel.css">
</head>
<body class="body">
  <div id="container">
    <header id="header">
      <div id="logo"><a href="admin.php"><img src="images/logo.png" alt=""></a></div>
      <nav id="main-nav">
        <ul>
          <li><a href="admin.php">Admin</a></li>
          <li><a href="uye_liste.php" class="active">Üyeler</a></li>
          <li><a href="kitap_liste.php">Kitaplar</a></li>
          <li><a href="logout.php">Çıkış</a></li>
        </ul>
      </nav>
    </header>
    <main id="content">
      <a href="uye_duzenle.php?id=<?php echo $u["id"]; ?>">Düzenle</a> 
      <a href="uye_ekle.php" class="btn">Yeni Üye Ekle</a>
      <h2>Üye Listesi</h2>
      <table border="1" cellpadding="8" cellspacing="0" style="background:black; width:100%;">
        <tr>
          <th>ID</th>
          <th>Kullanıcı Adı</th>
          <th>Ad Soyad</th>
          <th>Rol</th>
          <th>Durum</th>
          <th>İşlemler</th>
        </tr>
        <?php while ($u = mysqli_fetch_assoc($sonuc)): ?>
          <tr>
            <td><?php echo $u["id"]; ?></td>
            <td><?php echo htmlspecialchars($u["kulad"]); ?></td>
            <td><?php echo htmlspecialchars($u["adsoyad"]); ?></td>
            <td><?php echo $u["rol"]; ?></td>
            <td><?php echo $u["durum"]; ?></td>
            <td>
                <a href="uye_duzenle.php?id=<?php echo $u["id"]; ?>">Düzenle</a> |
                <a href="uye_durum.php?id=<?php echo $u["id"]; ?>&durum=aktif">Aktif</a> |
                <a href="uye_durum.php?id=<?php echo $u["id"]; ?>&durum=pasif">Pasif</a> |
                <a href="uye_durum.php?id=<?php echo $u["id"]; ?>&durum=engelli">Engelle</a> |
                <a href="uye_sil.php?id=<?php echo $u["id"]; ?>" onclick="return confirm('Silinsin mi?')">Sil</a>
</td>

          </tr>
        <?php endwhile; ?>
      </table>
    </main>
  </div>
</body>
</html>
