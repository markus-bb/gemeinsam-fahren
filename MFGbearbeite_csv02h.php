<!DOCTYPE html>
<html>
<head>
  <title>Data Eval</title>
  <meta charset="utf-8">
  <version 02h 2024-10-23>
</head>

<body>
  <h1>Datenauswertung: MFGbearbeite_csv</h1>
  <?php
    $csvfile = '../Teilnehmer/MFGteilnehmer.csv';

    echo "<h3> Eingabeparameter </h3>";
    $params = $_GET;
    foreach ($params as $x => $y) {
       echo "$x: $y <br>\n";
    }

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
     
	echo "<h3>verarbeitete Parameter</h3>\n";
 
	$title = $vorname.":".$mail;
	$description = 'hin='.htmlspecialchars($params['hin']).':rueck='.htmlspecialchars($params['rueck']).':MfgBahn='.htmlspecialchars($params['MfgBahn']);
	$description = $description.':MfgBieteAutoZahl='.htmlspecialchars($params['MfgBieteAutoZahl']).':MfgSucheAutoZahl='.htmlspecialchars($params['MfgSucheAutoZahl']);
	$icon = 'Daten/Icon_Gruppengefluester-07-40px.png';

	$line = $title.';'.$description.';'.$lat.';'.$lng.';'.$icon;
	echo $line."<br>\n";
 
	$myfile = fopen($csvfile, "a") or die("Unable to open file!");
    # Achtung der Zeilenumbruch am Ende der nächsten Zeile muss da bleiben!!
	fwrite($myfile, $line.'
');
	fclose($myfile);
	echo "<h3>Daten erfolgreich übernommen</h3>\n";        
	# header("Location:../MFGkarte.html");     # aktivieren für Schnelldurchlauf !
	echo '<a href="../MFGkarte.html">weiter zur Karte</a> <br>'."\n";
     }
  ?>
  


</body>
</html>