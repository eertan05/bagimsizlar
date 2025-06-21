<?php
session_start();
require '../db_connect.php';
require '../lang_man.php';
$dict = array_map('str_getcsv', file('../baseDictionary.csv'));
?>

<html>

<head>
  <link rel="stylesheet" href="trans.css">
  <link rel="stylesheet" href="window-engine.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
  <?php
echo " >>>jsonCreated: ".$_SESSION["jsonCreated"];
  if (1){
  $_SESSION["jsonCreated"] = 1;
  /* ------- creating b_rel.JSON */
  $dbChar = 'utf8';
  $bD_properties=Array([$labels[34],'o_typeID',$labels[44]],
  [$labels[35],'o_definitionID',$labels[45]],
  [$labels[36],'o_legalStatusID',$labels[46]],
  [$labels[37],'o_fieldID',$labels[47]
//  ,
//  [$labels[38],'o_financialID',$labels[48]],
//  [$labels[39],'o_activitiesID',$labels[49]],
//  [$labels[40],'o_resourcesSpaceID',$labels[50]],
//  [$labels[41],'o_resourcesEquipmentID',$labels[51]],
//  [$labels[42],'o_resourcesServiceID',$labels[52]],
//  [$labels[43],'o_audienceID',$labels[53]
  ]
);


  try {
    $pdo = new PDO(
      "mysql:host=$servername;dbname=$dbname;charset=$dbChar",
      $username,
      $password,
      [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
  } catch (Exception $ex) {
    die($ex->getMessage());
  }


  $node_id = 0;
  $myfile = fopen("uploads/b_rel2.json", "w") or die("Unable to open file!");
  $stmt = $pdo->prepare("SELECT * FROM `organizations`");
  $stmt->execute();

  $nodes .= '{"nodes":[';
  $edges .= '"links":[';

  //$prop_Unique = 0;
  $propsies=array();
  foreach ($bD_properties as $p) {
    foreach ($dict as $word) {
      if(strcmp($word[1], $p[1]) == 0) {
        $nodes .= '{';
        $nodes .= implode(',', ['"id":'.$node_id ,'"name":"'.$word[5].'"', '"l_id":'.$word[2], '"type":"'.$p[1].'"']); //{"name":"NOBON-İlham Veren İşler #izmirdeoluyor","id":8,"type":"organization"},
        $nodes .= '},';
        $newProp = array( "id" => $node_id,
                        "name" => $word[5],
                        "l_id" => $word[2],
                        "type" => $p[1]);
        array_push($propsies, $newProp);
        //echo "\n".$node_id.">".$p[1].">".$word[5].">".$word[2];
        $node_id++;
      }
    }
  }

  //$lastNode_id=$node_id;
  while ($row = $stmt->fetch(PDO::FETCH_NAMED)) {
    $nodes .= '{';
    $nodes .= implode(',', ['"id":'.$node_id ,'"name":"'.$row['o_name'].'"', '"o_id":'.$row['o_id'], '"type":"o_organizationID"']); //{"name":"NOBON-İlham Veren İşler #izmirdeoluyor","id":8,"type":"organization"},
    $nodes .= '},';

    foreach ($bD_properties as $p){
      $actualprops= explode(",", $row[$p[1]]);
      foreach($actualprops as $act_prop) {
        if (is_numeric($act_prop)) {
        $edges .= '{';
        $targ = searchPropertiesName($p[1],$act_prop,$propsies);
        $edges .= implode(',', ['"source":'.$node_id, '"relation":"is"', '"target":'.$targ]); //{"source":0,"relation":"admin of","target":99},
        $edges .= '},';
        }
      }
    }
    $node_id++;
  }
  $stmt = $pdo->prepare("SELECT * FROM `persons`");
  $stmt->execute();
  while ($row = $stmt->fetch(PDO::FETCH_NAMED)) {
    $nodes .= '{';
    $nodes .= implode(',', ['"id":'.$node_id,'"name":"'.$row['p_name'].'"', '"p_id":'.$row['p_id'], '"type":"o_personID"']); //{"name":"NOBON-İlham Veren İşler #izmirdeoluyor","id":8,"type":"organization"},
    $nodes .= '},';
    $node_id++;
  }

  $nodes=mb_substr($nodes, 0, -1);
  $nodes .= '],';
  $edges=mb_substr($edges, 0, -1);
  $edges .= ']}';
  fwrite($myfile, $nodes.$edges);
  fclose($myfile);

}


  function searchPropertiesName($stype, $sid, $sarray) {
    foreach ($sarray as $prop){
      if ((strcmp($prop["type"], $stype) == 0) && ($prop["l_id"] == $sid)){
          return $prop["id"];
      }
    }
    return null;
  }

?>


  <header>
    <p class="title"> <img src="images/trans-making-logo.png"></p>

    <?php
    //------- loading data files --->
      $mydir = 'uploads';
      //      $myfiles = array_diff(scandir($mydir), array('.', '..'));
      $myfiles = scandir($mydir);
      foreach ($myfiles as &$file) {
        print_r("<p class='datafile'><a href='?f=" .$file. "'>".explode(".",$file)[0]."</a></p>");
      }
    ?>

  </header>

  <div class="windowGroup smallText">

    <!-- WINDOW 1 -->
    <div id="window1" class="window">
      <div class="gray">
        <p class="windowTitle">filters</p>
      </div>
      <div class="mainWindow" id="filtercheckboxes">
      </div>
    </div>

    <!-- WINDOW 2 -->
    <div id="window2" class="window fade">
      <div class="gray">
        <p class="windowTitle">node information</p>
      </div>
      <div id="nodeInfo" class="mainWindow">
      </div>
    </div>

    <!-- WINDOW 3 -->
    <div id="window3" class="window fade developer">
      <div class="crimson">
        <p class="windowTitle">load data</p>
      </div>
      <div id="loadData" class="mainWindow">
        <script lang="javascript" src="js/xlsx.full.min.js" type="text/javascript"></script>
        <script>
          $(document).ready(function() {
            $("#fileUploader").change(function(evt) {
              var selectedFile = evt.target.files[0];
              var reader = new FileReader();
              reader.onload = function(event) {
                var data = event.target.result;
                var workbook = XLSX.read(data, {
                  type: 'binary'
                });

                var json_object = [];
                workbook.SheetNames.forEach(function(sheetName) {
                  if (sheetName == "nodes" || sheetName == "NODES") {
                    var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                    json_object[0] = JSON.stringify(XL_row_object);
                  }
                  if (sheetName == "edges" || sheetName == "EDGES") {
                    var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                    json_object[1] = JSON.stringify(XL_row_object);
                  }
                });

                json_object = '{"nodes":' + json_object[0] + ', "links":' + json_object[1] + '}';
                //document.getElementById("jsonObject").innerHTML = json_object;

                // save JSON files on Server
                blobajax(json_object);

              };

              reader.onerror = function(event) {
                console.error("File could not be read! Code " + event.target.error.code);
              };

              reader.readAsBinaryString(selectedFile);
            });

            function blobajax(cont) {
              // (A) CREATE BLOB OBJECT
              var myBlob = new Blob([cont], {
                type: "text/plain"
              });
              // (B) FORM DATA
              var data = new FormData();
              var n = $("#fileName").val() + ".json"
              data.append("upfile", myBlob, n);
              // (C) AJAX UPLOAD TO SERVER
              var xhr = new XMLHttpRequest();
              xhr.open("POST", "upload.php");
              xhr.onload = function() {
                console.log(this.status);
                console.log(this.response);
                if (this.status == 200) {
                  //location.reload();
                  window.location.href = window.location.href.replace(/[\?#].*|$/, "?f=" + n);
                } else {
                  document.getElementById("jsonObject").innerHTML = "ERROR. please check the excel file and try again";
                }
              };
              xhr.send(data);
            }


            $("#fileName").keyup(function() {
              $("#fb").css("display", "block");
            });

          });
        </script>
        <p>
          You can upload your data as an excel file.
          It should have two sheets named "NODES" and "EDGES"</p>
        <hr>
        <p> NODES column names must be:
          id, name, type, info, value (the last two are optional)</br>
          </br>
          (value sorts nodes on a horizontal line;</br>
          info is shown when node clicked)
        </p>
        <hr>
        <p> EDGES column names must be:
          source, destination, relation</p>
        <hr>
        <p>see example files: <br>
          <img src="images/NODES.png" width="200px" ;><br>
          <img src="images/EDGES.png" width="200px" ;>
        </p>


        <label id="jsonObjectLink">upload a new excel file </label>
        <div>
          <span class="smallText">name your file to access later</br></span>
          <input type="text" id="fileName" name="fileName">
        </div>
        <div id="fb">
          <span class="smallText">select your excel file</br></span>
          <input type="file" id="fileUploader" name="fileUploader" accept=".xls, .xlsx" />
        </div>
      </div>
    </div>
  </div>
  <footer>
    <span id="button1">filters</span>
    <span id="button2">node info</span>
    <label class="largeCheckbox"><input type="checkbox" id="trackingMode"><span class="mark"></span>tracking mode</label>
    <span class="seperator admin"> | </span>
    <span id="button3" class="admin">load your data</span>
  </footer>
  <svg id='viz'></svg>
</body>

<script src='https://d3js.org/d3.v5.min.js'></script>
<script>
  var width = window.innerWidth;
  var height = window.innerHeight;
  //var color = d3.scaleOrdinal(d3.schemeCategory10);
// trans-making color scheme:
//#00BFDD #008DA8 #006168 #4B8B40 #21B56E #76BC43 #CEB52C #FFCE02 #FAA21B #F58320 #F15E3E #A8353A #762157 #231F20
  var color = d3.scaleOrdinal()
    .domain([0,1,2,3,4,5,6,7,8,9,10,11,12,13,14])
    .range([ //for white bg
      '#FF0000', // Red
      '#FFA500', // Orange
      '#FFFF00', // Yellow
      '#00FF00', // Lime Green
      '#008000', // Green
      '#00FFFF', // Cyan
      '#0000FF', // Blue
      '#4B0082', // Indigo
      '#800080', // Purple
      '#FFC0CB', // Pink
      '#A52A2A', // Brown
      '#808080', // Gray
      '#008080', // Teal
      '#FFD700', // Gold
      '#E6E6FA', // Lavender
              ]);
/*      .range([ //for black bg
        '#D3D3D3', // Light Gray
        '#FFFFE0', // Light Yellow
        '#90EE90', // Light Green
        '#ADD8E6', // Light Blue
        '#FFB6F1', // Light Pink
        '#BA55D3', // Light Purple
        '#FF6666', // Light Red
        '#FFCC99', // Light Orange
        '#E0FFFF', // Light Cyan
        '#00CED1', // Light Teal
        '#FFD700', // Light Gold
        '#9370DB', // Light Indigo
        '#A0522D', // Light Brown
        '#E6E6FA', // Light Lavender
        '#FF00FF', // Light Magenta
      ]); */

//  .range(['#e6194b', '#3cb44b', '#ffe119', '#4363d8', '#f58231', '#911eb4', '#46f0f0', '#f032e6', '#bcf60c', '#fabebe', '#008080', '#e6beff', '#9a6324', '#fffac8', '#800000', '#aaffc3', '#808000', '#ffd8b1', '#000075']);
//.range(["#00BFDD", "#008DA8", "#006168", "#4B8B40", "#21B56E", "#76BC43", "#CEB52C", "#FFCE02", "#FAA21B", "#F58320", "#F15E3E", "#A8353A", "#762157", "#231F20"]);
  var controls = {};
  var keepFocused = false;
  var focusIndex;
  var mapNodeSize = createRemap(1, 300, 5, 40);
  var jsonFile;
  var dataFile;

  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  var file = urlParams.get('f')
  var admin = urlParams.get('admin') != null ? 1 :0;
  if (file != null) {
    dataFile = "uploads/" + file;
  } else {
    dataFile = "uploads/b_rel.json";
  }
  console.log(dataFile);

  /* add the error code here if json could not created... so there is no file
    $.get(dataFile)
      .done(function() {
        if (dataFile.length == 0) {
          jsonFile = "uploads/sampleGraph.json";
        }
        console.log("done");
      })
      .fail(function() {
        jsonFile = "uploads/sampleGraph.json";
        console.log("fail");
      })
    console.log("json: " + jsonFile);
  */


  d3.json(dataFile).then(function(graph) {
    graph.nodes.forEach(function(d) {
      d.size = 0;
      if (!(d.type in controls)) {
        controls[d.type] = true;
      }
    });

    Object.entries(controls).forEach(([key, value]) => {
      //replace the names if required
      if (file.startsWith("b_rel")){keyShown = key.slice(2,-2);}else {keyShown = key;}
      // create the checkbox in window1
      document.getElementById("filtercheckboxes").innerHTML += '<input type="checkbox" class="types" id=' + key + ' value=' + key + ' checked> <span style="color:' + color(key) + '; weight:bold" >' + keyShown + '</span></br>'
    });

    var graphLayout = d3.forceSimulation(graph.nodes)
      .force("charge", d3.forceManyBody().strength(-3000))
      .force("center", d3.forceCenter(width / 2, height / 2))
      .force("x", d3.forceX(width / 2).strength(1))
      .force("y", d3.forceY(height / 2).strength(1))
      .force("link", d3.forceLink(graph.links).id(function(d){
        return d.id}).distance(500).strength(0.1))
        // d.name vs d.id but couldnot make it based on the index; it looks for id/name  somewhere
      .on("tick", ticked);

    var adjlist = [];
    graph.links.forEach(function(d) {
      adjlist[d.source.index + "-" + d.target.index] = true;
      adjlist[d.target.index + "-" + d.source.index] = true;
      graph.nodes[d.source.index].size++;
      graph.nodes[d.target.index].size++;
    });

    function isNeighbor(a, b) {
      return (a == b || adjlist[a + "-" + b]);
    }

    d3.selectAll("#filtercheckboxes .types").on("click", function() {
      controls[this.value] = this.checked;
      showHide();
    });

    d3.select("#trackingMode").on("click", function() {
      keepFocused = this.checked;
      if (!keepFocused) focusIndex = "";
      node.call(refresh);
    });


    d3.selectAll(".admin")
      .style("display", function(){ return admin? "inline" : "none"});

    var svg = d3.select("#viz").attr("width", width).attr("height", height);
    var container = svg.append("g");

    svg.call(
      d3.zoom()
      .scaleExtent([.1, 7])
      .on("zoom", function() {
        container.attr("transform", d3.event.transform);
      })
    );

    var link = container.append("g").attr("class", "links")
      .selectAll("line")
      .data(graph.links)
      .enter()
      .append("line")
      .attr("stroke", function(d) {  return color(d.relation); })
      .attr("opacity", .4)
      .attr("stroke-width", .5);

    var node = container.append("g").attr("class", "nodes")
      .selectAll("node")
      .data(graph.nodes)
      .enter()
      .append("svg:circle")
      .attr("class", "circle")
      .attr("r", function(d) {return mapNodeSize(d.size); })
      .attr("fill", function(d) {  return color(d.type); });
      //    .attr("x", function(d){return d.x})
      //    .attr("y", function(d){return d.y});

/**********************************  circle'a imaj ekleyemedim!!!
    var img = container.append("g")
      .selectAll("g")
      .data(graph.nodes)
      .enter()

      d3.select(".nodes")
      .data(graph.nodes)
      .enter()
      .append("svg:image")
        .attr("xlink:href", function(d) {
          return "https://github.com/favicon.ico"; //"/images/ee.jpg";
        })
        .attr("x", 12)//function(d){ return d.x})
        .attr("y", 12)//function(d){ return d.y})
        .attr("width", "24px")
        .attr("height", "24px");
*************************************/


    node.on("mouseover", focus).on("mouseout", unfocus);

    node.call(
      d3.drag()
      .on("start", dragstarted)
      .on("drag", dragged)
      .on("end", dragended)
    );

    var labelNode = container.append("g").attr("class", "labelNodes")
      .selectAll("text")
      .data(graph.nodes)
      .enter()
      .append("text")
      .text(function(d) {
        return d.name;
      })
      .attr("dx", function(d) {
        return mapNodeSize(d.size) + 2;
      })
      .attr("dy", function(d) {
        return mapNodeSize(d.size) / 2;
      })
      .style("fill", "#555")
      .style("font-family", "Helvetica")
      .style("font-size", 12)
      .style("font-weight", 100)
      .style("text-transform", "lowercase")
      .style("pointer-events", "none") // to prevent mouseover/drag capture
      .style("fill", function(d) {
        return color(d.type)
      });


// link labels ******************

      var labelLink = container.append("g").attr("class", "labelLinks")
        .selectAll("text")
        .data(graph.links)
        .enter()
        .append("text")
        //.attr("xlink:href", ".links")
        .attr("transform", function(d) { //calcul de l'angle du label
              var angle = Math.atan((d.source.y - d.target.y) / (d.source.x - d.target.x)) * 180 / Math.PI;
              return 'translate(' + [(d.source.x + d.target.x) / 2, (d.source.y + d.target.y) / 2] + ')rotate(' + angle + ')';
            })
        .attr("display", "none") //comment out to show link labels
        .style("font-family", "Helvetica")
        .style("font-size", ".4em" )
        .style("font-weight", 100)
        .style("text-transform", "lowercase")
        .style("pointer-events", "none") // to prevent mouseover/drag capture
        .style("fill", function(d) {
          return color(d.relation);
        })
        .text(function(d) {
          return d.relation;
        });

// end link labels *********************** */

    node.on("mouseover", focus).on("mouseout", unfocus);

    function ticked() {
      node.call(updateNode);
      link.call(updateLink);
      labelNode.call(updateNode);
      labelLink.call(updateLabelLink);
    }

    function fixna(x) {
      if (isFinite(x)) return x;
      return 0;
    }

    function focus(d) {
    focusIndex = d3.select(this).datum().index;
      node.call(refresh);

      // ......
      d3.select(this)
      .transition()
        .duration(750)
        .attr("r", mapNodeSize(d.size))
        //.style("fill", "gray");
      //

      var txt = "<h3>" + d.name + "</h3>";
      if (d.info !== undefined) {
        if (d.info.search("https://") !== -1) {
        //  d.info = d.info.replace("<iframe", "<iframe width=460 height=400 frameBorder=0 ");
          d.info = "<iframe src='".concat(d.info, "' width=460 height=400 frameBorder=0></iframe>");
        }
        txt += "<div>" + d.info+ "</div>";

      }
      document.getElementById("nodeInfo").innerHTML = txt ;
      //button2.click();
    }

    function unfocus() {
      if (!keepFocused) {
        focusIndex = "";
        node.call(refresh);
      }
    }

    function showHide() {
      node.attr("display", function(d) {
        return controls[d.type] ? "block" : "none"
      });
      labelNode.attr("display", function(d) {
        return controls[d.type] ? "block" : "none"
      });
      link.attr("display", function(d) {
        return (controls[d.target.type] && controls[d.source.type]) ? "block" : "none"
      });
      labelLink.attr("display", function(d) {
        return (controls[d.target.type] && controls[d.source.type]) ? "block" : "none"
      });
      node.call(refresh);
    }

    function refresh(node) {
      node.style("opacity", function(d) {
        return controls[d.type] && (isNeighbor(focusIndex, d.index) || focusIndex == "") ? .9 : 0.1;
      });
      labelNode.style("opacity", function(d) {
        return controls[d.type] && (isNeighbor(focusIndex, d.index) || focusIndex == "") ? .9 : 0.1;
      });
      link.style("opacity", function(d) {
        return (controls[d.target.type] || controls[d.source.type]) && (isNeighbor(focusIndex, d.target.index) && isNeighbor(focusIndex, d.source.index) || focusIndex == "") ? .5 : 0.1;
      });
      labelLink.style("opacity", function(d) {
        return (controls[d.target.type] || controls[d.source.type]) && (isNeighbor(focusIndex, d.target.index) && isNeighbor(focusIndex, d.source.index) || focusIndex == "") ? .5 : 0.1;
      });
    }

    function updateLink(link) {
      link.attr("x1", function(d) {
          return fixna(d.source.x);
        })
        .attr("y1", function(d) {
          return fixna(d.source.y);
        })
        .attr("x2", function(d) {
          return fixna(d.target.x);
        })
        .attr("y2", function(d) {
          return fixna(d.target.y);
        });
    }

    function updateNode(node) {
      node.attr("transform", function(d) {
        return "translate(" + fixna(d.x) + "," + fixna(d.y) + ")";
      });
    }

    function updateLabelLink(link) {
      link.attr("transform", function(d) { //calcul de l'angle du label
            var angle = Math.atan((d.source.y - d.target.y) / (d.source.x - d.target.x)) * 180 / Math.PI;
            return 'translate(' + [(d.source.x + d.target.x) / 2, (d.source.y + d.target.y-3) / 2] + ')rotate(' + angle + ')';
          })
    }

    function dragstarted(d) {
      d3.event.sourceEvent.stopPropagation();
      if (!d3.event.active) graphLayout.alphaTarget(0.3).restart();
      d.fx = d.x;
      d.fy = d.y;
    }

    function dragged(d) {
      d.fx = d3.event.x;
      d.fy = d3.event.y;
    }

    function dragended(d) {
      if (!d3.event.active) graphLayout.alphaTarget(0);
      d.fx = null;
      d.fy = null;
    }

  }); // d3.json

  function createRemap(inMin, inMax, outMin, outMax) {
    return function remaper(x) {
      return (x - inMin) * (outMax - outMin) / (inMax - inMin) + outMin;
    };



  }
</script>

</html>
<script src="window-engine.js"></script>
