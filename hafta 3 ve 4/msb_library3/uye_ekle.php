<?php
// uye_ekle.php
session_start();
require "config.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: login.php");
    exit;
}

$mesaj = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $kulad   = trim($_POST["kulad"] ?? "");
    $sifre   = trim($_POST["sifre"] ?? "");
    $adsoyad = trim($_POST["adsoyad"] ?? "");
    $email   = trim($_POST["email"] ?? "");
    $rol     = $_POST["rol"] ?? "uye";
    $durum   = $_POST["durum"] ?? "aktif";

    if ($kulad === "" || $sifre === "") {
        $mesaj = "Kullanıcı adı ve şifre zorunludur.";
    } else {
        // daha önce var mı kontrol
        $check = mysqli_prepare($conn, "SELECT id FROM users WHERE kulad = ? LIMIT 1");
        mysqli_stmt_bind_param($check, "s", $kulad);
        mysqli_stmt_execute($check);
        $res = mysqli_stmt_get_result($check);
        if (mysqli_fetch_assoc($res)) {
            $mesaj = "Bu kullanıcı adı zaten var.";
        } else {
            $sifre_md5 = md5($sifre);
            $ins = mysqli_prepare($conn, "INSERT INTO users (kulad, sifre, adsoyad, rol, durum, email) VALUES (?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($ins, "ssssss", $kulad, $sifre_md5, $adsoyad, $rol, $durum, $email);
            mysqli_stmt_execute($ins);

            if (mysqli_stmt_affected_rows($ins) > 0) {
                header("Location: uye_liste.php?ekle=1");
                exit;
            } else {
                $mesaj = "Kayıt eklenirken bir hata oluştu.";
            }
        }
    }
}
?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8">
  <title>Üye Ekle</title>
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
      <h2>Yeni Üye Ekle</h2>
      <?php if ($mesaj): ?>
        <p style="color:red; font-weight:bold;"><?php echo $mesaj; ?></p>
      <?php endif; ?>

      <form method="post" action="" class="form-card">
        <label>Kullanıcı Adı *</label>
        <input type="text" name="kulad" required>

        <label>Şifre *</label>
        <input type="password" name="sifre" required>

        <label>Ad Soyad</label>
        <input type="text" name="adsoyad">

        <label>E-posta</label>
        <input type="email" name="email">

        <label>Rol</label>
        <select name="rol">
          <option value="uye">Üye</option>
          <option value="admin">Admin</option>
        </select>

        <label>Durum</label>
        <select name="durum">
          <option value="aktif">Aktif</option>
          <option value="pasif">Pasif</option>
          <option value="engelli">Engelli</option>
        </select>

        <button type="submit" class="btn">Kaydet</button>
        <a href="uye_liste.php" class="btn secondary">Geri</a>
      </form>
    </main>
  </div>
</body>
</html>
