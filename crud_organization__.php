
<?php
  session_start();
  include_once 'paths.php';
  include 'db_connect.php';
  include_once 'header.php';
  include 'lang_man.php';

  $p_id = $_SESSION["_id"];
  $p_role = $_SESSION["_role"];

  // each multiple answer property is treated differently and stored with Question, Refecerence, Short Title, Maximum Value


  // here we collect a list of the columns from the ORGS database
  $orgsFields=[];
  $sql = "SHOW COLUMNS FROM orgs";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
      $error = "error on ".$p[1];
      echo $error;
    } else {
      while($row = mysqli_fetch_array($result)){
        array_push($orgsFields, $row['Field']);
    }
  }

  echo '<script>console.log("--1->", ' . json_encode($_POST) . ')</script>';


  $labelField="bD_".$_SESSION["lang"]."Label";
  //echo implode(" ",$orgsFields);
  /*------------------------------------------------------ CREATE -------------------------------------------------------------*/
  /*------------------------------------------------------ CREATE -------------------------------------------------------------*/
  /*------------------------------------------------------ CREATE -------------------------------------------------------------*/
  /*------------------------------------------------------ CREATE -------------------------------------------------------------*/
  /*------------------------------------------------------ CREATE -------------------------------------------------------------*/
?> 
  <div id="warnPopup">
    <div>
    <div id="popupText"></div>
    <button type="button" class="button" onclick="closePopup()">close</button>
    </div>
  </div>
<?php
if (empty($_POST)||(isset($_POST['create_organization']))) {
  ?>
  <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.4.3/build/ol.js"></script>


    <h1><?php echo $labels[54]; ?></h1>
    <div class="card" id="o_create">
    <form action="crud_organization.php" method="post" autocomplete="on">
      <h2><?php echo $labels[55]; ?></h2>
<!------------------------------- INTRO ------------------------------------------->

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

<!------------------------------- CONTACT/LOCATION ------------------------------------------->
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
<!------------------------------- TYPE o_typeID ------------------------------------------->

    <?php
    foreach ($bD_properties as $p){
    //echo "<h3>".$p[0]."</h3><ul class='checkbox_block ks-cboxtags'>";
    $sql = "SELECT * FROM baseDictionary WHERE bD_property='$p[1]' ";

    $s="<h3>".$p[0];
    $s.=($p[3]!=0) ? ' ('.$p[3].')' : '';
    $s.='</h3><ul class="checkbox_block ks-cboxtags" id="cb'.$p[1].'">';
    echo $s;

    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
      $error = "error on ".$p[1];
      echo $error;
    } else {
        while($row = mysqli_fetch_array($result)) {
          echo '<li class="checkbox"><input type="checkbox" class="switch" onchange="check(this,'.$p[3].')" name="'
          .$p[1].'[]"'
          .' value="'
          .$row["bD_index"]
          .'" id='.$p[1].$row["bD_index"].'><label for="'.$p[1].$row["bD_index"].'">'
          .$row[$labelField] // replace here with value in the selected language
          .'</label></li>';
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
    </script>
    ';
  }

  if(isset($_POST['o_register'])){
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
    //imagepng(imagecreatefromstring(file_get_contents(__DIR__."/uploads/".$s2.".".$ext)), __DIR__."/uploads/".$s2.".png");
    }

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

////-----------------------------------------------------------------
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
    foreach($orgsFields as $onefield) {
      if($onefield!="o_id") {
      if(isset($$onefield)) {

          $setOfOrgFields .= $onefield.' = "'.$$onefield.'",';
        }
      else {
        $setOfOrgFields .= $onefield.' = "'.$o_properties[$onefield].'",';
      } }
    }
    $setOfOrgFields = rtrim($setOfOrgFields, ',');
    $sql = "INSERT INTO orgs SET ".$setOfOrgFields;

    if ($conn->query($sql) === TRUE) {
      $last_id = $conn->insert_id;

      $sql = "INSERT INTO relPerOrg (rpo_p_id,rpo_o_id,rpo_role,rpo_contact,rpo_admin) VALUES ('$p_id','$last_id',0,0,1)";

      if ($conn->query($sql) === TRUE) {
        $msg = "association updated ";
        // the message
        $msg = "New association registered: ".$o_name;

        // use wordwrap() if lines are longer than 70 characters
        $msg = wordwrap($msg,70);

        $from = "bagimsizlar <info@bagimsizlar.org>";
        $to = "info@bagimsizlar.org";
        $subject = "New association registered";

        $header = implode("\r\n", [
              "From: $from",
              "MIME-Version: 1.0",
              "Content-type: text/html; charset=utf-8"
        ]);

        // send email ($to, $subject, $message, $header)
        mail($to, $subject,$msg,$header);
        // better to send to login page for a safe start!!!!!!
        header("Location: user_welcome.php?msg=$msg ");
        exit();

    } else {
      $error ="organization could not be updated";
    }
  }
}

/*------------------------------------------------------ VIEW -------------------------------------------------------------*/
/*------------------------------------------------------ VIEW -------------------------------------------------------------*/
/*------------------------------------------------------ VIEW -------------------------------------------------------------*/
/*------------------------------------------------------ VIEW -------------------------------------------------------------*/
/*------------------------------------------------------ VIEW -------------------------------------------------------------*/

if (isset($_POST['view_organization'])) {
  if($p_role==1) {
    $sql = "SELECT *
          FROM orgs
          WHERE orgs.o_id = ".$_POST['view_organization'];
  }
    else {$sql = "SELECT *
          FROM orgs
          INNER JOIN relPerOrg
          ON orgs.o_id = relPerOrg.rpo_o_id
          WHERE relPerOrg.rpo_admin = 1
          AND relPerOrg.rpo_p_id = ".$p_id
          ." AND orgs.o_id = ".$_POST['view_organization'];
        }
  $result = $conn->query($sql);

  if ($result->num_rows == 0) {
    $error = $labels[70]; //There must have been a mistake this organization doen't exist.;
    echo $error;
  } else {
    $n = mysqli_fetch_array($result);

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
          // looking for the name
          $sql2 = "SELECT * FROM baseDictionary WHERE bD_property='$p[1]' AND bD_index= ".$pie;
          $result2 = $conn->query($sql2);
          if ($result2->num_rows == 0) {
            $error = "error on ".$p[1];
            echo $error;
          } else {
            $n2 = mysqli_fetch_array($result2);
            //var_dump($n2);
            //echo "this is p[1] ".$p[1]."<br>";
            //echo "this is n[p[1]] ".$n[$p[1]]."<br>";
            echo "<li>".$n2[$labelField]."</li>";
          }
        }
      echo '</ul>';
    } else { echo $labels[72]; }
  }
  }
  echo '<br><br><a href="user_welcome.php" class="button">'.$labels[73].'</a></div>';
}

