<?php
  session_start();
  include_once '../header.php';
  include '../db_connect.php';
?>

  <link href="styles.css" rel="stylesheet">
</head>

<script src="js\p5.min.js"></script>
<script src="js\leaflet.js"></script>
<script src="js\leaflet.markercluster.js"></script>
<script type="text/javascript" src="js/tile-stamen.js"></script>
<script src="js\indmap.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">

    <section id="geographical"></section>
    <section id="search" lang="en" class="overlay">
      <span class="closebtn" onclick="closeItem('search')" title="Close Overlay">x</span>
      <article>
        <form action="">
          <!--action_page.php-->
          <input type="text" placeholder="Search.." name="search">
          <button type="submit"><i class="fa fa-search"></i></button>
        </form>
      </article>
    </section>
    <nav aria-label="secondary" id="nav_drawer">
      <ul class="">
        <li><a onclick="openItem('organization')">organization</a></li>
      </ul>
    </nav>
  </div>
</body>

</html>
