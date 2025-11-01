<div class="row">
    <div class="col-sm-9 mb-4">
        <div class="card mt-2">
            <div class="card-header sticky-top">
                <h6 class="text-center">Rekap Absensi</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-secondary text-xxs text-center font-weight-bolder opacity-7">No</th>
                                    <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7">Nip</th>
                                    <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7 ps-2">Nama</th>
                                    <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7 ps-2">Jenis Kelamin</th>
                                    <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7 ps-2">Jabatan</th>
                                    <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7 ps-2">Hadir</th>
                                    <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7 ps-2">Izin</th>
                                    <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7 ps-2">Sakit</th>
                                    <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7 ps-2">Tanpa Keterangan</th>
                                    <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7 ps-2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($out as $row): ?>
                                <tr>
                                    <td class="align-middle text-center">
                                        <p class="font-weight-bold mb-0 text-center"> <?php echo htmlspecialchars(
                                            $counter++,
                                        ) ?? "N/A"; ?></p>
                                    </td>

                                    <td class="align-middle text-center">
                                        <p class="font-weight-bold mb-0"> <?php echo htmlspecialchars(
                                            $row["nip"] ?? "N/A",
                                        ); ?> </p>
                                    </td>

                                    <td class="align-middle text-center">
                                        <p class="font-weight-bold mb-0"> <?php echo htmlspecialchars(
                                            $row["nama_pegawai"] ?? "N/A",
                                        ); ?> </p>
                                    </td>

                                    <td class="align-middle text-center">
                                        <p class="font-weight-bold mb-0"> <?php echo htmlspecialchars(
                                            $row["jenis_kelamin"] ?? "N/A",
                                        ); ?> </p>
                                        </td>

                                    <td class="align-middle text-center">
                                        <p class="font-weight-bold mb-0"><?php echo htmlspecialchars(
                                            $row["nama_jabatan"] ?? "N/A",
                                        ); ?> </p>
                                        </td>
                                    <td class="align-middle text-center">
                                        <p class="font-weight-bold mb-0"> <?php echo htmlspecialchars(
                                            $row["hadir"] ?? "N/A",
                                        ); ?> </p>
                                    </td>

                                    <td class="align-middle text-center">
                                        <p class="font-weight-bold mb-0"> <?php echo htmlspecialchars(
                                            $row["izin"] ?? "N/A",
                                        ); ?> </p>
                                    </td>

                                    <td class="align-middle text-center">
                                        <p class="font-weight-bold mb-0"> <?php echo htmlspecialchars(
                                            $row["sakit"] ?? "N/A",
                                        ); ?> </p>
                                    </td>

                                    <td class="align-middle text-center">
                                        <p class="font-weight-bold mb-0"> <?php echo htmlspecialchars(
                                            $row["tanpa_keterangan"] ?? "N/A",
                                        ); ?> </p>
                                    </td>

                                    <td class="align-middle">
                                        <a href="delete.php?nama_pegawai=<?php echo urlencode(
                                            $row["nama_pegawai"],
                                        ); ?>&bulan=<?php echo urlencode(
    $row["bulan"],
); ?>&tahun=<?php echo urlencode($row["tahun"]); ?>"
                                               class="text-secondary font-weight-bold text-xs text-danger text-center"
                                               data-toggle="tooltip"
                                               data-original-title="Hapus user"
                                               onclick="return confirm('Are you sure you want to delete this item?');">
                                                Hapus
                                            </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                </div>
            </div
        </div>
    </div>
</div>
