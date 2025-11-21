<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="false">
  <div class="container-fluid py-1 px-3">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm">
          <a class="opacity-5 text-white" href="javascript:;">Pages</a>
        </li>

        <?php
        $breadcrumbs = [];

        switch ($display) {
            case "Edit Pegawai":
            case "Tambah Pegawai":
                $breadcrumbs = [
                    ["label" => "Data", "link" => "../admin/data.php"],
                    [
                        "label" => "Data Pegawai",
                        "link" => "../pegawai/dataPegawai.php",
                    ],
                    ["label" => $display, "active" => true],
                ];
                break;

            case "Data Pegawai":
            case "Data Jabatan":
                $breadcrumbs = [
                    ["label" => "Data", "link" => "../admin/data.php"],
                    ["label" => $display, "active" => true],
                ];
                break;

            case "Data":
                $breadcrumbs = [["label" => $display, "active" => true]];
                break;

            case "Tambah Data":
                $breadcrumbs = [
                    ["label" => "Rekapitulasi", "link" => "../admin/rekap.php"],
                    [
                        "label" => "Rekap Absensi",
                        "link" => "../absensi/absensi.php",
                    ],
                    ["label" => $display, "active" => true],
                ];
                break;

            case "Rekap Absensi":
            case "Rekap Gaji":
                $breadcrumbs = [
                    ["label" => "Rekapitulasi", "link" => "../admin/rekap.php"],
                    ["label" => $display, "active" => true],
                ];
                break;

            default:
                $breadcrumbs = [["label" => $display, "active" => true]];
                break;
        }

        // Render breadcrumbs
        foreach ($breadcrumbs as $crumb) {
            if (!empty($crumb["active"])) {
                echo '<li class="breadcrumb-item text-sm text-white active" aria-current="page">' .
                    htmlspecialchars($crumb["label"]) .
                    "</li>";
            } else {
                echo '<li class="breadcrumb-item text-sm" aria-current="page">' .
                    '<a class="opacity-5 text-white" href="' .
                    htmlspecialchars($crumb["link"]) .
                    '">' .
                    htmlspecialchars($crumb["label"]) .
                    "</a></li>";
            }
        }
        ?>
      </ol>
    </nav>

    <!-- User and Logout -->

    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
        <div class="d-flex align-items-center ms-auto">
            <p class="mb-0 text-white me-3"><?php echo htmlspecialchars(
                $user["nama"],
            ); ?></p>
        </div>
      <ul class="navbar-nav  justify-content-end">
        <li class="nav-item d-flex align-items-center">
          <a href="javascript:;" class="nav-link text-white font-weight-bold px-0">
            <i class="fa fa-user me-sm-1"></i>
            <span class="d-sm-inline d-none">Logout</span>
          </a>
        </li>
        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
          <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line bg-white"></i>
              <i class="sidenav-toggler-line bg-white"></i>
              <i class="sidenav-toggler-line bg-white"></i>
            </div>
          </a>
      </ul>
    </div>
  </div>
</nav>
