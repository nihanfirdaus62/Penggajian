<?php
include "../inc/lm.php";
include "../inc/header.php";
include "../inc/pagination.php";
$join = "INNER JOIN jabatan ON pegawai.jabatan = jabatan.nama_jabatan";
$pagination = new Pagination($pdo);
$pagination->page("pegawai", "nama", 5, $join);
?>
<div class="container-fluid py-4">
    <div class="col-sm-12 mb-4">
        <div class="card mt-2">
            <div class="card-header sticky-top">
                <h6>Data Pegawai
                        <a href="tambahPegawai.php" class="btn btn-light float-end me-2">+</a>
                </h6>
                <div class="d-flex justify-content-between">
                    <!-- Pagination -->
                    <?php echo $pagination->link("dataPegawai.php"); ?>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-secondary text-xxs text-center font-weight-bolder opacity-7">No</th>
                                <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7">nip</th>
                                <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7 ps-2">Nama</th>
                                <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7 ps-2">Jenis Kelamin</th>
                                <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7 ps-2">Tanggal Lahir</th>
                                <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7 ps-2">No HP</th>
                                <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7 ps-2">Alamat</th>
                                <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7 ps-2">Jabatan</th>
                                <th class="text-uppercase textt-secondart text-xxs text-center font-weight-bolder opacitt-7 ps-2">Gaji</th>
                                <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7 ps-2">Masuk</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pagination->output as $row): ?>
                            <tr>
                                <td class="align-middle text-center">
                                    <p class="font-weight-bold mb-0 text-center"> <?php echo htmlspecialchars(
                                        $pagination->counter++,
                                    ) ?? "N/A"; ?></p>
                                </td>
                                <td class="align-middle text-center">
                                    <p class=" font-weight-bold mb-0 text-center"> <?php echo htmlspecialchars(
                                        $row["nip"] ?? "N/A",
                                    ); ?> </p>
                                </td>

                                <td class="align-middle text-center">
                                    <p class="font-weight-bold mb-0"> <?php echo htmlspecialchars(
                                        $row["nama"] ?? "N/A",
                                    ); ?> </p>
                                </td>

                                <td class="align-middle text-center">
                                    <p class="font-weight-bold mb-0"> <?php echo htmlspecialchars(
                                        $row["jenis_kelamin"] ?? "N/A",
                                    ); ?> </p>
                                    </td>

                                <td class="align-middle text-center">
                                    <p class="font-weight-bold mb-0">
                                        <?php
                                        $tgl = $row["tanggal_lahir"] ?? "";
                                        if ($tgl) {
                                            $date = new DateTime($tgl);
                                            echo $date->format("d/m/Y");
                                        } else {
                                            echo "N/A";
                                        }
                                        ?> </p>
                                    </td>
                                <td class="align-middle text-center">
                                    <p class="font-weight-bold mb-0"> <?php echo htmlspecialchars(
                                        $row["no_hp"] ?? "N/A",
                                    ); ?> </p>
                                </td>

                                <td class="align-middle text-center">
                                    <p class="font-weight-bold mb-0"> <?php echo htmlspecialchars(
                                        $row["alamat"] ?? "N/A",
                                    ); ?> </p>
                                </td>

                                <td class="align-middle text-center">
                                    <p class="font-weight-bold mb-0"> <?php echo htmlspecialchars(
                                        $row["jabatan"] ?? "N/A",
                                    ); ?> </p>
                                </td>

                                <td class="align-middle text-center">
                                    <p class="font-weight-bold mb-0"> <?php echo htmlspecialchars(
                                        $row["gaji"] ?? "N/A",
                                    ); ?> </p>
                                </td>

                                    <td class="align-middle text-center">
                                        <p class="font-weight-bold mb-0"> <?php
                                        $tgl = $row["tanggal_masuk"] ?? "";
                                        if ($tgl) {
                                            $date = new DateTime($tgl);
                                            echo $date->format("d/m/Y");
                                        } else {
                                            echo "N/A";
                                        }
                                        ?></p>
                                </td>

                                <td class="align-middle">
                                    <a href="editPegawai.php?nip=<?php echo urlencode(
                                        $row["nip"],
                                    ); ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                                        Edit
                                    </a>
                                        |
                                    <a href="hapusPegawai.php?nip=<?php echo urlencode(
                                        $row["nip"],
                                    ); ?>" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Hapus user" onclick="event.preventDefault(); confirmDelete(event);">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div

<?php include "../inc/footer.php"; ?>
