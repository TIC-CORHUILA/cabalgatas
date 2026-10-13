<?php

include('../../config/conex.php');

$atras = '';
// ini_set('display_errors', 0);
// ini_set('display_startup_errors', 0);
// error_reporting(E_ALL);
/** LIMITE DE MEMORIA*/
ini_set('default_socket_timeout', -1);
ini_set('mysql.connect_timeout', -1);
ini_set("memory_limit",-1);
set_time_limit(-1);

ob_start();

$sql="SELECT e.* , u.name
			FROM eventos e
			INNER JOIN usuarios u on u.id=e.id_organizador
			WHERE e.id='$_GET[id]'";
$datos=queryli($sql,1);
?>

<div id="idContenedor">
<table border="1" width="100%" cellspacing="0" cellpadding="5">
    <tr>
      <td rowspan="3" width="20%" align="center">
          <img src="../../dist/img/logo.png" width="100"> <!-- Cambia 'logo.png' por la ruta de la imagen -->
      </td>
      <td colspan="4" align="center"><b>SOFTWARE CABALGATAS</b></td>
    </tr>
    <tr>
      <td colspan="4" align="center"><b>EVENTO #<?=$_GET['id']?></b></td>
    </tr>
    <tr>
        <td><b>CÓDIGO:</b> FO-GD-DO-01</td>
        <td><b>VERSIÓN:</b> </td>
        <td><b>VIGENCIA:</b> </td>
        <td><b>PÁGINA:</b> 1 de 1</td>
    </tr>
</table>
<br>
<b>Datos del evento</b><br>
<table border="1" width="100%" cellspacing="0" cellpadding="5">
    <tr>
        <td><b>Fecha: </b> <?=$datos['fecha']?></td>
        <td><b>Organizador: </b> <?=$datos['name']?></td>
        <td><b>Responsable: </b> <?=$datos['responsable']?></td>
        <td><b>Nombre: </b> <?=$datos['titulo']?></td>
        <td><b>Descripción: </b> <?=$datos['descripcion']?></td>
    </tr>
</table>
<?php
	$sql="SELECT p.*, e.nombre, e.chip_codigo
				FROM eventos_participantes p
				INNER JOIN ejemplares e ON e.id=p.ejemplar_id
				WHERE p.evento_id='$_GET[id]'";
	$res=queryli($sql,2);
?>
<br>
  <table border="1" width="100%" cellspacing="0" cellpadding="5">
		<thead >
        <tr>
          <th>Ejemplar</th>
          <th>Código</th>
          <th>Montador</th>
          <th>Nombre</th>
          <th>Palafrenero</th>
        </tr>
      </thead>
      <tbody>
      	<?php
					$peso = 0;
					$canastas = 0;
					$i = 1;
      		foreach ($res as $key => $value) {

      			?>
          <tr>
						<td style="text-align: left !important"><?= ucwords(strtolower($value['nombre'])) ?></td>
						<td style="text-align: left !important"><?= ucwords(strtolower($value['chip_codigo'])) ?></td>
						<td style="text-align: left !important"><?= ucwords(strtolower($value['montador_id'])) ?></td>
						<td style="text-align: left !important"><?= ucwords(strtolower($value['nombre_montador'])) ?></td>
						<td style="text-align: center !important"><?= ucwords(strtolower($value['nombre_palafrenero'])) ?></td>
          </tr>
    			<?php
    			$i++;
      		}
      	?>
      </tbody>
  </table>

</div>

<script>
  window.onload = function () {
    var tabla = document.getElementById("idContenedor").outerHTML;
    var ventana = window.open("", "_blank");
    ventana.document.write(`
      <html>
        <head>
          <title>Hoja de Vida Ejemplar</title>
          <style>
            table { border-collapse: collapse; width: 100%; }
            th, td { border: 1px solid black; padding: 8px; text-align: left; vertical-align: middle; }
            .barcode-cell, th, td {
              text-align: center;
              vertical-align: middle;
            }
            .barcode-wrapper {
              display: flex;
              flex-direction: column;
              align-items: center;
              justify-content: center;
            }
            .barcode-wrapper div {
              margin-top: 5px;
            }
          </style>
        </head>
        <body onload="window.print(); window.close();">
          ${tabla}
        </body>
      </html>
    `);
    ventana.document.close();
  };
</script>
<?php
exit();
require_once '../../dist/dompdf/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new DOMPDF();
    echo '<script type="text/php">
        if (isset($pdf))
        {   $x = 5;
            $y = 10;
            $text = "{PAGE_NUM} DE {PAGE_COUNT}";
            $font = $fontMetrics->get_font("arial");
            $size = 12;
            $color = array(0,0,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script>';


$dompdf->load_html(ob_get_clean());
$dompdf->render();

// Enviar el PDF al navegador para visualizarlo
$dompdf->stream("archivo.pdf", ["Attachment" => true]);

