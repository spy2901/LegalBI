<?php



error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once './config/db.php';
require_once __DIR__ . '/../includes/helpers.php';

// 1️⃣ TotalCases
function getTotalCases_KPI($conn) {
    $result = $conn->query("SELECT COUNT(*) AS total FROM predmeti");
    $row = $result->fetch_assoc();
    return (int)$row['total'];
}

// 2️⃣ ActiveCases
function getActiveCases($conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM predmeti WHERE status = ?");
    $status = 'aktivan';
    $stmt->bind_param("s", $status);
    $stmt->execute();
    $stmt->bind_result($total);
    $stmt->fetch();
    $stmt->close();
    return (int)$total;
}

// 3️⃣ ClosedCases
function getClosedCases($conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM predmeti WHERE status = ?");
    $status = 'zavrsen';
    $stmt->bind_param("s", $status);
    $stmt->execute();
    $stmt->bind_result($total);
    $stmt->fetch();
    $stmt->close();
    return (int)$total;
}

// 4️⃣ AvgDuration (prosečno trajanje završenih predmeta u danima)
function getAvgDuration($conn) {
    $sql = "SELECT AVG(DATEDIFF(p.datum_presude, p2.datum_pokretanja)) AS avg_days
            FROM predmeti p2
            JOIN presude p ON p.predmet_id = p2.id
            WHERE p2.status = 'zavrsen'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['avg_days'] ? round($row['avg_days'],2) : 0;
}

// 5️⃣ OverdueCases (aktivni stariji od 365 dana)
function getOverdueCases($conn, $days = 365) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS total 
                            FROM predmeti 
                            WHERE status = ? AND DATEDIFF(CURDATE(), datum_pokretanja) > ?");
    $status = 'aktivan';
    $stmt->bind_param("si", $status, $days);
    $stmt->execute();
    $stmt->bind_result($total);
    $stmt->fetch();
    $stmt->close();
    return (int)$total;
}