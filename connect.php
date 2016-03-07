<?php

    // az adatbazis kapcsolat parameterei
    $host="localhost";
    $user="vxcl0q";
    $pass="yutheesu";
    $db="vxcl0q";

    // adatbazis kapcsolat letrehozasa
    $mysqllink=mysqli_connect($host,$user,$pass) or die("Could not connect");

    // adatbazis kivalasztasa
    mysqli_select_db($mysqllink,$db) or die("Could not select database");

?>