<?php
// kitap_ekle.php
session_start();
require "config.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: login.php");
    exit;
}

$mesaj = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ad    = trim($_POST["ad"] ?? "");
    $yazar = trim($_POST["yazar"] ?? "");
    $isbn  = trim($_POST["isbn"] ?? "");
    $yil   = intval($_POST["yayin_yili"] ?? 0);

    if ($ad === "") {
        $mesaj = "Kitap adı boş olamaz.";
    } else {
        $sql = "INSERT INTO kitaplar (ad, yazar, isbn, yayin_yili, durum) VALUES (?, ?, ?, ?, 'mevcut')";
        $st = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($st, "sssi", $ad, $yazar, $isbn, $yil);
        mysqli_stmt_execute($st);

        if (mysqli_stmt_affected_rows($st) > 0) {
            // başarıyla eklendi
            header("Location: kitap_liste.php?ok=1");
            exit;
        } else {
            $mesaj = "Kayıt eklenirken bir hata oluştu.";
        }
    }
}
?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <title>Kitap Ekle</title>
  <link rel="stylesheet" href="css/genel.css">
</head>
<body class="body">
  <div id="container">
    <header id="header">
      <div id="logo"><a href="admin.php"><img src="images/logo.png" alt=""></a></div>
      <nav id="main-nav">
        <ul>
          <li><a href="admin.php">Admin</a></li>
          <li><a href="uye_liste.php">Üyeler</a></li>
          <li><a href="kitap_liste.php" class="active">Kitaplar</a></li>
          <li><a href="logout.php">Çıkış</a></li>
        </ul>
      </nav>
    </header>

    <main id="content">
      <h2>Yeni Kitap Ekle</h2>
      <?php if ($mesaj): ?>
        <p style="color:red; font-weight:bold;"><?php echo $mesaj; ?></p>
      <?php endif; ?>

      <form method="post" action="kitap_ekle.php" class="form-card">
        <label>Kitap Adı *</label>
        <input type="text" name="ad" required>

        <label>Yazar</label>
        <input type="text" name="yazar">

        <label>ISBN</label>
        <input type="text" name="isbn">

        <label>Yayın Yılı</label>
        <input type="number" name="yayin_yili" min="1900" max="2099" step="1">

        <button type="submit" class="btn">Kaydet</button>
        <a href="kitap_liste.php" class="btn secondary">Geri</a>
      </form>
    </main>
  </div>
</body>
</html>
