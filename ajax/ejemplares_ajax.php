<?php
//The database connection configuration file is included.
include("../config/conex.php");


if($_POST['action']=="guardarEjemplar"){
	header('Content-Type: application/json');

    $imagen = '';
	  // Procesar el archivo si fue subido
	  if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
	    $uploadDir = '../uploads/'; // Directorio donde se guardará el archivo
	    $uploadFile = $uploadDir . rand() .basename($_FILES['imagen']['name']);

	    // Mover el archivo subido al directorio deseado
	    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadFile)) {
	        // Archivo subido exitosamente

	    	$imagen = str_replace('../', '', $uploadFile);
	    } else {
	      $imagen = '';
	    }
	  }

		if($_POST["id"]==""){

			if($imagen==""){
				//Insert
				$sql = "INSERT INTO ejemplares (nombre, chip_codigo, peso, alzada, color, sexo, edad, andar, raza, especie, condicion_corporal, unidad)
				        VALUES ('$_POST[nombre]', '$_POST[chip]', '$_POST[peso]', '$_POST[alzada]', '$_POST[color]', '$_POST[sexo]', '$_POST[edad]', '$_POST[andar]', '$_POST[raza]', '$_POST[especie]', '$_POST[condicion_corporal]','$_POST[unidad]')";
				queryli($sql);
			}
			else{
				//Insert
				$sql = "INSERT INTO ejemplares (foto, nombre, chip_codigo, peso, alzada, color, sexo, edad, andar, raza, especie, condicion_corporal, unidad)
				        VALUES ('$imagen', '$_POST[nombre]', '$_POST[chip]', '$_POST[peso]', '$_POST[alzada]', '$_POST[color]', '$_POST[sexo]', '$_POST[edad]', '$_POST[andar]', '$_POST[raza]', '$_POST[especie]', '$_POST[condicion_corporal]', '$_POST[unidad]')";
				queryli($sql);
			}

			//Se consulta el registro
			$sql="SELECT id FROM ejemplares ORDER BY id DESC LIMIT 1";
			$res=queryli($sql,1);

			$id=$res['id'];

		}
		else{
		  $CRIT = '';

		  if($imagen!=""){
		  	$CRIT.=" ,foto='$imagen'";
		  }

			$sql = "UPDATE ejemplares
			        SET nombre = '$_POST[nombre]',
			            chip_codigo = '$_POST[chip]',
			            peso = '$_POST[peso]',
			            alzada = '$_POST[alzada]',
			            color = '$_POST[color]',
			            sexo = '$_POST[sexo]',
			            edad = '$_POST[edad]',
			            unidad = '$_POST[unidad]',
			            andar = '$_POST[andar]',
			            raza = '$_POST[raza]',
			            especie = '$_POST[especie]',
			            condicion_corporal = '$_POST[condicion_corporal]'
			            $CRIT
			        WHERE id = '$_POST[id]'";
			queryli($sql);

			$id = $_POST['id'];
		}

  	echo json_encode(['success' => true,'data'=>$id ]);
}

if($_POST['action']=="consultarEjemplar"){
	header('Content-Type: application/json');

	$sql="SELECT * FROM ejemplares WHERE id='$_POST[id]'";
	$res=queryli($sql,1);

	echo json_encode(['success' => true, 'data' => $res]);

}


