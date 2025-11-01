<div class="row">
    <div class="col-sm-12">
        <div class="card mt-2">
            <div class="card-header sticky-top">
                <h6 class="text-center">Rekap Gaji</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-secondary text-xxs text-center font-weight-bolder opacity-7">No</th>
                                <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7">NIP</th>
                                <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7 ps-2">Nama</th>
                                <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7 ps-2">Jabatan</th>
                                <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7 ps-2">Gaji</th>
                                <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7 ps-2">Kehadiran</th>
                                <th class="text-uppercase text-secondary text-xxs text-center font-weight-bolder opacity-7 ps-2">Total Gaji</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($out as $row):
                                $totalGaji = $row["gaji"] * $row["hadir"];
                                // Formula: (Gaji) * (Kehadiran)
                                ?>
                            <tr>
                                <td class="align-middle text-center">
                                    <p class="font-weight-bold mb-0 text-center"><?php echo htmlspecialchars(
                                        $counter++,
                                    ); ?></p>
                                </td>
                                <td class="align-middle text-center">
                                    <p class="font-weight-bold mb-0"><?php echo htmlspecialchars(
                                        $row["nip"] ?? "N/A",
                                    ); ?></p>
                                </td>
                                <td class="align-middle text-center">
                                    <p class="font-weight-bold mb-0"><?php echo htmlspecialchars(
                                        $row["nama_pegawai"] ?? "N/A",
                                    ); ?></p>
                                </td>
                                <td class="align-middle text-center">
                                    <p class="font-weight-bold mb-0"><?php echo htmlspecialchars(
                                        $row["nama_jabatan"] ?? "N/A",
                                    ); ?></p>
                                </td>
                                <td class="align-middle text-center">
                                    <p class="font-weight-bold mb-0"><?php echo htmlspecialchars(
                                        number_format(
                                            $row["gaji"] ?? 0,
                                            0,
                                            ",",
                                            ".",
                                        ),
                                    ); ?></p>
                                </td>
                                <td class="align-middle text-center">
                                    <p class="font-weight-bold mb-0"><?php echo htmlspecialchars(
                                        $row["hadir"] ?? 0,
                                    ); ?></p>
                                </td>
                                <td class="align-middle text-center">
                                    <p class="font-weight-bold mb-0"><?php echo htmlspecialchars(
                                        number_format($totalGaji, 0, ",", "."),
                                    ); ?></p>
                                </td>
                            </tr>
                            <?php
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
