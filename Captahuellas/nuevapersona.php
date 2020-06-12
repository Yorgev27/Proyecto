<?php include 'components/header.php'; ?>
<!-- // VALIDAMOS QUE LA PERSONA EXISTA O QUE NO SE ENCUENTRE REGISTRADA  -->
<?php

// TOMAMOS LOS VALROES ENTRANTES 

$id = $_GET['id'];
$nombre = $_GET['nombre'];

// CONSULTAMOS EN EL SERVIDOR
require 'conexion.php';
$consultar_personal = $conexion->prepare("SELECT * FROM personal WHERE id_huella = '$id' ");
$consultar_personal->execute();
$resultado = $consultar_personal->get_result();
$personal = $resultado->fetch_assoc();

// SI EL RESULTADO ES 1 LA PERSONA SE ENCUENTRA EN BASE DE DATOS
if($resultado->num_rows == 1){

	// SI SU ESTADO ES ESPERANDO QUEIERE DECIR QUE AUN NO SE ENCUENTRA ACTIVADO
	if($personal['estado'] == 'esperando'){	
		echo personal_registro($personal['estado'], null);
	// SI SU ESTADO ES ACTIVO QUIERE DECIR QUE SE ENCUENTRA ACTIVADO
	} else if($personal['estado'] == 'activo'){
		echo personal_registro($personal['estado'], $personal);
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
			<?php // TOMAMOS COMO REFERENCIA EL TITLE BOX PARA DETERMINAR EL TITULO Y LA DESCRIPCION DE LA VENTANA ?>
			<?php if($estado == "esperando"){ ?>
				<?php echo TitleBox('Registrar Personal', 'Completa el registro del personal para agregarlo al listado', '') ?>
			<?php } else if($estado == "activo"){ ?>
				<?php echo TitleBox('Editar Personal', 'Completa la edicion del personal para modificar sus datos', '') ?>
			<?php } ?>
		</div>
		<div class="body">
			<?php if($estado == 'esperando' || $estado == 'activo'){ ?>
			<form method="post" id="form-nuevapersona" enctype="multipart/form-data">
				<span class="text-danger" style="display: none;"><label class="icon-x"></label> Cedula registrada</span>
				<div class="form-group">
					<label class="bold">Cedula</label>

					<!-- // ESTO ES PARA SABER SI EL USUARIO USO UN BOTON DE REGSTRO O UN BOTON DE EDICION -->
					<?php if($personal != null){ ?>
						<!-- en caso de que se haya usado un boton de edicion se prosgue a edtar la cedula  -->
						<?php if($personal['cedula'] != NULL && $personal['cedula'] != ""){ 
							$cedula = $personal['cedula'];
						 } else {
						 	$cedula = "";
						 } ?>
					<?php } ?>
					<input type="number" class="form-control" id="cedula" name="cedula" required value="<?php echo $cedula ?>">
				</div>
				<span class="text-success" style="display: none;"><label class="icon-check"></label> Correcto</span>
				<div class="form-group">
					<label class="bold">Nombre</label>
					<input type="text" class="form-control" id="nombre" name="nombres" value="<?php echo $_GET['nombre'] ?>" required>
				</div>

				<!-- Id de la huella oculta -->
				<input type="hidden" class="form-control" id="id_huella" name="id_huella" value="<?php echo $_GET['id'] ?>">
				<div class="form-group">

					<label class="bold">Cargo</label>

					<!-- Obtenemos el cargo de la persona -->
					<?php 
					$cargo = "";
					if($personal != null){
						if($personal['cargo'] != null && $personal['cargo'] != ""){
							$cargo = $personal['cargo'];
						}
					}
					 ?>
					<select class="custom-select" name="cargo">
						<?php 
						require 'conexion.php';
						$consultar_cargos = $conexion->prepare("SELECT nombre, id_cargo FROM cargo WHERE estado = 'activo' ");
						$consultar_cargos->execute();
						$resultados_cargos = $consultar_cargos->get_result();
						while($cargos = $resultados_cargos->fetch_assoc()){
						 ?>
						 	<?php if($cargo == $cargos['id_cargo']){ ?>
							<option value="<?php echo $cargos['id_cargo']?>" selected><?php echo $cargos['nombre']?></option>
							<?php } else {?>
								<option value="<?php echo $cargos['id_cargo']?>"><?php echo $cargos['nombre']?></option>
							<?php } ?>
						<?php } ?>
					</select>
				</div>
				<span class="text-danger" style="display: none;" id="invalidImage"><label class="icon-x"></label> Formato de archivo invalido solo se permite JPG o PNG con un tamaño menor a 1 Mb</span>
				<div class="row">
					<div class="col-4">
						<div class="avatar" style="height:150px;">
							<?php 
							if($personal != null){
								if($personal['foto'] != null && $personal['foto'] != ""){
									$foto = $personal['foto'];
								} else {
									$foto = 'default.jpg';
								}
							} else {
								$foto = 'default.jpg';
							}
							 ?>
							
							
							
							<img class="avatar" alt="" src="fotos/<?php echo $foto ?>" style="width:100%; height: 100%;" id="fotopersonal">
						</div>
					</div>
					<div class="col-8">
						<div class="form-group">
							<label class="bold">Subir Foto</label>
							<div class="input-group">
								<div class="custom-file">
									<input type="file" class="custom-file-input" name="subirfoto" id="subirfoto_persona">
									<label class="custom-file-label" for="subirfoto" style="overflow: hidden;">
										<?php echo $foto ?>
									</label>
								</div>
							</div>
						</div>
						<small>Al no subir una fotografia, la imagen por defeto sera defect.jpg</small>
					</div>
				</div>

				<?php if($estado == "esperando"){ ?>
					<input type="submit" class="btn btn-primary block marginauto" name="" value="Registrar" id="registro_persona">
				<?php } else if($estado == "activo"){ ?>
					<input type="submit" class="btn btn-success block marginauto" name="" value="Editar" id="edicion_persona">
				<?php } ?>
			</form>
			<?php } ?>
			<?php if($estado == null){ ?>
					<?php Anuncio('El usuario que intentas registrar no existe', 'Regresar', 'personal.php', '', ''); ?>
			<?php } ?>
		</div>
	</div>
</div>
</div>
<?php include 'components/footer.php'; ?>
<?php } ?>