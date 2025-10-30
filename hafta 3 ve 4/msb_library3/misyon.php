<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Misyon - MSB Library</title>
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
          <li><a href="misyon.php" class="active">Misyon</a></li>
          <li><a href="vizyon.php">Vizyon</a></li>
          <li><a href="iletisim.php">İletişim</a></li>
          <li><a href="login.php">Giriş</a></li>
          
        </ul>
      </nav>
    </header>

    <main id="content">
  <h2>Misyonumuz</h2>
  <p>
    MSB Library olarak misyonumuz; öğrencilerin ve araştırmacıların bilgiye erişimini kolaylaştırmak, 
    kaynakları dijital ortamda düzenli ve erişilebilir hale getirmek, teknolojiyi eğitim sürecinin ayrılmaz bir parçası haline getirmektir.
  </p>
  <p>
    Sistemimiz, kütüphane yönetimini dijitalleştirerek zaman tasarrufu sağlar, 
    kitap takibini ve ödünç verme süreçlerini kolaylaştırır, kullanıcı deneyimini iyileştirir.
  </p>
</main>

<footer id="footer">
  <p>© <?php echo date('Y'); ?> MSB Library</p>
</footer>

  </div>
  <script>document.getElementById('year3').textContent = new Date().getFullYear();</script>
</body>
</html>