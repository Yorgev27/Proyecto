<?php 
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	require '../conexion.php';
	require 'consultar.php';
	$conexion->set_charset('utf8');

	$metodo = $_POST['metodo'];
	if($metodo == 'nuevocargo'){
		nuevoCargo($conexion);
	} 
	if($metodo == 'nuevapersona'){
		nuevaPersona($conexion);
	}
	if($metodo == 'nuevaFalta'){
		nuevaFalta($conexion);
	}
	
	$conexion->close();
}


function nuevoCargo($conexion){
	$nombreCargo = $conexion->real_escape_string($_POST['nombreCargo']);
	$numFaltas = $conexion->real_escape_string($_POST['numeroFaltas']);
	$icono = $conexion->real_escape_string($_POST['pack_nuevocargo']);
	session_start();
	if($insertar_cargo = $conexion->prepare("INSERT INTO cargo (nombre, icono, creado_por, max_faltas) VALUES ('$nombreCargo','$icono','".$_SESSION['correo']."','$numFaltas')")){
		$insertar_cargo->execute();
		$resultado = $insertar_cargo->get_result();
		if(isset($resultado)){
			echo json_encode(array('error'=> false));

			$insertar_vitacora = $conexion->prepare("INSERT INTO vitacora (admin, movimiento, testigo) VALUES ('".$_SESSION['correo']."','registro_cargo','$nombreCargo')");
			$insertar_vitacora->execute();
		} else {
			echo json_encode(array('error'=> true));
		}
		$insertar_cargo->close();
	}
	die;
}


//FUNCION PARA REGISTRAR UN PERSONAL DONDE SE VERIFICA LA IMAGEN
function nuevaPersona($conexion){
	$cedula = $conexion->real_escape_string($_POST['cedula']);
	$nombre = $conexion->real_escape_string($_POST['nombres']);
	$id_huella = $conexion->real_escape_string($_POST['id_huella']);
	$cargo = $conexion->real_escape_string($_POST['cargo']);
	if(!empty($_FILES['subirfoto']['name'])){
		$ruta_foto = $_FILES['subirfoto']['tmp_name'];
		$foto = $_FILES['subirfoto']['name'];

		$info = pathinfo($foto);

		$type = $info['extension'];
		$name = $id_huella.'.'.$type;
		$destino = '../fotos/'.$name;
		if(copy($ruta_foto, $destino)){
			registrar($conexion, $name, $id_huella, $nombre, $cedula, $cargo);
		}
	} else {
		$resultado = consultar($conexion, "foto", "personal" , "id_huella", $id_huella, "=", "", "", "");
		$persona = $resultado->fetch_assoc();

		$name = $persona['foto'];
		registrar($conexion, $name, $id_huella, $nombre, $cedula, $cargo);
	}
}


// FUNCION PARA REGISTRAR UN PERSONAL
function registrar($conexion, $foto, $id_huella, $nombre, $cedula, $cargo){
	if($registrar_persona = $conexion->prepare("UPDATE personal SET estado = 'activo', nombre = '$nombre', cedula = '$cedula', foto = '$foto', fecha_registro = now(), cargo = '$cargo'  WHERE id_huella = '$id_huella' ")){
		if($registrar_persona->execute()){
			echo json_encode(array('error'=> false));

			session_start();
			$insertar_vitacora = $conexion->prepare("INSERT INTO vitacora (admin, movimiento, testigo) VALUES ('".$_SESSION['correo']."','registro_personal','$nombre')");
			$insertar_vitacora->execute();
		} else {
			echo json_encode(array('error'=> true));
		}
	}

}

// FUNCION PARA REGISTRAR UNA FALTA //


// EL PARAMETRO CONEXION ES ASIGNADO POR EL CODIGO JAVASCRIPT INDICANDO QUE EXIXSTE UNA CONEXION
// CON EL SERVIDOR ESTO PARA PODER EJECUTAR INSTRUCCIONES PARA EL PHPMYADMIN EN SQL
function nuevaFalta($conexion){

	// TOMAMOS LOS PARAMETROS ENTRANTES DEL AJAX //
	$numfaltas = $conexion->real_escape_string($_POST['numfalta']); // INDICA EL NUMERO DE FALTAS
	$razon = $conexion->real_escape_string($_POST['razon']); // INDICA LA RAZON DE LA FALTA
	$id_huella = $conexion->real_escape_string($_POST['id_huella']); // INDICA EL USUARIO A SANCIONAR

	// FUNCION PARA VALIDAR LA EXISTENCIA DEL PERSONAL // 
	$resultado = consultar($conexion, "*", "personal" , "id_huella", $id_huella, "=", "", "", "");

	// SI EL PERSONAL EXISTE ENTONCES LO TOMAMOS //
	if($resultado->num_rows == 1){
		// LOS DATOS DEL PERSONAL //
		$persona = $resultado->fetch_assoc();
		// FALTAS ANTERIORES //
		$faltas_anteriores = $persona['faltas'];
		// LA SUMA DE LAS FALTAS LA NUEVA CON LA ANTERIOR
		$sumas_faltas = $faltas_anteriores+$numfaltas; 

		session_start(); // INICIAMOS SESION PARA SABER QUE ADMIN ESTA SANCIONADO //

		// INSTRUCCION PARA REGISTRAR LA FALTA //
		if($registrar_falta = $conexion->prepare("INSERT INTO faltas (id_personal, razon, cantidad, admin, estado) VALUES ('$id_huella', '$razon', '$numfaltas', '".$_SESSION['correo']."', 'activo')")){
			// EJECUTAMOS LA SETENCIA DE REGISTRAR FATA //
			$registrar_falta->execute();
			// ACTUAIZAMOS EL PERSONAL PARA AUMENTAR EL CONTADOR DE FALTAS //
			if($actualizar_falta = $conexion->prepare("UPDATE personal SET faltas = '$sumas_faltas' WHERE id_huella = '$id_huella' ")){
				// EJECUTAMOS LA SETENCIA SQL 
				$actualizar_falta->execute();

				echo json_encode(array('error'=> false, '_POST' => $_POST)); // ENVIAMOS EL RESULTADO

				// INSERTAMOS LA VITACORA 
				$insertar_vitacora = $conexion->prepare("INSERT INTO vitacora (admin, movimiento, testigo) VALUES ('".$_SESSION['correo']."','registro_faltas','$razon')");
				$insertar_vitacora->execute();
			} 
		} 
	} else {
		echo json_encode(array('error'=> true, '_POST' => $_POST)); // ENVIAMOS EL RESULTADO DEL ERROR
	}
}
 ?>




