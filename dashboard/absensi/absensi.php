<?php include "centi.php"; ?>
<div class="container-fluid py-4">
    <div class="row">

        <div class="col-sm-9 mb-4">
            <div class="card mt-2">
                <div class="card-header sticky-top pt-3 pb-0">
                    <h6 class="text-center">Filter Rekap Absensi</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2 pt-0">
                    <form action="" method="post">
                        <div class="row justify-content-center">

                            <div class="col-md-2">
                                <select id="tahun" class="form-select form-select-sm text-center" name="tahun">
                                    <option value="">-- Tahun --</option>
                                    <?php foreach ($tahunOptions as $tahun) { ?>
                                        <option value="<?php echo htmlspecialchars(
                                            $tahun,
                                        ); ?>"><?php echo htmlspecialchars(
    $tahun,
); ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <select id="bulan" class="form-select form-select-sm text-center" name="bulan">
                                    <option value="">-- Bulan --</option>
                                    <?php foreach ($bulanOptions as $bulan) { ?>
                                        <option value="<?php echo htmlspecialchars(
                                            $bulan,
                                        ); ?>"><?php echo htmlspecialchars(
    $bulan,
); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                <button type="submit" name="filter" class="btn btn-outline-dark btn-sm ms-2">Filter</button>
                                <a href="add.php" class="btn btn-outline-dark btn-sm ms-2" data-toggle="tooltip" data-original-title="tambah absensi">Tambah</a>

                            </div>
                        </div>
                        <?php
                        if (
                            isset($_SESSION["status"]) &&
                            $_SESSION["status"]
                        ) { ?>
                            <div class="col-sm-12 mb-4 alert alert-success alert-dismissible fade show" role="alert">
                                <div>
                                    <?php echo htmlspecialchars(
                                        $_SESSION["status"],
                                    ); ?>
                                </div>
                            </div>
                        <?php }
                        unset($_SESSION["status"]);
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php include "tables.php"; ?>
<?php include "get/bulan.php"; ?>
<?php include "../inc/footer.php"; ?>
