
function verQr(id){
	$("#id_user").val(id);

  $.ajax({
      url: 'index_ajax.php',  // La URL del script en el servidor que procesará el login
      type: 'POST',
      data: {
      	id : id,
      	action : 'verQr'
      },
      success: function(response) {
				img = 'assets/images/codes/'+id+'.png';
				$("#verQrDiv").html('<img src="'+img+'" class="img-thumbnail" style="width:250px !important;" >');
      },
      error: function() {
          $('#message').text('Request Error').css('color', 'red');
      }
  });

}

function verBarCode(id){
	$("#id_user").val(id);

  $.ajax({
      url: 'index_ajax.php',  // La URL del script en el servidor que procesará el login
      type: 'POST',
      data: {
      	id : id,
      	action : 'verBarCode'
      },
      success: function(response) {
				img = 'assets/images/codes/bar/'+id+'.png';
				$("#verBarCodeDiv").html('<img src="'+img+'" class="img-thumbnail" style="width:300px !important;height:150px !important " >');
      },
      error: function() {
          $('#message').text('Request Error').css('color', 'red');
      }
  });

}


function loadId(id){

	$("#id_user").val(id)
	loadNFC()
}


function saveNFC(){

	if($("#NFC").val()!=""){
    $.ajax({
      url: 'index_ajax.php',  // La URL del script en el servidor que procesará el login
      type: 'POST',
      data: {
      	id : $("#id_user").val(),
      	nfc : $("#NFC").val(),
      	action : 'saveNFC'
      },
      success: function(response) {

      	$("#closeNFC").click()
      	alert("NFC saved")
      },
      error: function() {
          $('#message').text('Request Error').css('color', 'red');
      }
    });
	}
}

function loadNFC(){

  $.ajax({
    url: 'index_ajax.php',  // La URL del script en el servidor que procesará el login
    type: 'POST',
    data: {
    	id : $("#id_user").val(),
    	action : 'loadNFC'
    },
    success: function(response) {


    	$("#NFC").val(response.NFC);

    },
    error: function() {
        $('#message').text('Request Error').css('color', 'red');
    }
  });
}


function modalUsuarios(){




}

function consultarUsuario(id){


	$.ajax({
	  url: 'index_ajax.php',  // La URL del script en el servidor que procesará el login
	  type: 'POST',
	  data: {
	  	action: 'consultarUsuario',
	  	id: id,
	  },
	  success: function(response) {

	  	if(response.success){

	  		$("#idHidden").val(id)
	  		$("#username").val(response.data.name)
	  		$("#email").val(response.data.email)
	  		$("#rol").val(response.data.rol)


		  	$("#crearModalBtn").click();
	  	}

	  },
	  error: function() {
			Swal.fire({
			  title: 'Atención',
			  text: 'Error del servidor',
			  icon: 'warning',
			  confirmButtonText: 'Cerrar'
			})
	  }
	});
}


function guardarUsuarios(){


	if($("#username").val()==""){
		Swal.fire({
		  title: 'Atención',
		  text: 'Debe ingresar el nombre del usuario',
		  icon: 'warning',
		  confirmButtonText: 'Cerrar'
		})
		return false;
	}

	if($("#email").val()==""){
		Swal.fire({
		  title: 'Atención',
		  text: 'Debe ingresar el email del usuario',
		  icon: 'warning',
		  confirmButtonText: 'Cerrar'
		})
		return false;
	}

	if($("#rol").val()==""){
		Swal.fire({
		  title: 'Atención',
		  text: 'Debe seleccionar el rol del usuario',
		  icon: 'warning',
		  confirmButtonText: 'Cerrar'
		})
		return false;
	}


	$.ajax({
	  url: 'index_ajax.php',  // La URL del script en el servidor que procesará el login
	  type: 'POST',
	  data: {
	  	action: 'guardarUsuario',
	  	id: $("#idHidden").val(),
	  	user: $("#username").val(),
	  	email: $("#email").val(),
	  	password: $("#password").val(),
	  	rol: $("#rol").val(),
	  },
	  success: function(response) {
	  	if(response.success){
				Swal.fire({
				  title: 'Atención',
				  text: 'Datos guardados correctamente',
				  icon: 'success',
				  confirmButtonText: 'Cerrar'
				})

				setTimeout(function() {
					location.reload()
				}, 1000);
	  	}
	  	else{
				Swal.fire({
				  title: 'Atención',
				  text: 'El correo ya existe asociado a un usuario',
				  icon: 'error',
				  confirmButtonText: 'Cerrar'
				})
	  	}
	  },
	  error: function() {
	    $('#message').text('Error del servidor').css('color', 'red');
	  }
	});


}