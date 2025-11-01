<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["username"]) || $_SESSION["jabatan"] !== "Bendahara") {
    header("Location: ../../sign-in/index.php");
    exit();
}

require "../../config.php";
$current = basename($_SERVER["PHP_SELF"]);
$cut = [
    "index.php" => "Home",
    "dataPegawai.php" => "Data Pegawai",
    "tambahPegawai.php" => "Tambah Pegawai",
    "profile.php" => "Profile",
    "editPegawai.php" => "Edit Pegawai",
    "Jabatan.php" => "Data Jabatan",
    "data.php" => "Master data",
    "rekap.php" => "Rekapitulasi",
    "absensi.php" => "Rekap Absensi",
    "add.php" => "Tambah Data",
    "gaji.php" => "Rekap Gaji",
    "default" => ucwords(str_replace(".php", "", $current)),
];
$display = $cut[$current] ?? $cut["default"];

$sesi = $_SESSION["jabatan"];
?>
