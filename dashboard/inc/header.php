<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
} ?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/icon/apple-touch-icon.png">
  <link rel="icon" type="image/png" href="../../assets/img/icon/favicon.ico">
  <link rel="icon" type="image/png" sizes="32x32" href="../../assets/img/icon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../../assets/img/icon/favicon-16x16.png">
  <title>
   Penggajian
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- CSS Files -->
  <link id="pagestyle" href="../../assets/css/dashboard.min.css" rel="stylesheet"/>
  <link id="pagestyle" href="../../assets/css/pagination.css" rel="stylesheet"/>
</head>

<body class="g-sidenav-show   bg-gray-100">
<div class="min-height-300 bg-dark position-absolute w-100"></div>
<?php if ($_SESSION["jabatan"] === "Bendahara") { ?>
    <?php include "sidebar.php"; ?>
    <?php } else {include "othersidebar.php";} ?>
    <main class="main-content position-relative border-radius-lg ">
    <?php include "navbar.php"; ?>
