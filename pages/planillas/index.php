<?php

include('../../config/conex.php');
// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['id'])) {
  header('Location: ../../');
  exit();
}
//Query users
$sql="SELECT * FROM usuarios WHERE rol IN(1)";
$organizadores=queryli($sql,2);

//Se consultan los ejemplares
$sql="SELECT * FROM departamentos";
$departamentos=queryli($sql,2);

//Se consultan los ejemplares
$sql="SELECT e.*
			FROM ejemplares e
			INNER JOIN ejemplares_vacunas v ON v.id_ejemplar=e.id
			WHERE v.nombre='Encefalitis Equina Venezolana' AND v.aprobado=1
			GROUP BY e.id
			ORDER BY v.id desc";
$ejemplares=queryli($sql,2);

$proveedor_id = '';
$fecha_inicial = '';
$fecha_final = '';
$CRIT = '';

if(!empty($_GET)){
	$proveedor_id = $_GET['proveedor_id'];
	$fecha_inicial = $_GET['fecha_inicial'];
	$fecha_final = $_GET['fecha_final'];

	if($proveedor_id!="")
		$CRIT.=" AND p.id_organizador = $proveedor_id";

	if($fecha_inicial!="" && $fecha_final!=""){
		$CRIT.=" AND p.fecha >= '$fecha_inicial' AND p.fecha<='$fecha_final'";
	}
}

//planillas
$sql="SELECT p.*, u.name, COUNT(ep.id) AS total_participantes
        FROM eventos p
        INNER JOIN usuarios u ON u.id = p.id_organizador
        LEFT JOIN eventos_participantes ep ON ep.evento_id = p.id
        WHERE p.id<>'' $CRIT
        GROUP BY p.id, u.name
        ORDER BY p.fecha DESC
";
$datos=queryli($sql,2);

$atras = '../../';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cabalgatas</title>
<!-- Select2 -->
  <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../../dist/css/change.css">
  <!-- Select2 -->

  <style type="text/css">


	  #loader-overlay {
	    position: fixed;
	    top: 0;
	    left: 0;
	    width: 100%;
	    height: 100%;
	    background-color: rgba(255, 255, 255, 0.8); /* fondo semitransparente */
	    display: none; /* inicialmente oculto */
	    z-index: 9999; /* por encima de todo */
	  }

	  #loader-image {
	    position: absolute;
	    top: 50%;
	    left: 50%;
	    transform: translate(-50%, -50%);
	    width: 64px; /* ajusta tamaño si lo deseas */
	    height: 64px;
	  }

  </style>

</head>
<body class="hold-transition  sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div id="loader-overlay">
  <img src="https://i.imgur.com/llF5iyg.gif" alt="Cargando..." id="loader-image">
</div>


