<?php
@session_start();
//contrasena: minisophp
//sitio: minisophp
require_once 'app/desktop.inc.php';
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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>MiniSO-PHP</title>

    <!-- Bootstrap -->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu+Condensed" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Fjalla+One" rel="stylesheet">
    <link href="style2.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>



<!-- dock -->
<div id="dock">
    <label id="minidesk"> MiniSO-PHP</label>
    <a href="index.html"> <button class="btn btn-success black-background white my-2 my-sm-0">SALIR</button> </a>
</div>
<!-- dock -->

<!-- desktop -->
<div id="desktop">


    <a id="theexplorer" class="item-option" data-option="explorer" data-item="theexplorer">
        <img src="images/explorer.png">
        <p>Explorador</p>
    </a>

    <a id="thecalculator" class="item-option" data-option="calculator" data-item="thecalculator">
        <img src="images/calculator.png">
        <p>Calculadora</p>
    </a>
    <!--
                <a id="theinstaller" class="item-option" data-option="installer" data-item="theinstaller">
                   <img src="images/installer.png">
                   <p>Instalador</p>
                </a>
    -->


    <!-- Load Icon Components -->
    <?php ComponentesLst(); ?>
    <!-- Load Icon Components -->

    <!-- <a id="theinstaller" class="item-option" data-option="installer" data-item="theinstaller"> -->

    <?php
    $result = mysqli_query($conn, "SELECT * FROM carpeta WHERE usuario_idUsuario = '$idUsuario'");
    while ( $row = mysqli_fetch_assoc($result) ){
        echo " <a  class=\"item-option\" data-item=\"theinstaller\"> ";
        echo "<img src=\"images/carpeta.png\">";
        echo "<p>".$row['nomCarpeta']."</p>";
        echo "</a>";
    }
    ?>
    <form action="mod_carpeta.php" method="post">
        <!-- USERNAME INPUT -->
        <input type="text" placeholder="Crear carpeta" name="carpeta1">
        <input type="text" placeholder="Eliminar carpeta" name="carpeta2">
        <input type="submit" value="MODIFICAR" name="boton">
    </form>

</div>
<!-- desktop -->

<!-- minus app -->
<div id="minusapp"></div>
<!-- minus app -->

<!-- dataappend -->
<div id="data-append"></div>
<!-- dataappend -->

<!-- notifications -->
<div id="notifications">
    <h3 class="animated infinite flash">MiniDESK se actualizara en breve</h3>
</div>
<!-- notifications -->


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<!-- validate -->
<script src="js/jquery.validate.min.js"></script>
<script src="js/additional-methods.min.js"></script>
<!-- jquery iu -->
<script src="js/jquery-ui.js"></script>
<!-- FunctionsAnimate.JS -->
<script src="js/functions-animate.js"></script>
<!-- Right Menu -->
<script src="js/jquery.contextMenu.js"></script>
<!--<script src="js/context-menu-desktop.js"></script>-->
<!-- LoadJS --><?php includeJSDesk(); ?>

<!-- Load the plugin -->
<script src="ctxmenu/ctxmenu.js"></script>


<!-- SCRIP PARA MENU CONTEXTUAL -->
<script>
    // Se llamará a nuestra función cuando el usuario seleccione "¡Hola Mundo!" en el menú contextual personalizado.
    function ContextMenuExampleFunction(){
        alert("Hello World?");
    }


    // Inicializar un menú contextual para toda la página
    var contextMenu = CtxMenu();

    // Agregue nuestra función personalizada al menú
    //contextMenu.addItem("Nueva Carpeta", ContextMenuExampleFunction);
    contextMenu.addItem("Nueva Carpeta");
    // Agregar un separador
    contextMenu.addSeperator();

    // Agregue nuestra función personalizada al menú
    contextMenu.addItem("Nuevo Documento");
    // Agregar un separador
    contextMenu.addSeperator();

    // Agregue un segundo elemento al menú, esta vez con un ícono
    contextMenu.addItem("Actualizar",
        function(){
            location.reload();
        },
        Icon = "images/icon.png"
    );




    //  -  -  -  -  -  -  -  -  //
    //    Ejemplo de menú dos   //
    //  -  -  -  -  -  -  -  -  //


    // Función de ejemplo para cambiar el color de fondo de un elemento
    // Tenga en cuenta que el primer argumento en una función llamada desde el menú ctx será el elemento en el que se hizo clic.
    function ChangeElementColor(element){
        var color = [
            Math.random() * 255,
            Math.random() * 255,
            Math.random() * 255
        ];
        element.style.background = "rgb(" + color + ")"
    }

    // Inicialice un menú personalizado especial para la calse "item-option"
    var contextMenuTwo = CtxMenu(".item-option");
    // Agregue nuestra función personalizada al menú
    //contextMenuTwo.addItem("Change Color", ChangeElementColor);
    contextMenuTwo.addItem("Abrir");
    // Agregar un separador
    contextMenuTwo.addSeperator();

    // Agregue nuestra función personalizada al menú
    contextMenuTwo.addItem("Eliminar");
    // Agregar un separador
    contextMenuTwo.addSeperator();

    // Agregue nuestra función personalizada al menú
    contextMenuTwo.addItem("Cambiar de Nombre");


</script>

</body>
</html>