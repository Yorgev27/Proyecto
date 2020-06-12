function eliminar(e){
	e.preventDefault();
	var boton = e.target.getAttribute('id');
	if(boton == null){
		var boton = e.target.getAttribute('for');
	}

	var tipo_ventana = boton.split("_");
	if(tipo_ventana[0] == "cargo"){
		eliminar_registro(tipo_ventana[1], 'cargo', 'id_cargo',tipo_ventana[2], 'estado');
	} else if(tipo_ventana[0] == "personal"){
		if(tipo_ventana[2] == "descartado"){
			// PARA CMABIAR EL ATRIBUTO ESTADO A DESCARTADO
			eliminar_registro(tipo_ventana[1], 'personal', 'id_huella', tipo_ventana[2], 'estado');
		} else if(tipo_ventana[2] == "eliminado"){
			// PARA CAMBAR EL ATRIBUTO ESTADO A ELIMINADO
			eliminar_registro(tipo_ventana[1], 'personal', 'id_huella',tipo_ventana[2], 'estado');
		} else if(tipo_ventana[2] == "bloqueado"){
			// PARA CAMBIAR EL ESTADO BLOQUEADO A BLOQUEADO
			eliminar_registro(tipo_ventana[1], 'personal', 'id_huella',tipo_ventana[2], 'bloqueado');
		} else if(tipo_ventana[2] == "desbloqueado"){
			// PARA CAMBIAR EL ATRIBUTO BLOQUEADO A DESBLOQUEADO 
			eliminar_registro(tipo_ventana[1], 'personal', 'id_huella',tipo_ventana[2], 'bloqueado');
		}
	} else if(tipo_ventana[0] == "falta"){
		eliminar_registro(tipo_ventana[1], 'faltas', 'id_falta', tipo_ventana[2], 'estado');
	}
}

function abrirVentana(){
	$('.fixed-black').css({'display':'block'});
	$('.fixed-black .ventanaConfirmacion').animate({'opacity':'1'});
}

function eliminar_registro(id, tabla, atributo, intencion, atributoSET){
	abrirVentana();
	$.ajax({
		url: 'registros/consultarExistencia.php',
		type: 'POST',
		dataType: 'json',
		data: 'id='+id+'&tabla='+tabla+'&atributo='+atributo,
		beforeSend:function(){
			$('.fixed-black .ventanaConfirmacion').append(`<div class="lds-grid">
															<div></div>
															<div></div>
															<div></div>
															<div></div>
															<div></div>
															<div></div>
															<div></div>
															<div></div>
															<div></div>
													</div>`);
		}
	})
	.done(function(resp) {
		console.log(resp);
		if(resp.existencia == true){
			var nombre = resp.data['nombre'];
			var icono = resp.data['icono'];
			if(tabla == "faltas"){
				var nombre = resp.data['razon'];
			}
			if(intencion == 'eliminado'){
				var titulo = 'Confirmar eliminación';
				var descripcion = '¿Seguro que deseas eliminar '
			} else if(intencion == 'bloqueado'){
				var titulo = 'Confirmar Bloqueo';
				var descripcion = '¿Seguro que deseas bloquear '
			} else if(intencion == 'desbloqueado'){
				var titulo = 'Confirmar Desbloqueo';
				var descripcion = '¿Seguro que deseas desbloquear '
			} 
			$('.fixed-black .ventanaConfirmacion .lds-grid').css({'display':'none'})
			$('.fixed-black .ventanaConfirmacion').append(`
											<div class="contenido boxpadding">
												<h5 class="textcenter bold text-primary">${titulo}</h5>
												<p class="textcenter">${descripcion}</p>
												<p class="textcenter"><label class="${icono}"></label> <strong>${nombre}?</strong></p>
												<ul class="flex flex-wrap flex-margin">
													<li>
														<input type="submit" class="btn btn-success" id="confirmarEliminacion" value="CONFIRMAR">
													</li>
													<li>
														<button class="btn btn-danger">CANCELAR</button>
													</li>
												</ul>
											</div>`);
			$('#confirmarEliminacion').on('click', function(e){
				confirmarEliminacion(id, tabla, atributo, nombre, intencion, atributoSET);
			})
		}
	})
	.fail(function(resp){
		console.log(resp);
		alert('comprueba tu conexion');
		cerrarventana();
	})
}

function confirmarEliminacion(id, tabla, atributo, nombre, intencion, atributoSET){
	$.ajax({
		url: 'registros/eliminardatos.php',
		type: 'POST',
		dataType: 'json',
		data: 'id='+id+'&tabla='+tabla+'&atributo='+atributo+'&testigo='+nombre+'&intencion='+intencion+'&atributoSET='+atributoSET,
		beforeSend:function(){
			$('.fixed-black .ventanaConfirmacion .lds-grid').css({'display':'block'});
			$('.fixed-black .ventanaConfirmacion .contenido').contents().remove();
		},
	})
	.done(function(resp){
		if(resp.error == false){
			console.log(intencion);
			if(intencion == 'desbloqueado' || intencion == 'bloqueado'){
				window.location = document.URL;
			}
			var tabla = resp.tabla;
			var id = resp.id;
			$('#fila_'+id).addClass('desvanecer_derecha');
			setTimeout(function(){
				$('#fila_'+id).remove();
			}, 550);
			cerrarventana();
		}
	})
	.fail(function(resp){
		console.log(resp);
		alert('comprueba tu conexion');
		cerrarventana();
	})
}