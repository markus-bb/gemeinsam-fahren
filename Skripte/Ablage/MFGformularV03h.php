<!DOCTYPE html>
<html>
<head>
	<title>Formular für MFG</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">
  	<version 03h 2024-10-27>
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
	<table>
	<tr style="vertical-align:top"> <td style="width:50%">
	<form action="MFGbearbeite_csv.php" id="user">
		<label form="person"><h2>Kontakt</h2> </label>
		<fieldset> <legend> Kontaktdaten für Pop-up </legend>
		<table>
			<tr> 
			    	<td> <label for="vorname">Vorname</label> </td>
			    	<td> <input type="text" style="background-color:rgba(211, 252, 3, 0.3)" name="vorname" id="vorname" maxlength="30" value="Max" > </td>			
			    	<td> <label for="nachname">Nachname</label> </td>
				<td> <input type="text" name="nachname" id="nachname" maxlength="40"> </td>
			</tr><tr> 
			        <td> <label for="plz">PLZ </label></td>
			        <td> <input type="plz" name="plz" id="plz" maxlength="5"> </td>				
				<td> <label for="ort">Ort</label>  </td>
				<td> <input type="text" name="ort" id="ort" maxlength="40"> </td>
			</tr><tr>
				<td> <label for="mail">E-Mail</label> </td>
				<td> <input id="mail" type="email" style="background-color:rgba(211, 252, 3, 0.3)" name="mail" required value="Max@mail.com" > </td>
			</tr><tr>
				<!-- Koordinate: readonly, kommt aus dem Klickereignis -->
				<td> <label for="koordinate">Koordinate</label> </td>
				<?php
                                      echo '<td> <input type="text" name="koordinate" id="koordinate" maxlength="21" style="background-color:#dddddd" readOnly value="',
                                            substr($params['latlng'],6), '"> </td>';
                                ?>
			</tr><tr>
				<td colspan="1"> <label>Bitte meinen Eintrag komplett löschen</label> </td>
				<td> <input type="checkbox" id="löschen" name="löschen"> </td>
			</tr>	
		</table>
                <p> <button type="submit" style="background-color:#FFFF00"> Eintrag mit angegebener e-Mail löschen </button> </p>
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

	<p>
		<button type="button" onclick="history.back()" style="background-color:#B0B0B0"> Abbrechen und zurück zur Karte</button>
	</p>
	</td>
	<td style="width:5%"> </td>
<!-- rechte Spalte hier Inhalt einfügen -->
	<td style="width:45%" "text-align:top">
		<h2>Anleitung</h2>
		hier Inhalt einfügen <br>
		hier Inhalt einfügen <br>
		hier Inhalt einfügen <br>
		hier Inhalt einfügen <br>
	</td>
	</tr>
	<table>
</body>
</html>