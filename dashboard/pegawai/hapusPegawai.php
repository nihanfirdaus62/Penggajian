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

try {
    $sql = "DELETE FROM pegawai WHERE nip = :nip";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":nip" => $nip]);

    $db = $pdo->query("SELECT DATABASE()")->fetchColumn();
    $query = "
    SELECT TABLE_NAME
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE COLUMN_NAME = 'nip'
    AND TABLE_SCHEMA = :db
    AND TABLE_NAME != 'pegawai'
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute([":db" => $db]);

    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    foreach ($tables as $table) {
        $del = $pdo->prepare("DELETE FROM `$table` WHERE nip = :nip");
        $del->execute([":nip" => $nip]);
    }

    $pdo->commit();

    $_SESSION[
        "status"
    ] = "Data dengan nip $nip berhasil dihapus dari semua tabel terkait.";
    $_SESSION["status_code"] = "success";
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    $_SESSION["status"] = "Terjadi kesalahan: " . $e->getMessage();
    $_SESSION["status_code"] = "error";
}

header("Location: dataPegawai.php");
exit();
?>
