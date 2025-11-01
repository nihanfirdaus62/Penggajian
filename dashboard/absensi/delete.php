<?php
session_start();

if (!isset($_SESSION["username"]) || $_SESSION["jabatan"] !== "Bendahara") {
    header("Location: ../../sign-in/index.php");
    exit();
}
require "../../config.php";
if (
    isset($_GET["nama_pegawai"]) &&
    isset($_GET["bulan"]) &&
    isset($_GET["tahun"])
) {
    $nama_pegawai = trim($_GET["nama_pegawai"]);
    $bulan = trim($_GET["bulan"]);
    $tahun = trim($_GET["tahun"]);

    $sql =
        "DELETE FROM kehadiran WHERE nama_pegawai = :nama_pegawai AND bulan = :bulan AND tahun = :tahun";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":nama_pegawai", $nama_pegawai, PDO::PARAM_STR);
    $stmt->bindParam(":bulan", $bulan, PDO::PARAM_STR);
    $stmt->bindParam(":tahun", $tahun, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $_SESSION["status"] = " absensi $nama_pegawai berhasil dihapus.";
        $_SESSION["status_code"] = "success";
        header("Location: absensi.php");
    } else {
        $_SESSION[
            "status"
        ] = "Terjadi kesalahan saat menghapus absensi $nama_pegawai.";
        $_SESSION["status_code"] = "error";
        header("Location: absensi.php");
    }
} else {
    $_SESSION["status"] = "Data absensi tidak lengkap.";
    $_SESSION["status_code"] = "error";
    header("Location: absensi.php");
    exit();
}

exit();
?>
