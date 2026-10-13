<?php
//The database connection configuration file is included.
include("../config/conex.php");

if($_POST['action']=="guardarEvento"){
	header('Content-Type: application/json');

		if($_POST["id"]==""){

			//Se consulta el connsecutivo

			$sql="INSERT INTO eventos (fecha, id_organizador, id_usuario,titulo,descripcion, responsable  )
						VALUES('$_POST[fecha]', '$_POST[id_organizador]','$_SESSION[id]', '$_POST[titulo]', '$_POST[descripcion]' , '$_POST[responsable]'   )
			 ";
			if(queryli($sql)){

				$sql="SELECT * FROM eventos ORDER BY id DESC limit 1";
				$res=queryli($sql,1);

	  		echo json_encode(['success' => true, 'id'=>$res['id'] ]);
			}
			else{
	  		echo json_encode(['success' => false]);
			}

		}
		else{

			$sql="UPDATE eventos
						SET fecha='$_POST[fecha]' ,
								id_organizador='$_POST[id_organizador]',
								titulo='$_POST[titulo]',
								descripcion='$_POST[descripcion]',
								responsable='$_POST[responsable]'
						WHERE id='$_POST[id]'
						";
			if(queryli($sql)){
	  		echo json_encode(['success' => true]);
			}
			else{
	  		echo json_encode(['success' => false]);
			}

		}

}

if($_POST['action']=="guardarDetalle"){
	header('Content-Type: application/json');

	$sql="SELECT * FROM eventos_participantes WHERE evento_id = '$_POST[id]' AND ejemplar_id='$_POST[id_ejemplar]'";
	$res=queryli($sql,1);


	if($Rows>0){
		echo json_encode(['success' => true , 'msg' => 'Ejemplar ya está cargado']);
	}
	else{
		$sql="INSERT INTO eventos_participantes (
				evento_id,
				ejemplar_id,
				procedencia,
				departamento,
				municipio,
				montador_id,
				nombre_montador,
				correo_montador,
				celular_montador,
				nombre_palafrenero,
				celular_palafrenero,
				id_usuario
				)
			VALUES(
				'$_POST[id]',
				'$_POST[id_ejemplar]',
				'$_POST[procedencia]',
				'$_POST[departamento]',
				'$_POST[municipio]',
				'$_POST[montador]',
				'$_POST[nombre_montador]',
				'$_POST[correo_montador]',
				'$_POST[celular_montador]',
				'$_POST[nombre_palafrenero]',
				'$_POST[celular_palafrenero]',
				'$_SESSION[id]'
			)";
		if(queryli($sql)){

			//Se consulta el ultimo id
			$sql="SELECT id FROM eventos_participantes ORDER BY id DESC LIMIT 1 ";
			$res=queryli($sql,1);
			$idQr = $res['id'];

			$sql2="SELECT * FROM eventos WHERE id='$_POST[id]'";
			$res2=queryli($sql2,1);

			$textoReporte = '
				<p style="text-align:justify !important">¡Hola, <b>'.$_POST["nombre_montador"].'!</b> 👋<br><br>
					Queremos confirmarte que tu inscripción a la cabalgata <b>'.strtoupper($res2['titulo']).'</b>, programada para el día <b>'. $res2['fecha'] .'</b>, ha sido registrada exitosamente. 🎠🎉
					<br><br>
					Estamos muy emocionados de contar con tu participación en este gran evento.
					<br>
					Prepárate para vivir una experiencia inolvidable llena de tradición, alegría y pasión ecuestre. 🐎✨
					<br>
					Te estaremos enviando más información próximamente para que no te pierdas ningún detalle.
				</p>';

			include('../config/phpqrcode/qrlib.php');
		  $codesDir = "../dist/img/";
			$codeFile = 'codigo_envio.png';

			// Construimos un JSON con la propiedad id
			$json = json_encode([
			    'id' => $idQr
			]);

			// Ahora generamos el QR usando ese JSON como contenido
			$file = QRcode::png($json, $codesDir . $codeFile, 'H', 10);

			$fullPath = $codesDir . $codeFile;
	    // Lee el contenido binario del archivo
	    $imageData = file_get_contents($fullPath);

	    // Codifica en base64
	    $base64 = base64_encode($imageData);

	    // Puedes usarlo en un <img> así:
	    $imgQR = '<img src="data:image/png;base64,' . $base64 . '" style="width:200px; height:200px;">';
			$textoReporte = '
		    <div style="text-align:center;">
	        ' . $textoReporte . '
	        <br><br>
	        ' . $imgQR . '<br>
	        <b>PRESENTAR ESTE CODIGO AL MOMENTO DE INGRESAR AL EVENTO</b>
		    </div>
			';


			//Se envia correo
			include("../config/email.php");

			$username = 'contractor1@simtc1.com';

			$password = 'O9*belB8mt%2';

			$server = 'mail.simtc1.com';

			$outgoing_server = 'mail.simtc1.com';

			$imap_port = '993';
			$pop3_port = '995';
			$smtp_port = '465';




			$adjunto = '';


			$exito=sendEmail($username,$_POST['correo_montador'],'Software Cabalgatas | Registro exitoso','',$textoReporte,'Corporación universitaria del Huila Corhuila','','', $adjunto, $password, $server, $outgoing_server, $imap_port, $pop3_port, $smtp_port);


			echo json_encode(['success' => true,'msg' => '']);
		}
		else{
			echo json_encode(['success' => false]);
		}
	}


}


