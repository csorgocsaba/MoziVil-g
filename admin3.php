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
	$cim=$_POST["cim"];
	$ev=$_POST["ev"];
	$nyelv=$_POST["nyelv"];
	$plot=$_POST["plot"];
	$technika=$_POST["technika"];	
	$nev=$_POST["nev"];
	$sor=$_POST["sor"];
	$szek=$_POST["szek"];
	$login=$_POST["login"];
	$pw=$_POST["pw"];

	if(!isset($cim)) $cim="";
	if(!isset($ev)) $ev="";
	if(!isset($nyelv)) $nyelv="";
	if(!isset($plot)) $plot="";
	if(!isset($technika)) $technika="";	
	if(!isset($nev)) $nev="";
	if(!isset($sor)) $sor="";
	if(!isset($szek)) $szek="";
	if(!isset($login)) $login="";
	if(!isset($pw)) $pw="";

		echo "<a href=admin.php><< Kilépés</a>";
		// a kapcsolat letrehozasahoz a connect.php be-include-olasa. minden php oldalhoz kulon kapcsolatot kell letrehozni
		include "connect.php"; 
		
		//menü
		echo "<<table width=95% align=center>
			<tr><td align=center><b>Új film</b></td><td align=center><b>Új mozi</b></td></tr>
			<tr><td>
				<form action=admin3.php method=post name=film>
				<table>
					<tr>
						<td align=right>Film címe:</td>
						<td align=left><input type=text maxlength=12 name=cim value= ></td>
					</tr><tr>
						<td align=right>Gyártás éve:</td>
						<td align=left><input type=text maxlength=4 name=ev value= ></td>
					</tr><tr>
						<td align=right>Film nyelve:</td>
						<td align=left><input type=text maxlength=12 name=nyelv value= ></td>
					</tr><tr>
						<td align=right>Plot:</td>
						<td align=left><textarea name=plot rows=3 cols=23></textarea></td>
					</tr><tr>
						<td align=right>Technika:</td>
						<td align=left>
							<select name=technika size=1>
							<option value=2D>2D</option>
							<option value=3D>3D</option>
							</select>
						</td>
					</tr><tr>
						<td align=right></td>
						<td align=left><input type=submit value=mentés class=submitbutton></textarea></td>
					</tr><tr>
					</tr>
				</table>
				</form>
			</td><td>
				<form action=admin3.php method=post name=mozi>
				<table>
					<tr>
						<td align=right>Mozi neve:</td>
						<td align=left><input type=text maxlength=12 name=nev value= ></td>
					</tr><tr>
						<td align=right>Sorok száma:</td>
						<td align=left><input type=text maxlength=2 name=sor value= ></td>
					</tr><tr>
						<td align=right>Székek egy sorban:</td>
						<td align=left><input type=text maxlength=2 name=szek value= ></td>
					</tr><tr>
						<td align=right>Login név::</td>
						<td align=left><input type=text maxlength=12 name=login value= ></td>
					</tr><tr>
						<td align=right>Jelszó:</td>
						<td align=left><input type=text maxlength=12 name=pw value= ></td>
					</tr><tr>
						<td align=right></td>
						<td align=left><input type=submit value=mentés class=submitbutton></textarea></td>
					</tr><tr>
					</tr>
				</table>
				</form>
			</td></tr>
		</table><br>
		";
		if($cim and $ev and	$nyelv and$plot and	$technika){
			$query="INSERT INTO Film (film_id, film_cim, film_datum, film_nyelve, plot, technika) VALUES (NULL, '$cim', '$ev',	'$nyelv', '$plot', '$technika')";
			$resultset=mysqli_query($mysqllink,$query) or die("lekérdezési hiba: ".mysqli_error($mysqllink));
			if(mysqli_affected_rows($mysqllink)>0){
				echo"<div align=center><b>Film sikeresen elmentve</b></div>";
			}
		}
		elseif($nev and	$sor and $szek and	$login and	$pw){
		$query="INSERT INTO Mozi (mozi_id, mozi_nev, sorok_szama, helyek_szama, password, mozi_login) VALUES (NULL, '$nev', '$sor', '$szek', '$login', '$pw')";
			$resultset=mysqli_query($mysqllink,$query) or die("lekérdezési hiba: ".mysqli_error($mysqllink));
			if(mysqli_affected_rows($mysqllink)>0){
				echo"<div align=center><b>Mozi sikeresen elmentve</b></div>";
			}
		}
	?>


</td></tr></table>

</body>
</html>