<?php 

// Esta es la funcion de la consulta del user info, esta funcion sera utilizada para traer
// informacion del user info a la table de registro
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	$accion = $_POST['accion'];
	if($accion == "extraer_userinfo"){
		extraer_userinfo();
	}
	if($accion ==  "extraer_entradas"){
		extraer_entradas();
	}
}


// Esta funcion sera utilizada para extraer la informacion del usuario // 
function extraer_userinfo(){
	// establecemos conexion con access
	require '../conexionAccess.php';
	// Ejecutamos la sentencia //
	$sql = "SELECT Userid , Name FROM Userinfo";

	$aconexion = conectar('../Att2003.mdb');
	// Indicamos la direccion del archivo
	$rs = odbc_exec($aconexion, $sql);

	require '../conexion.php';

	$array_id = []; // ARREGLO PARA ID
	$array_nombre = []; // ARREGLO PARA  NOMBRE
	$i = 0;// INCREMENTADOR
	while(odbc_fetch_row($rs)){

		$id = odbc_result($rs, "Userid");
		$nombre = odbc_result($rs, "Name");

		// consultamos en mysql para revisar existencia //
		$consultarpersonal = $conexion->prepare("SELECT * FROM personal WHERE id_huella = '$id' ");
		$consultarpersonal->execute();
		$resultado = $consultarpersonal->get_result();

		// validamos que el personal no se encuentre registrado //
		if($resultado->num_rows == 0){
			$array_id[$i] = $id;
			$array_nombre[$i] = $nombre; 

			//Insertamos registro en espera //
			if($registrar_personal = $conexion->prepare("INSERT INTO personal (id_huella, nombre, estado) VALUES ('$id', '$nombre', 'esperando') ")){
				$registrar_personal->execute();
				$i++;
			}
		}

	} // End del while

	echo json_encode(array('id'=> $array_id , 'nombre' => $array_nombre));

	$conexion->close(); // CERRAMOS CONEXION MYSQL
	odbc_close($aconexion); // CERRAMOS CONEXION CON ACCESS
}

function extraer_entradas(){

	// establecemos conexion con access
	require '../conexionAccess.php';

	// Ejecutamos la sentencia //
	$sql = "SELECT Logid, Userid , CheckTime FROM Checkinout ORDER BY Logid DESC";

	$aconexion = conectar('../Att2003.mdb');
	// Indicamos la direccion del archivo
	$rs = odbc_exec($aconexion, $sql);

	require '../conexion.php';

	// PARA CONSULTAS OPTIMAS
	require '../registros/consultar.php';

	// ARRAYS A LLEVAR 
	$nombre = [];
	$foto = [];
	$cargo = [];
	$fecha_hora = [];
	$cedula = [];
	$estado = [];
	$bloqueo = [];
	$faltas = [];
	$i = 0;
	while(odbc_fetch_row($rs)){
		$logid= odbc_result($rs,"Logid");
		$userid = odbc_result($rs, "Userid");
		$hora_fecha = odbc_result($rs, "Checktime");

		// validamos que el personal no se encuentre registrado //
		$consultar_historico = $conexion->prepare("SELECT * FROM historico_huella WHERE Logid = '$logid' ");
		$consultar_historico->execute();
		$resultado = $consultar_historico->get_result();
		if($resultado->num_rows == 0){
	
			// CONSULTAMOS EL NOMBRE DEL PERSONAL PARA EL AJAX //
			$resultado_consulta = consultar($conexion, "*", 'personal', 'id_huella', $userid, '=', "", "", "");
			$personal = $resultado_consulta->fetch_assoc();

			// CONSULTAMOS EL CARGO DE LA PERSONA //
			$resultado_cargo = consultar($conexion, "icono", 'cargo', 'id_cargo', $personal['cargo'], '=', "", "", "");
			$query_cargo = $resultado_cargo->fetch_assoc();

			// DEFINIMOS SI EL PERSONAL ESTA ENTRANDO O ESTA SALIENDO //
			$entro_salio[$i] = $personal['entro_salio'];
			if($entro_salio[$i] == 'salio'){
				$entro_salio_insert = 'entro';
				$actualizar_personal = $conexion->prepare("UPDATE personal SET entro_salio = 'entro' WHERE id_huella = '$userid' ");
			} else if($entro_salio[$i] == 'entro') {
				$entro_salio_insert = 'salio';
				$actualizar_personal = $conexion->prepare("UPDATE personal SET entro_salio = 'salio' WHERE id_huella = '$userid' ");
			}
			$actualizar_personal->execute();

			$insertar_historico = $conexion->prepare("INSERT INTO historico_huella (Logid, id_huella, fecha_entrada, entro_salio) VALUES ('$logid', '$userid', '$hora_fecha', '$entro_salio_insert') ");
			$insertar_historico->execute();

			// GUARDAMOS EN EL ARREGLO //
			$id_personal[$i] = $personal['id_personal'];
			$nombre[$i] = $personal['nombre'];
			$foto[$i] = $personal['foto'];
			$cargo[$i] = $query_cargo['icono'];
			$fecha_hora[$i] = $hora_fecha;
			$cedula[$i] = $personal['cedula'];
			$bloqueo[$i] = $personal['bloqueado']; 
			$faltas[$i] = $personal['faltas'];

			$i++;
		}
	}

	if($i > 0){
		echo json_encode(array('error' => false, 'nombre' => $nombre, 'foto' => $foto, 'cargo'=> $cargo, 'fecha_hora'=> $fecha_hora, 'cedula' => $cedula, 'bloqueo' => $bloqueo, 'faltas'=>$faltas, 'id_personal'=> $id_personal, 'entro_salio' => $entro_salio, 'num_entradas' => $i));
	} else{
		echo json_encode(array('error' => true, 'num_entradas' => $i));
	}

	$conexion->close(); // CERRAMOS CONEXION MYSQL
	odbc_close($aconexion); // CERRAMOS CONEXION CON ACCESS
}
 ?>


