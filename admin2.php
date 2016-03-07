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

		
	}
	else { //moziID valtozonak nincs erteke
		echo "<div align=center class=hiba>nincs azonosító megadva</div>";
		echo "<a href=admin.php><< Jelentkezzen be!</a>";
	}

	?>


</td></tr></table>

</body>
</html>