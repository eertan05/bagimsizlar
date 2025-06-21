<?php
session_start();
$_SESSION["_logged_in"] = false;  // Update session variable
session_destroy();  // Destroy the session

// Return JSON response
header('Content-Type: application/json');
echo json_encode(["success" => true]);
exit();
?>
