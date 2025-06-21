<?php
  include 'header.php';

  echo '<section class="currenttext">)';

  //echo '<script>console.log("--o_register2->", ' . json_encode($_POST) . ')</script>';

  $p_id = $_SESSION["_id"];
  if (!$p_id) {
    $msg = "please login to continue";
    header("Location: crud_person.php?msg=$msg ");
    exit();
}
  $p_role = $_SESSION["_role"];

  // here we collect a list of the columns from the ORGS database
  $orgsFields = [];

  try {
    // Get column names from `orgs` table
    $sql = "SHOW COLUMNS FROM orgs";
    $stmt = $pdo->query($sql);
    if ($stmt === false) {
      die("Error executing query.");
    }

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $orgsFields[] = $row['Field'];
    }


  } catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
  }

  $labelField="bD_".$_SESSION["lang"]."Label"
?>

<div id="warnPopup">
  <div>
    <div id="popupText"></div>
    <button type="button" class="button" onclick="closePopup()">close</button>
  </div>
</div>

<?php
/*-------------------- CREATE -------------------------------*/
/*-------------------- CREATE -------------------------------*/
/*-------------------- CREATE -------------------------------*/
/*-------------------- CREATE -------------------------------*/
/*-------------------- CREATE -------------------------------*/
/*-------------------- CREATE -------------------------------*/
  if (empty($_POST)||(isset($_POST['create_organization']))) {
?>
  <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.4.3/build/ol.js"></script>


    <h1><?php echo $labels[54]; ?></h1>
    <div class="card" id="o_create">
    <form action="crud_organization.php" method="post" autocomplete="on">
      <h2><?php echo $labels[55]; ?></h2>

  <!------------------------- INTRO ------------------------->

      <div class="form-group">
        <label for="name"><?php echo $labels[56]; ?></label>
        <input class="form-control" type="text" name="name" id="name" required>
      </div>
      <div class="form-group">
        <label for="shortname"><?php echo $labels[57]; ?></label>
        <input class="form-control" type="text" name="shortname" id="shortname">
      </div>

      <div class="form-group">
        <label for="description"><?php echo $labels[60]; ?></label>
        <textarea class="form-control" id="description" name="description" class="materialize-textarea" required></textarea>
      </div>

      <div class="form-group">
        <label for="descriptionen"><?php echo $labels[86]; ?></label>
        <textarea class="form-control" id="descriptionen" name="descriptionen" class="materialize-textarea"></textarea>
      </div>

      <div class="form-group">
        <label for="people"><?php echo $labels[87]; ?></label>
        <textarea class="form-control" id="people" name="people" class="materialize-textarea"></textarea>
      </div>

      <div class="form-group">
        <label for="startdate"><?php echo $labels[58]; ?></label>
        <input class="form-control" type="date" name="startdate" id="startdate" required>
      </div>
      <div class="form-group">
        <label for="enddate"><?php echo $labels[59]; ?></label>
        <input class="form-control" type="date" name="enddate" id="enddate">
      </div>

<!------------------------------- CONTACT/LOCATION -------------------->
      <div class="form-group">
        <label for="address"><?php echo $labels[61]; ?></label>
        <input class="form-control" id="address" name="address">
      </div>
      <div class="form-group">
        <label for="city"><?php echo $labels[62]; ?></label>
        <input class="form-control" id="city" name="city" title="City">
      </div>

      <div class="form-group">
        <label for="coordinates"><?php echo $labels[64]; ?></label>
        <div id="map" class="map" style="height: 500px; width: 100%;" ></div>
        <input class="form-control" id="coordinates" name="coordinates">
      </div>

      <div class="form-group">
        <label for="phone"><?php echo $labels[65]; ?></label>
        <input class="form-control" type="tel" id="phone" name="phone" required> <!--pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"-->
      </div>
      <div class="form-group">
          <label for="email"><?php echo $labels[14]; ?></label>
          <input class="form-control" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="email" required>
        </div>
      <div class="form-group">
        <label for="website"><?php echo $labels[66]; ?></label>
        <input class="form-control" id="website" name="website" pattern="https?://.+" title="Include http://">
      </div>

    <div class="form-group">
      <label for="facebook_id">Facebook ID</label>
      <input class="form-control" id="facebook_id" name="facebook_id" title="Facebook ID">
    </div>

    <div class="form-group">
      <label for="instagram_id">Instagram ID</label>
      <input class="form-control" id="instagram_id" name="instagram_id" title="Instagram ID">
    </div>

    <div class="form-group">
      <label for="twitter_id">Twitter ID</label>
      <input class="form-control" id="twitter_id" name="twitter_id" title="Twitter ID">
    </div>

<!------------------------ TYPE o_typeID ------------------>

    <?php
    foreach ($bD_properties as $p){
      $sql = "SELECT * FROM baseDictionary WHERE bD_property = :property";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([':property' => $p[1]]);
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results

      $s="<h3>".$p[0];
      $s.=($p[3]!=0) ? ' ('.$p[3].')' : '';
      $s.='</h3><ul class="checkbox_block ks-cboxtags" id="cb'.$p[1].'">';
      echo $s;

      if ($stmt->rowCount() == 0) {
        echo "Error on " . $p[1];
      } else {
        //while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        foreach ($result as $row) { // Loop through the fetched results

          echo '<li class="checkbox">
              <input type="checkbox" onchange="check(this,' . $p[3] . ')" class="switch cb' . $p[1] . '"
                  name="' . $p[1] . '[]" value="' . $row["bD_index"] . '"
                  id="' . $p[1] . $row["bD_index"] . '" ';

          echo '><label for="' . $p[1] . $row["bD_index"] . '">'
              . htmlspecialchars($row[$labelField]) . // Prevent HTML injection
              '</label>
              </li>';
        }
      }
             echo '</ul>';
    }
    echo  '<input type="submit" name="o_register" value="'.$labels[28].'" class="button"></form>
               <a href="user_welcome.php" id="backButton" class="button">'.$labels[73].'</a></div>

    <div id="popup" class="ol-popup"></a><div id="popup-content"></div></div>
    <script>
    var container = document.getElementById("popup");
    var content = document.getElementById("popup-content");

    var overlay = new ol.Overlay({
      element: container,
      autoPan: true,
      autoPanAnimation: {
        duration: 250,
      },
    });

    const localmap = new ol.Map({
      layers: [new ol.layer.Tile({source: new ol.source.OSM()}) ],
      overlays: [overlay],
      target: "map",view: new ol.View({center: [0,0],zoom: 2})});
      localmap.on("singleclick", function (evt) {
     var coordinate = evt.coordinate;
     var lonlat = ol.proj.transform(evt.coordinate, "EPSG:3857", "EPSG:4326");
     document.getElementById("coordinates").value = lonlat[0]+", "+lonlat[1];
     var hdms = ol.coordinate.toStringHDMS(ol.proj.toLonLat(coordinate));
     content.innerHTML = "<p>'.$labels[68].'</p><code>" + hdms + "</code>";
     overlay.setPosition(coordinate);
    });
    </script>';
  }
  /********* register *********************/
  /********* register *********************/

  if(isset($_POST['o_register'])){

    $o_name = addslashes($_POST['name']);
    $o_shortname =  $_POST['shortname'];
    $o_startdate =  $_POST['startdate'];
    $o_enddate =  $_POST['enddate'];
    $o_comm =  3;
    $o_description = addslashes($_POST['description']);
    $o_description_en = addslashes($_POST['descriptionen']);
    $o_people = addslashes($_POST['people']);
    $o_address = addslashes($_POST['address']);
    $o_city = $_POST['city'];
    $o_location = $_POST['coordinates'];
    $o_phone = $_POST['phone'];
    $o_email = $_POST['email'];
    $o_website = $_POST['website'];
    $o_sfacebook = $_POST['facebook_id'];
    $o_sinstagram = $_POST['instagram_id'];
    $o_stwitter = $_POST['twitter_id'];

    // Handle Photo Upload
    if(isset($_POST['photo'])) {
      $o_image = $_POST['photo'];

      // Ensure the filename has an extension
      if (strpos($o_image, '.') !== false) {
        list($txt, $ext) = explode(".", $o_image);
        $s1 = "/uploads/tmp/" . $o_image;
        $s2 = strtolower(clean($o_id . $o_name));

        if (file_exists(__DIR__ . $s1)) {
            rename(__DIR__ . $s1, __DIR__ . "/uploads/" . $s2 . ".png");
        } else {
            error_log("File not found: " . __DIR__ . $s1);
        }
      } else {
        error_log("Invalid file name: " . $o_image);
      }
    }

      // Handle properties
    $o_properties = [];

    foreach($bD_properties as $p){
      $o_properties[$p[1]] = ' ';
      if(isset($_POST[$p[1]])) {
        if(is_array($_POST[$p[1]])) {
          $o_properties[$p[1]] = implode(",", $_POST[$p[1]]);
        } else {
          $o_properties[$p[1]] = $_POST[$p[1]];
        }
      }
    }

    // Build SQL safely with prepared statements
    $setOfOrgFields = [];
    $params = [];
    foreach($orgsFields as $onefield) {
      if($onefield != "o_id") {
        $setOfOrgFields[] = "$onefield = :$onefield";
        $params[":$onefield"] = $$onefield ?? $o_properties[$onefield];
      }
    }

      // Insert into `orgs`
    $setOfOrgFields = [];
    $params = [];

    // Build column-value pairs safely
    foreach ($orgsFields as $field) {
      if ($field !== "o_id") {  // Exclude primary key
        $setOfOrgFields[] = "$field = :$field";
        $params[":$field"] = $$field ?? '';  // Use variable variable ($$) to get field value
      }
    }

      // Ensure there's something to insert
    if (empty($setOfOrgFields)) {
        die("Error: No valid fields to insert.");
    }

    // Prepare SQL statement
    $sql = "INSERT INTO orgs SET " . implode(", ", $setOfOrgFields);
    $stmt = $pdo->prepare($sql);

    // Execute query
    if ($stmt->execute($params)) {
        $last_id = $pdo->lastInsertId();
        if (!$last_id) {
            die("Error: lastInsertId() failed.");
        }
    } else {
        die("Error inserting organization.");
    }

    // Insert into `relPerOrg`
    $sql = "INSERT INTO relPerOrg (rpo_p_id, rpo_o_id, rpo_role, rpo_contact, rpo_admin)
            VALUES (:p_id, :last_id, 0, 0, 1)";
    $stmt = $pdo->prepare($sql);

    try {
      // Debug Variables
      //<  var_dump($p_id, $last_id);

      // Ensure last_id is not null
      if (!$last_id) {
          throw new Exception("Error: lastInsertId() returned NULL");
      }

      $stmt = $pdo->prepare("INSERT INTO relPerOrg (rpo_p_id, rpo_o_id, rpo_role, rpo_contact, rpo_admin) VALUES (:p_id, :last_id, 0, 0, 1)");
      $stmt->execute([
        ':p_id' => $p_id,
        ':last_id' => $last_id
      ]);
    } catch (PDOException $e) {
      error_log("Database error: " . $e->getMessage());  // Log error
      die("Internal server error. Please try again later.");
    } catch (Exception $e) {
      die($e->getMessage()); // Debugging for missing last_id
    }

      // Send email
    $msg = "New association registered: " . $o_name;
    $to = "info@bagimsizlar.org";
    $subject = "New association registered";
    $from = "info@bagimsizlar.org";
    $headers = [
        "From: $from",
        "Reply-To: $from",
        "MIME-Version: 1.0",
        "Content-type: text/html; charset=utf-8"
    ];
    $sent = mail($to, $subject, wordwrap($msg, 70), implode("\r\n", $headers));
    if (!$sent) {
        error_log("Mail sending failed.");
    }

    // Redirect
    header("Location: user_welcome.php?msg=" . urlencode($msg));
    exit();
  }

