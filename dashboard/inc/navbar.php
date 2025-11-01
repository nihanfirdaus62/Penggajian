
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
            <?php if (
                $display === "Edit Pegawai" ||
                $display === "Tambah Pegawai"
            ) { ?>
                <li class="breadcrumb-item text-sm " aria-current="page"><a class="opacity-5 text-white" href="../admin/data.php">Data</a></li>
                <li class="breadcrumb-item text-sm " aria-current="page"><a class="opacity-5 text-white" href="../pegawai/dataPegawai.php">Data Pegawai</a></li>
                <li class="breadcrumb-item text-sm text-white active" aria-current="page"><?php echo htmlspecialchars(
                    $display,
                ); ?></li>
           <?php } elseif ($display === "Data Pegawai") { ?>
                <li class="breadcrumb-item text-sm " aria-current="page"><a class="opacity-5 text-white" href="../admin/data.php">Data</a></li>
                <li class="breadcrumb-item text-sm text-white active" aria-current="page"><?php echo htmlspecialchars(
                    $display,
                ); ?></li>
           <?php } elseif ($display === "Data Jabatan") { ?>
                <li class="breadcrumb-item text-sm " aria-current="page"><a class="opacity-5 text-white" href="../admin/data.php">Data</a></li>
                <li class="breadcrumb-item text-sm text-white active" aria-current="page"><?php echo htmlspecialchars(
                    $display,
                ); ?></li>
           <?php } elseif ($display === "Data") { ?>
                <li class="breadcrumb-item text-sm text-white active" aria-current="page"><?php echo htmlspecialchars(
                    $display,
                ); ?></li>
                <?php } elseif ($display === "Tambah Data") { ?>
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page"><a class="opacity-5 text-white" href="../admin/rekap.php">Rekapitulasi</a></li>
                    <li class="breadcrumb-item text-sm " aria-current="page"><a class="opacity-5 text-white" href="../absensi/absensi.php">Rekap Absensi</a></li>
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page"><?php echo htmlspecialchars(
                        $display,
                    ); ?></li>
                <?php } elseif ($display === "Rekap Absensi") { ?>
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page"><a class="opacity-5 text-white" href="../admin/rekap.php">Rekapitulasi</a></li>
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page"><?php echo htmlspecialchars(
                        $display,
                    ); ?></li>
                <?php } elseif ($display === "Rekap Gaji") { ?>
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page"><a class="opacity-5 text-white" href="../admin/rekap.php">Rekapitulasi</a></li>
                    <li class="breadcrumb-item text-sm text-white active" aria-current="page"><?php echo htmlspecialchars(
                        $display,
                    ); ?></li>
                <?php } else { ?>
                <li class="breadcrumb-item text-sm text-white active" aria-current="page"><?php echo htmlspecialchars(
                    $display,
                ); ?></li>
            <?php } ?>
          </ol>
        </nav>

        <p class="float-end text-white"> <?php
        $test = [$_SESSION["username"]];
        $sql = "SELECT nama, username FROM pegawai WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($test);
        $user = $stmt->fetch();
        echo htmlspecialchars($user["nama"]);
        ?></p>
      </div>

      <a href="../admin/logout.php" class="float-end text-white">Logout</a>
    </nav>
