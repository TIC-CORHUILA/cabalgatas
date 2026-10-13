<?php

session_start();

if(isset($_GET) && count($_GET)>0){
	session_destroy();
}
else{
	if (isset($_SESSION['name'])) {
		header('location: pages/panel/');
	}
}
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CABALGATAS</title>

    <link rel=" icon" href="dist/img/logo.png" />
	  <!-- Google Font: Source Sans Pro -->
	  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	  <!-- Font Awesome Icons -->
	  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
	  <!-- overlayScrollbars -->
	  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
	  <!-- Theme style -->
	  <link rel="stylesheet" href="dist/css/adminlte.min.css">
	  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	  <style type="text/css">
	  	.login-bg{

	  		background: url('dist/img/login-bg.jpg') no-repeat;
			  background-size: cover;
			  background-position: bottom center;
			  background-attachment: fixed;
	  	}
	  </style>
  </head>

  <body class="login-bg">
    <!-- Container start -->
    <div class="container p-0">
      <!-- Row start -->
      <div class="row g-0">
        <div class="col-xl-3 col-lg-12"></div>
        <div class="col-xl-6 col-lg-12">
          <!-- Row start -->
          <div class="row align-items-center justify-content-center">
            <div class="col-xl-8 col-sm-8 col-12">
              <form action="#" class="my-5">
                <div class="bg-white p-5 rounded-4" style="border-radius: 30px !important">
                  <div class="login-form">
                    <a href="#" class="mb-3 d-flex">
                  		<div style="text-align: center !important">
	                      <img src="dist/img/logo.png" class="img-fluid login-logo" alt="COMERCIALIZADORA" style="float: center !important;width: 60% !important" />
	                    </div>
                    </a>
                    <h4><b>Ingreso</b></h4>
                    <div class="mb-3">
                      <label class="form-label">Usuario</label>
                      <div class="input-group">
                        <input type="number" id="user"  class="form-control" placeholder="Ingresa tu usuario" autocomplete="new-password" />
                      </div>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Contraseña</label>
                      <div class="input-group">
						            <input type="password" id="password" class="form-control" placeholder="Ingresa tu contraseña" autocomplete="new-password" />
						            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
						                <i class="fas fa-eye"></i>
						            </button>
                      </div>
                    </div>
                    <div class="mb-3"  >
                      <button type="button" class="btn btn-primary " style="width: 100% !important;"  onclick="login()">
                        INGRESAR
                      </button>
                    </div>
                    <!-- <div id="message"></div> -->
										<div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert" style="display: none">
                      <b id="message"></b>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <!-- Row end -->
        </div>
      </div>
      <!-- Row end -->
    </div>
    <!-- Container end -->
  </body>


	<!-- REQUIRED SCRIPTS -->
	<!-- jQuery -->
	<script src="plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- overlayScrollbars -->
	<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
	<!-- AdminLTE App -->
	<script src="dist/js/adminlte.js"></script>


  <script type="text/javascript">
    $(document).ready(function(){
        $("#togglePassword").click(function(){
            let input = $("#password");
            let icon = $(this).find("i");

            if (input.attr("type") === "password") {
                input.attr("type", "text");
                icon.removeClass("fa-eye").addClass("fa-eye-slash");
            } else {
                input.attr("type", "password");
                icon.removeClass("fa-eye-slash").addClass("fa-eye");
            }
        });
			$("#user").focus()
    });

		function login(){

      var password = $('#password').val();

			if(password==""){
				Swal.fire({
				  title: 'Atención!',
				  text: 'Las credenciales son requeridas',
				  icon: 'error',
				  confirmButtonText: 'Cerrar'
				})
        return false;
			}

      $.ajax({
        url: 'ajax/index_ajax.php',  // La URL del script en el servidor que procesará el login
        type: 'POST',
        data: {
        	user: $("#user").val(),
        	password: password
        },
        success: function(response) {
          // Maneja la respuesta del servidor
          if (response.success) {
							Swal.fire({
							  title: 'Atención!',
							  text: 'Preparando todo para tí',
							  icon: 'success',
							  confirmButtonText: 'Cerrar'
							});

						  setTimeout(() => {
						    location.href = "pages/panel/";
						  }, 1000); // Espera 1 segundo antes de redirigir
          } else {
						Swal.fire({
						  title: 'Atención!',
						  text: 'Error al ingresar al sistema',
						  icon: 'error',
						  confirmButtonText: 'Cool'
						})
          }
        },
        error: function() {
          $('#message').text('Error del servidor').css('color', 'red');
        }
      });
		}

    // Manejar la tecla "Enter" en el campo de texto
    $('#password').keydown(function(event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Evita el envío del formulario si es necesario
            login();
        }
    });

  </script>

</html>