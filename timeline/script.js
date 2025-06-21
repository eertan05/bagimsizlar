//document.addEventListener('DOMContentLoaded', function() {
const canvas = document.getElementById('timeline-canvas');
const ctx = canvas.getContext('2d');

let cameraOffset = {
  x: window.innerWidth / 2,
  y: window.innerHeight / 2
}
let cameraZoom = 1
let MAX_ZOOM = 5
let MIN_ZOOM = 0.1
let SCROLL_SENSITIVITY = 0.0005

//let color = ['darkturquoise', 'darkviolet', 'fuchsia', 'brown', 'green', 'deeppink'];
let color = ["#00BFDD", "#770077", "#006168", "#bB8B00", "#21B56E", "#76BC43", "#CEB52C", "#FFCE02", "#FAA21B", "#F58320", "#F15E3E", "#A8353A", "#762157", "#231F20"];
let startYear = 2100;
let endYear = 1900;
let parsedData;
let theType = {};

// CONTENT >>>
function fetchAndParseCSV() {
  return new Promise((resolve, reject) => {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'csvfile.csv', true); // Use true for asynchronous request
    xhr.onload = function() {
      if (xhr.status === 200) {
        Papa.parse(xhr.responseText, {
          header: true,
          dynamicTyping: true,
          complete: function(result) {
            parsedData = result.data;
            resolve(parsedData);
          },
          error: function(error) {
            reject('CSV parsing error: ' + error.message);
          },
        });
      } else {
        reject('Error fetching CSV file: ' + xhr.statusText);
      }
    };
    xhr.send();
  });
}

// Call the fetchAndParseCSV function to initiate the process
fetchAndParseCSV()
  .then((parsedData) => {
    // Now you can access and work with parsedData here
    parsedData.pop();
    //console.log(parsedData);
    // Add your code to process the data here
    // Ready, set, go
    defineTypes();
    draw();
  })
  .catch((error) => {
    console.error(error);
  });

let i = 0;

function defineTypes() {
  parsedData.forEach(item => {
    let type = item.Type;
    if (!(type in theType)) {
      theType[type] = color[i];
      i++;
    }
  });
  //console.log(theType);
  document.getElementById("legend").innerHTML += "<span class='legend_title'> color code:  </span>";

  for (i in theType) {
    let text = "<span class='legend' style='color:" + theType[i] + ";'>" + i + "</span>"

    document.getElementById("legend").innerHTML += text + " ";

  }


}

function draw() {
  canvas.width = (window.innerWidth >= 2000) ? window.innerWidth - 50 : 2000;
  canvas.height = window.innerHeight - 50;

  // Translate to the canvas centre before zooming - so you'll always zoom on what you're looking directly at
  ctx.translate(window.innerWidth / 2, window.innerHeight / 2);
  ctx.scale(cameraZoom, cameraZoom);
  ctx.translate(-window.innerWidth / 2 + cameraOffset.x, -window.innerHeight / 2 + cameraOffset.y);
  ctx.clearRect(0, 0, window.innerWidth, window.innerHeight);

  const startX = -canvas.width / 2 +100;
  const endX = canvas.width / 2 - 50 - 100;
  const startY = -canvas.height / 2 + 200;
  const canvasWidth = endX - startX;
  const lineHeight = convertRemToPixels(1);
  let yearPixelsDif;
  let yearsTextPos = {};
  let line = '';
  let lineCnt = 0;



  // Draw ALL
  // Draw timeline line
  ctx.beginPath();
  ctx.moveTo(startX, startY);
  ctx.lineTo(endX, startY);
  ctx.strokeStyle = '#000';
  ctx.stroke();

  // Find start and end years
  parsedData.forEach(item => {
    //console.log("***" + item.Year + "***" + item.Event + "***" + item.Type);
    let year = parseInt(item.Year);
    if (year < startYear) startYear = year;
    if (year > endYear) endYear = year;
  });
  yearPixelsDif = canvasWidth / (endYear - startYear)

  // Define initial positions for years text
  parsedData.forEach(item => {
    const year = parseInt(item.Year);

    yearsTextPos.newKey = year;
    yearsTextPos[year] = [((year - startYear) * yearPixelsDif) + startX, startY + 2 * lineHeight];
    yearsTextPos[year][2] = 0; //in order not to rewrite over once written year
  });

  parsedData.forEach(item => {
    const year = parseInt(item.Year);
    const eventX = yearsTextPos[year][0];
    let eventY = yearsTextPos[year][1];

    if (yearsTextPos[year][2] == 0) {
      // Draw event line
      ctx.beginPath();
      ctx.moveTo(eventX, startY);
      ctx.lineTo(eventX, eventY + 5);
      ctx.fillStyle = '#007bff';
      ctx.fill();
      ctx.strokeStyle = '#999';
      ctx.stroke();

      // Display event year
      ctx.fillStyle = '#000';
      ctx.font = 'bold 0.8rem Arial';
      ctx.fillText(year, eventX, startY - 5);

      yearsTextPos[year][2] = 1;
    }

    // Display event description
    ctx.font = '0.8rem Arial Narrow';
    let type = item.Type;
    ctx.fillStyle = theType[type];

    eventY = eventY + lineHeight;
    let text = item.Event;
    text = text.toString();

    const words = text.split(' ');
    line = '';
    lineCnt = 0;


    for (const word of words) {
      const textLine = line + (line === '' ? '' : ' ') + word;
      const textWidth = ctx.measureText(textLine).width;

      if (textWidth > yearPixelsDif - 10) {
        ctx.fillText(line, eventX, eventY);
        eventY += lineHeight;
        line = word;
      } else {
        line = textLine;
      }
      lineCnt++;
    }
    ctx.fillText(line, eventX, eventY);

    // add event to list of year and next-pointer
    yearsTextPos.newKey = year;
    yearsTextPos[year] = [eventX, eventY + (lineHeight / 2)];
    lineCnt = 0;

  });
  // <<< CONTENT


  requestAnimationFrame(draw);

}


