<html>
<head>
<title>MoziVilág</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2">
<link rel="stylesheet" href="biblio.css" type="text/css">
<script language="JavaScript" src="biblio.js"></script>
</head>

<body bgcolor="#FFFFFF" text="#000000" link="#AAAAAA" vlink="#AAAAAA" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table bgcolor="#99FFCC" width=700 border=0 align=center class=fotabla><tr><td>

	<?php 
	$filmID=$_POST['filmID'];
	$tagID=$_POST['tagID'];

	
	if(!isset($filmID)) $filmID="";
	if(!isset($tagID)) $tagID="";	?>


	<?php
	if($filmID) {
		// a kapcsolat letrehozasahoz a connect.php be-include-olasa. minden php oldalhoz kulon kapcsolatot kell letrehozni
		include "connect.php";
		
		echo "<table width=400 align=center>
		<tr>";
		if($tagID) {
			echo "<td>
			<form action=index.php method=post name=film>
			<input type=submit value=kilépés class=submitbutton2>
			</form>
			</td>";
		}
		else {
			echo "<td>
			<form action=login.php method=post name=film>
			<input type=submit value=belépés class=submitbutton2>
			</form>
			</td>";
		}
		echo "<td>
			<form action=filmek.php method=post name=film>
			<input type=hidden name=tagID value=$tagID>
			<input type=submit value=filmek class=submitbutton2>
			</form>
		</td><td>
			<form action=menu.php method=post name=vetites>
			<input type=hidden name=tagID value=$tagID>
			<input type=submit value=moziműsor class=submitbutton2>
			</form>
		</td>";
		if($tagID) {
			echo "<td>
				<form action=menu.php method=post name=vetites>
				<input type=hidden name=tagID value=$tagID>
				<input type=submit value=jegyeim class=submitbutton2>
				</form>
			</td>";
		}
		echo "</tr>
		</table>
		<br><br>
		<div class=cim2>MoziVilág</div>
		<br><br>
		<div align=center>Vállasszon mozit!</div>
		<br>";
	
		// tag lekerdezese adatbazisbol
		$query="select distinct m.mozi_nev, m.mozi_id from  Vetites v inner join Mozi m on v.mozi_id=m.mozi_id where CURDATE()<vetites_datum and v.film_id='$filmID' order by mozi_nev";
		//echo $query;
		$resultset=mysqli_query($mysqllink,$query) or die("lekérdezési hiba: ".mysqli_error());

		// ha legalabb 1 tagot eredmenyezett a lekerdezes
		if(mysqli_affected_rows($mysqllink)>0) {

			// while ciklus vegig a filmeken
			echo "<table width=95% align=center class=filmtabla>";
			$i=0;
			while($row2=mysqli_fetch_assoc($resultset)) {
				echo "<tr>
					<td align=center><form action=film_mozi_vetites.php method=post name=film>
						<input type=hidden name=moziID value=$row2[mozi_id]>
						<input type=hidden name=filmID value=$filmID>
						<input type=hidden name=tagID value=$tagID>
						<input type=submit value='$row2[mozi_nev]' class=submitbutton3>
					</form></td>
				</tr>";
				$i++;
			}
			echo "</table>";
		}
		else {
			echo "<div align=center class=hiba>nincs ilyen azonosítóval rendelkező tag ($tag)</div>";
		}
	}
	?>

</td></tr></table>

</body>
</html>