<?php 
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	require '../conexion.php';
	$conexion->set_charset('utf8');

	$usuario = $conexion->real_escape_string($_POST['user']);
	$pas = $conexion->real_escape_string($_POST['password']);


	if($nueva_consulta = $conexion->prepare("SELECT nombre, password, correo FROM admins WHERE nombre = ? AND password = ?")){

		$nueva_consulta->bind_param('ss',$usuario, $pas);
		$nueva_consulta->execute();

		$resultado = $nueva_consulta->get_result();

		if ($resultado->num_rows == 1) {
			$datos = $resultado->fetch_assoc();
			session_start();
			$_SESSION['correo'] = $datos['correo']; 

			echo json_encode(array('error'=> false, 'tipo' => $datos['correo'], 'sesion' => $_SESSION['correo']));
		} else {
			echo json_encode(array('error'=> true));
		}
		$nueva_consulta->close();

	}
	$conexion->close();
}
 ?>