if($_POST['action']=="divVacuna"){

$sql="SELECT * FROM ejemplares_vacunas WHERE id_ejemplar='$_POST[id]' ORDER BY id DESC";
$res=queryli($sql,2);

?>

			            <table class="table table-bordered" id="tablaVacuna" width="100%">
			                <thead>
			                    <tr>
			                        <th>No</th>
			                        <th>Nombre</th>
			                        <th>Estado</th>
			                        <th>Fecha</th>
			                        <th>Acción</th>
			                    </tr>
			                </thead>
			                <tbody>
			                	<?php
			                		$i = 1;
			                		foreach ($res as $key => $value) {

			                			$color = '';

			                			if($value['aprobado']==1){
			                				$color = "#34A88A; color:white";
			                			}
			                			else if($value['aprobado']==2){
			                				$color = "#FF4F4F; color:white";
			                			}

?>
			                    <tr>
		                        <td style="background-color: <?=$color?>" ><?=$i ?></td>
		                        <td style="background-color: <?=$color?>" ><?=$value['nombre'] ?></td>
		                        <td style="background-color: <?=$color?>" >
		                        	<?=$value['cumple'] ?>
		                        </td>
		                        <td style="background-color: <?=$color?>" >
		                        	<?=$value['fecha_aplicacion'] ?>
		                        </td>
														 <td align=center style="background-color: <?=$color?>" >
                              	<?php
                              		if($value['archivo_adjunto']!=""){
                              	?>
                              		<a href="../../<?=$value['archivo_adjunto']?>" target="_blank" >
                              			<i class="fas fa-file-pdf" onclick="abrirAdjunto(<?=$value['id']?>)"  style="font-size:18px; cursor:pointer; color: red" ></i>
                              		</a>
                              	<?php
                              	}

                              	if($value['nombre']=="Encefalitis Equina Venezolana" && $value['aprobado'] == null ){
                              	?>
																	<i class="fas fa-check-circle" onclick="aprobar(<?=$value['id']?>,1)" style="font-size: 18px; cursor: pointer; color: green;"></i>
																	<i class="fas fa-times-circle" onclick="aprobar(<?=$value['id']?>,2)" style="font-size: 18px; cursor: pointer; color: red;"></i>
                              	<?php
                              	}
                              	else{
                              		?>
	                              	<i class="fas fa-trash	" onclick="eliminarVacuna(<?=$value['id']?>)"  style="font-size:18px; cursor:pointer; color: blue" ></i>
                              		<?php
                              	}
                              	?>
                            	</td>
			                    </tr>

<?php
													$i++;
			                		}

			                	?>

			                </tbody>
			            </table>


<?php

}


if($_POST['action']=="guardarVacuna"){
	header('Content-Type: application/json');

  $archivo_adjunto = '';
  // Procesar el archivo si fue subido
  if (isset($_FILES['archivo_adjunto']) && $_FILES['archivo_adjunto']['error'] == UPLOAD_ERR_OK) {
    $uploadDir = '../uploads/estado_sanitario/'; // Directorio donde se guardará el archivo
    $uploadFile = $uploadDir . rand() .basename($_FILES['archivo_adjunto']['name']);

    // Mover el archivo subido al directorio deseado
    if (move_uploaded_file($_FILES['archivo_adjunto']['tmp_name'], $uploadFile)) {
        // Archivo subido exitosamente

    	$archivo_adjunto = str_replace('../', '', $uploadFile);
    } else {
      $archivo_adjunto = '';
    }
  }


	$sql="INSERT INTO ejemplares_vacunas (nombre, cumple, fecha_aplicacion, id_ejemplar,archivo_adjunto )
				VALUES('$_POST[nombre_vacuna]','$_POST[cumple_vacuna]','$_POST[fecha_vacuna]','$_POST[id]','$archivo_adjunto')
			 ";
	queryli($sql);

	echo json_encode(['success' => true]);

}

if($_POST['action']=="eliminarVacuna"){
	header('Content-Type: application/json');

	$sql="DELETE FROM ejemplares_vacunas WHERE id='$_POST[id]'";
	queryli($sql);

	echo json_encode(['success' => true]);


}

if($_POST["action"]=="actualizarReproduccion"){
	header('Content-Type: application/json');

	$sql="UPDATE ejemplares
				SET gestante = '$_POST[gestante]', tiempo_gestacion='$_POST[tiempo_gestacion]', castrado='$_POST[castrado]'
				WHERE id='$_POST[id]' ";
	queryli($sql);
	echo json_encode(['success' => true]);

}


if($_POST["action"]=="actualizarPropietario"){
	header('Content-Type: application/json');

	$sql="UPDATE ejemplares
				SET nombre_propietario = '$_POST[nombre_propietario]', correo_electronico='$_POST[correo_electronico]',
						celular='$_POST[celular]', documento_propietario='$_POST[documento_propietario]'
				WHERE id='$_POST[id]' ";
	queryli($sql);
	echo json_encode(['success' => true]);

}


if($_POST["action"]=="actualizarVeterinario"){
	header('Content-Type: application/json');

	$sql="UPDATE ejemplares
				SET nombre_veterinario = '$_POST[nombre_veterinario]', matricula_profesional='$_POST[matricula_profesional]', contacto_veterinario='$_POST[contacto_veterinario]'
				WHERE id='$_POST[id]' ";
	queryli($sql);
	echo json_encode(['success' => true]);

}

if($_POST["action"]=="aprobar"){
	header('Content-Type: application/json');

	date_default_timezone_set('America/Bogota');
	$hoy = date('Y-m-d H:i:s');

	$sql = "UPDATE ejemplares_vacunas
	        SET aprobado='$_POST[opc]', id_usuario_aprueba='$_SESSION[id]', fecha_aprueba='$hoy'
	        WHERE id='$_POST[id]'";

	queryli($sql);

	echo json_encode(['success' => true]);

}

?>