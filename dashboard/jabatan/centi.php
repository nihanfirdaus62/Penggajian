<?php
session_start();

if (!isset($_SESSION["username"]) || $_SESSION["jabatan"] !== "Bendahara") {
    header("Location: ../../sign-in/index.php");
    exit();
}

$add_errors = [];
$form_data = ["nama_jabatan" => "", "gaji" => ""];
if (isset($_POST["btnsv"]) && isset($_GET["1"]) && $_GET["1"] == "tambah") {
    require "../../config.php";

    $nama_jabatan = trim($_POST["nama_jabatan"] ?? "");
    $gaji = $_POST["gaji"] ?? "";

    if (empty($nama_jabatan) || strlen($nama_jabatan) < 2) {
        $add_errors[] = "Jabatan harus diisi dan minimal 2 karakter.";
    }

    if (empty($add_errors)) {
        $checkSql =
            "SELECT nama_jabatan FROM jabatan WHERE nama_jabatan = :nama_jabatan";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->bindParam(":nama_jabatan", $nama_jabatan, PDO::PARAM_STR);
        $checkStmt->execute();
        if ($checkStmt->rowCount() > 0) {
            $dup = $checkStmt->fetch(PDO::FETCH_ASSOC);
            if ($dup["nama_jabatan"] === $nama_jabatan) {
                $add_errors[] = "Jabatan sudah terdaftar.";
            }
        }
    }

    if (empty($add_errors)) {
        $sql =
            "INSERT INTO jabatan (nama_jabatan, gaji) VALUES (:nama_jabatan, :gaji)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":nama_jabatan", $nama_jabatan, PDO::PARAM_STR);
        $stmt->bindParam(":gaji", $gaji, PDO::PARAM_STR);

        if ($stmt->execute()) {
            header("Location: Jabatan.php?success=added");
            $_SESSION["status"] = "Data jabatan berhasil ditambahkan.";
            exit();
        } else {
            $add_errors[] = "Gagal menyimpan data. Coba lagi.";
        }
    } else {
        $form_data["nama_jabatan"] = $nama_jabatan;
        $form_data["gaji"] = $gaji;
    }
}

$edit_errors = [];
$edit_form_data = ["nama_jabatan" => "", "gaji" => ""];
if (isset($_POST["btnsv"]) && isset($_GET["nama_jabatan"])) {
    require "../config.php";
    $nama_jabatan_old = trim($_GET["nama_jabatan"]);

    $sql = "SELECT * FROM jabatan WHERE nama_jabatan = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nama_jabatan_old]);
    $sqlJabatan = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$sqlJabatan) {
        header("Location: Jabatan.php?error=not_found");
        exit();
    }

    $nama_jabatan = trim($_POST["nama_jabatan"] ?? "");
    $gaji = trim($_POST["gaji"] ?? "");

    if (empty($nama_jabatan) || strlen($nama_jabatan) < 2) {
        $edit_errors[] = "Jabatan harus diisi dan minimal 2 karakter.";
    }
    if (empty($edit_errors) && $nama_jabatan !== $sqlJabatan["nama_jabatan"]) {
        $checkSql =
            "SELECT nama_jabatan FROM jabatan WHERE nama_jabatan = :nama_jabatan AND nama_jabatan != :old_nama_jabatan";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([
            "nama_jabatan" => $nama_jabatan,
            "old_nama_jabatan" => $sqlJabatan["nama_jabatan"],
        ]);
        if ($checkStmt->rowCount() > 0) {
            $edit_errors[] = "Nama jabatan sudah ada.";
        }
    }

    if (empty($edit_errors)) {
        $updateSql =
            "UPDATE jabatan SET nama_jabatan = :nama_jabatan, gaji = :gaji WHERE nama_jabatan = :old_nama_jabatan";
        $stmt = $pdo->prepare($updateSql);
        $param = [
            "nama_jabatan" => $nama_jabatan,
            "gaji" => $gaji,
            "old_nama_jabatan" => $sqlJabatan["nama_jabatan"],
        ];
        if ($stmt->execute($param)) {
            $_SESSION["status"] = "Data jabatan berhasil diperbarui.";
            header("Location: Jabatan.php");
            exit();
        } else {
            $edit_errors[] = "Gagal memperbarui data jabatan.";
        }
    } else {
        $edit_form_data["nama_jabatan"] = $nama_jabatan;
        $edit_form_data["gaji"] = $gaji;
    }
}
include "../inc/lm.php";
include "../inc/header.php";
include "../inc/pagination.php";
$pagination = new Pagination($pdo);
$pagination->page("jabatan", "nama_jabatan", 5);
?>
