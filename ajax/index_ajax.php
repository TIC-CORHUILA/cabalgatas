<?php
//The database connection configuration file is included.
include("../config/conex.php");

header('Content-Type: application/json');

//Query if the user exists
$sql="SELECT * FROM usuarios WHERE documento='$_POST[user]'";
$res=queryli($sql,1);

if($Rows>0){

	if (password_verify($_POST['password'], $res['password'])) {
		//session_start();
		$_SESSION['id'] = $res['id'];
		$_SESSION['name'] = $res['name'];
		$_SESSION['email'] = $res['email'];
		$_SESSION['rol'] = $res['rol'];

	  echo json_encode(['success' => true]);
	}
	else{
  	echo json_encode(['success' => false, 'message' => 'Verificar las credenciales']);
	}

}
else{
  echo json_encode(['success' => false, 'message' => 'Verificar las credenciales']);
}

?>
