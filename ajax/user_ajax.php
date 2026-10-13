<?php
//The database connection configuration file is included.
include("../config/conex.php");

header('Content-Type: application/json');

if($_POST['action']=="guardarUsuarios"){

		if($_POST["id"]==""){

			$_POST['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);

			//Insert
			$sql="INSERT INTO usuarios (name, documento, tipo_documento, email, rol,password, celular, status)
						VALUES ('$_POST[name]','$_POST[documento]','$_POST[tipo_documento]','$_POST[email]','$_POST[rol]','$_POST[password]','$_POST[celular]',1 )";
			queryli($sql);

			//Query the last register
			$sql="SELECT id FROM usuarios ORDER BY id DESC LIMIT 1";
			$res=queryli($sql,1);

			if($Rows>0){
				$_POST['id'] = $res['id'];
			}
		}
		else{

			if($_POST['password']!=""){
				$_POST['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);

				//Update
				$sql="UPDATE usuarios
							SET
								name = '$_POST[name]',
								password = '$_POST[password]',
								tipo_documento = '$_POST[tipo_documento]',
								email = '$_POST[email]',
								documento = '$_POST[documento]',
								celular = '$_POST[celular]',
								rol = '$_POST[rol]'
							WHERE id='$_POST[id]' ";
				queryli($sql);
			}
			else{
				//Update
				$sql="UPDATE usuarios
							SET
								name = '$_POST[name]',
								tipo_documento = '$_POST[tipo_documento]',
								email = '$_POST[email]',
								documento = '$_POST[documento]',
								celular = '$_POST[celular]',
								rol = '$_POST[rol]'
							WHERE id='$_POST[id]' ";
				queryli($sql);
			}
		}

  	echo json_encode(['success' => true]);
}

if($_POST['action']=="consultarUsuario"){

	$sql="SELECT * FROM usuarios WHERE id='$_POST[ID]'";
	$res=queryli($sql,1);

	echo json_encode(['success' => true, 'data' => $res]);

}

if($_POST['action']=="changeStatus"){

	$sql="UPDATE usuarios
				SET status = '$_POST[value]'
				WHERE id='$_POST[id]'";
	queryli($sql);
  	echo json_encode(['success' => true]);

}


?>