/*------------------- VIEW ---------------------------------*/
/*------------------- VIEW ---------------------------------*/
/*------------------- VIEW ---------------------------------*/
/*------------------- VIEW ---------------------------------*/
/*------------------- VIEW ---------------------------------*/
/*------------------- VIEW ---------------------------------*/

if (isset($_POST['view_organization'])) {
    if ($p_role == 1) {
        $sql = "SELECT * FROM orgs WHERE orgs.o_id = :view_organization";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':view_organization' => $_POST['view_organization']]);
    } else {
        $sql = "SELECT *
                FROM orgs
                INNER JOIN relPerOrg ON orgs.o_id = relPerOrg.rpo_o_id
                WHERE relPerOrg.rpo_admin = 1
                AND relPerOrg.rpo_p_id = :p_id
                AND orgs.o_id = :view_organization";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':p_id' => $p_id,
            ':view_organization' => $_POST['view_organization']
        ]);
    }

    $n = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$n) {
        $error = $labels[70]; // There must have been a mistake; this organization doesn't exist.
        echo $error;
    } else {

    echo '<h1>'.$labels[71].'</h1><div class="card" id="view_organization"><h2>'
        .$n['o_name']
        .'</h2><hr><img src="uploads/'.strtolower(clean($n['o_id'].$n['o_name'])).'.png" class="org_logo"/>'
        .'<h3>'.$labels[60].'</h3><p class="v_des"> '.$n['o_description'].'</p>'
        .'<h3>'.$labels[86].'</h3><p class="v_des"> '.$n['o_description_en'].'</p>'
        .'<h3>'.$labels[87].'</h3><p class="v_des"> '.$n['o_people'].'</p>'
        .'<h3>'.$labels[61].'</h3><p class="v_add"> '.$n['o_address'].'</p>'
        .'<h3>'.$labels[62].'</h3><p class="v_cit"> '.$n['o_city'].'</p>'
        .'<h3>'.$labels[65].'</h3><p class="v_pho"> '.$n['o_phone'].'</p>'
        .'<h3>'.$labels[14].'</h3><p class="v_web"> '.$n['o_email'].'</p>'
        .'<h3>'.$labels[66].'</h3><p class="v_web"> '.$n['o_website'].'</p><hr>';

    foreach ($bD_properties as $p){
          echo "<h3>".$p[2]."</h3>";
      if($n[$p[1]]!="") {
        $pieces = explode(",", $n[$p[1]]);
        echo '<ul class="v_properties">';
        foreach ($pieces as $pie){
          $sql2 = "SELECT * FROM baseDictionary WHERE bD_property = :property AND bD_index = :index";
          $stmt2 = $pdo->prepare($sql2);
          $stmt2->execute([
              ':property' => $p[1],
              ':index' => $pie
          ]);

          $n2 = $stmt2->fetch(PDO::FETCH_ASSOC);

          if (!$n2) {
              $error = "error on ".$p[1];
              echo $error;
          } else {
            //var_dump($n2);
            //echo "this is p[1] ".$p[1]."<br>";
            //echo "this is n[p[1]] ".$n[$p[1]]."<br>";
            //echo "this is label".$labelField."<br>";
            //echo "this is label".$n2[$labelField]."<br>";
            echo "<li>".$n2[$labelField]."</li>";
          }
        }
      echo '</ul>';
    } else {
      echo $labels[72];
      echo '</ul>';

    }
  }
  }
  echo '<br><br><a href="user_welcome.php" class="button">'.$labels[73].'</a></div>';
}

