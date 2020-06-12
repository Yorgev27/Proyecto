
<?php include 'components/header.php'; ?>

<?php 
	require 'conexion.php';
	require 'registros/consultar.php';
	$id_persona = $_GET['id']; 
	$resultado = consultar($conexion, "*", "personal" , "id_personal", $id_persona, "=", "", "", "");
	if($resultado->num_rows == 1){
		$persona = $resultado->fetch_assoc();
		persona($persona, $conexion);	
	} else {
		no_exist();
	}
?>

<?php function persona($persona, $conexion){ ?>
<div class="col-12 col-lg-8">
	<div class="box box-white boxshadow_strong">
		<div class="contenido boxpadding">

			<div class="title">
				<div class="container-fluid">
					<div class="row">
						<div class="col-5">
							<i>Personal</i>
							<h3><?php echo $persona['nombre'] ?></h3>
						</div>
						<div class="col-7">
							<p>Buscar por cedula</p>
							<ul class="flex flex-wrap flex-margin">
								<form class="form-inline">
									<li>
										<div class="input-group input-group-sm">
											<input type="search" name="" placeholder="Buscar" class="form-control form-control-navbar" style="width: 70%;">
											<div class="input-group-append" style="right:5px; top:7px;position: absolute;">
												<label class="icon-search"></label>
											</div>
										</div>			
									</li>
									<li>
										<input type="submit" class="btn btn-primary btn-radius" value="buscar">
									</li>
								</form>
							</ul>
							
						</div>
					</div>
				</div>
			</div>
			<div class="body relative">
				<ul class="flex flex-margin flex-wrap relative">
					<?php 
						// COnsultamos cargo// 
						$resultado_cargo = consultar($conexion, "*", "cargo" , "id_cargo", $persona['cargo'], "=", "", "", "");
						$cargo = $resultado_cargo->fetch_assoc();

					 ?>				 
					<li>
						<div class="relative inlineblock avatar-bg">
							<?php if($persona['bloqueado'] == 'bloqueado'){ ?>
								<h3 class="text-danger bold">Bloquedo</h3>
								<span class="cargoicon icon-block bg-danger text-white"></span>
							<?php } else if($persona['bloqueado'] == 'desbloqueado' && $persona['faltas'] > 0){ ?>
								<h3 class="text-warning bold">Alertado</h3>
								<span class="cargoicon icon-alert bg-warning text-white"></span>
							<?php } else if($persona['bloqueado'] == 'desbloqueado' && $persona['faltas'] == 0){ ?>
								<h3 class="text-success bold">Activo</h3>
								<span class="cargoicon icon-check bg-success text-white"></span>
							<?php } ?>

							<img src="fotos/<?php echo $persona['foto']?>" alt="" class="avatar-bg avatar-radius" style="width:125px; height:125px;">
							
						</div>
						<h4>Faltas:</h4>
						<?php if($persona['estado'] == "activo"){ 
							// HACEMOS EL CALCULO MATEMATICO PARA SABER LAS FALTAS //
							$progreso = $persona['faltas']/$cargo['max_faltas'];

							// LO LLEVAMOS A PORCENTAJES 
							$progreso = $progreso*100;

							?>

						<div class="progress progress-xs">
							<div class="progress-bar bg-warning progress-bar-striped" roel="progressbar" aria-valuenow="<?php echo $progreso ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $progreso ?>%">
								<span class="sr-only"></span>
							</div>
						</div>
						<h4 class="textcenter bold"> <?php echo $persona['faltas']?> / <?php echo $cargo['max_faltas'] ?></h4>
						<?php } else if($persona['estado'] == "esperando"){ ?>
							No registrado aun
						<?php } ?>
					</li>
					<li>
						<ul>
							<li>
								<strong>Cedula</strong>
								<div>
									<?php // MOSTRAMOS CEDULA // ?>
									<?php if($persona['cedula'] != "" || $persona['cedula'] != NULL){ ?>
										<span><?php echo $persona['cedula']?></span>
									<?php } else {?>
										<span>No registrado</span>
									<?php } ?>
								</div>
							</li>
							<li>
								<strong>Nombre</strong>
								<div>
									<?php // MOSTRMAOS NOMBRE ?>
									<span><?php echo $persona['nombre']?></span>
								</div>
							</li>
							<li>
								<strong>Cargo</strong>
								<div class="relative">
									<?php if($persona['cedula'] != "" || $persona['cedula'] != NULL){ ?>
										<i class="cargoicon bg-primary relative <?php echo $cargo['icono']?>"></i>
										<span><?php echo $cargo['nombre']?></span>
									<?php } else {?>
										<span>No registrado</span>
									<?php } ?>

									
								</div>
							</li>
						</ul>
					</li>
					<li>
						<ul>
							<li>
								<strong>Hora de entrada</strong>
								<div>
									<span>7:30 AM</span>
								</div>
							</li>
							<li>
								<strong>Hora de salida</strong>
								<div>
									<span>12:30 PM</span>
								</div>
							</li>
						</ul>
					</li>
				</ul>

				<ul class="acciones flex flex-wrap flex-margin">
					<li>
						<?php if($persona['estado'] == "activo"){ ?>
							<button type="button" class="btn btn-warning btn-iconleft relative" onclick="window.location = 'nuevafalta.php?id=<?php echo $persona['id_huella'] ?>'">
								<label class="icon icon-alert"></label>
								Agregar Falta
							</button>
						<?php } else if($persona['estado'] == "esperando"){?>
							<button type="button" class="btn btn-primary btn-iconleft relative" onclick="window.location = 'nuevapersona.php?id=<?php echo $persona['id_huella'] ?>&nombre=<?php echo $persona['nombre'] ?>'">
								<label class="icon icon-user-plus"></label>
								Registrar
							</button>
						<?php } ?>
					</li>
					<li>
						<?php if($persona['estado'] == "activo"){ ?>
							<button type="button" class="btn btn-success btn-iconleft relative" onclick="window.location = 'nuevapersona.php?id=<?php echo $persona['id_huella'] ?>&nombre=<?php echo $persona['nombre'] ?>'">
								<label class="icon icon-pencil"></label>
								Modificar
							</button>
						<?php } ?>
					</li>
					<li>
						<?php if($persona['estado'] == "activo"){ ?>
							<button type="button" class="btn btn-danger btn-iconleft relative">
								<label class="icon icon-trash-1"></label>
								Eliminar
							</button>
						<?php } else if($persona['estado'] == "esperando"){?>
							<button type="button" class="btn btn-danger btn-iconleft relative">
								<label class="icon icon-block"></label>
								Descartar
							</button>
						<?php } ?>
					</li>
				</ul>

				<div class="altas">
					<h5>Faltas registradas</h5>
					<?php 
					// UTILIZAMOS LA OPTIMIZACION DE CONSULTA DE CONSULTAR.PHP

					$consultar =  $conexion->prepare("SELECT * FROM faltas WHERE id_personal = '".$persona['id_huella']."' AND estado = 'activo' ORDER BY id_falta DESC");
					// SE EJECUTA LA CONSULTA Y SE ARROJA EL RESULTADO
					$consultar->execute();
					$resultado = $consultar->get_result();
					if($resultado->num_rows){
					 ?>

					<table class="table table-striped">
						<thead>
							<tr>
								<th class="textcenter">Admin</th>
								<th class="textcenter">Razón</th>
								<th class="textcenter">Fecha</th>
								<th class="textcenter">Acciones</th>
							</tr>
						</thead>
						<tbody>

							 	<?php while($falta = $resultado->fetch_assoc()){ ?>
								<tr>
									<td>
										<div class="relative avatar-list">
											<img src="fotos/admin.jpg" class="avatar-list avatar-radius marginauto block" alt="">
											<span class="cargoicon bg-warning text-white bold" style="line-height: 20px;"><?php echo $falta['cantidad'] ?></span>
										</div>
									</td>
									<td>
										<p><?php echo $falta['razon'] ?></p>
									</td>
									<td class="textcenter">
										<span><?php echo CalcularHora($falta['fecha_falta'], 'all'); ?></span>
									</td>
									<td>
										<ul class="flex flex-margin">
											<li>
												<button class="btntd btn-success btn-radius boxshadow">
													<label class="icon-pencil"></label>
												</button>
											</li>
											<li>
												<button class="btntd btn-danger btn-radius boxshadow" id="falta_<?php echo $falta['id_falta'] ?>_eliminado" onclick="eliminar(event)">
													<label for="falta_<?php echo $falta['id_falta'] ?>_eliminado" class="icon-x"></label>
												</button>
											</li>
										</ul>
									</td>
								</tr>
								<?php } ?>
						</tbody>
					</table>
					<?php } else {?>

						<?php 
						echo  NoDateList('No hay faltas registradas', '','', '') ?>
					<?php }  ?>
				</div>

				<div class="entradas">
					<h5>Entradas recientes</h5>
					<?php 
						// UTILIZAMOS LA OPTIMIZACION DE CONSULTA DE CONSULTAR.PHP
						$resultado = consultar($conexion, '*', 'historico_huella', 'id_huella', $persona['id_huella'], "=", "ORDER BY id_historico", "DESC", "LIMIT 10");
						if($resultado->num_rows){
					 ?>
					<table class="table table-striped">
						<thead>
							<tr>
								<th class="textcenter">Foto</th>
								<th class="textcenter">Hora</th>
								<th class="textcenter">Acciones</th>
								<th class="textcenter">Condicion</th>
							</tr>
							<tbody>
								<?php while($historico = $resultado->fetch_assoc()){ ?>
									<tr>	
										<td class="foto">
											<div class="relative avatar-list">
												<img src="fotos/<?php echo $persona['foto']?>" alt="" class="avatar-list avatar-radius">

												<?php // CONSULTAMOS EL ICONO DE PERSONAL //
													$resultado_cargo = consultar($conexion, "*", "cargo" , "id_cargo", $persona['cargo'], "=", "", "", "");
													$cargo = $resultado_cargo->fetch_assoc()

												 ?>
												<label class="cargoicon bg-primary <?php echo $cargo['icono'] ?>"></label>
											</div>
										</td>
										<td class="relative textcenter">
											<label class="icon-clock-o"></label>
											<span><?php echo CalcularHora($historico['fecha_entrada'], 'all'); ?></span>
										</td>
										<td>
											<ul class="flex flex-margin">
												<li>
													<button class="btntd btn-success btn-radius boxshadow">
														<label class="icon-pencil"></label>
													</button>
												</li>
												<li>
													<button class="btntd btn-danger btn-radius boxshadow">
														<label class="icon-x"></label>
													</button>

												</li>
											</ul>
										</td>		
										<td class="relative">
											<div class="ribbon-wrapper">
												<?php if($persona['bloqueado'] == 'desbloqueado' && $persona['faltas'] == '0'){ ?>
													<div class="ribbon bg-success boxshadow_strong">
														<i class="icon-check"></i>
													</div>
												<?php } else if($persona['bloqueado'] == 'desbloqueado' && $persona['faltas'] > 0){?>
													<div class="ribbon bg-warning boxshadow_strong">
														<i class="bold" style="font-size:22px;"><?php echo $persona['faltas'] ?></i>
													</div>
												<?php } else if($persona['bloqueado'] == 'bloqueado'){ ?>
													<div class="ribbon bg-dark boxshadow_strong">
														<i class="icon-lock"></i>
													</div>
												<?php } ?>
											</div>
										</td>	
									</tr>
								<?php } ?>
							</tbody>			
						</thead>
					</table>
					<?php } else { ?>
						<?php echo  NoDateList('No hay entradas registradas', '','', '') ?>
					<?php } ?>
				</div>

			</div>
		</div>
	</div>
</div>
<?php } // CIERRE DE LA FUNCION persona() ?>

<?php function no_exist(){ ?>
<div class="col-12 col-lg-8">
	<div class="box box-white boxshadow_strong">
		<div class="contenido boxpadding">
			<?php echo TitleBox('Personal', 'La persona que intentas ver se encuentra bloqueada o no registrada', '') ?>	
			<?php  ?>
			<?php 
				Anuncio("Persona no encontrada", "Volver", "personal.php", "", "");
			 ?>
		</div>
	</div>
</div>
<?php } ?>
<?php 
$resultado->close();
$conexion->close();
 ?>
<?php include 'components/footer.php'; ?>