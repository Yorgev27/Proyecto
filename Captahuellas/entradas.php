
<?php include 'components/header.php'; ?>

<div class="col-12 col-lg-8">
	<div class="box box-white boxshadow_strong">
		<div class="contenido boxpadding">
			<div class="title">
				<!-- este es el contenido del title donde tomaremos como referencia la clase titleBox que se encuentra en la carpeta Components/optim.php -->
				<?php echo TitleBox('Entradas / Salidas', 'Ultimas entradas registradas', 'Buscar por Cedula') ?>
				<!-- Esta es la lista de informacion y leyenda de la parte superior -->
				<?php echo headerlist_users(); ?>

				<!-- esta es la animacion de loading  -->
				<?php echo listloading('white', 'bg-primary', 'text-white'); ?>
			</div>
		</div>
	</div>

<br>
<div class="box box-white boxshadow_strong">
	<div class="contenido boxpadding">
		<?php echo date("d/m/Y ") ?>
		<div class="body relative" style="min-height: 150px;">
			<!-- aqui comienza la tabla  -->
			<table class="table">
				<!-- cabecera de la tabla  -->
				<thead>
					<tr>
						<th class="textcenter">Foto</th>
						<th class="textcenter">Cedula</th>
						<th class="textcenter">Nombre</th>
						<th class="textcenter">Hora</th>
						<th class="textcenter">E/S</th>
					</tr>
				</thead>
				<tbody id="tbody" class="relative">
			</table>
		</div>
	</div>
</div>
</div>
<?php include 'components/footer.php'; ?>

<script type="text/javascript">
	escaner_entrada();

	function cargar_lista(){

		// Creamos nuestra conexion
		var req = new XMLHttpRequest();
		$('#tbody').append(`<div class="fixed-white"
						 style="position: absolute;
						  width:100%; height: 100%;
						   top:0; left:0; 
						   background-color: white; opacity: .5; z-index: 50;">
						   	<div class="lds-grid" style="margin-top:55px;">
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
						</div>`);
		req.onreadystatechange = function(){
			if(req.readyState == 4 && req.status == 200){
				document.querySelector('.fixed-white').style.display = "none";
				var contenido = document.getElementById('tbody').innerHTML = req.responseText;
			}
		}
		req.open("POST", "components/listas.php", true);

		req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		req.send("metodo=entradas");
	}
	$(document).ready(function(){
		cargar_lista();
	});
</script>