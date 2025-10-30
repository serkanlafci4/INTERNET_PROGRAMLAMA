<?php
// uye_duzenle.php
session_start();
require "config.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: login.php");
    exit;
}

$id = intval($_GET["id"] ?? 0);
if ($id <= 0) {
    header("Location: uye_liste.php");
    exit;
}

// önce kullanıcıyı çek
$st = mysqli_prepare($conn, "SELECT * FROM users WHERE id = ?");
mysqli_stmt_bind_param($st, "i", $id);
mysqli_stmt_execute($st);
$res = mysqli_stmt_get_result($st);
$uye = mysqli_fetch_assoc($res);

if (!$uye) {
    header("Location: uye_liste.php");
    exit;
}

$mesaj = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $kulad   = trim($_POST["kulad"] ?? "");
    $adsoyad = trim($_POST["adsoyad"] ?? "");
    $email   = trim($_POST["email"] ?? "");
    $rol     = $_POST["rol"] ?? "uye";
    $durum   = $_POST["durum"] ?? "aktif";
    $yeni_sifre = trim($_POST["yeni_sifre"] ?? "");

    if ($kulad === "") {
        $mesaj = "Kullanıcı adı boş olamaz.";
    } else {
        // kullanıcı adı başka birinde var mı kontrol (kendi hariç)
        $chk = mysqli_prepare($conn, "SELECT id FROM users WHERE kulad = ? AND id <> ? LIMIT 1");
        mysqli_stmt_bind_param($chk, "si", $kulad, $id);
        mysqli_stmt_execute($chk);
        $r2 = mysqli_stmt_get_result($chk);
        if (mysqli_fetch_assoc($r2)) {
            $mesaj = "Bu kullanıcı adı başka birinde kayıtlı.";
        } else {
            // update
            $up = mysqli_prepare($conn, "UPDATE users SET kulad=?, adsoyad=?, email=?, rol=?, durum=? WHERE id=?");
            mysqli_stmt_bind_param($up, "sssssi", $kulad, $adsoyad, $email, $rol, $durum, $id);
            mysqli_stmt_execute($up);

            // şifre girilmişse değiştir
            if ($yeni_sifre !== "") {
                $md5 = md5($yeni_sifre);
                $up2 = mysqli_prepare($conn, "UPDATE users SET sifre=? WHERE id=?");
                mysqli_stmt_bind_param($up2, "si", $md5, $id);
                mysqli_stmt_execute($up2);
            }

            header("Location: uye_liste.php?guncellendi=1");
            exit;
        }
    }
}
?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8">
  <title>Üye Düzenle</title>
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
      <h2>Üye Düzenle (#<?php echo $uye["id"]; ?>)</h2>
      <?php if ($mesaj): ?>
        <p style="color:red; font-weight:bold;"><?php echo $mesaj; ?></p>
      <?php endif; ?>

      <form method="post" action="" class="form-card">
        <label>Kullanıcı Adı *</label>
        <input type="text" name="kulad" value="<?php echo htmlspecialchars($uye["kulad"]); ?>" required>

        <label>Ad Soyad</label>
        <input type="text" name="adsoyad" value="<?php echo htmlspecialchars($uye["adsoyad"]); ?>">

        <label>E-posta</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($uye["email"]); ?>">

        <label>Rol</label>
        <select name="rol">
          <option value="uye"   <?php if ($uye["rol"]=="uye")   echo "selected"; ?>>Üye</option>
          <option value="admin" <?php if ($uye["rol"]=="admin") echo "selected"; ?>>Admin</option>
        </select>

        <label>Durum</label>
        <select name="durum">
          <option value="aktif"   <?php if ($uye["durum"]=="aktif")   echo "selected"; ?>>Aktif</option>
          <option value="pasif"   <?php if ($uye["durum"]=="pasif")   echo "selected"; ?>>Pasif</option>
          <option value="engelli" <?php if ($uye["durum"]=="engelli") echo "selected"; ?>>Engelli</option>
        </select>

        <label>Yeni Şifre (boş bırakılırsa değişmez)</label>
        <input type="password" name="yeni_sifre">

        <button type="submit" class="btn">Güncelle</button>
        <a href="uye_liste.php" class="btn secondary">Geri</a>
      </form>
    </main>
  </div>
</body>
</html>
