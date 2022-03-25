<?php
require_once("diccionarios.php");
require_once("validaciones.php");
require_once('db_config.php');
require_once('consultas.php');

if(mkdir ("./media", "0777")){
	echo "Directory created";
}
$target_dir = "media/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower($_FILES["fileToUpload"]["type"]);
//******* NO MODIFIQUÉ LOS MENSAJES, supongo que no descuenta?
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed."; 
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


$errores = array();
if(!checkName($_POST)){
	$errores[] = "No entregó su nombre.";
}
if(!checkMasa($_POST)){
	$errores[] = "Seleccione masa.";
}
if(!checkIngredientes($_POST)){
	$errores[] = "Seleccione ingredientes.";
}
if(count($errores)>0){//Si el arreglo $errores tiene elementos, debemos mostrar el error.
	header("Location: index.php?errores=".implode($errores, "<br>"));//Redirigimos al formulario inicio con los errores encontrados
	return; //No dejamos que continue la ejecución
}
//Si llegamos aqui, las validaciones pasaron
$nombre = $_POST['nombre'];
$tipo_masa = getTipoMasa($_POST['masa']);
$ingredientes = getIngredientes($_POST['ingredientes']);
$direccion = $_POST['direccion'];
$comuna = getComuna($_POST['comunas']);
$costo = count($_POST['ingredientes'])*200;


//Guardamos en base de datos
$db = DbConfig::getConnection();
$res = saveOrder($db, $_POST['nombre'],$_POST['telefono'], $_POST['direccion'],$_POST['comunas'], $_POST['masa'], $_POST['ingredientes'], $_POST['comentario'], $costo );
$db->close();
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="taller4.css" type="text/css">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
	<h1>Confirmación pedido</h1>
	<p>
		Señor <?php echo $nombre; ?>,<br/>

		Hemos recibido su orden de una Pizza de masa <?php echo $tipo_masa; ?>. Con los siguientes ingredientes:
	</p>
	<ul>
		<?php foreach($ingredientes as $ingrediente) { ?>
		<li><?php echo $ingrediente; ?></li>
		<?php } ?>
	</ul>

	<p>Será enviado lo más pronto posible a la dirección <?php echo $direccion; ?> en la comuna de <?php echo $comuna['nombre']; ?>.</p>
	<p>¡Gracias por su preferencia!</p>
</body>
</html>