/*------------------------------------------------------ UPDATE -------------------------------------------------------------*/
/*------------------------------------------------------ UPDATE -------------------------------------------------------------*/
/*------------------------------------------------------ UPDATE -------------------------------------------------------------*/
/*------------------------------------------------------ UPDATE -------------------------------------------------------------*/
/*------------------------------------------------------ UPDATE -------------------------------------------------------------*/

if (isset($_POST['edit_organization'])) {
  if($p_role==1) {
    $sql = "SELECT *
          FROM orgs
          WHERE orgs.o_id = ".$_POST['edit_organization'];
  }
    else {
  $sql = "SELECT *
          FROM orgs
          INNER JOIN relPerOrg
          ON orgs.o_id = relPerOrg.rpo_o_id
          WHERE relPerOrg.rpo_admin = 1
          AND relPerOrg.rpo_p_id = ".$p_id
          ." AND orgs.o_id = ".$_POST['edit_organization'];
        }
  $result = $conn->query($sql);

  if ($result->num_rows == 0) {
    $error = $labels[70];
    echo $error;
  } else {
    $n = mysqli_fetch_array($result);

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

<!------------------------------- TYPE o_typeID ----------------------------------------->

  <?php
  foreach ($bD_properties as $p){
    $sql = "SELECT * FROM baseDictionary WHERE bD_property='$p[1]' ";
    $s="<h3>".$p[0];
    $s.=($p[3]!=0) ? ' ('.$p[3].')' : '';
    $s.='</h3><ul class="checkbox_block ks-cboxtags" id="cb'.$p[1].'">';
    echo $s;

  $result = $conn->query($sql);
  if ($result->num_rows == 0) {
    $error = "error on ".$p[1];
    echo $error;
  } else {
      $actualprops= explode(",", $n[$p[1]] ?? '');
      while($row = mysqli_fetch_array($result)) {
        echo '<li class="checkbox"><input type="checkbox" onchange="check(this,'.$p[3].')" class="switch cb'.$p[1].'" name="'
        .$p[1].'[]"'
        .' value="'
        .$row["bD_index"]
        .'" id="'.$p[1].$row["bD_index"].'" ';
        foreach($actualprops as $act_prop) {
          //echo $act_prop;
          if($act_prop==$row["bD_index"]) echo "checked";
        }
        echo '><label for="'.$p[1].$row["bD_index"].'">'
        .$row[$labelField] // replace here with value in the selected language
        .'</label></li>';
      }
    }
    echo '</ul>';
  }
  ?>


  <h3>Who can modify/update/delete this organization? (this section is under construction)</h3>

    <div id='announce' class='visually-hidden' aria-live="assertive"></div>
<div id="searchfield">
<?php
    $sql1 = "SELECT p_name FROM persons
             JOIN relPerOrg
             ON persons.p_id = relPerOrg.rpo_p_id
             JOIN orgs
             ON orgs.o_id = relPerOrg.rpo_o_id
             WHERE relPerOrg.rpo_admin = 1
             AND orgs.o_id = ".$_POST['edit_organization'];

    $result1 = $conn->query($sql1);
    while($row1 = mysqli_fetch_array($result1)) {
      echo '<h4 class="o_admin">'.$row1["p_name"]."</h4>";
    }
  ?>

		<br><br><label for="otherAdmins">Search for the name you want to add</label>

		<input role="combobox" id="otherAdmins" type="text" class="biginput" autocomplete="off" aria-owns="res" aria-autocomplete="both" name="otherAdmins">
		<input type="button" value="Add Admin" onclick="addAdmin()" class="button" />
</div>

<div class="autocomplete-suggestions" id="search-autocomplete"></div>

  <script>

$(document).ready(function() {
	const people = [<?php
    $sql2 = "SELECT p_name FROM persons";
    $result2 = $conn->query($sql2);
    while($row2 = mysqli_fetch_array($result2)) {
      echo '"'.$row2["p_name"].'",';
    }
  ?>];
	var cache = {};
	var searchedBefore = false;
	var counter = 1;
	var highligtCounter = 0;
	var keys = {
		ESC: 27,
		TAB: 9,
		RETURN: 13,
		LEFT: 37,
		UP: 38,
		RIGHT: 39,
		DOWN: 40
	};
	$("#otherAdmins").on("input", function(event) {
		doSearch(people);
	});

	$("#otherAdmins").on("keydown", function(event) {
		doKeypress(keys, event);
	});
});
function addAdmin()
    {

    let otherAdmins = $("#otherAdmins").val();
    //let otherAdmin=people.indexOf(otherAdmins);
    jsonString ={"od":<?php echo $_POST['edit_organization']; ?>,"name":otherAdmins};

        $(function()
        {
            $.ajax({
                type: "POST",
                contentType: "application/json",
                data: "{data:" + JSON.stringify(jsonString) + "}",
                url: 'addAdmin.php',
                dataType: "JSON"
            });

        });
    }

</script>
<script src="js/typeahead.js"></script>
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
}}
//-----------------------------------------------------------------------------------------/
//-----------------------------------------------------------------------------------------/
//-----------------------------------------------------------------------------------------/
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
  //imagepng(imagecreatefromstring(file_get_contents(__DIR__."/uploads/".$s2.".".$ext)), __DIR__."/uploads/".$s2.".png");
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
    foreach($orgsFields as $onefield) {
      if(isset($$onefield)) {
        if($onefield!="o_id")
          $setOfOrgFields .= $onefield.' = "'.$$onefield.'",';
        }
      else {
        $setOfOrgFields .= $onefield.' = "'.$o_properties[$onefield].'",';
      }
    }
    $setOfOrgFields = rtrim($setOfOrgFields, ',');

  $sql = "UPDATE orgs SET ".$setOfOrgFields." WHERE o_id = ".$o_id;

  if ($conn->query($sql) === TRUE) {
    //if ($conn->query($sql) === TRUE) {
      $msg = "association updated ";
      // better to send to login page for a safe start!!!!!!
      header("Location: user_welcome.php?msg=$msg ");
      exit();

  } else {
    $error ="organization could not be updated";
  }
}



