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
	$tagID=$_POST["tagID"];
	$cimresz=$_POST["cimresz"];
	$select=$_POST["select"];
	$nyelv=$_POST["nyelv"];
	
	
	if(!isset($tagID)) $tagID="";
	if(!isset($select)) $select="";
	if(!isset($nyelv)) $nyelv="";
	if(!isset($cimresz)) $cimresz="";	?>

	<?php
	
	// a kapcsolat letrehozasahoz a connect.php be-include-olasa. minden php oldalhoz kulon kapcsolatot kell letrehozni
	include "connect.php"; 
	
	//menü
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
	<table width=95% align=center class=filmtabla>
		<form action=filmek.php method=post name=filmkeres>
			<input type=hidden name=tagID value=$tagID>
			<tr>
				<td align=right>cím:</td>
				<td align=left><input type=text maxlength=50 name=cimresz value="; echo $cimresz; echo "></td>
				<td align=right>technika:</td>
				<td align=left>
						<select name=select size=1>
							<option value=0 selected></option>
							<option value=2D>2D</option>
							<option value=3D>3D</option>
						</select>
				</td>
				<td align=right>nyelve:</td>
				<td align=left><input type=text maxlength=50 name=nyelv value="; echo $nyelv; echo "></td>
				<td align=right><input type=submit value=keres class=submitbutton3></td>
			</tr>		
		</form>
	</table><br>";
	
	//filmek listázása
	$query;
	if($cimresz and !$select and !$nyelv){
	 	$query=" select * from Film f inner join Vetites v on f.film_id=v.film_id where CURDATE()<vetites_datum and f.film_cim like '%$cimresz%' group by f.film_id order by film_cim";
	}
	elseif(!$cimresz and $select and !$nyelv){
	 	$query=" select * from Film f inner join Vetites v on f.film_id=v.film_id where CURDATE()<vetites_datum and f.technika='$select' group by f.film_id order by film_cim";
	}
	elseif(!$cimresz and !$select and $nyelv){
	 	$query=" select * from Film f inner join Vetites v on f.film_id=v.film_id where CURDATE()<vetites_datum and f.film_nyelve like '$nyelv%' group by f.film_id order by film_cim";
	}
	elseif(!$cimresz and $select and $nyelv){
	 	$query=" select * from Film f inner join Vetites v on f.film_id=v.film_id where CURDATE()<vetites_datum and f.technika='$select' and f.film_nyelve like '$nyelv%' group by f.film_id order by film_cim";
	}
	elseif($cimresz and !$select and $nyelv){
	 	$query=" select * from Film f inner join Vetites v on f.film_id=v.film_id where CURDATE()<vetites_datum and f.film_nyelve like '$nyelv%' and f.film_cim like '%$cimresz%' group by f.film_id order by film_cim";
	}
	elseif($cimresz and $select and !$nyelv){
	 	$query=" select * from Film f inner join Vetites v on f.film_id=v.film_id where CURDATE()<vetites_datum and f.technika='$select' and f.film_cim like '%$cimresz%' group by f.film_id order by film_cim";
	}
	elseif($cimresz and $select and $nyelv){
	 	$query=" select * from Film f inner join Vetites v on f.film_id=v.film_id where CURDATE()<vetites_datum and f.film_cim like '%$cimresz%' and f.technika='$select' and f.film_nyelve like '$nyelv%' group by f.film_id order by film_cim";
	}
	else {
		$query=" select * from Film f inner join Vetites v on f.film_id=v.film_id where CURDATE()<vetites_datum group by f.film_id order by film_cim";
	}
	//echo $query_kolcs;
	$resultset=mysqli_query($mysqllink,$query) or die("lekérdezési hiba: ".mysqli_error($mysqllink));


	// ha van film
	if(mysqli_affected_rows($mysqllink)>0) {

		// while ciklus vegig a filmeken
		echo "<table width=95% align=center class=filmtabla>
			<tr><td align=center>cím</td><td align=center>megjelenés<br>éve</td><td align=center>nyelve</td><td align=center>technika</td><td>&nbsp;</td></tr>";
		$i=0;
		while($row2=mysqli_fetch_assoc($resultset)) {
			echo "<tr>
				<td align=center><form action=film.php method=post name=film>
					<input type=hidden name=filmID value=$row2[film_id]>
					<input type=hidden name=tagID value=$tagID>
					<input type=submit value='$row2[film_cim]' class=submitbutton3>
				</form></td><td align=center>
					$row2[film_datum].
				</td><td align=center>
					$row2[film_nyelve]
				</td><td align=center>
					$row2[technika]
				</td><td align=center><form action=film_mozi.php method=post name=jegyfoglalas>
					<input type=hidden name=filmID value=$row2[film_id]>
					<input type=hidden name=tagID value=$tagID>
					<input type=submit value=jegyfoglalás class=submitbutton3>
				</form></td>
			</tr>";
			$i++;
		}
		echo "</table>";
	}
	
	else { //nem adott vissza semmit a lekerdezes
		echo "<div align=center class=hiba>Egyetlen film sem felelet meg a keresési feltételeknek</div>";
	}
	mysqli_close($mysqllink);

	?>


</td></tr></table>

</body>
</html>