let ind;
let canvas;

function preload() {
  ind = loadJSON("js/db.json");
}

function setup() {
  noCanvas();
  createMap();
}

function createMap() {
  let layer = new L.StamenTileLayer("toner-lite");
  let map = new L.Map("geographical", {
    center: new L.LatLng(39.5, 28.5),
    zoom: 7,
    minZoom: 3,
    maxZoom: 17,
  });
  map.addLayer(layer);

  let markers = new L.MarkerClusterGroup({
    showCoverageOnHover: false
  });
  let icon = new L.Icon.Default();
  icon.options.shadowSize = [0, 0];
  for (item in ind) {
    let a = ind[item];
    let id = a.id;
    let marker = L.marker(new L.LatLng(a.lat, a.lon), {
      icon: icon
    });
    //marker.feature ={properties:{id: id}};
    marker.id = id;
    marker.bindPopup("loading...");
    marker.on('click', loadPlaceData);
    markers.addLayer(marker);
  }
  map.addLayer(markers);
}

// Open the full screen search box
function openItem(str) {
  resetViews();
  console.log("loading " + str);
  if (str == "listing") {
    if (select('#listing').html() == "") listing();
  } else select('#listing').html("");
  select('#' + str).style('display', 'block');
  select('#' + str).style('opacity', '1');
}

// Close the full screen search box
function closeItem(str) {
  document.getElementById(str).style.display = "none";
}

let pages = ["#about", "#geographical", "#listing", "#relational", "#search"];

function resetViews() {
  pages.forEach(function(item) {
    select(item).style('opacity', '0');
    select(item).style('display', 'none');
  });
}

function loadPlaceData(e) {
  let popup = e.target.getPopup();
  //console.log(popup);

  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      for (let key in ind) {
        if (ind[key].id == "" + popup._source.id) {
          popup._content = "<h2>" + ind[key].org_name + "</h2>";
          popup._content += "<p>" + ind[key].odak_noktasi + "</p>";
          //console.log("found"+ind[key].org_name);
        }
      }
      //popup._content = ""+popup._source.id;
      popup.update();
    }
  };
  xhttp.open("GET", "js/db.json", true); //to be substituted with a php call
  xhttp.send();
};

function listing() {
  let l = createDiv().id("listing_list");

  for (let item in ind) {
    l.html("<h2><a class='listing_label' id='lab" + ind[item].id + "' onclick='openLabel(" + ind[item].id + ")'>" + ind[item].org_name + "</a></h2>", true);
  }
  let d = createDiv().id("listing_desc");
  let c = createDiv().id("listing_cont");
  c.child(l);
  c.child(d);
  select('#listing').child(c);
}

function openLabel(id) {
  let s = select("#lab" + id);
  if (s.hasClass('sel')) {
    closeLabel(id);
    //console.log("we passed");
  } else {
    s.addClass('sel');
    let x = createDiv().class("closeLabelBtn").html("<a onclick='closeLabel("+id+")'>x</a>");

    let l = createDiv().id("label_desc" + id).class("floater");
    l.position(mouseX, mouseY);

    l.html("<h2 id='#lab" + id + "header'>" + ind[id].org_name + "</h2><p>" + ind[id].odak_noktasi + "</p>");
    dragElement(document.getElementById("label_desc" + id));
    l.child(x);
    select("#listing_cont").child(l);
  }
  //l.attribute("draggable","true");
  /*let sel=select(".sel")
  if(sel!=null) sel.removeClass('sel');
  let d=select("#listing_desc");
  let c=select('#listing_cont');
  c.style('width','55vw');
  d.style('width','0');
  d.style('opacity','0');
  d.html("");
  c.style('width','75vw');
  setTimeout(function(){

    d.child(l);
    d.style('width','20vw');
    d.style('opacity','1');
  },100);

  console.log(id);*/
}
function closeLabel(id){
  let r = select("#lab" + id);
  r.removeClass('sel');
  document.querySelector("#label_desc" + id).remove();
}


// Make the DIV element draggable:


function dragElement(elmnt) {
  var pos1 = 0,
    pos2 = 0,
    pos3 = 0,
    pos4 = 0;
  if (document.getElementById(elmnt.id + "header")) {
    // if present, the header is where you move the DIV from:
    document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
  } else {
    // otherwise, move the DIV from anywhere inside the DIV:
    elmnt.onmousedown = dragMouseDown;
  }

  function dragMouseDown(e) {
    e = e || window.event;
    e.preventDefault();
    // get the mouse cursor position at startup:
    pos3 = e.clientX;
    pos4 = e.clientY;
    document.onmouseup = closeDragElement;
    // call a function whenever the cursor moves:
    document.onmousemove = elementDrag;
  }

  function elementDrag(e) {
    e = e || window.event;
    e.preventDefault();
    // calculate the new cursor position:
    pos1 = pos3 - e.clientX;
    pos2 = pos4 - e.clientY;
    pos3 = e.clientX;
    pos4 = e.clientY;
    // set the element's new position:
    elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
    elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
  }

  function closeDragElement() {
    // stop moving when mouse button is released:
    document.onmouseup = null;
    document.onmousemove = null;
  }
}