if($_POST["action"]=="grillaDetalle"){

	$sql="SELECT p.*, e.nombre, e.chip_codigo
				FROM eventos_participantes p
				INNER JOIN ejemplares e ON e.id=p.ejemplar_id
				WHERE p.evento_id='$_POST[id]'";
	$res=queryli($sql,2);

	?>

  <table class="table table-bordered table-striped mt-3" id="listaDetale">
		<thead >
          <tr>
              <th>Id</th>
              <th>Ejemplar</th>
              <th>Código</th>
              <th>Montador</th>
              <th>Nombre</th>
              <th>Palafrenero</th>
              <!-- <th>Acción</th> -->
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
              <td><?=$i?></td>
							<td style="text-align: left !important"><?= ucwords(strtolower($value['nombre'])) ?></td>
							<td style="text-align: left !important"><?= ucwords(strtolower($value['chip_codigo'])) ?></td>
							<td style="text-align: left !important"><?= ucwords(strtolower($value['montador_id'])) ?></td>
							<td style="text-align: left !important"><?= ucwords(strtolower($value['nombre_montador'])) ?></td>
							<td style="text-align: center !important"><?= ucwords(strtolower($value['nombre_palafrenero'])) ?></td>
<!-- 							<td>
                <i  title="Eliminar" class="fas fa-trash	" onclick="eliminarDetalle(<?=$value['id']?>)"  style="font-size:15px;color:#0D3B66 !important" ></i>
							</td> -->
          </tr>

      			<?php
      			$i++;
      		}
      	?>
      </tbody>
  </table>


<?php
}

if($_POST["action"]=="verDatos"){

	header('Content-Type: application/json');

	$sql="SELECT * FROM eventos WHERE id='$_POST[ID]'";
	$res=queryli($sql,1);

	if(queryli($sql)){
		echo json_encode(['success' => true, 'data' => $res ]);
	}
	else{
		echo json_encode(['success' => false, 'data' => [] ]);
	}

}

if($_POST['action']=="buscarMunicipios"){

	$sql="SELECT m.*
				FROM municipios m
				INNER JOIN departamentos d on d.Id = m.Id_Dpto
				WHERE d.Departamento='$_POST[id]'";
	$res=queryli($sql,2);

	foreach ($res as $key => $value) {
		echo "<option>".$value['Municipio']."</option>";
	}

}


if($_POST['action']=="eliminarDetalle"){

	header('Content-Type: application/json');

	$sql="DELETE FROM eventos_participantes WHERE id='$_POST[id]'";

	if(queryli($sql)){
		echo json_encode(['success' => true, 'data' => [] ]);
	}
	else{
		echo json_encode(['success' => false, 'data' => [] ]);
	}

}

?>