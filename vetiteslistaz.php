<html>
<head>
<title>MoziVil�g</title>
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
		echo "<a href=admin.php><< Kil�p�s</a>";
		// a kapcsolat letrehozasahoz a connect.php be-include-olasa. minden php oldalhoz kulon kapcsolatot kell letrehozni
		include "connect.php"; 
		
		//men�
		echo "<table width=400 align=center>
			<tr><td>
				<form action=filmlistaz.php method=post name=film>
				<input type=hidden name=moziID value=$moziID>
				<input type=submit value=filmek class=submitbutton>
				</form>
			</td><td>
				<form action=vetiteslistaz.php method=post name=vetites>
				<input type=hidden name=moziID value=$moziID>
				<input type=submit value=vet�t�sek class=submitbutton>
				</form>
			</td><td>
				<form action=ujvetites.php method=post name=vetites>
				<input type=hidden name=moziID value=$moziID>
				<input type=submit value=\"vet�t�s hozz�ad�sa\" class=submitbutton>
				</form>
			</td></tr>
		</table>";
		
		//vet�t�sek list�z�sa
		$query=" select  film_cim, film_datum, film_nyelve, vetites_datum, jegyar, count(j.vasarlas_datum) as jegydb, count(j.vasarlas_datum)*jegyar as bevetel from Vetites v inner join Film f on v.film_id=f.film_id left outer join Jegy j on j.vetites_id=v.vetites_id where mozi_id=$moziID group by v.vetites_id order by count(*) desc";
		//echo $query_kolcs;
		$resultset=mysqli_query($mysqllink,$query) or die("lek�rdez�si hiba: ".mysqli_error($mysqllink));

		// vet�t�sek szamanak kiiratasa
		echo "<center><b>Vet�t�sek sz�ma: ".mysqli_affected_rows($mysqllink)."</b></center><br>";

		// ha van vet�t�s
		if(mysqli_affected_rows($mysqllink)>0) {

			// while ciklus vegig a filmeken
			echo "<table width=95% align=center class=kolcstabla>
				<tr>
					<td align=center><b>cim</td>
					<td align=center><b>�v</td>
					<td align=center><b>nyelv</td>
					<td align=center><b>d�tum</td>
					<td align=center><b>jegy�r</td>
					<td align=center><b>eladott jegyek</td>
					<td align=center><b>bev�tel</td>
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
		echo "<div align=center class=hiba>nincs azonos�t� megadva</div>";
		echo "<a href=admin.php><< Jelentkezzen be!</a>";
	}

	?>


</td></tr></table>

</body>
</html>