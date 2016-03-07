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
		
		//vetítések listázása
		$query=" select  film_cim, film_datum, film_nyelve, vetites_datum, jegyar, count(j.vasarlas_datum) as jegydb, count(j.vasarlas_datum)*jegyar as bevetel from Vetites v inner join Film f on v.film_id=f.film_id left outer join Jegy j on j.vetites_id=v.vetites_id where mozi_id=$moziID group by v.vetites_id order by count(*) desc";
		//echo $query_kolcs;
		$resultset=mysqli_query($mysqllink,$query) or die("lekérdezési hiba: ".mysqli_error($mysqllink));

		// vetítések szamanak kiiratasa
		echo "<center><b>Vetítések száma: ".mysqli_affected_rows($mysqllink)."</b></center><br>";

		// ha van vetítés
		if(mysqli_affected_rows($mysqllink)>0) {

			// while ciklus vegig a filmeken
			echo "<table width=95% align=center class=kolcstabla>
				<tr>
					<td align=center><b>cim</td>
					<td align=center><b>év</td>
					<td align=center><b>nyelv</td>
					<td align=center><b>dátum</td>
					<td align=center><b>jegyár</td>
					<td align=center><b>eladott jegyek</td>
					<td align=center><b>bevétel</td>
				</tr>";
			$i=0;
			while($row2=mysqli_fetch_assoc($resultset)) {
				echo "<tr>
					<td align=center>$row2[film_cim]</td>
					<td align=center>$row2[film_datum]</td>
					<td align=center>$row2[film_nyelve]</td>
					<td align=center>$row2[vetites_datum]</td>
					<td align=center>$row2[jegyar] Ft</td>
					<td align=center>$row2[jegydb]</td>
					<td align=center>$row2[bevetel] Ft</td>
				</tr>";
				$i++;
			}
			echo "</table>";
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