/*-------------------- UPDATE -----------------------------------*/
/*-------------------- UPDATE -----------------------------------*/
/*-------------------- UPDATE -----------------------------------*/
/*-------------------- UPDATE -----------------------------------*/
/*-------------------- UPDATE -----------------------------------*/

if (isset($_POST['edit_organization'])) {
    if ($p_role == 1) {
        $sql = "SELECT * FROM orgs WHERE orgs.o_id = :edit_organization";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':edit_organization' => $_POST['edit_organization']]);
    } else {
        $sql = "SELECT *
                FROM orgs
                INNER JOIN relPerOrg ON orgs.o_id = relPerOrg.rpo_o_id
                WHERE relPerOrg.rpo_admin = 1
                AND relPerOrg.rpo_p_id = :p_id
                AND orgs.o_id = :edit_organization";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':p_id' => $p_id,
            ':edit_organization' => $_POST['edit_organization']
        ]);
    }

    $n = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$n) {
        $error = $labels[70];
        echo $error;
    } else {
    //echo implode(" | ",$n);
    ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.4.3/css/ol.css" type="text/css">
    <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.4.3/build/ol.js"></script>
  <h1><?php echo $labels[74]; ?></h1>

  <section class="card" id="o_update">
  <form action="crud_organization.php" method="post" autocomplete="on" id="org_form">
    <h2><?php echo $labels[75]; ?></h2>
<!------------------------------- INTRO ------------------------------------------->
    <input type="hidden" name="o_id" value="<?php echo $n['o_id']; ?>">
    <div class="form-group label-animate">
      <label for="name"><?php echo $labels[56]; ?></label>
      <input class="form-control" type="text" name="name" id="name" required value="<?php echo $n['o_name'];?>">
    </div>
    <div class="form-group label-animate">
      <label for="shortname"><?php echo $labels[57]; ?></label>
      <input class="form-control" type="text" name="shortname" id="shortname" value="<?php echo $n['o_shortname'];?>">
    </div>

  <div class="form-group label-animate">
      <label for="startdate"><?php echo $labels[58]; ?></label>
      <input class="form-control" type="date" name="startdate" id="startdate" required value="<?php echo $n['o_startdate'];?>">
    </div>
    <div class="form-group label-animate">
      <label for="enddate"><?php echo $labels[59]; ?></label>
      <input class="form-control" type="date" name="enddate" id="enddate" value="<?php echo $n['o_enddate'];?>">
    </div>
    <div class="form-group label-animate">
      <label for="description"><?php echo $labels[60]; ?></label>
      <textarea class="form-control" id="description" name="description" class="materialize-textarea" required><?php echo $n['o_description'];?></textarea>
    </div>
    <div class="form-group label-animate">
      <label for="descriptionen"><?php echo $labels[86]; ?></label>
      <textarea class="form-control" id="descriptionen" name="descriptionen" class="materialize-textarea"><?php echo $n['o_description_en'];?></textarea>
    </div>
    <div class="form-group label-animate">
      <label for="people"><?php echo $labels[87]; ?></label>
      <textarea class="form-control" id="people" name="people" class="materialize-textarea"><?php echo $n['o_people'];?></textarea>
    </div>
<!------------------------------- CONTACT/LOCATION ------------------------------------------->
    <div class="form-group label-animate">
      <label for="address"><?php echo $labels[61]; ?></label>
      <input class="form-control" id="address" name="address" value="<?php echo $n['o_address'];?>">
    </div>
    <div class="form-group label-animate">
      <label for="city"><?php echo $labels[62]; ?></label>
      <input class="form-control" id="city" name="city" value="<?php echo $n['o_city'];?>">
    </div>

    <div class="form-group">
      <label for="coordinates label-animate"><?php echo $labels[64]; ?></label>
      <div id="map" class="map" style="height: 500px; width: 100%;" ></div>
      <input class="form-control" id="coordinates" name="coordinates" value="<?php echo $n['o_location'];?>">
    </div>

    <div class="form-group label-animate">
      <label for="phone"><?php echo $labels[65]; ?></label>
      <input class="form-control" type="tel" id="phone" name="phone" value="<?php echo $n['o_phone'];?>" required> <!--pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"-->
    </div>

    <div class="form-group label-animate">
        <label for="email"><?php echo $labels[14]; ?></label>
        <input class="form-control" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="<?php echo $labels[14]; ?>" value="<?php echo $n['o_email'];?>" required>
      </div>

    <div class="form-group label-animate">
      <label for="website"><?php echo $labels[66]; ?></label>
      <input class="form-control" id="website" name="website" pattern="https?://.+" title="<?php echo $labels[63]; ?>" value="<?php echo $n['o_website'];?>">
    </div>

    <div class="form-group label-animate">
      <label for="facebook_id">Facebook ID</label>
      <input class="form-control" id="facebook_id" name="facebook_id" title="Facebook ID" value="<?php echo $n['o_sfacebook'];?>">
    </div>

    <div class="form-group label-animate">
      <label for="instagram_id">Instagram ID</label>
      <input class="form-control" id="instagram_id" name="instagram_id" title="Instagram ID" value="<?php echo $n['o_sinstagram'];?>">
    </div>

    <div class="form-group label-animate">
      <label for="twitter_id">Twitter ID</label>
      <input class="form-control" id="twitter_id" name="twitter_id" title="Twitter ID" value="<?php echo $n['o_stwitter'];?>">
    </div>

<!------------------------------- TYPE o_typeID ------------------------->

  <?php
  foreach ($bD_properties as $p) {
      $sql = "SELECT * FROM baseDictionary WHERE bD_property = :property";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([':property' => $p[1]]);
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results

      $s = "<h3>" . $p[0];
      $s .= ($p[3] != 0) ? ' (' . $p[3] . ')' : '';
      $s .= '</h3><ul class="checkbox_block ks-cboxtags" id="cb' . $p[1] . '">';
      echo $s;

      if ($stmt->rowCount() == 0) {
          echo "Error on " . $p[1];
      } else {
          $actualprops = explode(",", $n[$p[1]] ?? '');

          foreach ($result as $row) { // Loop through the fetched results
              echo '<li class="checkbox">
                      <input type="checkbox" onchange="check(this,' . $p[3] . ')" class="switch cb' . $p[1] . '"
                          name="' . $p[1] . '[]" value="' . $row["bD_index"] . '"
                          id="' . $p[1] . $row["bD_index"] . '" ';

              if (in_array($row["bD_index"], $actualprops)) {
                  echo "checked"; // Check the box if it matches a selected value
              }

              echo '><label for="' . $p[1] . $row["bD_index"] . '">'
                  . htmlspecialchars($row[$labelField]) . // Prevent HTML injection
                  '</label>
                  </li>';
          }
      }
      echo '</ul>';
  }  ?>

  <h3><?php echo $labels[333]; ?> </h3>

  <div id='announce' class='visually-hidden' aria-live="assertive"></div>
  <div id="searchfield">
      <?php
      /**** List current admins ****/
      $sql1 = "SELECT p_name
          FROM persons
          JOIN relPerOrg ON persons.p_id = relPerOrg.rpo_p_id
          JOIN orgs ON orgs.o_id = relPerOrg.rpo_o_id
          WHERE relPerOrg.rpo_admin = 1
          AND orgs.o_id = :edit_organization";

      $stmt1 = $pdo->prepare($sql1);
      $stmt1->execute([':edit_organization' => $_POST['edit_organization']]);
      $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

      foreach ($result1 as $row1) {
          echo '<h4 class="o_admin" id="admin_' . htmlspecialchars($row1["p_name"]) . '">'
              . htmlspecialchars($row1["p_name"])
              . '<button class="deleteAdmin" onclick="deleteAdmin(\'' . htmlspecialchars($row1["p_name"], ENT_QUOTES) . '\')" data-name="' . htmlspecialchars($row1["p_name"], ENT_QUOTES) . '"> &nbsp; x</button>'              . '</h4>';
      }
    ?>

      <br><br><label for="newAdmin">Search for the name you want to add</label>
      <input role="combobox" id="newAdmin" type="text" class="biginput" autocomplete="off" aria-owns="res" aria-autocomplete="both" name="newAdmin">
      <input type="button" value="Add Admin" onclick="addAdmin()" class="button" />
  </div>

  <div class="autocomplete-suggestions" id="search-autocomplete"></div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    $(document).ready(function() {
        // Fetch the list of people
        const people = [<?php
            $sql2 = "SELECT p_name FROM persons";
            $stmt2 = $pdo->query($sql2);
            $names = [];
            while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                $names[] = '"' . addslashes($row2["p_name"]) . '"';
            }
            echo implode(",", $names);
        ?>];

console.log(people);
        let cache = {};
        let searchedBefore = false;
        let counter = 1;
        let highlightCounter = 0;

        let keys = {
            ESC: 27,
            TAB: 9,
            RETURN: 13,
            LEFT: 37,
            UP: 38,
            RIGHT: 39,
            DOWN: 40
        };

        $("#newAdmin").on("input", function(event) {
            doSearch(people);
        });

        $("#newAdmin").on("keydown", function(event) {
            doKeypress(keys, event);
        });
    });
  });
  </script>

  <script src="js/typeahead.js"></script>

  <script>
  function addAdmin() {
    event.preventDefault();

      let newAdmin = $("#newAdmin").val();
      let orgId = <?php echo json_encode($_POST['edit_organization']); ?>;

      let data = { od: orgId, name: newAdmin };

      $.ajax({
          type: "POST",
          url: "addAdmin.php",
          contentType: "application/json",
          data: JSON.stringify(data),
          dataType: "json",
          success: function(response) {
            $("#searchfield").prepend(
            `<h4 class="o_admin" id="admin_${newAdmin}">
               ${newAdmin}
               <button class="deleteAdmin" onclick="deleteAdmin('${newAdmin}')" data-name="${newAdmin}"> &nbsp; x</button>
             </h4>`
            );
            $("#newAdmin").val(""); // Clear input field

              console.log("Admin added successfully", response);
          },
          error: function(xhr, status, error) {
              console.error("Error adding admin:", status, error);
          }
      });
  }

  function deleteAdmin(adminToDelete) {
   event.preventDefault();

      let orgId = <?php echo json_encode($_POST['edit_organization']); ?>;
      let data = { od: orgId, name: adminToDelete };

      $.ajax({
          type: "POST",
          url: "deleteAdmin.php",
          contentType: "application/json",
          data: JSON.stringify(data),
          dataType: "json",
          success: function(response) {
              console.log("Targeting: #admin_" + adminToDelete);
              $("#admin_" + adminToDelete).hide();
              $("#newAdmin").val(""); // Clear input field
              console.log("Admin deleted successfully", response);
          },
          error: function(xhr, status, error) {
              console.error("Error deleting admin:", status, error);
              console.log("XHR Response Text:", xhr.responseText);
          }
      });
  }
  </script>


  <h3>Logo</h3>
  <?php echo $n['o_name'];
  echo '<div class="spacer"></div><input type="submit" name="o_update" value="'.$labels[31].'" class="button" id="updateButton"></form>

  <div id="imageUploadSection">
    <div id="preview"><img src="uploads/'.strtolower(clean($n['o_id'].$n['o_name'])).'.png"/></div>
    <form id="image_upload_form" method="post" enctype="multipart/form-data" action="upload.php" autocomplete="off">
      <input type="hidden" name="targetFileName" value="' . strtolower(clean($n['o_id'].$n['o_name'])) . '" />
      <div class="browse_text">'.$labels[76].'</div>
      <div class="file_input_container">
      <div class="upload_button"><label class="button" for="photo">'.$labels[77].'<input type="file" name="photo" id="photo" class="file_input hidden" /></label></div>
      </div><br clear="all">
    </form>
  </div>

  <a href="user_welcome.php" class="button" id="backButton">'.$labels[73].'</a></section>

  <div id="popup" class="ol-popup"></a><div id="popup-content"></div></div>
  <script src="js/jquery.min.js"></script>
  <script src="js/jquery.form.min.js"></script>
  <script src="js/uploadFile.js"></script>

  <script>
  var container = document.getElementById("popup");
  var content = document.getElementById("popup-content");

  var overlay = new ol.Overlay({
    element: container,
    autoPan: true,
    autoPanAnimation: {
      duration: 250,
    },
  });

  const localmap = new ol.Map({
    layers: [new ol.layer.Tile({source: new ol.source.OSM()}) ],
    overlays: [overlay],
    target: "map",';
    if($n['o_location']!=NULL) echo 'view: new ol.View({center: ol.proj.transform(['.$n['o_location'].'], "EPSG:4326", "EPSG:3857"),zoom: 15})});

    var countryStyle = new ol.style.Style({
      fill: new ol.style.Fill({
        color: [156, 105, 201, 0.5]
      }),
      stroke: new ol.style.Stroke({
        color: [156, 105, 201, 1],
        width: 2
      })
    });

    var layer = new ol.layer.Vector({
      source: new ol.source.Vector({
        features: [
          new ol.Feature({
            geometry: new ol.geom.Circle(ol.proj.transform(['.$n['o_location'].'], "EPSG:4326", "EPSG:3857"),100)
          })
        ]
      }),
      style: countryStyle
    });


  localmap.addLayer(layer);
    ';
    else echo 'view: new ol.View({center: [0,0],zoom: 2})});';
      echo '
      localmap.on("singleclick", function (evt) {
       var coordinate = evt.coordinate;
       var lonlat = ol.proj.transform(evt.coordinate, "EPSG:3857", "EPSG:4326");
       console.log(lonlat[0]+", "+lonlat[1]);
       document.getElementById("coordinates").value = lonlat[0]+", "+lonlat[1];
       var hdms = ol.coordinate.toStringHDMS(ol.proj.toLonLat(coordinate));
       content.innerHTML = "<p>Your association is located here:</p><code>" + hdms + "</code>";
       overlay.setPosition(coordinate);
      });
  </script>';
  }
}

