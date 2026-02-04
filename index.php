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

    <title>LegalBI Dashboard</title>
    <!-- CSS -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/perfect-scrollbar.css">

    <!-- Google FONT -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900|Open+Sans:300,400,600,700,800|Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="./vendor/chartist/css/chartist.min.css">
    <link href="./vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/47e60dfc20.js" crossorigin="anonymous" defer></script>
    <script src="assets/charts.js"></script>
</head>

<body data-spy="scroll" data-target=".nav-bar" data-offset="50">
    <div id="main-wrapper">
        <div class="nav-header">
            <a href="index.php" class="brand-logo">
                <svg class="logo-abbr" width="52" height="52" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path class="svg-logo-path" d="M0 12C0 5.37258 5.37258 0 12 0H26C40.3594 0 52 11.6406 52 26C52 40.3594 40.3594 52 26 52C11.6406 52 0 40.3594 0 26V12Z" fill="#43DC80" />
                    <mask id="mask0" maskUnits="userSpaceOnUse" x="0" y="0" width="52" height="52">
                        <path class="svg-logo-path" d="M0 12C0 5.37258 5.37258 0 12 0H26C40.3594 0 52 11.6406 52 26C52 40.3594 40.3594 52 26 52C11.6406 52 0 40.3594 0 26V12Z" fill="#43DC80" />
                    </mask>
                    <g mask="url(#mask0)">
                        <circle class="svg-logo-circle" cx="54" cy="13" r="26" fill="#34D574" />
                        <circle class="svg-logo-circle" cx="23" cy="62" r="20" fill="#50E98D" />
                        <circle class="svg-logo-circle" cx="12.5" cy="41.5" r="13" stroke="#50E98D" />
                    </g>
                    <path class="svg-logo-text" d="M18.652 37V21.208C18.652 19.9013 18.904 18.8933 19.408 18.184C19.9307 17.456 20.5747 16.952 21.34 16.672C22.1053 16.3733 22.8707 16.224 23.636 16.224C24.252 16.224 25.064 16.2333 26.072 16.252C27.08 16.2707 28.172 16.308 29.348 16.364C30.524 16.42 31.644 16.5133 32.708 16.644V20.704H25.008C24.4853 20.704 24.1027 20.844 23.86 21.124C23.6173 21.404 23.496 21.7307 23.496 22.104V25.016L31.336 25.268V29.104L23.496 29.356V37H18.652Z" fill="white" />
                </svg>
                <svg class="brand-title" width="85" height="27" viewBox="0 0 85 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path class="svg-logo-title" d="M0.00600014 26V6.824C0.00600014 5.23733 0.312 4.01333 0.924 3.152C1.55867 2.268 2.34067 1.656 3.27 1.316C4.19933 0.953332 5.12867 0.771999 6.058 0.771999C6.806 0.771999 7.792 0.783332 9.016 0.805998C10.24 0.828666 11.566 0.873999 12.994 0.941998C14.422 1.01 15.782 1.12333 17.074 1.282V6.212H7.724C7.08933 6.212 6.62467 6.382 6.33 6.722C6.03533 7.062 5.888 7.45867 5.888 7.912V11.448L15.408 11.754V16.412L5.888 16.718V26H0.00600014ZM22.671 26.204C21.2657 26.204 20.1323 25.796 19.271 24.98C18.4097 24.1413 17.979 23.008 17.979 21.58V19.812C17.979 18.4293 18.4663 17.2847 19.441 16.378C20.4383 15.4713 21.991 15.018 24.099 15.018H28.247V14.134C28.247 13.6353 28.1563 13.2387 27.975 12.944C27.8163 12.6267 27.465 12.4 26.921 12.264C26.3997 12.1053 25.595 12.026 24.507 12.026H19.135V8.66C20.0417 8.34266 21.0957 8.07067 22.297 7.844C23.4983 7.61733 24.9717 7.49267 26.717 7.47C28.2357 7.47 29.5503 7.65133 30.661 8.014C31.7717 8.37667 32.6217 9.01133 33.211 9.918C33.823 10.802 34.129 12.0713 34.129 13.726V26H29.471L28.553 24.13C28.281 24.3793 27.873 24.674 27.329 25.014C26.785 25.3313 26.1163 25.6147 25.323 25.864C24.5297 26.0907 23.6457 26.204 22.671 26.204ZM25.697 22.158C25.9917 22.1807 26.3203 22.1467 26.683 22.056C27.0457 21.9653 27.3743 21.8747 27.669 21.784C27.9637 21.6707 28.1563 21.58 28.247 21.512V17.772L26.071 17.976C24.575 18.1347 23.827 18.7693 23.827 19.88V20.594C23.827 21.1833 23.997 21.5913 24.337 21.818C24.6997 22.0447 25.153 22.158 25.697 22.158ZM44.1848 26.204C43.3688 26.204 42.5188 26.17 41.6348 26.102C40.7508 26.034 39.9121 25.932 39.1188 25.796C38.3254 25.66 37.6568 25.4787 37.1128 25.252V21.818H45.4088C45.9754 21.818 46.3721 21.75 46.5988 21.614C46.8254 21.4553 46.9388 21.172 46.9388 20.764V20.254C46.9388 19.9367 46.8254 19.6873 46.5988 19.506C46.3948 19.302 45.9641 19.2 45.3068 19.2H42.3148C41.2948 19.2 40.3541 19.0413 39.4928 18.724C38.6541 18.4067 37.9854 17.874 37.4868 17.126C36.9881 16.378 36.7388 15.3693 36.7388 14.1V13.012C36.7388 11.8333 36.9654 10.836 37.4188 10.02C37.8721 9.204 38.6541 8.592 39.7648 8.184C40.8754 7.75333 42.4281 7.538 44.4228 7.538C45.2161 7.538 46.0434 7.58333 46.9048 7.674C47.7661 7.76467 48.5594 7.88933 49.2848 8.048C50.0328 8.184 50.6221 8.33133 51.0528 8.49V11.924H43.1988C42.7001 11.924 42.3261 12.0033 42.0768 12.162C41.8501 12.298 41.7368 12.5813 41.7368 13.012V13.488C41.7368 13.9187 41.8728 14.202 42.1448 14.338C42.4168 14.474 42.8701 14.542 43.5048 14.542H46.5308C48.4574 14.542 49.8288 14.984 50.6448 15.868C51.4834 16.7293 51.9028 17.9307 51.9028 19.472V21.206C51.9028 23.0647 51.2568 24.368 49.9648 25.116C48.6728 25.8413 46.7461 26.204 44.1848 26.204ZM61.9272 26C60.4538 26 59.2525 25.796 58.3232 25.388C57.4165 24.9573 56.7592 24.2547 56.3512 23.28C55.9658 22.3053 55.8072 20.9793 55.8752 19.302L56.0452 12.366H53.2232V8.626L56.2832 7.708L57.0312 2.574H61.6892V7.708H65.6672V12.366H61.6892V19.268C61.6892 20.0387 61.8252 20.5827 62.0972 20.9C62.3692 21.1947 62.7318 21.3647 63.1852 21.41L65.4972 21.648V26H61.9272ZM76.1896 26.17C74.0816 26.17 72.4043 25.8753 71.1576 25.286C69.911 24.674 69.0043 23.688 68.4376 22.328C67.8936 20.9453 67.6216 19.1093 67.6216 16.82C67.6216 14.3493 67.905 12.434 68.4716 11.074C69.0383 9.714 69.945 8.762 71.1916 8.218C72.4383 7.674 74.1043 7.402 76.1896 7.402C78.2976 7.402 79.975 7.68533 81.2216 8.252C82.4683 8.81867 83.375 9.782 83.9416 11.142C84.5083 12.502 84.7916 14.3947 84.7916 16.82C84.7916 19.1773 84.5196 21.0473 83.9756 22.43C83.4316 23.79 82.5363 24.7533 81.2896 25.32C80.043 25.8867 78.343 26.17 76.1896 26.17ZM76.1896 21.512C76.8696 21.512 77.4023 21.4213 77.7876 21.24C78.1956 21.036 78.479 20.6053 78.6376 19.948C78.819 19.268 78.9096 18.214 78.9096 16.786C78.9096 15.358 78.819 14.3153 78.6376 13.658C78.479 13.0007 78.1956 12.5813 77.7876 12.4C77.4023 12.196 76.8696 12.094 76.1896 12.094C75.5323 12.094 74.9996 12.196 74.5916 12.4C74.2063 12.5813 73.923 13.0007 73.7416 13.658C73.583 14.3153 73.5036 15.358 73.5036 16.786C73.5036 18.214 73.583 19.268 73.7416 19.948C73.923 20.6053 74.2063 21.036 74.5916 21.24C74.9996 21.4213 75.5323 21.512 76.1896 21.512Z" fill="#4B8067" />
                </svg>
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
                                <div class="input-group search-area d-lg-inline-flex d-none">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><a href="javascript:void(0)"><i class="flaticon-381-search-2"></i></a></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Search here...">
                                </div>
                            </li>
                            <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link bell bell-link" href="javascript:void(0)">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.23779 10.2492L4.66679 11.7064V8.30554L2.23779 10.2492Z" fill="#67636D" />
                                        <path d="M1.1665 12.327V23.3334C1.16852 23.8531 1.28817 24.3656 1.5165 24.8325L9.20134 17.15L1.1665 12.327Z" fill="#67636D" />
                                        <path d="M26.4832 24.8325C26.7115 24.3656 26.8311 23.8531 26.8332 23.3334V12.327L18.7983 17.15L26.4832 24.8325Z" fill="#67636D" />
                                        <path d="M23.3335 8.30554V11.7064L25.7625 10.2492L23.3335 8.30554Z" fill="#67636D" />
                                        <path d="M21.0492 13.0772C21.024 12.998 21.0076 12.9162 21.0002 12.8334V7.00004C21.0002 6.69062 20.8773 6.39388 20.6585 6.17508C20.4397 5.95629 20.1429 5.83337 19.8335 5.83337H8.16684C7.85742 5.83337 7.56067 5.95629 7.34188 6.17508C7.12309 6.39388 7.00017 6.69062 7.00017 7.00004V12.8334C6.99274 12.9162 6.97631 12.998 6.95117 13.0772L14.0002 17.3064L21.0492 13.0772Z" fill="#67636D" />
                                        <path d="M17.3262 3.50003L14.7292 1.4222C14.5222 1.25653 14.2651 1.16626 14 1.16626C13.7349 1.16626 13.4777 1.25653 13.2708 1.4222L10.6738 3.50003H17.3262Z" fill="#67636D" />
                                        <path d="M16.7358 18.3855L14.6008 19.6688C14.4194 19.7778 14.2117 19.8354 14 19.8354C13.7883 19.8354 13.5806 19.7778 13.3991 19.6688L11.2641 18.3855L3.16748 26.4833C3.63438 26.7117 4.14691 26.8313 4.66665 26.8333H23.3333C23.853 26.8313 24.3656 26.7117 24.8325 26.4833L16.7358 18.3855Z" fill="#67636D" />
                                    </svg>
                                    <span class="badge light text-white bg-primary rounded-circle">6</span>
                                </a>
                            </li>
                            <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link  ai-icon" href="javascript:void(0)" role="button" data-bs-toggle="dropdown">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M23.3333 19.8333H23.1187C23.2568 19.4597 23.3295 19.065 23.3333 18.6666V12.8333C23.3294 10.7663 22.6402 8.75902 21.3735 7.12565C20.1068 5.49228 18.3343 4.32508 16.3333 3.80679V3.49996C16.3333 2.88112 16.0875 2.28763 15.6499 1.85004C15.2123 1.41246 14.6188 1.16663 14 1.16663C13.3812 1.16663 12.7877 1.41246 12.3501 1.85004C11.9125 2.28763 11.6667 2.88112 11.6667 3.49996V3.80679C9.66574 4.32508 7.89317 5.49228 6.6265 7.12565C5.35983 8.75902 4.67058 10.7663 4.66667 12.8333V18.6666C4.67053 19.065 4.74316 19.4597 4.88133 19.8333H4.66667C4.35725 19.8333 4.0605 19.9562 3.84171 20.175C3.62292 20.3938 3.5 20.6905 3.5 21C3.5 21.3094 3.62292 21.6061 3.84171 21.8249C4.0605 22.0437 4.35725 22.1666 4.66667 22.1666H23.3333C23.6428 22.1666 23.9395 22.0437 24.1583 21.8249C24.3771 21.6061 24.5 21.3094 24.5 21C24.5 20.6905 24.3771 20.3938 24.1583 20.175C23.9395 19.9562 23.6428 19.8333 23.3333 19.8333Z" fill="#67636D" />
                                        <path d="M9.98193 24.5C10.3863 25.2088 10.971 25.7981 11.6767 26.2079C12.3823 26.6178 13.1839 26.8337 13.9999 26.8337C14.816 26.8337 15.6175 26.6178 16.3232 26.2079C17.0289 25.7981 17.6136 25.2088 18.0179 24.5H9.98193Z" fill="#67636D" />
                                    </svg>
                                    <span class="badge light text-white bg-primary rounded-circle">4</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <div id="dlab_W_Notification1" class="widget-media dz-scroll p-3 height380">
                                        <ul class="timeline">
                                            <li>
                                                <div class="timeline-panel">
                                                    <div class="media me-2">
                                                        <img alt="image" width="50" src="images/avatar/1.jpg">
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="mb-1">Dr sultads Send you Photo</h6>
                                                        <small class="d-block">29 July 2020 - 02:26 PM</small>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="timeline-panel">
                                                    <div class="media me-2 media-info">
                                                        KG
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="mb-1">Resport created successfully</h6>
                                                        <small class="d-block">29 July 2020 - 02:26 PM</small>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="timeline-panel">
                                                    <div class="media me-2 media-success">
                                                        <i class="fa fa-home"></i>
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="mb-1">Reminder : Treatment Time!</h6>
                                                        <small class="d-block">29 July 2020 - 02:26 PM</small>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="timeline-panel">
                                                    <div class="media me-2">
                                                        <img alt="image" width="50" src="images/avatar/1.jpg">
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="mb-1">Dr sultads Send you Photo</h6>
                                                        <small class="d-block">29 July 2020 - 02:26 PM</small>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="timeline-panel">
                                                    <div class="media me-2 media-danger">
                                                        KG
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="mb-1">Resport created successfully</h6>
                                                        <small class="d-block">29 July 2020 - 02:26 PM</small>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="timeline-panel">
                                                    <div class="media me-2 media-primary">
                                                        <i class="fa fa-home"></i>
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="mb-1">Reminder : Treatment Time!</h6>
                                                        <small class="d-block">29 July 2020 - 02:26 PM</small>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <a class="all-notification" href="javascript:void(0)">See all notifications <i class="ti-arrow-right"></i></a>
                                </div>
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
                                    <a href="./email-inbox.html" class="dropdown-item ai-icon">
                                        <svg id="icon-inbox" xmlns="http://www.w3.org/2000/svg" class="text-success" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                            <polyline points="22,6 12,13 2,6"></polyline>
                                        </svg>
                                        <span class="ms-2">Inbox </span>
                                    </a>
                                    <a href="./page-login.html" class="dropdown-item ai-icon">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                            <polyline points="16 17 21 12 16 7"></polyline>
                                            <line x1="21" y1="12" x2="9" y2="12"></line>
                                        </svg>
                                        <span class="ms-2"><a href="./public/logout.php">Logout</a> </span>
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
                            <i class="flaticon-layout"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>

                    <!-- KPI Analitika -->
                    <li>
                        <a class="ai-icon" href="kpi.php" aria-expanded="false">
                            <i class="flaticon-bar-chart-1"></i>
                            <span class="nav-text">KPI Analitika</span>
                        </a>
                    </li>

                    <!-- Izveštaji -->
                    <li>
                        <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <i class="flaticon-file"></i>
                            <span class="nav-text">Izveštaji</span>
                        </a>
                        <ul class="mm-collapse" aria-expanded="false">
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
                            <i class="flaticon-search"></i>
                            <span class="nav-text">Analitika</span>
                        </a>
                    </li>

                    <!-- Upravljanje korisnicima (samo admin) -->
                    <li>
                        <a class="ai-icon" href="users.php" aria-expanded="false">
                            <i class="flaticon-user"></i>
                            <span class="nav-text">Korisnici</span>
                        </a>
                    </li>

                    <!-- Podešavanja -->
                    <li>
                        <a class="ai-icon" href="settings.php" aria-expanded="false">
                            <i class="flaticon-gear"></i>
                            <span class="nav-text">Podešavanja</span>
                        </a>
                    </li>

                    <!-- Logout -->
                    <li>
                        <a class="ai-icon" href="./public/logout.php" aria-expanded="false">
                            <i class="flaticon-logout"></i>
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
                <div class="card card-bd">
                    <div class="bg-secondary card-border"></div>
                    <div class="card-body box-style">
                        <div class="media align-items-center">
                            <div class="media-body me-3">
                                <h2 class="num-text text-black font-w700">78</h2>
                                <span class="fs-14">Total Project Handled</span>
                            </div>
                            <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M34.422 13.9831C34.3341 13.721 34.1756 13.4884 33.9638 13.3108C33.7521 13.1332 33.4954 13.0175 33.222 12.9766L23.649 11.5141L19.353 2.36408C19.2319 2.10638 19.0399 1.88849 18.7995 1.73587C18.5591 1.58325 18.2803 1.5022 17.9955 1.5022C17.7108 1.5022 17.4319 1.58325 17.1915 1.73587C16.9511 1.88849 16.7592 2.10638 16.638 2.36408L12.342 11.5141L2.76902 12.9766C2.49635 13.0181 2.24042 13.1341 2.02937 13.3117C1.81831 13.4892 1.6603 13.7215 1.57271 13.9831C1.48511 14.2446 1.47133 14.5253 1.53287 14.7941C1.59441 15.063 1.72889 15.3097 1.92152 15.5071L8.89802 22.6501L7.24802 32.7571C7.20299 33.0345 7.23679 33.3189 7.34555 33.578C7.45431 33.8371 7.63367 34.0605 7.86319 34.2226C8.09271 34.3847 8.36315 34.4791 8.64371 34.495C8.92426 34.5109 9.20365 34.4477 9.45002 34.3126L18 29.5906L26.55 34.3126C26.7964 34.4489 27.0761 34.5131 27.3573 34.4978C27.6384 34.4826 27.9096 34.3885 28.1398 34.2264C28.37 34.0643 28.5499 33.8406 28.659 33.5811C28.768 33.3215 28.8018 33.0365 28.7565 32.7586L27.1065 22.6516L34.0785 15.5071C34.2703 15.3091 34.4037 15.0622 34.4643 14.7933C34.5249 14.5245 34.5103 14.2441 34.422 13.9831Z" fill="#864AD1" />
                            </svg>
                        </div>
                    </div>
                </div>
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
    <script src="./vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="./vendor/chart.js/Chart.bundle.min.js"></script>

    <!-- Chart piety plugin files -->
    <script src="./vendor/peity/jquery.peity.min.js"></script>

    <!-- Apex Chart -->
    <script src="./vendor/apexchart/apexchart.js"></script>

    <!-- Dashboard 1 -->
    <script src="./assets/js/dashboard/dashboard-1.js"></script>

    <script src="./assets/js/custom.min.js"></script>
    <script src="./assets/js/deznav-init.js"></script>
</body>

</html>