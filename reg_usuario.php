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

$result = mysqli_query($conn, "INSERT INTO `usuario` (`idUsuario`, `usuario`, `pswd`) VALUES (NULL, '$usuario', '$pswd')");
header('location: index.html');
