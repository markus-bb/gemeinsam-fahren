<!DOCTYPE html>
<html>
<head>
  <title>eMail entfernen</title>
  <meta charset="utf-8">
  <version V02h 2024-10-31>
</head>

<body>

  <?php
    $csvfile = '../Teilnehmer/MFGteilnehmer.csv';
    $vers = 'V02h';
    $params = $_GET;
    $tpr = 0;   # für Testausgabe : $tpr = 1;

    if ($tpr > 0) {
        echo " <h1>Eintrag entfernen: MFGentferne_mail</h1>"."\n";
        echo "<h3> Eingabeparameter </h3>"."\n";
        foreach ($params as $x => $y) {
           echo "$x: $y <br>\n";
        }
    }

    $mail = htmlspecialchars($params['mail']);

     if ( strlen($mail)==0) {
	echo '<h4>Fehler in den Daten</h4>'."\n";
	echo 'leere e-mail Adresse<br>'."\n"; 
	echo $mail.'<br>'."\n"; 
	echo ' <br> <br><button onclick="history.back()">zurück zur Eingabe</button>';
     } else {
     
	if ($tpr > 0) { echo "<h3>verarbeitete Parameter</h3>\n"; }
 
	$title = " :".$mail;
	$description = ' ';
	$icon = 'Daten/marker_gruppengefluester.png';

	$line = $title.';'.$description.'; ; ;'.$icon;
	if ($tpr > 0) { echo $line."<br>\n"; }
 
	$myfile = fopen($csvfile, "a") or die("Unable to open file!");
    # Achtung der Zeilenumbruch am Ende der nächsten Zeile muss da bleiben!!
	fwrite($myfile, $line.'
');
	fclose($myfile);
        echo '<small>'.$vers.'</small><br>'."\n";
	echo "<h3>e-Mail Adresse ".$mail." wurde entfernt</h3>\n";
	echo "<h4>Falls Marker noch auf Karte erscheint, Strg + F5 gleichzeitig drücken.</h4>\n";
	# see https://www.php.net/manual/en/function.header.php         
	#header("Location:../MFGkarte.html");     # aktivieren für Schnelldurchlauf !
	echo '<a href="../MFGkarte.html">weiter zur Karte</a> <br>'."\n";
     }
  ?>
  


</body>
</html>