<?php
include 'header.php';

echo '<section class="currenttext">';

//echo '<script>console.log("--1->", ' . json_encode($_POST) . ')</script>';
//echo '<script>console.log("--1->", ' . json_encode($_SESSION["_logged_in"]) . ')</script>';

if (empty($_SESSION["_logged_in"])) {

  // ------------------ LOGIN -------------------

  if (!empty($_POST['login'])) {

    $email = $_POST["email"];
    $userPassword = $_POST["password"];
    $stmt = $pdo->prepare("SELECT * FROM persons WHERE p_email = ?");
    $stmt->execute([$email]);
    $n = $stmt->fetch(PDO::FETCH_BOTH);

    if (!$n) {
      $error = $labels[17];
      echo "<div class='alert'>" . $error . "</div>";
    } else {
      $passwordHash = $n['p_password'];
      if (password_verify($userPassword, $passwordHash)) {
        $_SESSION["_logged_in"] = true;
        $_SESSION["_fullname"] = $n['p_name'];
        $_SESSION["_email"] = $n['p_email'];
        $_SESSION["_id"] = $n['p_id'];
        $_SESSION["_role"] = $n['p_role'];
        $_SESSION["_comm"] = $n['p_comm'];

        echo '<script>console.log("--1->", ' . json_encode($_POST) . ')</script>';

        header("Location: user_welcome.php");
        exit();
        // YOU ARE LOGGED IN
      } else {

        echo '<section class="card login">';
        echo "<div class='alert'>" . $labels[18]. "</div>";
        echo  '<div><a href="user_welcome.php" id="backButton" class="button">'.$labels[103].'</a></div>';
        echo '</section>';

      }
    }
  }
  // ------------------ FORGOT PASSWORD -------------------
  elseif (!empty($_POST['forgot'])) {

    $email = $_POST['email'];

    $stmt = $pdo->prepare("SELECT * FROM persons WHERE p_email = ?");
    $stmt->execute([$email]);
    $n = $stmt->fetch(PDO::FETCH_ASSOC);

    echo '<h1>'. $labels[12] .'</h1>';
    echo '<section class="card login">';

    if ($n) {
      $fetch_user_id = $n['p_id'];
      $fetch_email = $n['p_email'];

      $token = bin2hex(random_bytes(16));
      $securepwd = password_hash($token, PASSWORD_DEFAULT);

      $stmt = $pdo->prepare("UPDATE persons SET p_password = ? WHERE p_id = ?");
      $stmt->execute([$securepwd, $fetch_user_id]);

      $to = $fetch_email;
      $subject = "Your New Password";
      $message = "This is your new password: $token. Please change it after login.";
      $headers = "From: info@bagimsizlar.org\r\nContent-type: text/html; charset=utf-8";

      if (mail($to, $subject, $message, $headers)) {
          echo "<div class='alert'>Email has been sent.</div>";
      } else {
          echo "<div class='alert'>Failed to send email!</div>";
      }
    } else {
      echo "<div class='alert'>No account found with that email.</div>";
    }
    echo  '<div><a href="user_welcome.php" id="backButton" class="button">'.$labels[103].'</a></div>';
  }
  //---------------------REGISTER ACTION------------------------------*/
  elseif (!empty($_POST['register'])) {

    echo '<h1>'. $labels[12] .'</h1>';
    echo '<section class="card login">';

    echo "<div class='alert'>WE ARE TRYING TO REGISTER</div>";
    if (isset($_POST['g-recaptcha-response'])) {
      $captcha = $_POST['g-recaptcha-response'];
    } else {
      $captcha = false;
      echo "<div class='alert'>CAPTCHA ERROR 1</div>";
    }
    if (!$captcha) {
      echo "<div class='alert'>CAPTCHA ERROR</div>";
    } else {
      echo "<div class='alert'>CAPTCHA VERIFICATION</div>";

      //6LeRrvoqAAAAAJinMkCYaRlyPsR69Dp2gFdDwKEF
      $secret   = '6LeRrvoqAAAAADTTGZnGPgBVDxqdTmv3CXJL7oGu';
      $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$captcha}&remoteip=" . $_SERVER['REMOTE_ADDR']);
      $json = json_decode($response);

      if (!$json->success || $json->score < 0.5) {
          echo "<div class='alert'>CAPTCHA ERROR</div>";
      } else {
        echo "<div class='alert'>CAPTCHA IS FINE</div>";

        // Secure PDO Connection
        $email = $_POST["email"];
        $sql = "SELECT * FROM persons WHERE p_email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) { // Fix: Using count() instead of num_rows
            echo "<div class='alert'>Email already exists!</div>";
        } else {
          $fullname = $_POST["fullname"];
          $phone = $_POST["phone"];
          $securepwd = password_hash($_POST['password'], PASSWORD_DEFAULT);

          $sql = "INSERT INTO persons (p_email, p_name, p_phone, p_password)
                  VALUES (:email, :fullname, :phone, :securepwd)";

          $stmt = $pdo->prepare($sql);
          $stmt->bindParam(":email", $email, PDO::PARAM_STR);
          $stmt->bindParam(":fullname", $fullname, PDO::PARAM_STR);
          $stmt->bindParam(":phone", $phone, PDO::PARAM_STR);
          $stmt->bindParam(":securepwd", $securepwd, PDO::PARAM_STR);


          if ($stmt->execute()) {
            $msg = $labels[20];

            header("Location: crud_person.php?msg=".urlencode($msg));
            exit();
          } else {
            echo "<div class='alert'>Error updating record: " . implode(" ", $stmt->errorInfo()) . "</div>";
          }
        }
      }
      echo  '<div><a href="user_welcome.php" id="backButton" class="button">'.$labels[103].'</a></div>';
    }
  }
  /*-----------------REGISTER CARD--------------------------*/
  elseif (!empty($_POST['register_card'])) {
  ?>
    <script type="text/javascript" src="js/passwordMeter.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?render=6LeRrvoqAAAAAJinMkCYaRlyPsR69Dp2gFdDwKEF"></script>
    <script>
      grecaptcha.ready(function() {
        // Execute reCAPTCHA and set token
        grecaptcha.execute('6LeRrvoqAAAAAJinMkCYaRlyPsR69Dp2gFdDwKEF', {action:'validate_captcha'})
          .then(function(token) {
            let captchaField = document.getElementById('g-recaptcha-response');
            if (captchaField) {
                captchaField.value = token;
            }
        });
      });
    </script>

    <div id="registration">
    <h1><?php echo $labels[21]; ?></h1>
    <section class="card login">

    <form action="crud_person.php" method="post" autocomplete="on" class="card" id="registrationForm">
      <h3><?php echo $labels[22]; ?></h3>

      <div class="form-group label-animate">
        <label for="email"><?php echo $labels[14]; ?></label>
        <input class="form-control" type="email" name="email" id="email" required pattern="[^@]+@[^.]+\..+">
      </div>

      <div class="form-group pwd label-animate">
        <label for="password"><?php echo $labels[24]; ?></label>
        <input class="form-control" type="password" id="password" name="password" autocomplete="new-password" spellcheck="false">
        <div class="rating"></div>
      </div>

      <div class="form-group label-animate pwd">
        <label for="confirm_password"><?php echo $labels[25]; ?></label>
        <input class="form-control" type="password" id="confirm_password" name="confirm_password" autocomplete="new-password" spellcheck="false">
      </div>

      <div class="form-group label-animate">
        <label for="fullname"><?php echo $labels[23]; ?></label>
        <input class="form-control" type="text" name="fullname" id="fullname" required>
      </div>

      <div class="form-group label-animate">
        <label for="phone"><?php echo $labels[27]; ?></label>
        <input class="form-control" type="tel" id="phone" name="phone">
      </div>

      <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
      <input type="hidden" name="action" value="validate_captcha">
      <input id="reg_button" type="submit" name="register" value="<?php echo $labels[28]; ?>" class="button">
    </form>
  </div>
  <?php
  } else {
    //-------------------------- LOGIN FORM ---------------*/
      ?>

      <div id="login">
        <h1><?php echo $labels[12]; ?></h1>
        <section class="card login">

        <?php
          if (!empty($_POST["msg"])) {
            echo "<div class='alert'>" . htmlspecialchars($_POST["msg"]) . "</div><br>";
          }
        ?>
          <form action="crud_person.php" method="post" autocomplete="on">
            <h3><?php echo $labels[13]; ?></h3>

            <div class="form-group label-animate">
              <label for="email"><?php echo $labels[14]; ?></label>
              <input class="form-control" type="email" name="email" id="email" required pattern="[^@]+@[^\.]+\..+">
            </div>

            <div class="form-group label-animate">
              <label for="password"><?php echo $labels[15]; ?></label>
              <input class="form-control" type="password" name="password" id="password" required>
            </div>

            <input type="submit" name="login" id="submitLogin" value="<?php echo $labels[26]; ?>" class="button login">
            <input type="submit" name="forgot" onclick="checkForgot()" value="I forgot my password" class="button forgot">

          </form>

          <hr>

          <form action="crud_person.php" method="post">
            <input type="submit" name="register_card" value="<?php echo $labels[16]; ?>" class="button signup">
          </form>

      </div>

      <script>
        function checkForgot(){

          const i1 = document.getElementById("password");
          i1.removeAttribute("required");
          i1.disabled = true;
          i1.style.opacity = "0.5";

          const i2 = document.getElementById("submitLogin");
          i2.disabled = true;
          i2.style.pointerEvents = "none";
          i2.style.opacity = "0.5";
        }
      </script>

      <?php
    }
  }
  /* ---------------------------EDIT----------------*/
  elseif (!empty($_POST['edit_profile'])) {

    $id = $_SESSION["_id"];

    $stmt = $pdo->prepare("SELECT * FROM persons WHERE p_id = ?");
    $stmt->execute([$id]);

    $n = $stmt->fetch(PDO::FETCH_BOTH);
  //  echo "<script>console.log('" . $n['p_id'] . "');</script>";

    if ($n) {
  ?>

  <h1><?php echo $labels[6]; ?></h1>
  <section id="p_update" class="card">
    <form action="crud_person.php" method="post" autocomplete="on">
      <div class="form-group label-animate">
        <input type="hidden" name="update" value="1">
        <input type="hidden" name="id" value="<?php echo $n['p_id']; ?>">
      </div>

      <div class="form-group label-animate">
        <label>Email</label>
        <input class="form-control"  type="email" name="email" value="<?php echo htmlspecialchars($n['p_email']); ?>" required>
      </div>

      <div class="form-group label-animate">
        <label>Full Name</label>
        <input class="form-control"  type="text" name="fullname" value="<?php echo htmlspecialchars($n['p_name']); ?>" required>
      </div>
      <div class="form-group label-animate pwd">
        <label>Password</label>
        <input class="form-control"  type="password" name="password">
      </div>

      <div class="form-group label-animate">
        <label>Phone</label>
        <input class="form-control"  type="text" name="phone" value="<?php echo htmlspecialchars($n['p_phone']); ?>">
      </div>

      <input type="submit" value="<?php echo $labels[31];?>" class="button" >
    </form>
    <a href="user_welcome.php" id="backButton" class="button"><?php echo $labels[73];?></a>
<?php
  }
}
/* ------------------------ UPDATE----------------*/
  elseif (!empty($_POST['update'])) {

    $p_id = $_SESSION["_id"];
    $p_name = $_POST['fullname'];
    $p_email = $_POST['email'];
    $p_phone = $_POST['phone'];
    $securepwd = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    $sql = "UPDATE persons SET p_email = ?, p_name = ?, p_phone = ?";
    if ($securepwd) {
        $sql .= ", p_password = ?";
        $params = [$p_email, $p_name, $p_phone, $securepwd, $p_id];
    } else {
        $params = [$p_email, $p_name, $p_phone, $p_id];
    }

    $sql .= " WHERE p_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    if ($stmt->rowCount() > 0) {
        header("Location: user_welcome.php?msg=Updated");
        exit();
    } else {
        echo "<div class='alert'>No changes made.</div>";
    }
  }
  else {
    if ($_SESSION["_logged_in"]){
      header("Location: user_welcome.php");
      exit();
    }
  }
?>

</section>
</section>

<?php
include 'footer.php';
?>
