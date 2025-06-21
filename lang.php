<?php
/*----------  LOAD LANGUAGE -----------------------*/
$defaultLang = 'en';

if (!empty($_GET["language"])) { //<!-- see this line. checks
  //Based on the lowercase $_GET['language'] value, we will decide,
  //what lanuage do we use
  switch (strtolower($_GET["language"])) {
    case "en":
      //If the string is en or EN
      $_SESSION['lang'] = 'en';
      break;
    case "tr":
      //If the string is tr or TR
      $_SESSION['lang'] = 'tr';
      break;
    default:
      //IN ALL OTHER CASES your default langauge code will set
      //Invalid languages
      $_SESSION['lang'] = $defaultLang;
      break;
  }
}

if (empty($_SESSION["lang"])) {
  //Set default lang if there was no language
  $_SESSION["lang"] = $defaultLang;
}

switch ($_SESSION['lang']){
  case "en": $lng="bD_enLabel"; break;
  case "tr": $lng="bD_trLabel"; break;
}

$stmt = $pdo->query("SELECT $lng, bD_index FROM baseDictionary WHERE bD_property = 'interface' ");
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$labels=array();
foreach ($results as $result){
  $labels[$result["bD_index"]]=$result[$lng];
}

$bD_properties=Array([
  $labels[93],'o_typ',$labels[44],1],
  [$labels[94],'o_fow',$labels[47],3],
  [$labels[95],'o_def',$labels[45],3],
  [$labels[96],'o_act',$labels[49],5],
  [$labels[97],'o_leg',$labels[46],1],
  [$labels[98],'o_fin',$labels[48],3],
  [$labels[99],'o_equ',$labels[51],0],
  [$labels[100],'o_ser',$labels[52],0],
  [$labels[40],'o_pla',$labels[50],0],
  [$labels[101],'o_tar',$labels[53],0]
);

?>
