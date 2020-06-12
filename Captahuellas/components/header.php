<?php include 'components/optim.php'; ?>
<?php include 'components/aside.php'; ?>

<!-- ESTA FUNCION DE HADERPHP SE MOSTRARA EN CADA UNA DE LAS VENTANAS EXCEPTO EN EL LOGIN  -->
<?php  
// ESTA FUNCION NOS PERMITIRA SABER SI EL ADMINISTRADOR ESTA CONECTADO
require 'conexion.php';
session_start();

// VALIDADOR DE LA RUTA, PARA SABER SI SE ENCUENTRA DENTO DEL SISTEMA
if($_SESSION['correo'] == null || $_SESSION['correo'] == ""){
	header("location: login/");
} 
// BUSCAMOS LOS DATOS DEL ADMINISTRADOR INICIADO SESSION //
$consultardatos = $conexion->prepare("SELECT * FROM admins WHERE correo = '".$_SESSION['correo']."' ");
$consultardatos->execute();
$resultado = $consultardatos->get_result();
if($resultado->num_rows == 1) {
	$admin = $resultado->fetch_assoc();
}
$consultardatos->close();
$conexion->close();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="iso-8859-1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Captahuellas - Unefa</title>
	<link rel="stylesheet" type="text/css" href="bootstrap/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<link rel="stylesheet" type="text/css" href="css/default.css">
	<link rel="stylesheet" type="text/css" href="css/responsive.css">
	<link rel="stylesheet" type="text/css" href="iconos/styles.css">
	<link rel="stylesheet" type="text/css" href="css/botones.css">
	<link rel="stylesheet" type="text/css" href="css/aside.css">
	<link rel="stylesheet" type="text/css" href="css/timeline.css">
	<link rel="stylesheet" type="text/css" href="css/loading.css">
	<link rel="stylesheet" type="text/css" href="css/animaciones.css">
	<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
</head>
<body>


<?php // EN CASO DE QUE LA RUTA SEA CONTRARIA NO SE MOSTRARA EL HEADER O CABECERA ?>
<div class="fixed-header boxshadow_strong bg-light">
</div>
<!-- ESTE ES EL HEADER REAL EL CUAL TENDRA TODOS LOS CONTENIDOS QUE SE PODRAN MOSTRAR AL USUARIO  -->
<header>
	<div class="container-fluid padding-0" style="margin-top:7px">
		<div class="row">
			<!-- ESTE ES EL FORMULARIO DE BUSQUEDA  -->
			<div class="col-6 col-md-4 padding-0">
				<form class="form-inline ml-3" id="formsearch">
					<div class="input-group input-group-sm">
						<input type="search" id="headersearch" name="" placeholder="Buscar" class="form-control form-control-navbar" style="width: 70%;">
						<div class="input-group-append" style="right:5px; top:7px;position: absolute;">
							<label class="icon-search"></label>
						</div>
					</div>

				<!-- ESTE ES EL BOTON DE SUBMIT DEL FORMULARIO PARA ACCIONAR LA BUSQUEDA  -->
				<input type="submit" name="" style="display: none">
				</form>
			</div>

			<ul class="navbar-nav col-6 col-md-8 ml-auto">
				<li class="nav-item dropdown">
					<!-- ESTE CHECKBOX ME PERMITIRA ABRIR EL MENU DEL ADMINISTRADOR  -->
					<!-- AL CHECKBOX SER TRUE SE ABRIRA EL PANEL  -->
					<!-- AL CHECKBOX SER FALSO SE CERRARA EL PANEL  -->
					<input type="checkbox" name="menuadmin" id="btn-menuadmin" style="display: none;">
					<div class="col-8 col-md-12">

						<!-- ESTE ES EL BOTON QUE ME PERMITIRA HACER TRUE O FALSO AL CHECKBOX -->
						<label for="btn-menuadmin" class="btn-primary btn-radius pointer" id="btn-account">
							<ul class="flex flex-wrap flex-margin">
								<li>
									<img src="fotos/<?php echo $admin['foto']?>" class="avatar-small avatar-circle" alt="">
								</li>
								<li>
									<stnrog>Admin</strong>
									<label class="icon-angle-down"></label>
								</li>
							</ul>
						</label>
					</div>

					<!-- EL MENU QUE SE ABIRA DE ACUERDO AL VALOR DEL CHECKBOX  -->

					<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="position: absolute; margin-right: 10px;">
						<span class="dropdown-item dropdown-header">Mi cuenta</span>
						<div class="dropdown-dividir">
							
						</div>
						<a href="desconectarse.php" class="dropdown-item" title="">
							<i class="icon-logout"></i>
							Cerrar Sesión
						</a>
					</div>

				</li>

				<!-- ESTE ES EL LABON DEL ASIDE  -->
				<li>
					<div class="col-4 padding-0 vb-320 vb-576 vn-768 vn-1024 vn-1366 vn-1920" id="forbtn_aside">
						<div class="labelbutton">
							<label for="btn-aside">
								<i class="icon-three-bars icon"></i>
							</label>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</div>
