<?php

$limit = 10;
$page =
    isset($_GET["page"]) && is_numeric($_GET["page"]) ? (int) $_GET["page"] : 1;
$offset = ($page - 1) * $limit;

$totalSql = "SELECT COUNT(*) FROM jabatan";
$totalStmt = $pdo->prepare($totalSql);
$totalStmt->execute();
$totalRows = $totalStmt->fetchColumn();
$totalPages = ceil($totalRows / $limit);

$sql =
    "SELECT * FROM jabatan ORDER BY nama_jabatan ASC LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
$stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
$stmt->execute();
$output = [];
$counter = $offset + 1;
if ($stmt->rowCount() > 0) {
    while ($out = $stmt->fetch()) {
        $output[] = $out;
    }
}
?>
