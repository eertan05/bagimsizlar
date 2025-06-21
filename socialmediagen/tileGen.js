let letters;
let typeWidth = 20;
let typeHeight = 10;
let p = [
  [0][0],
  [-1, -6], // 1
  [0, -6],  // 2
  [1, -6],  // 3
  [-1, -5], // 4
  [0, -5],  // 5
  [1, -5],  // 6
  [-1, -4], // 7
  [0, -4],  // 8
  [1, -4],  // 9
  [-1, -3], // 10
  [0, -3],  // 11
  [1, -3],  // 12
  [-1, -2], // 13
  [0, -2],  // 14
  [1, -2],  // 15
  [-1, -1], // 16
  [0, -1],  // 17
  [1, -1],  // 18
  [-1, 0],  // 19
  [0, 0],   // 20
  [1, 0]    // 21
];
let setColor="#00CF7B";
let colors ={
  networknode: "#00CF7B",
  workshop: "#684385",
  panel: "#EB8801",
  performance: "#B5BF00",
  exhibition: "#FF1B85"
}
let o = {
  gridOn: false,
  bg: "#2F5B83",
  fc: "#00CF7B",
  tc: "#FF1B85",
  s1: ["post", 207, 450, 620, 200, 0, "#000"],
  s2: ["digitaL", 235, 700, 600, 250, -2, "#000"],
  s3: ["IGNoRANcE", 880, 700, 950, 750, 0, "#000"]
}
let letterspacing = 0;
let citylist = ["BEIRUT", "IZMIR", "ISTANBUL", "CAIRO", "CASABLANCA", "BAALBEK", "TEHRAN", "TUNIS", "BISHKEK", "SHIRAZ", "KHARTOUM", "ATHENS"];

function typing(s, g, x, y, w, h, it, c) {
  var group = g.group();
  h/=6;

  for (let i = 0; i < s.length; i++) {
    let findL=s[i].indexOf("l");
    if(findL!=-1) {
    let sts = s[i].split("l");

    group.line(
      x + p[sts[0]][0] * w - it * p[sts[0]][1] / 7 * w,
      y + p[sts[0]][1] * h,
      x + p[sts[1]][0] * w - it * p[sts[1]][1] / 7 * w,
      y + p[sts[1]][1] * h
    );
  } else {
    group.line(
      x + p[s[i]][0] * w - it * p[s[i]][1] / 7 * w,
      y + p[s[i]][1] * h,
      x + p[s[i]][0] * w - it * p[s[i]][1] / 7 * w,
      y + p[s[i]][1] * h
    );
  }
}

  if (o["gridOn"]) {
    var groupG = g.group();
    for (let k = -6; k < 1; k++)
      for (let j = -1; j < 2; j++) {
        groupG.circle(1).cx(x + j * typeWidth).cy(y + k * typeHeight);
      }
  }
}

function sentencing(g, st, it, c) {
  let string = st.split("/")
      m=10,
      r=string.length,
      w=g.offsetWidth,
      h=g.offsetHeight,
      draw= SVG().attr("id", "svgCanvas").addTo(g).viewbox(0,0,w, h).group().stroke({linecap: "round"}).fill('none');

      let rr= draw.rect(w-20, h-20).cx(w/2).cy(h/2);
      w-=40;
      h-=40;

  for (let i = 0; i < string.length; i++) {
    m=h/25;
  let container = draw.group(),
      tW = w/ string[i].length,
      lh = (h/string.length)-m,/*(h-(r*7)) / (7 * r),*/
      lw = tW / 3,
      x = tW*.5+20,
      y = 20+(h-m*.5)-((lh+m)*(string.length-1-i)) /*-m*2.5*/
      ;

    wording(container, string[i], x,y,tW,h,lw,lh,tW + letterspacing,0, c);
  }
}

function wording(g,st,x,y,w,h,lw,lh,ls,it,c) {
  for (let i = 0; i < st.length; i++) {
    if(st[i]!=" "){
      //console.log(st[i]);
      typing(letters[st[i]], g, x + i * ls, y, lw, lh, it, c);
      }
  }
}

function generate(o, g) {
  let group = g.group().stroke({
    color: "#000000",
    width: 5,
    linecap: "round"
  }).fill('none');

  postWording(group, o[0], o[1], o[2], o[3], o[4], o[5], o[6]);
}

function postWording(g, st, x, y, w, h, it, c) {
  let group = g.group();

  let tW = w / st.length,
    lh = h / 7,
    lw = tW / 3;
  for (let i = 0; i < st.length; i++) {
    typing(letters[st[i]], group, x + i * tW + letterspacing, y, lw, lh, it, c);
  }
}

