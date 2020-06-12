
<?php include 'components/header.php'; ?>
<?php 
if(isset($_GET['id'])){
	require 'conexion.php';
	require 'registros/consultar.php';
	$resultado = consultar($conexion, "id_cargo, nombre, max_faltas, icono", "cargo", "id_cargo", $_GET['id'] , "=", "", "", "");
	if($resultado->num_rows > 0){
		$cargo = $resultado->fetch_assoc();
		echo ventana_registro($cargo);
		include 'components/footer.php';
	} else {
		ventana_registro_error();
		include 'components/footer.php'; 
		die();
	}
} else {
	echo ventana_registro(null);
	include 'components/footer.php';
}
 ?>


<!-- ESTA ES LA VENTANA ERROR DE REGISTRO DE UN CARGO QUE SE MOSTRARA CUANDO SE HAYAN INSERTADO DATOS DE MYSQL POR EL USUARIO  -->
 <?php function ventana_registro_error(){ ?>
 	<div class="col-12 col-lg-8">
 		<div class="box box-white boxshadow_strong">
 			<div class="contenido boxpadding">
 				<div class="ttle">
 					<div class="row">
 						<div class="col-12">
 							<h3>Cargo no existente</h3>
 							<small>Ah ocurrido un error al editar o ingresar un cargo que ya no existe</small>
 							<p>Por favor intente de nuevo</p>
 							<a href="cargos.php" class="btn btn-primary" title="">VOVLER</a>
 						</div>
 					</div>
 				</div>
 			</div>
 		</div>
 	</div>
 <?php } ?>


<!-- ESTA ES LA FUNCION DE LA VENTANA DE REGISTRO QUE SE MOSTRARA UNA VEZ VALIDADA LA OBTENCION DE LA ID CON UN NUMERO O SIN UNO  -->
<?php function ventana_registro($cargo){ ?>

<div class="co-12 col-lg-7">
	<div class="box box-white boxshadow_strong">
		<div class="contenido boxpadding">
			<div class="title">
				<div class="row">
					<div class="col-12">
						<?php if($cargo == null){?>
							<h5>Nuevo Cargo</h5>
							<small>Asigna un nuevo cargo para el area del personal</small>
						<?php } else {?>
							<h5>Editar Cargo</h5>
							<small>Edita un cargo para el area del personal</small>
						<?php } ?>
					</div>
				</div>
			</div>
			<br>
			<div class="body">
				<!-- SI EL PARAMETRO CARGO ESTA VACO SIGNIFICA QUE ES UN NUEVO CARGO POR LO TANTO EL FORMULARO TENDRA UN ID DE NUEVO CARGO -->

				<!-- SI EL PARAMETRO CARGO CONTIENE ALGO SIGNIFICA QUE ES UNA EDICION RESPECTO A UN CARGO POR LO TANTO EL FORMULARIO TENDRA EL ID DE EDITAR CARGO   -->

				<?php if($cargo == null){
					$idform = "form_newcargo";
				} else {
					$idform = "form_editcargo";
				}?>
				<form method="post" id="<?php echo $idform?>">
					<div class="form-group">
						<label>Nombre del Cargo</label>
						<input type="text" name="nombreCargo" class="form-control" name="" required value="<?php echo $cargo['nombre'] ?>">
					</div>
					<div class="form-group">
						<label>Maximo de faltas</label>
						<input type="number" name="numeroFaltas" class="form-control" name="" min="0" required value="<?php echo $cargo['max_faltas'] ?>">
					</div>
					<div class="form-group">
						<label>Icono de cargo</label>
						<ul class="flex flex-wrap flex-margin">
							<?php itemicon('pack_nuevocargo','icon-user') ?>
							<?php itemicon('pack_nuevocargo','icon-vcard') ?>	
							<?php itemicon('pack_nuevocargo','icon-msn-messenger') ?>	
							<?php itemicon('pack_nuevocargo','icon-graduation-cap') ?>
							<?php itemicon('pack_nuevocargo','icon-organization') ?>
							<?php itemicon('pack_nuevocargo','icon-person') ?>
							<?php itemicon('pack_nuevocargo','icon-user-secret') ?>
							<?php itemicon('pack_nuevocargo','icon-user-md') ?>

							<?php itemicon('pack_nuevocargo','icon-flask') ?>
							<?php itemicon('pack_nuevocargo','icon-zynga') ?>
							<?php itemicon('pack_nuevocargo','icon-lab') ?>
							<?php itemicon('pack_nuevocargo','icon-basket') ?>
							<?php itemicon('pack_nuevocargo','icon-flight') ?>
							<?php itemicon('pack_nuevocargo','icon-book') ?>
							<?php itemicon('pack_nuevocargo','icon-taxi') ?>
							<?php itemicon('pack_nuevocargo','icon-tree') ?>
							<?php itemicon('pack_nuevocargo','icon-star-1') ?>
							<?php itemicon('pack_nuevocargo','icon-magic') ?>
							<?php itemicon('pack_nuevocargo','icon-mouse-pointer') ?>
							<?php itemicon('pack_nuevocargo','icon-archive-1') ?>
						</ul>
					</div>

					<!-- // SI EL FORMULARIO ES UNA EDICION RESPECTO A UN CARGO DEBEMOS GUARDAR EL ID DEL CARGO  -->
					<?php if($cargo != null){ ?>
						<input type="hidden" name="id_cargo" value="<?php echo $cargo['id_cargo'] ?>">
					<?php } ?>

					<!-- SI EL FORMULARIO ES UNA EDICION O UN NUEVO CARGO  -->
					<?php if($cargo == null){ ?>
					<div class="form-group" style="height: 40px;">	
						<input type="submit" class="btn btn-primary float-right" name="" value="Crear">
					</div> 
					<?php } else { ?>
					<div class="form-group" style="height: 40px;">	
						<input type="submit" class="btn btn-success float-right" name="" value="Editar">
					</div>
					<?php } ?>
				</form>
			</div>
		</div>
	</div>
</div>
<?php } ?>