<div class="wrapper">
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="../../dist/img/logo.png" alt="logo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item" >
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item" >
        <a href="../../?cerrar" class="nav-link">
          <i class="nav-icon fas fa-power-off" ></i>
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
      	$menu = 'planillas';

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
            <h1 class="m-0"><b>Cabalgatas</b></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"><b style="color: #0D3B66 !important">Inicio</b></a></li>
              <li class="breadcrumb-item active"><b>eventos</b></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
	<input type="hidden" id="idHidden">

        <!-- App body starts -->
        <div class="app-body">
					<input type="hidden" id="id_user">
          <!-- Container starts -->
          <div class="container">

						<div class="container mt-1">
            	<div class="card">
            		<div class="card-body">
							    <!-- Filtros de búsqueda -->
							    <div class="row mb-3">
							        <div class="col-md-5">
							        	<label>Organizador</label>
							        	<select class="form-control select2 " id="proveedor">
							        		<option value="">Seleccione</option>
							        		<?php

							        			foreach ($organizadores as $key => $value) {
							        				if($value['rol']==1){

							        					if($proveedor_id==$value['id'] ){
							        						echo "<option selected value='".$value['id']."' >".$value['name']."</option>";
							        					}
							        					else{
							        						echo "<option value='".$value['id']."' >".$value['name']."</option>";
							        					}
							        				}
							        			}

							        		?>
							        	</select>
							        </div>
							        <div class="col-md-2">
							        	<label>Fecha inicial</label>
						            <input type="date" id="fecha_inicial" class="form-control" value="<?=$fecha_inicial ?>" >
							        </div>
							        <div class="col-md-2">
							        	<label>Fecha final</label>
						            <input type="date" id="fecha_final" class="form-control" value="<?=$fecha_final ?>">
							        </div>
							        <div class="col-md-1">
											<label>&nbsp;</label>
											<label>&nbsp;</label>
											<button type="button" class="btn btn-primary btn-block" onclick="location.href='index.php'">
											    <i class="fas fa-trash"></i>
											</button>

							        </div>
							        <div class="col-md-1">
							        	<label>&nbsp;</label>
												<button type="button"  class="btn btn-primary btn-block " onclick="search()"><i class="fas fa-search"></i></button>
							        </div>
							        <div class="col-md-1 text-right">
							        	<label>&nbsp;</label>
												<button type="button"  class="btn btn-primary btn-block " onclick="abrirModal('')"><i class="fas fa-plus"></i></button>
							        </div>
							    </div>
						  	</div>
            	</div>
					    <br>
							<div class="card">
            		<div class="card-body">
    					    <!-- Tabla -->
		              <table id="example1" class="table table-bordered table-striped" width="100%">
		                <thead >
							            <tr>
							                <th>Id</th>
							                <th>Fecha</th>
							                <th>Organizador</th>
							                <th>Nombre</th>
							                <th>Cantidad asistentes</th>
							                <th>Acción</th>
							            </tr>
							        </thead>
							        <tbody>
							        	<?php
							        		$i = 1;
							        		foreach ($datos as $key => $value) {
													?>

							            <tr>
							                <td><?=$i?></td>
							                <td nowrap style="cursor: pointer;" onclick="verDatos(<?=$value['id'] ?>)" ><?=$value['fecha']  ?></td>
							                <td style="cursor: pointer;" onclick="verDatos(<?=$value['id'] ?>)" ><?=ucwords(strtolower($value['name']))  ?></td>
							                <td style="cursor: pointer;" onclick="verDatos(<?=$value['id'] ?>)" ><?=ucwords(strtolower($value['titulo']))  ?></td>
							                <td align="center" style="cursor: pointer;" ><?=$value['total_participantes'] ?></td>
						                	<td align="center" style="cursor: pointer;"  >
<!-- 						                		<a href="../evento?id=<?=$value['id']?>">
            											<i title="Ver"  class="fas fa-link	" onclick="verDatos(<?=$value['id'] ?>)" style="font-size:20px; cursor:pointer; color: green !important"  ></i>
            										</a>
 -->            										<i title="Ver"  class="fas fa-edit	" onclick="verDatos(<?=$value['id'] ?>)" style="font-size:20px; cursor:pointer; color: blue !important"  ></i>
            										<i title="PDF"  class="fas fa-file-pdf	" onclick="generar(<?=$value['id'] ?>)" style="font-size:20px; cursor:pointer; color: red !important"   ></i>
							                </td>
							            </tr>

													<?php
													$i++;
							        		}


							        	?>
							        </tbody>
							    </table>
					    	</div>
					    </div>

						</div>

						<div class="modal fade" id="crearModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  <div class="modal-dialog modal-xl">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="modal-title" id="exampleModalLabel"><b>Nuevo evento</b></h5>
						        <button type="button" class="btn btn-primary" onclick="cerrarModal()" aria-label="Close">
						          <i class="fas fa-close">X</i>
						        </button>
						      </div>
						      <div class="modal-body" style="text-align: center;">

								    <div class="container bg-light p-4 rounded shadow">

				            	<div class="card">
				            		<div class="card-body">
											    <!-- Filtros de búsqueda -->
													<div class="container">
													    <div class="row mb-3">
													        <div class="col-12 col-sm-6 col-lg-4">
													            <label style="float:left !important; " >Fecha</label>
													            <input type="date" class="form-control" value="<?=date('Y-m-d') ?>" id="fecha" min="<?=date('Y-m-d') ?>">
													        </div>
													        <div class="col-12 col-sm-6 col-lg-4">
													            <label style="float:left !important; " >Organizador</label>
													            <select class="form-control select2" id="id_organizador" style="width: 100%;">
													                <option value="">Seleccione</option>
													                <?php foreach ($organizadores as $key => $value) {
													                    if($value['rol']==1) {
													                        echo "<option value='".$value['id']."' >".$value['name']."</option>";
													                    }
													                } ?>
													            </select>
													        </div>
													        <div class="col-12 col-lg-4">
													            <label style="float:left !important; " >Responsable</label>
													            <input type="text" class="form-control" placeholder="Nombre de la persona encargada" id="responsable">
													        </div>
													    </div>

													    <div class="row mb-3">
													        <div class="col-12 col-sm-6 col-lg-5">
													            <label style="float:left !important; " >Nombre</label>
													            <input type="text" class="form-control" placeholder="Nombre del evento" id="titulo">
													        </div>
													        <div class="col-12 col-sm-6 col-lg-5">
													            <label style="float:left !important; " >Descripción</label>
													            <input type="text" class="form-control" placeholder="Descripción del evento" id="descripcion">
													        </div>
													        <div class="col-12 col-sm-12 col-lg-2 d-flex align-items-end">
													            <button type="button" class="btn btn-primary btn-block w-100" onclick="guardarEvento('')">
													                <i class="fas fa-save"></i> Guardar
													            </button>
													        </div>
													    </div>
													</div>

										  	</div>
				            	</div>
				            	<div class="card" style="display: none" id="divDetalle">
				            		<div class="card-body">

													<div class="container">
													    <div class="row mb-3">
													        <div class="col-12 col-sm-6 col-lg-3">
													            <label style="float:left !important; ">Ejemplar</label>
													            <select class="form-control" id="id_ejemplar" style="width: 100% !important">
													                <option selected>Seleccione</option>
													                <?php foreach ($ejemplares as $value) {
													                    echo "<option value='".$value['id']."' >".strtoupper($value['chip_codigo'].' - '.$value['nombre'])."</option>";
													                } ?>
													            </select>
													        </div>

													        <div class="col-12 col-sm-6 col-lg-3">
													            <label style="float:left !important; ">Procedencia</label>
													            <select class="form-control" id="procedencia" style="width: 100% !important">
													                <option selected>Seleccione</option>
													                <option>Criadero</option>
													                <option>Pesebrera</option>
													                <option>Finca</option>
													                <option>Otro</option>
													            </select>
													        </div>

													        <div class="col-12 col-sm-6 col-lg-3">
													            <label style="float:left !important; ">Departamento</label>
													            <select class="form-control select2" id="departamento" onchange="buscarMunicipios(this.value)" style="width: 100% !important">
													                <?php foreach ($departamentos as $value) {
													                    echo "<option>".$value['Departamento']."</option>";
													                } ?>
													            </select>
													        </div>

													        <div class="col-12 col-sm-6 col-lg-3">
													            <label style="float:left !important; ">Municipio</label>
													            <select class="form-control" id="municipio" style="width: 100% !important"></select>
													        </div>
													    </div>

													    <div class="row mb-3">
													        <div class="col-12 col-sm-6 col-lg-3">
													            <label style="float:left !important; ">Montador</label>
													            <select class="form-control" id="montador">
													                <option>Chalan</option>
													                <option>Amazona</option>
													            </select>
													        </div>

													        <div class="col-12 col-sm-6 col-lg-3">
													            <label style="float:left !important; ">Nombre Montador</label>
													            <input type="text" class="form-control" id="nombre_montador">
													        </div>

													        <div class="col-12 col-sm-6 col-lg-3">
													            <label style="float:left !important; ">Correo Electrónico Montador</label>
													            <input type="email" class="form-control" id="correo_montador">
													        </div>

													        <div class="col-12 col-sm-6 col-lg-3">
													            <label style="float:left !important; ">Celular Montador</label>
													            <input type="tel" class="form-control" id="celular_montador">
													        </div>
													    </div>

													    <div class="row mb-3">
													        <div class="col-12 col-sm-6 col-lg-4">
													            <label style="float:left !important; ">Nombre Palafrenero</label>
													            <input type="text" class="form-control" id="nombre_palafrenero">
													        </div>

													        <div class="col-12 col-sm-6 col-lg-4">
													            <label style="float:left !important; ">Celular Palafrenero</label>
													            <input type="number" class="form-control" id="celular_palafrenero">
													        </div>

													        <div class="col-12 col-lg-2 d-flex align-items-end">
													            <button type="button" class="btn btn-primary w-100" onclick="guardarDetalle()">
													                <i class="fas fa-save"></i> Guardar
													            </button>
													        </div>
													    </div>
													</div>
							          </div>
							        </div>
								        <hr>

								        <div style="overflow: scroll !important" id="listado_detalle">


								        </div>
								    </div>


						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="cerrarModal()">Cerrar</button>
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

  <div class="modal fade" id="modal-crearMaquinaria">
    <div class="modal-dialog" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close cerrarCrear" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"></h4>
          	<span id="informacionDespachos"></span>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>




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


