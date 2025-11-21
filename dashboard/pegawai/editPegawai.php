<?php
$errors = [];
require_once "../inc/sql.php";

$sqlHelper = new SqlHelper($pdo);
$param = trim($_GET["nip"]);
$where = "WHERE nip = ?";
if ($sqlHelper->select("pegawai", $where, "", [$param])) {
    $pegawai = $sqlHelper->get();
}

if ($sqlHelper->select("jabatan", "", "ORDER BY nama_jabatan ASC", [], false)) {
    $options = $sqlHelper->get();
}

if (empty($pegawai)) {
    header("Location: dataPegawai.php?error=not_found");
    exit();
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

    if (empty($nama) || strlen($nama) < 5) {
        $errors["nama"] = " Nama  minimal 5 karakter!.";
    }
    if (!in_array($jenis_kelamin, ["Laki-Laki", "Perempuan"])) {
        $errors["jenis_kelamin"] = "Pilih salah satu jenis kelamin!.";
    }
    if (empty($tanggal_lahir)) {
        $errors["tanggal_lahir"] = "Tanggal lahir harus diisi!.";
    }
    if (empty($no_hp) || !preg_match('/^[0-9]{10,13}$/', $no_hp)) {
        $errors["no_hp"] = "Nomor HP harus angka 10-13 digit!.";
    }
    if (empty($alamat) || strlen($alamat) < 5) {
        $errors["alamat"] = "Alamat harus diisi minimal 5 karakter!.";
    }
    if (empty($jabatan)) {
        $errors["jabatan"] = "Pilih jabatan.";
    }
    if (empty($username) || strlen($username) < 3) {
        $errors["username"] = "minimal 3 karakter.";
    }
    if (!empty($password) && strlen($password) < 6) {
        $errors["password"] =
            "Password baru minimal 6 karakter (kosongkan jika tidak ubah).";
    }
    if (!empty($errors)) {
        $_SESSION["status"] = "Error";
        $_SESSION["status_code"] = "error";
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
            $_SESSION["status_code"] = "success";
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
                    <form action="" method="POST"> <!-- Form Edit -->
                        <p class="text-uppercase text-sm">Informasi pegawai</p>
                        <!-- Start Row -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nip" class="form-control-label"> NIP</label>
                                    <input class="form-control" name="nip" type="text" pattern="[0-9]*" maxlength="13"  value="<?php echo htmlspecialchars(
                                        $pegawai["nip"] ?? "",
                                    ); ?>" readonly>
                                </div>
                            </div>
                             <!--Form Nama -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama" class="form-control-label">Nama</label>
                                    <input class="form-control <?php echo isset(
                                        $errors["nama"],
                                    )
                                        ? "is-invalid"
                                        : ""; ?>" type="text" name="nama"
                                        value="<?php echo htmlspecialchars(
                                            $pegawai["nama"] ?? "",
                                        ); ?>">

                                    <div class="invalid-feedback">
                                        <?php echo htmlspecialchars(
                                            $errors["nama"],
                                        ); ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Form Username -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username" class="form-control-label">Username</label>
                                    <input class="form-control <?php echo isset(
                                        $errors["username"],
                                    )
                                        ? "is-invalid"
                                        : ""; ?>" type="text" name="username"
                                        value="<?php echo htmlspecialchars(
                                            $pegawai["username"] ?? "",
                                        ); ?>">

                                    <div class="invalid-feedback">
                                        <?php echo $errors["username"] ?? ""; ?>
                                    </div>
                                </div>
                            </div>
                             <!-- Form Password -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="form-control-label">Password</label>
                                    <input class="form-control <?php echo isset(
                                        $errors["password"],
                                    )
                                        ? "is-invalid"
                                        : ""; ?>" type="password" name="password">

                                    <div class="invalid-feedback">
                                        <?php echo $errors["password"] ?? ""; ?>
                                    </div>
                                </div>
                            </div>
                            <!--Form Tanggal Lahir-->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tanggal_lahir" class="form-control-label">Tanggal lahir</label>
                                    <input class="form-control <?php echo isset(
                                        $errors["tanggal_lahir"],
                                    )
                                        ? "is-invalid"
                                        : ""; ?>" type="date" name="tanggal_lahir"
                                        value="<?php echo htmlspecialchars(
                                            $pegawai["tanggal_lahir"],
                                        ); ?>">
                                    <div class="invalid-feedback">
                                        <?= $errors["tanggal_lahir"] ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Form Jenis Kelamin -->
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
                        <!-- End Row -->
                        </div>

                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">Informasi Kontak</p>
                        <!-- Start Row -->
                        <div class="row">
                            <!--Form No HP -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_hp" class="form-control-label">Nomor Ponsel</label>
                                    <input class="form-control <?php echo isset(
                                        $errors["no_hp"],
                                    )
                                        ? "is-invalid"
                                        : ""; ?>" type="text" name="no_hp" pattern="[0-9]*" maxlength="13"
                                        value="<?php echo htmlspecialchars(
                                            $pegawai["no_hp"] ?? "",
                                        ); ?>">
                                            <!-- Call Error Message  -->
                                    <div class="invalid-feedback">
                                        <?php echo $errors["no_hp"] ?? ""; ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Form Jabatan -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jabatan" class="form-control-label">Jabatan</label>
                                    <select name="jabatan" id="jabatan" class="form-select ">
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
