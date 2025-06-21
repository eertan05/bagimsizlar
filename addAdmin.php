<?php
include 'db_connect.php';

// Set response headers
header("Content-Type: application/json");

// Receive the RAW post data
$content = trim(file_get_contents("php://input"));
$decoded = json_decode($content, true);

// Validate JSON
if (!is_array($decoded) || empty($decoded['od']) || empty($decoded['name'])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input data!"]);
    exit;
}

try {
    // First, get the p_id from the persons table
    $sql = "SELECT p_id FROM persons WHERE p_name = :person_name";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':person_name', $decoded['name'], PDO::PARAM_STR);
    $stmt->execute();
    $person = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$person) {
        http_response_code(404);
        echo json_encode(["error" => "Person not found!"]);
        exit;
    }

    $person_id = $person['p_id'];
    $org_id = $decoded['od'];

    // Insert into relPerOrg
    $sql = "INSERT INTO relPerOrg (rpo_p_id, rpo_o_id, rpo_admin) VALUES (:person_id, :org_id, :is_admin)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':person_id', $person_id, PDO::PARAM_INT);
    $stmt->bindParam(':org_id', $org_id, PDO::PARAM_INT);
    $stmt->bindValue(':is_admin', 1, PDO::PARAM_INT);

    $stmt->execute();

    echo json_encode(["success" => "Admin added successfully"]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
