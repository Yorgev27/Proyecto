<?php include 'components/header.php'; ?>
<?php $ruta = ''; ?>
<?php echo headerphp($ruta); ?>
<div class="col-12 col-md-7">
	<div class="box box-white boxshadow_strong">
		<div class="contenido boxpadding">
			<div class="title">
				<?php echo TitleBox('Administradores', 'Administradores registrados en el sistema ', 'Buscar por Correo') ?>
			</div>
			<div class="body">
				<h5>Leyenda</h5>
				<ul class="flex flex-wrap flex-margin">
					<li>
						<label class="icon-user"></label>
						<span>Estudiante</span>
					</li>
					<li>
						<label class="icon-user-md"></label>
						<span>Administrativo</span>
					</li>
					<li>
						<label class="icon-user-secret"></label>
						<span>Obrero</span>
					</li>
					<li>
						<label class="icon-graduation-cap"></label>
						<span>Docente</span>
					</li>
				</ul>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Foto</th>
							<th>Nombre</th>
							<th>Correo</th>
							<th>Password</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><img src="fotos/user5.jpg" alt="" class="avatar-small avatar-radius"></td>
							<td>Carlos</td>
							<td>Carlos</td>
							<td>Sumagro01</td>
							<td>Hola</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php echo footerphp($ruta); ?>