/*------------------------------------------------------ DELETE -------------------------------------------------------------*/
/*------------------------------------------------------ DELETE -------------------------------------------------------------*/
/*------------------------------------------------------ DELETE -------------------------------------------------------------*/
/*------------------------------------------------------ DELETE -------------------------------------------------------------*/
/*------------------------------------------------------ DELETE -------------------------------------------------------------*/

if (isset($_POST['delete_organization'])) {
  if($p_role==1) {
    $sql = "SELECT *
          FROM orgs
          WHERE orgs.o_id = ".$_POST['delete_organization'];
  }
    else {
  $sql = "SELECT *
          FROM orgs
          INNER JOIN relPerOrg
          ON orgs.o_id = relPerOrg.rpo_o_id
          WHERE relPerOrg.rpo_admin = 1
          AND relPerOrg.rpo_p_id = ".$p_id
          ." AND orgs.o_id = ".$_POST['delete_organization'];
        }
  $result = $conn->query($sql);

  if ($result->num_rows == 0) {
    $error = "There must have been a mistake this organization doen't exist.";
    echo $error;
  } else {
    $n = mysqli_fetch_array($result);

    echo '<h1>Deleting Organization</h1><div class="card"><h2>Heads up! Are you sure you want to delete the association: '
        .$n['o_name']." from Bagmsizlar database? This operation cannot be reverted, all data will be lost.";
    echo  '<form action="crud_organization.php" method="post">
            <button name="o_delete" type="submit" value="'.$n['o_id'].'" class="button">
            Delete '.$n['o_name'].'</button>
          </form>
           <a href="user_welcome.php" class="button">Back to Profile</a></div>';
    }
  }

  if(isset($_POST['o_delete'])){
    echo $_POST['o_delete'];
    $dsql1 = "DELETE FROM orgs WHERE orgs.o_id= ".$_POST['o_delete'];
    if ($conn->query($dsql1) === TRUE) {
      $dsql2 = "DELETE FROM relPerOrg WHERE relPerOrg.rpo_o_id= ".$_POST['o_delete'];
      echo "We are deleting the association";
      if ($conn->query($dsql2) === TRUE) {
        echo "Association deleted successfully";
        header("Location: user_welcome.php?msg=$msg ");
        exit();
      } else {
        echo "Error deleting association and relation: " . $conn->error;
      }
    } else {
      echo "Error deleting association: " . $conn->error;
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

include_once 'footer.php' ?>
