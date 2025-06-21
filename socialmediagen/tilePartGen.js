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
    ).stroke(c);
  } else {
    group.line(
      x + p[s[i]][0] * w - it * p[s[i]][1] / 7 * w,
      y + p[s[i]][1] * h,
      x + p[s[i]][0] * w - it * p[s[i]][1] / 7 * w,
      y + p[s[i]][1] * h
    ).stroke(c);
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
      draw= SVG().addTo(g).viewbox(0,0,w, h).group().stroke({linecap: "round"}).fill('none');

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

let canvasWidth=window.innerWidth,
canvasHeight=window.innerHeight;

function reportWindowSize() {
  canvasHeight = window.innerHeight;
  canvasWidth = window.innerWidth;
}

window.onresize = reportWindowSize;

var textString="Post/Digital/Ignorance";
var allText=`Abbas/Shamas
Abdeslam/ZiouZiou
Abdessamad/Baddis
Abir/Guasmi
Afra Al/Dhaheri
Ahmad/Gharbeia
Ahmet/Kenan/Bilgiç
Alessandro/Bertelle
Ali Cem/Doğan
Ali/Kanal
Ali Kemal/Ertem
Ameen/Moazami
Amirali/Ghasemi
Amirali/Mohebbinejad
Anahita/Hekmat
Apeiron/Collective
Arash/Fayez
Arash/Hanaei
Arash/Khosronejad
Badr/Houary
Bager/Akbay
Bakry/Mohamed/Salih
Başak/Tosun
Betal/Özay
Can/Çetin
Cenkhan/Aksoy
Constance/Léon
Danielle/Brathwaite/Shirley
Darağaç/Collective
Deena/Abdelwahed
Ebru/Yetişkin
Ecehan/Toprak
  Eda/Sütunç
Elnaz/Salehi
Elodie/Lanard
Elsadig/Mohmmed/Ahmed
Emre/Can/Çetin
Emre/Yıldız
Erkan/Saka
    Eti    /Kastoryano
Falgoush
Farnoosh/Allahverdi/    Nik
Fatine/Arafati
Forough/Fami
Ghazel
Golnaz/Behrouznia
Güzden/Varinlioğlu
Hakan/Ergun
Hakan/Gündüz
Hamza/Chamas
Hande/Bozbıyık
Hanif/Haghtalab
Hannaneh/Heydari
Hasan/Morad
Hashel/Al Lamki
Hossam/Shukrallah
Ifebusola/Shoutende
İpek/İpekçioğlu
İpek/Yeğinsü
Jan/Gerber
Karim/Ghaleb
Kasraa/Paashaaie
Kawtar/Benlakhdar
Lamyaa/Achaary
Lara/Kamhi
Laura/Cugusi
LU/Records
Mahoor/Mirshakkak
Mahshid/Mahboubifar
Maitha/Abdalla
Mansour/Aziz
Martin/Shamoonpour
Marwan/Osman
Mary/Maggic
Maryam/Katan
Maysara/Abdulhag
Mehdi/Bahrami
Mehmet/Erkök
Milad/Forouzandeh
Mohamad/Shamas
Mohamed/Salah/Elmur
Mohsen/Hazrati
Mustafa/Elsiddeg
Mustafa/Gasemlbari
Nader/Shamas
Nadir/Bouhmouch
Nagehan/Uskan
Nassrin/Nasser
Nazanin/Aharipour
Neslihan/Turan
Nour/Yahya
Hamza/Yahya
Oğuz/Emre/Bal
Ouafa/Belgacem
Ozan/Atalan
Özge/Çelikaslan
Öznur/Karakaş
Pascal/Brunet
Pelin/Tan
Rachel/Uwa
Raheleh/Bahrami
Rajaa/Shaman
Ramin/Rahimi
Rana/Dehghan
Ranwa/Yehia
Rayan/Elhadi/Elsayed/Hima
Renata/Salecl
Rüzgar/Buşki
Sadegh/Majlesi
Salma/Kossemini
Sebastian/Lütgert
Selim/Harbi
Seloua/Luste/Boulbina
Shaahin/Peymani
Shaarbek/Amankul
Shaghayegh/Kamyar
Siavash/Naghshbandi
Simo/Mansouri
Soheila/Golestani
Stefanos/Levidis
Studio/51
Suat/İlyus
Tevfik/Uyar
Tom/Keogh
Vahid/Danaeifar
WAF
Yağmur/Yıldırım
Yara/Mekawei
Yas Nik/Khoshgrudi
Yasmin/Elayat
Yerivan/Hassan
Younes/El Hossaini
Youssef/El Idrisi
Zafer/Batık
Zeyo`;
fetch(home_url+"/user/themes/a21/js/letters.json")
  .then(response => {
    return response.json();
  })
  .then(data => {
    allLines = allText.split('\n');
    lines = allLines.length;
    letters = data['default'][0];
    regenerate();
  });

// Update the current slider value (each time you drag the slider handle)

let strokeWidth=5;

jQuery.get(home_url+"/user/themes/a21/js/part.txt", function(data) {
allText = data;
allLines = allText.split('\n');
lines = allLines.length;
});

function regenerate(){
  if(document.getElementById('canva')!=null) document.getElementById('canva').remove();
  var draw = document.createElement("div");
  draw.id="canva";
  draw.setAttribute("style", "stroke-width:"+strokeWidth+"px;");
  draw.style.width=canvasWidth+"px";
  draw.style.height=canvasHeight+"px";
  draw.style.background="#000000";//o["bg"];
  //draw.attribute("height",canvasWidth);
  //SVG().addTo('body').size(canvasWidth, canvasHeight).attr("style", "background-color:" + coreVariables["bg"]).attr("id", "canvas");
  //draw.size(canvasWidth,canvasHeight);
  //let g = draw.group();
  document.body.appendChild(draw);
  sentencing(draw, textString, 0, setColor); //"#00CF7B"



  //wording(g, textString, 0, canvasHeight, canvasWidth, canvasHeight, 0, "#000");
  //generate(opt[textString], g);
}
function getHue(i){
    return 1/0.2*(i) * 210;
}
let i =(1/0.2*(50) * 210);
var fadeEffect = setInterval(function () {
  var j = i+60;
  var k = i+120;
  var val = getHue(i);
  var col = 'hsla('+val+', 90%, 60%, 1)';

        //$("#colorPanel").css({"background-color": col});
  setColor=col;
  i = (i<180)? i+1 : 0;
  j = (j<180)? j+1 : 0;
  k = (k<180)? k+1 : 0;

  let fademe=document.getElementById('canva');
      if (!fademe.style.opacity) {
          fademe.style.opacity = 1;
      }
      if (fademe.style.opacity > 0) {
          fademe.style.opacity -= 0.01;
      } else {
        fademe.style.opacity = 1;
        if(counter<lines) counter++;
        else counter=0;
        textString=allLines[counter];
        regenerate();
        //clearInterval(fadeEffect);
      }
  }, 30);

function setSize(x,y){
  slider.value=x;
  slider2.value=y;

  canvasWidth = x;
  canvasHeight = y;

  output.innerHTML = x;
  output2.innerHTML = y;

  regenerate();
}
/*
var intervalId = window.setInterval(function(){
  /// call your function here
  if(counter<lines) counter++;
  else counter=0;

  textString=allLines[counter];

  regenerate();
}, 3000);*/

var allLines;
var counter=0;
var lines=0;
function readTextFile(file)
{
    var rawFile = new XMLHttpRequest();
    rawFile.open("GET", file, false);
    rawFile.onreadystatechange = function ()
    {
        if(rawFile.readyState === 4)
        {
            if(rawFile.status === 200 || rawFile.status == 0)
            {
                var allText = rawFile.responseText;
                allLines = allText.split('\n');
                lines = allLines.length;
                //alert(allText);
            }
        }
    }
    rawFile.send(null);
}
