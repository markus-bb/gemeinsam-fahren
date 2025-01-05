<?php
$correctPassword = "test123"; // Set your password here

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST['password'];
    if ($password !== $correctPassword) {
        header('Location: login.html');
        exit();
    }
} else {
    header('Location: login.html');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>MFG Karte</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <version V28m 2024-12-22>
  
  <!-- Load Leaflet code library - see updates at http://leafletjs.com/download.html -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

  <!-- Load jQuery and PapaParse to read data from a CSV file -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/papaparse@5.3.0/papaparse.min.js"></script>

  <!-- Load library to read data from a gpx file 
  <script src="https://cdn.jsdelivr.net/npm/leaflet-gpx@1.7.0/gpx.min.js"></script> -->
  <script src="Skripte/gpx.js"></script>

  <!-- Position the map with Cascading Style Sheet (CSS) -->
  <style>
    body { margin:0; padding:0; }
    #map { position: absolute; top:0; bottom:0; right:0; left:0; }
  </style>

</head>

<body>

  <!-- Insert HTML division tag to layout the map -->
  <div id="map"></div> 

  <!-- Insert Javascript (.js) code to create the map -->
  <script>

  // admin parameters  
  const vers = "V28m";
  const tpr = 0; 

  // various parameter for localisation
  // set csv name for mult. purpose
  const csvname = 'Teilnehmer/MFGteilnehmer.csv';
  const strCol = '#00AA9E';
  const cirCol = '#00AA9E';
  const cirRad = 3000;
  const ziel = [49.5922, 11.0310];

// gpx Parameter
  const gpxname = 'Fussweg';
  const gpxsource = 'Daten/Fussweg.gpx';
  const startIcon = 'Daten/dgreen.png';
  const endIcon = 'Daten/dred.png';

// Teilnehmer Marker  noch nicht genutzt
  const teilmarker='Daten/marker_gruppengefluester.png';
  const mustermarker='Daten/Icon_Gruppengefluester-07-40px.png';

// homemarker + popup
  const homemarker='Daten/marker_gruppengefluester.png';
//  var homepopuptext = '<small>'+vers+'</small><br><img src="Daten/Logo_Gruppengefluester-07-200px.jpg" align="left">'+"\n";
  var homepopuptext = '<img src="Daten/Logo_Gruppengefluester-07-200px.jpg" align="left">'+"\n";
  homepopuptext += '<p><br><br><a href="https://cornelia-dietz.de" target="_blank"><b>Cornelia-Dietz.de</b></a><br></p>'+"\n";
  homepopuptext += '<a href="MFGintro_hilfe.html">Zu Einleitung und Hilfe </a>';
  
// Bahnhof
  const iconBahnhof = 'Daten/hbf.png';
  const latlngBahnhof = [49.59605, 11.0021];
  const textBahnhof = '<b>Bahnhof Erlangen</b><br>150m zum Hugenottenplatz<br>mit Bus <b>294</b>, in 7 Minuten<br>nach "Röthelheimpark-Zentrum"';

// Buslinie
  var buslatlngs = [ [49.591847, 11.029072],[49.592395, 11.022050],[49.593793, 11.022270],[49.594311, 11.015036],[49.594320, 11.014569],
		  [49.594047, 11.009641],[49.597213, 11.008485],[49.596554, 11.004114],[49.596447, 11.004023],[49.596381, 11.004041] ];
  const busStartLatlng = [49.5964,11.00405];
  const busStartText ='<b>Hugenottenplatz</b><br>mit Bus <b>294</b>, in 7 Minuten<br>nach "<b>Röthelheimpark-Zentrum</b>"';
  const busEndLatlng = [49.592, 11.0289];
  const busEndText ='Röthelheimpark-Zentrum, Bus 294';
  const busIcon = 'Daten/bus_green.png';

// ======================================================================================
// generates markers with popups
  function makePOI(csvFile) {

    // model for various icons 
    var SDIcon = L.Icon.extend({
      options: {
        iconSize:   [45, 45],
        iconAnchor: [22, 45],
        popupAnchor:[0, -12],
     }
    });
    const markers = L.layerGroup();

  // Read markers data from file csvString
    $.get(csvFile, function(csvString) {
      // Use PapaParse to convert string to array of objects
      var data = Papa.parse(csvString, {header: true, dynamicTyping: true}).data;

      // For each row in data, create a marker and add it to clubs 
      // For each row, columns `Latitude`, `Longitude`, `Description`, `Icon`, and `Title` are required
      ll=data.length;
      if (tpr > 0 ) { console.log('size of data:'+ ll.toString());
         console.log('data[0]:'+data[0].Title+'  data[ll-2]:'+data[ll-2].Title); }

      const tmail = [];  // create list of e-mail addresses
 
      for ( let i = ll-2; i>=0; i--) {   // run loop backword, skip last empty element
        var row = data[i];

// check if Title is usefull
	if ( typeof row.Title == 'undefined') {
	    console.log('row.Title not defined ');
	    continue;
	}	    
	if ( row.Title.length < 6) {
	    console.log('row.Title to short ');
	    continue;
	}	
    	const name_email = row.Title.split(":");
	const emailx = name_email[1];
	if ( tmail.includes(emailx) ) {  // skip if e-mail is in list
	    // alert('email already exists: '+ emailx);
	    continue;
        }
	tmail.push(emailx);  // add to list of e-mail addresses

	// exclude coordinates out of range
	if (tpr > 0 ) { console.log('Latitude/Latitude: '+ row.Latitude+'('+(typeof row.Latitude)+') '+row.Longitude+'('+(typeof row.Latitude)+') '); }
//	if ( parseFloat(row.Latitude)>60.0 || parseFloat(row.Latitude)<40.0 || parseFloat(row.Longitude)>20.0 || parseFloat(row.Longitude)<0) { 
	if ( row.Latitude.length<2 || row.Longitude.length<2 ) { 
	    continue;
        }
	if ( typeof row.Latitude !== 'number' || typeof row.Longitude !== 'number' ) { 
	    continue;
        }
	// console.log('Title:'+row.Title+' '+row.Latitude+' '+row.Longitude);
        reformated = formatPopup(row.Title, row.Description);
	// console.log(reformated);
        var marker = L.marker([row.Latitude, row.Longitude], {
              icon: new SDIcon({iconUrl: row.Icon })
          }).bindPopup(reformated).addTo(markers);
      }
      if (tpr > 0 ) { console.log(tmail.toString()); }
    });

    
    return markers;
  }

// ======================================================================================
// function to format text in popup
function formatPopup(title, description) { 
     let count = 0;
     for (let i = 0; i < description.length; i++) {
	if (description[i] === '=') {
	   count++;
	}
     }
     var outstr = "";
     if (count > 1) {
	// console.log('========================================');
	// console.log(title);
	const params = description.split(":");

	let emptyS = true; // noch kein Eintrag

	for (i in params) {
	    // console.log(params[i]);
	    const parts = params[i].split("=");

	    switch(parts[0]) {
	    case 'hin': 
		outstr = outstr + '<br>Hinfahrt: &ensp;&nbsp;' + parts[1]+'<br>';
		break;
	    case  'rueck':
		outstr = outstr + 'Rückfahrt: ' + parts[1]+'<br><ul>';
		break;

	    case  'MfgBahn':
		if (parts[1] == 'on' )  {
		    emptyS = false; 
		    outstr = outstr + '<li>Fahre mit der Bahn und suche Mitfahrende</li>';
		}
		break;
	    case  'MfgBieteAutoZahl':
		if (parts[1] > 0 )  {
		   emptyS = false; 
		   if (parts[1] == 1 ) {
			outstr = outstr + '<li>Biete 1 Platz im Auto</li>';
                   } else {
			outstr = outstr + '<li>Biete '+parts[1]+' Plätze im Auto</li>';
		   }
		}
		break;
	    case  'MfgSucheAutoZahl':
		if (parts[1] > 0 )  {
		   emptyS = false; 
		   if (parts[1] == 1 ) {
			outstr = outstr + '<li>Suche 1 Platz im Auto</li>';
                   } else {
			outstr = outstr + '<li>Suche '+parts[1]+' Plätze im Auto</li>';
		   }
		}
		break;	    default:
		outstr = outstr + '<li>' + parts[0]+' not implemented </li>';
	    }
	}
	outstr = outstr + "</ul>";
	if (emptyS) {
	    outstr = "<ul>kein Angebot (mehr)</ul>";
	}
    }
    else {
	outstr = description;
    }
    // console.log(outstr);
    const name_email = title.split(":");	    
    const formated = "<strong>"+name_email[0]+"</strong>"+outstr + "<strong>e-mail: "+name_email[1]+"</strong>";
    return formated;
}


// ======================================================================================
// function to be performed on click
  function onClickCoord(e) {   
	// alert("You clicked the map at " + e.latlng);
        z = map.getZoom();
	// alert(e.latlng.lat+':'+ e.latlng.lng + ' zoom:', z);
	window.location.href = "Skripte/MFGformular.php?latlng="+e.latlng; 
        // window.open('Skripte/MFGformular.php?latlng='+e.latlng,'_blank' ); // <- Formular in neuem Tab öffnen.
  }


// ======================================================================================
// Strahlen...
  function makeStar2(csvFile, dist, center) {

  // Read position of markers data from file csvString
    // alert('makeStar:'+csvFile +' '+ dist.toString());

    const lines = [];
    const difflatlng = [];
    const latfak = 0.65;  // correction for long contraction 
    var dfak = 0.0;
    var ldist ;
    const star = L.layerGroup();
 
    $.get(csvFile, function(csvString) {
      // Use PapaParse to convert string to array of objects
      var data = Papa.parse(csvString, {header: true, dynamicTyping: true}).data;
      // For each row in data, create a marker and add it to clubs 
      // For each row, columns `Latitude`, `Longitude`, Description, Icon, and `Title` are required
      
      ll=data.length;
      const tmail = [];
      // for all points draw a line from Marker to a circle of radius = dist around center
      for ( let i = ll-2; i>=0; i--) {   // run loop backword, skip last empty element
        var row = data[i];

// check if Title is usefull
	if ( typeof row.Title == 'undefined') {
	    console.log('row.Title not defined ');
	    continue;
	}	    
	if ( row.Title.length < 6) {
	    console.log('row.Title to short ');
	    continue;
	}	

    	const name_email = row.Title.split(":");
	const emailx = name_email[1];
	if ( tmail.includes(emailx) ) {
	    // alert('email already exists: '+ emailx);
	    continue;
        }
	tmail.push(emailx);
	// exclude out of range
	if ( row.Latitude.length<2 || row.Longitude.length<2 ) { 
	    // alert('Latitude/Latitude out of range: '+ row.Latitude+' '+row.Longitude);
	    continue;
        }
	if ( typeof row.Latitude !== 'number' || typeof row.Longitude !== 'number' ) { 
	    continue;
        }

        if (i<3000) {  // allow to reduce data for testing
	     difflatlng[0] = center[0] - row.Latitude; difflatlng[1] = center[1] - row.Longitude;
	     // alert('difflatlng:'+difflatlng.toString());
           ldist = Math.sqrt(difflatlng[0]**2 + (difflatlng[1]*latfak)**2)*111;
           dfak = dist / 1000 / ldist;
	     lines[i] = [[center[0]-dfak*difflatlng[0],center[1]-dfak*difflatlng[1]],[row.Latitude,row.Longitude]];
	    // alert(lines[i].toString());
            polyline = L.polyline([lines[i]], {color: strCol}).addTo(star).bindPopup('Entfernung zum Ziel: '+ Math.round(ldist).toString()+' km');  
          }
      }
    });
    
    return star;
  }
    
// =========================== start of script ======================================

   // window.location.reload(true);   / reload page ??

// getting parameter from commandline
// see https://www.sitepoint.com/get-url-parameters-with-javascript/
   const queryString = window.location.search;
   // alert('queryString: ' + queryString);
   const urlParams = new URLSearchParams(queryString);
   // alert('urlParams: ' + urlParams.toString());

   var zoom = 13;   
   if ( urlParams.has('zoom') ) { // alert('has zoom'); 
      zoom = parseInt(urlParams.get('zoom')); }

   var lat = ziel[0];
   if ( urlParams.has('lat') ) { // alert('has lat');
      lat = Number(urlParams.get('lat'));  }

   var lon = ziel[1];
   if ( urlParams.has('lon') ) { // alert('has lon');
      lon =urlParams.get('lon');  }
   // alert('zoom: ' + zoom.toString() + '  lat: ' + lat.toString() +'  lon: ' + lon.toString()); /* */ 

// make markers for input file -> overlays
  msMarkers = makePOI(csvname);
  const overlays = { 'Teilnehmer': msMarkers };

// init OSM org tiles -> baseLayers 
  const OpenStreetMap_org = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
	maxZoom: 19,
	attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
  });
  const baseLayers = { 'OSM org': OpenStreetMap_org };

  // Set up initial map center and zoom level
  const map = L.map('map', {
    center: [lat, lon], 
    zoom: zoom,  
    layers: [OpenStreetMap_org, msMarkers],
    scrollWheelZoom: true
  });
  // alert('zoom: '+ map.getZoom());

