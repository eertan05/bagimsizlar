<?php
ob_start();
session_start();

include "db_connect.php";
include "lang.php";

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$requestUri = $_SERVER['REQUEST_URI'];

$currentPage = $protocol . "://" . $host . $requestUri;
$currentPage =  explode('?', $currentPage)[0];
if ($currentPage == "https://amberplatform.org/bgmszlree/") $currentPage =$currentPage."index.php";
?>

<script>

  document.addEventListener("DOMContentLoaded", function () {
    let links = document.querySelectorAll("#nav_primary a");

    var activeHref = <?php echo json_encode($currentPage); ?>;
    if (activeHref) {
      links.forEach(link => {
        if (link.href === activeHref) {
          link.classList.add("active");
          sessionStorage.setItem("activeLink", link.href);
          sessionStorage.setItem("activeSubLink", "");
        }
      });
    }
  });

  function setLogoutSession(event) {
    event.preventDefault();  // Prevent default behavior
    console.log("Logout function triggered");
    // Send an AJAX request to update the PHP session
    fetch("logout.php", { method: "POST", credentials: "include" })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Redirect after session is updated
          window.location.href = "https://amberplatform.org/bgmszlree/crud_person.php";
        }
      })
      .catch(error => console.error("Error logging out:", error));
  }

    document.addEventListener("DOMContentLoaded", function() {
      const toggle = document.getElementById("menu-toggle");
      const menu = document.getElementById("lower_menu");
      const uppermenu = document.getElementById("upper_menu");
      const services = document.getElementById("service");
      const header = document.querySelector("#main > header");
      const iconBar = document.querySelector(".fa-bars");
      const iconX = document.querySelector(".fa-xmark");

      toggle.addEventListener("click", function() {
        menu.classList.toggle("show");
        uppermenu.classList.toggle("hide");
        services.classList.toggle("hide");
        header.classList.toggle("full");

        iconBar.classList.toggle("hide");
        iconX.classList.toggle("hide");
      });
    });

</script>


<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


  <?php
    $curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
    $curPageTitle = substr($curPageName,0,-4);

    if($mapon==1) {
  ?>

  <script>var lang="<?php echo $_SESSION["lang"];?>";</script>

  <script type="text/javascript" src="https://amberplatform.org/bgmszlree/js/leaflet.js"></script>
  <script type="text/javascript" src="https://amberplatform.org/bgmszlree/js/leaflet.markercluster.js"></script>
  <link href="https://amberplatform.org/bgmszlree/js/leaflet.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <?php
   }
  ?>

  <script
   src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
   integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs="
   crossorigin="anonymous">
  </script>

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="shortcut icon" href="https://amberplatform.org/bgmszlree/favicon.ico">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="stylesheet" href="https://amberplatform.org/bgmszlree/styles.css" media="all">
</head>

<body id="<?php echo $curPageTitle;?>">
<div id="main">

  <header>
  <nav  id="nav_primary">
    <div id="logo">
      <a href="https://amberplatform.org/bgmszlree/index.php" ><img src="https://amberplatform.org/bgmszlree/img/logos/B.png" ></a>
    </div>
    <div class="links-service-group">
    <div id="links">
      <div id="upper_menu">
        <a class="Btext" href="https://amberplatform.org/bgmszlree/index.php"><img src="https://amberplatform.org/bgmszlree/img/logos/Bindex_text.png"></a><a class="Bhub" href="https://amberplatform.org/bgmszlree/hub/index.php"><img src="https://amberplatform.org/bgmszlree/img/logos/Bhub_text.png"></a>
      </div>
      <div id="menu-toggle">
        <i class="fa-solid fa-bars"></i>
        <i class="fa-solid fa-xmark hide"></i>
      </div>
      <div id="lower_menu">
        <a href="https://amberplatform.org/bgmszlree/index.php"><?php echo $labels[2]; ?></a>
        <a href="https://amberplatform.org/bgmszlree/mapping/index.php" ><?php echo $labels[85]; ?></a>
        <a href="https://amberplatform.org/bgmszlree/timeline/index.php" ><?php echo $labels[91]; ?></a>
        <a href="https://amberplatform.org/bgmszlree/charts/index.php" ><?php echo $labels[92]; ?></a>
        <span id="divider">|</span>
        <a href="https://amberplatform.org/bgmszlree/hub/bagimsizlar-hakkinda/"><?php echo $labels[3]; ?></a>
        <a href="https://amberplatform.org/bgmszlree/hub/category/bulusma/" ><?php echo $labels[4]; ?></a>
        <a href="https://amberplatform.org/bgmszlree/hub/category/kaynakca/" ><?php echo $labels[5]; ?></a>
        <a href="https://amberplatform.org/bgmszlree/hub/category/podcast/" ><?php echo $labels[90]; ?></a>
      </div>
      <div id="pageheader">
          <span class="mapLink">
            <div class="sliding-names">
              <div class="sliding-text">
          <?php
            $sql = "SELECT * FROM orgs ORDER BY o_name ASC";
            $result = $pdo->query($sql);
            $result = $result->fetchAll(PDO::FETCH_ASSOC);
            $slidingNames = [];
            foreach ($result as $rs) {
              $slidingNames[] = $rs["o_name"];
            }
            echo implode(', ', $slidingNames);
          ?>
        </div>
        </div>
        </span>
      </div>
    </div>

    <div id="service">
        <?php if (empty($_SESSION["_logged_in"])): ?>
          <div>
          <a href="https://amberplatform.org/bgmszlree/crud_person.php">
            <span class="text">Login</span>
          </a>
                </div>
        <?php else: ?>
          <div class="dropdown">
            <a href="https://amberplatform.org/bgmszlree/crud_person.php">
              <span class="text">Profil</span>
            </a>
            <div class="dropdown-content">
              <a href="#" onclick="setLogoutSession(event)">
                <i>Logout</i>
              </a>
            </div>
          </div>
        <?php endif; ?>

    <div>
      <?php
        switch ($_SESSION['lang']) {
          case "en":
            echo '<a href="' . $curPageName . '?language=tr">Türkçe</a>';
            break;
          case "tr":
            echo '<a href="' . $curPageName . '?language=en">English</a>';
            break;
        }
      ?>
    </div>
  </div>
  <div>

  </nav>
</header>
