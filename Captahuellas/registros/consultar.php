<?php 
// FUNCIONES QUE RETORNAN //

//Funcion para consultar los datos de un personal //

// CONEXON definira la conexiona l servidor
// $Select definira que tabla sera seleccionada
// $atributo definira el atributo a comprar
// $dato definira el dato del atributo a comparar
// $condicion se definira si es igual o distinto 
// $order definira el orden de la consulta
// $asc definira si es ascendiente o descendiente
// $limit definira el numero de consultas a seguir
function consultar($conexion, $select, $tabla, $atributo, $dato, $condicion, $order, $asc, $limit){

	// SI LA CONDICION NO ES IGUAL ENTONCES ES UNA CONSULTA SIMPLE
	if($condicion == "" || $condicion == NULL){
		$consultar =  $conexion->prepare("SELECT ".$select." FROM ".$tabla." ".$order." ".$asc." ");
	} else {

		// SI LA CONSULTA ES IGUAL ES UNA CONSULTA A CONDICION
		if($condicion == "="){

			// SI LA CONDICION ES IGUAL
		$consultar =  $conexion->prepare("SELECT ".$select." FROM ".$tabla." WHERE ".$atributo." = '".$dato."' 	".$order." ".$asc." ");
		} else{

			// SI LA CONDICION ES DESIGUAL
			$consultar =  $conexion->prepare("SELECT ".$select." FROM ".$tabla." WHERE ".$atributo." != '".$dato."' ".$order." ".$asc." ".$limit." ");
		}
	}

	// SE EJECUTA LA CONSULTA Y SE ARROJA EL RESULTADO
	$consultar->execute();
	$resultado = $consultar->get_result();

	// RETORNAMOS EL RESULTADO 
	return $resultado;
}


 ?>