</header>

<?php aside(); ?>

<div class="content-all">

	<!-- // ESTE ES EL ASDE DONDE APARECERAN LAS NOTIFICACIONES DE LAS NUEVAS ENTRADAS -->
	<div class="notificacion_aside" style="display: none;">
		<ul>
			<li>
				<div class="notificacion box-white boxradius boxshadow_strong">
					<div class="container-fluid" style="padding: 0; width: 100%; margin:0">
						<div class="row" style="padding:0; width: 100%; margin:0">
							<div class="col-6 col-lg-3">
								<div class="avatar-list relative">
									<img src="fotos/1.jpg" alt="" class="avatar avatar-list">
									<span class="cargoicon icon-user bg-primary"></span>
								</div>
							</div>
							<div class="col-0 vn-320 vn-576 vn-768 vb-1024 col-lg-7" style="padding.left:2px;">
								<strong class="text-primary">JORBI BARAHONA</strong>
							</div>
							<div class="col-6 col-lg-2 relative">
								<label class="icon-sign-in relative text-success" style="margin-top:25px;right:15px; font-size:22px; "></label>
								<div class="ribbon-wrapper">
									<div class="ribbon bg-success boxshadow_strong">
										<i class="icon-check"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</li>

			<li>
				<div class="notificacion box-white boxradius boxshadow_strong">
					<div class="container-fluid" style="padding: 0; width: 100%; margin:0">
						<div class="row" style="padding:0; width: 100%; margin:0">
							<div class="col-6 col-lg-3">
								<div class="avatar-list relative">
									<img src="fotos/1000.jpg" alt="" class="avatar avatar-list">
									<span class="cargoicon icon-user bg-primary"></span>
								</div>
							</div>
							<div class="col-0 vn-320 vn-576 vn-768 vb-1024 col-lg-7" style="padding.left:2px;">
								<strong class="text-danger">MARIA UNPAJOTE</strong>
							</div>
							<div class="col-6 col-lg-2 relative">
								<label class="icon-sign-out relative text-danger" style="margin-top:25px;right:15px; font-size:22px; "></label>
								<div class="ribbon-wrapper">
									<div class="ribbon bg-warning boxshadow_strong">
										<i>1</i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</li>

			<li>
				<div class="notificacion box-white boxradius boxshadow_strong">
					<div class="container-fluid" style="padding: 0; width: 100%; margin:0">
						<div class="row" style="padding:0; width: 100%; margin:0">
							<div class="col-6 col-lg-3">
								<div class="avatar-list relative">
									<img src="fotos/1000.jpg" alt="" class="avatar avatar-list">
									<span class="cargoicon icon-user bg-primary"></span>
								</div>
							</div>
							<div class="col-0 vn-320 vn-576 vn-768 vb-1024 col-lg-7" style="padding.left:2px;">
								<strong class="text-dark">SARITA TANCREDTA</strong>
							</div>
							<div class="col-6 col-lg-2 relative">
								<label class="icon-block relative text-dark" style="margin-top:25px;right:15px; font-size:22px; "></label>
								<div class="ribbon-wrapper">
									<div class="ribbon bg-dark boxshadow_strong">
										<i class="icon-lock"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</li>
		</ul>
	</div>


	<div class="content-wrapper">
	<br>
	<div class="content">
		<div class="container-fluid">
			<div class="row">
	