<?php
@session_start();

require_once 'app/minidesk.conf.php';
$host = HOST;
$db =   DBDATA;
$user = DBUSER;
$pwd =  DBPASS;

$conn = mysqli_connect($host, $user, $pwd, $db);
// verificar conexion
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$idUsuario = $_SESSION['idUsuario'];
$carpeta1 = $_POST['carpeta1'];
$carpeta2 = $_POST['carpeta2'];

if ($carpeta1 != ""){
    $result = mysqli_query($conn, "INSERT INTO `carpeta` (`idCarpeta`, `nomCarpeta`, `usuario_idUsuario`) VALUES (NULL, '$carpeta1', '$idUsuario')");
    header('location: inicio2.php');
}elseif ($carpeta2 != ""){
    $result = mysqli_query($conn, "DELETE FROM `carpeta` WHERE `carpeta`.`nomCarpeta` = '$carpeta2' AND `carpeta`.`usuario_idUsuario` = '$idUsuario'");
    header('location: inicio2.php');
}




//header('location: inicio2.php');

