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
    $nip = trim($_POST["nip"] ?? "");
    $nama = trim($_POST["nama"] ?? "");
    $jenis_kelamin = $_POST["jenis_kelamin"] ?? "";
    $tanggal_lahir = $_POST["tanggal_lahir"] ?? "";
    $no_hp = trim($_POST["no_hp"] ?? "");
    $alamat = trim($_POST["alamat"] ?? "");
    $jabatan = trim($_POST["jabatan"] ?? "");
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if (empty($nip) || !preg_match('/^[0-9]{1,13}$/', $nip)) {
        $errors[] = "NIP harus berupa angka (max 13 digit).";
    }
    if (empty($nama) || strlen($nama) < 2) {
        $errors[] = "Nama harus diisi dan minimal 2 karakter.";
    }
    if (!in_array($jenis_kelamin, ["Laki-Laki", "Perempuan"])) {
        $errors[] = "Pilih jenis kelamin yang valid.";
    }
    if (empty($tanggal_lahir)) {
        $errors[] = "Tanggal lahir harus diisi.";
    }
    if (empty($no_hp) || !preg_match('/^[0-9]{10,13}$/', $no_hp)) {
        $errors[] = "Nomor HP harus berupa angka (10-13 digit).";
    }
    if (empty($alamat) || strlen($alamat) < 5) {
        $errors[] = "Alamat harus diisi dan minimal 5 karakter.";
    }
    if (empty($jabatan)) {
        $errors[] = "Pilih jabatan.";
    }
    if (empty($username) || strlen($username) < 3) {
        $errors[] = "Username harus diisi dan minimal 3 karakter.";
    }
    if (empty($password) || strlen($password) < 6) {
        $errors[] = "Password harus minimal 6 karakter.";
    }

    if (empty($errors)) {
        $checkSql =
            "SELECT nip, username FROM pegawai WHERE nip = :nip OR username = :username";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->bindParam(":nip", $nip, PDO::PARAM_STR);
        $checkStmt->bindParam(":username", $username, PDO::PARAM_STR);
        $checkStmt->execute();
        if ($checkStmt->rowCount() > 0) {
            $dup = $checkStmt->fetch(PDO::FETCH_ASSOC);
            if ($dup["nip"] === $nip) {
                $errors[] = "NIP sudah terdaftar.";
            } elseif ($dup["username"] === $username) {
                $errors[] = "Username sudah digunakan.";
            }
        }
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO pegawai (nip, nama, jenis_kelamin, tanggal_lahir, no_hp, alamat, jabatan, username, password)
                VALUES (:nip, :nama, :jenis_kelamin, :tanggal_lahir, :no_hp, :alamat, :jabatan, :username, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":nip", $nip, PDO::PARAM_STR);
        $stmt->bindParam(":nama", $nama, PDO::PARAM_STR);
        $stmt->bindParam(":jenis_kelamin", $jenis_kelamin, PDO::PARAM_STR);
        $stmt->bindParam(":tanggal_lahir", $tanggal_lahir, PDO::PARAM_STR);
        $stmt->bindParam(":no_hp", $no_hp, PDO::PARAM_STR);
        $stmt->bindParam(":alamat", $alamat, PDO::PARAM_STR);
        $stmt->bindParam(":jabatan", $jabatan, PDO::PARAM_STR);
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->bindParam(":password", $hashedPassword, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $_SESSION["status"] = "Data pegawai berhasil diperbarui.";
            header("Location: dataPegawai.php?success=added");
            exit();
        } else {
            $errors[] = "Gagal menyimpan data. Coba lagi.";
        }
    }
}

$sqlJabatan =
    "SELECT id_jabatan, nama_jabatan FROM jabatan ORDER BY nama_jabatan";
$stmtJabatan = $pdo->prepare($sqlJabatan);
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
        <div class="card mt-2"> <!-- Card untuk form pegawai -->
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
                        <form action="tambahPegawai.php" method="post">
                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP</label>
                                <input type="text" id="nip" name="nip" value="<?= htmlspecialchars(
                                    $_POST["nip"] ?? "",
                                ) ?>"
                                    placeholder="123" pattern="[0-9]*" maxlength="13" class="form-control"
                                    title="Numeric only!" required>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    value="<?= htmlspecialchars(
                                        $_POST["nama"] ?? "",
                                    ) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label> <br>
                                <input type="radio" name="jenis_kelamin" id="Laki" value="Laki-Laki"
                                    <?= ($_POST["jenis_kelamin"] ?? "") ===
                                    "Laki-Laki"
                                        ? "checked"
                                        : "" ?> required>
                                <label for="Laki">Laki-laki</label>
                                <input type="radio" name="jenis_kelamin" id="Perempuan" value="Perempuan" class="ms-3"
                                    <?= ($_POST["jenis_kelamin"] ?? "") ===
                                    "Perempuan"
                                        ? "checked"
                                        : "" ?> required>
                                <label for="Perempuan">Perempuan</label>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                    value="<?= htmlspecialchars(
                                        $_POST["tanggal_lahir"] ?? "",
                                    ) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">Nomor Ponsel</label>
                                <input type="text" pattern="[0-9]*" maxlength="13" title="Numeric only!"
                                    id="no_hp" name="no_hp" value="<?= htmlspecialchars(
                                        $_POST["no_hp"] ?? "",
                                    ) ?>"
                                    placeholder="081122223333" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat"
                                    value="<?= htmlspecialchars(
                                        $_POST["alamat"] ?? "",
                                    ) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <select name="jabatan" id="jabatan" class="form-select" required>
                                    <option value="">Pilih Jabatan...</option>
                                    <?php foreach ($options as $opt): ?>
                                        <option value="<?= htmlspecialchars(
                                            $opt["nama_jabatan"],
                                        ) ?>"
                                                <?= ($_POST["jabatan"] ??
                                                    "") ===
                                                $opt["nama_jabatan"]
                                                    ? "selected"
                                                    : "" ?>>
                                            <?= htmlspecialchars(
                                                $opt["nama_jabatan"],
                                            ) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    value="<?= htmlspecialchars(
                                        $_POST["username"] ?? "",
                                    ) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" name="btnsv" class="btn btn-primary">Simpan Data</button>
                            <a href="dataPegawai.php" class="btn btn-secondary ms-2">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "../inc/footer.php"; ?>
