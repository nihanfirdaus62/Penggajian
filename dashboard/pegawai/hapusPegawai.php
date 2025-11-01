<?php
session_start();

if (!isset($_SESSION["username"]) || $_SESSION["jabatan"] !== "Bendahara") {
    header("Location: ../../sign-in/index.php");
    exit();
}
require "../../config.php";
if (!isset($_GET["nip"]) || empty($_GET["nip"])) {
    header("Location: dataPegawai.php");
    exit();
}

$nip = $_GET["nip"];
$sql = "DELETE FROM pegawai WHERE nip = :nip";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":nip", $_GET["nip"], PDO::PARAM_STR);

if ($stmt->execute()) {
    $_SESSION["status"] = "Pegawai dengan NIP $nip berhasil dihapus.";
    $_SESSION["status_code"] = "success";
    header("Location: dataPegawai.php");
} else {
    $_SESSION[
        "status"
    ] = "Terjadi kesalahan saat menghapus pegawai dengan NIP $nip.";
    $_SESSION["status_code"] = "error";
    header("Location: dataPegawai.php");
}
exit();
?>
