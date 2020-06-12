<?php
 	// TOMAMOS EL ARCHIVO ACCESS A CONSULTAR EN PHP //
	function conectar($archivo){
		$db = getcwd()."\\".$archivo;
		// ESTABLECEMOS EL DRVER PARA PODER HACER CONSULTAS EN PHP EN ACCESS
		$dsn =  "DRIVER={Microsoft Access Driver (*.mdb)};DBQ=$db";
		// ESTABLECEMOS LA CONEXION
		$aconexion = odbc_connect($dsn, '', '' );
		if (!$aconexion) { 
			// SI LA CONEXION FALLA LO ANUNCIAMOS
			exit( "Error al conectar: " . $aconexion);
		}
		return $aconexion;
	}
?>