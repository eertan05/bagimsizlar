<?php
session_start();
include_once 'img/ph/db_connect.php';

$comm = $_POST['action2'];
$mail = $_POST['action1'];

try {
    if ($_POST['action0'] == '1') {
        $sql = "UPDATE persons SET p_comm = :comm WHERE p_email = :mail";
        $_SESSION["_comm"] = $comm;
    } else {
        $sql = "UPDATE organizations SET o_comm = :comm WHERE o_email = :mail"; // Use prepared statements consistently
    }

    $stmt = $pdo->prepare($sql);

    if (!$stmt) {
        throw new PDOException("Prepare failed: " . print_r($pdo->errorInfo(), true));
    }

    if ($stmt->execute([':comm' => $comm, ':mail' => $mail])) {
        echo 'success';
    } else {
        throw new PDOException("Execute failed: " . print_r($stmt->errorInfo(), true));
    }

} catch (PDOException $e) {
    error_log("PDO Exception: " . $e->getMessage());
    http_response_code(500); // Internal server error
    echo json_encode(["error" => "Database error: " . $e->getMessage()]); // send JSON error
}

?>