function textBlock(container) {
  let tex = container.text(function(add) {
    add.tspan('POST DIGITAL IGNORANCE')
    add.tspan("a'21 AmberNetworkFestival").newLine()
    add.tspan('Art Technology and Thought').newLine()
    add.tspan('amberplatform.org/a21').newLine().fill(o["fc"])
  }).x(75).y(880).fill(o["bg"]);

  tex.font({
    family: 'Barlow Semi Condensed',
    size: 20,
    leading: '1.28em',

    style: 'italic'
  })
}

function dots(container) {
  let group = container.group().attr("id", "dots");
  group.path(arc(400, 250, 250, 0, 270)).fill(o["tc"]);
  group.line(400, 0, 0, 400).stroke({
    color: o["tc"],
    width: 5,
    linecap: "round"
  }).fill('none');
  group.path(arc(900, 520, 250, 180, 450)).fill(o["tc"]);
  group.line(900, 770, 1250, 420).stroke({
    color: o["tc"],
    width: 5,
    linecap: "round"
  }).fill('none');
  group.path(arc(1600, 250, 250, 225, 495)).fill(o["tc"]);
  group.line(1600, 450, 1600, 500).stroke({
    color: o["tc"],
    width: 5,
    linecap: "round"
  }).fill('none');
  group.line(1470, 500, 1730, 500).stroke({
    color: o["tc"],
    width: 5,
    linecap: "round"
  }).fill('none');
}

function cities(container) {
  let testo = container.group();
  let n=0;
  for(let i=0;i<7;i++)
    for(let j=0;j<3;j++) {
      let ax=100+250*i;
      let ay=180+250*j;
      testo.circle(10).cx(ax).cy(ay).fill(o["tc"]);
      ay-=5;
      if(i%2==0) {
        let tex = testo.text(citylist[n]).x(ax).y(ay).fill("#fff");
        n++;

      tex.font({
        family: 'Barlow',
        size: 20,
        leading: '1em',
        anchor:   'middle',
        weight: 'bold'
      }).attr("letter-spacing","4").rotate(-45);
    }
    if((i==3)&&(j==1)) {
      let tex = testo.text("BERLIN").x(ax).y(ay).fill("#fff");

    tex.font({
      family: 'Barlow',
      size: 20,
      leading: '1em',
      anchor:   'middle',
      weight: 'bold'
    }).attr("letter-spacing","4").rotate(-45);
  }
    }

}

function posterGen(container){
  dots(container);
  let pol = container.polygon('110,250 500,250 700,105 800,40 1800,40 1800,720 180,720 110,450').fill(o["fc"]).attr("id", "frame");
  textBlock(container);
  let g = container.group();
  g.rect(1850, 770).fill("#fff");
  generate(o["s1"], g);
  generate(o["s2"], g);
  generate(o["s3"], g);
  var mask = container.mask().add(g);
  pol.maskWith(mask);
  //cities(container);
}

function polarToCartesian(centerX, centerY, radius, angleInDegrees) {
  var angleInRadians = (angleInDegrees - 90) * Math.PI / 180.0;

  return {
    x: centerX + (radius * Math.cos(angleInRadians)),
    y: centerY + (radius * Math.sin(angleInRadians))
  };
}

function arc(x, y, radius, startAngle, endAngle) {

  var start = polarToCartesian(x, y, radius, endAngle);
  var end = polarToCartesian(x, y, radius, startAngle);

  var largeArcFlag = endAngle - startAngle <= 180 ? "0" : "1";

  var d = [
    "M", start.x, start.y,
    "A", radius, radius, 0, largeArcFlag, 0, end.x, end.y
  ].join(" ");

  return d;
}

let canvasWidth=500,
canvasHeight=500;
var text = document.getElementById("text");
var slider = document.getElementById("width");
var output = document.getElementById("widthLabel");
output.innerHTML = slider.value; // Display the default slider value
var slider2 = document.getElementById("height");
var output2 = document.getElementById("heightLabel");

var slider3 = document.getElementById("strokeWidth");
var output3 = document.getElementById("strokeWidthLabel");
fetch(home_url+"/user/themes/a21/js/letters.json")
  .then(response => {
    return response.json();
  })
  .then(data => {
    letters = data['default'][0];
    regenerate();
  });

// Update the current slider value (each time you drag the slider handle)
slider.oninput = function() {
  output.innerHTML = this.value;
  canvasWidth = this.value;
  regenerate();
}

slider2.oninput = function() {
  output2.innerHTML = this.value;
  canvasHeight = this.value;
  regenerate();
}
let strokeWidth=3;
slider3.oninput = function() {
  output3.innerHTML = this.value;
  strokeWidth = this.value;
  regenerate();
}

text.oninput = function() {
  textString = this.value;
  regenerate();
}
let textString="POST";
let strokeColor="#ffffff";
document.forms.colo.colors.forEach(radio => {
  radio.addEventListener('change', () => {
    strokeColor=document.forms.colo.colors.value;
    regenerate();
    //alert(`${document.forms.colo.colors.value}`);
  })
});

