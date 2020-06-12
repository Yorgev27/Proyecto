
<?php function aside(){ 
	require 'conexion.php';
	?>

<aside>
	<ul class="flex flex-wrap">
		<li style="display: block; width: 90%; margin:auto">
			<h5 class="text-white">Inicio</h5>
			<span class="linea"></span>
		</li>
		<li>
			<?php itemapp('icon-area-chart', 'Dashboard', 'index.php', '0', '') ?>
		</li>
		<li>
			<?php itemapp('icon-newspaper-o', 'E / S', 'entradas.php','0', 'badge_entrada') ?>
		</li>
		</li>
		<li>
			<?php itemapp('icon-lock', 'Sin Acceso', 'denegado.php','0', 'badge_entrada') ?>
		</li>
		<li style="display: block; width: 90%; margin:auto">
			<h5 class="text-white">Personal</h5>
			<span class="linea"></span>
		</li>
		<li>
			<?php 
				$num_personal = $conexion->prepare("SELECT * FROM personal WHERE estado = 'activo' ");
				$num_personal->execute();
				$resultado = $num_personal->get_result();
				$number = $resultado->num_rows;
				$num_personal->close();
			 ?>
			<?php itemapp('icon-users', 'Personal', 'personal.php', $number, 'badge_personal') ?>
		</li>
			<?php 
				$num_registrarse = $conexion->prepare("SELECT * FROM personal WHERE estado = 'esperando' ");
				$num_registrarse->execute();
				$resultado = $num_registrarse->get_result();
				$number = $resultado->num_rows;
				$num_registrarse->close();
			 ?>
		<li>
			<?php itemapp('icon-user-plus', 'Registrar', 'registro.php',  $number, 'badge_registrarse') ?>
		</li>
		<li>
			<?php 
				$num_cargos = $conexion->prepare("SELECT * FROM cargo WHERE estado = 'activo' ");
				$num_cargos->execute();
				$resultado = $num_cargos->get_result();
				$number = $resultado->num_rows;
				$num_cargos->close();
			 ?>
			<?php itemapp('icon-doc-text', 'Cargos', 'cargos.php', $number, 'badge_cargo') ?>
		</li>
		<li style="display: block; width: 90%; margin:auto">
			<h5 class="text-white">Administradores</h5>
			<span class="linea"></span>
		</li>
		<li>
			<?php 
				$num_admins = $conexion->prepare("SELECT * FROM admins");
				$num_admins->execute();
				$resultado = $num_admins->get_result();
				$number = $resultado->num_rows;
				$num_admins->close();
			 ?>
			<?php itemapp('icon-users-1', 'Admins', 'administradores.php', $number, 'badge_admins') ?>
		</li>
		<li>
			<?php itemapp('icon-user-plus', 'Registrar', 'personal.php', '0', '') ?>
		</li>
		<li>
			<?php itemapp('icon-flow-branch', 'Privilegios', 'administracion.php','0', 'badge_privilegios') ?>
		</li>
	</ul>
</aside>
<?php 
	$conexion->close();
} 
?>