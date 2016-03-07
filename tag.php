<html>
<head>
<title>K�nyvt�ri k�lcs�nz�s</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2">
<link rel="stylesheet" href="biblio.css" type="text/css">
<script language="JavaScript" src="biblio.js"></script>
</head>

<body bgcolor="#FFFFFF" text="#000000" link="#AAAAAA" vlink="#AAAAAA" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width=700 border=0 align=center class=fotabla><tr><td>

	<?php 
	$tagID=$_POST["tagID"];
	if(!isset($tagID)) $tagID="1"; ?>

	<br><br>

	<div class=cim>Tag k�lcs�nz�sei</div>

	<br>
	<a href=index.php><< M�sik tag v�laszt�sa</a>
	<br><br>

	<?php
	// ha van tag kivalasztva, ellenkezo esetben hiba
	if($tagID) {
		// a kapcsolat letrehozasahoz a connect.php be-include-olasa. minden php oldalhoz kulon kapcsolatot kell letrehozni
		include "connect.php"; 
		
		// tag adatainak lekerese
		$query="SELECT * FROM member WHERE MemberID=$tagID";
		//echo $query;
		$resultset=mysqli_query($mysqllink,$query) or die("lek�rdez�si hiba: ".mysqli_error($mysqllink));

		// ha volt ilyen azonositoju tag
		if(mysqli_affected_rows($mysqllink)>0) {
			// az adatok mentese a row nev asszociativ tombbe
			$row=mysqli_fetch_assoc($resultset);

			// tag adatainak kiirasa (nev, cim, egyenleg)
			echo "<table width=400 align=center class=tagtabla>
				<tr><td align=right width=40%><i>N�v</i></td><td><b>$row[MemberName]</b></td></tr>
				<tr><td align=right><i>C�m</i></td><td><b>$row[MemberAddress]</b></td></tr>
				<tr><td align=right><i>Egyenleg</i></td><td><b>$row[Credit]</b></td></tr>
				</table>";

			echo "<br><br>";

			//feladat: lekerdezni es betenni ide az egyenleg kiiratasat 

			// tag kolcsonzeseinek lekerdezese
			$query_kolcs="SELECT titles.*,lending.DateStart,(lending.DateStart + INTERVAL 15 DAY) as DateEnd FROM lending,titles WHERE lending.ISBN=titles.ISBN AND lending.MemberID=$tagID";
			//echo $query_kolcs;
			$resultset_kolcs=mysqli_query($mysqllink,$query_kolcs) or die("lek�rdez�si hiba: ".mysqli_error($mysqllink));

			// kolcsonzesek szamanak kiiratasa
			echo "<center><b>K�lcs�nz�sek sz�ma: ".mysqli_affected_rows($mysqllink)."</b></center><br>";

			// ha volt kolcsonzese
			if(mysqli_affected_rows($mysqllink)>0) {

				// a visszahozashoz a form kezdese, ami tartalmazni fogja a tag azonositojat, valamint a beixelt konyvek ISBN szamat
				echo "<form action=visszahoz.php method=post name=visszahoz>
					<input type=hidden name=tagID value=$tagID>
					<table width=95% align=center class=kolcstabla>
					<tr>
						<td width=20>&nbsp;</td>
						<td><b>C�m</b></td>
						<td><b>Kik�lcs�nz�s d�tuma</b></td>
						<td><b>Visszahozatal (tervezett)<br>d�tuma</b></td>
					</tr>";
		
				// while ciklus vegig a kolcsonzesek adatain (konyv adatai, kolcsonzes adatai)
				$i=0;
				while($row2=mysqli_fetch_assoc($resultset_kolcs)) {
					echo "<tr>
						<td width=20><input type=checkbox class=checkbox name=kolcs[$i] value=\"$row2[ISBN]\"></td>
						<td>$row2[Title]</td>
						<td>$row2[DateStart]</td>
						<td>$row2[DateEnd]</td>
					</tr>";
					$i++;
				}
		
				echo "</table>
					<br>
					<center><input type=submit value=\"Kijel�ltek visszahozva\" class=submitbutton></center>
					</form>";
			}
			// ha a tagnak van legalabb 10kr egyenlege, akkor kolcsonozhet
			if($row["Credit"]>=10) {
				echo "<center><form action=kolcsonoz.php method=post>
					<input type=hidden name=tagID value=$tagID>
					<input type=submit value=\"K�nyv k�lcs�nz�se\" class=submitbutton>
					</form></center>";
			}
			else { //nincs eleg egyenlege, nem kolcsonozhet
				echo "<div align=center class=hiba>A tag nem k�lcs�n�zhet, mert egyenlege nem engedi!</div>";
			}

		}
		else { //nem adott vissza semmit a lekerdezes
			echo "<div align=center class=hiba>nincs ilyen azonos�t�val rendelkezo tag ($tag)</div>";
		}
		mysqli_close($mysqllink);
	}
	else { //tagID valtozonak nincs erteke
		echo "<div align=center class=hiba>nincs azonos�t� megadva</div>";
		echo "<a href=index.php><< Tag kiv�laszt�s�hoz</a>";
	}

	?>

</td></tr></table>
</body>
</html>