//---------------------------------------------------------------/
//---------------------------------------------------------------/
//---------------------------------------------------------------/

if(isset($_POST['o_update'])){
  $o_id=$_POST['o_id'];
  $o_name = addslashes($_POST['name']);
  $o_shortname =  $_POST['shortname'];
  $o_startdate =  $_POST['startdate'];
  $o_enddate =  $_POST['enddate'];
  if(isset($_POST['photo'])) {
  $o_image =  $_POST['photo'];

  list($txt, $ext) = explode(".", $o_image);
  $s1="/uploads/tmp/".$o_image;
  $s2=strtolower(clean($o_id.$o_name));
  rename(__DIR__.$s1, __DIR__."/uploads/".$s2.".png");
  }

  $o_comm =  3;
  $o_description =  addslashes($_POST['description']);
  $o_description_en =  addslashes($_POST['descriptionen']);
  $o_people =  addslashes($_POST['people']);

  $o_address =  addslashes($_POST['address']);
  $o_city =  $_POST['city'];
  $o_location = $_POST['coordinates'];
  //$latlon = explode(",", $_POST['coordinates']);

  $o_phone =  $_POST['phone'];
  $o_email =  $_POST['email'];
  $o_website =  $_POST['website'];
  $o_sfacebook =  $_POST['facebook_id'];
  $o_sinstagram =  $_POST['instagram_id'];
  $o_stwitter =  $_POST['twitter_id'];


  $o_properties= array();
    foreach($bD_properties as $p){
      $o_properties[$p[1]] = ' ';
      if(isset($_POST[$p[1]])) {
        //echo $_POST[$p[1]]
        if(is_array($_POST[$p[1]])) {
          $o_properties[$p[1]]=implode(",",$_POST[$p[1]]);
        } else
        foreach($_POST[$p[1]] as $prm){
          if ($o_properties[$p[1]] != ' ') {
            $o_properties[$p[1]].=','.$prm;
            }
          else $o_properties[$p[1]] = $prm;
        }
      }
    }


    // if the organization is not there; otherwise use UPDATE SQL request not INSERT
    $setOfOrgFields = "";
    foreach ($orgsFields as $onefield) {
        if (isset($$onefield)) {
            // Skip "o_id" field and ensure proper formatting
            if ($onefield != "o_id") {
                $value = $$onefield;
                // Handle empty strings or invalid values as NULL
                if ($value === "") {
                    $value = null;
                }
                // Properly escape values in the SQL query
                $setOfOrgFields .= "$onefield = :$onefield,";
            }
        } else {
            $value = $o_properties[$onefield] ?? null;
            // Handle empty strings or invalid values as NULL
            if ($value === "") {
                $value = null;
            }
            $setOfOrgFields .= "$onefield = :$onefield,";
        }
    }
    // Remove trailing comma
    $setOfOrgFields = rtrim($setOfOrgFields, ',');

    // Prepare SQL query
    $sql = "UPDATE orgs SET " . $setOfOrgFields . " WHERE o_id = :o_id";
    $stmt = $pdo->prepare($sql);

    // Bind values dynamically from $orgsFields
    foreach ($orgsFields as $onefield) {
        if ($onefield != "o_id") {
            // Ensure the value is properly assigned or set to null if empty
            $value = isset($$onefield) ? $$onefield : ($o_properties[$onefield] ?? null);

            // Bind the parameter with correct handling for NULL or empty values
            $stmt->bindValue(":$onefield", $value === "" ? null : $value);
        }
    }
    $stmt->bindValue(':o_id', $o_id);

    $stmt->execute();

    //var_dump($stmt->execute());

    if ($stmt->execute()) {
      $msg = "association updated";
      //  echo '<script>console.log(' . json_encode($msg, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . ')</script>';
      header("Location: user_welcome.php?msg=$msg ");
      exit();
      } else {
        $error = "organization could not be updated";
    }
  }

