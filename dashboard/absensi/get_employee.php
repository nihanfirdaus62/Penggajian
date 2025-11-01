<?php
require "../../config.php";

if (isset($_GET["nama"]) && !empty($_GET["nama"])) {
    $nama = trim($_GET["nama"]);

    $sql =
        "SELECT nip, jenis_kelamin, jabatan FROM pegawai WHERE nama = :nama LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":nama", $nama, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($data); // Return as JSON
    } else {
        echo json_encode(["error" => "No data found for this NIP"]);
    }
} else {
    echo json_encode(["error" => "Invalid NIP"]);
}
?>
