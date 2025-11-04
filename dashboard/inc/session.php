<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["username"]) || $_SESSION["jabatan"] === "Bendahara") {
    header("Location: ../../sign-in/index.php");
    exit();
}

require "../../config.php";
$current = basename($_SERVER["PHP_SELF"]);
$cut = [
    "index.php" => "Home",
    "datagaji.php" => "Data Gaji",
    "default" => ucwords(str_replace(".php", "", $current)),
];
$display = $cut[$current] ?? $cut["default"];

$sesi = $_SESSION["jabatan"];

$test = [$_SESSION["username"]];
$sql = "SELECT nama, username FROM pegawai WHERE username = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute($test);
$user = $stmt->fetch();
?>