/*------------------------- DELETE ----------------------------------*/
/*------------------------- DELETE ----------------------------------*/
/*------------------------- DELETE ----------------------------------*/
/*------------------------- DELETE ----------------------------------*/
/*------------------------- DELETE ----------------------------------*/
/*------------------------- DELETE ----------------------------------*/

if (isset($_POST['delete_organization'])) {
    if ($p_role == 1) {
        $sql = "SELECT * FROM orgs WHERE orgs.o_id = :delete_organization";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':delete_organization' => $_POST['delete_organization']]);
    } else {
        $sql = "SELECT *
                FROM orgs
                INNER JOIN relPerOrg ON orgs.o_id = relPerOrg.rpo_o_id
                WHERE relPerOrg.rpo_admin = 1
                AND relPerOrg.rpo_p_id = :p_id
                AND orgs.o_id = :delete_organization";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':p_id' => $p_id,
            ':delete_organization' => $_POST['delete_organization']
        ]);
    }

    $n = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$n) {
        $error = "There must have been a mistake; this organization doesn't exist.";
        echo $error;
    } else {
        echo '<h1>Deleting Organization</h1>
              <div class="card">
                <h2>Heads up! Are you sure you want to delete the association: '
                . htmlspecialchars($n['o_name']) . ' from Bagmsizlar database?
                This operation cannot be reverted, all data will be lost.</h2>';
        echo '<form action="crud_organization.php" method="post">
                <button name="o_delete" type="submit" value="' . htmlspecialchars($n['o_id']) . '" class="button">
                Delete ' . htmlspecialchars($n['o_name']) . '</button>
              </form>
              <a href="user_welcome.php" class="button">Back to Profile</a>
              </div>';
    }
}

