<?php 

// TOMAMOS LOS DATOS DE CONEXION
// DONDE DICE LOCALHOST LA CAMBIAMOS POR IP DEL SERVIDOR AL MOMENTO DE SER SUBIDO
$conexion = new mysqli('localhost', 'root', '','captahuellas');
if($conexion->connect_error){

	// EN CASO DE QUE LA CONEXION RESULTE ERRONEA SE MUESTRE EL MENSAJE //
	echo $error -> $conexion->connect_error;
}
 ?>