function regenerate(){
  if(document.getElementById('canvas')!=null) document.getElementById('canvas').remove();
  var draw = document.createElement("div");
  draw.id="canvas";

  draw.style.width=canvasWidth+"px";
  draw.style.height=canvasHeight+"px";
  let tE=document.getElementById('textEditor');
  tE.appendChild(draw);
  sentencing(draw, textString, 0, setColor); //"#00CF7B"

  let svgCanvas=document.getElementById('svgCanvas');
  svgCanvas.setAttribute("style", "stroke:"+strokeColor+"; stroke-width:"+strokeWidth+"px");
  svgCanvas.style.background="#000000";
}

function setSize(x,y){
  slider.value=x;
  slider2.value=y;

  canvasWidth = x;
  canvasHeight = y;

  output.innerHTML = x;
  output2.innerHTML = y;

  regenerate();
}

function savePNG(){
  saveSvgAsPng(document.getElementById("svgCanvas"), "a21_"+textString+".png");
}
function saveS(){
  saveSvg(document.getElementById("svgCanvas"), "a21_"+textString+".svg");
}


/*---------------------------------------------------------------------*/
let rawSvg = '<?xml version="1.0" encoding="UTF-8" standalone="no"?><!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd"><svg width="100%" height="100%" viewBox="0 0 1080 1080" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;"><g><g id="logo"><path d="M109.474,964.758c0,-0.423 0.45,-0.772 1.007,-0.772c0.56,-0 1.008,0.349 1.008,0.772l0,73.088c0,0.426 -0.448,0.773 -1.008,0.773c-0.551,0 -1.007,-0.347 -1.007,-0.773l0,-73.088Z" style="fill-rule:nonzero;"/><path d="M125.147,989.819c-1.745,-0 -3.165,1.32 -3.165,2.942l-0,13.041c-0,1.617 1.416,2.931 3.157,2.931c1.728,0 3.135,-1.314 3.135,-2.931l-0,-13.04c-0,-1.623 -1.404,-2.943 -3.127,-2.943" style="fill-rule:nonzero;"/><path d="M176.129,1000.22l-33.983,-0c-1.845,-0 -3.343,-1.498 -3.343,-3.343c-0,-1.845 1.498,-3.343 3.343,-3.343l37.325,0c1.846,0 3.343,1.497 3.343,3.343l-0,17.372c-0,1.846 -1.497,3.342 -3.343,3.342l-34.099,0l0,14.955l33.988,0c1.845,0 3.343,1.498 3.343,3.343c-0,1.845 -1.498,3.342 -3.343,3.342l-37.328,0c-0.888,0.001 -1.739,-0.351 -2.366,-0.977c-0.627,-0.627 -0.979,-1.477 -0.979,-2.364l0,-21.641c0,-1.847 1.496,-3.343 3.343,-3.343l34.099,0l-0,-10.686Z" style="fill-rule:nonzero;"/><path d="M213.993,1008.44l-6.17,9.73c-0.988,1.558 -3.055,2.021 -4.613,1.033c-1.558,-0.988 -2.021,-3.055 -1.033,-4.613l12.368,-19.506c0.798,-1.257 2.331,-1.836 3.76,-1.419c1.429,0.418 2.41,1.73 2.406,3.219l-0.111,39.012c-0.005,1.845 -1.507,3.338 -3.353,3.332c-1.844,-0.004 -3.338,-1.507 -3.332,-3.351l0.078,-27.437Z" style="fill-rule:nonzero;"/><path d="M81.512,1050.14c0.356,0 0.647,-0.297 0.647,-0.658c-0,-0.363 -0.291,-0.659 -0.647,-0.659l-6.456,0c-0.385,0 -0.647,0.359 -0.647,0.648l0,6.455c0,0.386 0.351,0.648 0.647,0.648l6.456,0c0.356,0 0.647,-0.295 0.647,-0.657c-0,-0.367 -0.291,-0.661 -0.647,-0.661l-5.786,0l0,-1.903l5.786,0c0.356,0 0.647,-0.293 0.647,-0.655c-0,-0.365 -0.291,-0.658 -0.647,-0.658l-5.786,0l0,-1.9l5.786,0Z" style="fill-rule:nonzero;"/><path d="M94.931,1052.95l5.117,0l-0,2.975c-0,0.357 0.294,0.652 0.659,0.652c0.359,0 0.657,-0.295 0.657,-0.652l0,-6.453c0,-0.357 -0.298,-0.647 -0.657,-0.647c-0.365,0 -0.659,0.29 -0.659,0.647l-0,2.159l-5.117,-0l-0,-2.159c-0,-0.357 -0.296,-0.647 -0.66,-0.647c-0.362,0 -0.657,0.29 -0.657,0.647l-0,6.453c-0,0.357 0.295,0.652 0.657,0.652c0.364,0 0.66,-0.295 0.66,-0.652l-0,-2.975Z" style="fill-rule:nonzero;"/><path d="M84.586,1048.83c-0.316,-0 -0.573,0.256 -0.573,0.573l0,6.6c0,0.317 0.257,0.573 0.573,0.573l6.53,0c0.356,0 0.647,-0.295 0.647,-0.659c-0,-0.363 -0.291,-0.656 -0.647,-0.656l-5.786,-0l0,-5.116l5.786,-0c0.356,-0 0.647,-0.296 0.647,-0.661c-0,-0.366 -0.283,-0.654 -0.647,-0.654l-6.53,-0Z" style="fill-rule:nonzero;"/><path d="M119.257,1055.26l-5.119,-0l-0,-5.118l5.119,0l-0,5.118Zm-5.863,-6.431c-0.317,-0 -0.573,0.256 -0.573,0.573l-0,6.6c-0,0.317 0.256,0.573 0.573,0.573l6.604,0c0.317,0 0.573,-0.256 0.573,-0.573l0,-6.6c0,-0.317 -0.256,-0.573 -0.573,-0.573l-6.604,-0Z" style="fill-rule:nonzero;"/><path d="M138.466,1055.26l-5.119,-0l-0,-5.118l5.119,0l-0,5.118Zm-5.863,-6.431c-0.317,-0 -0.573,0.256 -0.573,0.573l-0,6.6c-0,0.317 0.256,0.573 0.573,0.573l6.605,0c0.316,0 0.573,-0.256 0.573,-0.573l-0,-6.6c-0,-0.317 -0.257,-0.573 -0.573,-0.573l-6.605,-0Z" style="fill-rule:nonzero;"/><path d="M151.877,1055.26c-0.357,-0 -0.65,0.292 -0.65,0.655c0,0.365 0.293,0.66 0.65,0.66l6.529,0c0.152,0 0.299,-0.06 0.405,-0.168c0.108,-0.107 0.169,-0.253 0.169,-0.405l-0,-6.531c-0,-0.356 -0.295,-0.647 -0.657,-0.647c-0.362,0 -0.66,0.291 -0.66,0.647l-0,2.979l-5.116,-0l-0,-2.979c-0,-0.356 -0.296,-0.647 -0.659,-0.647c-0.361,0 -0.661,0.291 -0.661,0.647l0,3.721c0,0.316 0.257,0.574 0.574,0.574l5.862,-0l-0,1.494l-5.786,-0Z" style="fill-rule:nonzero;"/><path d="M142.197,1048.82c-0.317,0 -0.573,0.257 -0.573,0.574l-0,6.605c-0,0.317 0.256,0.573 0.573,0.573l6.609,0c0.316,0 0.573,-0.256 0.573,-0.573l0,-3.796c0,-0.151 -0.06,-0.298 -0.168,-0.404c-0.108,-0.108 -0.253,-0.169 -0.405,-0.169l-3.005,0c-0.357,0 -0.646,0.294 -0.646,0.656c0,0.364 0.289,0.661 0.646,0.661l2.261,0l0,2.306l-5.118,0l-0,-5.118l5.785,0c0.357,0 0.65,-0.294 0.65,-0.656c0,-0.363 -0.293,-0.659 -0.65,-0.659l-6.532,0Z" style="fill-rule:nonzero;"/><path d="M65.455,1048.83c-0.356,-0 -0.647,0.296 -0.647,0.656c0,0.366 0.291,0.662 0.647,0.662l2.57,-0l-0,5.784c-0,0.355 0.298,0.644 0.659,0.644c0.362,0 0.658,-0.289 0.658,-0.644l-0,-5.784l2.569,-0c0.358,-0 0.647,-0.296 0.647,-0.662c-0,-0.36 -0.289,-0.656 -0.647,-0.656l-6.456,-0Z" style="fill-rule:nonzero;"/><path d="M123.079,1048.83c-0.359,-0 -0.657,0.288 -0.657,0.642l-0,6.531c-0,0.317 0.256,0.573 0.573,0.573l6.533,0c0.354,0 0.649,-0.297 0.649,-0.659c-0,-0.363 -0.295,-0.656 -0.649,-0.656l-5.789,-0l-0,-5.789c-0,-0.354 -0.296,-0.642 -0.66,-0.642" style="fill-rule:nonzero;"/><path d="M103.854,1048.82c-0.347,0.001 -0.639,0.295 -0.639,0.65l0,6.456c0,0.358 0.292,0.648 0.657,0.648c0.364,0 0.66,-0.29 0.66,-0.648l0,-4.856l5.306,5.308c0.238,0.233 0.558,0.214 0.717,0.147c0.251,-0.1 0.412,-0.336 0.412,-0.599l0,-6.456c0,-0.355 -0.294,-0.649 -0.657,-0.649c-0.361,0 -0.66,0.294 -0.66,0.649l0,4.856l-5.306,-5.305c-0.215,-0.215 -0.49,-0.201 -0.49,-0.201Z" style="fill-rule:nonzero;"/><path d="M32.572,1055.26l-5.119,-0l-0,-2.305l5.119,-0l0,2.305Zm-5.862,-3.62c-0.316,-0 -0.573,0.256 -0.573,0.573l0,3.795c0,0.152 0.061,0.297 0.168,0.405c0.108,0.108 0.253,0.168 0.405,0.168l6.606,0c0.152,0 0.298,-0.06 0.405,-0.168c0.108,-0.108 0.168,-0.253 0.168,-0.405l0,-6.608c0,-0.316 -0.256,-0.573 -0.573,-0.573l-6.532,-0c-0.355,-0 -0.647,0.296 -0.647,0.658c0,0.365 0.292,0.664 0.647,0.664l5.788,0l0,1.491l-5.862,-0Z" style="fill-rule:nonzero;"/><path d="M45.604,1049.48l-0,6.533c-0,0.153 0.06,0.298 0.167,0.406c0.108,0.108 0.254,0.167 0.406,0.167l6.529,0c0.359,0 0.647,-0.294 0.647,-0.658c0,-0.365 -0.288,-0.662 -0.647,-0.662l-5.785,-0l-0,-2.306l5.785,-0c0.359,-0 0.647,-0.294 0.647,-0.657c0,-0.364 -0.288,-0.657 -0.647,-0.657l-5.785,0l-0,-2.166c-0,-0.353 -0.296,-0.647 -0.658,-0.647c-0.368,-0 -0.659,0.294 -0.659,0.647Z" style="fill-rule:nonzero;"/><path d="M42.405,1051.64l-5.311,-0l-0,-1.491l5.311,0l0,1.491Zm-6.058,-2.813c-0.152,-0 -0.298,0.06 -0.405,0.168c-0.107,0.108 -0.168,0.253 -0.168,0.405l0,6.529c0,0.359 0.297,0.652 0.663,0.652c0.361,0 0.657,-0.293 0.657,-0.652l-0,-2.974l1.875,-0l3.441,3.434c0.241,0.248 0.675,0.244 0.922,-0.006c0.256,-0.253 0.261,-0.67 0.008,-0.925l-2.502,-2.503l2.311,-0c0.316,-0 0.573,-0.257 0.573,-0.573l0,-2.982c0,-0.152 -0.06,-0.297 -0.168,-0.405c-0.107,-0.108 -0.253,-0.168 -0.405,-0.168l-6.802,-0Z" style="fill-rule:nonzero;"/><path d="M181.353,1052.95l5.117,0l-0,2.975c-0,0.357 0.294,0.652 0.659,0.652c0.359,0 0.658,-0.295 0.658,-0.652l-0,-6.453c-0,-0.357 -0.299,-0.647 -0.658,-0.647c-0.365,0 -0.659,0.29 -0.659,0.647l-0,2.159l-5.117,-0l-0,-2.159c-0,-0.357 -0.296,-0.647 -0.66,-0.647c-0.361,0 -0.657,0.29 -0.657,0.647l-0,6.453c-0,0.357 0.296,0.652 0.657,0.652c0.364,0 0.66,-0.295 0.66,-0.652l-0,-2.975Z" style="fill-rule:nonzero;"/><path d="M219.76,1052.95l5.117,0l0,2.975c0,0.357 0.294,0.652 0.66,0.652c0.359,0 0.657,-0.295 0.657,-0.652l0,-6.453c0,-0.357 -0.298,-0.647 -0.657,-0.647c-0.366,0 -0.66,0.29 -0.66,0.647l0,2.159l-5.117,-0l0,-2.159c0,-0.357 -0.296,-0.647 -0.66,-0.647c-0.361,0 -0.657,0.29 -0.657,0.647l0,6.453c0,0.357 0.296,0.652 0.657,0.652c0.364,0 0.66,-0.295 0.66,-0.652l0,-2.975Z" style="fill-rule:nonzero;"/><path d="M196.077,1055.26l-5.119,-0l-0,-5.118l5.119,0l-0,5.118Zm-5.863,-6.431c-0.317,-0 -0.573,0.256 -0.573,0.573l-0,6.6c-0,0.317 0.256,0.573 0.573,0.573l6.605,0c0.316,0 0.573,-0.256 0.573,-0.573l-0,-6.6c-0,-0.317 -0.257,-0.573 -0.573,-0.573l-6.605,-0Z" style="fill-rule:nonzero;"/><path d="M209.415,1048.83c-0.317,-0 -0.573,0.256 -0.573,0.573l-0,6.606c-0,0.317 0.256,0.573 0.573,0.573l6.609,-0c0.316,-0 0.573,-0.256 0.573,-0.573l0,-3.796c0,-0.152 -0.06,-0.298 -0.168,-0.405c-0.108,-0.108 -0.253,-0.168 -0.405,-0.168l-3.005,-0c-0.357,-0 -0.646,0.294 -0.646,0.656c0,0.364 0.289,0.661 0.646,0.661l2.261,-0l0,2.306l-5.118,-0l0,-5.118l5.785,-0c0.358,-0 0.65,-0.294 0.65,-0.656c0,-0.363 -0.292,-0.659 -0.65,-0.659l-6.532,-0Z" style="fill-rule:nonzero;"/><path d="M199.246,1056.01c-0,0.317 0.256,0.573 0.573,0.573l6.606,0c0.151,0 0.298,-0.06 0.404,-0.168c0.108,-0.107 0.169,-0.253 0.169,-0.405l-0,-6.61c-0,-0.153 -0.061,-0.298 -0.169,-0.406c-0.107,-0.108 -0.255,-0.169 -0.407,-0.167c-0.057,-0 -0.115,-0 -0.173,0.001c-0.315,0.001 -0.57,0.257 -0.57,0.572l-0,5.863l-5.119,-0l0,-5.785c0,-0.358 -0.293,-0.65 -0.655,-0.65c-0.363,-0 -0.659,0.292 -0.659,0.65l-0,6.532Z" style="fill-rule:nonzero;"/><path d="M171.082,1048.83c-0.356,-0 -0.647,0.296 -0.647,0.656c0,0.366 0.291,0.662 0.647,0.662l2.569,-0l0,5.784c0,0.355 0.299,0.644 0.66,0.644c0.362,0 0.657,-0.289 0.657,-0.644l0,-5.784l2.57,-0c0.358,-0 0.647,-0.296 0.647,-0.662c0,-0.36 -0.289,-0.656 -0.647,-0.656l-6.456,-0Z" style="fill-rule:nonzero;"/><path d="M228.694,1048.83c-0.356,-0 -0.647,0.296 -0.647,0.656c0,0.366 0.291,0.662 0.647,0.662l2.57,-0l0,5.784c0,0.355 0.298,0.644 0.659,0.644c0.362,0 0.658,-0.289 0.658,-0.644l0,-5.784l2.569,-0c0.358,-0 0.647,-0.296 0.647,-0.662c0,-0.36 -0.289,-0.656 -0.647,-0.656l-6.456,-0Z" style="fill-rule:nonzero;"/><path d="M196.856,979.709c-0.127,0.002 -0.251,-0.05 -0.342,-0.142c-0.091,-0.09 -0.142,-0.213 -0.142,-0.342l0,-4.748c0,-0.268 0.218,-0.486 0.484,-0.486l19.924,0c0.268,0 0.485,0.218 0.485,0.486l0,6.743c0,0.834 0.677,1.51 1.51,1.51c0.833,0 1.51,-0.676 1.51,-1.51l0,-6.743c0,-0.268 0.218,-0.486 0.486,-0.486l4.18,0c0.13,0 0.252,0.052 0.343,0.143c1.095,1.095 8.155,8.154 8.155,8.154c0.588,0.59 1.546,0.59 2.135,-0c0.59,-0.59 0.59,-1.547 0,-2.135c0,-0 -3.653,-3.653 -5.333,-5.333c-0.138,-0.139 -0.18,-0.347 -0.104,-0.528c0.075,-0.181 0.251,-0.301 0.448,-0.301l3.921,0c0.834,0 1.51,-0.675 1.51,-1.509l0,-6.741c0,-0.834 -0.676,-1.511 -1.51,-1.511l-15.741,0c-0.834,0 -1.51,0.677 -1.51,1.511l0,4.745c0,0.268 -0.217,0.486 -0.485,0.486l-19.924,-0c-0.127,-0 -0.251,-0.051 -0.342,-0.142c-0.091,-0.091 -0.142,-0.215 -0.142,-0.344l0,-2.75c0,-0.129 0.051,-0.251 0.142,-0.343c0.091,-0.091 0.215,-0.142 0.342,-0.142l13.519,0c0.834,0 1.511,-0.676 1.511,-1.51c-0,-0.834 -0.677,-1.511 -1.511,-1.511l-15.513,0c-0.834,0 -1.511,0.677 -1.511,1.511l0,13.484c0,0.268 -0.216,0.484 -0.484,0.484l-4.229,0c-0.266,0 -0.484,-0.216 -0.484,-0.484l0,-6.743c0,-0.834 -0.677,-1.51 -1.51,-1.51l-13.455,-0c-0.268,-0 -0.486,-0.218 -0.486,-0.486l0,-4.745c0,-0.834 -0.676,-1.511 -1.509,-1.511c-0.834,0 -1.51,0.677 -1.51,1.511l-0,4.745c-0,0.268 -0.218,0.486 -0.486,0.486l-4.377,-0c-0.268,-0 -0.486,-0.218 -0.486,-0.486l0,-4.745c0,-0.611 -0.366,-1.161 -0.929,-1.394c-0.565,-0.235 -1.213,-0.107 -1.645,0.323c-0,-0 -5.008,4.978 -6.375,6.338c-0.19,0.188 -0.496,0.188 -0.685,0c-1.368,-1.36 -6.375,-6.338 -6.375,-6.338c-0.433,-0.43 -1.081,-0.558 -1.645,-0.323c-0.563,0.233 -0.93,0.783 -0.93,1.394l0,13.484c0,0.129 -0.052,0.252 -0.142,0.342c-0.091,0.092 -0.214,0.142 -0.344,0.142l-4.263,0c-0.129,0 -0.253,-0.05 -0.343,-0.142c-0.091,-0.09 -0.143,-0.213 -0.143,-0.342l0,-13.484c0,-0.834 -0.675,-1.511 -1.509,-1.511l-15.515,0c-0.834,0 -1.511,0.677 -1.511,1.511c0,0.834 0.677,1.51 1.511,1.51l13.519,0c0.129,0 0.253,0.051 0.344,0.142c0.09,0.092 0.142,0.214 0.142,0.343l-0,2.75c-0,0.129 -0.052,0.253 -0.142,0.344c-0.091,0.091 -0.215,0.142 -0.344,0.142l-13.519,-0c-0.834,-0 -1.511,0.676 -1.511,1.51l0,8.738c0,0.834 0.677,1.51 1.511,1.51l23.768,0c0.836,0 1.511,-0.676 1.511,-1.51l-0,-10.682c-0,-0.197 0.118,-0.374 0.299,-0.448c0.181,-0.076 0.389,-0.035 0.528,0.104c1.47,1.46 4.381,4.355 4.381,4.355c0.588,0.585 1.54,0.585 2.128,-0c0,-0 2.912,-2.895 4.382,-4.355c0.139,-0.139 0.346,-0.18 0.528,-0.104c0.181,0.074 0.299,0.251 0.299,0.448l-0,10.682c-0,0.834 0.676,1.51 1.509,1.51c0.834,0 1.51,-0.676 1.51,-1.51l0,-6.743c0,-0.268 0.218,-0.486 0.486,-0.486l4.377,0c0.268,0 0.486,0.218 0.486,0.486l-0,6.743c-0,0.834 0.676,1.51 1.51,1.51l39.181,0c0.834,0 1.511,-0.676 1.511,-1.51c-0,-0.833 -0.677,-1.511 -1.511,-1.511l-13.519,0Zm-12.207,0c0.268,0 0.484,-0.216 0.484,-0.484l0,-4.748c0,-0.268 -0.216,-0.486 -0.484,-0.486l-11.46,0c-0.268,0 -0.486,0.218 -0.486,0.486l0,4.748c0,0.268 0.218,0.484 0.486,0.484l11.46,0Zm-47.152,-5.232c-0,-0.268 -0.218,-0.486 -0.486,-0.486l-11.524,0c-0.268,0 -0.486,0.218 -0.486,0.486l0,4.748c0,0.129 0.052,0.252 0.143,0.342c0.09,0.092 0.214,0.142 0.343,0.142l11.524,0c0.268,0 0.486,-0.216 0.486,-0.484l-0,-4.748Zm82.788,-3.991c0,0.268 0.218,0.486 0.486,0.486l11.75,-0c0.268,-0 0.484,-0.218 0.484,-0.486l0,-2.75c0,-0.268 -0.216,-0.485 -0.484,-0.485l-11.75,0c-0.268,0 -0.486,0.217 -0.486,0.485l0,2.75Z"/><path d="M85.293,989.922l-51.6,-0c-4.208,-0 -7.619,3.411 -7.619,7.619l0,33.46c0,4.207 3.411,7.618 7.619,7.618l59.219,0c4.208,0 7.619,-3.411 7.619,-7.618l0,-59.152c0,-4.208 -3.411,-7.619 -7.619,-7.619l-59.245,0c-4.204,0 -7.618,3.414 -7.618,7.619c-0,4.205 3.414,7.619 7.618,7.619l51.626,0l0,10.454Zm0,15.238l-43.981,-0l-0,18.222l43.981,-0l0,-18.222Z"/></g><g id="pdi"><path d="M87.645,195.747c0,80.064 65.883,145.946 145.946,145.946c80.064,-0 145.946,-65.882 145.946,-145.946c0,-80.064 -65.882,-145.946 -145.946,-145.946" style="fill:#ff1b85;fill-rule:nonzero;"/><path d="M233.591,49.801l-233.513,233.514" style="fill:none;fill-rule:nonzero;stroke:#ff1b85;stroke-width:2.92px;"/><path d="M671.429,353.369c0,-80.064 -65.882,-145.946 -145.946,-145.946c-80.063,-0 -145.946,65.882 -145.946,145.946c0,80.063 65.883,145.946 145.946,145.946" style="fill:#ff1b85;fill-rule:nonzero;"/><path d="M525.483,499.315l204.325,-204.325" style="fill:none;fill-rule:nonzero;stroke:#ff1b85;stroke-width:2.92px;"/><path d="M1037.33,298.946c27.36,-27.359 42.747,-64.507 42.747,-103.199c-0,-80.064 -65.883,-145.946 -145.946,-145.946c-80.064,0 -145.946,65.882 -145.946,145.946c-0,38.692 15.387,75.84 42.747,103.199" style="fill:#ff1b85;fill-rule:nonzero;"/><path d="M934.132,312.504l-0,29.189" style="fill:none;fill-rule:nonzero;stroke:#ff1b85;stroke-width:2.92px;"/><path d="M858.24,341.693l151.784,-0" style="fill:none;fill-rule:nonzero;stroke:#ff1b85;stroke-width:2.92px;"/></g></g></svg>';

