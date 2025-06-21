<?php
ob_start(); // Start output buffering
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'db_connect.php';
include 'lang.php';

$labelField = "bD_" . $_SESSION["lang"] . "Label";

$outp = [];

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $n_id = intval($_GET['id']);

    $sql = "SELECT * FROM orgs WHERE o_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $n_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $rs) {
        $entry = [
            $labels[67] => $rs["o_name"],
            $labels[62] => $rs["o_city"],
            $labels[61] => $rs["o_address"],
            $labels[65] => $rs["o_phone"],
            $labels[66] => $rs["o_website"],
        ];

        foreach ($bD_properties as $p) {
          $outpP = [];

          if (isset($rs[$p[1]])) {
            $pieces = explode(",", $rs[$p[1]]);
            foreach ($pieces as $pie) {
              $sql2 = "SELECT * FROM baseDictionary WHERE bD_property = :property AND bD_index = :index";
              $stmt2 = $pdo->prepare($sql2);
              $stmt2->bindValue(':property', $p[1], PDO::PARAM_STR);
              $stmt2->bindValue(':index', $pie, PDO::PARAM_INT);
              $stmt2->execute();

              if ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                $outpP[] = $row2[$labelField];
              }
            }
          }
          // Add values as a comma-separated string or fallback to "—"
          $entry[$p[2]] = !empty($rs[$p[1]]) ? implode(", ", $outpP) : "—";
          echo '<script>console.log("--o_register2->", ' . json_encode($rs[$p[1]]) . ')</script>';
        }

        if ($_SESSION["lang"] == "tr") {
            $entry[$labels[89]] = $rs["o_description"];
        } else {
            $entry[$labels[89]] = $rs["o_description_en"];
        }

        $entry[$labels[88]] = $rs["o_people"];

        $outp[] = $entry;
    }
} else {
    $sql = "SELECT * FROM orgs ORDER BY o_name ASC";
    $result = $pdo->query($sql);
    $result = $result->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $rs) {
      $entry = [
        "id" => $rs["o_id"],
        "name" => $rs["o_name"],
        "location" => $rs["o_location"],
      ];
      foreach ($bD_properties as $p) {

        $entry[$p[2]] = isset($rs[$p[1]]) ? $rs[$p[1]] : "—";
      }
      $outp[] = $entry;
    }
}
ob_end_clean(); // Clean the output buffer

echo json_encode($outp, JSON_UNESCAPED_UNICODE);
?>
