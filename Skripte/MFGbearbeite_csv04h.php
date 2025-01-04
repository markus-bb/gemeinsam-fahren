<!DOCTYPE html>
<html>
<head>
  <title>Data Eval</title>
  <meta charset="utf-8">
  <version 04h 2024-10-31>
</head>

<body>
  <!-- <h1>Datenauswertung: MFGbearbeite_csv</h1> -->
  <?php
    $csvfile = '../Teilnehmer/MFGteilnehmer.csv';
    $vers = 'V04h';
    $tpr = 0;   # für Testausgabe : $tpr = 1;

    $params = $_GET;
    if ($tpr > 0 ) {
        echo "<h3> Eingabeparameter </h3>";
         foreach ($params as $x => $y) {
           echo "$x: $y <br>\n";
        }
    }
    echo '<small>'.$vers.'</small><br>'."\n";
    $vorname = htmlspecialchars($params['vorname']);
    $mail = htmlspecialchars($params['mail']);
    $koordinate= htmlspecialchars($params['koordinate']);
    $p = strpos($koordinate,',');
    $lat = substr($koordinate,1,$p-1);
    $lng = substr($koordinate,$p+2,-1);

     if ( strlen($vorname)<3 or strlen($mail)==0) {
	echo '<h4>Fehler in den Daten</h4>'."\n";
	echo 'zu kurzer Vorname oder leere e-mail Adresse<br>'."\n"; 
	echo $vorname.":".$mail.'<br>'."\n"; 
	echo ' <br> <br><button onclick="history.back()">zurück zur Eingabe</button>';
     } else {
     
        if ($tpr > 0) { echo "<h3>verarbeitete Parameter</h3>\n"; }
 
	$title = $vorname.":".$mail;
	$description = 'hin='.htmlspecialchars($params['hin']).':rueck='.htmlspecialchars($params['rueck']).':MfgBahn='.htmlspecialchars($params['MfgBahn']);
	$description = $description.':MfgBieteAutoZahl='.htmlspecialchars($params['MfgBieteAutoZahl']).':MfgSucheAutoZahl='.htmlspecialchars($params['MfgSucheAutoZahl']);
	$icon = 'Daten/marker_gruppengefluester.png';

	$line = $title.';'.$description.';'.$lat.';'.$lng.';'.$icon;
	if ($tpr > 0) { echo $line."<br>\n"; }
 
	$myfile = fopen($csvfile, "a") or die("Unable to open file!");
    # Achtung der Zeilenumbruch am Ende der nächsten Zeile muss da bleiben!!
	fwrite($myfile, $line.'
');
	fclose($myfile);
	echo "<h3>Daten erfolgreich übernommen</h3>\n";
	if ($tpr > 0) { echo "<small> 04h </small>\n"; }
	echo "<h4>Falls Marker nicht auf Karte erscheint, Strg + F5 gleichzeitig drücken.</h4>\n";
	# see https://www.php.net/manual/en/function.header.php         
	# header("Location:../MFGkarte.html");     # aktivieren für Schnelldurchlauf !
	echo '<a href="../MFGkarte.html">weiter zur Karte</a> <br>'."\n";
     }
  ?>

</body>
</html>