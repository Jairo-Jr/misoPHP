<?php

require_once 'conexion.function.php';

// Variable de Conexion a Base de Datos
//$conexion = Conexion::singleton_conexion();



// Despliega los componentes instalados
function ComponentesLst(){
    $conexion = Conexion::singleton_conexion();
    $SQL = 'SELECT * FROM componentes';
    $sentence = $conexion -> prepare($SQL);
    $sentence -> execute();
    $resultados = $sentence -> fetchAll();
    if (empty($resultados)){
    }else{
    	foreach ($resultados as $key){
            echo '
            <a id="theimtem'.$key['id'].'" class="item-option" data-option="'.$key['id'].'" data-item="theimtem'.$key['id'].'">
               <img src="plugins/'.$key['ruta'].'/'.$key['string'].'.png">
               <p alt="'.$key['descripcion'].'">'.$key['nombre'].'</p>
            </a>
            ';
    	}
    }	
}





// Incluye los archivos JS de los componentes
function includeJSDesk(){
    $conexion = Conexion::singleton_conexion();
    $SQL = 'SELECT * FROM componentes';
    $sentence = $conexion -> prepare($SQL);
    $sentence -> execute();
    $resultados = $sentence -> fetchAll();
    if (empty($resultados)){
    }else{
    	foreach ($resultados as $key){
            echo '
    <script src="plugins/'.$key['ruta'].'/'.$key['string'].'.js"></script>
    <script>
      var agenda = new Array("plugins/'.$key['ruta'].'/'.$key['string'].'.php", "'.$key['tabla'].'");
    </script>
            ';
    	}
    }
}