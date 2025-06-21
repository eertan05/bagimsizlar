<!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8">
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

 <?php
  include 'lang_man.php';
  $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
  $curPageTitle = substr($curPageName,0,-4);

  if($mapon==1) {
?>
  <script>var lang="<?php echo $_SESSION["lang"];?>";</script>
  <script type="text/javascript" src="js\leaflet.js"></script>
  <script type="text/javascript" src="js\leaflet.markercluster.js"></script>

  <link href="js\leaflet.css" rel="stylesheet">
<?php
  }
?>
  <script
   src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
   integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs="
   crossorigin="anonymous">
  </script>

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="shortcut icon" href="favicon.ico">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="stylesheet" href="../styles.css">
</head>

<body id="<?php echo $curPageTitle;?>">
<div id="main">

<header>
        <!--<span lang="en">Independents</span>-->

      <nav aria-label="primary" id="nav_primary">
        <a href="../index.php" id="logo"><img src="../img/bagımsızlar_logo.png" height=100></a>
        <a href="javascript:void(0);" onclick="myFunction()" class="menu_b"><span class="material-icons">menu</span></a>

        <div class="links">
          <a href="../index.php"><?php echo $labels[2]; ?></a>
          <a href="../mapping/index.php"><?php echo $labels[85]; ?></a>
          <a href="../timeline/index.php"><?php echo $labels[91]; ?></a>
          <a href="../charts/index.php"><?php echo $labels[92]; ?></a>
          <a href="../about.php" id="h_about"><?php echo $labels[3]; ?></a>
          <a href="../workshops.php"><?php echo $labels[4]; ?></a>
          <a href="../bibliography.php"><?php echo $labels[5]; ?></a>
          <a href="../acikradyo.php"><?php echo $labels[90]; ?></a>
        </div>

          <!--<li><a onclick="openItem('relational')">relational</a></li>
          <li><a onclick="openItem('temporal')">temporal</a></li>-->
        <div class="service">
          <?php if(!isset($_SESSION["_logged_in"])) {
          echo '<a href="crud_person.php"><i>Login</i><span class="material-icons">login</span></a>';
        } else {
          echo '<a href="user_welcome.php"><i>Profile</i><span class="material-icons">person</span></a>';
        } ?>
          <div class="dropdown"><a><span class="material-icons dd">language</span></a>
            <div class="dropdown-content">
              <a href="<?php echo $curPageName; ?>?language=en" class="external active">English</a>
              <a href="<?php echo $curPageName; ?>?language=tr" class="external">Türkçe</a>
            </div>
          </div>

      </nav>
    </header>
