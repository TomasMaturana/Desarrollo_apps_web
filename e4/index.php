<?php
date_default_timezone_set('America/Santiago');
if (isset($_COOKIE['contador'])) {
	$contador=$_COOKIE['contador'] +1;
}
else{
	$contador=1;
}
$fecha = date('l jS \of F Y h:i:s A');
setcookie("fecha", $fecha);
setcookie("contador", $contador);

foreach ($_COOKIE as $name => $value) {
	if($name != "contador" && $name != "fecha"){
		setcookie($name, $value, time() - 3600);
	}
}
?>
<!DOCTYPE html>

    <head>
        <meta charset="utf-8">
		<html lang="es">
        <title>Ejercicio 4</title>
    </head>
    
<body>

<?php
if (isset($_COOKIE['fecha'])) {
	echo "Fecha: ". $_COOKIE['fecha'];
}
?>
<br>
<?php
if (isset($_COOKIE['contador'])) {
	echo "Contador: ". $_COOKIE['contador'];
}
?>

</body>
</html>