function convertRemToPixels(rem) {
  return rem * parseFloat(getComputedStyle(document.documentElement).fontSize);
}

// Gets the relevant location from a mouse or single touch event
function getEventLocation(e) {
  if (e.touches && e.touches.length == 1) {
    return {
      x: e.touches[0].clientX,
      y: e.touches[0].clientY
    }
  } else if (e.clientX && e.clientY) {
    return {
      x: e.clientX,
      y: e.clientY
    }
  }
}

function drawRect(x, y, width, height) {
  ctx.fillRect(x, y, width, height)
}

function drawText(text, x, y, size, font) {
  ctx.font = `${size}px ${font}`
  ctx.fillText(text, x, y)
}

let isDragging = false
let dragStart = {
  x: 0,
  y: 0
}

function onPointerDown(e) {
  isDragging = true
  dragStart.x = getEventLocation(e).x / cameraZoom - cameraOffset.x
  dragStart.y = getEventLocation(e).y / cameraZoom - cameraOffset.y
}

function onPointerUp(e) {
  isDragging = false
  initialPinchDistance = null
  lastZoom = cameraZoom
}

function onPointerMove(e) {
  if (isDragging) {
    cameraOffset.x = getEventLocation(e).x / cameraZoom - dragStart.x
    cameraOffset.y = getEventLocation(e).y / cameraZoom - dragStart.y
  }
}

function handleTouch(e, singleTouchHandler) {
  if (e.touches.length == 1) {
    singleTouchHandler(e)
  } else if (e.type == "touchmove" && e.touches.length == 2) {
    isDragging = false
    handlePinch(e)
  }
}

let initialPinchDistance = null;
let lastZoom = cameraZoom;

function handlePinch(e) {
  e.preventDefault();

  let touch1 = {
    x: e.touches[0].clientX,
    y: e.touches[0].clientY
  };
  let touch2 = {
    x: e.touches[1].clientX,
    y: e.touches[1].clientY
  };

  // This is distance squared, but no need for an expensive sqrt as it's only used in ratio
  let currentDistance = (touch1.x - touch2.x) ** 2 + (touch1.y - touch2.y) ** 2;

  if (initialPinchDistance == null) {
    initialPinchDistance = currentDistance;
  } else {
    adjustZoom(null, currentDistance / initialPinchDistance);
  }
}

function adjustZoom(zoomAmount, zoomFactor) {
  if (!isDragging) {
    if (zoomAmount) {
      cameraZoom += zoomAmount;
    } else if (zoomFactor) {
      cameraZoom = zoomFactor * lastZoom;
    }
    cameraZoom = Math.min(cameraZoom, MAX_ZOOM);
    cameraZoom = Math.max(cameraZoom, MIN_ZOOM);
  }
}

canvas.addEventListener('mousedown', onPointerDown);
canvas.addEventListener('touchstart', (e) => handleTouch(e, onPointerDown));
canvas.addEventListener('mouseup', onPointerUp);
canvas.addEventListener('touchend', (e) => handleTouch(e, onPointerUp));
canvas.addEventListener('mousemove', onPointerMove);
canvas.addEventListener('touchmove', (e) => handleTouch(e, onPointerMove));
canvas.addEventListener('wheel', (e) => adjustZoom(e.deltaY * SCROLL_SENSITIVITY));



//});
