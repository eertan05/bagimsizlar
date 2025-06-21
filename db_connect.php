<?php
$servername = "localhost";
$username = "amberpla_eertan";
$password = "4mb3rPl4tf0rm";
$dbname = "amberpla_bgmszlree";

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
