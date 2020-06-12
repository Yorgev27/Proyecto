
// Al hacer click en actuaizar datos de la creacion de un nuevo personal
$("#btn_generarUserinfo").on("click", function(e){
	$('#result').css({'display':'none'});
	$('#result').removeClass('bg-danger');
	$('#result').removeClass('bg-success');
	$('#result').contents().remove();
	Generar_userInfo(e)
});


function Generar_userInfo(e){
	// target del anuncio // 
	var announce = e.target.parentElement.parentElement.parentElement.parentElement.lastElementChild;
	// tomamos el target del box //
	var box = e.target.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement;
	$.ajax({
		url: 'registroAccess/consultas.php',
		type: 'POST',
		dataType: 'json',
		data: 'accion=extraer_userinfo',
		beforeSend:function(){
			const div = document.createElement("div")
			div.className = 'fixed-white';
			div.innerHTML = getanimation('');
			box.appendChild(div);
		}
	})
	.done(function(resp) {
		// Tomamos los datos suministrados por el ajax // 
		var id = resp['id'];
		var nombre = resp['nombre'];
		// Colcamos los datos dentro de la lista // 
		if(id.length > 0 && nombre.length > 0 ){
			if(id.length == nombre.length){
				if(announce.classList[0] == "announce"){
					$(announce).remove();
				}
				var body_table = document.querySelector('tbody');
				var tr_first = body_table.firstElementChild;

				var tr = [];
				for(var i = 0; i < id.length; i++){
					tr[i] = document.createElement("tr")
					tr[i].className = 'aparecer_derecha';
					tr[i].innerHTML = ` 
									<td>${id[i]}</td>
									<td class="relative"><span class="badge badge-danger parpadeo " style="position:absolute; right:2px; top:2px">New</span><p class="relative" style="top:10px">${nombre[i]}</p></td>
									<td><button class="btn btn-primary" onclick="window.location='nuevapersona.php?id=${id[i]}&nombre=${nombre[i]}'">Registrar</button></td>
									<td><button class="btn btn-danger">Denegar</button></td>
									`;

				}
				var valor = $('#badge_registrarse').contents().text();
				if(valor != ""){
					var numero = parseInt(valor);
				} else {
					var numero = 0;
				}
				var resultado = numero + tr.length;
				document.querySelector('#badge_registrarse').innerHTML = resultado;
				$('#badge_registrarse').css({'display':'block'});
				$('.fixed-white').css({'display':'none'});
			}

			Insertar_rt_animacion(tr, body_table, tr_first);

			$('#result').addClass('bg-success');
			$('#result').append('<span><strong>'+id.length+'</strong><span> Nuevos Resultados </span><label class="icon-check relative" style="top:4px;"></label></span>');
			$('#result').css({'display':'inline-block'});
			$('.fixed-white').css({'display':'none'});
		} else {
			$('#result').addClass('bg-danger');
			$('#result').append('<span><strong></strong><span> No se han encontrado nuevos resultados </span><label class="icon-x relative" style="top:4px;"></label></span>');
			$('#result').css({'display':'inline-block'});
			$('.fixed-white').css({'display':'none'});
		}
	})
	.fail(function(resp) {
		console.log('fail',resp)
	})
}

function escanear_entradas_aside(){

}