// Kreis
    const circle = L.circle(ziel, {
		color: cirCol,
		fillColor: cirCol,
		fillOpacity: 0.1,
		radius: cirRad
	}).addTo(map);
 
// einzelne Strukturen vor Ort
// Bahnhof
    var bahnhof = L.icon({
	iconUrl: iconBahnhof,
	iconSize:  [40, 40],
	iconAnchor:[18, 40]  // point of the icon which will correspond to marker's location
    });
 
    // --> Bahnhof-Marker
    L.marker(latlngBahnhof,{icon: bahnhof}).addTo(map).bindPopup(textBahnhof);

// Buslinie
     polyline = L.polyline(buslatlngs, {color: 'green', dashArray: "8"} ).addTo(map).bindPopup('Buslinie');

     var bus_gruen = L.icon({
	iconUrl: busIcon,
	iconSize:  [40, 40],
	iconAnchor:[18, 40]  // point of the icon which will correspond to marker's location
    });

    // Bus Start
    L.marker(busStartLatlng,{icon: bus_gruen}).addTo(map).bindPopup(busStartText); 
    // Bus Ende
     L.marker(busEndLatlng,{icon: bus_gruen}).addTo(map).bindPopup(busEndText);

// Veranstaltungsort: ziel	
    // --> Popup soll offen bleiben	
    const scaleF = 0.35;
    var mhome = L.icon({
	iconUrl: homemarker,
	iconSize:  [170*scaleF, 200*scaleF],
	iconAnchor:[170*scaleF/2, 200*scaleF]  
    });
    L.marker(ziel,{icon: mhome}).addTo(map).bindPopup(homepopuptext,{minWidth: 200}).openPopup();

// Control panel to display map layers 
  const controlLayers = L.control.layers( baseLayers, overlays, {  
    position: "topright",
    collapsed: false, 
    hideSingleBase: true
  }).addTo(map);

// make star from file 1 -> star and add to map
  stars = makeStar2(csvname, cirRad, ziel);
  controlLayers.addOverlay(stars , 'Strecken');
  // see https://groups.google.com/g/leaflet-js/c/LwnqaZcb2VA
  // Strahlen sind default an
  stars.addTo(map);

// gpx Linie aus Datei
  new L.GPX(gpxsource , {
    async: true,
    marker_options: {
       startIconUrl: startIcon,
       endIconUrl: endIcon
    } 
  }  ).addTo(map).bindPopup(gpxname);

  map.on('dblclick', onClickCoord);   // add onClickCoord to map  
  </script>
  
</body>
</html>
