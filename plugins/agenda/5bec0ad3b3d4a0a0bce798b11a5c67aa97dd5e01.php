<?php

require_once '../../app/conexion.function.php';

// Agregamos conexion a base de datos
$conexion = Conexion::singleton_conexion();

if (isset($_POST['process'])) {

$process = $_POST['process'];
$tabla = $_POST['tabla'];

#............................................................................................

if ($process == 1){


$SQL = 'SELECT * FROM '.$tabla.'';
$sentence = $conexion -> prepare($SQL);
$sentence -> execute();
$resultados = $sentence -> fetchAll();
if (empty($resultados)){
   $conexion = null;
}else{
	echo'
       <table class="table theagendatablebody">
         <thead style="background: #000;color: #FFF;">
            <tr>
               <th class="text-center">Nombre:</th>
               <th class="text-center">Apellido:</th>
               <th class="text-center">Telefono:</th>
               <th class="text-center">Email:</th>
               <th class="text-center">Comentarios:</th>
               <th class="">Acciones:</th>
            </tr>
         </thead>
         <tbody class="'.$tabla.'">
	';
	foreach ($resultados as $key){
		echo'
          <tr id="contacto'.$key['id'].'">
            <td class="tdnombre'.$key['id'].'">'.$key['nombre'].'</td>
            <td class="tdapellido'.$key['id'].'">'.$key['apellido'].'</td>
            <td class="tdtelefono'.$key['id'].'">'.$key['telefono'].'</td>
            <td class="tdemail'.$key['id'].'">'.$key['email'].'</td>
            <td class="tdcoment'.$key['id'].'">'.$key['comentarios'].'</td>
            <td> 
               <button onclick="editarContacto(agenda,'.$key['id'].')" class="btn btn-xs btn-block btn-primary">Editar</button>
               <button onclick="eliminarContacto(agenda,'.$key['id'].')" class="btn btn-xs btn-block btn-danger">Eliminar</button>
            </td>
          </tr>
		';
	}
	echo '
	    </tbody>
      </table>
      <div id="agenda-append"></div>

<!-- Modal -->
<div class="modal fade" id="NuevoContacto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user"></i> Nuevo Contacto</h4>
      </div>
      <div class="modal-body">
         <form id="NuevoContactoFRM">
             <label class="pull-left">Nombre:</label>
             <input type="text" name="nombre" class="form-control" value=""><p></p>
             <label class="pull-left">Apellido:</label>
             <input type="text" name="apellido" class="form-control" value=""><p></p>
             <label class="pull-left">Telefono:</label>
             <input type="text" name="telefono" class="form-control" value=""><p></p>
             <label class="pull-left">Email:</label>
             <input type="text" name="email" class="form-control" value=""><p></p>
             <label class="pull-left">Comentarios:</label>
             <textarea rows="5" name="comentarios" class="form-control"></textarea>
         </form>
      </div>
      <div class="modal-footer">
        <button onclick="nuevoContactoCrear(agenda)" type="button" class="btn btn-primary"> Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>




	';
}

$conexion = null;


}elseif ($process == 2) {


$SQL = 'SELECT * FROM '.$tabla.' WHERE id = :id';
$sentence = $conexion -> prepare($SQL);
$sentence -> bindParam(':id', $_POST['contacto'] ,PDO::PARAM_INT);
$sentence -> execute();
$resultados = $sentence -> fetchAll();
if (empty($resultados)){
	$conexion = null;
}else{
	foreach ($resultados as $key){
echo'
<!-- Modal -->
<div class="modal fade" id="agenda-model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-user"></i> Editar Contacto</h4>
      </div>
      <div class="modal-body">
         <form id="editarContactoFRM">
             <label class="pull-left">Nombre:</label>
             <input type="text" name="nombre" class="form-control" value="'.$key['nombre'].'"><p></p>
             <label class="pull-left">Apellido:</label>
             <input type="text" name="apellido" class="form-control" value="'.$key['apellido'].'"><p></p>
             <label class="pull-left">Telefono:</label>
             <input type="text" name="telefono" class="form-control" value="'.$key['telefono'].'"><p></p>
             <label class="pull-left">Email:</label>
             <input type="text" name="email" class="form-control" value="'.$key['email'].'"><p></p>
             <label class="pull-left">Comentarios:</label>
             <textarea rows="5" name="comentarios" class="form-control">'.$key['comentarios'].'</textarea>
             <input type="hidden" name="id" value="'.$key['id'].'">
         </form>
      </div>
      <div class="modal-footer">
        <button onclick="guardarCambiosContacto(agenda);" class="btn btn-primary"> Guardar Cambios</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>
';
	}
}

$conexion = null;


}elseif ($process == 3){


$SQL = 'INSERT INTO  '.$tabla.' (nombre, apellido, telefono, email, comentarios) VALUES (:nombre, :apellido, :telefono, :email, :comentarios)';
$sentence = $conexion -> prepare($SQL);
$sentence -> bindParam(':nombre', $_POST['nombre'] ,PDO::PARAM_STR);
$sentence -> bindParam(':apellido', $_POST['apellido'] ,PDO::PARAM_STR);
$sentence -> bindParam(':telefono', $_POST['telefono'] ,PDO::PARAM_STR);
$sentence -> bindParam(':email', $_POST['email'] ,PDO::PARAM_STR);
$sentence -> bindParam(':comentarios', $_POST['comentarios'] ,PDO::PARAM_STR);
$sentence -> execute();
$ultimoid = $conexion -> lastInsertId();
$conexion = null;



echo '
          <tr id="contacto'.$ultimoid.'">
            <td class="tdnombre'.$key['id'].'">'.$_POST['nombre'].'</td>
            <td class="tdapellido'.$key['id'].'">'.$_POST['apellido'].'</td>
            <td class="tdtelefono'.$key['id'].'">'.$_POST['telefono'].'</td>
            <td class="tdemail'.$key['id'].'">'.$_POST['email'].'</td>
            <td class="tdcoment'.$key['id'].'">'.$_POST['comentarios'].'</td>
            <td> 
               <button onclick="editarContacto(agenda,'.$ultimoid.')" class="btn btn-xs btn-block btn-primary">Editar</button>
               <button onclick="eliminarContacto(agenda,'.$ultimoid.')" class="btn btn-xs btn-block btn-danger">Eliminar</button>
            </td>
          </tr>
';



}elseif ($process == 4){

$SQL = 'DELETE FROM '.$tabla.' WHERE id = :id';
$sentence = $conexion -> prepare($SQL);
$sentence -> bindParam(':id', $_POST['contacto'] ,PDO::PARAM_STR);
$sentence -> execute();
$ultimoid = $conexion -> lastInsertId();
$conexion = null;

echo $_POST['contacto'];



}elseif ($process == 5){
	

$SQL = 'UPDATE '.$tabla.' SET nombre = :nombre, apellido = :apellido, telefono = :telefono, email = :email, comentarios = :comentarios WHERE id = :id';
$sentence = $conexion -> prepare($SQL);
$sentence -> bindParam(':nombre', $_POST['nombre'] ,PDO::PARAM_STR);
$sentence -> bindParam(':apellido', $_POST['apellido'] ,PDO::PARAM_STR);
$sentence -> bindParam(':telefono', $_POST['telefono'] ,PDO::PARAM_STR);
$sentence -> bindParam(':email', $_POST['email'] ,PDO::PARAM_STR);
$sentence -> bindParam(':comentarios', $_POST['comentarios'] ,PDO::PARAM_STR);
$sentence -> bindParam(':id', $_POST['id'] ,PDO::PARAM_STR);
$sentence -> execute();

$jsonencode = array('nombre' => $_POST['nombre'], 'apellido' => $_POST['apellido'], 'telefono' => $_POST['telefono'], 'email' => $_POST['email'], 'comentarios' => $_POST['comentarios'], 'id' => $_POST['id']);
echo json_encode($jsonencode);


}





























#............................................................................................
}