<script src="../../plugins/select2/js/select2.full.min.js"></script>

<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script>
  // Mostrar loader
  function showLoader() {
    $('#loader-overlay').fadeIn(200);
  }

  // Ocultar loader
  function hideLoader() {
    $('#loader-overlay').fadeOut(200);
  }

	$(document).ready(function() {

    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    let table = $('#').DataTable({
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

  function abrirModal(id){
		if (id == "") {
		    let fechaActual = new Date().toISOString().split("T")[0]; // Obtiene la fecha en formato YYYY-MM-DD
		    $("#fecha").val(fechaActual);
		}

		$("#crearModal").modal({backdrop: 'static', keyboard: false});

		$("#modal-crearMaquinaria").modal();
		$(".cerrarCrear").click();
		$("#modal-crearMaquinaria").modal('hide');
		$("#crearModal").css("overflow-y","scroll")

		$("#divDetalle").css("display", "none")
		$("#listado_detalle").css("display", "none")

		$("#modal-crearMaquinaria").modal();
		$("#crearModal").modal({backdrop: 'static', keyboard: false});
  	setTimeout(function() {

	    $('#id_ejemplar, #procedencia, #departamento').select2({
	    });
	    $("#departamento").change()
			$(".cerrarCrear").click();
  	}, 500);
		$("#modal-crearMaquinaria").modal('hide');
		$("#crearModal").css("overflow-y","scroll")

    $('#id_organizador').select2();

	  $("#idHidden").val(id)
  }

  function cerrarModal(){
		$('#crearModal').modal('hide');
  }

	function guardarEvento(){

		if($("#id_organizador").val()==""){
			Swal.fire({
			  title: 'Atención',
			  text: 'El organizador es requerido',
			  icon: 'warning',
			  confirmButtonText: 'Cerrar'
			})
			return false;
		}

		if($("#responsable").val()==""){
			Swal.fire({
			  title: 'Atención',
			  text: 'El responsable requerido',
			  icon: 'warning',
			  confirmButtonText: 'Cerrar'
			})
			return false;
		}

		if($("#titulo").val()==""){
			Swal.fire({
			  title: 'Atención',
			  text: 'El titulo requerido',
			  icon: 'warning',
			  confirmButtonText: 'Cerrar'
			})
			return false;
		}

		if($("#descripcion").val()==""){
			Swal.fire({
			  title: 'Atención',
			  text: 'La Descripción es requerida',
			  icon: 'warning',
			  confirmButtonText: 'Cerrar'
			})
			return false;
		}

		$.ajax({
		  url: '../../ajax/planillas_ajax.php',  // La URL del script en el servidor que procesará el login
		  type: 'POST',
		  data: {
		  	action: 'guardarEvento',
		  	id : $("#idHidden").val(),
		  	fecha : $("#fecha").val(),
		  	id_organizador : $("#id_organizador").val(),
		  	responsable : $("#responsable").val(),
		  	titulo : $("#titulo").val(),
		  	descripcion : $("#descripcion").val(),
		  	valor : 0,
		  },
		  success: function(response) {
		  	if(response.success){

		  		$("#idHidden").val(response.id)
		  		$("#divDetalle").css("display", "block")
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

	function verDatos(id){
		$("#id_organizador").val("")
		$("#id_proveedor_hielo").val("")
		$("#id_organizador").change();
		$("#id_proveedor_hielo").change();
		$("#hielo_kg").val("")
		$("#valor").val("")
		$("#idHidden").val(id)
		if(id!=""){
			$.ajax({
			  url: '../../ajax/planillas_ajax.php',  // La URL del script en el servidor que procesará el login
			  type: 'POST',
			  data: {
			  	action: 'verDatos',
			  	ID: $("#idHidden").val(),
			  },
			  success: function(response) {
			  	if(response.success){

			  		$("#idHidden").val(id)
			  		$("#fecha").val(response.data.fecha)
			  		$("#id_organizador").val(response.data.id_organizador)
			  		$("#responsable").val(response.data.responsable)
			  		$("#titulo").val(response.data.titulo)
			  		$("#descripcion").val(response.data.descripcion)


						abrirModal(id)
				  	setTimeout(function() {
							$("#id_organizador").change();
							grillaDetalle(id)
							$("#divDetalle").css("display", "block")
				  	}, 500);

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

	function guardarDetalle(){

		if($("#id_ejemplar").val()==""){
			Swal.fire({
			  title: 'Atención',
			  text: 'El ejemplar es requerido',
			  icon: 'warning',
			  confirmButtonText: 'Cerrar'
			})

			return false;
		}

		if($("#nombre_montador").val()==""){
			Swal.fire({
			  title: 'Atención',
			  text: 'El nombre del montador es requerido',
			  icon: 'warning',
			  confirmButtonText: 'Cerrar'
			})

			return false;
		}

		if($("#correo_montador").val()==""){
			Swal.fire({
			  title: 'Atención',
			  text: 'El corrreo del montador es requerido',
			  icon: 'warning',
			  confirmButtonText: 'Cerrar'
			})

			return false;
		}

		// Validar estructura de correo
		var correo = $("#correo_montador").val();
		var regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

		if (!regexCorreo.test(correo)) {
		  Swal.fire({
		    title: 'Atención',
		    text: 'El correo del montador no tiene un formato válido',
		    icon: 'warning',
		    confirmButtonText: 'Cerrar'
		  });
		  return false;
		}
		showLoader()

		$.ajax({
		  url: '../../ajax/planillas_ajax.php',  // La URL del script en el servidor que procesará el login
		  type: 'POST',
		  data: {
		  	action: 'guardarDetalle',
		  	id : $("#idHidden").val(),
				id_ejemplar : $("#id_ejemplar").val(),
				procedencia : $("#procedencia").val(),
				departamento : $("#departamento").val(),
				municipio : $("#municipio").val(),
				montador : $("#montador").val(),
				nombre_montador : $("#nombre_montador").val(),
				correo_montador : $("#correo_montador").val(),
				celular_montador : $("#celular_montador").val(),
				nombre_palafrenero : $("#nombre_palafrenero").val(),
				celular_palafrenero : $("#celular_palafrenero").val(),
		  },
		  success: function(response) {
		  	hideLoader()
		  	if(response.success){

		  		if(response.msg==""){

						Swal.fire({
						  title: 'Atención',
						  text: 'Datos almacenados correctamente',
						  icon: 'success',
						  confirmButtonText: 'Cerrar'
						})

						$("#id_ejemplar").val("")
						$("#id_ejemplar").change()
						$("#nombre_montador").val("")
						$("#correo_montador").val("")
						$("#celular_montador").val("")
						$("#nombre_palafrenero").val("")
						$("#celular_palafrenero").val("")

						grillaDetalle($("#idHidden").val())
		  		}
		  		else{
						Swal.fire({
						  title: 'Atención',
						  text: response.msg,
						  icon: 'warning',
						  confirmButtonText: 'Cerrar'
						})
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

	function grillaDetalle(id){
		$("#listado_detalle").css("display","block");
		$.ajax({
		  url: '../../ajax/planillas_ajax.php',  // La URL del script en el servidor que procesará el login
		  type: 'POST',
		  data: {
		  	action: 'grillaDetalle',
		  	id : id,
		  },
		  success: function(response) {

		  	$("#listado_detalle").html(response)


		    let table = $('#listaDetale').DataTable({
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
				  text: 'Error en el servidor',
				  icon: 'error',
				  confirmButtonText: 'Cerrar'
				})
		  }
		});
	}

	function search(){

		location.href='index.php?proveedor_id='+$("#proveedor").val()+'&fecha_inicial='+$("#fecha_inicial").val()+'&fecha_final='+$("#fecha_final").val();

	}


	function buscarMunicipios(id){

		  	$("#municipio").empty()

		$.ajax({
		  url: '../../ajax/planillas_ajax.php',  // La URL del script en el servidor que procesará el login
		  type: 'POST',
		  data: {
		  	action: 'buscarMunicipios',
		  	id : id,
		  },
		  success: function(response) {


		  	$("#municipio").append(response)
		  	$("#municipio").select2();
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


	function eliminarDetalle(id){

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
					  url: '../../ajax/planillas_ajax.php',  // La URL del script en el servidor que procesará el login
					  type: 'POST',
					  data: {
					  	action: 'eliminarDetalle',
					  	id: id,
					  },
					  success: function(response) {

					  	if(response.success){
								grillaDetalle($("#idHidden").val())
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

	function generar(id){
		window.open("pdf.php?id="+id, "_blank");
	}

</script>

</body>
</html>
