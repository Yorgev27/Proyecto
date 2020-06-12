<?php
// $icon representa el icono a ser insertado
// $texto representa el texto a mostrar 
// $ruta representa la ruta que se va a dirigir al clickear sobre el 
// ESTA ES LA PALETA DE ESTILOS PARA EL OPTION 
function headerlist_users(){
 	?>
 			<ul class="flex fle-wrap flex-margin">
				<li class="relative">
					<div class="relative bg-gray" style="height: 60px; width:100px;">
						<div class="ribbon-wrapper">
							<div class="ribbon bg-success">
								<i class="icon-check"></i>
							</div>
						</div>
						Activo
						<P>Sin  falta</P>
					</div>
				</li>
				<li class="relative">
					<div class="relative bg-gray" style="height: 60px; width:120px;">
						<div class="ribbon-wrapper">
							<div class="ribbon bg-warning">
								<i>1</i>
							</div>
						</div>
						Alertado
						<P>Con faltas</P>
					</div>
				</li>
				<li class="relative">
					<div class="relative bg-gray" style="height: 60px; width:150px;">
						<div class="ribbon-wrapper">
							<div class="ribbon bg-dark">
								<i class="icon-lock"></i>
							</div>
						</div>
						Bloqueado
						<P>Faltas Completas</P>
					</div>
				</li>
			</ul>
			<form id="form-header" method="post">
				<div class="row">
					<div class="form-group col-4">
						<label>Cargo</label>
						<select class="form-control" name="header_selectcargo">
							<option value="todos">Todos</option>
						<?php 
						require 'conexion.php';
						$consultar_cargos = $conexion->prepare("SELECT * FROM cargo WHERE estado =  'activo'");
						$consultar_cargos->execute();
						$resultados_cargos = $consultar_cargos->get_result();
						while($cargos = $resultados_cargos->fetch_assoc()){
						 ?>
						 		<option value="<?php echo $cargos['id_cargo'] ?>"><?php echo $cargos['nombre'] ?></option>
						<?php } ?>
						</select>
					</div>
					<div class="form-group col-4">
						<label>Estado</label>
						<select class="form-control" name="header_selectactividad">
							<option value="todos">Todos</option>
							<option value="activo">Activo</option>
							<option value="faltas">Con faltas</option>
							<option value="bloqueado">bloqueados</option>
						</select>
					</div>
					<div class="form-group col-4">
						<label>Fecha o dia</label>
						<input type="date" class="form-control" name="header_date">
					</div>
				</div>
				<input type="submit" class="btn btn-primary float-right" name="" value="Buscar">
			</form>
<?php
} // FIN DE LA FUNCION //
?>
<?php

// FUNCION TIME APP DESTNADA AL ASIDE 

// $inco representa el icono
// $texto representa el nombre del app
// $ruta representa la url a redirigir
// $number representa el numero flotante en la app
function itemapp($icon, $texto, $ruta, $number, $id_badge){?>
	<a class="btnapp btn-app" href="<?php echo $ruta ?>">
		<?php // si el numero es cero no mostrara nigun otro numero ?>
		<span class="badge bg-danger" <?php if($number == 0){ ?> style=" display:none" <?php } ?> id="<?php echo $id_badge ?>"><?php echo $number ?></span>
		<i class="<?php echo $icon ?>"></i>
		<?php echo $texto; ?>
	</a>
<?php } ?>

<?php function itemicon($name, $value){ ?>
	<li style="width:100px; margin-top:10px">
		<div style="display: block; margin:auto; text-align: center; width: 50px;">
			<input type="radio" name="<?php echo $name ?>" id="<?php echo $value ?>" value="<?php echo $value?>" required>
			<label for="<?php echo $value ?>" class="icon <?php echo $value?>" style="font-size:25px"></label>
		</div>
	</li>
<?php } ?>


<?php 

// ESTO NOS SERA UTIL AL MOMENTO DE MOSTRAR QUE LAT TABLA SE ENCUENTRA VACIA O QUE NO HAY ENTRADAS RECIENTES //

function NoDateList($text, $textbutton, $urlbutton, $idbutton){
	if($urlbutton != ""){
		$onclick = "window.location='$urlbutton'";
	} else {
		$onclick = "";
	}
	?>
		</tbody>
	</table>
	<div class="announce table boxpadding boxshadow box-white boxshadow relative" style="min-height: 95px;">
		<h5><i class="text-primary icon-exclamation"></i> <?php echo $text ?></h5>
		<?php if($textbutton != ""){ ?>
		<button type="button" id="<?php echo $idbutton ?>" class="btn btn-primary marginauto text-primary" style="background-color: transparent;" onclick="<?php echo $onclick ?>" ><?php echo $textbutton ?></button>
		<?php } ?>
	</div>	
	<?php
} ?>


<?php function Anuncio($text, $textbutton, $urlbutton, $idbutton, $id_anuncio){ 

?>
	<div class="announce table boxpadding boxshadow box-white boxshadow relative" style="min-height: 95px;" id="<?php echo $id_anuncio ?>">
		<div class="contenido">
			<h5><i class="text-primary icon-exclamation"></i> <?php echo $text ?></h5>
			<?php if($textbutton != ""){ ?>
			<button type="button" id="<?php echo $idbutton ?>" class="btn btn-primary marginauto text-primary" style="background-color: transparent;" <?php if($urlbutton != "" || $urlbutton != null){ ?> onclick="window.location='<?php echo $urlbutton ?>'" <?php } ?>><?php echo $textbutton ?></button>
			<?php } ?>
		</div>
	</div>	
<?php } ?>

