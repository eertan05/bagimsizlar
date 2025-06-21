<?php
session_start();
include 'db_connect.php';
include 'lang_man.php';

$dbChar = 'utf8';
$p_role = $_SESSION["_role"];

$bD_properties=Array([$labels[34],'o_typeID',$labels[44]],
[$labels[35],'o_definitionID',$labels[45]],
[$labels[36],'o_legalStatusID',$labels[46]],
[$labels[37],'o_fieldID',$labels[47]],
[$labels[38],'o_financialID',$labels[48]],
[$labels[39],'o_activitiesID',$labels[49]],
[$labels[40],'o_resourcesSpaceID',$labels[50]],
[$labels[41],'o_resourcesEquipmentID',$labels[51]],
[$labels[42],'o_resourcesServiceID',$labels[52]],
[$labels[43],'o_audienceID',$labels[53]]
);

if (isset($_SESSION["_logged_in"])) {
  if ($p_role == 1) {

    try {
      $pdo = new PDO(
        "mysql:host=$servername;dbname=$dbname;charset=$dbChar",
        $username,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
      );
    } catch (Exception $ex) {
      die($ex->getMessage());
    }

    // (B) HTTP CSV HEADERS
    if ($_POST['persons']) {
      header("Content-Type: application/octet-stream");
      header("Content-Transfer-Encoding: Binary");
      header("Content-disposition: attachment; filename=\"b_persons.csv\"");
      // (C) GET USERS FROM DATABASE + DIRECT OUTPUT
      $stmt = $pdo->prepare("SELECT * FROM `persons`");
      $stmt->execute();
      while ($row = $stmt->fetch(PDO::FETCH_NAMED)) {
        echo implode(",", [$row['p_id'], $row['p_email'], $row['p_name']]);
        echo "\r\n";
      }
    } else if ($_POST['organizations']) {
      header("Content-Type: application/octet-stream");
      header("Content-Transfer-Encoding: Binary");
      header("Content-disposition: attachment; filename=\"b_organizations.csv\"");
      // (C) GET USERS FROM DATABASE + DIRECT OUTPUT
      $stmt = $pdo->prepare("SELECT * FROM `organizations`");
      $stmt->execute();
      while ($row = $stmt->fetch(PDO::FETCH_NAMED)) {
        echo '"';
        echo implode('","', [$row['o_id'], $row['o_name'], $row['o_shortname'], $row['o_startdate'], $row['o_enddate'], str_replace("\r\n", "", $row['o_description']), str_replace("\r\n", "", $row['o_description_en']), $row['o_people'], $row['o_address'], $row['o_location'], $row['o_website'], $row['o_city'], $row['o_phone'], $row['o_typeID'], $row['o_definitionID'], $row['o_legalStatusID'], $row['o_fieldID'], $row['o_audienceID'], $row['o_activitiesID'], $row['o_financialID'], $row['o_resourcesSpaceID'], $row['o_resourcesServiceID'], $row['o_resourcesEquipmentID']]);
        echo '"';
        echo "\r\n";
      }
    } else if ($_POST['relational']) {
      header("Content-Type: application/octet-stream");
      header("Content-Transfer-Encoding: Binary");
      header("Content-disposition: attachment; filename=\"b_relational.csv\"");
      // (C) GET USERS FROM DATABASE + DIRECT OUTPUT  // 
      $stmt = $pdo->prepare("SELECT organizations.o_name, organizations.o_id, persons.p_name, persons.p_email, persons.p_id, relPerOrg.rpo_id, relPerOrg.rpo_p_id, relPerOrg.rpo_o_id FROM `relPerOrg`
        LEFT JOIN organizations ON relPerOrg.rpo_o_id = organizations.o_id
        LEFT JOIN persons ON relPerOrg.rpo_p_id = persons.p_id
        GROUP BY relPerOrg.rpo_o_id");


      $stmt->execute();
      while ($row = $stmt->fetch(PDO::FETCH_NAMED)) {
        echo '"';
        echo implode('","', [$row['rpo_id'], $row['o_name'], $row['p_name'], $row['p_email']]);
        echo '"';
        echo "\r\n";
      }
    } else if ($_POST['newslist']) {
      header("Content-Type: application/octet-stream");
      header("Content-Transfer-Encoding: Binary");
      header("Content-disposition: attachment; filename=\"b_newslist.csv\"");
      // (C) GET USERS FROM DATABASE + DIRECT OUTPUT  // 
      
      $stmt = $pdo->prepare("SELECT * FROM `persons`");
      $stmt->execute();

      while ($row = $stmt->fetch(PDO::FETCH_NAMED)) {
        if(($row['p_comm']==1)||($row['p_comm']==3)) {
          echo '"';
          echo implode('","', [$row['p_name'], $row['p_email']]);
          echo '"';
          echo "\r\n";
        }
      }

      $stmt = $pdo->prepare("SELECT * FROM `organizations`");
      $stmt->execute();

      while ($row = $stmt->fetch(PDO::FETCH_NAMED)) {
        if(($row['o_comm']==1)||($row['o_comm']==3)) {
          if($row['o_email']!=""){
          echo '"';
          echo implode('","', [$row['o_name'], $row['o_email']]);
          echo '"';
          echo "\r\n";}
        }
      }
    }
    else if ($_POST['coordlist']) {
      header("Content-Type: application/octet-stream");
      header("Content-Transfer-Encoding: Binary");
      header("Content-disposition: attachment; filename=\"b_coordlist.csv\"");
      // (C) GET USERS FROM DATABASE + DIRECT OUTPUT  // 
      
      $stmt = $pdo->prepare("SELECT * FROM `persons`");
      $stmt->execute();

      while ($row = $stmt->fetch(PDO::FETCH_NAMED)) {
        if(($row['p_comm']==2)||($row['p_comm']==3)) {
          echo '"';
          echo implode('","', [$row['p_name'], $row['p_email']]);
          echo '"';
          echo "\r\n";
        }
      }

      $stmt = $pdo->prepare("SELECT * FROM `organizations`");
      $stmt->execute();

      while ($row = $stmt->fetch(PDO::FETCH_NAMED)) {
        if(($row['o_comm']==2)||($row['o_comm']==3)) {
          if($row['o_email']!=""){
          echo '"';
          echo implode('","', [$row['o_name'], $row['o_email']]);
          echo '"';
          echo "\r\n";}
        }
      }
    }
    else if ($_POST['json']) {
      $node_id = 0;
      header("Content-Type: application/octet-stream");
      header("Content-Transfer-Encoding: Binary");
      header("Content-disposition: attachment; filename=\"b_rel.json\"");
      // (C) GET USERS FROM DATABASE + DIRECT OUTPUT  // 
      $stmt = $pdo->prepare("SELECT * FROM `organizations`");
      $stmt->execute();

      $nodes .= '{"nodes":[';
      $edges .= '"links":[';

      //$prop_Unique = 0;
      $propsies=array();
      foreach ($bD_properties as $p) {
        foreach ($dict as $word) {
          if(strcmp($word[1], $p[1]) == 0) {
            $nodes .= '{';
            $nodes .= implode(',', ['"id":'.$node_id ,'"name":"'.$word[5].'"', '"l_id":'.$word[2], '"type":"'.$p[1].'"']); //{"name":"NOBON-İlham Veren İşler #izmirdeoluyor","id":8,"type":"organization"},
            $nodes .= '},';
            $newProp = array( "id" => $node_id,
                            "name" => $word[5],
                            "l_id" => $word[2],
                            "type" => $p[1]);

            array_push($propsies, $newProp);
            //echo "\n".$node_id.">".$p[1].">".$word[5].">".$word[2];
            $node_id++;
          }
        }
      }
      //$lastNode_id=$node_id;
      while ($row = $stmt->fetch(PDO::FETCH_NAMED)) {
        $nodes .= '{';
        $nodes .= implode(',', ['"id":'.$node_id ,'"name":"'.$row['o_name'].'"', '"o_id":'.$row['o_id'], '"type":"organization"']); //{"name":"NOBON-İlham Veren İşler #izmirdeoluyor","id":8,"type":"organization"},
        $nodes .= '},';

        foreach ($bD_properties as $p){
          $actualprops= explode(",", $row[$p[1]]);
          foreach($actualprops as $act_prop) {
            if (is_numeric($act_prop)) {
            $edges .= '{';
            $targ = searchPropertiesName($p[1],$act_prop,$propsies);
            $edges .= implode(',', ['"source":'.$node_id, '"relation":"is"', '"target":'.$targ]); //{"source":0,"relation":"admin of","target":99},
            $edges .= '},';
            }
          }
        }
        $node_id++;
      }

      $stmt = $pdo->prepare("SELECT * FROM `persons`");
      $stmt->execute();
      while ($row = $stmt->fetch(PDO::FETCH_NAMED)) {
        $nodes .= '{';
        $nodes .= implode(',', ['"id":'.$node_id,'"name":"'.$row['p_name'].'"', '"p_id":'.$row['p_id'], '"type":"person"']); //{"name":"NOBON-İlham Veren İşler #izmirdeoluyor","id":8,"type":"organization"},
        $nodes .= '},';
        $node_id++;
      }
      $nodes=mb_substr($nodes, 0, -1);
      $nodes .= '],';
      $edges=mb_substr($edges, 0, -1);
      $edges .= ']}';
      echo $nodes;
      echo $edges;
    }
  }
} else {
  header("Location: crud_person.php ");
}

function searchPropertiesName($stype, $sid, $sarray) {
  foreach ($sarray as $prop){
    if ((strcmp($prop["type"], $stype) == 0) && ($prop["l_id"] == $sid)){
        return $prop["id"];
    }
  }
  return null;
}