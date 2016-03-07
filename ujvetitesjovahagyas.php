<html>
<head>
<title>MoziVilág</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2">
<link rel="stylesheet" href="biblio.css" type="text/css">
<script language="JavaScript" src="biblio.js"></script>
</head>

<body bgcolor="#FFFFFF" text="#000000" link="#AAAAAA" vlink="#AAAAAA" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width=700 border=0 align=center class=fotabla><tr><td>

	<br><br>
	
	<?php
	$radio=$_POST['radio'];
	$moziID=$_POST['moziID'];
	$datum=$_POST['datum'];
	$jegyar=$_POST['ar'];
	if(!isset($moziID)) $moziID=""; ?>


	<?php
	// ha van mozi kivalasztva, ellenkezo esetben hiba
	if($moziID) {
		// ha minden adat ki van valasztva, ellenkezo esetben hiba
		if($radio and $datum and $jegyar){
			include "connect.php"; 
			$query="INSERT INTO `Vetites`(`vetites_id`, `mozi_id`, `film_id`, `vetites_datum`, `meghirdetes_datum`, `jegyar`) VALUES (NULL, $moziID, $radio, '$datum', CURDATE(), $jegyar)";
			$resultset=mysqli_query($mysqllink,$query) or die("lekérdezési hiba a lekerdezesben: ".mysqli_error($mysqllink));
			mysqli_close($mysqllink);
			echo "<div align=center class=hiba>sikeres mentés</div>			
				<br><br><form action=ujvetites.php method=post>
				<input type=hidden name=moziID value=$moziID>
				<center><input type=submit value=\"Vissza\" class=submitbutton></center>
				</form><br><br>";
		}
		else { //valamelyik adat hianyzik
			echo "<div align=center class=hiba>nincs minden adat megadva</div>";
			echo "<a href=ujvetites.php><< vissza</a>";
		}
	}
	else { //moziID valtozonak nincs erteke
		echo "<div align=center class=hiba>nincs bejelentkezve</div>";
		echo "<a href=admin.php><< bejelentkezés</a>";
	}
	?>

</td></tr></table>

</body>
</html>