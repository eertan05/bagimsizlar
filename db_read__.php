<?php
// Database connection
$host = "localhost";
$username = "amberpla_eertan";
$password = "4mb3rPl4tf0rm";
$dbname = "amberpla_bgmszlree";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Define table name and CSV file path
    $tableName = 'baseDictionary';
    $csvFileName = 'basedictionary' . '.csv';

    // Open a file in write mode ('w')
    $file = fopen($csvFileName, 'w');

    // Step 1: Get table headers
    $query = $pdo->prepare("SHOW COLUMNS FROM $tableName");
    $query->execute();
    $columns = $query->fetchAll(PDO::FETCH_COLUMN);

    // Write headers to CSV
    fputcsv($file, $columns);

    // Step 2: Get table data
    $stmt = $pdo->prepare("SELECT * FROM $tableName");
    $stmt->execute();

    $dict = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($file, $row);
          $dict[] = $row;
    }

    fclose($file);
    var_dump($dict);

    // Step 3: Read back the file (for frontend use)
    $dict = [];
    if (($handle = fopen($csvFilePath, 'r')) !== FALSE) {
        while (($row = fgetcsv($handle)) !== FALSE) {
            $data[] = $row;
        }
        fclose($handle);
    }

    // Step 4: Output as JSON for frontend use
    // header('Content-Type: application/json');
    // echo json_encode($data);

    // Optionally delete the file after download
    unlink($csvFileName);

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
