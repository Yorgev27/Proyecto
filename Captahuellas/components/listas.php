<?php 

	// TOMAMOS LAS LIBRERIAS NECESARIAS //
	require '../conexion.php';
	require '../registros/consultar.php';
	require '../components/optim.php';

	// EXTRAEMOS EL METODO A TRAVES DEL XMLhttpRequested
	$metodo = $_POST['metodo'];

	// VERICAMOS A QUE PARTE PERTENECE ESE METODO
	if($metodo == 'entradas'){

		// SI PERTENECE A ENTRADAS ENTONCES MOSTRAMOS TODA LA TABLA //
		entradas($conexion, "");
	} else if($metodo == "entradas_update"){

		// SI LA TABLA ES ACTUALIZADA POR EL BUSCADOR ENTONCES SE RECOGEN LOS SIGUIENTES DATOS SUMINISTRADOS POR XMLhttpRequest de Global.js en la parte de buscar_lista()
		$actividad = $_POST['header_selectactividad']; // actividad
		$cargo = $_POST['header_selectcargo']; // por cargo 
		$fecha =$_POST['header_date']; // por fecha //
		$parametros = ""; // BLANQUEAMOS EL PARAMETRO POR SI NO EXISTE NINGUNO VALOR ENTRANTE

		// PARA ACTIVIDAD
		if($actividad != "todos"){
			if($actividad == 'activo'){
				$actividad_parametro = "AND personal.faltas = 0 AND personal.bloqueado = 'desbloqueado'" ;
				$parametros = $parametros." ".$actividad_parametro;
			} else if($actividad == 'faltas'){
				$actividad_parametro = "AND personal.faltas > 0";
				$parametros = $parametros." ".$actividad_parametro;
			} else if($actividad == 'bloqueado'){
				$actividad_parametro = "AND personal.bloqueado = 'bloqueado'";
				$parametros = $parametros." ".$actividad_parametro;
			}
		}

		// ARA CARGO
		if($cargo != "todos"){
			$cargo_parametro = "AND personal.cargo = ".$cargo;
			$parametros = $parametros." ".$cargo_parametro;
		}

		// PARA FECHA
		if($fecha != "" || $fecha != NULL){
			// SI LA FECHA CONTIENE UN VALOR SIMILAR
			$fecha_parametro = "AND historico_huella.fecha_entrada LIKE '%".$fecha."%' ";
			$parametros = $parametros." ".$fecha_parametro;
		}

		// EJECUTAMOS
		entradas($conexion, $parametros);
	}

?>

<?php

// FUNCION PARA MOSTRAR LAS ENTRADAS
function entradas($conexion, $parametros){
	$consultar_historico =  $conexion->prepare("SELECT historico_huella.*, personal.id_personal, personal.nombre, personal.cedula, personal.foto, personal.cargo, personal.faltas, personal.bloqueado, personal.estado FROM historico_huella INNER JOIN personal ON personal.id_huella = historico_huella.id_huella WHERE historico_huella.estado = 'activo' ".$parametros." ORDER BY id_historico DESC");
	// SE EJECUTA LA CONSULTA Y SE ARROJA EL RESULTADO
	$consultar_historico->execute();
	$resultado = $consultar_historico->get_result();

	if($resultado->num_rows > 0){
		while($personal = $resultado->fetch_assoc()){
		// CONSULTAMOS LOS DATOS DEL CARGO 
		$resultado_cargo = consultar($conexion, "*", "cargo" , "id_cargo", $personal['cargo'], "=", "", "", "");
		$cargo = $resultado_cargo->fetch_assoc();
						?>
		<tr>
			<td class="foto relative">
				<div class="relative avatar-list">
					<img src="fotos/<?php echo $personal['foto']?>" alt="" class="avatar-list avatar-radius">
					<label class="cargoicon bg-primary <?php echo $cargo['icono'] ?>"></label>
				</div>
			</td>
			<td class="textcenter"><?php echo $personal['cedula'] ?></td>
			<td class="bold text-primary textcenter">
				<a href="persona.php?id=<?php echo $personal['id_personal']?>" title=""><?php echo $personal['nombre'] ?></a>
			</td>

			<td class="relative textcenter">
				<label class="icon-clock-o"></label>
				<span><?php echo CalcularHora($personal['fecha_entrada'], 'hora'); ?></span>
			</td>
			<td class="relative">
				<?php if($personal['entro_salio'] == 'entro'){ ?>
					<label class="icon-sign-in relative text-primary" style="top:22px; right:10px; font-size: 22px;"></label>
				<?php } else {?>
					<label class="icon-sign-out relative text-danger" style="top:22px; right:10px; font-size: 22px;"></label>
				<?php } ?>
				<div class="ribbon-wrapper">
					<?php if($personal['bloqueado'] == 'desbloqueado' && $personal['faltas'] == '0'){ ?>
						<div class="ribbon bg-success boxshadow_strong">
							<i class="icon-check"></i>
						</div>
					<?php } else if($personal['bloqueado'] == 'desbloqueado' && $personal['faltas'] > 0){?>
						<div class="ribbon bg-warning boxshadow_strong">
							<i class="bold" style="font-size:22px;"><?php echo $personal['faltas'] ?></i>
						</div>
					<?php } else if($personal['bloqueado'] == 'bloqueado'){ ?>
						<div class="ribbon bg-dark boxshadow_strong">
							<i class="icon-lock"></i>
						</div>
					<?php } ?>
				</div>
			</td>
		</tr>
	<?php } ?>
	</tbody>
<?php
 } else{
?>
<!-- Si no hay entradas recientes se muestra el anunciado -->
	</tbody>
<?php
		echo NoDateList('No hay entradas', '', '', '');
	} 
} // end de entradas
?>