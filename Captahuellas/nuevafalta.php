<?php include 'components/header.php'; ?>
<!-- // VALIDAMOS QUE LA PERSONA EXISTA O QUE NO SE ENCUENTRE REGISTRADA  -->
<?php

// TOMAMOS LOS VALROES ENTRANTES 

$id = $_GET['id'];

// CONSULTAMOS EN EL SERVIDOR
require 'conexion.php';
$consultar_personal = $conexion->prepare("SELECT * FROM personal WHERE id_huella = '$id' ");
$consultar_personal->execute();
$resultado = $consultar_personal->get_result();
$personal = $resultado->fetch_assoc();

// SI EL RESULTADO ES 1 LA PERSONA SE ENCUENTRA EN BASE DE DATOS
if($resultado->num_rows == 1){

	// SI SU ESTADO ES ESPERANDO QUEIERE DECIR QUE AUN NO SE ENCUENTRA ACTIVADO
	if($personal['estado'] == 'activo'){	
		echo personal_registro($personal['estado'], $personal);
	// SI SU ESTADO ES ACTIVO QUIERE DECIR QUE SE ENCUENTRA ACTIVADO
	} else if($personal['estado'] == 'activo'){
		echo personal_registro(null, $personal);
	}
// SI EL RESULTADO ES DISTINTO A 1 QUIERE DECIR QUE NO EXISTE EN BASE DE DATOS
} else if($resultado->num_rows == 0){
	echo personal_registro(null, $personal);
}
 ?>


<!-- EL FORMULARIO DEL PERSONAL REGISTRO // -->
<?php function personal_registro($estado, $personal){ ?>
<div class="col-12 col-lg-8">
<div class="box box-white boxshadow_strong">
	<div class="contenido boxpadding relative">
		<div class="title">
			<?php echo TitleBox('Agregar Falta', 'Completa los datos para agregar las faltas necesarias', '') ?>
			<ul class="flex flex-wrap flex-margin">
				<li style="width:50%;">
					<h3 class="textcenter"><?php echo $personal['nombre'] ?></h3>
					<div class="relative inlineblock avatar-bg block" style="margin:auto">
						<img src="fotos/<?php echo $personal['foto']?>" alt="" class="avatar-bg avatar-radius block" style="width:125px; height:125px; margin:auto">
					</div>	
				</li>
				<li  style="width:50%;">
					<?php 
						// COnsultamos cargo//
						require 'conexion.php'; 
						$consultar_cargo = $conexion->prepare("SELECT * FROM cargo WHERE id_cargo = '".$personal['cargo']."'  ");
						$consultar_cargo->execute();
						$resultado_cargo = $consultar_cargo->get_result();
						$cargo = $resultado_cargo->fetch_assoc();

						// HACEMOS EL CALCULO MATEMATICO PARA SABER LAS FALTAS //
						$progreso = $personal['faltas']/$cargo['max_faltas'];

						// LO LLEVAMOS A PORCENTAJES
						$progreso = $progreso*100;
					?>
					<h5 class="textcenter"><?php echo $cargo['nombre'] ?></h5>
					<div class="progress progress-xs">
						<div class="progress-bar bg-warning progress-bar-striped" roel="progressbar" aria-valuenow="<?php echo $progreso ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $progreso ?>%">
							<span class="sr-only"></span>
						</div>
					</div>
					<h4 class="textcenter bold"> <?php echo $personal['faltas']?> / <?php echo $cargo['max_faltas'] ?></h4>
				</li>
			</ul>
		</div>
		<div class="body">
			<form method="post" id="form-nuevafalta" enctype="multipart/form-data">
				<div class="form-group">
					<label class="bold">Numero de faltas</label>
					<input type="number" class="form-control" id="numfalta" name="numfalta" required value="" min="0" max="<?php echo $cargo['max_faltas']-$personal['faltas']; ?>">
				</div>
				<div class="form-group">
					<label class="bold">Razon</label>
					<textarea type="text" class="form-control" id="razon" name="razon" value="" required style="resize: inherit; min-height: 100px;" required></textarea>
				</div>

				<input type="hidden" name="id_huella" id="id_huella" value="<?php echo $personal['id_huella'] ?>">
				
				<input type="submit" class="btn btn-primary block marginauto" name="" value="Registrar" id="registro_cargo">

			</form>
			<?php if($estado == null){ ?>
					<?php Anuncio('El usuario que intentas registrar no existe', 'Regresar', 'personal.php', '', ''); ?>
			<?php } ?>
		</div>
	</div>
</div>
</div>
<?php include 'components/footer.php'; ?>
<?php } ?>