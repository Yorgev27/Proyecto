<?php 

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){

	require '../conexion.php';
	$conexion->set_charset('utf8');

	$metodo = $_POST['metodo'];
	if($metodo == 'editarcargo'){
		editcargo($conexion);
	} 
	if($metodo == 'editarPersona'){
		editarPersona($conexion);
	}
	
	$conexion->close();
}


// ESTA FUNCION ES UTLIZADA PARA EDITAR EL CARGO
function editcargo($conexion){
	$idcargo = $conexion->real_escape_string($_POST['id_cargo']);
	$nombreCargo = $conexion->real_escape_string($_POST['nombreCargo']);
	$numFaltas = $conexion->real_escape_string($_POST['numeroFaltas']);
	$icono = $conexion->real_escape_string($_POST['pack_nuevocargo']);

	$consultar_cargo = $conexion->prepare("SELECT * FROM cargo WHERE id_cargo = '$idcargo' ");
	$consultar_cargo->execute();
	$resultado = $consultar_cargo->get_result();
	if($resultado->num_rows > 0){
		session_start();
		if($editar_cargo = $conexion->prepare("UPDATE cargo SET nombre = '$nombreCargo', icono = '$icono', max_faltas = '$numFaltas', editado_por = '".$_SESSION['correo']."', fecha_edicion = now() WHERE id_cargo = '$idcargo'")){
			$editar_cargo->execute();
			$resultado = $editar_cargo->get_result();
			if(isset($resultado)){
				echo json_encode(array('error'=> false));

				$insertar_vitacora = $conexion->prepare("INSERT INTO vitacora (admin, movimiento, testigo) VALUES ('".$_SESSION['correo']."','editar_cargo','$nombreCargo')");
				$insertar_vitacora->execute();
			} else {
				echo json_encode(array('error'=> true));
			}
			$editar_cargo->close();
		}
	} else {
		echo json_encode(array('error'=> true));
	}
	$consultar_cargo->close();
}

 ?>

