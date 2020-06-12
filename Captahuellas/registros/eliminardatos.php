<?php 
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	require '../conexion.php';
	$conexion->set_charset('utf8');

	// TOMAMOS EL NOMBRE DE LA TABLA DE DATOS A CONSULTAR
	$tabla = $conexion->real_escape_string($_POST['tabla']);
	// TOMAMOS EL NOMBRE DEL PARAMETRO A COSNULTAR
	$atributo = $conexion->real_escape_string($_POST['atributo']);
	// TOMAMOS EL ATRIBUTO A ACTUALIZAR
	$atributoSET= $conexion->real_escape_string($_POST['atributoSET']);
	// TOMAMOS EL ID DE LA VARIABLE A CONSULTAR 
	$id = $conexion->real_escape_string($_POST['id']);
	// TOMAMOS EL ID DE LA VARIABLE A CONSULTAR 
	$testigo = $conexion->real_escape_string($_POST['testigo']);
	// TOMAMOS EL TIPO DE ELIMINACION
	$intencion = $conexion->real_escape_string($_POST['intencion']);



	$actualizar = $conexion->prepare("UPDATE ".$tabla." SET ".$atributoSET." = '".$intencion."' WHERE ".$atributo." = '$id' ");
	$actualizar->execute();
	$resultado = $actualizar->get_result();
	if(isset($resultado)){
		session_start();
		if($intencion == 'eliminado'){
			$movimiento = "eliminar_".$tabla;
			if($tabla == 'faltas'){
				actualizar_faltas($id, $conexion);
			}
		} else if($intencion == 'descartado'){
			$movimiento = "descartar".$tabla;
		} else if($intencion == 'bloqueado'){
			$movimiento = "bloquear_".$tabla;
		}else if($intencion == 'desbloqueado'){
			$movimiento = "desbloquear_".$tabla;
		}

		$insertar_vitacora = $conexion->prepare("INSERT INTO vitacora (admin, movimiento, testigo) VALUES ('".$_SESSION['correo']."','$movimiento','$testigo')");
		$insertar_vitacora->execute();
		echo json_encode(array('error'=> false, 'id' => $id, 'tabla' => $tabla));
	} else {
		echo json_encode(array('error'=> true));
	}
}

function actualizar_faltas($id, $conexion){
	require 'consultar.php';
	$resultado = consultar($conexion, "*" , "faltas", "id_falta", $id, "=", "", "", "");
	$falta = $resultado->fetch_assoc();


	$id_huella = $falta['id_personal'];
	$cantidad_falta = $falta['cantidad'];

	$resultado_personal = consultar($conexion, "*" , "personal", "id_huella", $id_huella, "=", "", "", "");
	$personal = $resultado_personal->fetch_assoc();	

	$faltas_anteriores = $personal['faltas'];

	$resta_falta = $faltas_anteriores-$cantidad_falta;


	$actualizar_personal = $conexion->prepare("UPDATE personal SET faltas = '$resta_falta' WHERE id_huella = '$id_huella' ");
	$actualizar_personal->execute();
}

?>