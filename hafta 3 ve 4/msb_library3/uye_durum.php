<?php
session_start();
require "config.php";
if (!isset($_SESSION["user_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: login.php");
    exit;
}

$id = intval($_GET["id"] ?? 0);
$durum = $_GET["durum"] ?? "aktif";

if ($id > 0 && in_array($durum, ["aktif","pasif","engelli"])) {
    $st = mysqli_prepare($conn, "UPDATE users SET durum = ? WHERE id = ?");
    mysqli_stmt_bind_param($st, "si", $durum, $id);
    mysqli_stmt_execute($st);
}
header("Location: uye_liste.php");
exit;
?>
