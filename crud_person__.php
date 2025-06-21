<?php
// Start the session
  session_start();
  include_once 'paths.php';
  include 'db_connect.php';
  include_once 'header.php';
  include 'lang_man.php';

  if(!isset($_SESSION["_logged_in"])) {  // already logged in > edit, update
    if(empty($_POST)) { // no post load login
      //----------------------------------------LOGIN FORM-----------------------------------*/
      ?>
      <div id="login">
        <h1><?php echo $labels[12]; ?></h1>
        <?php if (isset($_GET["msg"])){
          echo "<div class='alert'>".$_GET["msg"]."</div>";
        } ?>
        <section class="card login"><form action="crud_person.php" method="post" autocomplete="on">
            <h3><?php echo $labels[13]; ?></h3>
            <div class="form-group">
              <div class="form-group">
                <label for="email"><?php echo $labels[14]; ?></label>
                <input class="form-control" type="email" name="email" id="email" required pattern="[^@]+@[^\.]+\..+">
              </div>
              <label for="password"><?php echo $labels[15]; ?></label>
              <input class="form-control" type="password" name="password" autocomplete="new-password" spellcheck="false" tabindex="0" aria-label="Onayla" name="Passwd" autocapitalize="off" autocorrect="off" dir="ltr" data-initial-dir="ltr" data-initial-value="" id="password">
           </div>
            <input type="submit" name="login" value="<?php echo $labels[26]; ?>" class="button login">
            <input type="submit" name="forgot" value="I forgot my password" class="button forgot">
          </form>
            <hr>
          <form action="crud_person.php" method="post">
            <input type="submit" name="register_card" value="<?php echo $labels[16]; ?>" class="button signup">
          </form>
        </section>
      </div>

<?php
    } else { // there is a post > login, forgot, register, registration page
      if( isset($_POST['login'])){
        //----------------------------------------LOGIN ACTION-----------------------------------*/
        $email =  $_POST["email"];
        $userPassword  =  $_POST["password"];

        $sql = "SELECT * FROM persons WHERE p_email='$email' ";
        $result = $conn->query($sql);
        if ($result->num_rows == 0) {
          $error = $labels[17];
          echo "<div class='alert'>".$error."</div>";
        } else {
            $n = mysqli_fetch_array($result);
    			  $passwordHash = $n['p_password'];

            if(password_verify($userPassword, $passwordHash)) {
              $_SESSION["_logged_in"] = true;
              $_SESSION["_fullname"] = $n['p_name'];
              $_SESSION["_email"] = $n['p_email'];
              $_SESSION["_id"] = $n['p_id'];
              $_SESSION["_role"] = $n['p_role'];
              $_SESSION["_comm"] = $n['p_comm'];

              header("Location: user_welcome.php");
              exit();
              // YOU ARE LOGGED IN
            } else {
              $error = $labels[18];
              echo "<div class='alert'>".$error."</div>";
            }
          }
      }
      //---------------------------------------- FORGOT ACTION-----------------------------------*/

      elseif(isset($_POST['forgot'])) {
        $email = $_POST['email'];
        $result = mysqli_query($conn,"SELECT * FROM persons WHERE p_email='$email'");
        $row = mysqli_fetch_assoc($result);
	      $fetch_user_id=$row['p_id'];
	      $fetch_email=$row['p_email'];
	      if($email==$fetch_email) {
          $feedback = is_array($row) ? "" : $email . " is not registered." ;
          echo "<h1>forgotten password</h1>".$feedback.  $email . $fetch_user_id . $fetch_email;
          if ($feedback == "") {
            $length = 16;
            $token = bin2hex(random_bytes($length));
            $from = "bagimsizlar <info@bagimsizlar.org>";
            $to = $fetch_email.", daniele.savasta@gmail.com";
            $subject = "Bagimsizlar Password";

            $header = implode("\r\n", [
              "From: $from",
              "MIME-Version: 1.0",
              "Content-type: text/html; charset=utf-8"
            ]);
            $securepwd = password_hash($token, PASSWORD_DEFAULT);
            $sql = "UPDATE persons SET p_password = '$securepwd' WHERE p_id = '$fetch_user_id'";
            $result = $conn->query($sql);
            $message = "This is your new password: $token, please change it after login.";
            if (!@mail($to, $subject, $message, $header)) {
              $feedback = "Failed to send email!";
            }
            if ($feedback=="") { $feedback = "Email has been sent - Please check the email for your new password."; }

            echo "<h1>forgotten password</h1><article class='card'>$feedback</article>";
          }
        }
      }

      //----------------------------------------REGISTER ACTION-----------------------------------*/
      elseif ( $_POST['register']) {
        echo "<div class='alert'>WE ARE TRYING TO REGISTER" ."</div>";
        if (isset($_POST['g-recaptcha-response'])) {
          $captcha = $_POST['g-recaptcha-response'];
        } else {
          $captcha = false;
          echo "<div class='alert'>CAPTCHA ERROR 1" ."</div>";
        }

        if (!$captcha) { echo "<div class='alert'>CAPTCHA ERROR 2" ."</div>"; }
        else {
          echo "<div class='alert'>CAPTCHA VERIFICATION" ."</div>";
          $secret   = '6LdioTQaAAAAAHE_rq2L50zzEoCFBsTvoRbUmjVl';
          $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);
          // use json_decode to extract json response
          $json=json_decode($response);
          var_dump($json);
          if ($response->success === false) { echo "<div class='alert'>CAPTCHA ERROR" ."</div>"; }
          if ($json->success===true && $json->score >= 0.5) {
            echo "<div class='alert'>CAPTCHA IS FINE" ."</div>";
            $email =  $_POST["email"];
            $sql = "SELECT * FROM persons WHERE p_email='$email' ";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              $error =  $labels[19];
              echo "<div class='alert'>".$error."</div>";
            } else {
              $fullname =  $_POST["fullname"];
              echo ($fullname);
              $phone =  $_POST["phone"];
              $securepwd = password_hash($_POST['password'], PASSWORD_DEFAULT);
              $sql = "INSERT INTO persons (p_email, p_name, p_phone, p_password) VALUES ('$email', '$fullname', '$phone', '$securepwd')";
              if ($conn->query($sql) === TRUE) {
                $msg = $labels[20];
                // better to send to login page for a safe start!!!!!!
                header("Location: crud_person.php?msg=$msg ");
                exit();
              } else {
                echo "<div class='alert'>Error updating record: " . $conn->error."</div>";
              }
            }
          }
        }
      } elseif($_POST['register_card']) {
        //----------------------------------------REGISTER CARD-----------------------------------*/
        ?>
        <script type="text/javascript" src="js/passwordMeter.js"></script>
        <script src="https://www.google.com/recaptcha/api.js?render=6LdioTQaAAAAAMhnZbHAgB8edr3GAsh2zrnt398c"></script>
        <script>
          grecaptcha.ready(function() {
            // do request for recaptcha token response is promise with passed token
            grecaptcha.execute('6LdioTQaAAAAAMhnZbHAgB8edr3GAsh2zrnt398c', {action:'validate_captcha'})
              .then(function(token) {
                // add token value to form
                document.getElementById('g-recaptcha-response').value = token;
            });
          });
        </script>
        <div id="registration">
          <h1><?php echo $labels[21];?></h1>
          <form action="crud_person.php" method="post" autocomplete="on" class="card" id="registrationForm">
            <h3><?php echo $labels[22];?></h3>
            <div class="form-group">
              <label for="email"><?php echo $labels[14];?></label>
              <input class="form-control" type="email" name="email" id="email" required pattern="[^@]+@[^\.]+\..+">
            </div>
            <div class="form-group pwd">
              <label for="password"><?php echo $labels[24];?></label>
              <input class="form-control" type="password" id="password" name="password" autocomplete="new-password" spellcheck="false" tabindex="0" aria-label="Onayla" name="Passwd" autocapitalize="off" autocorrect="off" dir="ltr" data-initial-dir="ltr" data-initial-value="" id="password">
              <div class="rating"></div>
            </div>
            <div class="form-group pwd">
              <label for="password"><?php echo $labels[25];?></label>
              <input class="form-control" type="password" autocomplete="new-password" spellcheck="false" tabindex="0" aria-label="Onayla" name="ConfirmPasswd" autocapitalize="off" autocorrect="off" dir="ltr" data-initial-dir="ltr" data-initial-value="">
            </div>
            <div class="form-group">
              <label for="fullname"><?php echo $labels[23];?></label>
              <input class="form-control" type="text" name="fullname" id="fullname" required>
            </div>
            <div class="form-group">
              <label for="phone"><?php echo $labels[27];?></label>
              <input class="form-control" type="tel" id="phone" name="phone" > <!--pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">-->
            </div>
            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
            <input type="hidden" name="action" value="validate_captcha">
            <input id="reg_button" type="submit" name="register" value="<?php echo $labels[28];?>" class="button">
          </form>
        </div>
        <?php
      }
    }
  } elseif ( $_POST['edit_card'] ) {
    $id = $_SESSION["_id"];
    //----------------------------------------EDIT ACTION-----------------------------------*/

    $sql = "SELECT * FROM persons WHERE p_id=".$id." ";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
      $error = $labels[29];
      echo "<div class='alert'>".$error."</div>";
    } else {
      $n = mysqli_fetch_array($result);
      ?>
      <h1><?php echo $labels[6];?></h1>
      <div id="p_update" class="card">
        <form action="crud_person.php" method="post" autocomplete="on">
          <h2><?php echo $labels[30];?></h2>
          <div class="form-group label-animate">
            <label for="email"><?php echo $labels[14];?></label>
            <input class="form-control" type="email" name="email" id="email" required pattern="[^@]+@[^\.]+\..+" value="<?php echo $n['p_email']; ?>">
          </div>
          <div class="form-group pwd">
            <label for="password"><?php echo $labels[24];?></label>
            <input class="form-control" type="password" name="password" autocomplete="new-password" spellcheck="false" tabindex="0" aria-label="Onayla" name="Passwd" autocapitalize="off" autocorrect="off" dir="ltr" data-initial-dir="ltr" data-initial-value="" id="password">
          </div>
          <div class="form-group pwd">
            <label for="password"><?php echo $labels[25];?></label>
            <input class="form-control" type="password" autocomplete="new-password" spellcheck="false" tabindex="0" aria-label="Onayla" name="ConfirmPasswd" autocapitalize="off" autocorrect="off" dir="ltr" data-initial-dir="ltr" data-initial-value="">
          </div>
          <div class="form-group label-animate">
            <label for="fullname"><?php echo $labels[23];?></label>
            <input class="form-control" type="text" name="fullname" id="fullname" required value="<?php echo $n['p_name']; ?>">
          </div>
          <div class="form-group label-animate">
            <label for="phone"><?php echo $labels[27];?></label>
            <input class="form-control" type="tel" id="phone" name="phone" value="<?php echo $n['p_phone']; ?>"> <!--pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">-->
          </div>
          <input type="submit" name="update" value="<?php echo $labels[31];?>" class="button">
        </form>
        <a href="user_welcome.php" id="backButton" class="button"><?php echo $labels[73];?></a>
      </div>
<?php }
  } elseif( $_POST['update'] ){
    $p_id = $_SESSION["_id"];
    $p_name = $_POST['fullname'];
    $securepwd = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $p_email =  $_POST['email'];
    $p_phone =  $_POST['phone'];

    $sql = "UPDATE persons
            SET p_email = '$p_email',
                p_name = '$p_name',
                p_phone = '$p_phone',
                p_password = '$securepwd'
            WHERE p_id=".$p_id;
    if ($conn->query($sql) === TRUE) {
      $msg = $labels[34];
      // better to send to login page for a safe start!!!!!!
      header("Location: user_welcome.php?msg=$msg ");
      exit();
    } else { $error = $labels[33]; }
  } else {
    header("Location: user_welcome.php");
    exit();
}
?>
<script type="text/javascript" src="js/formLabelAnimate.js"></script>
<?php include_once 'footer.php'; ?>
