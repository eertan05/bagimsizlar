let ind;
let canvas;
var markersList = [];
var map;
var xmlhttp = new XMLHttpRequest();

var url = "mapGetter.php";
let orgSelected;


xmlhttp.onreadystatechange = function () {
    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
        try {
            ind = JSON.parse(xmlhttp.responseText);
            ind.forEach(item => item.show = true);
            createMap("");
            setInterval(() => {
                map.invalidateSize();
            }, 100);
        } catch (e) {
            console.error("JSON Parse Error:", e);
        }
    } else if (xmlhttp.readyState === 4) {
        console.error("Error:", xmlhttp.status, xmlhttp.statusText);
    }
};

xmlhttp.open("GET", url, true);
xmlhttp.send();


function createMap(filtering) {
  //let list = document.getElementById("list");

  //let layer = new L.StamenTileLayer("toner-lite");
  map = new L.Map("geographical", {
    center: new L.LatLng(39.3, 34.5),
    zoom: 6,
    minZoom: 3,
    maxZoom: 17,
  });
  L.tileLayer(
    "https://tiles.stadiamaps.com/tiles/stamen_toner_lite/{z}/{x}/{y}{r}.png",
    {
      maxZoom: 20,
      attribution:
        '&copy; <a href="https://stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://stamen.com/" target="_blank">Stamen Design</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/about" target="_blank">OpenStreetMap</a> contributors',
    }
  ).addTo(map);
  //map.addLayer(layer);
  showMapData(filtering);
}

function showMapData(filtering) {
  if (filtering != "") mapFilter(filtering);
  let markers = new L.layerGroup();
  markers.myTag = "datalayer";
  let icon = new L.Icon.Default();
  icon.options.shadowSize = [0, 0];

  let filteredItem = 0;
  for (item in ind) {
    let a = ind[item];
    if (!a.show) continue;
    filteredItem++;

    let id = a.id;
    if (a.location != "") {
      let location = a.location.split(",");
      let lon = location[0];
      let lat = location[1];

      let marker = L.marker(
        new L.LatLng(lat, lon),
        {
          title: a.name,
          alt: a.name,
          id: id,
        },
        {
          icon: icon,
        }
      );
      marker.bindPopup("<h3>" + a.name + "</h3>");
      marker.on("click", function () {
        loadOrgData(id);
      });
      marker.on("mouseover", function () {
        markerPop(id);
      });
      markersList.push(marker);
      marker.addTo(markers);
    }
    let ta = document.createElement("a");
    ta.append(a.name);
    ta.setAttribute("onclick", "loadOrgData(" + id + ");");
    ta.setAttribute("onmouseover", "markerFunction(" + id + ");");

    ta.className = "listing_label";
    list.append(ta);
  }
  map.addLayer(markers);

  //markers.addTo(map);
  let listing_title = document.getElementById("listing_title");
  listing_title.innerHTML = "Listing " + filteredItem + " of " + ind.length;
}

function mapFilter(filtering) {
  for (item in ind) {
    ind[item].show = true;
  }

  let f;
  let fname;

  switch (filtering.charAt(0)) {
    case "0":
      let alphabeticalStartWith = filtering.charAt(1);
      if (alphabeticalStartWith != "*") {
        for (item in ind) {
          if (ind[item].name.toLowerCase().charAt(0) != alphabeticalStartWith) {
            ind[item].show = false;
          }
        }
      } else ind[item].name.show = true;
      break;
    case "t":
      f = document.getElementsByClassName("ty");
      fname = "Type";
      filterSystem(f, fname);
      break;
    case "f":
      f = document.getElementsByClassName("fi");
      fname = "Fields";
      filterSystem(f, fname);
      break;
    case "d":
      f = document.getElementsByClassName("de");
      fname = "Definition";
      filterSystem(f, fname);
      break;
    case "c":
      f = document.getElementsByClassName("ac");
      fname = "Activities";
      filterSystem(f, fname);
      break;
    case "i":
      f = document.getElementsByClassName("fc");
      fname = "Financial";
      filterSystem(f, fname);
      break;
    case "l":
      f = document.getElementsByClassName("ls");
      fname = "Legal Status";
      filterSystem(f, fname);
      break;
    case "a":
      f = document.getElementsByClassName("au");
      fname = "Audience";
      filterSystem(f, fname);
      break;
    case "q":
      f = document.getElementsByClassName("rq");
      fname = "Resources: Equipments";
      filterSystem(f, fname);
      break;
    case "s":
      f = document.getElementsByClassName("rs");
      fname = "Resources: Services";
      filterSystem(f, fname);
      break;
    case "r":
      f = document.getElementsByClassName("re");
      fname = "Resources: Spaces";
      filterSystem(f, fname);
      break;
  }
}

