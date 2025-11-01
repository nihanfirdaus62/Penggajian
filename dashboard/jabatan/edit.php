<?php
if (
    empty($edit_errors) &&
    isset($_GET["nama_jabatan"]) &&
    !empty(trim($_GET["nama_jabatan"]))
) {
    require "../../config.php";
    $nama_jabatan_old = trim($_GET["nama_jabatan"]);
    $sql = "SELECT * FROM jabatan WHERE nama_jabatan = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nama_jabatan_old]);
    $jabatan_data = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($jabatan_data) {
        $edit_form_data = array_merge($edit_form_data, $jabatan_data); // Merge with any POST data
    }
} ?>
<div class="col-sm-4 mb-4">
    <div class="card mt-2">
        <div class="card-header sticky-top">
            <h6 class="mb-0">Edit Jabatan</h6>
        </div>
        <div class="card-body">
            <?php if (!empty($edit_errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($edit_errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="nama_jabatan" class="form-label">Jabatan</label>
                    <input type="text" class="form-control" id="nama_jabatan" name="nama_jabatan" value="<?php echo htmlspecialchars(
                        $edit_form_data["nama_jabatan"] ?? "",
                    ); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="gaji" class="form-label">Gaji</label>
                    <input type="number" min="0" step="0.01" class="form-control" id="gaji" name="gaji" value="<?= htmlspecialchars(
                        $edit_form_data["gaji"] ?? "",
                    ) ?>" required>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" name="btnsv" class="btn btn-primary float-end me-2">Simpan Data</button>
                        <a href="Jabatan.php" class="btn btn-secondary ms-2 float-end me-2">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
