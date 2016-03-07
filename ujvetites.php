<html>
<head>
<title>MoziVilág</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2">
<link rel="stylesheet" href="biblio.css" type="text/css">
<script language="JavaScript" src="biblio.js"></script>
</head>

<body bgcolor="#FFFFFF" text="#000000" link="#AAAAAA" vlink="#AAAAAA" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table bgcolor="#FFFFFF" width=700 border=0 align=center class=fotabla><tr><td>

	<?php 
	$moziID=$_POST["moziID"];
	if(!isset($moziID)) $moziID=""; ?>

	<?php
	// ha van mozi kivalasztva, ellenkezo esetben hiba
	if($moziID) {
		echo "<a href=admin.php><< Kilépés</a>";
		// a kapcsolat letrehozasahoz a connect.php be-include-olasa. minden php oldalhoz kulon kapcsolatot kell letrehozni
		include "connect.php"; 
		
		//menü
		echo "<table width=400 align=center>
			<tr><td>
				<form action=filmlistaz.php method=post name=film>
				<input type=hidden name=moziID value=$moziID>
				<input type=submit value=filmek class=submitbutton>
				</form>
			</td><td>
				<form action=vetiteslistaz.php method=post name=vetites>
				<input type=hidden name=moziID value=$moziID>
				<input type=submit value=vetítések class=submitbutton>
				</form>
			</td><td>
				<form action=ujvetites.php method=post name=vetites>
				<input type=hidden name=moziID value=$moziID>
				<input type=submit value=\"vetítés hozzáadása\" class=submitbutton>
				</form>
			</td></tr>
		</table>";
		
		//filmek listázása
		$query=" select * from Film";
		//echo $query_kolcs;
		$resultset=mysqli_query($mysqllink,$query) or die("lekérdezési hiba: ".mysqli_error($mysqllink));

		// filmek szamanak kiiratasa
		echo "<center><b>Filmek száma: ".mysqli_affected_rows($mysqllink)."</b></center><br>";

		// ha van film
		if(mysqli_affected_rows($mysqllink)>0) {

			// while ciklus vegig a filmeken
			echo "<form action=ujvetitesjovahagyas.php method=post name=jovahagyas>
				<input type=hidden name=moziID value=$moziID>
				<table width=95% align=center class=kolcstabla>";
			$i=0;
			while($row2=mysqli_fetch_assoc($resultset)) {
				echo "<tr>
					<td align=center><input type=radio name=radio value=$row2[film_id]></td>
					<td align=center>$row2[film_cim]</td>
				</tr>";
				$i++;
			}
			echo "</table><br>
				<table width=400 align=center>
					<tr><td align=right width=40%>vetítés dátuma:</td><td><input type=text maxlength=12 name=datum value= ></td></tr>
					<tr><td align=right width=40%>jegyár:</td><td><input type=text maxlength=12 name=ar value= ></td></tr>
					<tr><td>&nbsp;</td><td><input type=submit value=\"mentés\" class=submitbutton></td></tr>
				</table>
				</form>";
		}
		
		else { //nem adott vissza semmit a lekerdezes
			echo "<div align=center class=hiba>nincs egyetlen film sem</div>";
		}
		mysqli_close($mysqllink);
		
	
	}
	else { //moziID valtozonak nincs erteke
		echo "<div align=center class=hiba>nincs azonosító megadva</div>";
		echo "<a href=admin.php><< Jelentkezzen be!</a>";
	}

	?>


</td></tr></table>

</body>
</html>