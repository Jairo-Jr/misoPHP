<?php
require_once 'app/minidesk.conf.php';
$host = HOST;
$db =   DBDATA;
$user = DBUSER;
$pwd =  DBPASS;

$usuario = $_POST['usuario'];
$pswd = $_POST['pswd'];

$conn = mysqli_connect($host, $user, $pwd, $db);
// verificar conexion
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$result = mysqli_query($conn, "SELECT * FROM usuario WHERE usuario = '$usuario' AND pswd = '$pswd'");

if(mysqli_num_rows($result) == 0){
    //define('ingreso','no');
    header('location: index.html');
    echo "no se encontraron resultaods";
}else{
    session_start();
    $row = mysqli_fetch_assoc($result);
    $_SESSION['idUsuario'] = $row['idUsuario'];
    header('location: inicio.php');
    echo "se encontraron resultaods";
}
