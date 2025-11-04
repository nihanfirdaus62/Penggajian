<?php
include "../inc/session.php";
include "conn.php";
include "../inc/header.php";
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Data Gaji</h5>
                </div>
                <div class="card-body">
                        <table class="table table-striped table-hover text-center">
                            <thead class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                <tr>
                                    <th rowspan="2" class="align-middle opacity-7">Nama</th>
                                    <th rowspan="2" class="align-middle opacity-7">Gaji Harian</th>
                                    <th rowspan="2" class="align-middle opacity-7 border-bottom">Tanggal (Bulan dan Tahun)</th>
                                    <th colspan="4" class="align-middle opacity-7 border-bottom">Kehadiran</th>
                                    <th rowspan="2" class="align-middle opacity-7">Total Gaji</th>
                                    <th rowspan="2" class="align-middle opacity-7">Print</th>
                                </tr>
                                <tr>
                                    <th class="opacity-7 text-xs">Hadir</th>
                                    <th class="opacity-7 text-xs">Izin</th>
                                    <th class="opacity-7 text-xs">Sakit</th>
                                    <th class="opacity-7 text-xs">Tanpa Keterangan</th>
                                </tr>
                        </thead>
                        <tbody>
                            <div class="align-middle text-center font-weight-bold mb-0">
                                <?php foreach ($out as $pegawai): ?>
                                    <tr>

                                        <!-- NAMA -->
                                        <td>
                                            <p class="mb-0" >
                                                <?php echo htmlspecialchars(
                                                    $pegawai["nama_pegawai"] ??
                                                        "N/A",
                                                ); ?>
                                            </p>
                                        </td>

                                        <!-- Gaji -->
                                        <td>
                                            <p class="mb-0">
                                                <?php
                                                $gaji = $pegawai["gaji"] ?? 0;
                                                echo $gaji
                                                    ? "Rp. " .
                                                        number_format(
                                                            $gaji,
                                                            0,
                                                            ",",
                                                            ".",
                                                        )
                                                    : "";
                                                ?>
                                            </p>
                                        </td>

                                        <!-- Bulan-->
                                        <td>
                                            <p class="mb-0">
                                                <?php
                                                $bulan =
                                                    $month_map[
                                                        $pegawai["bulan"]
                                                    ];
                                                echo htmlspecialchars(
                                                    $bulan .
                                                        "/" .
                                                        $pegawai["tahun"] ??
                                                        "N/A",
                                                );
                                                ?>
                                            </p>
                                        </td>
                                        <td>
                                            <p class="mb-0">
                                               <?php echo htmlspecialchars(
                                                   $pegawai["hadir"] ?? "N/A",
                                               ); ?>
                                            </p>
                                        </td>
                                        <td>
                                            <p class="mb-0">
                                               <?php echo htmlspecialchars(
                                                   $pegawai["izin"] ?? "N/A",
                                               ); ?>
                                            </p>
                                        </td>
                                        <td>
                                            <p class="mb-0">
                                               <?php echo htmlspecialchars(
                                                   $pegawai["sakit"] ?? "N/A",
                                               ); ?>
                                            </p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <p class="mb-0">
                                               <?php echo htmlspecialchars(
                                                   $pegawai[
                                                       "tanpa_keterangan"
                                                   ] ?? "N/A",
                                               ); ?>
                                            </p>
                                        </td>
                                        <td>
                                            <p class="mb-0">
                                                <?php
                                                $total =
                                                    $pegawai["gaji"] *
                                                    $pegawai["hadir"];

                                                echo $total
                                                    ? "Rp. " .
                                                        number_format(
                                                            $total,
                                                            0,
                                                            ",",
                                                            ".",
                                                        )
                                                    : "";
                                                ?>
                                            </p>
                                        </td>

                                        <td>
                                             <a href="generate.php?nama_pegawai=<?= $pegawai[
                                                 "nama_pegawai"
                                             ] ?>&bulan=<?= $pegawai[
    "bulan"
] ?>&tahun=<?= $pegawai[
    "tahun"
] ?>" class="float-end btn btn-outline-primary btn-sm font-weight-bold mb-0">Print</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </div>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
