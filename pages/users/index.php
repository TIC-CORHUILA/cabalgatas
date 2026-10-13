<?php

include('../../config/conex.php');

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['id'])) {
  header('Location: ../../');
  exit();
}

//Query users
$sql="SELECT * FROM usuarios";
$res=queryli($sql,2);

$atras = '../../';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cabalgatas</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../../dist/css/change.css">

</head>
<body class="hold-transition  sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="../../dist/img/logo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item" >
        <a class="nav-link" style="color:white  !important" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item" >
        <a href="../../?cerrar" class="nav-link">
          <i class="nav-icon fas fa-power-off" style="color:white  !important"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../" class="brand-link">
      <img src="../../dist/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Cabalgatas</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">
          	<?php
          		echo $_SESSION['name'];
          	?>
          </a>
        </div>
      </div>

      <?php
      	$menu = 'usuarios';

      	include('../../config/menu.php');

      ?>

    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><b>Usuarios</b></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><b style="color: white !important">Inicio</b></a></li>
              <li class="breadcrumb-item active"><b>Usuarios</b></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

        <!-- App body starts -->
        <div class="app-body">
					<input type="hidden" id="id_user">
          <!-- Container starts -->
          <div class="container">

            <!-- Row start -->
            <div class="row gx-3">
              <div class="col-12 col-xl-6">
              </div>

								<div class="container" style="margin-bottom:25px;">
									<div class="row">
					          <div class="col-md-11"></div>
					          <div class="col-md-1">
											<button type="button"  class="btn btn-primary btn-block " onclick="abrirModal('')"><i class="fas fa-plus"></i></button>
					          </div>
									</div>
								</div>


            </div>
            <!-- Row end -->

            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped" width="100%">
                  <thead >
                    <tr>
                      <th></th>
                      <th>Nombre</th>
                      <th>Documento</th>
                      <th>Email</th>
                      <th>Celular</th>
                      <th>Rol</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                          <tbody>

                          <?php

                          	$i = 1;
                          	foreach ($res as $key => $value) {

                        			if($value['rol']==0)
                        				$value['rol'] = "Administrador";
                        			if($value['rol']==1)
                        				$value['rol'] = "Organizador de eventos";

                          		if($value['status']==1) $value['status'] = '<button style="width: 100% !important; " onclick="changeStatus('.$value["id"].',2)" class="btn btn-success addToCart">Activo</button>';
                          		else if($value['status']==2) $value['status'] = '<button style="width: 100% !important; " onclick="changeStatus('.$value["id"].',1)" class="btn btn-danger addToCart">Inactivo</button>';

                          		echo '
                          		<tr>
	                              <td>'.$i.'</td>
	                              <td>
	                                '.$value['name'].'
	                              </td>
	                              <td>'.$value['documento'].'</td>
	                              <td>'.$value['email'].'</td>
	                              <td>'.$value['celular'].'</td>
	                              <td>'.$value['rol'].'</td>
	                              <td>'.$value['status'].'</td>

	                              <td>
                                  <i class="fas fa-edit	" onclick="consultarUsuario('.$value['id'].')"  style="font-size:15px;color:black !important" ></i>
	                              </td>
	                            </tr>';
                            $i++;
                          	}

                          ?>
                       	 </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>

						<div class="modal fade" id="crearModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="modal-title" id="exampleModalLabel"><b>Usuarios</b></h5>
						        <button type="button" class="btn btn-primary" onclick="cerrarModal()" aria-label="Close">
						          <i class="fas fa-close">X</i>
						        </button>
						      </div>
						      <div class="modal-body" style="text-align: center;">
						        <div class="row">
						          <div class="col-sm-12 col-12">
						            <input type="hidden" id="idHidden">
								        <div class="row">

								          <div class="col-md-6" style="text-align: left;">
								            <label for="tipo_documento" class="form-label">Tipo documento</label>
								            <select id="tipo_documento" class="form-control">
								              <option value="1">CC</option>
								              <option value="2">NIT</option>
								            </select>
								          </div>
								          <div class="col-md-6">
								            <div style="text-align: left;">
								              <label for="documento" class="form-label">Documento</label>
								              <input type="text" class="form-control" id="documento" placeholder="Documento">
								            </div>
								          </div>
								        </div>
						            <div class="row">
						              <div class="col-md-12">
						                <div style="text-align: left;">
						                  <label for="username" class="form-label">Nombre</label>
						                  <input type="text" class="form-control" id="username" placeholder="Nombre" value="" />
						                </div>
						              </div>
						            </div>
						            <div class="row">
						              <div class="col-md-6">
						                <div style="text-align: left;">
						                  <label for="email" class="form-label">Email</label>
						                  <input type="text" class="form-control" id="email" placeholder="Email" value="" />
						                </div>
						              </div>
						              <div class="col-md-6">
						                <div style="text-align: left;">
						                  <label for="celular" class="form-label">Celular</label>
						                  <input type="text" class="form-control" id="celular" placeholder="Celular" value="" />
						                </div>
						              </div>

						            </div>
						          </div>
						        </div>
						        <div class="row">
						          <div class="col-md-6">
						            <div style="text-align: left;">
						              <label for="password" class="form-label">Password</label>
						              <input type="text" class="form-control" id="password" placeholder="Password">
						            </div>
						          </div>
						          <div class="col-md-6" style="text-align: left;">
						            <label for="rol" class="form-label">Rol</label>
						            <select id="rol" class="form-control">
						              <option value="" selected>Seleccione</option>
						              <option value="0">Administrador</option>
						              <option value="1">Organizador de eventos</option>

						            </select>
						          </div>
						        </div>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="cerrarModal()">Cerrar</button>
						        <button type="button" class="btn btn-primary" onclick="guardarUsuarios()">Guardar</button>
						      </div>
						    </div>
						  </div>
						</div>


          </div>
          <!-- Container ends -->

        </div>
        <!-- App body ends -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer" style="color: #001242 !important">
    <strong>Copyright &copy; <?=date('Y')?></strong>
   Todos los derechos reservados.
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../plugins/jszip/jszip.min.js"></script>
<script src="../../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<link rel="stylesheet" href="../../dist/css/change.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script>
  $(function () {

		$(document).ready(function() {
		    let table = $('#example1').DataTable({
		        "dom": '<"row"<"col-md-8"f><"col-md-4 d-flex justify-content-end"B>>rtip',
		        "buttons": [
		            {
		                extend: "excel",
		                text: "Excel",
		                exportOptions: { columns: ":not(:last-child)" }
		            },
		            {
		                extend: "pdf",
		                text: "PDF",
		                exportOptions: { columns: ":not(:last-child)" }
		            }
		        ],
		        "autoWidth": true,
		        "paging": true,
		        "lengthChange": false,
		        "searching": true,
		        "ordering": true,
		        "info": true,
		        "responsive": true,
		        "language": {
		            "decimal": ",",
		            "thousands": ".",
		            "lengthMenu": "Mostrar _MENU_ registros por página",
		            "zeroRecords": "No se encontraron resultados",
		            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
		            "infoEmpty": "Mostrando 0 de 0 registros",
		            "infoFiltered": "(filtrado de _MAX_ registros totales)",
		            "search": "Buscar:",
		            "paginate": {
		                "first": "Primero",
		                "last": "Último",
		                "next": "Siguiente",
		                "previous": "Anterior"
		            }
		        }
		    });

		    // Asegura que los botones estén en su posición
		    table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(1)');
		});

   });

  function abrirModal(id){
		$("#username").val('')
		$("#tipo_documento").val(1)
		$("#documento").val('')
		$("#email").val('')
		$("#password").val('')
		$("#rol").val('1')
  	$("#crearModal").modal()
	  $("#idHidden").val(id)
  }

  function cerrarModal(){
		$('#crearModal').modal('hide');
  }

	function guardarUsuarios(){

		if($("#username").val()==""){
			Swal.fire({
			  title: 'Atención',
			  text: 'El nombre es requerido',
			  icon: 'warning',
			  confirmButtonText: 'Cerrar'
			})
			return false;
		}

		if($("#email").val()==""){
			Swal.fire({
			  title: 'Atención',
			  text: 'El email es requerido',
			  icon: 'warning',
			  confirmButtonText: 'Cerrar'
			})
			return false;
		}

		if($("#password").val()=="" && $("#idHidden").val()==""){
			Swal.fire({
			  title: 'Atention',
			  text: 'La contraseña es requerido',
			  icon: 'warning',
			  confirmButtonText: 'Cerrar'
			})
			return false;
		}

		$.ajax({
		  url: '../../ajax/user_ajax.php',  // La URL del script en el servidor que procesará el login
		  type: 'POST',
		  data: {
		  	action: 'guardarUsuarios',
		  	id : $("#idHidden").val(),
		  	name : $("#username").val(),
		  	email : $("#email").val(),
		  	password : $("#password").val(),
		  	tipo_documento : $("#tipo_documento").val(),
		  	rol : $("#rol").val(),
		  	documento : $("#documento").val(),
		  	celular : $("#celular").val(),
		  },
		  success: function(response) {
		  	if(response.success){
					Swal.fire({
					  title: 'Atención',
					  text: 'Datos almacenados correctamente',
					  icon: 'success',
					  confirmButtonText: 'Cerrar'
					})

				  setTimeout(() => {
				    location.reload()
				  }, 1000); // Espera 1 segundo antes de redirigir
		  	}
		  	else{
					Swal.fire({
					  title: 'Atención',
					  text: 'Error en el servidor',
					  icon: 'error',
					  confirmButtonText: 'Cerrar'
					})
		  	}
		  },
		  error: function() {
				Swal.fire({
				  title: 'Atención',
				  text: 'Error en el servidor',
				  icon: 'error',
				  confirmButtonText: 'Cerrar'
				})
		  }
		});

	}

	function consultarUsuario(id){

		$("#username").val('')
		$("#tipo_documento").val(1)
		$("#documento").val('')
		$("#celular").val('')
		$("#email").val('')
		$("#password").val('')
		$("#rol").val('1')
		abrirModal(id)

		if(id!=""){
			$.ajax({
			  url: '../../ajax/user_ajax.php',  // La URL del script en el servidor que procesará el login
			  type: 'POST',
			  data: {
			  	action: 'consultarUsuario',
			  	ID: $("#idHidden").val(),
			  },
			  success: function(response) {

			  	if(response.success){

			  		$("#username").val(response.data.name)
			  		$("#email").val(response.data.email)
			  		$("#tipo_documento").val(response.data.tipo_documento)
			  		$("#documento").val(response.data.documento)
			  		$("#rol").val(response.data.rol)
			  		$("#celular").val(response.data.celular)

			  	}
			  },
			  error: function() {
					Swal.fire({
					  title: 'Atention',
					  text: 'Server Error',
					  icon: 'error',
					  confirmButtonText: 'Cerrar'
					})
			  }
			});
		}
	}

			function changeStatus(id, value){

				$.ajax({
				  url: '../../ajax/user_ajax.php',  // La URL del script en el servidor que procesará el login
				  type: 'POST',
				  data: {
				  	action: 'changeStatus',
				  	id: id,
				  	value: value,
				  },
				  success: function(response) {
				  	if(response.success){
							Swal.fire({
							  title: 'Atención',
							  text: 'Estado actualizado correctamente',
							  icon: 'success',
							  confirmButtonText: 'Cerrar'
							})
				  	}
				  	setTimeout(function() {location.reload()}, 500);
				  },
				  error: function() {
						Swal.fire({
						  title: 'Atención',
						  text: 'Error en el servidor',
						  icon: 'error',
						  confirmButtonText: 'Cerrar'
						})
				  }
				});


			}

</script>

</body>
</html>
