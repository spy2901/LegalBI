<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['username'])) {
    header('location: ./public/login.php');
    exit;
}


require_once __DIR__ . '/modules/dashboard.php';
?>

<!DOCTYPE html>
<html>

<head>

    <title>LegalBI</title>
    <!-- CSS -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="./assets/css/font-awesome.css">
    <!-- Google FONT -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900|Open+Sans:300,400,600,700,800|Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <!-- Chart -->
    <link rel="stylesheet" href="./vendor/chartist/css/chartist.min.css">
    <!-- Bootsrap -->
    <link href="./vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script src="assets/js/charts.js"></script>
</head>

<body data-spy="scroll" data-target=".nav-bar" data-offset="50">
    <div id="main-wrapper">
        <div class="nav-header">
            <a href="index.php" class="brand-logo">
                <!-- Logo ikona -->
                <i class="fa-solid fa-scale-balanced"
                    style="font-size:32px; color:#2f7be5; margin-right:10px;"></i>

                <!-- Naziv -->
                <span class="brand-title"
                    style="font-size:22px; font-weight:700; color:#2f7be5;">
                    Legal<span style="color:#1f2937;">BI</span>
                </span>

            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar">
                                Dashboard
                            </div>
                        </div>
                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                                    <!-- <img src="images/profile/pic1.jpg" width="20" alt="" /> -->
                                    <div class="header-info">
                                        <span><?php echo $_SESSION['username']; ?></span>
                                        <small><?php echo $_SESSION['uloga']; ?></small>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="./app-profile.html" class="dropdown-item ai-icon">
                                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        <span class="ms-2">Profile </span>
                                    </a>
                                    <a href="./public/logout.php" class="dropdown-item ai-icon">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                            <polyline points="16 17 21 12 16 7"></polyline>
                                            <line x1="21" y1="12" x2="9" y2="12"></line>
                                        </svg>
                                        <span class="ms-2">Logout</span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
                <ul class="metismenu" id="menu">

                    <!-- Dashboard -->
                    <li>
                        <a class="ai-icon" href="index.php" aria-expanded="false">
                            <i class="fa-solid fa-gavel"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>

                    <!-- KPI Analitika -->
                    <li>
                        <a class="ai-icon" href="kpi.php" aria-expanded="false">
                            <i class="fa-solid fa-chart-column"></i>
                            <span class="nav-text">KPI Analitika</span>
                        </a>
                    </li>

                    <!-- Izveštaji -->
                    <li>
                        <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                            <i class="fa-solid fa-file-lines"></i>
                            <span class="nav-text">Izveštaji</span>
                        </a>
                        <ul>
                            <li><a href="izvestaji-period.php">Po periodu</a></li>
                            <li><a href="izvestaji-pravnik.php">Po pravniku</a></li>
                            <li><a href="izvestaji-lokacija.php">Po lokaciji</a></li>
                            <li><a href="izvestaji-oblast.php">Po pravnoj oblasti</a></li>
                            <li><a href="izvestaji-export.php">Export PDF/Excel</a></li>
                        </ul>
                    </li>

                    <!-- Analitika / Drill-Down -->
                    <li>
                        <a class="ai-icon" href="analitika.php" aria-expanded="false">
                            <i class="fa-solid fa-magnifying-glass-chart"></i>
                            <span class="nav-text">Analitika</span>
                        </a>
                    </li>

                    <!-- Upravljanje korisnicima -->
                    <li>
                        <a class="ai-icon" href="users.php" aria-expanded="false">
                            <i class="fa-solid fa-users"></i>
                            <span class="nav-text">Korisnici</span>
                        </a>
                    </li>

                    <!-- Podešavanja -->
                    <li>
                        <a class="ai-icon" href="settings.php" aria-expanded="false">
                            <i class="fa-solid fa-gear"></i>
                            <span class="nav-text">Podešavanja</span>
                        </a>
                    </li>

                    <!-- Logout -->
                    <li>
                        <a class="ai-icon" href="./public/logout.php" aria-expanded="false">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span class="nav-text">Logout</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>


        <!--**********************************
            Sidebar end
        ***********************************-->
        <!-- Dashboard KPI -->
        <div class="row">
            <div class="col-xl-3 col-xxl-3 col-lg-6 col-sm-6">
            </div>
        </div>
        <?php //display_kpi(); 
        ?>

        <!-- Dashboard grafici -->
        <?php // display_charts(); 
        ?>

        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="https://www.triathlonforge.com">Spy2901</a>
                    <script>
                        document.write(new Date().getFullYear())
                    </script>
                </p>
            </div>
        </div>

    </div>


    <style>
        /* ======================================================
   SUBMENU – OSNOVNO STANJE
====================================================== */
        .deznav .metismenu ul {
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transition:
                max-height 1s ease,
                opacity 1s ease,
                transform 1s ease;
        }

        /* ======================================================
   OTVORENO
====================================================== */
        .deznav .metismenu li.mm-active>ul {
            max-height: 500px;
            opacity: 1;
            transform: translateY(0);
        }

        /* ======================================================
   KLJUČNO: TOKOM ZATVARANJA (MetisMenu state)
====================================================== */
        .deznav .metismenu ul.mm-collapsing {
            max-height: 500px;
            /* polazna tačka za animaciju */
            opacity: 1;
            transform: translateY(0);
        }

        /* ======================================================
   METISMENU FIX
====================================================== */
        .deznav .metismenu ul.collapse {
            display: block !important;
        }

        /* ======================================================
   STRELICA
====================================================== */
        .deznav .metismenu .has-arrow {
            position: relative;
        }

        .deznav .metismenu .has-arrow::after {
            content: "";
            position: absolute;
            right: 1.5rem;
            top: 50%;
            width: 8px;
            height: 8px;
            border-right: 2px solid #7a86b8;
            border-bottom: 2px solid #7a86b8;
            transform: translateY(-50%) rotate(45deg);
            transition:
                transform 0.6s ease,
                border-color 0.4s ease;
        }

        .deznav .metismenu>li:hover>a.has-arrow::after {
            border-color: #2f7be5;
        }

        .deznav .metismenu li.mm-active>a.has-arrow::after {
            transform: translateY(-50%) rotate(-135deg);
            border-color: #2f7be5;
        }
    </style>
    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="./vendor/global/global.min.js"></script>
    <script src="./vendor/metismenu/js/metisMenu.min.js"></script>

    <script src="./vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>

    <!-- Chart piety plugin files -->
    <script src="./vendor/peity/jquery.peity.min.js"></script>

    <script src="./assets/js/custom.min.js"></script>
    <script src="./assets/js/deznav-init.js"></script>
</body>

</html>