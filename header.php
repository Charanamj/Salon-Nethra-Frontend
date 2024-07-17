<?php ob_start();
session_start();
?>
<?php include 'function.php';?>
<?php include 'config.php';?> 

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Salon Management System</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <script src="<?= SYSTEM_PATHS ?>assets/js/sweetalert2.all.js"></script>

  <!-- Favicons -->
  <link href="<?= SYSTEM_PATHS ?>assets/img/favicon.png" rel="icon">
  <link href="<?= SYSTEM_PATHS ?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= SYSTEM_PATHS ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= SYSTEM_PATHS ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= SYSTEM_PATHS ?>assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="<?= SYSTEM_PATHS ?>assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="<?= SYSTEM_PATHS ?>assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="<?= SYSTEM_PATHS ?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?= SYSTEM_PATHS ?>assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Nova
  * Updated: Jan 29 2024 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nova-bootstrap-business-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>
<body class="index-page">
  <!-- ======= Header ======= -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="d-flex align-items-center header-dark">Salon Nethra</h1>
      </a>

      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="<?= SYSTEM_PATHS ?>index.php" class="active">Home</a></li>
          <li><a href="<?= SYSTEM_PATHS ?>about.php">About</a></li>
          <li><a href="<?= SYSTEM_PATHS ?>services.php">Services</a></li>
          <li><a href="<?= SYSTEM_PATHS ?>team.php">Our Team</a></li>
          <li><a href="<?= SYSTEM_PATHS ?>contact.php">Contact Us</a></li>
          <li><a class="getstarted scrollto" href="<?= SYSTEM_PATHS ?>register.php">Registration</a></li>
          <?php if(empty($_SESSION['cLogEmail'])){ ?>
          <li><a class="getstarted scrollto" href="<?= SYSTEM_PATHS ?>login.php">Log in</a></li><?php
          }
          ?>
          <?php 
              if(!empty($_SESSION['cLogEmail'])){ ?>
                <li><a class="getstarted scrollto" href="<?= SYSTEM_PATHS ?>logout.php">Log Out</a></li><?php

              }
          ?>
          
        </ul>
      </nav>
    </div>
  </header>