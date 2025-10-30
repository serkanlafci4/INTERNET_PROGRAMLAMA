<?php
// uye_sil.php
session_start();
require "config.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["rol"] !== "admin") {
    header("Location: login.php");
    exit;
}

$id = intval($_GET["id"] ?? 0);
if ($id > 0) {
    $st = mysqli_prepare($conn, "DELETE FROM users WHERE id = ?");
    mysqli_stmt_bind_param($st, "i", $id);
    mysqli_stmt_execute($st);
}

header("Location: uye_liste.php");
exit;
?>
