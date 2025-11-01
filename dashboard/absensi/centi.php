<?php
session_start();

if (!isset($_SESSION["username"]) || $_SESSION["jabatan"] !== "Bendahara") {
    header("Location: ../sign-in/index.php");
    exit();
}
require "../../config.php";

$bulanOptions = $pdo
    ->query("SELECT DISTINCT bulan FROM kehadiran ORDER BY bulan")
    ->fetchAll(PDO::FETCH_COLUMN);
$tahunOptions = $pdo
    ->query("SELECT DISTINCT tahun FROM kehadiran ORDER BY tahun")
    ->fetchAll(PDO::FETCH_COLUMN);

$sqlse = "SELECT * FROM kehadiran ";
$stmtJabatan = $pdo->prepare($sqlse);
$stmtJabatan->execute();
$options = [];
if ($stmtJabatan->rowCount() > 0) {
    while ($row = $stmtJabatan->fetch(PDO::FETCH_ASSOC)) {
        $options[] = $row;
    }
}

$out = [];
$counter = 1;

try {
    if (isset($_POST["filter"])) {
        $bulan = $_POST["bulan"];
        $tahun = $_POST["tahun"];

        if (!empty($bulan) && !empty($tahun)) {
            $sql =
                "SELECT * FROM kehadiran WHERE tahun = :tahun AND bulan = :bulan";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":tahun", $tahun);
            $stmt->bindParam(":bulan", $bulan);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $out = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $_SESSION[
                    "status"
                ] = "Menampilkan Rekap Absensi dari Bulan $bulan Tahun $tahun";
            } else {
                $_SESSION["status"] = "Gagal menampilkan data";
            }
        } else {
            $_SESSION["status"] = "Tahun dan Bulan harus diisi";
        }
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo "An error occurred while fetching data. Please try again.";
    $out = [];
}
include "../inc/lm.php";
include "../inc/header.php";
?>
