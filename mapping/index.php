<?php
session_start();
include "../header.php";
?>

<head>
  <link rel="stylesheet" href="mapping.css">
  <link rel="stylesheet" href="window-engine.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

  <?php
  /**************** createByPeople ****************************/
  /**************** createByPeople ****************************/
  /**************** createByPeople ****************************/

  function createByPeople()
  {
    global $pdo;
    // ------- creating b_rel.JSON
    ($myfile = fopen("uploads/byPeople.json", "w")) or die("Unable to open file!");

    // Assuming $pdo is your PDO connection

    $stmt = $pdo->prepare(
        "SELECT o.o_id, o.o_name, o.o_typ, o.o_def, GROUP_CONCAT(COALESCE(bd.bD_trLabel, bd.bD_trLabel)) AS o_typ_words FROM orgs o LEFT JOIN (SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(o_typ, ',', n.n), ',', -1) AS typ_id, o_id FROM orgs JOIN (SELECT 1 AS n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10) n ON LENGTH(o_typ) - LENGTH(REPLACE(o_typ, ',', '')) >= n.n - 1) AS split_typ_ids ON o.o_id = split_typ_ids.o_id LEFT JOIN baseDictionary bd ON split_typ_ids.typ_id = bd.bD_iD GROUP BY o.o_id, o.o_name, o.o_typ, o.o_def;"
    );

    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row) {
      echo "Org ID: " .
        $row["o_id"] .
        ", Org Name: " .
        $row["o_name"] .
        ", o_typ: " .
        $row["o_typ"] .
        ", o_def: " .
        $row["o_def"] .
        ", Types: " .
        $row["o_typ_words"] .
        "<br>";
    }

    $node_id = 0;
    $nodes .= '{"nodes":[';
    $edges .= '"links":[';

    //$prop_Unique = 0;
    $propsies = [];
    foreach ($bD_properties as $p) {
      foreach ($dict as $word) {
        if (strcmp($word[1], $p[1]) == 0) {
          $nodes .= "{";
          $nodes .= implode(",", [
            '"id":' . $node_id,
            '"name":"' . $word[5] . '"',
            '"l_id":' . $word[2],
            '"type":"' . $p[1] . '"',
          ]); //{"name":"NOBON-İlham Veren İşler #izmirdeoluyor","id":8,"type":"organization"},
          $nodes .= "},";
          $newProp = ["id" => $node_id, "name" => $word[5], "l_id" => $word[2], "type" => $p[1]];
          array_push($propsies, $newProp);
          $node_id++;
        }
      }
    }

    //$lastNode_id=$node_id;
    while ($row = $stmt->fetch(PDO::FETCH_NAMED)) {
      $nodes .= "{";
      $nodes .= implode(",", [
        '"id":' . $node_id,
        '"name":"' . $row["o_name"] . '"',
        '"o_id":' . $row["o_id"],
        '"type":"o_organizationID"',
      ]); //{"name":"NOBON-İlham Veren İşler #izmirdeoluyor","id":8,"type":"organization"},
      $nodes .= "},";

      foreach ($bD_properties as $p) {
        $actualprops = explode(",", $row[$p[1]]);
        foreach ($actualprops as $act_prop) {
          if (is_numeric($act_prop)) {
            $edges .= "{";
            $targ = searchPropertiesName($p[1], $act_prop, $propsies);
            $edges .= implode(",", ['"source":' . $node_id, '"relation":"is"', '"target":' . $targ]); //{"source":0,"relation":"admin of","target":99},
            $edges .= "},";
          }
        }
      }
      $node_id++;
    }
    $stmt = $pdo->prepare("SELECT * FROM `persons`");
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_NAMED)) {
      $nodes .= "{";
      $nodes .= implode(",", [
        '"id":' . $node_id,
        '"name":"' . $row["p_name"] . '"',
        '"p_id":' . $row["p_id"],
        '"type":"o_personID"',
      ]); //{"name":"NOBON-İlham Veren İşler #izmirdeoluyor","id":8,"type":"organization"},
      $nodes .= "},";
      $node_id++;
    }

    $nodes = mb_substr($nodes, 0, -1);
    $nodes .= "],";
    $edges = mb_substr($edges, 0, -1);
    $edges .= "]}";
    fwrite($myfile, $nodes . $edges);
    fclose($myfile);
  }

  /**************** createByLegalStatus *****************************************/
  /**************** createByLegalStatus *****************************************/
  /**************** createByLegalStatus *****************************************/
  function createByLegalStatus()
  {
    global $pdo;

    $filename = "uploads/byLegalStatus.json";
      if (file_exists($filename)) {
        $file_modified_time = filemtime($filename);
        $one_week_ago = strtotime("-1 week");

        // if the file is older than one week.
        if ($file_modified_time > $one_week_ago) {
          $stmt = $pdo->prepare(
                  "SELECT o.o_name, GROUP_CONCAT(DISTINCT bd_leg.bD_trLabel SEPARATOR ', ') AS o_leg_words, GROUP_CONCAT(DISTINCT bd_typ.bD_trLabel SEPARATOR ', ') AS o_typ_words FROM orgs o LEFT JOIN (SELECT o.o_name, SUBSTRING_INDEX(SUBSTRING_INDEX(o.o_leg, ',', n.n), ',', -1) AS typ_id FROM orgs o JOIN (SELECT 1 AS n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10) n ON LENGTH(o.o_leg) - LENGTH(REPLACE(o.o_leg, ',', '')) >= n.n - 1) AS split_leg ON o.o_name = split_leg.o_name LEFT JOIN baseDictionary bd_leg ON split_leg.typ_id = bd_leg.bD_index AND bd_leg.bD_property = 'o_leg' LEFT JOIN (SELECT o.o_name, SUBSTRING_INDEX(SUBSTRING_INDEX(o.o_typ, ',', n.n), ',', -1) AS typ_id FROM orgs o JOIN (SELECT 1 AS n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10) n ON LENGTH(o.o_typ) - LENGTH(REPLACE(o.o_typ, ',', '')) >= n.n - 1) AS split_typ ON o.o_name = split_typ.o_name LEFT JOIN baseDictionary bd_typ ON split_typ.typ_id = bd_typ.bD_index AND bd_typ.bD_property = 'o_typ' GROUP BY o.o_name;"
          );

          $stmt->execute();
          $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

          echo "<pre>";
          echo "</pre>";

          $nodes = [];
          $links = [];
          $node_id = 0; // Initialize node ID

          foreach ($results as $row) {
            $orgName = $row["o_name"];
            $legWords = explode(", ", $row["o_leg_words"]);
            $typWords = explode(", ", $row["o_typ_words"]);

            // Add organization node (check if it exists)
            $orgNodeExists = false;
            foreach ($nodes as $node) {
              if ($node["name"] === $orgName && $node["type"] === "organization") {
                $orgNodeExists = true;
                $orgID = $node["id"]; // Get existing org ID
                break;
              }
            }

            if (!$orgNodeExists) {
                $nodes[] = ["id" => $node_id, "name" => $orgName, "type" => "organization"];
                $orgID = $node_id;
                $node_id++;
            }

            // Add o_leg links (check if node exists)
            foreach ($legWords as $legWord) {
              if (!empty($legWord)) {
                $legNodeExists = false;
                foreach ($nodes as $node) {
                  if ($node["name"] === $legWord && $node["type"] === "o_leg") {
                    $legNodeExists = true;
                    $legNodeId = $node["id"]; // Get existing leg node ID
                    break;
                  }
                }
                if (!$legNodeExists) {
                  $nodes[] = ["id" => $node_id, "name" => $legWord, "type" => "o_leg"];
                  $legNodeId = $node_id;
                  $node_id++;
                }
                $links[] = ["source" => $orgID, "target" => $legNodeId, "relation" => "is"];
              }
            }

            // Add o_typ links (check if node exists)
            foreach ($typWords as $typWord) {
              if (!empty($typWord)) {
                $typNodeExists = false;
                foreach ($nodes as $node) {
                  if ($node["name"] === $typWord && $node["type"] === "o_typ") {
                    $typNodeExists = true;
                    $typNodeId = $node["id"]; // Get existing typ node ID
                    break;
                  }
                }
                if (!$typNodeExists) {
                  $nodes[] = ["id" => $node_id, "name" => $typWord, "type" => "o_typ"];
                  $typNodeId = $node_id;
                  $node_id++;
                }
                $links[] = ["source" => $orgID, "target" => $typNodeId, "relation" => "is"];
              }
            }
          }
          // Remove duplicate nodes (if needed)
          $nodes = array_unique($nodes, SORT_REGULAR);

          $graphData = ["nodes" => $nodes, "links" => $links];
          $jsonString = json_encode($graphData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); // Encode to JSON
          ($myfile = fopen($filename, "w")) or die("Unable to open file!");
          fwrite($myfile, $jsonString); // Write the JSON string to the file
          fclose($myfile);
        }
      }
    }

  /**************** createByField *****************************************/
  /**************** createByField *****************************************/
  /**************** createByField *****************************************/

  function createByField() {
    global $pdo;

    $filename = "uploads/byField.json";
      if (file_exists($filename)) {
        $file_modified_time = filemtime($filename);
        $one_week_ago = strtotime("-1 week");

      if ($file_modified_time > $one_week_ago) {

        $stmt = $pdo->prepare(
          "SELECT o.o_name, GROUP_CONCAT(DISTINCT bd_def.bD_trLabel SEPARATOR ', ') AS o_def_words, GROUP_CONCAT(DISTINCT bd_fow.bD_trLabel SEPARATOR ', ') AS o_fow_words FROM orgs o LEFT JOIN (SELECT o.o_name, SUBSTRING_INDEX(SUBSTRING_INDEX(o.o_def, ',', n.n), ',', -1) AS typ_id FROM orgs o JOIN (SELECT 1 AS n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10) n ON LENGTH(o.o_def) - LENGTH(REPLACE(o.o_def, ',', '')) >= n.n - 1) AS split_def ON o.o_name = split_def.o_name LEFT JOIN baseDictionary bd_def ON split_def.typ_id = bd_def.bD_index AND bd_def.bD_property = 'o_def' LEFT JOIN (SELECT o.o_name, SUBSTRING_INDEX(SUBSTRING_INDEX(o.o_fow, ',', n.n), ',', -1) AS typ_id FROM orgs o JOIN (SELECT 1 AS n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10) n ON LENGTH(o.o_fow) - LENGTH(REPLACE(o.o_fow, ',', '')) >= n.n - 1) AS split_fow ON o.o_name = split_fow.o_name LEFT JOIN baseDictionary bd_fow ON split_fow.typ_id = bd_fow.bD_index AND bd_fow.bD_property = 'o_fow' GROUP BY o.o_name;"
        );

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<pre>";
          //print_r($results);
        echo "</pre>";

        $nodes = [];
        $links = [];
        $node_id = 0; // Initialize node ID

        foreach ($results as $row) {
          $orgName = $row["o_name"];
          $defWords = explode(", ", $row["o_def_words"]);
          $fowWords = explode(", ", $row["o_fow_words"]);

          // Add organization node (check if it exists)
          $orgNodeExists = false;
          foreach ($nodes as $node) {
            if ($node["name"] === $orgName && $node["type"] === "organization") {
              $orgNodeExists = true;
              $orgID = $node["id"]; // Get existing org ID
              break;
            }
          }

          if (!$orgNodeExists) {
            $nodes[] = ["id" => $node_id, "name" => $orgName, "type" => "organization"];
            $orgID = $node_id;
            $node_id++;
          }

          // Add o_def links (check if node exists)
          foreach ($defWords as $defWord) {
            if (!empty($defWord)) {
              $defNodeExists = false;
              foreach ($nodes as $node) {
                if ($node["name"] === $defWord && $node["type"] === "o_def") {
                  $defNodeExists = true;
                  $defNodeId = $node["id"]; // Get existing def node ID
                  break;
                }
              }

              if (!$defNodeExists) {
                $nodes[] = ["id" => $node_id, "name" => $defWord, "type" => "o_def"];
                $defNodeId = $node_id;
                $node_id++;
              }
              $links[] = ["source" => $orgID, "target" => $defNodeId, "relation" => "is"];
            }
          }

          // Add o_fow links (check if node exists)

          foreach ($fowWords as $fowWord) {
            if (!empty($fowWord)) {
              $fowNodeExists = false;
              foreach ($nodes as $node) {
                if ($node["name"] === $fowWord && $node["type"] === "o_fow") {
                  $fowNodeExists = true;
                  $fowNodeId = $node["id"]; // Get existing fow node ID
                  break;
                }
              }

            if (!$fowNodeExists) {
              $nodes[] = ["id" => $node_id, "name" => $fowWord, "type" => "o_fow"];
              $fowNodeId = $node_id;
              $node_id++;
            }
            $links[] = ["source" => $orgID, "target" => $fowNodeId, "relation" => "is"];
            }
          }
        }

        // Remove duplicate nodes (if needed)
        $nodes = array_unique($nodes, SORT_REGULAR);
        $graphData = ["nodes" => $nodes, "links" => $links];
        //echo json_encode($graphData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); // Important!
        $jsonString = json_encode($graphData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); // Encode to JSON
        ($myfile = fopen($filename, "w")) or die("Unable to open file!");
        fwrite($myfile, $jsonString); // Write the JSON string to the file
        fclose($myfile);
      }
    }
  }

  /**************** createByFinance *****************************************/
  /**************** createByFinance *****************************************/
  /**************** createByFinance *****************************************/
  function createByFinance(){
    global $pdo;

    $filename = "uploads/byFinance.json";
    if (file_exists($filename)) {
    $file_modified_time = filemtime($filename);
    $one_week_ago = strtotime("-1 week");

      if ($file_modified_time > $one_week_ago) {

        $stmt = $pdo->prepare(
          "SELECT o.o_name, GROUP_CONCAT(DISTINCT bd_tar.bD_trLabel SEPARATOR ', ') AS o_tar_words, GROUP_CONCAT(DISTINCT bd_fin.bD_trLabel SEPARATOR ', ') AS o_fin_words FROM orgs o LEFT JOIN (SELECT o.o_name, SUBSTRING_INDEX(SUBSTRING_INDEX(o.o_tar, ',', n.n), ',', -1) AS typ_id FROM orgs o JOIN (SELECT 1 AS n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10) n ON LENGTH(o.o_tar) - LENGTH(REPLACE(o.o_tar, ',', '')) >= n.n - 1) AS split_tar ON o.o_name = split_tar.o_name LEFT JOIN baseDictionary bd_tar ON split_tar.typ_id = bd_tar.bD_index AND bd_tar.bD_property = 'o_tar' LEFT JOIN (SELECT o.o_name, SUBSTRING_INDEX(SUBSTRING_INDEX(o.o_fin, ',', n.n), ',', -1) AS typ_id FROM orgs o JOIN (SELECT 1 AS n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10) n ON LENGTH(o.o_fin) - LENGTH(REPLACE(o.o_fin, ',', '')) >= n.n - 1) AS split_fin ON o.o_name = split_fin.o_name LEFT JOIN baseDictionary bd_fin ON split_fin.typ_id = bd_fin.bD_index AND bd_fin.bD_property = 'o_fin' GROUP BY o.o_name;"
        );

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<pre>";
          //print_r($results);
        echo "</pre>";

        $nodes = [];
        $links = [];
        $node_id = 0; // Initialize node ID

        foreach ($results as $row) {
          $orgName = $row["o_name"];
          $tarWords = explode(", ", $row["o_tar_words"]);
          $finWords = explode(", ", $row["o_fin_words"]);

          // Add organization node (check if it exists)
          $orgNodeExists = false;
          foreach ($nodes as $node) {
            if ($node["name"] === $orgName && $node["type"] === "organization") {
              $orgNodeExists = true;
              $orgID = $node["id"]; // Get existing org ID
              break;
            }
          }

          if (!$orgNodeExists) {
            $nodes[] = ["id" => $node_id, "name" => $orgName, "type" => "organization"];
            $orgID = $node_id;
            $node_id++;
          }

          // Add o_tar links (check if node exists)
          foreach ($tarWords as $tarWord) {
            if (!empty($tarWord)) {
              $tarNodeExists = false;
              foreach ($nodes as $node) {
                if ($node["name"] === $tarWord && $node["type"] === "o_tar") {
                  $tarNodeExists = true;
                  $tarNodeId = $node["id"]; // Get existing tar node ID
                  break;
                }
              }
              if (!$tarNodeExists) {
                $nodes[] = ["id" => $node_id, "name" => $tarWord, "type" => "o_tar"];
                $tarNodeId = $node_id;
                $node_id++;
              }
              $links[] = ["source" => $orgID, "target" => $tarNodeId, "relation" => "is"];
            }
          }

          // Add o_fin links (check if node exists)
          foreach ($finWords as $finWord) {
            if (!empty($finWord)) {
              $finNodeExists = false;
              foreach ($nodes as $node) {
                if ($node["name"] === $finWord && $node["type"] === "o_fin") {
                  $finNodeExists = true;
                  $finNodeId = $node["id"]; // Get existing fin node ID
                  break;
                }
              }
              if (!$finNodeExists) {
                $nodes[] = ["id" => $node_id, "name" => $finWord, "type" => "o_fin"];
                $finNodeId = $node_id;
                $node_id++;
              }
              $links[] = ["source" => $orgID, "target" => $finNodeId, "relation" => "is"];
            }
          }
        }
        // Remove duplicate nodes (if needed)
        $nodes = array_unique($nodes, SORT_REGULAR);

        $graphData = ["nodes" => $nodes, "links" => $links];
        $jsonString = json_encode($graphData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); // Encode to JSON
        ($myfile = fopen($filename, "w")) or die("Unable to open file!");
        fwrite($myfile, $jsonString); // Write the JSON string to the file
        fclose($myfile);
      }
    }
  }

  /**************** createByResources *****************************************/
  /**************** createByResources *****************************************/
  /**************** createByResources *****************************************/
  function createByResources(){
    global $pdo;

    $filename = "uploads/byResources.json";
    if (file_exists($filename)) {
      $file_modified_time = filemtime($filename);
      $one_week_ago = strtotime("-1 week");

      // Check if the file is older than one week.
      if ($file_modified_time > $one_week_ago) {
        $stmt = $pdo->prepare(
          "SELECT o.o_name, GROUP_CONCAT(DISTINCT bd_pla.bD_trLabel SEPARATOR ', ') AS o_pla_words, GROUP_CONCAT(DISTINCT bd_equ.bD_trLabel SEPARATOR ', ') AS o_equ_words, GROUP_CONCAT(DISTINCT bd_ser.bD_trLabel SEPARATOR ', ') AS o_ser_words FROM orgs o LEFT JOIN (SELECT o.o_name, SUBSTRING_INDEX(SUBSTRING_INDEX(o.o_pla, ',', n.n), ',', -1) AS typ_id FROM orgs o JOIN (SELECT 1 AS n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10) n ON LENGTH(o.o_pla) - LENGTH(REPLACE(o.o_pla, ',', '')) >= n.n - 1) AS split_pla ON o.o_name = split_pla.o_name LEFT JOIN baseDictionary bd_pla ON split_pla.typ_id = bd_pla.bD_index AND bd_pla.bD_property = 'o_pla' LEFT JOIN (SELECT o.o_name, SUBSTRING_INDEX(SUBSTRING_INDEX(o.o_equ, ',', n.n), ',', -1) AS typ_id FROM orgs o JOIN (SELECT 1 AS n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10) n ON LENGTH(o.o_equ) - LENGTH(REPLACE(o.o_equ, ',', '')) >= n.n - 1) AS split_equ ON o.o_name = split_equ.o_name LEFT JOIN baseDictionary bd_equ ON split_equ.typ_id = bd_equ.bD_index AND bd_equ.bD_property = 'o_equ' LEFT JOIN (SELECT o.o_name, SUBSTRING_INDEX(SUBSTRING_INDEX(o.o_ser, ',', n.n), ',', -1) AS typ_id FROM orgs o JOIN (SELECT 1 AS n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10) n ON LENGTH(o.o_ser) - LENGTH(REPLACE(o.o_ser, ',', '')) >= n.n - 1) AS split_ser ON o.o_name = split_ser.o_name LEFT JOIN baseDictionary bd_ser ON split_ser.typ_id = bd_ser.bD_index AND bd_ser.bD_property = 'o_ser' GROUP BY o.o_name;"
        );

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $nodes = [];
        $links = [];
        $node_id = 0; // Initialize node ID

        foreach ($results as $row) {
          $orgName = $row["o_name"];
          $plaWords = explode(", ", $row["o_pla_words"]);
          $equWords = explode(", ", $row["o_equ_words"]);
          $serWords = explode(", ", $row["o_ser_words"]);

          // Add organization node (check if it exists)
          $orgNodeExists = false;
          foreach ($nodes as $node) {
            if ($node["name"] === $orgName && $node["type"] === "organization") {
              $orgNodeExists = true;
              $orgID = $node["id"]; // Get existing org ID
              break;
            }
          }

          if (!$orgNodeExists) {
            $nodes[] = ["id" => $node_id, "name" => $orgName, "type" => "organization"];
            $orgID = $node_id;
            $node_id++;
          }

          // Add o_pla links (check if node exists)
          foreach ($plaWords as $plaWord) {
            if (!empty($plaWord)) {
              $plaNodeExists = false;
              foreach ($nodes as $node) {
                if ($node["name"] === $plaWord && $node["type"] === "o_pla") {
                    $plaNodeExists = true;
                    $plaNodeId = $node["id"]; // Get existing pla node ID
                    break;
                }
              }
              if (!$plaNodeExists) {
                $nodes[] = ["id" => $node_id, "name" => $plaWord, "type" => "o_pla"];
                $plaNodeId = $node_id;
                $node_id++;
              }
              $links[] = ["source" => $orgID, "target" => $plaNodeId, "relation" => "is"];
            }
          }

          // Add o_equ links (check if node exists)
          foreach ($equWords as $equWord) {
            if (!empty($equWord)) {
              $equNodeExists = false;
              foreach ($nodes as $node) {
                if ($node["name"] === $equWord && $node["type"] === "o_equ") {
                  $equNodeExists = true;
                  $equNodeId = $node["id"]; // Get existing equ node ID
                  break;
                }
              }
              if (!$equNodeExists) {
                $nodes[] = ["id" => $node_id, "name" => $equWord, "type" => "o_equ"];
                $equNodeId = $node_id;
                $node_id++;
              }
              $links[] = ["source" => $orgID, "target" => $equNodeId, "relation" => "is"];
            }
          }

          // Add o_ser links (check if node exists)
          foreach ($serWords as $serWord) {
            if (!empty($serWord)) {
              $serNodeExists = false;
              foreach ($nodes as $node) {
                if ($node["name"] === $serWord && $node["type"] === "o_ser") {
                  $serNodeExists = true;
                  $serNodeId = $node["id"]; // Get existing ser node ID
                  break;
                }
              }
              if (!$serNodeExists) {
                $nodes[] = ["id" => $node_id, "name" => $serWord, "type" => "o_ser"];
                $serNodeId = $node_id;
                $node_id++;
              }
              $links[] = ["source" => $orgID, "target" => $serNodeId, "relation" => "is"];
            }
          }
        }
        // Remove duplicate nodes (if needed)
        $nodes = array_unique($nodes, SORT_REGULAR);

        $graphData = ["nodes" => $nodes, "links" => $links];
        $jsonString = json_encode($graphData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); // Encode to JSON
        ($myfile = fopen($filename, "w")) or die("Unable to open file!");
        fwrite($myfile, $jsonString); // Write the JSON string to the file
        fclose($myfile);
      }
    }
  }
  /*********************************************************/
  function searchPropertiesName($stype, $sid, $sarray)
  {
      foreach ($sarray as $prop) {
          if (strcmp($prop["type"], $stype) == 0 && $prop["l_id"] == $sid) {
              return $prop["id"];
          }
      }
      return null;
  }
  ?>

  <div id="nav-data" style="display:block;">

    <?php
    //------- loading data files --->
    $mydir = "uploads";
    $myfiles = scandir($mydir);
    echo "<span class='mapLink'>";
    foreach ($myfiles as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'json') {
            echo "<a href='?f=" . $file . "'>" . explode(".", $file)[0] . "</a>";
        }
    }
    echo "</span>";

    createByField();
    createByFinance();
    createByLegalStatus();
    createByResources();
    ?>

  </div>





  <div class="windowGroup smallText">

    <!-- WINDOW 1 -->
    <div id="window1" class="window">
      <div class="gray">
        <p class="windowTitle">filters</p>
      </div>
      <div class="mainWindow" id="filtercheckboxes">
      </div>
    </div>

    <!-- WINDOW 2 -->
    <div id="window2" class="window fade">
      <div class="gray">
        <p class="windowTitle">node information</p>
      </div>
      <div id="nodeInfo" class="mainWindow">
      </div>
    </div>

    <!-- WINDOW 3 -->
    <div id="window3" class="window fade developer">
      <div class="crimson">
        <p class="windowTitle">load data</p>
      </div>
      <div id="loadData" class="mainWindow">
        <script lang="javascript" src="js/xlsx.full.min.js" type="text/javascript"></script>
        <script>
          $(document).ready(function() {
            $("#fileUploader").change(function(evt) {
              var selectedFile = evt.target.files[0];
              var reader = new FileReader();
              reader.onload = function(event) {
                var data = event.target.result;
                var workbook = XLSX.read(data, {
                  type: 'binary'
                });

                var json_object = [];
                workbook.SheetNames.forEach(function(sheetName) {
                  if (sheetName == "nodes" || sheetName == "NODES") {
                    var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                    json_object[0] = JSON.stringify(XL_row_object);
                  }
                  if (sheetName == "edges" || sheetName == "EDGES") {
                    var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                    json_object[1] = JSON.stringify(XL_row_object);
                  }
                });

                json_object = '{"nodes":' + json_object[0] + ', "links":' + json_object[1] + '}';
                //document.getElementById("jsonObject").innerHTML = json_object;

                // save JSON files on Server
                blobajax(json_object);

              };

              reader.onerror = function(event) {
                console.error("File could not be read! Code " + event.target.error.code);
              };

              reader.readAsBinaryString(selectedFile);
            });

            function blobajax(cont) {
              // (A) CREATE BLOB OBJECT
              var myBlob = new Blob([cont], {
                type: "text/plain"
              });
              // (B) FORM DATA
              var data = new FormData();
              var n = $("#fileName").val() + ".json"
              data.append("upfile", myBlob, n);
              // (C) AJAX UPLOAD TO SERVER
              var xhr = new XMLHttpRequest();
              xhr.open("POST", "upload.php");
              xhr.onload = function() {
                if (this.status == 200) {
                  //location.reload();
                  window.location.href = window.location.href.replace(/[\?#].*|$/, "?f=" + n);
                } else {
                  document.getElementById("jsonObject").innerHTML = "ERROR. please check the excel file and try again";
                }
              };
              xhr.send(data);
            }


            $("#fileName").keyup(function() {
              $("#fb").css("display", "block");
            });

          });
        </script>

        <p>
          You can upload your data as an excel file.
          It should have two sheets named "NODES" and "EDGES"</p>
        <hr>
        <p> NODES column names must be:
          id, name, type, info, value (the last two are optional)<br>
          <br>
          (value sorts nodes on a horizontal line;<br>
          info is shown when node clicked)
        </p>
        <hr>
        <p> EDGES column names must be:
          source, destination, relation</p>
        <hr>
        <p>see example files: <br>
          <img src="images/NODES.png" width="200px" ;><br>
          <img src="images/EDGES.png" width="200px" ;>
        </p>


        <label id="jsonObjectLink">upload a new excel file </label>
        <div>
          <span class="smallText">name your file to access later<br></span>
          <input type="text" id="fileName" name="fileName">
        </div>
        <div id="fb">
          <span class="smallText">select your excel file<br></span>
          <input type="file" id="fileUploader" name="fileUploader" accept=".xls, .xlsx" />
        </div>
      </div>
    </div>
  </div>
  <footer>
    <span id="button1">filters</span>
    <span id="button2">node info</span>
    <label class="largeCheckbox"><input type="checkbox" id="trackingMode"><span class="mark"></span>tracking mode</label>
    <span id="button3" class="admin">load your data</span>
  </footer>
  <svg id='viz'></svg>

<script src='https://d3js.org/d3.v5.min.js'></script>
<script>
  var width = window.innerWidth; // window.innerWidth * window.devicePixelRatio;
  var height = window.innerHeight;

  console.log(width)

  var controls = {};
  var keepFocused = false;
  var focusIndex = "";
  var mapNodeSize = createRemap(0, 300, 5, 100);
  var jsonFile;
  var dataFile;
  var theH = window.height;

  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  var file = urlParams.get('f')
  var admin = urlParams.get('admin') != null ? 1 :0;
  if (file == null)  file = "byField.json";
  dataFile = "uploads/" + file;

  var color;
  switch (file) {
    case "byField.json":
      color = d3.scaleOrdinal()
        .domain(d3.range(4)) // domain length should match range length
        .range(["#00BFDD", "#A8353A", "#FAA21B", "#F58320" ]);
      break;

    case "byFinance.json":
      color = d3.scaleOrdinal()
        .domain(d3.range(7))
        .range(["#00BFDD", "#4B8B40","#F15E3E","#008DA8", "#006168", "#21B56E", "#008DA8"]);
      break;

    case "byLegalStatus.json":
      color = d3.scaleOrdinal()
        .domain(d3.range(9))
        .range(["#00BFDD","#76BC43", "#F15E3E","#CEB52C", "#F58320", "#FFCE02", "#F15E3E", "#A8353A", "#762157", "#231F20"]);
      break;

      case "byResources.json":
        color = d3.scaleOrdinal()
          .domain(d3.range(5))
          .range(["#00BFDD", "#F15E3E", "#A8353A", "#762157", "#231F20"]);
        break;

    default:
    color = d3.scaleOrdinal()
      .domain(d3.range(4)) // domain length should match range length
      .range(["#00BFDD", "#A8353A", "#FAA21B", "#F58320" ]);
      break;
  }


  d3.json(dataFile).then(function(graph) {
    graph.nodes.forEach(function(d) {
      d.size = 0;
      if (!(d.type in controls) ) {
        controls[d.type] = true;
      }
    });

    Object.entries(controls).forEach(([key, value]) => {
      //replace the names if required
      //if (file.startsWith("b_rel")){keyShown = key.slice(2,-2);}else {keyShown = key;}
      switch (key) {
        case 'o_def':
          keyShown = 'definition';
          break; // Important! Prevents fall-through
        case 'o_fow':
          keyShown = 'field of work';
          break;
        case 'o_tar':
          keyShown = 'audience';
          break; // Important! Prevents fall-through
        case 'o_fin':
          keyShown = 'financial';
          break;
        case 'o_typ':
          keyShown = 'type';
          break; // Important! Prevents fall-through
        case 'o_leg':
          keyShown = 'legal status';
        break;
        case 'organization':
          keyShown = 'organization';
        break;
        case 'o_equ':
          keyShown = 'equipment';
        break;
        case 'o_ser':
          keyShown = 'services';
        break;
        case 'o_pla':
          keyShown = 'places';
        break;
      }
    // create the checkbox in window1
      document.getElementById("filtercheckboxes").innerHTML += '<input type="checkbox" class="types" id=' + key + ' value=' + key + ' checked> <span style="color:' + color(key) + '; font-weight:bold" >' + keyShown + '</span></br>'
    });
    theH = Object.entries(controls).length * 20 + 120;
    button1.click(theH);


    var graphLayout = d3.forceSimulation(graph.nodes)
      .force("charge", d3.forceManyBody().strength(-3000))
      .force("center", d3.forceCenter(width / 2, height / 2))
      .force("x", d3.forceX(width / 2).strength(1))
      .force("y", d3.forceY(height / 2).strength(1))
      .force("link", d3.forceLink(graph.links).id(function(d){
        return d.id}).distance(500).strength(0.1))
        // d.name vs d.id but couldnot make it based on the index; it looks for id/name  somewhere
      .on("tick", ticked);

    var adjlist = [];
    graph.links.forEach(function(d) {
      adjlist[d.source.index + "-" + d.target.index] = true;
      adjlist[d.target.index + "-" + d.source.index] = true;
      graph.nodes[d.source.index].size++;
      graph.nodes[d.target.index].size++;
    });

    function isNeighbor(a, b) {
      return (a == b || adjlist[a + "-" + b]);
    }

    d3.selectAll("#filtercheckboxes .types").on("click", function() {
      controls[this.value] = this.checked;
      showHide();
    });

    d3.select("#trackingMode").on("click", function() {
      keepFocused = this.checked;
      if (!keepFocused) focusIndex = "";
      node.call(refresh);
    });


    d3.selectAll(".admin")
      .style("display", function(){ return admin? "inline" : "none"});

    var svg = d3.select("#viz").attr("width", width).attr("height", height);
    var container = svg.append("g");

    svg.call(
      d3.zoom()
      .scaleExtent([.1, 7])
      .on("zoom", function() {
        container.attr("transform", d3.event.transform);
      })
    );

    var link = container.append("g").attr("class", "links")
      .selectAll("line")
      .data(graph.links)
      .enter()
      .append("line")
      .attr("stroke", function(d) {  return color(d.relation); })
      .attr("opacity", .4)
      .attr("stroke-width", .5);

    var node = container.append("g").attr("class", "nodes")
      .selectAll("node")
      .data(graph.nodes)
      .enter()
      .append("svg:circle")
      .attr("class", "circle")
      .attr("r", function(d) {return mapNodeSize(d.size); })
      .attr("fill", function(d) {  return color(d.type); });
      //    .attr("x", function(d){return d.x})
      //    .attr("y", function(d){return d.y});

    node.on("mouseover", focus).on("mouseout", unfocus);

    node.call(
      d3.drag()
      .on("start", dragstarted)
      .on("drag", dragged)
      .on("end", dragended)
    );

    var labelNode = container.append("g").attr("class", "labelNodes")
      .selectAll("text")
      .data(graph.nodes)
      .enter()
      .append("text")
      .text(function(d) {
        return d.name;
      })
      .attr("dx", function(d) {
        return mapNodeSize(d.size) + 2;
      })
      .attr("dy", function(d) {
        return mapNodeSize(d.size) / 2;
      })
      .style("fill", "#555")
      .style("font-family", "Helvetica")
      .style("font-size", "12px")
      .style("font-weight", 100)
      .style("text-transform", "lowercase")
      .style("pointer-events", "none") // to prevent mouseover/drag capture
      .style("fill", function(d) {
        return color(d.type)
      });


// link labels ******************

      var labelLink = container.append("g").attr("class", "labelLinks")
        .selectAll("text")
        .data(graph.links)
        .enter()
        .append("text")
        //.attr("xlink:href", ".links")
        .attr("transform", function(d) { //calcul de l'angle du label
              var angle = Math.atan((d.source.y - d.target.y) / (d.source.x - d.target.x)) * 180 / Math.PI;
              return 'translate(' + [(d.source.x + d.target.x) / 2, (d.source.y + d.target.y) / 2] + ')rotate(' + angle + ')';
            })
        .attr("display", "none") //comment out to show link labels
        .style("font-family", "Helvetica")
        .style("font-size", "0.4em" )
        .style("font-weight", 100)
        .style("text-transform", "lowercase")
        .style("pointer-events", "none") // to prevent mouseover/drag capture
        .style("fill", function(d) {
          return color(d.relation);
        })
        .text(function(d) {
          return d.relation;
        });

// end link labels *********************** */

    node.on("mouseover", focus).on("mouseout", unfocus);

    function ticked() {
      node.call(updateNode);
      link.call(updateLink);
      labelNode.call(updateNode);
      labelLink.call(updateLabelLink);
    }

    function fixna(x) {
      if (isFinite(x)) return x;
      return 0;
    }

    function focus(d) {
    focusIndex = d3.select(this).datum().index;
      node.call(refresh);

      d3.select(this)
      .transition()
      .duration(750)
      .attr("r", mapNodeSize(d.size));

      var txt = "<h3>" + d.name + "</h3>";
      if (d.info !== undefined) {
        if (d.info.search("https://") !== -1) {
        //  d.info = d.info.replace("<iframe", "<iframe width=460 height=400 frameBorder=0 ");
          d.info = "<iframe src='".concat(d.info, "' width=460 height=400 frameBorder=0></iframe>");
        }
        txt += "<div>" + d.definition+ "</div>";

      }
      document.getElementById("nodeInfo").innerHTML = txt ;
      //button2.click();
    }

    function unfocus() {
      if (!keepFocused) {
        focusIndex = "";
        node.call(refresh);
      }
    }

    function showHide() {
      node.attr("display", function(d) {
        return controls[d.type] ? "block" : "none"
      });
      labelNode.attr("display", function(d) {
        return controls[d.type] ? "block" : "none"
      });
      link.attr("display", function(d) {
        return (controls[d.target.type] && controls[d.source.type]) ? "block" : "none"
      });
      labelLink.attr("display", function(d) {
        return (controls[d.target.type] && controls[d.source.type]) ? "block" : "none"
      });
      node.call(refresh);
    }

    function refresh(node) {
      node.style("opacity", function(d) {
        return controls[d.type] && (isNeighbor(focusIndex, d.index) || focusIndex == "") ? .9 : 0.1;
      });
      labelNode.style("opacity", function(d) {
        return controls[d.type] && (isNeighbor(focusIndex, d.index) || focusIndex == "") ? .9 : 0.1;
      });
      link.style("opacity", function(d) {
        return (controls[d.target.type] || controls[d.source.type]) && (isNeighbor(focusIndex, d.target.index) && isNeighbor(focusIndex, d.source.index) || focusIndex == "") ? .5 : 0.1;
      });
      labelLink.style("opacity", function(d) {
        return (controls[d.target.type] || controls[d.source.type]) && (isNeighbor(focusIndex, d.target.index) && isNeighbor(focusIndex, d.source.index) || focusIndex == "") ? .5 : 0.1;
      });
    }

    function updateLink(link) {
      link.attr("x1", function(d) {
          return fixna(d.source.x);
        })
        .attr("y1", function(d) {
          return fixna(d.source.y);
        })
        .attr("x2", function(d) {
          return fixna(d.target.x);
        })
        .attr("y2", function(d) {
          return fixna(d.target.y);
        });
    }

    function updateNode(node) {
      node.attr("transform", function(d) {
        return "translate(" + fixna(d.x) + "," + fixna(d.y) + ")";
      });
    }

    function updateLabelLink(link) {
      link.attr("transform", function(d) { //calcul de l'angle du label
            var angle = Math.atan((d.source.y - d.target.y) / (d.source.x - d.target.x)) * 180 / Math.PI;
            return 'translate(' + [(d.source.x + d.target.x) / 2, (d.source.y + d.target.y-3) / 2] + ')rotate(' + angle + ')';
          })
    }

    function dragstarted(d) {
      d3.event.sourceEvent.stopPropagation();
      if (!d3.event.active) graphLayout.alphaTarget(0.3).restart();
      d.fx = d.x;
      d.fy = d.y;
    }

    function dragged(d) {
      d.fx = d3.event.x;
      d.fy = d3.event.y;
    }

    function dragended(d) {
      if (!d3.event.active) graphLayout.alphaTarget(0);
      d.fx = null;
      d.fy = null;
    }

  }); // d3.json

  function createRemap(inMin, inMax, outMin, outMax) {
    return function remaper(x) {
      return (x - inMin) * (outMax - outMin) / (inMax - inMin) + outMin;
    };

  }



window.addEventListener("DOMContentLoaded", () => {
  const navContent = document.getElementById("nav-data");
  const pageHeader = document.getElementById("pageheader");

  if (navContent && pageHeader) {
    pageHeader.innerHTML = navContent.innerHTML;
    navContent.remove();
  } else {
    console.warn("pageHeader or navContent not found.");
  }

  let subLinks = document.querySelectorAll("#pageheader .mapLink a");
  subLinks.forEach(link => {

    // Get current link's "f" value
    const linkUrl = new URL(link.href);
    const params = new URLSearchParams(linkUrl.search);
    const fileName = params.get("f");

    if (fileName === file) {
      link.classList.add("active");
    }
  });

});


</script>
<script src="window-engine.js" defer></script>
</div>

</body>
</html>
