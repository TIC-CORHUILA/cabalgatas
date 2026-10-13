<?php

include('../../config/conex.php');

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['id'])) {
  header('Location: ../../');
  exit();
}

//Query users
$sql="SELECT * FROM ejemplares";
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
  <style type="text/css">


        .custom-file-label {
            display: inline-block;
            padding: 8px 15px;
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            cursor: pointer;
            border-radius: 5px;
        }

  </style>
</head>
<body class="hold-transition  sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
	<input type="hidden" id="idHidden">
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
      <span class="brand-text font-weight-light">Ejemplares</span>
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
      	$menu = 'ejemplares';
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
            <h1 class="m-0"><b>Ejemplares</b></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><b style="color: white !important">Inicio</b></a></li>
              <li class="breadcrumb-item active"><b>Ejemplares</b></li>
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
                  <thead>
                    <tr>
                      <th></th>
                      <th>Nombre</th>
                      <th>Chip</th>
                      <th>Peso</th>
                      <th>Especie</th>
                      <th>Raza</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                          <tbody>

                          <?php

                          	$i = 1;
                          	foreach ($res as $key => $value) {

                          		echo '
                          		<tr>
	                              <td>'.$i.'</td>
	                              <td>
	                                '.$value['nombre'].'
	                              </td>
	                              <td>'.$value['chip_codigo'].'</td>
	                              <td>'.$value['peso'].'</td>
	                              <td>'.$value['especie'].'</td>
	                              <td>'.$value['raza'].'</td>

	                              <td align=center>
                                  <i class="fas fa-edit	" onclick="consultarEjemplar('.$value['id'].')"  style="font-size:20px; cursor:pointer; color : blue" ></i>
                                  <i class="fas fa-file-pdf	" onclick="generar('.$value['id'].')"  style="font-size:20px; cursor:pointer; color: red !important" ></i>

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

  <div class="modal fade" id="crearModal">
    <div class="modal-dialog modal-xl" >
     <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close cerrarCrear" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        </div>
	      <div class="modal-body" style="text-align: center;">
	        <div class="card card-primary card-outline">
	          <div class="card-header">
	            <h3 class="card-title">
	              <i class="fas fa-edit"></i>
	              Crear ejemplar
	            </h3>
	          </div>

	          <div class="card-body">
	            <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
	              <li class="nav-item">
	                <a class="nav-link active" id="custom-content-below-home-tab-1" data-toggle="pill" href="#custom-content-below-home-1" role="tab" aria-controls="custom-content-below-home-1" aria-selected="true">Datos del ejemplar</a>
	              </li>
	              <li class="nav-item">
	                <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile-1" role="tab" aria-controls="custom-content-below-profile-2" aria-selected="false">Estado sanitario</a>
	              </li>
	              <li class="nav-item">
	                <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile-2" role="tab" aria-controls="custom-content-below-profile-3" aria-selected="false">Datos de reproducción</a>
	              </li>
	              <li class="nav-item">
	                <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile-3" role="tab" aria-controls="custom-content-below-profile-4" aria-selected="false">Propietario / Pesebrera</a>
	              </li>
	              <li class="nav-item">
	                <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile-4" role="tab" aria-controls="custom-content-below-profile-4" aria-selected="false">Veterinario</a>
	              </li>
	            </ul>
	            <div class="tab-content" id="custom-content-below-tabContent">
	              <div class="tab-pane fade show active" id="custom-content-below-home-1" role="tabpanel" aria-labelledby="custom-content-below-home-tab-1">
			            <div class="row">
			            	<div class="col-4" >
			            		<br>
			            		<div id="cargaImagen">
			            			<img src="../../dist/img/photo1.png" style="width: 100%">
			            		</div>
	                    <label>Foto (Opcional)</label>
	                    <input type="file" class="form-control" id="imagen" name="imagen">
			            	</div>
			            	<div class="col-8" >
					            <div class="row mt-3">
				                <div class="col-md-6">
				                    <label>Nombre</label>
				                    <input type="text" class="form-control" id="nombre">
				                </div>
				                <div class="col-md-6">
				                    <label>Chip - Código</label>
				                    <input type="text" class="form-control" id="chip">
				                </div>
				              </div>
					            <div class="row mt-3">

				                <div class="col-md-2">
				                    <label>Peso (Kg)</label>
				                    <input type="number" class="form-control" id="peso">
				                </div>
				                <div class="col-md-2">
				                    <label>Alzada (cm)</label>
				                    <input type="number" class="form-control" id="alzada">
				                </div>
				                <div class="col-md-2">
				                    <label>Color</label>
				                    <input type="text" class="form-control" id="color">
				                </div>
				                <div class="col-md-3">
				                    <label>Sexo</label>
				                    <select class="form-control" id="sexo">
				                        <option>Macho</option>
				                        <option>Hembra</option>
				                    </select>
				                </div>
				                <div class="col-md-1">
				                    <label>Edad</label>
				                    <input type="text" class="form-control" id="edad">
				                </div>
				                <div class="col-md-2">
				                    <label>Unidad</label>
				                    <select class="form-control" id="unidad">
			                        <option>Meses</option>
			                        <option>Años</option>
				                  	</select>
				                </div>
					            </div>

					            <div class="row mt-3">
					                <div class="col-md-3">
					                    <label>Andar</label>
					                    <select class="form-control" id="andar">
					                        <option>P1 - Trote y galope</option>
					                        <option>P2 - Trocha y galope</option>
					                        <option>P3 - Trocha colombiana</option>
					                        <option>P4 - Paso fino colombiano</option>
					                        <option>P5 - Otros andares</option>
					                    </select>
					                </div>
					                <div class="col-md-3">
					                    <label>Raza</label>
					                    <select class="form-control" id="raza">
					                        <option>Criollo colombiano</option>
					                        <option>Cuarto de milla</option>
					                        <option>Appaloosa</option>
					                        <option>Percherón</option>
					                        <option>Otros</option>
					                    </select>
					                </div>

					                <div class="col-md-3">
					                    <label>Especie</label>
					                    <select class="form-control" id="especie">
					                        <option>Equino</option>
					                        <option>Asnal</option>
					                        <option>Mular</option>
					                    </select>
					                </div>
					                <div class="col-md-3">
					                    <label>Condición Corporal</label>
					                    <select class="form-control" id="condicion_corporal">
					                        <option>1</option>
					                        <option>2</option>
					                        <option>3</option>
					                        <option>4</option>
					                        <option>5</option>
					                    </select>
					                </div>
					            </div>
					            <div class="row mt-3">
					              <div class="col-md-10">
					              </div>
					              <div class="col-md-2">
						        			<button type="button" class="btn btn-primary" onclick="guardarEjemplar()">Guardar</button>
					              </div>

					            </div>

			            	</div>
			            </div>
	              </div>

	              <div class="tab-pane fade" id="custom-content-below-profile-1" role="tabpanel" >

			            <div class="row mt-3">
			                <div class="col-md-6">
		                    <label>Estado sanitario</label>
		                    <select id="nombre_vacuna" class="form-control" onchange="validarEstado(this.value)">

													 <option>Encefalitis Equina Venezolana</option> <!--Vacunas mostrar vacunado - no vacunado -->
													 <option>Influenza equina</option> <!--Vacunas mostrar vacunado - no vacunado -->
													 <option>Anemia infecciosa equina</option><!--Positivo - negativo -->
												</select>
			                </div>
			                <div class="col-md-6">
		                    <label>Estado</label>
		                    <select id="cumple_vacuna" class="form-control">
		                    	<option>Vacunado</option>
		                    	<option>No vacunado</option>
		                    </select>
			                </div>
		              </div>
			            <div class="row mt-3">
		                <div class="col-md-5">
	                    <label>Fecha</label>
	                    <input type="date" id="fecha_vacuna" class="form-control" max="<?=date('Y-m-d') ?>">
		                </div>
		                <div class="col-md-5">
  										<label>Cargar documento</label>
	                    <input type="file" class="form-control" id="archivo_adjunto" name="archivo_adjunto">

		                </div>
		                <div class="col-md-2">
  										<label>&nbsp;</label>
											<button type="button"  class="btn btn-primary btn-block " id="botonSave" onclick="guardarVacuna()"><i class="fas fa-save"></i></button>
		                </div>
			            </div>
			            <br><br>
			            <div id="divVacuna">

			            </div>



	              </div>

	              <div class="tab-pane fade" id="custom-content-below-profile-2" role="tabpanel" >
					        <!-- Datos de Reproducción -->
			            <div class="row">
			                <div class="col-md-6">
			                    <label>Gestante (Si es Hembra)</label>
			                    <select class="form-control" id="gestante">
			                        <option>No Aplica</option>
				                        <option>No</option>
			                        <option>Si</option>
			                    </select>
			                </div>
			                <div class="col-md-6">
			                    <label>Tiempo de Gestación (Meses)</label>
			                    <input type="number" class="form-control" id="tiempo_gestacion">
			                </div>
			            </div>

			            <div class="row mt-3">
			                <div class="col-md-6">
			                    <label>Castrado (Si es Macho)</label>
			                    <select class="form-control" id="castrado">
			                        <option>No Aplica</option>
			                        <option>No</option>
			                        <option>Si</option>
			                    </select>
			                </div>

				              <div class="col-md-2">
					        			<button type="button" class="btn btn-primary" onclick="actualizarReproduccion()">Guardar</button>
				              </div>
			            </div>

	              </div>

	              <div class="tab-pane fade" id="custom-content-below-profile-3" role="tabpanel">
					        <!-- Propietario -->
			            <div class="row">
		                <div class="col-md-3">
	                    <label style="text-align: left !important">Nombre</label>
	                    <input type="text" class="form-control" id="nombre_propietario">
		                </div>
		                <div class="col-md-2">
	                    <label style="text-align: left !important">Documento</label>
	                    <input type="text" class="form-control" id="documento_propietario">
		                </div>
		                <div class="col-md-3">
	                    <label style="text-align: left !important">Correo Electrónico</label>
	                    <input type="email" class="form-control" id="correo_electronico">
		                </div>
		                <div class="col-md-2">
	                    <label style="text-align: left !important">Celular</label>
	                    <input type="tel" class="form-control" id="celular">
		                </div>
		                <div class="col-md-2">
				        			<button type="button" class="btn btn-primary" onclick="actualizarPropietario()">Guardar</button>
			              </div>
			            </div>
	              </div>

	              <div class="tab-pane fade" id="custom-content-below-profile-4" role="tabpanel">
					        <!-- Propietario -->
			            <div class="row">
		                <div class="col-md-3">
	                    <label style="text-align: left !important">Nombre</label>
	                    <input type="text" class="form-control" id="nombre_veterinario">
		                </div>
		                <div class="col-md-3">
	                    <label style="text-align: left !important">Matrícula Profesional</label>
	                    <input type="email" class="form-control" id="matricula_profesional">
		                </div>
		                <div class="col-md-3">
	                    <label style="text-align: left !important">Contacto</label>
	                    <input type="tel" class="form-control" id="contacto_veterinario">
		                </div>
		                <div class="col-md-2">
				        			<button type="button" class="btn btn-primary" onclick="actualizarVeterinario()">Guardar</button>
			              </div>
			            </div>
	              </div>



	            </div>
	          </div>
	          <!-- /.card -->
	        </div>

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="cerrarModal()">Cerrar</button>
	      </div>

      </div>

      <!-- /.modal-content -->

    </div>

    <!-- /.modal-dialog -->

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

  <!-- dropzonejs -->
  <link rel="stylesheet" href="../../plugins/dropzone/min/dropzone.min.css">
<!-- dropzonejs -->
<script src="../../plugins/dropzone/min/dropzone.min.js"></script>
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

		$("#placa").val('')
		$("#tipo").val('')
		$("#marca").val('')
		$("#modelo").val('')
		$("#propietario").val('')

		$("#crearModal").modal({
		  backdrop: 'static', // Evita cerrar al hacer clic fuera
		  keyboard: false // Evita cerrar con la tecla "Escape"
		});


	  $("#idHidden").val(id)

		divVacunas()

  }

  function cerrarModal(){
		$('#crearModal').modal('hide');
		$('#modalDocs').modal('hide');
  }

	function guardarEjemplar(){

		// Crear un nuevo objeto FormData
		var formData = new FormData();
		formData.append('action', 'guardarEjemplar');
		formData.append('id', $("#idHidden").val());
		formData.append('imagen', $("#imagen")[0].files[0]); // Archivo de imagen seleccionado
		formData.append('nombre', $("#nombre").val());
		formData.append('chip', $("#chip").val());
		formData.append('peso', $("#peso").val());
		formData.append('alzada', $("#alzada").val());
		formData.append('color', $("#color").val());
		formData.append('sexo', $("#sexo").val());
		formData.append('edad', $("#edad").val());
		formData.append('unidad', $("#unidad").val());
		formData.append('andar', $("#andar").val());
		formData.append('raza', $("#raza").val());
		formData.append('especie', $("#especie").val());
		formData.append('condicion_corporal', $("#condicion_corporal").val());

		$.ajax({
		  url: '../../ajax/ejemplares_ajax.php',  // La URL del script en el servidor que procesará el login
		  type: 'POST',
		  data: formData,
		  processData: false, // No procesar los datos, jQuery los enviará como FormData
		  contentType: false, // No establecer un tipo de contenido, dejar que el navegador lo maneje
		  success: function(response) {

		  	if(response.success){
		  		$("#idHidden").val(response.data)
					Swal.fire({
					  title: 'Atención',
					  text: 'Datos almacenados correctamente',
					  icon: 'success',
					  confirmButtonText: 'Cerrar'
					})

					if(response.data!=""){
						$.ajax({
						  url: '../../ajax/ejemplares_ajax.php',  // La URL del script en el servidor que procesará el login
						  type: 'POST',
						  data: {
						  	action: 'consultarEjemplar',
						  	id: $("#idHidden").val(),
						  },
						  success: function(response) {

						  	if(response.success){

						  		$("#alzada").val(response.data.alzada)
						  		$("#nombre").val(response.data.nombre)
						  		$("#chip").val(response.data.chip_codigo)
						  		$("#color").val(response.data.color)
						  		$("#edad").val(response.data.edad)
						  		$("#unidad").val(response.data.unidad)
						  		$("#peso").val(response.data.peso)
						  		$("#sexo").val(response.data.sexo)

						  		$("#andar").val(response.data.andar)
						  		$("#raza").val(response.data.raza)
						  		$("#especie").val(response.data.especie)
						  		$("#condicion_corporal").val(response.data.condicion_corporal)

						  		$("#cargaImagen").html('<img src="../../'+response.data.foto +'" class="profile-img mt-2" style="width: 100%" >');

						  	}
						  },
						  error: function() {
								Swal.fire({
								  title: 'Atención',
								  text: 'Server Error',
								  icon: 'error',
								  confirmButtonText: 'Cerrar'
								})
						  }
						});

					}
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

	function consultarEjemplar(id){

		abrirModal(id)
		$("#idHidden").val()
		if(id!=""){
			$.ajax({
			  url: '../../ajax/ejemplares_ajax.php',  // La URL del script en el servidor que procesará el login
			  type: 'POST',
			  data: {
			  	action: 'consultarEjemplar',
			  	id: $("#idHidden").val(),
			  },
			  success: function(response) {

			  	if(response.success){

			  		$("#alzada").val(response.data.alzada)
			  		$("#nombre").val(response.data.nombre)
			  		$("#chip").val(response.data.chip_codigo)
			  		$("#color").val(response.data.color)
			  		$("#edad").val(response.data.edad)
			  		$("#unidad").val(response.data.unidad)
			  		$("#peso").val(response.data.peso)
			  		$("#sexo").val(response.data.sexo)

			  		$("#andar").val(response.data.andar)
			  		$("#raza").val(response.data.raza)
			  		$("#especie").val(response.data.especie)
			  		$("#condicion_corporal").val(response.data.condicion_corporal)

			  		$("#gestante").val(response.data.gestante)
			  		$("#tiempo_gestacion").val(response.data.tiempo_gestacion)
			  		$("#castrado").val(response.data.castrado)

			  		$("#nombre_propietario").val(response.data.nombre_propietario)
			  		$("#documento_propietario").val(response.data.documento_propietario)
			  		$("#correo_electronico").val(response.data.correo_electronico)
			  		$("#celular").val(response.data.celular)

			  		$("#nombre_veterinario").val(response.data.nombre_veterinario)
			  		$("#matricula_profesional").val(response.data.matricula_profesional)
			  		$("#contacto_veterinario").val(response.data.contacto_veterinario)

			  		$("#cargaImagen").html('<img src="../../'+response.data.foto +'" class="profile-img mt-2" style="width: 100%" >');

			  	}
			  },
			  error: function() {
					Swal.fire({
					  title: 'Atención',
					  text: 'Server Error',
					  icon: 'error',
					  confirmButtonText: 'Cerrar'
					})
			  }
			});
		}
	}

	function divVacunas(){
	  	$("#divVacuna").html("")
			$.ajax({
			  url: '../../ajax/ejemplares_ajax.php',  // La URL del script en el servidor que procesará el login
			  type: 'POST',
			  data: {
			  	action: 'divVacuna',
			  	id: $("#idHidden").val(),
			  },
			  success: function(response) {

			  	$("#divVacuna").html(response)
		    let table = $('#tablaVacuna').DataTable({
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
			  },
			  error: function() {
					Swal.fire({
					  title: 'Atención',
					  text: 'Server Error',
					  icon: 'error',
					  confirmButtonText: 'Cerrar'
					})
			  }
			});

	}

	function guardarVacuna(){

		if($("#archivo_adjunto").val()==""){
			Swal.fire({
			  title: 'Atención',
			  text: 'El documento es requerido',
			  icon: 'warning',
			  confirmButtonText: 'Cerrar'
			})
			return false;
		}

		// Crear un nuevo objeto FormData
		var formData = new FormData();
		formData.append('action', 'guardarVacuna');
		formData.append('id', $("#idHidden").val());
		formData.append('nombre_vacuna', $("#nombre_vacuna").val());
		formData.append('cumple_vacuna', $("#cumple_vacuna").val());
		formData.append('fecha_vacuna', $("#fecha_vacuna").val());
		formData.append('archivo_adjunto', $("#archivo_adjunto")[0].files[0]); // Archivo de imagen seleccionado

		$.ajax({
		  url: '../../ajax/ejemplares_ajax.php',  // La URL del script en el servidor que procesará el login
		  type: 'POST',
		  data: formData,
		  processData: false, // No procesar los datos, jQuery los enviará como FormData
		  contentType: false, // No establecer un tipo de contenido, dejar que el navegador lo maneje
		  success: function(response) {

		  	if(response.success){
					divVacunas()
					$("#nombre_vacuna").val("")
					Swal.fire({
					  title: 'Atención',
					  text: 'Datos almacenados correctamente',
					  icon: 'success',
					  confirmButtonText: 'Cerrar'
					})
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

	function eliminarVacuna(id){
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {

        if (result.isConfirmed) {

					$.ajax({
		  			url: '../../ajax/ejemplares_ajax.php',  // La URL del script en el servidor que procesará el login
					  type: 'POST',
					  data: {
					  	action: 'eliminarVacuna',
					  	id: id,
					  },
					  success: function(response) {
					  	if(response.success){
								divVacunas()
					  	}
					  },

					  error: function() {

							Swal.fire({
							  title: 'Atención',
							  text: 'Server Error',
							  icon: 'error',
							  confirmButtonText: 'Cerrar'
							})

					  }

					});

        }

    });

	}

	function actualizarReproduccion(){

		if($("#idHidden").val()!=""){

		// Crear un nuevo objeto FormData
		var formData = new FormData();
		formData.append('action', 'actualizarReproduccion');
		formData.append('id', $("#idHidden").val());
		formData.append('gestante', $("#gestante").val());
		formData.append('tiempo_gestacion', $("#tiempo_gestacion").val());
		formData.append('castrado', $("#castrado").val());

		$.ajax({
		  url: '../../ajax/ejemplares_ajax.php',  // La URL del script en el servidor que procesará el login
		  type: 'POST',
		  data: formData,
		  processData: false, // No procesar los datos, jQuery los enviará como FormData
		  contentType: false, // No establecer un tipo de contenido, dejar que el navegador lo maneje
		  success: function(response) {

		  	if(response.success){
					Swal.fire({
					  title: 'Atención',
					  text: 'Datos actualizados correctamente',
					  icon: 'success',
					  confirmButtonText: 'Cerrar'
					})
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

	}

	function actualizarPropietario(){

		if($("#idHidden").val()!=""){

		// Crear un nuevo objeto FormData
		var formData = new FormData();
		formData.append('action', 'actualizarPropietario');
		formData.append('id', $("#idHidden").val());
		formData.append('nombre_propietario', $("#nombre_propietario").val());
		formData.append('documento_propietario', $("#documento_propietario").val());
		formData.append('correo_electronico', $("#correo_electronico").val());
		formData.append('celular', $("#celular").val());

		$.ajax({
		  url: '../../ajax/ejemplares_ajax.php',  // La URL del script en el servidor que procesará el login
		  type: 'POST',
		  data: formData,
		  processData: false, // No procesar los datos, jQuery los enviará como FormData
		  contentType: false, // No establecer un tipo de contenido, dejar que el navegador lo maneje
		  success: function(response) {

		  	if(response.success){
					Swal.fire({
					  title: 'Atención',
					  text: 'Datos actualizados correctamente',
					  icon: 'success',
					  confirmButtonText: 'Cerrar'
					})
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

	}

	function actualizarVeterinario(){

		if($("#idHidden").val()!=""){
			// Crear un nuevo objeto FormData
			var formData = new FormData();
			formData.append('action', 'actualizarVeterinario');
			formData.append('id', $("#idHidden").val());
			formData.append('nombre_veterinario', $("#nombre_veterinario").val());
			formData.append('matricula_profesional', $("#matricula_profesional").val());
			formData.append('contacto_veterinario', $("#contacto_veterinario").val());

			$.ajax({
			  url: '../../ajax/ejemplares_ajax.php',  // La URL del script en el servidor que procesará el login
			  type: 'POST',
			  data: formData,
			  processData: false, // No procesar los datos, jQuery los enviará como FormData
			  contentType: false, // No establecer un tipo de contenido, dejar que el navegador lo maneje
			  success: function(response) {

			  	if(response.success){
						Swal.fire({
						  title: 'Atención',
						  text: 'Datos actualizados correctamente',
						  icon: 'success',
						  confirmButtonText: 'Cerrar'
						})
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
	}


	function validarEstado(nombre){

		$("#cumple_vacuna").empty();

		if(nombre=="Anemia infecciosa equina"){
			$("#cumple_vacuna").append('<option>Positivo</option>')
			$("#cumple_vacuna").append('<option>Negativo</option>')
		}
		else{
			$("#cumple_vacuna").append('<option>Vacunado</option>')
			$("#cumple_vacuna").append('<option>No Vacunado</option> ')
		}

	}
	function generar(id){
		window.open("pdf.php?id="+id, "_blank");
	}

	function aprobar(id, opc){
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, aprobar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {

      if (result.isConfirmed) {

				$.ajax({
				  url: '../../ajax/ejemplares_ajax.php',  // La URL del script en el servidor que procesará el login
				  type: 'POST',
				  data: {
				  	action: 'aprobar',
				  	id: id,
				  	opc: opc,
				  },
				  success: function(response) {
						divVacunas()
						Swal.fire({
						  title: 'Atención',
						  text: 'Datos actualizados correctamente',
						  icon: 'success',
						  confirmButtonText: 'Cerrar'
						})

				  },
				  error: function() {

						Swal.fire({
						  title: 'Atención',
						  text: 'Server Error',
						  icon: 'error',
						  confirmButtonText: 'Cerrar'
						})

				  }
				});

      }
    });

	}

</script>

</body>
</html>
