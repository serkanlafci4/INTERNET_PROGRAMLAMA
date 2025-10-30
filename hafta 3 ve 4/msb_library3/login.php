<?php
session_start();
require "config.php";

$hata = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $kadi  = trim($_POST["kadi"] ?? "");
    $sifre = trim($_POST["sifre"] ?? "");

    if ($kadi === "" || $sifre === "") {
        $hata = "Kullanıcı adı ve şifre zorunlu.";
    } else {
        $sifre_md5 = md5($sifre);
        $sql = "SELECT * FROM users WHERE kulad = ? AND sifre = ? LIMIT 1";
        $st = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($st, "ss", $kadi, $sifre_md5);
        mysqli_stmt_execute($st);
        $res = mysqli_stmt_get_result($st);
        if ($row = mysqli_fetch_assoc($res)) {
            if ($row["durum"] !== "aktif") {
                $hata = "Hesabınız aktif değil (durum: {$row["durum"]}).";
            } else {
                $_SESSION["user_id"] = $row["id"];
                $_SESSION["kulad"]   = $row["kulad"];
                $_SESSION["adsoyad"] = $row["adsoyad"];
                $_SESSION["rol"]     = $row["rol"];

                if ($row["rol"] === "admin") {
                    header("Location: admin.php");
                } else {
                    header("Location: uye.php");
                }
                exit;
            }
        } else {
            $hata = "Kullanıcı adı veya şifre hatalı!";
        }
    }
}
?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Giriş - MSB Library</title>
  <link rel="stylesheet" href="css/genel.css">
</head>
<body class="body">
  <div id="container">
    <header id="header">
      <div id="logo"><a href="index.php"><img src="images/logo.png" alt="MSB Logo"></a></div>
      <nav id="main-nav">
        <ul>
          <li><a href="index.php">Anasayfa</a></li>
          <li><a href="hakkimizda.php">Hakkımızda</a></li>
          <li><a href="misyon.php">Misyon</a></li>
          <li><a href="vizyon.php">Vizyon</a></li>
          <li><a href="iletisim.php">İletişim</a></li>
          <li><a href="login.php" class="active">Giriş</a></li>
        </ul>
      </nav>
    </header>

    <main id="content">
      <h2>Kullanıcı Girişi</h2>
      <?php if ($hata): ?>
        <p style="color:crimson; font-weight:bold;"><?php echo $hata; ?></p>
      <?php endif; ?>
      <div class="form-card">
        <form id="login-form" action="login.php" method="post" novalidate>
          <label for="kadi">Kullanıcı Adı</label>
          <input id="kadi" name="kadi" type="text" required placeholder="Kullanıcı adınız">

          <label for="sifre">Şifre</label>
          <input id="sifre" name="sifre" type="password" required placeholder="Şifreniz">

          <div class="form-actions">
            <button type="submit" class="btn">Giriş Yap</button>
            <a href="iletisim.php" class="btn secondary">Şifremi Unuttum</a>
          </div>
        </form>
      </div>
    </main>

    <footer id="footer">
      <p>© <?php echo date('Y'); ?> MSB Library</p>
    </footer>
  </div>
</body>
</html>