<?php 

// El titlebox es la parte superior de los boxes que estaran en la parte superior de las cajas blancas donde se muestra el titulo y un buscador a un lado 
/*
$titulo = al nombre del box o de la ventana
$descrpcion = la descripcion del box 
$textsearch = el texto del search a buscar si es que existe un buscador
*/
function TitleBox($titulo, $descripcion, $textSearch){

 ?>
 <div class="container-fluid">
	<div class="row">
		<?php if($textSearch != ""){ ?>
		<div class="col-7">
			<h3><?php echo $titulo ?></h3>
			<span class="text-primary icon-exclamation relative" style="top:20px;"></span>
			<p style="margin-left:20px">
				<?php echo $descripcion ?>
			</p>
		</div>

		<div class="col-5">
			<div class="row mt-4">
				<div class="col-10" style="padding:0">
					<div class="input-group input-group-sm">
						<input type="search" name="" placeholder="<?php echo $textSearch?>" class="form-control form-control-navbar" style="width: 70%;">
						<div class="input-group-append" style="right:5px; top:7px;position: absolute;">
						</div>
					</div>
				</div>
				<div class="col-2" style="padding:0">
					<button class="btn btntd btn-primary" value="buscar" style="margin:0;">
						<label class="icon-search"></label>
					</button>
				</div>
			</div>
		</div>
		<?php } else{  ?>
		<div class="col-12">
			<h3><?php echo $titulo ?></h3>
			<span class="text-primary icon-exclamation relative" style="top:20px;"></span>
			<p style="margin-left:20px">
				<?php echo $descripcion ?>
			</p>
		</div>
		<?php } ?>

	</div>
</div>
<?php 
} 

// ESTO SIRVE PARA CALCULAR LA HORA EN LENGUAJE UNIVERSAL
function CalcularHora($fecha_hora, $retorno){
	$fecha_vitacora = $fecha_hora;
	$fecha = explode(" ", $fecha_vitacora);

	// SEPARAMOS LA FECHA DEL REGISTRO  EN DIA, MES Y AÑO //
	$fecha_separada = explode("-", $fecha[0]);

	// AÑO
	$ano = $fecha_separada[0];
	// MES
	$mesVitacora = $fecha_separada[1];
	// DIA
	$dia = $fecha_separada[2];


	$hora_separada = explode(":",$fecha[1]);

	// SEPARAMOS LA FECHA DE REGISTRO EN HORAS, MINUTOS Y SEGUNDOS

	// HORAS
	$hora = $hora_separada[0];

	// MINUTOS
	$minutos = $hora_separada[1];

	// SEGUNDOS
	$segundos = $hora_separada[2];

	if($hora > 12){
		$hora = $hora-12;
		$indicador = "PM";
	} else {
		$indicador = "AM";
		if($hora == 00){
			$hora = $hora+12;
		}
	}

	// CALCULO DEL MES //

	if($mesVitacora == "01"){
		$mes = "de enero";
	} else if($mesVitacora == "02"){
		$mes = "de febrero";
	} else if($mesVitacora == "03"){
		$mes = "de marzo";
	} else if($mesVitacora == "04"){
		$mes = "de abril";
	} else if($mesVitacora == "05"){
		$mes = "de mayo";
	} else if($mesVitacora == "06"){
		$mes = "de junio";
	} else if($mesVitacora == "07"){
		$mes = "de julio";
	} else if($mesVitacora == "08"){
		$mes = "de agosto";
	} else if($mesVitacora == "09"){
		$mes = "de septiembre";
	} else if($mesVitacora == "10"){
		$mes = "de octubre";
	} else if($mesVitacora == "11"){
		$mes = "de noviembre";
	} else if($mesVitacora == "12"){
		$mes = "de diciembre";
	}

	if($retorno == "hora"){
		$return = $hora.':'.$minutos.' '.$indicador;
	} else if($retorno == "fecha"){
		$return = $dia.' '.$mes.' del '.$ano;
	} else if($retorno == "all"){
		$return = $dia.' '.$mes.' del '.$ano.' <br>'.$hora.':'.$minutos.' '.$indicador;
	}

	return $return;
}


function listloading($background_grid, $bakcground_bootstrap, $text_bootstrap){
?>
	<div class="listloading relative <?php echo $bakcground_bootstrap ?> <?php echo $text_bootstrap ?> boxradius pb-2 pr-2 mb-2 inlineblock" style="display: none;">
		<div class="lds-grid" style="transform: scale(.5); width: 30px; height: 30px;">
		   		<div style="background-color: <?php echo $background_grid ?>;"></div>
		   		<div style="background-color: <?php echo $background_grid ?>;"></div>
		   		<div style="background-color: <?php echo $background_grid ?>;"></div>
		   		<div style="background-color: <?php echo $background_grid ?>;"></div>
		   		<div style="background-color: <?php echo $background_grid ?>;"></div>
		   		<div style="background-color: <?php echo $background_grid ?>;"></div>
		   		<div style="background-color: <?php echo $background_grid ?>;"></div>
		   		<div style="background-color: <?php echo $background_grid ?>;"></div>
		   		<div style="background-color: <?php echo $background_grid ?>;"></div>
		   	</div>
		<h5 class="inlineblock ml-3">Cargando nuevas entradas</h5>
	</div>
<?php  
}

function animation(){
?>
	<div class="lds-grid">
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
	</div>
<?php } ?>


