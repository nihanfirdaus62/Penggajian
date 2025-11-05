<?php include "../inc/lm.php"; ?>
<?php include "../inc/header.php"; ?>
<?php
$sql = "SELECT 'total_pegawai' as label, count(*) as count FROM pegawai
        UNION
        SELECT 'total_jabatan' as label, count(*) as count FROM jabatan
        UNION
        SELECT 'Total_kehadiran' as label, count(*) as count FROM kehadiran";
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$counts = array_column($results, "count", "label");
$total_pegawai = $counts["total_pegawai"];
$total_jabatan = $counts["total_jabatan"];
$total_kehadiran = $counts["Total_kehadiran"];
?>
<!-- body -->
<div class="container-fluid py-4"> <!-- Container Fluid - end in footer-->
      <div class="row"> <!-- Kotak kotak di atas -->
          <p class="text-uppercase text-lg mb-0 font-weight-bold">Dashboard</p>
        <p><span id="current-datetime"></span></p>
        <?php if ($_SESSION["jabatan"] == "Bendahara") { ?>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4 ms-10">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Jumlah pegawai</p>
                    <h5 class="font-weight-bolder">
                    <?php echo $total_pegawai; ?>
                    </h5>
                    <p class="mb-0">
                      <span class="text-success text-sm font-weight-bolder"></span>
                      <a href="../pegawai/dataPegawai.php">Lihat </a>
                    </p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Jumlah Jabatan</p>
                    <h5 class="font-weight-bolder">
                    <?php echo $total_jabatan; ?>
                    </h5>
                    <p class="mb-0">
                      <span class="text-success text-sm font-weight-bolder"><a href="../jabatan/jabatan.php">Lihat</a></span>

                    </p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Kehadiran</p>
                    <h5 class="font-weight-bolder">
                      <?php echo $total_kehadiran; ?>
                    </h5>
                    <p class="mb-0">
                      <span class="text-danger text-sm font-weight-bolder"><a href="absensi/absensi.php">Lihat  </a></span>
                    </p>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
<?php } ?>
      <script>
      function updateDateTime() {
        const now = new Date();
        const options = {
          year: 'numeric',
          month: 'long',
          day: 'numeric',
          hour: '2-digit',
          minute: '2-digit',
          second: '2-digit'
        };
        const formattedDateTime = now.toLocaleDateString('en-US', options);
        document.getElementById('current-datetime').textContent = formattedDateTime;
      }

      // Update the time immediately and then every second
      updateDateTime();
      setInterval(updateDateTime, 1000);
      </script>
<?php include "../inc/footer.php"; ?>
