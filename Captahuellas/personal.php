<?php include 'components/header.php'; ?>
<div class="col-12 col-md-12 col-lg-8">
<div class="box box-white boxshadow_strong">
	<div class="contenido boxpadding relative">
		<div class="title" style="min-height: 100px;">
			<?php echo TitleBox('Personal', 'Personal Registrado en el sistema', 'Buscar por Cedula') ?>
			<?php echo headerlist_users(); ?>
			<a href="registro.php" class="btn btn-primary">Registrar</a>
		</div>
	</div>
</div>
<br>
<div class="box box-white boxshadow_strong">
	<div class="contenido boxpadding relative">
		<div class="body">
			<table class="table">
				<thead>
					<tr>
						<th class="textcenter">Foto</th>
						<th class="textcenter">Cedula</th>
						<th class="textcenter">Nombre</th>
						<th class="textcenter">Acciones</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php 

						// REALIZAMOS LA CONSULTA
						require 'conexion.php';
						require 'registros/consultar.php';
						$resultado = consultar($conexion, "*", "personal", "estado", "activo", "=", "ORDER BY id_personal", "DESC", "LIMIT 10");
						if($resultado->num_rows > 0){
						while($personal = $resultado->fetch_assoc()){?>
							<tr>
								<td class="foto">
									<?php 

									// ESTO ES PARA SABER SI LA PERSONA SE ENCUENTRA DENTRO O FUERA DE LAS INSTALACIONES // 
										if($personal['entro_salio'] == 'entro'){ ?>
										<label class="icon-sign-in absolute text-primary bold" style="top:25px; left:-10px; font-size:20px;"></label>
									<?php } else{ ?>
										<label class="icon-sign-out absolute text-danger bold" style="top:25px; left:-10px; font-size:20px;"></label>
									<?php } ?>
									<div class="relative avatar-list">
										<img src="fotos/<?php echo $personal['foto']?>" alt="" class="avatar-list avatar-radius">


										<?php // CONSULTAMOS EL ICONO DE PERSONAL //
											$consultar_cargo = $conexion->prepare("SELECT * FROM cargo WHERE id_cargo = '".$personal['cargo']."'  ");
											$consultar_cargo->execute();
											$resultado_cargo = $consultar_cargo->get_result();
											$cargo = $resultado_cargo->fetch_assoc()

										 ?>
										<label class="cargoicon bg-primary <?php echo $cargo['icono'] ?>"></label>
									</div>
								</td>
								<td>
									<?php echo $personal['cedula'] ?>
								<td class="bold text-primary"><a href="persona.php?id=<?php echo $personal['id_personal']?>" title=""><?php echo $personal['nombre'] ?></a>
								</td>
								<td>
									<ul class="flex flex-margin">
										<li style="margin-left:-5px;">
											<button class="btntd btn-success btn-radius boxshadow" onclick="window.location = 'nuevapersona.php?id=<?php echo $personal['id_huella'] ?>&nombre=<?php echo $personal['nombre'] ?>'">
												<label class="icon-pencil"></label>
											</button>
										</li>
										<li style="margin-left:5px;">
											<button class="btntd btn-danger btn-radius boxshadow" id="personal_<?php echo $personal['id_huella'] ?>_eliminado">
												<label class="icon-x"></label>
											</button>
										</li>
										<li style="margin-left:5px;">
										<?php if($personal['bloqueado'] == 'desbloqueado'){ ?>
											<button class="btntd btn-radius boxshadow  btn-dark" id="personal_<?php echo $personal['id_huella'] ?>_bloqueado" onclick="eliminar(event)" style="z-index: 200;">
												<label for="personal_<?php echo $personal['id_huella'] ?>_bloqueado"class="icon-lock"></label>
											</button>
										<?php } else if($personal['bloqueado'] == 'bloqueado'){ ?>
											<button class="btntd btn-primary btn-radius boxshadow" id="personal_<?php echo $personal['id_huella'] ?>_desbloqueado" onclick="eliminar(event)" style="z-index: 200;">
												<label for="personal_<?php echo $personal['id_huella'] ?>_desbloqueado"class="icon-unlock-alt"></label>
											</button>
										<?php } ?>
										</li>
									</ul>
								</td>
								<td class="relative">
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
					</table>
				<?php } else {?>
					<?php echo  NoDateList('No hay personal registrado', 'Registrar', 'registro.php', '') ?>
				<?php } 
				// CERRAMOS CONEXION
				$conexion->close();
				?>
		</div>
	</div>
</div>
</div>
<?php include 'components/footer.php'; ?>