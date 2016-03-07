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
	$foglal=$_POST['foglal'];
	$tagID=$_POST['tagID'];
	$vetitesID=$_POST['vetitesID'];
	
	if(!isset($vetitesID)) $vetitesID="";
	if(!isset($foglal)) $foglal="";
	if(!isset($tagID)) $tagID=""; ?>

	<br><br>

	<div class=cim>MoziVilág</div>
	<br><br>
	<div class=cim>Visszaigazolás</div>
	<br><br>

	<?php
	print_r($_POST); //debug
	// ha van tag kivalasztva, ellenkezo esetben hiba
	if($vetitesID) {
		// a kapcsolat letrehozasahoz a connect.php be-include-olasa. minden php oldalhoz kulon kapcsolatot kell letrehozni
		include "connect.php";

		print_r($_POST); //debug
		$buntetes=0;  //ebben gyujtjuk a buntetest, 15 napon tul tullepett naponkent 5 kr, ennek tesztelese tabla-editalassal lehetseges

		if(is_array($foglal)) { // ha nem volt beixelve semmi, akkor ez nem teljesul
		$cim;
		$mozi;
		$jegyar;
		$db=0;
			$query_adatok="select * from Vetites v inner join  Film f on v.film_id=f.film_id inner join Mozi m on v.mozi_id=m.mozi_id where vetites_id=$vetitesID";
			//echo $query_adatok;
			$resultset=mysqli_query($mysqllink,$query_adatok) or die("lekérdezési hiba: ".mysqli_error($mysqllink));
			if(mysqli_affected_rows($mysqllink)>0){
				$row=mysqli_fetch_assoc($resultset);
				$cim=$row[film_cim];
				$mozi=$row[mozi_nev];
				$jegyar=$row[jegyar];
			}
						
			foreach($foglal as $sor=>$e) {
				foreach($e as $szek=>$value){
					$query_insert="INSERT INTO Jegy (vetites_id, vendeg_id, sor, szek, vasarlas_datum) VALUES ($vetitesID, $tagID, $sor, $szek, CURDATE())";
					//echo $query_insert;
					$resultset=mysqli_query($mysqllink,$query_insert) or die("lekérdezési hiba: ".mysqli_error($mysqllink));
					if(mysqli_affected_rows($mysqllink)>0){
						$db++;
						$aktszek=$szek+1;
						$aktsor=$sor+1;
						echo "
						<table width=95% border=0 align=center class=jegytabla>
							<tr>
								<td><div class=cim>MoziVilág</div></td>
							</tr><tr>
								<td align=center>$mozi</td>
								<td align=center>$cim</td>
							</tr><tr>
								<td></td>
								<td color=Grey align=center>film cím</td>
							</tr><tr>
								<td>sor: $aktsor szék: $aktszek</td>
								<td>jegyar: $jegyar</td>
							<\tr>
						</table>";
					}
				}
			}
			$ar=$db*$jegyar;
			echo " <br><div align=center class=hiba>A jegyek átvételekor fizetendő: $ar<div>";

		//	if($buntetes>0) { // levonjuk az egyenlegebol, nem baj ha minusz lesz
		//	}
		}

		echo "<br><br><form action=menu.php method=post>
			<input type=hidden name=tagID value=$tagID>
			<input type=submit value=\"Vissza a tag oldalára\" class=submitbutton3>
			</form><br><br>";

		mysqli_close($mysqllink);

	}
	else { //tagID valtozonak nincs erteke
		echo "<div align=center class=hiba>nincs azonosító megadva</div>";
		echo "<a href=index.php><< Tag kiválasztásához</a>";
	}
	?>

</td></tr></table>

</body>
</html>