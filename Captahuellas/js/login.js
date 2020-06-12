$(document).on('submit', '#formlogin', function(event){
	event.preventDefault();
	$.ajax({
		url: 'conectarse.php',
		type: 'POST',
		dataType: 'json',
		data: $(this).serialize(),
		beforeSend:function(){

		}
	})
	.done(function(respuesta) {
		console.log(respuesta.error);
		if(respuesta.error == false){
			window.location="../index.php";
		} else {
			$('.alert-danger').slideDown('slow');
			setTimeout(function(){
				$('.alert-danger ').slideUp('slow');
			}, 3000);
		}
	})
	.fail(function(resp) {
		console.log(resp);
	})
	.always(function() {
		console.log("complete");
	});
	
})