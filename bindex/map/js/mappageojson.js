let myMap;
let canvas;
const mappa = new Mappa('Leaflet');

const options = {
  lat: 39.5,
  lng: 28.5,
  zoom: 8,
  style: "https://stamen-tiles-{s}.a.ssl.fastly.net/toner-background/{z}/{x}/{y}.png"
}

var Stamen_TonerBackground = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/toner-background/{z}/{x}/{y}{r}.{ext}', {
	attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
	subdomains: 'abcd',
	minZoom: 0,
	maxZoom: 20,
	ext: 'png'
});

function setup(){

  canvas = createCanvas(windowWidth,windowHeight-40);
  myMap = mappa.tileMap(options);
  myMap.overlay(canvas)

  // Only redraw the point when the map changes and not every frame.
  myMap.onChange(drawPoint);
	textFont('Space Mono');
	textStyle(BOLD);

	let str="Design, Books and Edition, Coding, Creative Industries, New Media Art, Electronics,Görsel sanatlar,Tasarım,Gösteri sanatları, Çağdaş müzik, Sinema, Ses, Fanzin,Görsel sanatlar, Gösteri sanatları, Film, Fotoğraf, Tiyatro, Edebiyat, Şehircilik, Arkeoloji, Eğitim, Toplum gelişimi, Sürdürülebilirlik, Sinema, Okuma, Kitap, Çevre,Görsel sanatlar, Kamusal alan, Katılımcı sanat, Teknoloji, Yaratıcı endüstriler, Yeni medya Sanatı, Elektronik,Görsel sanatlar, Fotoğraf, Yayın, Kamusal alan, Katılımcı sanat, Sosyal odaklı sanat, Toplum gelişimi,Gösteri sanatları, Tiyatro, Eğitim, Dans, Sosyal odaklı sanat, Gençlik çalışmaları, Doğaçlama Tiyatro,Görsel sanatlar, Film, Fotoğraf, Sosyal odaklı sanat,Görsel sanatlar, Gösteri sanatları, Tiyatro, Yayın, Networking, Fanzin, Yeni medya Sanatı,Gösteri sanatları, Edebiyat, Dans, Sürdürülebilirlik, Kitap, Çevre, Hareketli Meditasyon,Görsel sanatlar, Kamusal alan, Katılımcı sanat, Sosyal odaklı sanat, Sokak sanatı, Plastik sanatlar,Görsel sanatlar, Plastik sanatlar, Tasarım";
	keywords=split(str, ",");
}
let keywords;

function draw(){
}

let w=130;let h=30;
let w2=w/2;let h2=h/2;

function drawPoint(){
	//background(255);
	textAlign(CENTER);
  clear();

  const nurten = myMap.latLngToPixel(38.37111, 26.898040); // Nurten Yıldırım
	const nobon = myMap.latLngToPixel(38.420820, 27.145060); // NOBON
	const ap=myMap.latLngToPixel(38.437330,27.157930);//Apeiron Collective
	const yuksek=myMap.latLngToPixel(38.435890,27.142710);//Yüksek Oda
	const beden=myMap.latLngToPixel(40.996130,29.026560);//Beden İşlemsel Sanatlar Derneği
	const no238=myMap.latLngToPixel(38.423050,27.131530);//No 238
	const tiatro=myMap.latLngToPixel(38.436890,27.143190);//TİYATROHANE
	const siyah=myMap.latLngToPixel(38.394800,27.058980);//Büyük Siyah Kapı
	const lokall=myMap.latLngToPixel(38.419320,27.130230);//Lokall İzmir Kent Rehberi
	const acik=myMap.latLngToPixel(38.367140,26.765710);//Açık Stüdyo
	const daragac=myMap.latLngToPixel(38.437200,27.157890);//Darağaç

	noStroke();
	fill(0);

  rect(nurten.x-w2, nurten.y-h2, w, h);
	rect(nobon.x-w2, nobon.y-h2, w, h);
	rect(ap.x-w2, ap.y-h2, w, h);
	rect(yuksek.x-w2, yuksek.y-h2, w, h);
	rect(beden.x-w2*2, beden.y-h2, w*2, h);
	rect(no238.x-w2, no238.y-h2, w, h);
	rect(tiatro.x-w2, tiatro.y-h2, w, h);
	rect(siyah.x-w2, siyah.y-h2, w, h);
	rect(lokall.x-w2, lokall.y-h2, w, h);
	rect(acik.x-w2, acik.y-h2, w, h);
	rect(daragac.x-w2, daragac.y-h2, w, h);

	/*circle(nobon.x, nobon.y, circleSize);
	circle(ap.x, ap.y, circleSize);
	circle(yuksek.x, yuksek.y, circleSize);
	circle(beden.x, beden.y, circleSize);
	circle(no238.x, no238.y, circleSize);
	circle(tiatro.x, tiatro.y, circleSize);
	circle(siyah.x, siyah.y, circleSize);
	circle(lokall.x, lokall.y, circleSize);
	circle(acik.x, acik.y, circleSize);
	circle(daragac.x, daragac.y, circleSize);
*/
	fill(255,222,78);
	text("Nurten Yıldırım",nurten.x, nurten.y);
	text("NOBON",nobon.x, nobon.y);
	text("Apeiron Collective",ap.x, ap.y);
	text("Yüksek Oda",yuksek.x, yuksek.y);
	text("Beden İşlemsel Sanatlar Derneği",beden.x, beden.y);
	text("No 238",no238.x, no238.y);
	text("TİYATROHANE",tiatro.x, tiatro.y);
	text("Büyük Siyah Kapı",siyah.x, siyah.y);
	text("Lokall İzmir Kent Rehberi",lokall.x, lokall.y);
	text("Açık Stüdyo",acik.x, acik.y);
	text("Darağaç",daragac.x, daragac.y);

	textAlign(LEFT);
	for(let i=0;i<keywords.length;i++) {
		fill(0);
		rect(100,88+20*i,200,19);
		fill(255,222,78);
		text(keywords[i],100,100+20*i);
	}
}


// Open the full screen search box
function openItem(str) {
  console.log("loading "+str);
  document.getElementById(str).style.display = "block";
}

// Close the full screen search box
function closeItem(str) {
  document.getElementById(str).style.display = "none";
}
