 <?php
$servername = "localhost";
$username = "amberpla_eertan";
$password = "4mb3rPl4tf0rm";
$dbname = "amberpla_bgmszlree";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";
//printf("Initial character set: %s\n", mysqli_character_set_name($conn));

if (!mysqli_set_charset($conn, "utf8")) {
    printf("Error loading character set utf8: %s\n", mysqli_error($conn));
    exit();
} else {
  //  printf("Current character set: %s\n", mysqli_character_set_name($conn));
}


?>
