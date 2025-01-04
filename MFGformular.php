<!DOCTYPE html>
<html>
<head>
	<title>Formular für MFG</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">
  	<version 06h 2024-10-30>
</head>
<body>
  <?php
    # for test purposes output received parameters
    $params = $_GET;
    foreach ($params as $x => $y) {
       # echo "$x: $y <br>";
    }
   ?>
    <!-- Formular für gemeinsames Fahren -->
    <h1> Gemeinsam Reisen </h1>
    <table> <!-- Tabelle 3 Spalten, links Eingabe Mitte leer (Abstand), rechts Anleitung -->
	<tr style="vertical-align:top"> <td style="width:47%">
	<small>V06h</small>
	<button type="button" onclick="history.back()" style="background-color:#B0B0B0"> Abbrechen und zurück zur Karte</button>

	<form action="MFGbearbeite_csv.php" id="user">
	    <label form="person"><h2>Kontakt</h2> </label>
	    <fieldset> <legend> Kontaktdaten für Pop-up </legend>
		<table>
			<tr> 
			    	<td> <label for="vorname">Vorname</label> </td>
			    	<td> <input type="text" style="background-color:rgba(211, 252, 3, 0.3)" name="vorname" id="vorname" maxlength="30" > </td>			
			    	<!--<td> <label for="nachname">Nachname</label> </td>
				<td> <input type="text" name="nachname" id="nachname" maxlength="40"> </td> -->
			</tr><!--<tr> 
			        <td> <label for="plz">PLZ </label></td>
			        <td> <input type="plz" name="plz" id="plz" maxlength="5"> </td>				
				<td> <label for="ort">Ort</label>  </td>
				<td> <input type="text" name="ort" id="ort" maxlength="40"> </td>
			</tr>--><tr>
				<td> <label for="mail">E-Mail</label> </td>
				<td> <input id="mail" type="email" style="background-color:rgba(211, 252, 3, 0.3)" name="mail" required > </td>
			</tr><tr>
				<!-- Koordinate: readonly, kommt aus dem Klickereignis -->
				<td> <label for="koordinate">Koordinate</label> </td>
				<?php
                                      echo '<td> <input type="text" name="koordinate" id="koordinate" maxlength="21" style="background-color:#dddddd" readOnly value="',
                                            substr($params['latlng'],6), '"> </td>';
                                ?>
			</tr>
		</table>
	    </fieldset>

		
	    <!-- Select -->
	    <label form="person"><h2>Dein Angebot/Gesuch</h2> </label>
	    <fieldset> <legend> Reisedaten für Pop-up </legend>
		<table>
			<tr>
				<td> <label for="hin">Hinfahrt</label> </td>
				<td> <select name="hin">
					<option>Samstag Vormittag</option>
					<option>Freitag Abend </option>
					<option>Fr oder Sa möglich</option>
					<option> </option>
				     </select>	
				</td>
			</tr><tr>
				<td> <label for="rueck">Rückfahrt</label> </td>
				<td> <select name="rueck">
					<option>Sonntag Abend</option>
					<option>Montag Vormittag </option>
					<option>So oder Mo möglich</option>
					<option> </option>
				     </select>	
				</td>
			</tr>
		</table>
		
		<table>
			<tr>
				<td colspan="1"> <label>Fahre mit der Bahn und suche Mitfahrende</label> </td>
				<td> <input type="checkbox" id="MfgBahn" name="MfgBahn"> </td>
			</tr><tr>
				<td colspan="1"> <label>Biete Platz im Auto für</label> </td>
				<td> <input type="number" id="MfgBieteAutoZahl" size=3 min="0" max="9" name="MfgBieteAutoZahl"> </td>
				<td> <label>Personen</label> </td>
			</tr><tr>
				<td colspan="1"> <label>Suche Platz im Auto für</label> </td>
				<td> <input type="number" id="MfgSucheAutoZahl" size=3 min="0" max="9" name="MfgSucheAutoZahl"> </td>
				<td> <label>Personen</label> </td>
			</tr><tr>
				<td colspan="4"> (Mehrfachauswahl erhöht die Chance...) </td>
			<tr>
		</table>
	    </fieldset>
            <p> <button type="submit" style="background-color:#00FF7F"> Marker und Pop-up erstellen </button> </p>
	</form>

	<form action="MFGentferne_mail.php" id="remove">
	    <label form="entferne"><h2>Eintrag entfernen</h2> </label>
	    <fieldset> <legend>bisheriger Kontakt</legend>
		<table>
                    <tr>
			<td> <label for="mail">E-Mail&nbsp;</label> </td>
			<td> <input id="mail" type="email" style="background-color:rgba(211, 252, 3, 0.3)" name="mail" required  > </td>
		    </tr>
	 	</table>
	    </fieldset>
	    <p> <button type="submit" style="background-color:#FFFF00"> Eintrag mit angegebener e-Mail entfernen </button> </p> 
	</form>
	</td>

<!-- Abstand zw. Spalten -->
	<td style="width:3%"> </td>

<!-- rechte Spalte hier Inhalt einfügen -->
	<td style="width:50%" "text-align:top">
		<br><h2>Anleitung</h2>
		<h3>Daten für Pop-up erfassen</h3>

		<ol>
		<li> Fülle das Formular aus. 
			<br> Im Pop-up auf der Karte werden Vorname, E-Mail und Dein Angebot/Gesuch angezeigt. 
			<br> Du kannst <b>sowohl Bahn als auch Auto-Fahrgemeinschaften</b> eingeben, wenn Du vorerst beide Optionen <br>offen halten möchtest. </li>
		<li> Die Koordinaten Deines Markers wurden bereits automatisch in das Formular übernommen. </li>
		<li> Klicke auf „Marker und Pop-up erstellen“ um den Vorgang abzuschließen. </li>
		<li> Falls Dein Marker nicht erscheint, drücke gleichzeitig Strg und F5, um die Karte neu zu laden. </li>
		</ol>

<br><br><br><br><br><br><br><br><br><br><br>
		<h3>Bestehenden Marker entfernen</h3>
		<p> Gib die <b>identische</B> E-Mail des Markers, den Du entfernen willst, in das Feld unter „Eintrag entfernen“ ein <br>
		und klicke den gelben Button.

		<h3>Support</h3> 
		<p> kontakt@cornelia-dietz.de
		</p>
	</td>
	</tr>
    <table>
</body>
</html>