if (isset($_POST['o_delete'])) {
    echo $_POST['o_delete'];

    try {
        // Start transaction to handle both DELETEs together
        $pdo->beginTransaction();

        // First DELETE query
        $dsql1 = "DELETE FROM orgs WHERE orgs.o_id = :o_id";
        $stmt1 = $pdo->prepare($dsql1);
        $stmt1->execute([':o_id' => $_POST['o_delete']]);

        // Second DELETE query
        $dsql2 = "DELETE FROM relPerOrg WHERE relPerOrg.rpo_o_id = :o_id";
        $stmt2 = $pdo->prepare($dsql2);
        $stmt2->execute([':o_id' => $_POST['o_delete']]);

        // Commit the transaction if both DELETEs succeed
        $pdo->commit();

        echo "Association deleted successfully";
        header("Location: user_welcome.php?msg=$msg");
        exit();

    } catch (PDOException $e) {
        // Roll back the transaction on failure
        $pdo->rollBack();
        echo "Error deleting association: " . $e->getMessage();
    }
}
?>

<script src="js/org.js"></script>
<script type="text/javascript" src="js/formLabelAnimate.js"></script>
<script>
  function check(me,max) {
    console.log(max)
    if(max!=0) {
      if (document.querySelectorAll('input[name="'+me.name+'"]:checked').length > max) {
        me.checked = false;
        let popup = document.getElementById("warnPopup");
        popup.children[0].children[0].innerHTML= "only "+max+" choices are allowed. please review your selection";
        popup.classList.toggle("show");
      }
    }
  }
  function closePopup(){
    let popup = document.getElementById("warnPopup");
    popup.classList.toggle("show");
  }
