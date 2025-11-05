<?php
require "../../config.php";
require_once "../../pdf/tcpdf.php";

$nama = $_GET["nama_pegawai"] ?? null;
$tahun = $_GET["tahun"] ?? null;
$bulan = $_GET["bulan"] ?? null;

$months = [
    1 => "Januari",
    "Februari",
    "Maret",
    "April",
    "Mei",
    "Juni",
    "Juli",
    "Agustus",
    "September",
    "Oktober",
    "November",
    "Desember",
];

$monthName = $months[date("n")];

if (!$nama || !$tahun || !$bulan) {
    $_SESSION["STATUS"] = "Invalid parameters";
    header("location:datagaji.php?error=failed");
    exit();
}

try {
    $sql = "SELECT k.nip, k.nama_pegawai, k.nama_jabatan, j.gaji, k.hadir, k.bulan, k.tahun
            FROM kehadiran k
            JOIN jabatan j ON k.nama_jabatan = j.nama_jabatan
            WHERE k.bulan = :bulan AND k.tahun = :tahun AND k.nama_pegawai = :nama_pegawai
            ORDER BY k.nama_pegawai ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":bulan", $bulan);
    $stmt->bindParam(":tahun", $tahun);
    $stmt->bindParam(":nama_pegawai", $nama);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}

if (empty($data)) {
    $_SESSION["STATUS"] = "No data found";
    header("location:datagaji.php?error=failed");
    exit();
}

// =============================
// Custom TCPDF Class
// =============================
class MYPDF extends TCPDF
{
    public $data;

    public function Header()
    {
        $logo = K_PATH_IMAGES . "logo.png";
        if (file_exists($logo)) {
            $this->Image($logo, 20, 5, 25);
        }

        $this->SetFont("helvetica", "B", 12);
        $this->Cell(0, 6, "MADRASAH ALIYAH", 0, 1, "C");

        $this->SetFont("helvetica", "B", 16);
        $this->Cell(0, 8, "MANABUL ULUM SUKAMAJU", 0, 1, "C");

        $this->SetFont("helvetica", "", 9);
        $this->Cell(
            0,
            5,
            "
            Jln. sukamaju RT 03 RW 04, Kec nyalindung, Sukabumi",
            0,
            1,
            "C",
        );
        $this->Cell(
            0,
            5,
            "Telp. 081214207059 | Email: smpannurlosarang77@gmail.com",
            0,
            1,
            "C",
        );

        $this->Ln(2);
        $this->SetLineWidth(0.8);
        $this->Line(
            15,
            $this->GetY(),
            $this->getPageWidth() - 15,
            $this->GetY(),
        );
        $this->Ln(5);

        // Title
        $this->SetFont("helvetica", "BU", 14);
        $this->Cell(0, 8, "SLIP GAJI GURU", 0, 1, "C");
        $this->Ln(3);
    }
    public function Footer()
    {
        // Position 15 mm from bottom
        $this->SetY(-15);

        // Set font
        $this->SetFont("helvetica", "I", 8);

        // Add your custom footer text (no page numbers)
        $this->Cell(0, 10, "Madrasah Aliyah Manabul Ulum Sukamaju", 0, 0, "L");
        $this->Cell(
            0,
            10,
            "Dicetak oleh sistem, pada waktu: " . date("d/m/Y H:i"),
            0,
            1,
            "R",
        );
    }

    public function cells(
        $spacing = false,
        $labels = [],
        $prefix = ":",
        $values = [],
        $labelWidth = 30,
        $underline = true,
        $border = 0,
        $valueWidth = 100,
    ) {
        $labelHeight = 8;

        foreach ($labels as $i => $lab) {
            if ($spacing) {
                $this->Cell(20, $labelHeight, "", 0, 0);
            }

            // Label
            $this->SetFont("helvetica", "", 15);
            $this->Cell($labelWidth, $labelHeight, $lab, $border, 0, "L");

            // Prefix (: or =)
            $this->SetFont("helvetica", "", 15);
            $this->Cell(10, $labelHeight, $prefix, $border, 0, "C");

            // Value
            $x = $this->GetX();
            $y = $this->GetY();

            $this->SetFont("helvetica", "", 15);
            $this->Cell(
                $valueWidth,
                $labelHeight,
                $values[$i] ?? "",
                $border,
                1,
                "L",
            );

            // Optional underline
            if ($underline) {
                $this->Line(
                    $x,
                    $y + $labelHeight - 2,
                    $x + $valueWidth,
                    $y + $labelHeight - 2,
                );
            }
        }
    }
}

// =============================
// Create PDF
// =============================
$pdf = new MYPDF(
    PDF_PAGE_ORIENTATION,
    PDF_UNIT,
    PDF_PAGE_FORMAT,
    true,
    "UTF-8",
    false,
);
$pdf->data = $data;

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor("SMK");
$pdf->SetTitle("Slip Gaji");
$pdf->SetSubject("Rekapitulasi Gaji");

$pdf->SetMargins(15, 55, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetAutoPageBreak(true, 25);
$pdf->AddPage();

// =============================
// Content Section
// =============================

$pdf->SetAlpha(0.1);
$pdf->Image(K_PATH_IMAGES . "logo.png", 30, 60, 150, 0, "", "", "", false, 300);
$pdf->SetAlpha(1);

$pdf->Ln(10);

$pdf->cells(
    false,
    ["NIP", "Nama", "Jabatan", "Periode"],
    ":",
    [
        $data["nip"],
        $data["nama_pegawai"],
        $data["nama_jabatan"],
        $data["bulan"] . " " . $data["tahun"],
    ],
    35,
    false,
);
$pdf->Ln(10);
$pdf->Line(15, $pdf->GetY(), $pdf->GetX() + 190, $pdf->GetY());
$pdf->Ln(10);

$total = $data["gaji"] * $data["hadir"];

$pdf->cells(
    true,
    ["Gaji Harian", "Kehadiran", "Total (Gaji x Kehadiran)"],
    "=",
    [
        "Rp " . number_format($data["gaji"], 0, ",", "."),
        $data["hadir"],
        "Rp " . number_format($total, 0, ",", "."),
    ],
    55,
    false,
);
$pdf->Ln(40);

$pdf->Cell(
    0,
    10,
    "Nyalindung," . date("d") . " " . $monthName . " " . date("Y"),
    0,
    1,
    "R",
);
$pdf->Cell(168, 10, "Kepala Yayasan,", 0, 1, "R");

$pdf->Ln(15);

$pdf->Cell(0, 10, "________________________", 0, 1, "R");

$pdf->Cell(170, 10, "(Nama Pimpinan)", 0, 1, "R");
$pdf->Ln(5);

$pdf->Output("rekap_gaji_bulan_{$bulan}.pdf", "I");
exit();
?>
