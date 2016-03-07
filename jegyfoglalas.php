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
	$vetitesID=$_POST['vetitesID'];
	$tagID=$_POST['tagID'];
	
	$sor=0;
	$szek=0;
	$foglalt;

	//echo "$vetitesID";
	
	if(!isset($vetitesID)) $vetitesID="";
	if(!isset($tagID)) $tagID="";	?>


	<?php
	if($vetitesID) {
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
			<form action=login2.php method=post name=film>
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
		";
		
		
		// tag lekerdezese adatbazisbol
		$query="select * from  Vetites v inner join Mozi m on v.mozi_id=m.mozi_id where v.vetites_id='$vetitesID'";
		//echo $query;
		$resultset=mysqli_query($mysqllink,$query) or die("lekérdezési hiba: ".mysqli_error());
		
		//echo "<center><b>Filmek száma: ".mysqli_affected_rows($mysqllink)."</b></center><br>";

		// ha legalabb 1 tagot eredmenyezett a lekerdezes
		if(mysqli_affected_rows($mysqllink)>0) {
			$row=mysqli_fetch_assoc($resultset);
			$sor=$row[sorok_szama];
			$szek=$row[helyek_szama];
			
			//echo "$sor, $szek";
			for($i=0; $i<$sor; $i++) {
				for ($j=0; $j<$szek; $j++) {
					$foglalt[$i][$j]=0;
				}
			}
		}
		
		// tag lekerdezese adatbazisbol
		$query="select * from  Jegy where vetites_id='$vetitesID'";
		//echo $query;
		$resultset=mysqli_query($mysqllink,$query) or die("lekérdezési hiba: ".mysqli_error());
		$szabad=mysqli_affected_rows($mysqllink);
		$szabad=$sor*$szek-$szabad;
		echo "<center><b>Szabad helyek száma: $szabad</b></center><br>
			<div align=center>Vállasszon széket!</div>
			<br>";

		// ha legalabb 1 tagot eredmenyezett a lekerdezes
		if(mysqli_affected_rows($mysqllink)>0) {
			
			// while ciklus végig a jegyeken, a foglaltakat beállítja
			while($row2=mysqli_fetch_assoc($resultset)) {
				$foglalt[$row2[sor]][$row2[szek]]=1;
			}
		}
			echo "<table width=95% align=center class=vaszontabla><tr><td></td></tr> </tabla>";
				if($tagID){
					echo "<form action=jegyfoglalas_igazolas.php method=post name=foglal>";
				}
				else{
					echo "<form action=login2.php method=post name=foglal2>";
				}
				echo "<input type=hidden name=tagID value=$tagID>
				<input type=hidden name=vetitesID value=$vetitesID>
				<table width=95% align=center class=filmtabla><br>";
			$k=1;
			foreach($foglalt as $key => $value){
				echo "<tr><td> $k </td>";
				foreach($value as $key1 => $value1){
					$ertek=$key*$szek+$key1;
					if($value1){					
						echo "<td> <input type=checkbox class=checkbox1 name=foglal[$key][$key1] value=$ertek disabled> </td>";
					}
					else {
						echo "<td> <input type=checkbox class=checkbox2 name=foglal[$key][$key1] value=$ertek>  </td>";
					}
				}
				echo "<td> $k </td></tr>";
				$k++;
			}
			echo "<tr><td></td>";
			for($i=1; $i<=$szek; $i++){
				echo"<td align=center >$i</td>";
			}
			echo "</tr></table>
				<br>";
				if($tagID){
						echo "<center><input type=submit value=\"Lefoglal\" class=submitbutton3></center>";
					}
					else{
						echo "<center><input type=submit value=\"bejelentkjezés\" class=submitbutton3></center>";
					}
				echo "</form>";
	}
	?>

</td></tr></table>

</body>
</html>