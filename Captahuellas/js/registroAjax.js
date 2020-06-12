
// ESTE ES EL METODO PARA AGREGAR CARGO
$(document).on('submit', '#form_newcargo', function(event){
	registros('form_newcargo', 'nuevocargo', 'registrar', 'cargos.php');
});


// ESTE ES EL METODO PARA EDITAR CARGO
$(document).on('submit', '#form_editcargo', function(event){
	registros('form_editcargo', 'editarcargo', 'editar', 'cargos.php');
});


// ESTE ES EL METODO PARA AGREGAR UNA PERSONA 
$(document).on('submit', '#form-nuevapersona', function(event){
	registros('form-nuevapersona', 'nuevapersona', 'registrar', 'personal.php');
})

// ESTE ES EL METODO PARA EDITAR UNA PERSONA 
$(document).on('submit', '#form-editpersona', function(event){
	registros('form-editpersona', 'editarPersona', 'editar', 'personal.php');
})

// ESTE ES EL METODO PARA AGREGAR UNA FALTA 
$(document).on('submit', '#form-nuevafalta', function(event){
	registros('form-nuevafalta', 'nuevaFalta', 'registrar', 'personal.php');
})




function registros(formulario, metodo, ruta, redireccion){

	// Ejecutamos el prevent Defualt //
	event.preventDefault();

	// Desactvamos el boton //
	var boton = document.querySelector('#'+formulario+' input[type="submit"]');
	boton.disabled;

	// Establecemos la ruta del formulario enviando un dato hidden al formulario
	$('#'+formulario).append('<input type="hidden" name="metodo" value="'+metodo+'">')

	// Tomamos los datos del formularo
	var form = document.querySelector('#'+formulario);
	var datos = new FormData(form);
	$.ajax({
		url: 'registros/'+ruta+'.php',
		type: 'POST',
		dataType: 'json',
		data: datos,
		global: false,
		processData: false,
		async: true,
		contentType: false,
		beforeSend:function(){
			$('#'+formulario+' input[type="submit"]').addClass('disabled')
			$('#'+formulario).append(`
									<div class="fixed-white"
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
									</div>`);
		}
	})
	.done(function(resp) {
		setTimeout(function(){
			window.location = redireccion;
		}, 2500);
	})
	.fail(function(resp) {
		console.log(resp);
	})
	.always(function(resp) {
		console.log(resp);
	});
	
}


// ESTO ES PARA EL REGISTRO DE UNA PERSONA DONDE SE PREVISUALIZARA EL CODIGO DE SUBIR
// AVATAR Y EL REGISTRO DE LA PERSONA 

// Cuando una persona sube una imagen //

$('#subirfoto_persona').change(function(){
	filePreview(this)
})

function filePreview(input){
	if(input.files && input.files[0]){
		var type = input.files[0].type;
		var size = input.files[0].size;
		console.log(input.files);
		console.log(size);
		if(type == "image/jpeg" || type == "image/JPEG" || type == "image/png" || type == "image/PNG" || type=="image/jpg" || type=="imagen/JPG"){
			if (size <= 1000000){
				var reader = new FileReader();
				reader.onload = function(e){
					var label = input.parentElement.lastElementChild;
					label.innerHTML = input.files[0].name;
					$('#fotopersonal').attr("src", e.target.result);
				}
				reader.readAsDataURL(input.files[0]);
			} else {
				$('#invalidImage').slideDown('slow');
			}
		} else {
			$('#invalidImage').slideDown('slow');
		}

	}
}
