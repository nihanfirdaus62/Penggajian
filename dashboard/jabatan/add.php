<div class="col-sm-4 mb-4">
    <div class="card mt-2">
        <div class="card-header sticky-top">
            <h6 class="mb-0">Tambah Jabatan</h6>
        </div>
        <div class="card-body">
            <?php if (!empty($add_errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($add_errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="nama_jabatan" class="form-label">Jabatan</label>
                    <input type="text" class="form-control" id="nama_jabatan" name="nama_jabatan" value="<?= htmlspecialchars(
                        $form_data["nama_jabatan"],
                    ) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="gaji" class="form-label">Gaji</label>
                    <input type="text" pattern="[0-9]*" maxlength="13" title="Numeric only!" id="gaji" name="gaji" value="<?= htmlspecialchars(
                        $form_data["gaji"],
                    ) ?>" placeholder="" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" name="btnsv" class="btn btn-primary float-end ms-2">Simpan Data</button>
                        <a href="Jabatan.php" class="btn btn-secondary float-end ms-2">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
