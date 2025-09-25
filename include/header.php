<?php
require_once 'action/session.php';
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>SysSoft Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap.css"> -->
    <!-- <link rel="stylesheet" href="assets/css/bootstrap5.2.0.min.css"> -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet">

</head>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="<?= $href; ?>"><img src="assets/images/syssoft.png" alt="logo"></a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <ul class="metismenu" id="menu">
                            <?php
                            // Check if the current page is 'user.php'
                            if (basename($_SERVER['PHP_SELF']) == 'user.php') {
                                echo '<li><a href="user.php" class="text-decoration-none' . (basename($_SERVER['PHP_SELF']) == 'user.php' ? ' active' : '') . '"><i class="ti-dashboard"></i> <span>Dashboard</span></a></li>';
                            } else {
                                // For other pages, add the active class based on the current page
                                echo '<li><a href="admin.php" class="text-decoration-none' . (basename($_SERVER['PHP_SELF']) == 'admin.php' ? ' active' : '') . '"><i class="ti-dashboard"></i> <span>Dashboard</span></a></li>';

                                echo '<li><a href="deletedTicket.php" class="text-decoration-none' . (basename($_SERVER['PHP_SELF']) == 'deletedTicket.php' ? ' active' : '') . '"><i class="ti-ticket"></i> <span>Deleted Ticket</span></a></li>';

                                echo '<li><a href="registerUser.php" class="text-decoration-none' . (basename($_SERVER['PHP_SELF']) == 'registerUser.php' ? ' active' : '') . '"><i class="ti-user"></i> <span>Register User</span></a></li>';
                            }
                            ?>



                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
            <!-- header area start -->
            <div class="header-area">
                <div class="row align-items-center">
                    <!-- nav and search button -->
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="pull-left">

                        </div>
                    </div>
                    <!-- profile info & task notification -->
                    <div class="col-md-6 col-sm-4 clearfix">
                        <ul class="notification-area pull-right">
                            <li id="full-view"><i class="ti-fullscreen"></i></li>
                            <li id="full-view-exit"><i class="ti-zoom-out"></i></li>
                            <li class="settings-btn position-relative" style="list-style: none;">
                                <i class="ti-settings fs-4"></i> <!-- Settings Icon -->
                                <?php
                                    if ($passwordStatus==0) {
                                        echo '<span class="position-absolute top-0 start-100 translate-middle badge bg-danger rounded-circle p-1"> </span>';
                                    }
                                ?>
                                
                            </li>


                        </ul>
                    </div>
                </div>
            </div>
            <!-- header area end -->

            <!-- page title area start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left"><?= $pageTitle; ?></h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="<?= $href; ?>">Home</a></li>
                                <li><span><?= $pageTitle; ?></span></li>
                                <!-- <li id="getUser"><span class="text-dark ml-3">Please wait...</span></li> -->
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <img class="avatar user-thumb" src="assets/images/author/avatar.png" alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown"><?= $name ?> <i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="action/logout.php">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>