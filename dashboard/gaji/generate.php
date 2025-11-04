<?php
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["jabatan"] !== "Bendahara") {
    header("Location: ../../sign-in/index.php");
    exit();
}
require "../../config.php";
require_once "../../pdf/tcpdf.php";

$bulan = $_GET["bulan"] ?? null;
if (!$bulan) {
    $_SESSION["status"] = "Pilih bulan untuk mencetak PDF";
    header("Location: gaji.php?error=failed");
    exit();
}
try {
    $sql = "SELECT k.nip, k.nama_pegawai, k.nama_jabatan, j.gaji, k.hadir
            FROM kehadiran k
            JOIN jabatan j ON k.nama_jabatan = j.nama_jabatan
            WHERE k.bulan = :bulan
            ORDER BY k.bulan ASC, k.nama_pegawai ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":bulan", $bulan);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
if (empty($data)) {
    $_SESSION["status"] = "Tidak ada data untuk bulan tersebut";
    header("Location: gaji.php?error=failed");
    exit();
}

$pdf = new TCPDF(
    PDF_PAGE_ORIENTATION,
    PDF_UNIT,
    PDF_PAGE_FORMAT,
    true,
    "UTF-8",
    false,
);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor("SMK");
$pdf->SetTitle("Rekap Gaji Bulanan");
$pdf->SetSubject("Rekapitulasi Gaji Pegawai per bulan");

$pdf->SetMargins(15, 27, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(true, 25);
$pdf->AddPage();

$pdf->SetFont("helvetica", "", 12);
$pdf->Cell(0, 10, "PT. Contoh Perusahaan", 0, 1, "C");
$pdf->Cell(0, 10, "Rekapitulasi Gaji Karyawan Bulanan", 0, 1, "C");
$pdf->Cell(0, 10, "bulan: $bulan", 0, 1, "C");
$pdf->Cell(0, 10, "Tanggal: " . date("d-m-Y"), 0, 1, "C");

$pdf->Ln(10);

// Table header
$pdf->SetFont("helvetica", "B", 10);
$header = ["No", "NIP", "Nama", "Jabatan", "Gaji", "Kehadiran", "Total Gaji"];
$w = [10, 25, 40, 30, 25, 20, 30];

foreach ($header as $i => $h) {
    $pdf->Cell($w[$i], 7, $h, 1, 0, "C");
}
$pdf->Ln();

// Table data
$pdf->SetFont("helvetica", "", 9);
$counter = 1;
foreach ($data as $row) {
    $totalGaji = $row["gaji"] * $row["hadir"];
    $pdf->Cell($w[0], 6, $counter++, 1, 0, "C");
    $pdf->Cell($w[1], 6, $row["nip"], 1, 0, "C");
    $pdf->Cell($w[2], 6, $row["nama_pegawai"], 1, 0, "L");
    $pdf->Cell($w[3], 6, $row["nama_jabatan"], 1, 0, "L");
    $pdf->Cell($w[4], 6, number_format($row["gaji"], 0, ",", "."), 1, 0, "R");
    $pdf->Cell($w[5], 6, $row["hadir"], 1, 0, "C");
    $pdf->Cell($w[6], 6, number_format($totalGaji, 0, ",", "."), 1, 0, "R");

    $pdf->Ln();
}

$pdf->Ln(20);

$left_col_width = 80; // Adjust as needed
$right_col_width = 0; // 0 will extend to the right margin

// ----- First Signature Block -----

// Dibuat oleh (Left)
$pdf->Cell($left_col_width, 10, "Dibuat oleh,", 0, 0, "L");

// Disetujui oleh (Right, aligned to the end)
$pdf->Cell($right_col_width, 10, "Disetujui oleh,", 0, 1, "R");

$pdf->Ln(15);

// Left signature line
$pdf->Cell($left_col_width, 10, "____________________", 0, 0, "L");

// Right signature line
$pdf->Cell($right_col_width, 10, "____________________", 0, 1, "R");

// Left name
$pdf->Cell($left_col_width, 10, "(Nama Bendahara)", 0, 0, "L");

// Right name
$pdf->Cell($right_col_width, 10, "(Nama Pimpinan)", 0, 1, "R");

// ----- Second Signature Block (using the same logic) -----

$pdf->Output("rekap_gaji_bulan $bulan.pdf", "I");
exit();
?>
