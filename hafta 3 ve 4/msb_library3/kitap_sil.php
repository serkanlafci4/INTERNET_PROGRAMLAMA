<?php
// kitap_sil.php
session_start();
require "config.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: login.php");
    exit;
}

$id = intval($_GET["id"] ?? 0);

if ($id > 0) {
    // Dilersen "sil" yerine durum='silindi' de yapabilirsin
    // $st = mysqli_prepare($conn, "UPDATE kitaplar SET durum='silindi' WHERE id=?");
    $st = mysqli_prepare($conn, "DELETE FROM kitaplar WHERE id = ?");
    mysqli_stmt_bind_param($st, "i", $id);
    mysqli_stmt_execute($st);
}

header("Location: kitap_liste.php");
exit;
?>
