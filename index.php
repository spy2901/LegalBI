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
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/perfect-scrollbar.css">

    <!-- Google FONT -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900|Open+Sans:300,400,600,700,800|Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet">

       
    <!-- Bootsrap -->
    <link href="./vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!--  -->
    <script src="assets/js/charts.js"></script>
    <script src="assets/js/darkMode.js"></script>
    <style>
        
    </style>
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
                            <li class="nav-item">
                                <a class="nav-link dark-mode-toggle" href="javascript:void(0);" title="Toggle dark mode">
                                    <i class="fa-solid fa-sun" aria-hidden="true" style="font-size:18px;color:inherit;"></i>
                                </a>
                            </li>

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
                            <svg class="inline-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_iconCarrier">
                                    <g id="Navigation / House_01">
                                        <path id="Vector" d="M20 17.0002V11.4522C20 10.9179 19.9995 10.6506 19.9346 10.4019C19.877 10.1816 19.7825 9.97307 19.6546 9.78464C19.5102 9.57201 19.3096 9.39569 18.9074 9.04383L14.1074 4.84383C13.3608 4.19054 12.9875 3.86406 12.5674 3.73982C12.1972 3.63035 11.8026 3.63035 11.4324 3.73982C11.0126 3.86397 10.6398 4.19014 9.89436 4.84244L5.09277 9.04383C4.69064 9.39569 4.49004 9.57201 4.3457 9.78464C4.21779 9.97307 4.12255 10.1816 4.06497 10.4019C4 10.6506 4 10.9179 4 11.4522V17.0002C4 17.932 4 18.3978 4.15224 18.7654C4.35523 19.2554 4.74432 19.6452 5.23438 19.8482C5.60192 20.0005 6.06786 20.0005 6.99974 20.0005C7.93163 20.0005 8.39808 20.0005 8.76562 19.8482C9.25568 19.6452 9.64467 19.2555 9.84766 18.7654C9.9999 18.3979 10 17.932 10 17.0001V16.0001C10 14.8955 10.8954 14.0001 12 14.0001C13.1046 14.0001 14 14.8955 14 16.0001V17.0001C14 17.932 14 18.3979 14.1522 18.7654C14.3552 19.2555 14.7443 19.6452 15.2344 19.8482C15.6019 20.0005 16.0679 20.0005 16.9997 20.0005C17.9316 20.0005 18.3981 20.0005 18.7656 19.8482C19.2557 19.6452 19.6447 19.2554 19.8477 18.7654C19.9999 18.3978 20 17.932 20 17.0002Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </g>
                                </g>
                            </svg>
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
                <span>test</span>
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