<?php
require "../../config.php";
if (isset($_GET["tahun"]) && !empty($_GET["tahun"])) {
    $tahun = trim($_GET["tahun"]);
    $sql =
        "SELECT DISTINCT bulan FROM kehadiran WHERE tahun = :tahun ORDER BY bulan ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":tahun", $tahun, PDO::PARAM_STR);
    $stmt->execute();

    $bulanOptions = [];
    if ($stmt->rowCount() > 0) {
        $bulanOptions = $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    echo json_encode($bulanOptions);
} else {
    echo json_encode([]);
}
?>
