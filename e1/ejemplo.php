<?php

// Conectando y seleccionado la base de datos  
$dbconn = new mysqli("127.0.0.1", "cc5002", "cc5002", "world")
		or die('No se ha podido conectar: ' . $mysqli->connect_error);
$dbconn->set_charset("utf8");

?>

<!DOCTYPE html>
<html>
 <head>
  <title>Ejercicio 1</title>
 </head>
 
 <body>
 <h1>Ciudades pertenecientes a Japón cuya población es mayor a 20000 habitantes:</h1>
<?php
$query = "SELECT Name FROM city WHERE CountryCode='JPN' AND Population>20000";
$result = $dbconn->query($query);
if ($result->num_rows > 0){
	echo "<table border=1>\n";
	echo "\t<tr><td><b>Ciudad</b></td></tr>\n";
	while ($row = $result->fetch_row()) {
		echo "\t<tr>\n";
		echo "\t\t<td>$row[0]</td>\n";
		echo "\t</tr>\n";
	}
	echo "</table>\n";
}
?>

<h1>Nombre de los países, junto a sus idiomas oficiales y sus porcentajes.</h1>
<?php
$query = "SELECT Name, Language, Percentage FROM country INNER JOIN countrylanguage ON country.Code = countrylanguage.CountryCode WHERE IsOfficial='T'";
$result = $dbconn->query($query);
if ($result->num_rows > 0){
	echo "<table border=1>\n";
	echo "\t<tr><td><b>País</b></td><td><b>Idioma</b></td><td><b>Porcentaje</b></td></tr>\n";
	while ($row = $result->fetch_row()) {
		echo "\t<tr>\n";
		echo "\t\t<td>$row[0]</td><td>$row[1]</td><td>$row[2]</td>\n";
		echo "\t</tr>\n";
	}
	echo "</table>\n";
}

$dbconn->close();
?>
</body>
</html>

