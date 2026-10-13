<?php

include('../../config/conex.php');

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['id'])) {
  header('Location: ../../');
  exit();
}


//Se consultan los ejemplares
$sql="SELECT e.*
			FROM ejemplares e
			WHERE NOT EXISTS (
			    SELECT 1
			    FROM ejemplares_vacunas v
			    WHERE v.id_ejemplar = e.id
			      AND v.nombre = 'Encefalitis Equina Venezolana'
			      AND v.aprobado = 1
			)
			ORDER BY e.id;";
$ejemplares_vacunas=queryli($sql,2);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CABALGATAS</title>

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
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars" ></i></a>
      </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item">
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
    <a href="#" class="brand-link">
      <img src="../../dist/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">CABALGATAS</span>
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
      	$menu = 'panel';

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
            <h1 class="m-0">Dashboard v2</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v2</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"></span>
              <?php

              	$sql="SELECT * FROM ejemplares";
              	$res=queryli($sql,2);

              	$total = $Rows;

              	$femenino =0;
              	$masculino =0;
              	foreach ($res as $key => $value) {

              		if($value['sexo']=="Macho"){
              			$masculino++;
              		}
              		else{
              			$femenino++;
              		}

              	}
              ?>

              <div class="info-box-content">
                <span class="info-box-text">Ejemplares</span>
                <span class="info-box-number">
                  <?=$total?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"></span>

              <div class="info-box-content">
                <span class="info-box-text">Machos</span>
                <span class="info-box-number"><?=$masculino ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"></span>

              <div class="info-box-content">
                <span class="info-box-text">Hembras</span>
                <span class="info-box-number"><?=$femenino ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-12 col-sm-6 col-md-6">
        		<?php
        			$sql="SELECT COUNT(id) as cantidad, edad, unidad, sexo
									FROM ejemplares
									GROUP BY sexo, edad, unidad
									ORDER BY sexo ASC";
							$res=queryli($sql,2);



        		?>
            <div class="card">
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    	<tr>
                    		<th colspan="3" align="center" style="text-align: center !important">Relacion Sexo - Edad</th>
                    	</tr>
	                    <tr>
	                      <th>Cantidad</th>
	                      <th>Sexo</th>
	                      <th>Edad</th>
	                    </tr>
                    </thead>
                    <tbody>
                    	<?php

                    		foreach ($res as $key => $value) {
												?>
			                    <tr>
			                      <td align="center"><span class="badge badge-warning"><?=$value['cantidad'] ?></span></td>
			                      <td><a href="#"><?=$value['sexo'] ?></a></td>
			                      <td><?=$value['edad'].' '.$value['unidad']  ?></td>
			                    </tr>
												<?php
                    		}

                    	?>

                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
        		</div>


        	</div>
          <div class="col-12 col-sm-6 col-md-6">
        		<?php
        			$sql="SELECT COUNT(id) as cantidad, departamento, municipio
										FROM eventos_participantes e
										GROUP BY e.departamento, e.municipio
										ORDER BY departamento ASC";
							$arrayDpto=queryli($sql,2);

        		?>
            <div class="card">
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    	<tr>
                    		<th colspan="3" align="center" style="text-align: center !important">Participantes por procedencia</th>
                    	</tr>
	                    <tr>
	                      <th>Cantidad</th>
	                      <th>Departamento</th>
	                      <th>Municipio</th>
	                    </tr>
                    </thead>
                    <tbody>
                    	<?php

                    		foreach ($arrayDpto as $key => $value) {
												?>
			                    <tr>
			                      <td align="center"><span class="badge badge-warning"><?=$value['cantidad'] ?></span></td>
			                      <td><a href="#"><?=$value['departamento'] ?></a></td>
			                      <td><?=$value['municipio']  ?></td>
			                    </tr>
												<?php
                    		}

                    	?>

                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
        		</div>

        	</div>

        	<div class="col-12 col-sm-12 col-md-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body" style="overflow: scroll;">
                <table class="table m-0" id="no_vacunados">
                  <thead>
                  	<tr>
                  		<th colspan="6" align="center" style="text-align: center !important">Equinos sin vacuna - Encefalitis Equina Venezolana</th>
                  	</tr>
                    <tr>
                      <th></th>
                      <th>Nombre</th>
                      <th>Chip</th>
                      <th>Peso</th>
                      <th>Especie</th>
                      <th>Raza</th>
                    </tr>
                  </thead>
                          <tbody>

                          <?php

                          	$i = 1;
                          	foreach ($ejemplares_vacunas as $key => $value) {

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

	                            </tr>';
                            $i++;
                          	}

                          ?>
                       	 </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
        	</div>

        </div>

        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer" style="color: ">
    <strong>Copyright &copy; <?=date('Y')?></strong>
   Todos los derechos reservados.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="../../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.js"></script>

<!-- PAGE ../../PLUGINS -->
<!-- jQuery Mapael -->
<script src="../../plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="../../plugins/raphael/raphael.min.js"></script>
<script src="../../plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="../../plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="../../plugins/chart.js/Chart.min.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../../dist/js/pages/dashboard2.js"></script>


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



<script type="text/javascript">

		$(document).ready(function() {

    let table = $('#no_vacunados').DataTable({
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


</script>

</body>
</html>
