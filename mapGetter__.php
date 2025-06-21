<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'paths.php';
include 'db_connect.php';
include 'lang_man.php';

$labelField="bD_".$_SESSION["lang"]."Label";

if ( isset( $_GET['id'] ) && !empty( $_GET['id'] ) ) {
  $n_id = "".$_GET['id'];

  $sql = "SELECT * FROM orgs WHERE o_id =".$n_id;

  $result = $conn->query($sql);

  $outp = "[";
  while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
      if ($outp != "[") {$outp .= ",";}
      else {$outp .= "{";}
      $outp .= '"'.$labels[67].'":"' . $rs["o_name"] . '",';
      $outp .= '"'.$labels[62].'":"' . $rs["o_city"] . '",';
      $outp .= '"'.$labels[61].'":"' . $rs["o_address"] . '",';
      $outp .= '"'.$labels[65].'":"' . $rs["o_phone"] . '",';
      $outp .= '"'.$labels[66].'":"'  . $rs["o_website"] . '"';

      foreach ($bD_properties as $p){
        $outp .= ',"'.$p[2].'":"';
        $outpP="";
        if(isset($rs[$p[1]]))
        if($rs[$p[1]]!=""&&$rs[$p[1]]!=" ") {
          $pieces = explode(",", $rs[$p[1]]);
          foreach ($pieces as $pie){
            // looking for the name
            $sql2 = "SELECT * FROM baseDictionary WHERE bD_property='$p[1]' AND bD_index= ".$pie;
            $result2 = $conn->query($sql2);
            if ($result2->num_rows == 0) {
              $error = "error on ".$p[1];
            } else {
              $n2 = mysqli_fetch_array($result2);
              if ($outpP != "") {$outpP .= ", ";}
              $outpP .= $n2[$labelField];
            }
          }
      }
      if ($outpP=="") $outpP="—";
      $outp .=$outpP.'"';
    }
    if($_SESSION["lang"] == "tr")  $outp .= ',"'.$labels[89].'":"' . $rs["o_description"]  . '"';
    else  $outp .= ',"'.$labels[89].'":"' . $rs["o_description_en"]  . '"';
    $outp .= ',"'.$labels[88].'":"' . $rs["o_people"]  . '"';
    $outp .='}]';
    $outp = str_replace(array("\r", "\n"), '<br>', $outp);
  }
} else {
  $result = $conn->query("SELECT * FROM orgs ORDER BY o_name ASC");

  $outp = "";
  while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
      if ($outp != "[") {$outp .= ",";}
      $outp .= '{"id":"' . $rs["o_id"] . '",';
      $outp .= '"name":"' . $rs["o_name"] . '",';
      $outp .= '"location":"' . $rs["o_location"]  . '"';

      foreach ($bD_properties as $p){
        $outp .= ',"'.$p[2].'":"';
        $outpP = "";
        if(isset($rs[$p[1]]))
        if($rs[$p[1]]!= "") {
          $outpP .= $rs[$p[1]];
        }
        if ($outpP == "") $outpP = "—";
        $outp .= $outpP.'"';
      }
      $outp .= '}';
  }
  $outp .="]";
}

$conn->close();
echo json_encode($outp, JSON_UNESCAPED_UNICODE);
?>
