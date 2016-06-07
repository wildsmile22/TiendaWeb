<?php
$host = "localhost"; //database location
$user = "root"; //database username
$pass = ""; //database password
$db_name = "Tienda"; //database name
//database connection
$link = mysql_connect($host, $user, $pass) or
    die("No ha sido posible conectarse: " . mysql_error());
mysql_select_db($db_name);
?>