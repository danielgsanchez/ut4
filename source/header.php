<?php
    session_start();
    //regex para que el nombre solo pueda contener espacios y letras.
    $patternNOM = "/^[a-zA-Z\s]+$/i";
    //imágenes de perfil predeterminadas para admin moncloa y otros usuarios
    if (isset($_REQUEST["submitLogin"]) && (!empty($_REQUEST['user']))){
        if (preg_match($patternNOM, $_REQUEST['user'])){
            $_SESSION['user'] = $_REQUEST['user'];
            if (empty($_SESSION['pfp'])){
                $_SESSION['pfp'] = "avatardefault.png";
            }
            if ($_SESSION['user'] == "moncloa"){
                $_SESSION['pfp'] = "moncloa.jpg";
            }
            if ($_SESSION['user'] == "admin"){
                $_SESSION['pfp'] = "admin.jpg";
            }
        }
    }
    //desconexión y unset de la sesión
    if ((isset($_REQUEST["submitLogout"])) && ($_REQUEST["submitLogout"]=="desconectar")){
        session_unset();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <meta lang="es"/>
        <meta author="Daniel García Sánchez"/>
        <title>SUSHI SENSEI</title>
        <link rel="stylesheet" href="inicio.css"/>
    </head>
    <body>
        <div class="flexbox">
        <header>
            <div class="logo">
                <img src="UT2 recursos/logo_png.png" width="150">
                <a href="index.php">Sushi Sensei</a>
            </div>
        <nav>
            <?php
                if (!isset($_SESSION["user"])) {?>
                <a href="index.php">Inicio</a>
                <a href="error.php">Perfil</a>
                <a href="error.php">Generar pedido</a>
            <?php } else {?>
                <a href="index.php">Inicio</a>
                <a href="perfil.php">Perfil</a>
                <a href="pedido.php">Generar pedido</a>
            <?php } ?>
            <?php
                if (isset($_SESSION["user"]) && ($_SESSION["user"] == "moncloa")) {?>
                <a href="gestion.php">Gestión de carta y clientes</a>
            <?php } else {?>
                <a style="display:none" href="">Gestión de carta y clientes</a>
            <?php }?>
        </nav>
        </header>
        <aside>
            <?php
                if (!isset($_SESSION["user"])) {?>
            <form action="index.php" method="get">
                <fieldset>
                    <legend>Iniciar sesión</legend>
                    <div class="label"><label for="user">Usuario: </label></div><br/><input type="text" name="user"/><br/><br/><br/>
                    <button name="submitLogin" type="submit" value="conectar">Conectar</button><br/><br/>
                </fieldset>
            </form>
            <?php } else {?>
            <form action="index.php" method="get">
                <fieldset>
                    <legend>Bienvenido</legend>
                    <div class="user"><?=$_SESSION["user"]?></div><br/>
                    <img src="UT2 recursos/<?=$_SESSION["pfp"]?>" width="100px"/><br/><br/>
                    <button name="submitLogout" type="submit" value="desconectar">Desconectar</button><br/><br/>
                </fieldset>
            </form>
            <?php }?>
        </aside>