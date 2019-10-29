<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Registrar</title>

    <!-- Bootstrap -->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu+Condensed" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Fjalla+One" rel="stylesheet">
    <link href="style3.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<!-- dock -->
<!--
<div id="dock">
    <label id="minidesk"> MiniSO-PHP</label>
</div>
-->
<!-- dock -->

<!-- desktop -->
<div id="desktop">

    <div class="login-box">
        <img src="images/logo7.png" class="avatar" alt="Avatar Image">
        <h1>Registrar Usuario</h1>
        <form action="reg_usuario.php" method="post">
            <!-- USERNAME INPUT -->
            <label for="username">Usuario</label>
            <input type="text" placeholder="Ingrese Nuevo Usuario" name="usuario" required>
            <!-- PASSWORD INPUT -->
            <label for="password">Contraseña</label>
            <input type="password" placeholder="Ingrese Nueva Contraseña" name="pswd" required>
            <input type="submit" value="REGISTRAR">
            <a href="index.html">Regresar</a><br>
        </form>
    </div>

</div>
<!-- desktop -->
<!-- minus app -->
<div id="minusapp"></div>
<!-- minus app -->

<!-- dataappend -->
<div id="data-append"></div>
<!-- dataappend -->



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
<!-- LoadJS -->
</body>
</html>