<?php

require_once 'conexion.function.php';

// Agregamos conexion a base de datos
$conexion = Conexion::singleton_conexion();



if (isset($_POST['process'])){
#............................................................................................


// Carpetas
// <div id="folderapp" class="panel panel-default panel-folder animated zoomIn">
  // <div class="panel-heading"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Aplicaciones
  //    <a class="close-btn pull-right"><i class="fa fa-times" aria-hidden="true"></i></a>
  //    <a class="maximus-btn pull-right"><i class="fa fa-window-maximize" aria-hidden="true"></i></a>
  //    <a class="minimus-btn pull-right"><i class="fa fa-window-restore" aria-hidden="true"></i></a>
  //    <a class="minus-btn pull-right"><i class="fa fa-minus" aria-hidden="true"></i></a>
  // </div>
  //  <div id="appfolder" class="panel-body">

  //  </div>
// </div>




// Process Var
$process = $_POST['process'];


if ($process == 'installer'){

$random = rand(0,999);

echo'
<div id="folderapp" class="panel panel-default panel-folder animated zoomIn window'.$random.'" data-window="'.$random.'" style="width: 450px;">
   <div class="panel-heading"><i class="fa fa-floppy-o" aria-hidden="true"></i> Instalador
      <a class="close-btn pull-right"><i class="fa fa-times" aria-hidden="true"></i></a>
      <a  onclick="minusFolder('.$random.')" class="minus-btn pull-right"><i class="fa fa-minus" aria-hidden="true"></i></a>
   </div>
   <div id="appfolder" class="panel-body">
         
       <div id="first-div-installer" class="col-sm-12">  
         <label>Este es un instalador, se sube el archivo en formato .ZIP y se pueden instalar complementos para agregar al MiniDESK.</label>
         <p></p>
         <button class="btn btn-lg btn-success installerbtn"><i class="fa fa-upload" aria-hidden="true"></i> Seleccionar Archivo ZIP.</button>
         <form id="formuploadcomponent" enctype="multipart/form-data" >
             <input name="process" type="hidden" value="upcomponent" />
             <input name="componente" type="file" id="componentinput" />
         </form>
       </div>

<div id="second-div-installer" class="col-sm-12">
<h3>Espera un momento...</h3>
<div class="progress">
  <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
    <span class="sr-only">20% Complete</span>
  </div>
</div>
</div>

<div id="final-process-installer" class="col-md-12">

</div>

   </div>
</div>
';



}elseif ($process == 'upcomponent') {

      // Iniciamos una session por que la vamos a usar
      session_start();

      // Tomamos la fecha actual
      $date = date('Y-m-d h:i:s');

      // le damos hash a la fecha para obtener un string
      $hashdate = sha1($date);

      // Hacemos una variable por que la usaremos para
      // darle nombre a la carpeta
      $carpeta = 'tmp/'.$hashdate;

      // Ya tomados los datos ponemos la $_SESSION con el nombre de la carpeta.
      $_SESSION['installvariable'] = $carpeta;

      //obtenemos el archivo a subir
      $file = $_FILES['componente']['name'];

      // Carpeta y archivo
      $carpetawithfile = $carpeta.'/'.$file;

      // Creamos la carpeta temporal de la instalacion
      if (!file_exists($carpeta)) {
          mkdir($carpeta, 0777, true);
      }

      // Nombre del archivo sin la extension y poniendo su primer letra como
      // mayuscula para poder agregarlo al escritorio
      $nombrearchivo = substr($file, 0,-4);
      $nombrearchivomayuscula = ucfirst($nombrearchivo);


      //comprobamos si el archivo ha subido
      if ($file && move_uploaded_file($_FILES['componente']['tmp_name'], $carpetawithfile))
      {
           //Creamos un objeto de la clase ZipArchive()
           $enzipado = new ZipArchive();
                
           //Abrimos el archivo a descomprimir
           $enzipado->open($carpetawithfile);
 
           //Extraemos el contenido del archivo dentro de la carpeta especificada
           $extraido = $enzipado->extractTo($carpeta);
           $enzipado->close();
 
           // Si fue extraido bien vamos a tomar los archivos
           // y ponerlo en sus respectivas carpetas
           // para asi poder usar el complemento
           if($extraido == TRUE){

               
              // Creamos carpeta del complemento
           	  $rutafinalcomplemento = '../plugins/'.$nombrearchivo;
              if (!file_exists('../plugins/'.$nombrearchivo)) {
                 mkdir('../plugins/'.$nombrearchivo, 0777, true);
              }

              // Leemos el archivo de la descripcion.
              $leerdescripcion = fopen($carpeta.'/'.$nombrearchivo.'.txt', "r");
              $textocompleto = fgets($leerdescripcion);
              fclose($leerdescripcion);

              // Copiamos Icono del complemento
              $rutaicon =  $rutafinalcomplemento.'/'.$hashdate.'.png';
              copy($carpeta.'/'.$nombrearchivo.'.png', $rutafinalcomplemento.'/'.$hashdate.'.png');

              // Copiamos Archivo PHP del complemento
              copy($carpeta.'/'.$nombrearchivo.'.php', $rutafinalcomplemento.'/'.$hashdate.'.php');

              // Copiamos Archivo de Javascript
              copy($carpeta.'/'.$nombrearchivo.'.js', $rutafinalcomplemento.'/'.$hashdate.'.js');

              // Creamos la tabla de base de datos con la cual trabajara
              // Leemos el archivo de SQL para crear la tabla en la base de datos
              $getthecompSQL = fopen($carpeta.'/'.$nombrearchivo.'.sql', "r");
              $ContentSQLData = fgets($getthecompSQL);
              fclose($getthecompSQL);


              // Insertamos todo en la base de datos
              $cortable = substr($hashdate, 0,15);
              $componenteactive = 1;
              $SQL = 'INSERT INTO componentes (nombre, descripcion, string, fechareg, tabla, ruta, activo)VALUES(:nombre, :descripcion, :string, :fechareg, :tabla, :ruta, :activo)';
              $sentence = $conexion -> prepare($SQL);
              $sentence -> bindParam(':nombre',$nombrearchivomayuscula,PDO::PARAM_STR);
              $sentence -> bindParam(':descripcion',$textocompleto,PDO::PARAM_STR);
              $sentence -> bindParam(':string',$hashdate,PDO::PARAM_STR);
              $sentence -> bindParam(':fechareg',$date,PDO::PARAM_STR);
              $sentence -> bindParam(':tabla',$cortable,PDO::PARAM_STR);
              $sentence -> bindParam(':ruta',$nombrearchivo,PDO::PARAM_STR);
              $sentence -> bindParam(':activo',$componenteactive,PDO::PARAM_INT);
              $sentence -> execute();

              // Ejecutamos la creacion de la base de datos con el nombre del
              // $date en su hash por que asi lo podemos diferenciar de manera mas simple.
              // $CreateTable = str_replace($nombrearchivo,$hashdate, $ContentSQLData);
              $CreateTable = str_replace($nombrearchivo, substr($hashdate, 0,15), $ContentSQLData);
              $CreateTableSentence = $conexion -> prepare($CreateTable);
              $CreateTableSentence -> execute();


              // Borramos la carpeta del complemento
              $filesdeletins = glob($carpeta.'/*'); // totamos todos los archivos
              foreach($filesdeletins as $filefinaldel){ // inciamos un foreach
                if(is_file($filefinaldel))
                  unlink($filefinaldel); // Borramos los archivos
              }
              rmdir($carpeta); // Borramos la carpeta
              echo 1;

           }
           else {
           	 // Borramos la carpeta del complemento
              $filesdeletins = glob($carpeta.'/*'); // totamos todos los archivos
              foreach($filesdeletins as $filefinaldel){ // inciamos un foreach
                if(is_file($filefinaldel))
                  unlink($filefinaldel); // Borramos los archivos
              }
              rmdir($carpeta); // Borramos la carpeta
              echo 2;
           }
      }

      unset($_SESSION['installvariable']); // Hacemos unset a la variable
      $_SESSION['installvariable'] = null; // Volvemos la variable null
      session_destroy(); // Destruimos la session

}elseif ($process == 'calculator') {

$random = rand(0,99999999);

echo'
<div id="folderapp" class="panel panel-default panel-folder animated zoomIn window'.$random.'" data-window="'.$random.'" style="width: 482px;">
   <div class="panel-heading"><i class="fa fa-calculator" aria-hidden="true"></i> Calculadora
      <a class="close-btn pull-right"><i class="fa fa-times" aria-hidden="true"></i></a>
      <a onclick="minusFolder('.$random.')"  class="minus-btn pull-right"><i class="fa fa-minus" aria-hidden="true"></i></a>
   </div>
    <div id="appfolder" class="panel-body" style="padding:0px;">
    <div class="calculator">
        <div class="screen"></div>
        <input type="hidden" value="" class="outcome" />
        <ul class="buttons">
            <li class="clear"><a>C</a></li>
            <li><a data-command="-" class="val">&plusmn;</a></li>
            <li><a data-command="/" class="val">&divide;</a></li>
            <li><a data-command="*" class="val">&times;</a></li>    
            <li><a data-command="7" class="val">7</a></li>
            <li><a data-command="8" class="val">8</a></li>
            <li><a data-command="9" class="val">9</a></li>
            <li><a data-command="-" class="val">-</a></li>
            <li><a data-command="4" class="val">4</a></li>
            <li><a data-command="5" class="val">5</a></li>
            <li><a data-command="6" class="val">6</a></li>
            <li><a data-command="+" class="val">+</a></li>
            <li><a data-command="1" class="val">1</a></li>
            <li><a data-command="2" class="val">2</a></li>
            <li><a data-command="3" class="val">3</a></li>
            <li><a class="equal tall">=</a></li>
            <li><a data-command="0" class="val wide shift">0</a></li>
            <li><a data-command="." class="val shift">.</a></li>
        </ul>
    </div>
    </div>
</div>
<script>
$(function(){$(".val").click(function(a){a.preventDefault();a=$(this).attr("data-command");$(".screen").append(a);$(".outcome").val($(".outcome").val()+a)});$(".equal").click(function(){$(".outcome").val(eval($(".outcome").val()));$(".screen").html(eval($(".outcome").val()))});$(".clear").click(function(){$(".outcome").val("");$(".screen").html("")});$(".min").click(function(){$(".cal").stop().animate({width:"0px",height:"0px",marginLeft:"700px",marginTop:"1000px"},500);setTimeout(function(){$(".cal").css("display",
"none")},600)});$(".close").click(function(){$(".cal").css("display","none")})});
</script>

';


}elseif ($process == 'explorer') {

$random = rand(0,99999);


echo'
 <div id="folderapp" class="panel panel-default panel-folder animated zoomIn window'.$random.'" data-window="'.$random.'" style="width: 99%; top: 35px; left: 10px;">
   <div class="panel-heading"><i class="fa fa-globe" aria-hidden="true"></i> Explorador
      <a class="close-btn pull-right"><i class="fa fa-times" aria-hidden="true"></i></a>
      <a class="maximus-btn pull-right" style="display: none;"><i class="fa fa-window-maximize" aria-hidden="true"></i></a>
      <a class="minimus-btn pull-right" style="display: inline;"><i class="fa fa-window-restore" aria-hidden="true"></i></a>
      <a onclick="minusFolder('.$random.')" class="minus-btn pull-right"><i class="fa fa-minus" aria-hidden="true"></i></a>
   </div>
    <div id="appfolder" class="panel-body" style="padding:0px;">
     
  <div class="col-md-12" style="background: #000;padding: 10px;">
    <div class="input-group">
      <input id="theurlinput" type="text" class="form-control" placeholder="http://">
      <span class="input-group-btn">
        <button onclick="GoToURL()" class="btn btn-success" type="button">Go!</button>
      </span>
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->

  <iframe id="iframeExplorer" width="100%" height="800px;" src="http://www.vivegroup.org"></iframe>


    </div>
 </div>
<script>
   function GoToURL(){
      var theurl = $("#theurlinput").val();
      $("#iframeExplorer").attr("src",theurl);
   }
</script>
';




}elseif (is_numeric($process)){


      $SQL = 'SELECT * FROM componentes WHERE id = :id';
      $sentence = $conexion -> prepare($SQL);
      $sentence -> bindParam(':id', $process, PDO::PARAM_INT);
      $sentence -> execute();
      $resultados = $sentence -> fetchAll();
      if (empty($resultados)){
        echo 1;
      }else{
         foreach ($resultados as $key){
           $id = $key['id'];
           $nombre = $key['nombre'];
           $path = $key['ruta'];
           $tabla = $key['tabla'];
         }
      }

$random = rand(0,999);

echo'
<div id="folderapp'.$id.'" class="panel panel-default panel-folder animated zoomIn window'.$random.'" data-window="'.$random.'">
    <div class="panel-heading"><i class="fa fa-cube" aria-hidden="true"></i> '.$nombre.'
    <a class="close-btn pull-right"><i class="fa fa-times" aria-hidden="true"></i></a>
    <a class="maximus-btn pull-right"><i class="fa fa-window-maximize" aria-hidden="true"></i></a>
    <a class="minimus-btn pull-right"><i class="fa fa-window-restore" aria-hidden="true"></i></a>
    <a onclick="minusFolder('.$random.')" class="minus-btn pull-right"><i class="fa fa-minus" aria-hidden="true"></i></a>
  </div>
  <div id="'.$tabla.'" class="panel-body text-center" style="padding:0px;">
           <div class="line-scale"><div></div><div></div><div></div><div></div><div></div></div>
           <script>
                 setTimeout(function(){
                    ConstructorScript('.$path.');
                 },1000);
           </script>
  </div>
</div>
';





}

































#............................................................................................
}
