<?php
// kitap_duzenle.php
session_start();
require "config.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: login.php");
    exit;
}

$id = intval($_GET["id"] ?? 0);
if ($id <= 0) {
    header("Location: kitap_liste.php");
    exit;
}

$mesaj = "";

// önce kitabı çek
$st = mysqli_prepare($conn, "SELECT * FROM kitaplar WHERE id = ?");
mysqli_stmt_bind_param($st, "i", $id);
mysqli_stmt_execute($st);
$res = mysqli_stmt_get_result($st);
$kitap = mysqli_fetch_assoc($res);

if (!$kitap) {
    header("Location: kitap_liste.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ad    = trim($_POST["ad"] ?? "");
    $yazar = trim($_POST["yazar"] ?? "");
    $isbn  = trim($_POST["isbn"] ?? "");
    $yil   = intval($_POST["yayin_yili"] ?? 0);
    $durum = $_POST["durum"] ?? "mevcut";

    if ($ad === "") {
        $mesaj = "Kitap adı boş olamaz.";
    } else {
        $up = mysqli_prepare($conn, "UPDATE kitaplar SET ad=?, yazar=?, isbn=?, yayin_yili=?, durum=? WHERE id=?");
        mysqli_stmt_bind_param($up, "sssisi", $ad, $yazar, $isbn, $yil, $durum, $id);
        mysqli_stmt_execute($up);

        header("Location: kitap_liste.php?guncellendi=1");
        exit;
    }
}
?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <title>Kitap Düzenle</title>
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
      <h2>Kitap Düzenle</h2>
      <?php if ($mesaj): ?>
        <p style="color:red; font-weight:bold;"><?php echo $mesaj; ?></p>
      <?php endif; ?>

      <form method="post" action="" class="form-card">
        <label>Kitap Adı *</label>
        <input type="text" name="ad" value="<?php echo htmlspecialchars($kitap["ad"]); ?>" required>

        <label>Yazar</label>
        <input type="text" name="yazar" value="<?php echo htmlspecialchars($kitap["yazar"]); ?>">

        <label>ISBN</label>
        <input type="text" name="isbn" value="<?php echo htmlspecialchars($kitap["isbn"]); ?>">

        <label>Yayın Yılı</label>
        <input type="number" name="yayin_yili" value="<?php echo htmlspecialchars($kitap["yayin_yili"]); ?>">

        <label>Durum</label>
        <select name="durum">
          <option value="mevcut"  <?php if ($kitap["durum"]=="mevcut")  echo "selected"; ?>>Mevcut</option>
          <option value="oduncte" <?php if ($kitap["durum"]=="oduncte") echo "selected"; ?>>Ödünçte</option>
          <option value="silindi" <?php if ($kitap["durum"]=="silindi") echo "selected"; ?>>Silindi</option>
        </select>

        <button type="submit" class="btn">Güncelle</button>
        <a href="kitap_liste.php" class="btn secondary">Geri</a>
      </form>
    </main>
  </div>
</body>
</html>
