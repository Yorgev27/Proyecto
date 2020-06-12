<!-- TODO ESTO NOS REPRESENTA EL HEADER  -->

<?php 
// ESTA FUNCION NOS PERMITIRA SABER SI EL ADMINISTRADOR ESTA CONECTADO
require '../conexion.php';
error_reporting(0);
// VALIDADOR DE LA RUTA, PARA SABER SI SE ENCUENTRA DENTO DEL SISTEMA
if($_SESSION['correo'] != null || $_SESSION['correo'] != ""){
	header("location: ../");
} 
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Captahuellas - Unefa</title>
	<link rel="stylesheet" type="text/css" href="../bootstrap/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/default.css">
	<link rel="stylesheet" type="text/css" href="../css/responsive.css">
	<link rel="stylesheet" type="text/css" href="../iconos/styles.css">
	<link rel="stylesheet" type="text/css" href="../css/botones.css">
	<link rel="stylesheet" type="text/css" href="../css/login.css">
	<script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
</head>
<body>

<div class="content-all">
	<div class="container-fluid">
		<div class="row">

			<!-- ESTE ES EL HEADER DEL REGSITRO QUE APARECERA EN VERSIONES MOBILES  -->
			<div class="vb-320 vn-768 vn-1024 vn-1366 vn-1920 box box-white boxhshadow_strong">
					<ul class="boxheader flex flex-margin">
						<li>
							<img src="../img/unefa.png" alt="" style="width:125px; height: 125px;">
						</li>
						<li>
							<h1 class="text-white">Unefa Lara</h1>
							<span class="linea linea-white"></span>
							<h3 class="text-white">Excelencia Educativa</h3>
						</li>
					</ul>
			</div>
			<div class="box col-12 col-sm-12 col-md-10 col-lg-9 col-xl-8 marginauto box-white boxshadow_strong" id="boxlogin">
				<div class="container-fluid fullheight padding-0">
					<div class="row fullheight">
						<div class="col-12 col-md-6 boxpadding">
							<div>
								<h2 class="bold">Iniciar Sesión</h2>
							</div>
							<br>

							<!-- // ESTA ES LA ALERTA DEL USUARIO EN CASO DE QUE LA CONTRASEÑA SEA ERRONEA -->

							<!-- *****************************************************************
								 *****************************************************************
									 POR EL MOMENTO SE ENCUENTRA NO VISIBLE PARA EL USUARIO
								 *****************************************************************	 -->
							<div class="alert alert-danger alert-dismissible" style="display: none;">
								<button type="button" class="close">X</button>
								<h5>
									<i class="icon-block"></i>
									Error de sesión
								</h5>
								Nombre de usuario o contraseña invalidos, introduzca de nuevo.
							</div>

							<!-- FORMULARIO DE REGISTRO  -->
							<div>	
								<form action="" id="formlogin">
									<br>
									<div class="boxform-login">
										<input type="text" name="user" id="user" required placeholder="Usuario:" pattern="[A-Za-z0-9_-]{1,15}">
									</div>
									<br>
									<div class="boxform-login">
										<input type="password" name="password" id="password" required placeholder="Contraseña:" autocomplete="false" pattern="[A-Za-z0-9_-]{1,15}">
										<label class="icon-eye labelicon inputlabel"></label>
									</div>
									<br>
									<button class="block btn btn-primary btn-radius btnhover block marginauto boxshadow_strong">Iniciar</button>
								</form>
							</div>
							<br>

							<!-- ACCIONES QUE PUEDE TOMAR EL USUARIO  -->
							<div>
								<ul class="flex flex-margin">
									<li class="textcenter">
										<a href="#" title="">¿Olvidaste tu usuario?</a>
									</li>
									<li class="textcenter">
										<a href="#" title="">¿Olvidaste tu contraseña?</a>
									</li>
								</ul>
							</div>
						</div>

						<!-- ESTE ES EL DIV QUE APARECE EN PANTALLAS SUPERIORES A 768PX DE ANCHO  -->
						<div class="col-12 col-md-6 vn-320 vn-576 vb-768 padding-0">
							<ul class="boxheader flex flex-margin fullheight">
								<li>
									<img src="../img/unefa.png" alt="" style="width:100px; height: 100px;">
								</li>
								<li class="textcenter">
									<h2 class="text-white">Unefa Lara</h2>
									<span class="linea linea-white"></span>
									<h4 class="text-white">Excelencia Educativa</h4>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

	<!-- // ARCHIVO JAVASCRIPT QUE NOS PERMITE LOGEARNOS  -->
	<script type="text/javascript" src="../js/login.js"></script>

	<!-- TODO ESTO REPRESENTA EL FOOTER EN UNA PEQUEÑA FUNCION  -->
	</div> <?php // END DE CONTENT-ALL ?>
</body>
</html>