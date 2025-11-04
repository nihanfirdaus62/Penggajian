<?php
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["jabatan"] !== "Bendahara") {
    header("Location: ../sign-in/index.php");
    exit();
}
require "../../config.php";
$errors = [];
$pegawai = null;

if (!isset($_GET["nip"]) || empty(trim($_GET["nip"]))) {
    header("Location: dataPegawai.php?error=no_nip");
    exit();
}

$nip = trim($_GET["nip"]);

$sql = "SELECT * FROM pegawai WHERE nip = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_GET["nip"]]);
$pegawai = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pegawai) {
    header("Location: dataPegawai.php?error=not_found");
    exit();
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

    if (empty($nama) || strlen($nama) < 2) {
        $errors[] = "Nama harus diisi dan minimal 2 karakter.";
    }
    if (!in_array($jenis_kelamin, ["Laki-Laki", "Perempuan"])) {
        $errors[] = "Pilih jenis kelamin valid.";
    }
    if (empty($tanggal_lahir)) {
        $errors[] = "Tanggal lahir harus diisi.";
    }
    if (empty($no_hp) || !preg_match('/^[0-9]{10,13}$/', $no_hp)) {
        $errors[] = "Nomor HP harus angka 10-13 digit.";
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
    if (!empty($password) && strlen($password) < 6) {
        $errors[] =
            "Password baru minimal 6 karakter (kosongkan jika tidak ubah).";
    }

    if (empty($errors) && $username !== $pegawai["username"]) {
        $checkSql =
            "SELECT username FROM pegawai WHERE username = :username AND nip != :nip";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute(["username" => $username, "nip" => $nip]);
        if ($checkStmt->rowCount() > 0) {
            $errors[] = "Username sudah digunakan oleh pegawai lain.";
        }
    }
    if (empty($errors)) {
        if (!empty($password)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
        }
        $add = [
            "nama = :nama",
            "jenis_kelamin = :jenis_kelamin",
            "tanggal_lahir = :tanggal_lahir",
            "no_hp = :no_hp",
            "alamat = :alamat",
            "jabatan = :jabatan",
            "username = :username",
        ];

        $param = [
            "nama" => $nama,
            "jenis_kelamin" => $jenis_kelamin,
            "tanggal_lahir" => $tanggal_lahir,
            "no_hp" => $no_hp,
            "alamat" => $alamat,
            "jabatan" => $jabatan,
            "username" => $username,
            "nip" => $nip,
        ];

        if (!empty($password)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $add[] = "password = :password";
            $param["password"] = $hash;
        }
        $updateSql =
            "UPDATE pegawai SET " . implode(", ", $add) . " WHERE nip = :nip";

        $stmt = $pdo->prepare($updateSql);
        if ($stmt->execute($param)) {
            $_SESSION["status"] = "Data pegawai berhasil diperbarui.";
            header("Location: dataPegawai.php");
            exit();
        } else {
            $errors[] = "Gagal memperbarui data pegawai.";
        }
    } else {
        $pegawai["nama"] = $nama;
        $pegawai["jenis_kelamin"] = $jenis_kelamin;
        $pegawai["tanggal_lahir"] = $tanggal_lahir;
        $pegawai["no_hp"] = $no_hp;
        $pegawai["alamat"] = $alamat;
        $pegawai["jabatan"] = $jabatan;
        $pegawai["username"] = $username;
    }
}
?>

<?php
include "../inc/lm.php";
include "../inc/header.php";
?>
<div class="container-fluid py-4"> <!-- Container Fluid - end in footer-->
    <div class="row">
        <div class="col-sm-4 md-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <h6 class="mb-0">Edit Pegawai</h6>
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
                    <form action="" method="POST">
                        <p class="text-uppercase text-sm">Informasi pegawai</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nip" class="form-control-label"> NIP</label>
                                    <input class="form-control" name="nip" type="text" pattern="[0-9]*" maxlength="13"  value="<?php echo htmlspecialchars(
                                        $pegawai["nip"] ?? "",
                                    ); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama" class="form-control-label">Nama</label>
                                    <input class="form-control" type="text" name="nama" value="<?php echo htmlspecialchars(
                                        $pegawai["nama"] ?? "",
                                    ); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username" class="form-control-label">Username</label>
                                    <input class="form-control" type="text" name="username" value="<?php echo htmlspecialchars(
                                        $pegawai["username"] ?? "",
                                    ); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="form-control-label">Password</label>
                                    <input class="form-control" type="password" name="password">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tanggal_lahir" class="form-control-label">Tanggal lahir</label>
                                    <input class="form-control" type="date" name="tanggal_lahir" value="<?php echo htmlspecialchars(
                                        $pegawai["tanggal_lahir"],
                                    ); ?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Jenis Kelamin</label> <br>
                                    <input type="radio" name="jenis_kelamin" id="Laki" value="Laki-Laki"
                                        <?= ($pegawai["jenis_kelamin"] ??
                                            "") ===
                                        "Laki-Laki"
                                            ? "checked"
                                            : "" ?> required>
                                    <label for="Laki">Laki-laki</label>
                                    <input type="radio" name="jenis_kelamin" id="Perempuan" value="Perempuan" class="ms-3"
                                        <?= ($pegawai["jenis_kelamin"] ??
                                            "") ===
                                        "Perempuan"
                                            ? "checked"
                                            : "" ?> required>
                                    <label for="Perempuan">Perempuan</label>
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">Contact Information</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_hp" class="form-control-label">Nomor Ponsel</label>
                                    <input class="form-control" type="text" name="no_hp" pattern="[0-9]*" maxlength="13"  value="<?php echo htmlspecialchars(
                                        $pegawai["no_hp"] ?? "",
                                    ); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jabatan" class="form-control-label">Jabatan</label>
                                    <select name="jabatan" id="jabatan" class="form-select">

                                    <?php foreach ($options as $opt): ?>
                                        <option value="<?= htmlspecialchars(
                                            $opt["nama_jabatan"],
                                        ) ?>"
                                        <?php ($opt["jabatan"] ?? "") ===
                                        $pegawai["jabatan"]
                                            ? "checked"
                                            : ""; ?> >
                                                <?= htmlspecialchars(
                                                    $opt["nama_jabatan"],
                                                ) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="alamat" class="form-control-label">Alamat</label>
                                    <input class="form-control" type="text" name="alamat" value=" <?php echo htmlspecialchars(
                                        $pegawai["alamat"] ?? "",
                                    ); ?> ">
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="btnsv" class="btn btn-primary float-end ms-2">Simpan Data</button>
                        <a href="dataPegawai.php" class="btn btn-secondary float-end ms-2">Batal</a>
                        <a href="hapusPegawai.php?nip=<?php echo urlencode(
                            $pegawai["nip"],
                        ); ?>" class="btn btn-danger float-end ms-2" data-toggle="tooltip" data-original-title="Hapus user" onclick="return confirm('Are you sure you want to delete this item?');">
                            Hapus
                        </a>
                    </form>
                </div>
          </div>
        </div>
      </div>
<?php include "../inc/footer.php"; ?>
