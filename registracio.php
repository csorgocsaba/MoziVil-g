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
	$tag=$_POST['tag'];
	$pw=$_POST['pw'];
	$egyenleg=15000;
	
	if(!isset($tag)) $tag="";
	//if(!isset($pw)) $pw="";	?>

	<br><br>

	<div class=cim2>MoziVilág - Regisztráció</div>

	<br><br>

	<!-- a tagot kivalaszto form, a tag erteket a php beallitja -->

	<form action=registracio.php method=post name=tag>

	<table width=400 align=center>
	<tr><td align=right width=40%>felhasználónév:</td><td><input type=text maxlength=12 name=tag value=<?php echo $tag; ?>></td></tr>
	<tr><td align=right width=40%>jelszó:</td><td><input type=password maxlength=12 name=pw value=<?php echo $pw; ?>></td></tr>
	<tr><td>&nbsp;</td><td><input type=submit value=regisztrálok class=submitbutton3></td></tr>
	</table>

	</form>

	<?php
	if($tag) {
		// a kapcsolat letrehozasahoz a connect.php be-include-olasa. minden php oldalhoz kulon kapcsolatot kell letrehozni
		include "connect.php";

		// tag lekerdezese adatbazisbol
		$query="INSERT INTO Vendeg (vendeg_id, vendeg_login, vendeg_pw, egyenleg) VALUES (NULL, '$tag', '$pw', $egyenleg)";
		//echo $query;
		$resultset1=mysqli_query($mysqllink,$query) or die("lekérdezési hiba: ".mysqli_error());
		
		// tag lekerdezese adatbazisbol
		$query="SELECT * FROM Vendeg WHERE vendeg_login='$tag' AND vendeg_pw='$pw'";
		//echo $query;
		$resultset=mysqli_query($mysqllink,$query) or die("lekérdezési hiba: ".mysqli_error());
		
		// ha legalabb 1 tagot eredmenyezett a lekerdezes
		if(mysqli_affected_rows($mysqllink)>0) { 

// az elso tag rekordjanak betoltese a row valtozoba
			$row=mysqli_fetch_assoc($resultset);

			// a tag adatainak kiiratasa tablazatos formaban, a kivalasztashoz egy form a tag id-jevel, egy hidden input mezoben
			echo "<div align=center class=hiba>Sikeres bejelentkezés</div>";
			echo "
			<form action=menu.php method=post>
					<input type=hidden name=tagID value=$row[vendeg_id]>
					<table width=400 align=center>
					<tr><td align=center>
					<input type=submit value=tovább class=submitbutton3>
				
					</td></tr>
				</table>
					</form>";
		}
		else {
			echo "<div align=center class=hiba>hibás felhasználónév vagy jelszó</div>";
		}
		mysqli_close($mysqllink);	
	}
	?>

</td></tr></table>

</body>
</html>