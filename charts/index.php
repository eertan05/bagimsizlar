<?php
session_start();
include '../header.php';


$chartData = array();


//--------------------------------------------------------
function pieLegal() {
  global $pdo;

  $stmt = $pdo->prepare("
      SELECT
          o_name,
          o_leg,
          bD_trLabel AS s_bD_trLabel
      FROM
          orgs
      INNER JOIN
          baseDictionary
      ON
          orgs.o_leg = baseDictionary.bD_index
      AND
          baseDictionary.bD_property = 'o_leg'
  ");
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $title = "What is the legal status of your organization?";
  createPie("pieLegal", $results);



}
//--------------------------------------------------------
function pieType() {
  global  $pdo;

  // Example data structure: { pieLegal:{ title: "pieLegal", labels: [...], values: [...] }, pieFinancial:{ title: "pieFinancial", labels: [...], values: [...] } }

  $stmt = $pdo->prepare("
    WITH RECURSIVE Numbers AS (
      SELECT 0 AS n
      UNION ALL
      SELECT n + 1
      FROM Numbers
      WHERE n < (
        SELECT MAX(CHAR_LENGTH(o_typ) - CHAR_LENGTH(REPLACE(o_typ, ',', '')))
        FROM orgs
      )
    )

    SELECT
      SUBSTRING_INDEX(SUBSTRING_INDEX(o_typ, ',', Numbers.n + 1), ',', -1) AS value,
      o_name,
      o_typ,
      baseDictionary.bD_trLabel AS s_bD_trLabel
    FROM orgs
    JOIN Numbers
      ON Numbers.n <= CHAR_LENGTH(o_typ) - CHAR_LENGTH(REPLACE(o_typ, ',', ''))
    INNER JOIN baseDictionary
      ON baseDictionary.bD_property = 'o_typ'
      AND SUBSTRING_INDEX(SUBSTRING_INDEX(o_typ, ',', Numbers.n + 1), ',', -1) = baseDictionary.bD_index
      AND o_typ != ''
  ");
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $title = "What is the type(s) of your organization?";
  createPie("pieType", $results);
}
//--------------------------------------------------------
        function pieFinancial() {
  global  $pdo, $title;

  // Example data structure: { pieLegal:{ title: "pieLegal", labels: [...], values: [...] }, pieFinancial:{ title: "pieFinancial", labels: [...], values: [...] } }

  $stmt = $pdo->prepare("
    WITH RECURSIVE Numbers AS (
      SELECT 0 AS n
      UNION ALL
      SELECT n + 1
      FROM Numbers
      WHERE n < (
        SELECT MAX(
          CHAR_LENGTH(o_fin) - CHAR_LENGTH(REPLACE(o_fin, ',', ''))
        )
        FROM orgs
      )
    )

    SELECT
      SUBSTRING_INDEX(SUBSTRING_INDEX(o_fin, ',', Numbers.n + 1), ',', -1) AS value,
      o_name,
      o_fin,
      baseDictionary.bD_trLabel AS s_bD_trLabel
    FROM orgs
    JOIN Numbers
      ON Numbers.n <= CHAR_LENGTH(o_fin) - CHAR_LENGTH(REPLACE(o_fin, ',', ''))
    INNER JOIN baseDictionary
      ON baseDictionary.bD_property = 'o_fin'
      AND o_fin != ''
      AND SUBSTRING_INDEX(SUBSTRING_INDEX(o_fin, ',', Numbers.n + 1), ',', -1) = baseDictionary.bD_index
  ");
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $title = "How does your organization financially sustain itself?";
  createPie("pieFinancial", $results);
}
  //--------------------------------------------------------
function pieDefinition() {
  global  $pdo, $title;

  // Example data structure: { pieLegal:{ title: "pieLegal", labels: [...], values: [...] }, pieFinancial:{ title: "pieFinancial", labels: [...], values: [...] } }

  $stmt = $pdo->prepare("
    WITH RECURSIVE Numbers AS (
      SELECT 0 AS n
      UNION ALL
      SELECT n + 1
      FROM Numbers
      WHERE n < (
        SELECT MAX(
          CHAR_LENGTH(o_def) - CHAR_LENGTH(REPLACE(o_def, ',', ''))
        )
        FROM orgs
      )
    )

    SELECT
      SUBSTRING_INDEX(SUBSTRING_INDEX(o_def, ',', Numbers.n + 1), ',', -1) AS value,
      o_name,
      o_def,
      baseDictionary.bD_trLabel AS s_bD_trLabel
    FROM orgs
    JOIN Numbers
      ON Numbers.n <= CHAR_LENGTH(o_def) - CHAR_LENGTH(REPLACE(o_def, ',', ''))
    INNER JOIN baseDictionary
      ON baseDictionary.bD_property = 'o_def'
      AND o_def != ''
      AND SUBSTRING_INDEX(SUBSTRING_INDEX(o_def, ',', Numbers.n + 1), ',', -1) = baseDictionary.bD_index
  ");
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $title = "How you define your organization?";
  createPie("pieDefinition", $results);

}
//--------------------------------------------------------
function pieFields() {
  global  $pdo, $title;

  // Example data structure: { pieLegal:{ title: "pieLegal", labels: [...], values: [...] }, pieFinancial:{ title: "pieFinancial", labels: [...], values: [...] } }

  $stmt = $pdo->prepare("
    WITH RECURSIVE Numbers AS (
      SELECT 0 AS n
      UNION ALL
      SELECT n + 1
      FROM Numbers
      WHERE n < (
        SELECT MAX(
          CHAR_LENGTH(o_fow) - CHAR_LENGTH(REPLACE(o_fow, ',', ''))
        )
        FROM orgs
      )
    )

    SELECT
      SUBSTRING_INDEX(SUBSTRING_INDEX(o_fow, ',', Numbers.n + 1), ',', -1) AS value,
      o_name,
      o_fow,
      baseDictionary.bD_trLabel AS s_bD_trLabel
    FROM orgs
    JOIN Numbers
      ON Numbers.n <= CHAR_LENGTH(o_fow) - CHAR_LENGTH(REPLACE(o_fow, ',', ''))
    INNER JOIN baseDictionary
      ON baseDictionary.bD_property = 'o_fow'
      AND o_fow != ''
      AND SUBSTRING_INDEX(SUBSTRING_INDEX(o_fow, ',', Numbers.n + 1), ',', -1) = baseDictionary.bD_index
  ");
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $title = "Which fields is your organization working on?";
  createPie("pieFields", $results);

}
//--------------------------------------------------------
function pieActivities() {
  global  $pdo, $title;

  // Example data structure: { pieLegal:{ title: "pieLegal", labels: [...], values: [...] }, pieFinancial:{ title: "pieFinancial", labels: [...], values: [...] } }

  $stmt = $pdo->prepare("
    WITH RECURSIVE Numbers AS (
      SELECT 0 AS n
      UNION ALL
      SELECT n + 1
      FROM Numbers
      WHERE n < (
        SELECT MAX(
          CHAR_LENGTH(o_act) - CHAR_LENGTH(REPLACE(o_act, ',', ''))
        )
        FROM orgs
      )
    )

    SELECT
      SUBSTRING_INDEX(SUBSTRING_INDEX(o_act, ',', Numbers.n + 1), ',', -1) AS value,
      o_name,
      o_act,
      baseDictionary.bD_trLabel AS s_bD_trLabel
    FROM orgs
    JOIN Numbers
      ON Numbers.n <= CHAR_LENGTH(o_act) - CHAR_LENGTH(REPLACE(o_act, ',', ''))
    INNER JOIN baseDictionary
      ON baseDictionary.bD_property = 'o_act'
      AND o_act != ''
      AND SUBSTRING_INDEX(SUBSTRING_INDEX(o_act, ',', Numbers.n + 1), ',', -1) = baseDictionary.bD_index
  ");
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $title = "What are the types of activities your organization performs?";
  createPie("pieActivities", $results);

}
/*--------------------------------------------------------
function pieSpace() {
  global  $pdo, $title;

  // Example data structure: { pieLegal:{ title: "pieLegal", labels: [...], values: [...] }, pieFinancial:{ title: "pieFinancial", labels: [...], values: [...] } }

  $stmt = $pdo->prepare("
    WITH RECURSIVE Numbers AS (
      SELECT 0 AS n
      UNION ALL
      SELECT n + 1
      FROM Numbers
      WHERE n < (
        SELECT MAX(
          CHAR_LENGTH(o_spa) - CHAR_LENGTH(REPLACE(o_spa, ',', ''))
        )
        FROM orgs
      )
    )

    SELECT
      SUBSTRING_INDEX(SUBSTRING_INDEX(o_spa, ',', Numbers.n + 1), ',', -1) AS value,
      o_name,
      o_spa,
      baseDictionary.bD_trLabel AS s_bD_trLabel
    FROM orgs
    JOIN Numbers
      ON Numbers.n <= CHAR_LENGTH(o_spa) - CHAR_LENGTH(REPLACE(o_spa, ',', ''))
    INNER JOIN baseDictionary
      ON baseDictionary.bD_property = 'o_spa'
      AND o_spa != ''
      AND SUBSTRING_INDEX(SUBSTRING_INDEX(o_spa, ',', Numbers.n + 1), ',', -1) = baseDictionary.bD_index
  ");
  $stmt->execute();
  $title = "What type of spaces can your organization provide?";
  createPie("pieSpace");

}*/
//--------------------------------------------------------
function pieEquipment() {
  global  $pdo, $title;

  // Example data structure: { pieLegal:{ title: "pieLegal", labels: [...], values: [...] }, pieFinancial:{ title: "pieFinancial", labels: [...], values: [...] } }

  $stmt = $pdo->prepare("
    WITH RECURSIVE Numbers AS (
      SELECT 0 AS n
      UNION ALL
      SELECT n + 1
      FROM Numbers
      WHERE n < (
        SELECT MAX(
          CHAR_LENGTH(o_equ) - CHAR_LENGTH(REPLACE(o_equ, ',', ''))
        )
        FROM orgs
      )
    )

    SELECT
      SUBSTRING_INDEX(SUBSTRING_INDEX(o_equ, ',', Numbers.n + 1), ',', -1) AS value,
      o_name,
      o_equ,
      baseDictionary.bD_trLabel AS s_bD_trLabel
    FROM orgs
    JOIN Numbers
      ON Numbers.n <= CHAR_LENGTH(o_equ) - CHAR_LENGTH(REPLACE(o_equ, ',', ''))
    INNER JOIN baseDictionary
      ON baseDictionary.bD_property = 'o_equ'
      AND o_equ != ''
      AND SUBSTRING_INDEX(SUBSTRING_INDEX(o_equ, ',', Numbers.n + 1), ',', -1) = baseDictionary.bD_index
  ");
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $title = "What type of equipments can your organization provide?";
  createPie("pieEquipment", $results);

}
//--------------------------------------------------------
function pieServices() {
  global  $pdo, $title;

  // Example data structure: { pieLegal:{ title: "pieLegal", labels: [...], values: [...] }, pieFinancial:{ title: "pieFinancial", labels: [...], values: [...] } }

  $stmt = $pdo->prepare("
    WITH RECURSIVE Numbers AS (
      SELECT 0 AS n
      UNION ALL
      SELECT n + 1
      FROM Numbers
      WHERE n < (
        SELECT MAX(
          CHAR_LENGTH(o_ser) - CHAR_LENGTH(REPLACE(o_ser, ',', ''))
        )
        FROM orgs
      )
    )

    SELECT
      SUBSTRING_INDEX(SUBSTRING_INDEX(o_ser, ',', Numbers.n + 1), ',', -1) AS value,
      o_name,
      o_ser,
      baseDictionary.bD_trLabel AS s_bD_trLabel
    FROM orgs
    JOIN Numbers
      ON Numbers.n <= CHAR_LENGTH(o_ser) - CHAR_LENGTH(REPLACE(o_ser, ',', ''))
    INNER JOIN baseDictionary
      ON baseDictionary.bD_property = 'o_ser'
      AND o_ser != ''
      AND SUBSTRING_INDEX(SUBSTRING_INDEX(o_ser, ',', Numbers.n + 1), ',', -1) = baseDictionary.bD_index
  ");
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $title = "What type of services can your organization provide?";
  createPie("pieServices", $results);

}
//--------------------------------------------------------
function pieAudience() {
  global  $pdo, $title;

  // Example data structure: { pieLegal:{ title: "pieLegal", labels: [...], values: [...] }, pieFinancial:{ title: "pieFinancial", labels: [...], values: [...] } }

  $stmt = $pdo->prepare("
    WITH RECURSIVE Numbers AS (
      SELECT 0 AS n
      UNION ALL
      SELECT n + 1
      FROM Numbers
      WHERE n < (
        SELECT MAX(CHAR_LENGTH(o_tar) - CHAR_LENGTH(REPLACE(o_tar, ',', '')))
        FROM orgs
      )
    )

    SELECT
      SUBSTRING_INDEX(SUBSTRING_INDEX(o_tar, ',', Numbers.n + 1), ',', -1) AS value,
      o_name,
      o_tar,
      baseDictionary.bD_trLabel AS s_bD_trLabel
    FROM orgs
    JOIN Numbers
      ON Numbers.n <= CHAR_LENGTH(o_tar) - CHAR_LENGTH(REPLACE(o_tar, ',', ''))
    INNER JOIN baseDictionary
      ON baseDictionary.bD_property = 'o_tar'
      AND o_tar != ''
      AND SUBSTRING_INDEX(SUBSTRING_INDEX(o_tar, ',', Numbers.n + 1), ',', -1) = baseDictionary.bD_index
  ");
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $title = "Which audience is your organization targeted to?";
  createPie("pieAudience", $results);
}

function createPie($d, $results) {
  global $chartData, $stmt, $title;

  $xVal = array();
  $yVal = array();
  $items = array();

 foreach ($results as $row) {
          $label = $row['s_bD_trLabel'];
          $name = $row['o_name'];

          if (!in_array($label, $xVal)) {
              $xVal[] = $label;
              $yVal[] = 1;
              $items[$label] = array($name);
          } else {
              $yVal[array_search($label, $xVal)]++;
              $items[$label][] = $name;
          }

      }


  $chartData[] = array($d => array("title" => $title, "labels" => $xVal, "values" => $yVal, "items" => $items));
}



pieLegal();
pieFinancial();
pieType();
pieDefinition();
pieActivities();
/*pieSpace();*/
pieServices();
pieEquipment();
pieAudience();


$jsonData = json_encode($chartData, JSON_UNESCAPED_UNICODE);

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organization Statistics</title>
    <link rel="stylesheet" href="charts.css">
    <link rel="stylesheet" href="../styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>



<script>
document.addEventListener("DOMContentLoaded", function () {
  const pageHeader = document.getElementById("pageheader");

  pageHeader.innerHTML = `
    <span class='mapLink'>
      <a id="pieLegal" class="active">Legal</a>
      <a id="pieType">Type</a>
      <a id="pieDefinition">Definition</a>
      <a id="pieActivities">Activities</a>
      <a id="pieFinancial">Financial</a>
      <a id="pieSpace">Space</a>
      <a id="pieServices">Services</a>
      <a id="pieEquipment">Equipment</a>
      <a id="pieAudience">Audience</a>
    </span>
  `;

  let subLinks = document.querySelectorAll("#pageheader .mapLink a");

    subLinks.forEach(link => {
      console.log(link);
      link.addEventListener("click", function () {
        subLinks.forEach(l => l.classList.remove("active"));
        this.classList.add("active");
        generateChart(this.id);
      });
    });
    document.getElementById("pieLegal").click();
});


</script>

  <div id="chartContainer">
      <canvas id="myChart" ></canvas>
  </div>

  <footer><div id="legend"></div></footer>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script type="text/javascript">
  var data;
  var xValues, yValues, title, items;
  var myChart;
  var barColors = ['#FF6633', '#FFB399', '#FF33FF', '#FFFF99', '#00B3E6',
      '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D',
      '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A',
      '#FF99E6', '#CCFF1A', '#FF1A66', '#E6331A', '#33FFCC',
      '#66994D', '#B366CC', '#4D8000', '#B33300', '#CC80CC',
      '#66664D', '#991AFF', '#E666FF', '#4DB3FF', '#1AB399',
      '#E666B3', '#33991A', '#CC9999', '#B3B31A', '#00E680',
      '#4D8066', '#809980', '#E6FF80', '#1AFF33', '#999933',
      '#FF3380', '#CCCC00', '#66E64D', '#4D80CC', '#9900B3',
      '#E64D66', '#4DB380', '#FF4D4D', '#99E6E6', '#6666FF'];



  function generateChart(chartType) {
      if (myChart) {
          myChart.destroy(); // Destroy the existing chart
      }

data = <?php echo $jsonData; ?>;

      console.log("chartType:", chartType);
      console.log("data:", data);

      var pieObject = data.find(item => item[chartType]);
      console.log("pieObject:", pieObject);

      xValues = pieObject ? pieObject[chartType].labels : [];
      yValues = pieObject ? pieObject[chartType].values : [];
      items = pieObject ? pieObject[chartType].items : {};

      console.log("xValues:", xValues);
      console.log("yValues:", yValues);
      console.log("items:", items);

      myChart = new Chart("myChart", {
          type: "pie",
          data: {
              labels: xValues,
              datasets: [{
                  backgroundColor: barColors,
                  data: yValues
              }]
          },
          options: {
              maintainAspectRatio: false,
              responsive: true,
              aspectRatio: 1,
              plugins: {
                legend: {
                    display: true,
                    position: 'right',
                    labels: {
                        boxWidth: 12,       // Makes legend boxes square (equal width and height)
                        boxHeight: 12,      // Optional: defaults to boxWidth
                        borderRadius: 0,    // Ensures sharp corners (no border radius)
                        borderWidth: 0,     // Removes any border
                        font: {
                            family: "'Space Mono', sans-serif",
                            size: 12
                        },
                        generateLabels: function(chart) {
                            const data = chart.data;
                            return data.labels.map((label, index) => {
                                const value = data.datasets[0].data[index];
                                const total = data.datasets[0].data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(2);
                                return {
                                    text: `${label}: ${value} (${percentage}%)`,
                                    fillStyle: data.datasets[0].backgroundColor[index],
                                    index: index,
                                    strokeStyle: 'transparent', // Removes stroke border
                                    lineWidth: 0 // Ensures no outline
                                };
                            });
                        }
                    }
                },
                                  tooltip: {
                      enabled: true, // Enable default tooltips
                  }
              },
              layout: {
                  padding: {
                      left: 10,
                      right: 10,
                      top: 20,
                      bottom: 50 // Added padding at the bottom for the list
                  }
              },
              elements: {
                  arc: {
                      borderWidth: 0 // Remove border from the pie segments
                  }
              },
              title: {
                  fontSize: 14,
                  fontFamily: "'Space Mono', sans-serif",
                  display: true,
                  text: pieObject[chartType].title
              },
              onHover: function(event, chartElement) {
                  if (chartElement.length) {
                      var index = chartElement[0].index;
                      var label = myChart.data.labels[index];
                      updateInfoBox(label);
                  } else {
                      clearInfoBox();
                  }
              }
          },
          plugins: [{
              id: 'customCanvasBackgroundColor',
              beforeDraw: (chart) => {
                  const ctx = chart.canvas.getContext('2d');
                  ctx.save();
              },
              afterDraw: (chart) => {
                  const ctx = chart.ctx;
                  const canvasWidth = chart.width;
                  const canvasHeight = chart.height;
                  const padding = 10;
                  const listStartY = 50;
                  const maxLineWidth = (canvasWidth / 2 ) - 2 * padding;

                  ctx.save();
                  ctx.font = "14px 'Space Mono', sans-serif";
                  ctx.fillStyle = 'black';
                  ctx.textAlign = 'left';
                  ctx.textBaseline = 'top';

                  // Wrap text function
                  function wrapText(text, x, y, maxWidth) {
                      const words = text.split(' ');
                      const paddingTop = 20;
                      let line = '';
                      let lineHeight = 16; // Adjust if needed
                      for (let n = 0; n < words.length; n++) {
                          const testLine = line + words[n] + ' ';
                          const metrics = ctx.measureText(testLine);
                          const testWidth = metrics.width;
                          if (testWidth > maxWidth && n > 0) {
                              ctx.fillText(line, x, y + paddingTop);
                              line = words[n] + ' ';
                              y += lineHeight;
                          } else {
                              line = testLine;
                          }
                      }
                      ctx.fillText(line, x, y + paddingTop);
                  }

                  if (currentList.length > 0) {
                      const listText = currentList.join(', ');
                      wrapText(listText, padding, listStartY, maxLineWidth);
                  }

                  ctx.restore();
              }
          }]
      });
  }

  var currentList = [];

  function updateInfoBox(label) {
      currentList = items[label] || [];
      myChart.update();
  }

  function clearInfoBox() {
      currentList = [];
      myChart.update();
  }

  </script>

 <?php
 include '../footer.php';
 ?>
