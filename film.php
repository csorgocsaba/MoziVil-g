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

	<br><br>


	<br><br>


	<?php
	if($filmID) {
		// a kapcsolat letrehozasahoz a connect.php be-include-olasa. minden php oldalhoz kulon kapcsolatot kell letrehozni
		include "connect.php";

		// tag lekerdezese adatbazisbol
		$query="SELECT * FROM Film WHERE film_id='$filmID'";
		//echo $query;
		$resultset=mysqli_query($mysqllink,$query) or die("lekérdezési hiba: ".mysqli_error());

		// ha legalabb 1 tagot eredmenyezett a lekerdezes
		if(mysqli_affected_rows($mysqllink)>0) {

			// az elso tag rekordjanak betoltese a row valtozoba
			$row=mysqli_fetch_assoc($resultset);

			// a tag adatainak kiiratasa tablazatos formaban, a kivalasztashoz egy form a tag id-jevel, egy hidden input mezoben
			echo "<div class=cim>$row[film_cim]</div>
			
				<table width=400 align=center class=tagtabla>
				<tr><td align=left>$row[plot]</td></tr>					
				</table><br>
				
				<form action=filmek.php method=post>
					<input type=hidden name=tagID value=$tagID>
					<center><input type=submit value=vissza class=submitbutton3></center>
					</form>";
		}
		else {
			echo "<div align=center class=hiba>nincs ilyen azonosítóval rendelkező tag ($tag)</div>";
		}
	}
	?>

</td></tr></table>

</body>
</html>