</script>

<?php
function clean($text) {
  $utf8 = array(
    '/[áàâãªä]/u'   =>   'a',
    '/[ÁÀÂÃÄ]/u'    =>   'A',
    '/[ÍÌÎÏIİ]/u'     =>   'I',
    '/[íìîïıi]/u'     =>   'i',
    '/[éèêë]/u'     =>   'e',
    '/[ÉÈÊË]/u'     =>   'E',
    '/[óòôõºö]/u'   =>   'o',
    '/[ÓÒÔÕÖ]/u'    =>   'O',
    '/[úùûü]/u'     =>   'u',
    '/[ÚÙÛÜ]/u'     =>   'U',
    '/ç/'           =>   'c',
    '/Ç/'           =>   'C',
    '/Ğ/'           =>   'G',
    '/ğ/'           =>   'g',
    '/ş/'           =>   's',
    '/Ş/'           =>   'S',
    '/ñ/'           =>   'n',
    '/Ñ/'           =>   'N',
    '/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
    '/[’‘‹›‚]/u'    =>   '', // Literally a single quote
    '/[“”«»„]/u'    =>   '', // Double quote
    '/ /'           =>   '', // nonbreaking space (equiv. to 0x160)
  );
  return preg_replace(array_keys($utf8), array_values($utf8), $text);
}
?>

</section>

<?php
include_once 'footer.php' ?>