function filterSystem(f, fname) {
  for (let i = 0; i < f.length; i++) {
    if (f[i].checked) {
      let fieldSelected = f[i].name.slice(1);
      for (item in ind) {
        if (!filterFor(ind[item], fname, fieldSelected)) ind[item].show = false;
      }
    }
  }
}

function markerPop(id) {
  const found = markersList.find((element) => element.options.id == id);
  if (found) {
    found.openPopup();
  }
}

function markerFunction(id) {
  const found = markersList.find((element) => element.options.id == id);
  if (found) {
    found.openPopup();
    map.flyTo(new L.LatLng(found._latlng.lat, found._latlng.lng), 8);
  }
}

/*-------this function returns if the value of a specific field is found -*/
function selectIfData(id, field, value) {
  let xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      let data = JSON.parse(this.responseText);
    }
  };
  xhttp.open("GET", url + "?id=" + id + "&language=" + lang, true);
  xhttp.send();
}
/*-------------------------------------------*/
function filterFor(el, field, value) {
  let fArr = el[field].split(",");
  return fArr.includes(value);
}

function loadOrgData(id) {
  if (id != orgSelected) {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        let data = JSON.parse(this.responseText);
        let container = document.createElement("div");
        container.classList.add("data-container");

        for (var key in data[0]) {
          let value = data[0][key];

          // Skip if value is empty, null, or undefined
          if ( value === "—" || !value ) continue;

          let itemDiv = document.createElement("div");
          itemDiv.classList.add("data-item", key.replace(/\s/g, ""));

          itemDiv.innerHTML = `
            ${key !== "Name" ? `<label class="data-label">${key}</label>` : ""}
            <span class="data-content">${
              (key === "Homepage" || key === "Anasayfa")
                ? `<a target='_blank' href='${value}'>${value}</a>`
                : value
            }</span>
          `;

          container.appendChild(itemDiv);
        }

        let main = document.getElementById("organizationCard");
        main.innerHTML = '<a class="close-button" onclick="closeCard()">×</a>';
        main.appendChild(container);
        main.classList.add("visible");
        let fltr = document.getElementById("listing_filters");
        fltr.classList.remove("visible");


      }
    };

    xhttp.open("GET", url + "?id=" + id + "&language=" + lang, true);
    xhttp.send();

    const found = markersList.find((element) => element.options.id == id);
    if (found) {
      found.openPopup();
      map.flyTo(new L.LatLng(found._latlng.lat, found._latlng.lng), 15);
    }
  }
}


function closeCard() {
  let main = document.getElementById("organizationCard");
  main.classList.remove("visible");
}

function filtersDown() {
  var x = document.getElementById("listing_filters");

  if (x.classList.contains("visible")) {
    x.classList.remove("visible");
    document.getElementById("organizationCard").classList.remove("push");
  } else {
    x.classList += "visible";
    document.getElementById("organizationCard").classList += "push";
  }
}

function panelAccordion(param) {
  let panels = document
    .getElementById("listing_filters")
    .querySelectorAll("div");

  for (let i = 0; i < panels.length; i++) {
    panels[i].classList.remove("active");
    panels[i].style.maxHeight = "0px";
  }
  let panel = param.nextElementSibling;
  panel.style.maxHeight = panel.scrollHeight + "px";
  param.classList.toggle("active");
}

/*----------------------------------------------*/
var removeMarkers = function () {
  map.eachLayer(function (layer) {
    if (layer.myTag && layer.myTag === "datalayer") {
      map.removeLayer(layer);
    }
  });
  var element = document.getElementById("list");
  element.innerHTML = "";
};

//// calling function
const selectElement = Array.from(
  document.getElementsByClassName("filterProperties")
);

var filterTheMap = function (event) {
  removeMarkers();

  if (event.target.name.charAt(0) == "0") {
    let lettItems = document.getElementsByClassName("lett");
    for (let i = 0; i < lettItems.length; i++) lettItems[i].checked = false;
    document.getElementsByName(
      "0" + event.target.name.charAt(1)
    )[0].checked = true;
    //.checked = true;
  }

  showMapData(event.target.name);
};

for (var i = 0; i < selectElement.length; i++) {
  selectElement[i].addEventListener("change", filterTheMap);
}
