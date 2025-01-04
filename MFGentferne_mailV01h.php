<!DOCTYPE html>
<html>
<head>
  <title>eMail entfernen</title>
  <meta charset="utf-8">
  <version 01h 2024-10-30>
</head>

<body>
  <h1>Eintrag entfernen: MFGentferne_mail</h1>
  <?php
    $csvfile = '../Teilnehmer/MFGteilnehmer.csv';

    echo "<h3> Eingabeparameter </h3>";
    $params = $_GET;
    foreach ($params as $x => $y) {
       echo "$x: $y <br>\n";
    }

    $mail = htmlspecialchars($params['mail']);

     if ( strlen($mail)==0) {
	echo '<h4>Fehler in den Daten</h4>'."\n";
	echo 'leere e-mail Adresse<br>'."\n"; 
	echo $mail.'<br>'."\n"; 
	echo ' <br> <br><button onclick="history.back()">zurück zur Eingabe</button>';
     } else {
     
	echo "<h3>verarbeitete Parameter</h3>\n";
 
	$title = " :".$mail;
	$description = ' ';
	$icon = 'Daten/marker_gruppengefluester.png';

	$line = $title.';'.$description.'; ; ;'.$icon;
	echo $line."<br>\n";
 
	$myfile = fopen($csvfile, "a") or die("Unable to open file!");
    # Achtung der Zeilenumbruch am Ende der nächsten Zeile muss da bleiben!!
	fwrite($myfile, $line.'
');
	fclose($myfile);
	echo "<h3>Daten erfolgreich übernommen</h3>\n";
	# see https://www.php.net/manual/en/function.header.php         
	header("Location:../MFGkarte.html");     # aktivieren für Schnelldurchlauf !
	echo '<a href="../MFGkarte.html">weiter zur Karte</a> <br>'."\n";
     }
  ?>
  


</body>
</html>