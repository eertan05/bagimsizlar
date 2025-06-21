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

$orgId = $decoded['od'];
$adminName = $decoded['name'];

$sql = "SELECT p_id FROM persons WHERE p_name = :name LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([':name' => $adminName]);

if ($stmt->errorCode() != '00000') {
    error_log("SQL Error: " . implode(", ", $stmt->errorInfo()));
}

$person = $stmt->fetch(PDO::FETCH_ASSOC);

if ($person) {
    $sqlDelete = "DELETE FROM relPerOrg WHERE rpo_o_id = :org_id AND rpo_p_id = :person_id";
    $stmtDelete = $pdo->prepare($sqlDelete);

    if ($stmtDelete->execute([
        ':org_id' => $orgId,
        ':person_id' => $person['p_id']
    ])) {
        echo json_encode(["success" => "Admin deleted successfully"]);
    } else {
        error_log("Delete failed: " . implode(", ", $stmtDelete->errorInfo()));
        echo json_encode(["error" => "Failed to remove admin"]);
    }

} else {
    error_log("Admin not found: $adminName");
    echo json_encode(["error" => "Admin not found"]);
}
?>
