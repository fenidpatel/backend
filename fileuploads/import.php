<?php

header("Content-Type: application/json");

// Database connection
$dsn = 'mysql:host=localhost;dbname=csci6040_study;charset=utf8mb4';
$username = 'root';
$password = '';

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    echo json_encode([
        "status" => false,
        "message" => "Database connection failed"
    ]);
    exit;
}

// Allow only POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => false,
        "message" => "Only POST method allowed"
    ]);
    exit;
}

// Check file upload
if (!isset($_FILES['file'])) {
    echo json_encode([
        "status" => false,
        "message" => "No file uploaded"
    ]);
    exit;
}

$file = $_FILES['file'];

// Validate CSV file
$fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

if ($fileExtension !== 'csv') {
    echo json_encode([
        "status" => false,
        "message" => "Only CSV files allowed"
    ]);
    exit;
}

// Open CSV
$handle = fopen($file['tmp_name'], "r");

if (!$handle) {
    echo json_encode([
        "status" => false,
        "message" => "Unable to read file"
    ]);
    exit;
}

$rowNumber = 0;
$inserted = 0;
$data = [];

// Prepare SQL once
$stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");

// Read CSV rows
while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {

    $rowNumber++;

    // Skip header
    if ($rowNumber == 1 && strtolower($row[0]) == 'name') {
        continue;
    }

    if (count($row) < 3) {
        continue;
    }

    $name = trim($row[0]);
    $email = trim($row[1]);
    $password = password_hash(trim($row[2]), PASSWORD_DEFAULT);

    // Insert into DB
    $stmt->execute([$name, $email, $password]);

    $inserted++;

    $data[] = [
        "name" => $name,
        "email" => $email,
        "password" => $password
    ];
}

fclose($handle);

// JSON response
echo json_encode([
    "status" => true,
    "message" => "CSV imported successfully",
    "inserted_records" => $inserted,
    "data" => $data
]);
?>