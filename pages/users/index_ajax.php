<?php
//The database connection configuration file is included.
include("../../config/conex.php");

header('Content-Type: application/json');

if($_POST["action"]=="verQr"){
	include('../../config/phpqrcode/qrlib.php');

  $codesDir = "../../assets/images/codes/";
  $codeFile = $_POST['id'].'.png';

	//Query users
	$sql="SELECT * FROM users WHERE id='$_POST[id]'";
	$res=queryli($sql,1);

	QRcode::png($res['id'], $codesDir.$codeFile, 'H', '10');
  echo json_encode(['success' => true]);

}

if($_POST["action"]=="verBarCode"){
	require 'BarcodeGenerator.php';

  $codesDir = "../assets/images/codes/bar/";
  $codeFile = $_POST['id'].'.png';

	//Query users
	$sql="SELECT * FROM users WHERE id='$_POST[id]'";
	$res=queryli($sql,1);

	$text = $res;

	barcode( $codesDir.$codeFile, $text,'70','horizontal','code128',false,1);


  echo json_encode(['success' => true]);

}


if($_POST["action"]=="saveNFC"){

	$sql="UPDATE users
				SET CODE_TAG = '$_POST[nfc]'
				WHERE ID='$_POST[id]' ";
	queryli($sql)			;
  echo json_encode(['success' => true]);

}


if($_POST["action"]=="loadNFC"){

	$sql="SELECT * FROM users	WHERE ID='$_POST[id]' ";
	$res=queryli($sql,1);

  echo json_encode(['success' => true,'NFC' => $res['CODE_TAG']]);


}


if($_POST["action"]=="guardarUsuario"){

	if($_POST["id"]==""){
		//Se consulta si existe el correo
		$sql="SELECT * FROM users WHERE email='$_POST[email]'";
		$res=queryli($sql,1);

		if($Rows==0){

			// Crear el hash de la contraseña
			$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

			$sql="INSERT INTO users (name, email, rol,password) VALUES('$_POST[user]','$_POST[email]','$_POST[rol]','$hash' ) ";
			queryli($sql);

		  echo json_encode(['success' => true]);

		}
		else{
		  echo json_encode(['success' => false]);
		}
	}
	else{

		if($_POST['password']==""){
			$sql="UPDATE users
						SET name='$_POST[user]', rol='$_POST[rol]'
						WHERE id='$_POST[id]' ";

		}
		else{
			// Crear el hash de la contraseña
			$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

			$sql="UPDATE users
						SET name='$_POST[user]', rol='$_POST[rol]', password='$hash'
						WHERE id='$_POST[id]' ";
		}

		queryli($sql);
	  echo json_encode(['success' => true]);
	}


}

if($_POST["action"]=="consultarUsuario"){

	$sql="SELECT * FROM users WHERE id='$_POST[id]'";
	$res=queryli($sql,1);

  echo json_encode(['success' => true, 'data' => $res ]);

}

?>