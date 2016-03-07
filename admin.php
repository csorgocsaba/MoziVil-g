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
	$tag=$_POST['tag'];
	$pw=$_POST['pw'];
	
	if(!isset($tag)) $tag="";
	//if(!isset($pw)) $pw="";	?>

	<br><br>

	<div class=cim>admin belépés</div>

	<br><br>

	<!-- a tagot kivalaszto form, a tag erteket a php beallitja -->

	<form action=admin.php method=post name=tag>

	<table width=400 align=center>
	<tr><td align=right width=40%>felhasználónév:</td><td><input type=text maxlength=12 name=tag value=<?php echo $tag; ?>></td></tr>
	<tr><td align=right width=40%>jelszó:</td><td><input type=password maxlength=12 name=pw value=<?php echo $pw; ?>></td></tr>
	<tr><td>&nbsp;</td><td><input type=submit value=belépés class=submitbutton></td></tr>
	</table>

	</form>

	<?php
	echo "<br><a href=index.php><< Kilépés</a><br>";
	if($tag) {
		// a kapcsolat letrehozasahoz a connect.php be-include-olasa. minden php oldalhoz kulon kapcsolatot kell letrehozni
		include "connect.php";

		// tag lekerdezese adatbazisbol
		$query="SELECT * FROM Mozi WHERE mozi_nev='$tag' AND password='$pw'";
		//echo $query;
		$resultset=mysqli_query($mysqllink,$query) or die("lekérdezési hiba: ".mysqli_error());

		// ha legalabb 1 tagot eredmenyezett a lekerdezes
		if(mysqli_affected_rows($mysqllink)>0) { 

// az elso tag rekordjanak betoltese a row valtozoba
			$row=mysqli_fetch_assoc($resultset);

			// a tag adatainak kiiratasa tablazatos formaban, a kivalasztashoz egy form a tag id-jevel, egy hidden input mezoben
			echo "<div align=center class=hiba>Sikeres bejelentkezés</div>";
			if($row[mozi_id]){
				echo "<form action=admin2.php method=post>";
			}
			else{
				echo "<form action=admin3.php method=post>";
			}
			echo "
			<form action=admin2.php method=post>
					<input type=hidden name=moziID value=$row[mozi_id]>
					<table width=400 align=center>
					<tr><td align=center>
					
					<input type=submit value=tovább class=submitbutton>
				
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