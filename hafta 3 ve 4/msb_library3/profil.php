<?php
session_start();
require "config.php";
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$mesaj = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $yeni_kulad = trim($_POST["yeni_kulad"] ?? "");
    $eski_sifre = trim($_POST["eski_sifre"] ?? "");
    $yeni_sifre = trim($_POST["yeni_sifre"] ?? "");
    $uid = $_SESSION["user_id"];

    $sql = "SELECT sifre FROM users WHERE id = ?";
    $st = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($st, "i", $uid);
    mysqli_stmt_execute($st);
    $res = mysqli_stmt_get_result($st);
    $row = mysqli_fetch_assoc($res);

    if (!$row) {
        $mesaj = "Kullanıcı bulunamadı.";
    } elseif ($row["sifre"] !== md5($eski_sifre)) {
        $mesaj = "Eski şifre yanlış!";
    } else {
        if ($yeni_kulad !== "") {
            $u1 = mysqli_prepare($conn, "UPDATE users SET kulad = ? WHERE id = ?");
            mysqli_stmt_bind_param($u1, "si", $yeni_kulad, $uid);
            mysqli_stmt_execute($u1);
            $_SESSION["kulad"] = $yeni_kulad;
        }
        if ($yeni_sifre !== "") {
            $yeni_md5 = md5($yeni_sifre);
            $u2 = mysqli_prepare($conn, "UPDATE users SET sifre = ? WHERE id = ?");
            mysqli_stmt_bind_param($u2, "si", $yeni_md5, $uid);
            mysqli_stmt_execute($u2);
        }
        $mesaj = "Bilgiler güncellendi.";
    }
}
?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <title>Profil</title>
  <link rel="stylesheet" href="css/genel.css">
</head>
<body class="body">
  <div id="container">
    <header id="header">
      <div id="logo"><a href="index.php"><img src="images/logo.png" alt=""></a></div>
      <nav id="main-nav">
        <ul>
          <?php if ($_SESSION["rol"] === "admin"): ?>
            <li><a href="admin.php">Admin</a></li>
          <?php else: ?>
            <li><a href="uye.php">Üye Paneli</a></li>
          <?php endif; ?>
          <li><a href="profil.php" class="active">Profil</a></li>
          <li><a href="logout.php">Çıkış</a></li>
        </ul>
      </nav>
    </header>

    <main id="content">
      <h2>Profil Ayarları</h2>
      <?php if ($mesaj): ?>
        <p><strong><?php echo $mesaj; ?></strong></p>
      <?php endif; ?>

      <form method="post" action="">
        <label>Yeni Kullanıcı Adı</label>
        <input type="text" name="yeni_kulad" placeholder="Boş bırakılırsa değişmez">

        <label>Eski Şifre</label>
        <input type="password" name="eski_sifre" required>

        <label>Yeni Şifre</label>
        <input type="password" name="yeni_sifre" placeholder="Boş bırakılırsa değişmez">

        <button type="submit" class="btn">Güncelle</button>
      </form>
    </main>
  </div>
</body>
</html>
