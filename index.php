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
	// ha van mozi kivalasztva, ellenkezo esetben hiba

		// a kapcsolat letrehozasahoz a connect.php be-include-olasa. minden php oldalhoz kulon kapcsolatot kell letrehozni
		include "connect.php"; 
		
		//menü
		echo "<table width=400 align=center>
			<tr><td>
				<form action=admin.php method=post name=film>
				<input type=submit value=dolgozóknak class=submitbutton2>
				</form>
			</td><td>
				<form action=login.php method=post name=vetites>
				<input type=submit value=belépés class=submitbutton2>
				</form>
			</td><td>
				<form action=registracio.php method=post name=vetites>
				<input type=submit value=regisztráció class=submitbutton2>
				</form>
			</td></tr>
			<td></td>
		<td>
			<form action=filmek.php method=post name=film>
			<input type=submit value=filmek class=submitbutton2>
			</form>
		</td><td>
			<form action=vetiteslistaz.php method=post name=vetites>
			<input type=submit value=moziműsor class=submitbutton2>
			</form>
		</td>
		</tr>
	</table>
	<br><br>
		<div class=cim2>MoziVilág</div>
	<br><br>";	

	?>

</td></tr></table>

</body>
</html>