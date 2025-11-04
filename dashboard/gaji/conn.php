<?php
session_start();

if (!isset($_SESSION["username"]) || $_SESSION["jabatan"] !== "Bendahara") {
    header("Location: ../../sign-in/index.php");
    exit();
}
require "../../config.php";

$bulanOptions = $pdo
    ->query("SELECT DISTINCT bulan FROM kehadiran ORDER BY bulan")
    ->fetchAll(PDO::FETCH_COLUMN);
$tahunOptions = $pdo
    ->query("SELECT DISTINCT tahun FROM kehadiran ORDER BY tahun")
    ->fetchAll(PDO::FETCH_COLUMN);

$out = [];
$counter = 1;

// ... (rest of your code remains the same) ...

try {
    if (isset($_POST["filter"])) {
        $bulan = $_POST["bulan"];
        $tahun = $_POST["tahun"];

        if (!empty($bulan) && !empty($tahun)) {
            $sql = "SELECT k.nip, k.nama_pegawai, k.nama_jabatan, j.gaji, k.hadir
                    FROM kehadiran k
                    JOIN jabatan j ON k.nama_jabatan = j.nama_jabatan
                    WHERE k.bulan = :bulan AND k.tahun = :tahun
                    ORDER BY k.nama_pegawai ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":bulan", $bulan);
            $stmt->bindParam(":tahun", $tahun);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $out = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $_SESSION[
                    "status"
                ] = "Menampilkan Rekap Gaji dari Bulan $bulan Tahun $tahun";
                header(
                    "Location: gaji.php?success=filtered&bulan=$bulan&tahun=$tahun",
                ); // Add redirect
                exit();
            } else {
                $_SESSION["status"] = "Tidak ada data untuk filter tersebut";
            }
        } else {
            $_SESSION["status"] = "Tahun dan Bulan harus diisi";
        }
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $_SESSION["status"] = "Terjadi kesalahan database";
    header("Location: gaji.php?error=failed");
    exit();
}

if (
    isset($_GET["success"]) &&
    $_GET["success"] == "filtered" &&
    isset($_GET["bulan"]) &&
    isset($_GET["tahun"])
) {
    $bulan = $_GET["bulan"];
    $tahun = $_GET["tahun"];
    $sql = "SELECT k.nip, k.nama_pegawai, k.nama_jabatan, j.gaji, k.hadir
            FROM kehadiran k
            JOIN jabatan j ON k.nama_jabatan = j.nama_jabatan
            WHERE k.bulan = :bulan AND k.tahun = :tahun
            ORDER BY k.nama_pegawai ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":bulan", $bulan);
    $stmt->bindParam(":tahun", $tahun);
    $stmt->execute();
    $out = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $counter = 1;
}

include "../inc/lm.php";
include "../inc/header.php";
?>
