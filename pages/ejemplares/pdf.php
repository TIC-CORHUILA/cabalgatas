<?php

include('../../config/conex.php');

$atras = '';

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
// error_reporting(E_ALL);
/** LIMITE DE MEMORIA*/
ini_set('default_socket_timeout', -1);
ini_set('mysql.connect_timeout', -1);
ini_set("memory_limit",-1);
set_time_limit(-1);

ob_start();

$sql="SELECT * FROM ejemplares WHERE id='$_GET[id]'";
$datos=queryli($sql,1);

?>
<div id="idContenedor">
<table border="1" width="100%" cellspacing="0" cellpadding="5" class="barcode-cell">
    <tr>
      <td rowspan="3" width="20%" align="center">
          <img src="../../dist/img/logo.png" width="100"> <!-- Cambia 'logo.png' por la ruta de la imagen -->
      </td>
      <td colspan="4" align="center"><b>SOFTWARE CABALGATAS</b></td>
    </tr>
    <tr>
      <td colspan="4" align="center"><b>HOJA DE VIDA EJEMPLARES</b></td>
    </tr>
    <tr>
        <td><b>CÓDIGO:</b> FO-GD-DO-01</td>
        <td><b>VERSIÓN:</b> </td>
        <td><b>VIGENCIA:</b> </td>
        <td><b>PÁGINA:</b> 1 de 1</td>
    </tr>
</table>
<br>
<b>Datos del ejemplar</b>
<table border="1" width="100%" cellspacing="0" cellpadding="5">
    <tr>
        <td rowspan="4" width="100" align="center">
            <img src="../../dist/img/photo1.png" width="100">
        </td>
        <td colspan="2"><b>Nombre:</b> <?= ucwords(strtolower($datos['nombre'])) ?> </td>
        <td colspan="2"><b>Chip - Código:</b> <?=$datos['chip_codigo']?></td>
    </tr>
    <tr>
        <td><b>Peso (Kg): </b> <?=$datos['peso']?></td>
        <td><b>Alzada (cm): </b> <?=$datos['alzada']?></td>
        <td><b>Color: </b> <?=$datos['color']?></td>
        <td><b>Sexo: </b> <?=$datos['sexo']?></td>
    </tr>
    <tr>
        <td><b>Edad:</b> <?=$datos['edad']?></td>
        <td><b>Unidad:</b> <?=$datos['unidad']?></td>
        <td><b>Andar:</b> <?=$datos['andar']?></td>
        <td><b>Raza:</b> <?=$datos['raza']?></td>
    </tr>
    <tr>
        <td colspan="2"><b>Especie: </b><?=$datos['especie']?></td>
        <td colspan="2"><b>Condición Corporal: </b><?=$datos['condicion_corporal']?></td>
    </tr>
</table>
<br>
<b>Estado Sanitario</b>
<?php
$sql="SELECT * FROM ejemplares_vacunas WHERE id_ejemplar='$_GET[id]' ORDER BY id DESC";
$res=queryli($sql,2);
?>
<table width="100%" cellspacing="0" cellpadding="5" border="1">
  <thead>
      <tr>
          <th>No</th>
          <th>Nombre</th>
          <th>Estado</th>
          <th>Fecha</th>
      </tr>
  </thead>
  <tbody>
  	<?php
  		$i = 1;
  		foreach ($res as $key => $value) {
?>
      <tr>
        <td><?=$i ?></td>
        <td><?=$value['nombre'] ?></td>
        <td>
        	<?=$value['cumple'] ?>
        </td>
        <td>
        	<?=$value['fecha_aplicacion'] ?>
        </td>
      </tr>

<?php
			$i++;
  		}

  	?>

  </tbody>
</table>

<br>
<b>Datos de reproducción</b>
<table width="100%" cellspacing="0" cellpadding="5" border="1">
<tr>
	<td><b>Gestante (Si es Hembra):</b> <?=$datos['gestante']  ?> </td>
	<td><b>Tiempo de Gestación (Meses):</b> <?=$datos['tiempo_gestacion']  ?></td>
	<td><b>Castrado (Si es Macho):</b> <?=$datos['castrado']  ?> </td>
</tr>
</table>

<br>
<b>Propietario</b>
<table width="100%" cellspacing="0" cellpadding="5" border="1">
<tr>
	<td><b>Nombre:</b> <?=$datos['nombre_propietario']  ?> </td>
	<td><b>Documento:</b> <?=$datos['documento_propietario']  ?> </td>
</tr>
<tr>
	<td><b>Correo Electrónico:</b> <?=$datos['correo_electronico']  ?></td>
	<td><b>Celular:</b> <?=$datos['celular']  ?> </td>
</tr>
</table>

<br>
<b>Veterinario</b>
<table width="100%" cellspacing="0" cellpadding="5" border="1">
<tr>
	<td><b>Nombre:</b> <?=$datos['nombre_veterinario']  ?> </td>
	<td><b>Matrícula Profesional:</b> <?=$datos['matricula_profesional']  ?></td>
	<td><b>Contácto:</b> <?=$datos['contacto_veterinario']  ?> </td>
</tr>
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

// Descargar el PDF en lugar de visualizarlo
$dompdf->stream("archivo.pdf", ["Attachment" => true]);