//var canvas = new fabric.Canvas('canvas');
let dataFileImage=" ";
document.getElementById('file').addEventListener("change", function (e) {
  let file = e.target.files[0];
  let reader = new FileReader();
  reader.onload = function (f) {
    dataFileImage = f.target.result;
    regenerateI();
  }
  reader.readAsDataURL(file);
  });

text2.oninput = function() {
  imageString = this.value;
  regenerateI();
}

let imageString="POST";
let intContrast=0;
let RcontrastAmount=1,
    GcontrastAmount=1,
    BcontrastAmount=1
    ;
var islider1 = document.getElementById("RimageContrast");
var ioutput1 = document.getElementById("RimageContrastLabel");
var islider2 = document.getElementById("GimageContrast");
var ioutput2 = document.getElementById("GimageContrastLabel");
var islider3 = document.getElementById("BimageContrast");
var ioutput3 = document.getElementById("BimageContrastLabel");
var islider4 = document.getElementById("IimageContrast");
var ioutput4 = document.getElementById("IimageContrastLabel");

islider1.oninput = function() {
  ioutput1.innerHTML = this.value;
  RcontrastAmount = this.value/10;
  regenerateI();
}
islider2.oninput = function() {
  ioutput2.innerHTML = this.value;
  GcontrastAmount = this.value/10;
  regenerateI();
}
islider3.oninput = function() {
  ioutput3.innerHTML = this.value;
  BcontrastAmount = this.value/10;
  regenerateI();
}
islider4.oninput = function() {
  ioutput4.innerHTML = this.value;
  intContrast = this.value/100;
  regenerateI();
}
function regenerateI(){
  if(document.getElementById('imageCanvas')!=null) document.getElementById('imageCanvas').remove();

  let imageDrawC = document.createElement("div");
  imageDrawC.id="imageCanvas";
  let imageDraw= SVG().attr("id", "svgImageCanvas").addTo(imageDrawC).viewbox(0,0,1080, 1080);

  let image = imageDraw.image(dataFileImage, function (event) {
    if(event.target.naturalWidth>event.target.naturalHeight) {
      image.size((event.target.naturalWidth/event.target.naturalHeight)*1080,1080);
    }
    else {
      image.size(1080,(event.target.naturalHeight/event.target.naturalWidth)*1080);
    }
  }).attr("id", "imageImage");
  image.draggable();

  let ellipse = imageDraw.ellipse(850, 850).move(115, 115).fill('#fff')
  let mask = imageDraw.mask().add(ellipse);
  image.maskWith(mask);
  var store = imageDraw.svg(rawSvg);

  let iE=document.getElementById('imageEditor');
  iE.appendChild(imageDrawC);
  let svgImageCanvas=document.getElementById('svgImageCanvas');

  //console.log(intContrast);
  let el=document.createElementNS("http://www.w3.org/2000/svg","filter");
  el.id="contrast";
  //let fr=document.createElementNS("http://www.w3.org/2000/svg","feComponentTransfer");

  el.innerHTML=`
  <feComponentTransfer>
                <feFuncR type="linear" slope="`+RcontrastAmount+`" intercept="`+intContrast+`"></feFuncR>
                <feFuncG type="linear" slope="`+GcontrastAmount+`" intercept="`+intContrast+`"></feFuncG>
                <feFuncB type="linear" slope="`+BcontrastAmount+`" intercept="`+intContrast+`"></feFuncB>
                </feComponentTransfer>
                `;
  //el.append(fr);
  svgImageCanvas.append(el);
  svgImageCanvas.style.background="#ffffff";

  let imageStrings=imageString.split("/");
  let tex = imageDraw.text("").x(535).y(1055-(imageStrings.length*60));
  tex.build(true) ;
  tex.font({family: 'Barlow', size: 50, anchor:   'left', leading:  '1.2em'})
  for(stringa of imageStrings) {
    tex.tspan(stringa).newLine();
  }

  document.getElementById("imageImage").setAttribute("filter", "url(#contrast)");
}

function saveiPNG(){
  saveSvgAsPng(document.getElementById("svgImageCanvas"), "a21_"+imageString+".png");
}
function saveiS(){
  saveSvg(document.getElementById("svgImageCanvas"), "a21_"+imageString+".svg");
}
