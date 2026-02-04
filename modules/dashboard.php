<?php
require_once './config/db.php';
require_once __DIR__ . '/../includes/helpers.php';

function display_kpi(){
    global $conn;
    // Primer: ukupno slučajeva
    $result = $conn->query("SELECT COUNT(*) as ukupno FROM bpp");
    $row = $result->fetch_assoc();
    echo "<div class='kpi'>Ukupan broj slučajeva: ".$row['ukupno']."</div>";

    // Ovde možeš dodati ostale KPI-jeve
}

function display_charts(){
    // Ovde ubaciš Chart.js grafike (linije, stubičasti, pie)
    echo "<canvas id='casesChart'></canvas>";
}
?>
