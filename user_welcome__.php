<?php
session_start();
include_once 'paths.php';
include 'db_connect.php';
include_once 'header.php';

if(isset($_SESSION["_logged_in"])) {

  $email = $_SESSION["_email"];
  $p_id = $_SESSION["_id"];
  $p_role = $_SESSION["_role"];
  echo '<h1>'.$labels[6].'</h1><div class="card" id="usr_wel"><h2>'.$labels[7].', '.$_SESSION["_fullname"].'</h2><form action="crud_person.php" method="post"><input type="submit" name="edit_card" value="'.$labels[8].'" class="button" id="b_edit_person"></form><a class="whatsapp" href="https://chat.whatsapp.com/IYhVF7q2CKk9Qn8eYzZQlR"> '.$labels[102].'</a><div id="org"><h2>'.$labels[9].'</h2>';
  if($p_role==1) {
    $sql = "SELECT o_name, o_id, o_email, o_comm
            FROM orgs
            ORDER BY o_name";
  }
    else {
  $sql = "SELECT o_name, o_id, o_email, o_comm
          FROM orgs
          INNER JOIN relPerOrg
          ON orgs.o_id = relPerOrg.rpo_o_id
          WHERE relPerOrg.rpo_admin = 1
          AND relPerOrg.rpo_p_id = ".$p_id."
          ORDER BY o_name";
        }
  $result = $conn->query($sql);

  if ($result->num_rows == 0) {
    $error = $labels[10];
    echo $error;
  } else {

    $orglist = '<ul class="v_org_list">';
    $emailList = '<ul class="v_org_list"><h2>Emails</h2><form  class="news_email_form" id="pMail"><input type="text" class="news_email_field" readonly value="'.$email.'"/><ul class="checkbox_block ks-cboxtags"><li class="checkbox"><input type="checkbox" onclick="handleChange(event)" class="switch" id="news" '.(($_SESSION["_comm"] == 1 || $_SESSION["_comm"] == 3) ? 'checked' : '').' /><label for="news">News</label></li><li class="checkbox"><input type="checkbox" onclick="handleChange(event)" class="switch" id="coord" '.(($_SESSION["_comm"] == 2 || $_SESSION["_comm"] == 3) ? 'checked' : '').'/><label for="coord">Coordination</label></li></ul></form>';
    $emCount=0;
        while($row = mysqli_fetch_array($result)) {

          $orglist .= "<li><p>".$row['o_name'].
              '</p><form class="v_org_form" method="post" action="crud_organization.php">
              <button name="view_organization" type="submit" value="'.$row['o_id'].'" class="button">
              <i class="material-icons">dvr</i></button>

              <button name="edit_organization" type="submit" value="'.$row['o_id'].'" class="button">
              <i class="material-icons">edit</i></button>

              <button name="delete_organization" type="submit" value="'.$row['o_id'].'" class="button">
              <i class="material-icons">delete</i></button>
              </form></li>';
            //}
            //$orglist .= "</ul>";

            //$emailList="";
            //while($ro2w = mysqli_fetch_array($result)) {
              if($row['o_email']!="") {

                $emCount++;
              //$emailList.= '<form class="news_email_form"><input type="text" class="news_email_field" readonly value="'.$row['o_email'].'"/><ul class="checkbox_block ks-cboxtags"><li class="checkbox"><input type="checkbox" onclick="handleChange(event)" name="news" class="switch" id="news'.$emCount.'" '.(($row['o_comm'] == 1 || $row['o_comm'] == 3) ? 'checked' : '').'/><label for="news'.$emCount.'">News</label></li><li class="checkbox"><input type="checkbox" class="switch" onclick="handleChange(event)"  name="coord" id="coord'.$emCount.'" '.(($row['o_comm'] == 2 || $row['o_comm'] == 3) ? 'checked' : '').'/><label for="coord'.$emCount.'">Coordination</label></li></ul></form>';
            }}
            if($emCount==0) $emailList.= "<p>There are no emails associated with your account.</p>";
            $orglist.= "</ul>";
            //$emailList.= "<p><b>news:</b> You will reveive emails about bagimsizlar activities</p><p><b>coordination:</b> You will reveive emails about the creation and organization of bagimsizlar activities</p></ul>";

            echo $orglist;
            //echo $emailList;

  }

  if($p_role==1) {
    echo '<form class="download_form" method="post" action="export.php">
              <button name="persons" type="submit" value="persons" class="button"><span>Persons<span><i class="material-icons">file_download</i></button>
              <button name="organizations" type="submit" value="organizations" class="button"><span>Organizations<span><i class="material-icons">file_download</i></button>
              <button name="relational" type="submit" value="relational" class="button"><span>Relational<span><i class="material-icons">file_download</i></button>

              <button name="json" type="submit" value="json" class="button"><span>json<span><i class="material-icons">file_download</i></button>

              </form>';
  }
  // <button name="newslist" type="submit" value="newslist" class="button"><span>Newsletter list<span><i class="material-icons">file_download</i></button>
  // <button name="coordlist" type="submit" value="coordlist" class="button"><span>Coordination list<span><i class="material-icons">file_download</i></button>
?>

<form action="crud_organization.php" method="post">
  <input type="submit" name="create_organization" value="<?php echo $labels[11];?>" class="button">
</form></div></div>
<script src="js/jquery.min.js"></script>
<script src="js/jquery.form.min.js"></script>
<script type="text/javascript" src="js/formLabelAnimate.js"></script>

<script type="text/javascript">

function handleChange(e) {
 // e.checked = e.checked ? false : true;
    //e.prop("checked", !e.prop("checked"));
     //const {checked} = e.target;
  /*   if(checked) window.alert("check");
     else window.alert("not check");
*/
let f=e.target.parentElement.parentElement.parentElement;
let m=f.firstChild.value;
let news=false;
let coord=false;
let person=0;

if(f.news.checked){news=true;}
if(f.coord.checked){coord=true;}
if(f.id=="pMail") person=1;
let s=(news ? 1 : 0) + (coord ? 2 : 0);
console.log(" " + person + "|" + m + "|" + s);

     $.ajax({
        type: "POST",
        url: "updateMailingList.php",
        async: true,
        data: {
            action0: person,
            action1: m,
            action2: s
        },
        success: function (msg) {
            //alert(msg);
            /*if (msg != 'success') {
                alert('Fail');
            }*/
        }
    });
}

</script>
<?php
} else {
  header("Location: crud_person.php ");
}
 include_once 'footer.php'; ?>
