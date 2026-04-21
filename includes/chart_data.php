
<?php


require_once '../config/db.php';
header('Content-Type: application/json');

// DOZVOLJENE TABELE I KOLONE (whitelist radi bezbednosti)
$allowedTables = [
    "predmeti" => ["tip_predmeta", "status", "sud_id", "advokat", "lokacija", "monthly_trend"]
];

$table = $_GET['table'] ?? '';
$column = $_GET['column'] ?? '';

// VALIDACIJA
if (!array_key_exists($table, $allowedTables)) {
    echo json_encode(["error" => "Nevalidna tabela"]);
    exit;
}

if (!in_array($column, $allowedTables[$table])) {
    echo json_encode(["error" => "Nevalidna kolona: " . $column]);
    exit;
}

// QUERY
if ($column === "monthly_trend") {
    $sql = "SELECT DATE_FORMAT(datum_pokretanja, '%Y-%m') AS label, COUNT(*) AS value
            FROM $table
            WHERE datum_pokretanja IS NOT NULL
            GROUP BY DATE_FORMAT(datum_pokretanja, '%Y-%m')
            ORDER BY label ASC";
} else {
    $sql = "SELECT $column AS label, COUNT(*) AS value
            FROM $table
            GROUP BY $column
            ORDER BY value DESC";
}
$result = $conn->query($sql);

$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = [
        "label" => $row["label"],
        "value" => (int)$row["value"]
    ];
}

echo json_encode($data);