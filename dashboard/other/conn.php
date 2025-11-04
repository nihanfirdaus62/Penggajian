<?php
$out = [];
$month_map = [
    "Januari" => "01",
    "Februari" => "02",
    "Maret" => "03",
    "April" => "04",
    "Mei" => "05",
    "Juni" => "06",
    "Juli" => "07",
    "Agustus" => "08",
    "September" => "09",
    "Oktober" => "10",
    "November" => "11",
    "Desember" => "12",
];

try {
    if (!empty($user)) {
        $sql = "SELECT k.nip, k.nama_pegawai, k.nama_jabatan, j.gaji, k.bulan, k.tahun, k.hadir, k.izin, k.sakit, k.tanpa_keterangan
                FROM kehadiran k
                JOIN jabatan j ON k.nama_jabatan = j.nama_jabatan
                WHERE k.nama_pegawai = :nama_pegawai
                ORDER BY CAST(k.tahun AS UNSIGNED),
                         CASE k.bulan
                             WHEN 'Januari' THEN 1
                             WHEN 'Februari' THEN 2
                             WHEN 'Maret' THEN 3
                             WHEN 'April' THEN 4
                             WHEN 'Mei' THEN 5
                             WHEN 'Juni' THEN 6
                             WHEN 'Juli' THEN 7
                             WHEN 'Agustus' THEN 8
                             WHEN 'September' THEN 9
                             WHEN 'Oktober' THEN 10
                             WHEN 'November' THEN 11
                             WHEN 'Desember' THEN 12
                             ELSE 13
                         END";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":nama_pegawai", $user["nama"]);
        $stmt->execute();

        // Fetch rows one by one safely
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $out[] = $row;
        }

        if (empty($out)) {
            $_SESSION["status"] = "Data tidak ditemukan";
        }
    } else {
        $_SESSION["status"] = "Data tidak ditemukan";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
