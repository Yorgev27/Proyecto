// ESTO ES PARA CERRAR LAS VENTANAS 
$('.fixed-black').on('click', function(e){
	// TOMAMOS EL OBJETO AL QUE DIO CLICK
	var objeto_click = e.target.getAttribute('class');
	console.log(objeto_click);
	if(objeto_click == 'fixed-black'){
		cerrarventana();
	}
})

// ESTO ES PARA CERRAR LA VENTANA MEDIANTE EL BOTON DE LA X
$('.closewindow').on('click',function(e){
// TOMAMOS EL OBJETO AL QUE DIO CLICK
	var objeto_click = e.target.getAttribute('class');
	console.log(objeto_click);
	if(objeto_click == 'icon-x closewindow'){
		cerrarventana();
	}
})

function cerrarventana(){
	$('.fixed-black').css({'display':'none'})
	$('.fixed-black .ventanaConfirmacion .lds-grid').contents().remove();
	$('.fixed-black .ventanaConfirmacion .contenido').css({'opacity':'0'});
	$('.fixed-black .ventanaConfirmacion .contenido').remove();
}

function getanimation(texto){
	var animation = `<div class="fixed-white"
						 style="position: absolute;
						  width:100%; height: 100%;
						   top:0; left:0; 
						   background-color: white; opacity: .5; z-index: 50;">
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
						   	<h5 class="relative" style="top:85px">${texto}</h5>
						</div>`;
	return animation;
}

function animation_sinfixed(){
	var animation = `<div style="display:inline-block; margin:auto;">
						<div class="lds-grid block" style="margin:auto;">
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
					</div>`;
	return animation;
}


// FUNCION QUE SE UTILIZA PARA BUSCAR EN LAS LISTAS
// ESTE ES EL METODO PARA AGREGAR UNA FALTA 
$(document).on('submit', '#form-header', function(event){
	// Ejecutamos el prevent Defualt //
	event.preventDefault();
	// Desactvamos el boton //
	var boton = document.querySelector('#form-header input[type="submit"]');
	boton.disabled;

	// Establecemos la ruta del formulario enviando un dato hidden al formulario
	$('#form-header').append('<input type="hidden" name="metodo" value="entradas_update">')

	// Tomamos los datos del formularo
	var datos =  $(this).serialize();
	buscar_lista(datos);

})

function buscar_lista(datos){
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
			document.querySelector('#tbody .fixed-white').style.display = "none";
			var contenido = document.getElementById('tbody').innerHTML = req.responseText;
		}
	}
	req.open("POST", "components/listas.php", true);

	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	req.send(datos);
}