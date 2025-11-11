<?php include "centi.php"; ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-sm-6 mb-4">
            <div class="card mt-2">
                <div class="card-header sticky-top">
                    <h6>Data Jabatan
                        <?php if (!isset($_GET["1"])) { ?> <br>
                        <a href="Jabatan.php?1=tambah" class="btn btn-light float-end me-2" data-toggle="tooltip" data-original-title="Edit user">+</a>
                       <?php } ?>
                    </h6>
                    <div class="d-flex justify-content-between">
                        <!-- Pagination -->
                        <?php echo $pagination->link("Jabatan.php"); ?>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <?php if (
                        isset($_SESSION["status"]) &&
                        $_SESSION["status"] != ""
                    ) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION["status"]; ?>
                        </div>
                    <?php } ?>
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-secondary text-xxs text-center font-weight-bolder opacity-7">No</th>
                                    <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7">nama jabatan</th>
                                    <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7 ps-2">Gaji</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pagination->output as $row): ?>
                                    <tr>
                                        <td class="align-middle text-center">
                                            <p class="font-weight-bold mb-0 text-center"><?php echo htmlspecialchars(
                                                $pagination->counter++,
                                            ) ?? "N/A"; ?></p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <p class="font-weight-bold mb-0 text-center"><?php echo htmlspecialchars(
                                                $row["nama_jabatan"] ?? "N/A",
                                            ); ?></p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <p class="font-weight-bold mb-0">
                                                <?php
                                                $gaji = $row["gaji"] ?? 0;
                                                echo $gaji
                                                    ? "Rp " .
                                                        number_format(
                                                            $gaji,
                                                            0,
                                                            ",",
                                                            ".",
                                                        ) .
                                                        ",00"
                                                    : "N/A";
                                                ?>
                                            </p>
                                        </td>
                                        <td class="text-center" style="text-align: right;">
                                            <a href="Jabatan.php?nama_jabatan=<?php echo urlencode(
                                                $row["nama_jabatan"],
                                            ); ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">Edit</a>
                                            |
                                            <a href="delete.php?nama_jabatan=<?php echo urlencode(
                                                $row["nama_jabatan"],
                                            ); ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Hapus user" onclick="return confirm('Are you sure you want to delete this item?');">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php if (isset($_GET["1"])) {
            include "add.php";
        } elseif (isset($_GET["nama_jabatan"])) {
            include "edit.php";
        } ?>
    </div>
</div>
<?php include "../inc/footer.php"; ?>