function escaner_entrada(){
	$.ajax({
		url: 'registroAccess/consultas.php',
		type: 'POST',
		dataType: 'json',
		data: 'accion=extraer_entradas',
		beforeSend: function(){
			$('.listloading').slideDown('slow');
		},
		success:function(){
			$('.listloading').removeClass('bg-primary');
			$('.listloading h5').contents().remove();
			$('.listloading .lds-grid').remove();
			$('.listloading').removeClass('pb-2');
			$('.listloading h5').addClass('relative');
			$('.listloading h5').addClass('mt-2');
		}
	})
	.done(function(resp) {
		console.log(resp);
		var num_entradas = resp.num_entradas;
		$('.listloading').addClass('bg-success');
		$('.listloading h5').append('<label class="icon-check relative" style="top:5px; right:10px;"></label><strong>'+num_entradas+'</strong> entradas nuevas');
		// ARRAYS A LLEVAR 
		var cedula = resp.cedula;
		if(cedula != undefined){

			var bloqueo = resp.bloqueo;
			var faltas = resp.faltas;
			var id_personal = resp.id_personal
			var nombre = resp.nombre;
			var foto = resp.foto;
			var cargo = resp.cargo;
			var fecha_hora = resp.fecha_hora;
			var entro_salio = resp.entro_salio;
			var tr = [];

			// TOMAMOS EL BODY DE LA TABLA
			var body_table = document.querySelector('tbody')
			// TOMAMOS EL PRIMER HIJO DE LA TABLA
			var tr_first = body_table.firstElementChild;
	
			for(var i = 0; i < cedula.length; i++){
				tr[i] = document.createElement("tr");
				tr[i].className = "aparecer_derecha";

				// DETERMINAMOS SI El USUARIO ENTRO O SAlIO
				if(entro_salio[i] == 'salio'){
					es = `<label class="icon-sign-in relative text-success" style="top:22px; right:10px; font-size: 22px;"></label>`;
				} else{
					es = `<label class="icon-sign-out relative text-danger" style="top:22px; right:10px; font-size: 22px;"></label>`;
				}

				// DETERMINAMOS El ESTADO EN QUE SE ENCUENTRA El USUARIO
				if(bloqueo[i] == 'bloqueado'){
					var text_ribbon = `<div class="ribbon bg-dark boxshadow_strong">
											<i class="icon-lock"></i>
										</div>`;
				} else if(bloqueo[i] == 'desbloqueado' && faltas[i] > 0){
					var text_ribbon = `<div class="ribbon bg-warning boxshadow_strong">
											<i class="bold" style="font-size:22px;">${faltas[i]}</i>
										</div>`;
				} else if(bloqueo[i] == 'desbloqueado' && faltas[i] == 0){
					var text_ribbon = `<div class="ribbon bg-success boxshadow_strong">
											<i class="icon-check"></i>
										</div>`
				}

				tr[i].innerHTML = `
									<td class="foto relative">
										<div class="relative avatar-list">
											<img src="fotos/${foto[i]}" alt="" class="avatar-list avatar-radius">
											<label class="cargoicon bg-primary ${cargo[i]}"></label>
										</div>
									</td>
									<td class="relative">
										${cedula[i]}
										<span class="badge badge-danger parpadeo" style="absolute; left:0; bottom:20px">New</span>
									</td>
									<td class="bold text-primary">
										<a href="persona.php?id=${id_personal[i]}" title="">${nombre[i]}</a>
									</td>
									<td class="relative">
										<label class="icon-clock-o"></label>
										<span>${fecha_hora[i]}</span>
									</td>

									<td class="relative">
										${es}
										<div class="ribbon-wrapper">
											${text_ribbon}
										</div>
									</td>
								  `;

			}
			if(tr_first == undefined){
				$('.announce').css({'display':'none'});
			}
			Insertar_rt_animacion(tr, body_table, tr_first);
		}	
	})
	.fail(function(resp) {
		console.log(resp);
		$('.listloading').addClass('bg-danger');
		$('.listloading h5').append('<label class="icon-x relative" style="top:5px; right:10px;"></label>Error al cargar, comprueba tu conexion');
	});
}

function insertartr(resp){

}

function Insertar_rt_animacion(tr, body_table, tr_first){
	var i = 0;
	var indexarLista = setInterval(function(){
		if(i < tr.length){
			body_table.insertBefore(tr[i], tr_first);
			i++;
		} else {
			clearInterval(indexarLista);
			indexarLista = "";
		}
	}, 1000);
}