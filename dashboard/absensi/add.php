<?php
session_start();

if (!isset($_SESSION["username"]) || $_SESSION["jabatan"] !== "Bendahara") {
    header("Location: ../../sign-in/index.php");
    exit();
}

require "../../config.php";
$errors = [];
$success = false;

if (isset($_POST["btnsv"])) {
    $bulan = $_POST["bulan"] ?? "";
    $tahun = $_POST["tahun"] ?? "";
    $nip = trim($_POST["nip"] ?? "");
    $nama = trim($_POST["nama"] ?? "");
    $jenis_kelamin = $_POST["jenis_kelamin"] ?? "";
    $nama_jabatan = $_POST["jabatan"] ?? "";
    $hadir = $_POST["hadir"] ?? "";
    $izin = trim($_POST["izin"] ?? "");
    $sakit = trim($_POST["sakit"] ?? "");
    $tanpa_keterangan = trim($_POST["tanpa_keterangan"] ?? "");

    $sql = "INSERT INTO kehadiran (bulan, tahun, nip, nama_pegawai, jenis_kelamin, nama_jabatan, hadir, izin, sakit, tanpa_keterangan)
                VALUES (:bulan, :tahun, :nip, :nama, :jenis_kelamin, :nama_jabatan, :hadir, :izin, :sakit, :tanpa_keterangan)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":bulan", $bulan, PDO::PARAM_STR);
    $stmt->bindParam(":tahun", $tahun, PDO::PARAM_STR);
    $stmt->bindParam(":nip", $nip, PDO::PARAM_STR);
    $stmt->bindParam(":nama", $nama, PDO::PARAM_STR);
    $stmt->bindParam(":jenis_kelamin", $jenis_kelamin, PDO::PARAM_STR);
    $stmt->bindParam(":nama_jabatan", $nama_jabatan, PDO::PARAM_STR);
    $stmt->bindParam(":hadir", $hadir, PDO::PARAM_STR);
    $stmt->bindParam(":izin", $izin, PDO::PARAM_STR);
    $stmt->bindParam(":sakit", $sakit, PDO::PARAM_STR);
    $stmt->bindParam(":tanpa_keterangan", $tanpa_keterangan, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $_SESSION["status"] = "Data berhasil diperbarui.";
        header("Location: absensi.php?success=added");
        exit();
    } else {
        $errors[] = "Gagal menyimpan data. Coba lagi.";
    }
}

$sqlse = "SELECT * FROM pegawai ";
$stmtJabatan = $pdo->prepare($sqlse);
$stmtJabatan->execute();
$options = [];
if ($stmtJabatan->rowCount() > 0) {
    while ($row = $stmtJabatan->fetch(PDO::FETCH_ASSOC)) {
        $options[] = $row;
    }
}
include "../inc/lm.php";
include "../inc/header.php";
?>
<div class="container-fluid py-4"> <!-- Container Fluid - end in footer-->
    <div class="col-sm-4 mb-4">
        <div class="card mt-2">
            <div class="row">
                <div class="col-md-16">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <h6 class="mb-0">Tambah Pegawai</h6>
                    </div>
                </div>
                    <div class="card-body">
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?= htmlspecialchars($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="bulan" class="form-label">Bulan</label>
                                    <select class="form-select" id="bulan" name="bulan" required>
                                        <option value="">Pilih Bulan</option>
                                        <option value="Januari">Januari</option>
                                        <option value="Februari">Februari</option>
                                        <option value="Maret">Maret</option>
                                        <option value="April">April</option>
                                        <option value="Mei">Mei</option>
                                        <option value="Juni">Juni</option>
                                        <option value="Juli">Juli</option>
                                        <option value="Agustus">Agustus</option>
                                        <option value="September">September</option>
                                        <option value="Oktober">Oktober</option>
                                        <option value="November">November</option>
                                        <option value="Desember">Desember</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="tahun" class="form-label">Tahun</label>
                                    <input type="text" maxlength="4" pattern="[0-9]*" title="Masukkan tahun dalam format 4 digit" class="form-control" id="tahun" name="tahun"
                                        value="<?= htmlspecialchars(
                                            $_POST["tahun"] ?? "",
                                        ) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="nip" class="form-label">NIP</label>
                                    <select name="nip" id="nip" class="form-select" disabled>
                                        <option value="">Pilih NIP...</option>
                                        <?php foreach ($options as $opt): ?>
                                            <option value="<?= htmlspecialchars(
                                                $opt["nip"],
                                            ) ?>">
                                                <?= htmlspecialchars(
                                                    $opt["nip"],
                                                ) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="nama" class="form-label">Nama</label>
                                    <select name="nama" id="nama" class="form-select" required>
                                        <option value="">Pilih Nama...</option>
                                        <?php foreach ($options as $opt): ?>
                                            <option value="<?= htmlspecialchars(
                                                $opt["nama"],
                                            ) ?>">
                                                <?= htmlspecialchars(
                                                    $opt["nama"],
                                                ) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" disabled>
                                        <option value="">Pilih Jenis Kelamin...</option>
                                        <?php foreach ($options as $opt): ?>
                                            <option value="<?= htmlspecialchars(
                                                $opt["jenis_kelamin"],
                                            ) ?>">
                                                <?= htmlspecialchars(
                                                    $opt["jenis_kelamin"],
                                                ) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="jabatan" class="form-label">Jabatan</label>
                                    <input type="text" name="jabatan" id="jabatan" class="form-control" value="<?= htmlspecialchars(
                                        $opt["jabatan"],
                                    ) ?>" readonly>

                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm text-center">Absensi</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="hadir" class="form-label">hadir</label>
                                    <input type="text" class="form-control" id="hadir" name="hadir"
                                        value="<?= htmlspecialchars(
                                            $_POST["hadir"] ?? "",
                                        ) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="izin" class="form-label">izin</label>
                                    <input type="text" class="form-control" id="izin" name="izin"
                                        value="<?= htmlspecialchars(
                                            $_POST["izin"] ?? "",
                                        ) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="sakit" class="form-label">sakit</label>
                                    <input type="text" class="form-control" id="sakit" name="sakit"
                                        value="<?= htmlspecialchars(
                                            $_POST["sakit"] ?? "",
                                        ) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="tanpa_keterangan" class="form-label">tanpa keterangan</label>
                                    <input type="text" class="form-control" id="tanpa_keterangan" name="tanpa_keterangan"
                                        value="<?= htmlspecialchars(
                                            $_POST["tanpa_keterangan"] ?? "",
                                        ) ?>" required>
                                </div>
                            </div>
                            <div class="pt-3">
                                <button type="submit" name="btnsv" class="btn btn-outline-primary">Simpan Data</button>
                                <a href="absensi.php" class="btn btn-outline-secondary ms-2">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "get/ehe.php"; ?>
