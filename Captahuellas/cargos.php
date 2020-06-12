
<?php include 'components/header.php'; ?>
<!-- // Los cargos del personal se refieren a la jerarquia de usuarios respecto al personal  -->
<div class="co-12 col-lg-8">
	<div class="box box-white boxshadow_strong">
		<div class="contenido boxpadding">
			<div class="title">
				<?php echo TitleBox('Cargos', 'Crea y gestiona los cargos correspondientes al personal', 'Buscar por Nombre') ?>	
				<button type="button" class="btn btn-primary float-right" onclick="window.location ='nuevocargo.php'"><i class="icon-plus"></i>Nuevo</button>
			</div>
			<div class="body">
			<table class="table table-striped relative">
				<thead>
					<tr>
						<th class="textcenter">Icono</th>
						<th class="textcenter">Nombre</th>
						<th class="textcenter">Faltas</th>
						<th class="textcenter">Autor</th>
						<th class="textcenter">Acciones</th>
					</tr>
				</thead>
				<tbody class="relative">
					<?php
						require 'conexion.php';
						// consultamos todos los cargos disponbles  
						require 'registros/consultar.php';
						$resultado = consultar($conexion, "*", "cargo", "estado" , "activo", "=", "", "", "");

						// si el cargo es mayor a cero muestra la lista 
						if($resultado->num_rows > 0){
							while($cargo = $resultado->fetch_assoc()){
							?>
							<tr id="fila_<?php echo $cargo['id_cargo'] ?>" class="relative">
								<td>
									
									<label class="cargo <?php echo $cargo['icono'] ?>"></label>
								</td>
								<td><?php echo $cargo['nombre'] ?></td>
								<td><?php echo $cargo['max_faltas'] ?></td>

								<?php

									// CONSUTAMOS EL ADMINISTRDADOR QUE CREO EL CARGO
									$resultado_admin = consultar($conexion, "foto", "admins", "correo" ,$cargo['creado_por'] , "=", "", "", "");
									$autor = $resultado_admin->fetch_assoc();
									
								 ?>
								<td class="relative">
									<img src="fotos/<?php echo $autor['foto'] ?>" class="avatar-small avatar-radius marginauto block" alt="">
								</td>
								<td class="relative">
									<ul class="flex flex-margin">
										<li>
											<button class="btntd btn-success btn-radius boxshadow"  onclick="window.location ='nuevocargo.php?id=<?php echo $cargo['id_cargo']?>'">
												<label class="icon-pencil"></label>
											</button>
										</li>
										<li>
											<button type="submit" class="btntd btn-danger btn-radius boxshadow" id="cargo_<?php echo $cargo['id_cargo'] ?>_eliminado" onclick="eliminar(event);">
												<label for="cargo_<?php echo $cargo['id_cargo'] ?>_eliminado" class="icon-x"></label>
											</button>
										</li>
									</ul>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>

					<!-- si el cargo es cero no muestra la lista, la cerramos y mostramos el anuncio  -->
						<?php } else { ?>
							<?php echo  NoDateList('No hay cargos registrados', 'Registrar', 'nuevocargo.php') ?>
						<?php } ?>
		</div>
	</div>
</div>
</div>

<?php include 'components/footer.php'; ?>