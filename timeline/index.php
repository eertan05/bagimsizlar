<?php
session_start();
include '../header.php';
if (!isset($pdo)) {
    die("Database connection failed!");
}

function createTimelineCSV() {
  global $pdo;
    // Prepare SQL statement to fetch data from the database
    $stmt = $pdo->prepare("
        SELECT o_name, o_startdate, o_leg, bD_trLabel
        FROM orgs
        INNER JOIN baseDictionary
        ON 'o_leg' = baseDictionary.bD_property
        AND orgs.o_leg = baseDictionary.bD_index
    ");
    $stmt->execute();

    // Initialize CSV content with header
    $csv = "Year,Event,Type\n"; // Column headers

    // Loop through the result and write to CSV string
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results first
    echo '<script>console.log("--->", ' . json_encode($rows) . ')</script>';

    foreach ($rows as $row) {
        echo '<script>console.log("--->", ' . json_encode($row) . ')</script>';

        $year = substr($row['o_startdate'], 0, 4); // Extract the first 4 characters (year)
        if ($year > 1990) {
            // Add the data to the CSV string
            $csv .= $year . ',' . $row['o_name'] . ',' . $row['bD_trLabel'] . "\n";
        }
    }
    // Create and write the CSV file to the server
    $csv_handler = fopen('csvfile.csv', 'w');
    if ($csv_handler === false) {
        die("Unable to create CSV file!");
    }

    fwrite($csv_handler, $csv);
    fclose($csv_handler);
  //  echo "<div class='alert'>CSV file created successfully!</div>";
}
createTimelineCSV();
?>

<title>Organizations Timeline</title>
<link rel="stylesheet" href="timeline.css">
<link rel="stylesheet" href="../styles.css">
<link rel="stylesheet" href="../window-engine.css">

<canvas id="timeline-canvas"></canvas>

<!-- Include PapaParse Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
<script src="script.js"></script>

<footer><div id="legend"></div></footer>
</body>
</html>
