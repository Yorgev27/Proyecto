<?php 
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	require '../conexion.php';
	$conexion->set_charset('utf8');


	// TOMAMOS EL NOMBRE DE LA TABLA DE DATOS A CONSULTAR
	$tabla = $conexion->real_escape_string($_POST['tabla']);
	// TOMAMOS EL NOMBRE DEL PARAMETRO A COSNULTAR
	$atributo = $conexion->real_escape_string($_POST['atributo']);
	// TOMAMOS EL ID DE LA VARIABLE A CONSULTAR 
	$id = $conexion->real_escape_string($_POST['id']);

	$consultar_cargo = $conexion->prepare("SELECT * FROM ".$tabla." WHERE ".$atributo." = '$id' ");
	$consultar_cargo->execute();
	$resultado = $consultar_cargo->get_result();

	if($resultado->num_rows > 0){
		echo json_encode(array('existencia'=> true, 'data' => $resultado->fetch_assoc()));
	} else {
		echo json_encode(array('existencia'=> false, '_POST' => $_POST));
	}
}
 ?>
