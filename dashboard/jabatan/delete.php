<?php
session_start();

if (!isset($_SESSION["username"]) || $_SESSION["jabatan"] !== "Bendahara") {
    header("Location: ../../sign-in/index.php");
    exit();
}
require "../../config.php";
if (!isset($_GET["nama_jabatan"]) || empty($_GET["nama_jabatan"])) {
    header("Location: Jabatan.php");
    exit();
}

$nama_jabatan = $_GET["nama_jabatan"];
$sql = "DELETE FROM jabatan WHERE nama_jabatan = :nama_jabatan";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":nama_jabatan", $nama_jabatan, PDO::PARAM_STR);

if ($stmt->execute()) {
    $_SESSION["status"] = "Jabatan $nama_jabatan berhasil dihapus.";
    $_SESSION["status_code"] = "success";
    header("Location: Jabatan.php");
} else {
    $_SESSION[
        "status"
    ] = "Terjadi kesalahan saat menghapus Jabatan $nama_jabatan.";
    $_SESSION["status_code"] = "error";
    header("Location: Jabatan.php");
}
exit();
?>
