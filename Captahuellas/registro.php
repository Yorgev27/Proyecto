<?php include 'components/header.php'; ?>
<div class="col-12 col-lg-8">
	<div class="box box-white boxshadow_strong">
		<div class="boxpadding relative">
			<div class="title">

				<?php // TOMAMOS COMO REFERENCIA EL TITLE BOX PARA DETERMINAR EL TITULO Y LA DESCRIPCION DE LA VENTANA ?>
				<?php echo TitleBox('Nuevo Persona', 'Para la creacion de un nuevo personal debes seleccionar uno de los registros traidos de access para iniciar el rgistro', '') ?>
			</div>
			<div class="body relative">

				<!-- esta es la tabla para los nuevos registros que procederan a colocarse  -->
				<?php 
					// establecemos conexion con el servidor 
					require 'conexion.php';
					require 'registros/consultar.php';
					$resultado = consultar($conexion, "*", "personal", "estado", "esperando", "=", "ORDER BY id_personal", "DESC", "");
					$conexion->close();
				 ?>
				<div class="table-button" id="button-registro">
					<ul class="flex flex-margin flex-wrap">
						<li>
							<button type="button" id="btn_generarUserinfo" class="btn btn-primary marginauto">Actualizar</button>
						</li>
						<?php if($resultado->num_rows > 0 ){ ?>
							<li>
								<button type="button" id="btn_registrartodos" class="btn btn-primary marginauto text-primary right" style="background-color: transparent;">Registrar a todos</button>
							</li>
							<li>
								<button type="button" id="btn_registrartodos" class="btn btn-danger marginauto text-danger right" style="background-color: transparent;">Denegar a todos</button>
							</li>
						<?php } ?>
					</ul>
				</div>

				<!-- ESTE RESULTADO APARECERA CUANDO SE HAYA HECHO EL ESCANEO  -->
				<span id="result" class="relative text-white p-1 pr-4 pl-4" style="bottom:5px; border-radius: .25rem; display: none;">
					
				</span>
				<table class="table relative" id="table_nuevapersona">
					<thead>
						<tr>
							<th class="textcenter">ID</th>
							<th class="textcenter">Nombre</th>
							<th class="textcenter">Registrar</th>
							<th class="textcenter">Denegar</th>
						</tr>
					</thead>
					<tbody>
						<?php if($resultado->num_rows > 0 ){ ?>
						<?php while($personal= $resultado->fetch_assoc()){ ?>
							<tr id="fila_<?php echo $personal['id_huella'] ?>">
								<td><?php echo $personal['id_huella'] ?></td>
								<td class="relative">
									<p class="relative" style="top:10px"><?php echo $personal['nombre'] ?></p></td>
								<td><button class="btn btn-primary" onclick="window.location = 'nuevapersona.php?id=<?php echo $personal['id_huella'] ?>&nombre=<?php echo $personal['nombre'] ?>'">Registrar</button></td>
								<td><button class="btn btn-danger" id="personal_<?php echo $personal['id_huella'] ?>_descartado" onclick="eliminar(event);">Descartar</button></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				<!-- Si no hay entradas recientes se muestra el anunciado -->
				<?php } else {?>
					<?php echo NoDateList('No hay datos actualizados', '', '','') ?>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php include 'components/footer.php'; ?>