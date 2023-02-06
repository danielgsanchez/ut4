<?php
    $arrayPerfil = array();
    // declaración de las variables de error en los campos nombre, dirección, teléfono y email
    $errorNOM = $errorDIR = $errorTLF = $errorEMAIL = "";
    // patrones
    $patternNOM = "/^[a-zA-Z\s]+$/i";
    $patternDIR = "/^\d{1,3}, [A-za-z0-9 ]+, \d{0,2}\/\d{1,2}?\/[A-Za-z]{1}, [0-9]{5}, [A-za-z ]+$/i"; //13, Calle Atienza, 1/1/A, 19200, Azuqueca de Henares
    $patternTLF = "/^[6|7|9]+[0-9]{8}$/";
    $patternEMAIL = "/^[a-zA-Z0-9_\-.+]+@[a-zA-Z0-9-]+\.[a-zA-Z]+$/";
    $checkCliente = true; //boleano para comprobar si es cliente o no
?>

        <section>
            <article>
                <?php
                if (isset($_REQUEST["confirmarPedido"])){
                    $pedido=fopen("UT2 recursos/pedidos.txt", "a+");
                    fwrite($pedido, $_SESSION["user"]."\t".$_SESSION["totalPrecio"]."\t".date("Y-m-d H:i:s")."\n");
                    fclose($pedido);
                    echo "Pedido realizado con éxito ✔ <br/>";
                }

                    if ((isset($_REQUEST["cambiarDatos"])) && (!isset($_REQUEST["confirmarPedido"]))){
                        //&& (isset($tlf)) && (isset($dir)) && (isset($email))
                        if (!empty($_REQUEST["pfp"])){
                            $_SESSION["pfp"] = $_REQUEST["pfp"];
                        }
                        $cont = 0;
                        $infoClientes = fopen("UT2 recursos/clientes.txt", "r");
                        while (!feof($infoClientes)){
                            $linea = fgets($infoClientes);
                            if (!empty($linea)){
                                $arrayLinea = explode("\t", $linea);
                                $arrayPerfil[$cont] = $arrayLinea;
                                $cont++;
                            }
                        }
                        fclose($infoClientes);
                        
                        for ($j=0; $j<count($arrayPerfil); ++$j){
                            if ($arrayPerfil[$j][0] == $_SESSION["user"]){
                                $clientes = 'UT2 recursos/clientes.txt';
                                $edInfoPerfil = fopen($clientes,'r+');
                                $contenido = fread($edInfoPerfil, filesize($clientes));
                                fclose($edInfoPerfil);
                                // explode para separar
                                $contenido = explode("\n", $contenido);
                                $contenido[$j] = $_SESSION["user"]."\t".$_REQUEST["tlf"]."\t".$_REQUEST["dir"]."\t".$_REQUEST["email"]."\n";
                                // Volver a unir clientes.txt
                                $contenido = implode("\n", $contenido);
                                // Volver a abrir clientes.txt
                                $edInfoPerfil = fopen($clientes,'w');
                                fwrite($edInfoPerfil, $contenido);
                                fclose($edInfoPerfil);
                            }
                        }
                    }
                                $cont = 0; // contador para leer el archivo clientes.txt
                                $infoClientes = fopen("UT2 recursos/clientes.txt", "r");
                                while (!feof($infoClientes)){
                                    $linea = fgets($infoClientes);
                                    if (!empty($linea)){
                                        $arrayLinea = explode("\t", $linea);
                                        $arrayPerfil[$cont] = $arrayLinea;
                                        $cont++;
                                    }
                                }
                    
                    for($j=0; $j<count($arrayPerfil); ++$j){
                            if ($arrayPerfil[$j][0] == $_SESSION["user"]){
                                $checkCliente = false ?>
                        <form action="perfil2.php" method="get">
                            <fieldset>
                                <legend> Datos cliente: </legend>
                                <label for="pfp">Foto de perfil: </label><input type="file" name="pfp" accept="image/*"/><br/><br/>
                                <?php
                                    if ((!empty($_REQUEST["pfp"])) && isset($_REQUEST["cambiarDatos"])){
                                        $_SESSION["pfp"] = $_REQUEST["pfp"];
                                    }
                                ?>
                                <label for="nom">Nombre: </label><?=$arrayPerfil[$j][0]?><br/><br/>
                                <label for="tlf">Teléfono: </label><input type="number" name="tlf" value="<?=$arrayPerfil[$j][1]?>"/><br/><br/>
                                <?php
                                    if ((empty($_REQUEST["tlf"])) && (isset($_REQUEST["cambiarDatos"]))){
                                        $errorTLF = "El campo teléfono es obligatorio. <br/>";
                                        echo $errorTLF;
                                    } if ((!empty($_REQUEST["tlf"])) && (isset($_REQUEST["cambiarDatos"]))) {
                                        if (!preg_match($patternTLF, $_REQUEST["tlf"])){
                                            $errorTLF = "El teléfono debe tener 9 cifras, empezando por 6, 7 o 9. <br/>";
                                            echo $errorTLF;
                                        } else {
                                            $tlf = $_REQUEST["tlf"];
                                        }
                                    }?>
                                <label for="dir">Dirección: </label><input type="text" name="dir" value="<?=$arrayPerfil[$j][2]?>"/><br/><br/>
                                <?php
                                    if ((empty($_REQUEST["dir"])) && (isset($_REQUEST["cambiarDatos"]))){
                                        $errorDIR = "El campo dirección es obligatorio. <br/>";
                                        echo $errorDIR;
                                    } if ((!empty($_REQUEST["dir"])) && (isset($_REQUEST["cambiarDatos"]))) {
                                        if (!preg_match($patternDIR, $_REQUEST["dir"])){
                                        $errorDIR = "La dirección debe seguir el siguiente patrón: número de casa, calle, piso/letra, CP, localidad <br/>";
                                        echo $errorDIR;
                                        } else {
                                            $dir = $_REQUEST["dir"];
                                        }
                                    }?>
                                <label for="email">Email: </label><input type="email" name="email" value="<?=$arrayPerfil[$j][3]?>"/><br/><br/>
                                <?php
                                    if ((empty($_REQUEST["email"])) && (isset($_REQUEST["cambiarDatos"]))){
                                        $errorEMAIL = "El campo email es obligatorio. <br/>";
                                        echo $errorEMAIL;
                                    }
                                    if ((!empty($_REQUEST["email"])) && (isset($_REQUEST["cambiarDatos"]))) {
                                        if (!preg_match($patternEMAIL, $_REQUEST["email"])){
                                            $errorEMAIL = "El correo ha de tener la forma x@y.z, donde x solo pueden ser letras, números, puntos o guiones bajos <br/>";
                                            echo $errorEMAIL;
                                        } else {
                                            $email = $_REQUEST["email"];
                                        }
                                    }
                                ?>
                                <button name="cambiarDatos" type="submit" onclick="window.location.reload()">Cambiar datos</button><br/><br/>
                                <button name="confirmarPedido" type="submit"> Confirmar pedido </button><br/><br/>
                            </fieldset>
                        </form>
                    <?php }
                        }
                        if ($checkCliente == true) { ?>
                            <form action="perfil2.php" method="get">
                                <fieldset>
                                <legend>Datos de usuario: </legend>
                                <label for="pfp">Foto de perfil: </label><input type="file" name="pfp"/><br/><br/>
                                    <?php
                                    if ((!empty($_REQUEST["pfp"])) && isset($_REQUEST["submitPerfil"])){
                                        $_SESSION["pfp"] = $_REQUEST["pfp"];
                                    }
                                    ?>
                                <label for="nom">Nombre: </label><?=$_SESSION["user"]?><br/><br/>
                                <label for="tlf">Teléfono: </label><input type="number" name="tlf"/><br/><br/>
                               <?php
                                    if ((empty($_REQUEST["tlf"])) && (isset($_REQUEST["submitPerfil"]))){
                                        $errorTLF = "El campo teléfono es obligatorio. <br/>";
                                        echo $errorTLF;
                                    } if ((!empty($_REQUEST["tlf"])) && (isset($_REQUEST["submitPerfil"]))) {
                                        if (!preg_match($patternTLF, $_REQUEST["tlf"])){
                                            $errorTLF = "El teléfono debe tener 9 cifras, empezando por 6, 7 o 9. <br/>";
                                            echo $errorTLF;
                                        } else {
                                            $tlf = $_REQUEST["tlf"];
                                        }
                                    }?>
                                <label for="dir">Dirección: </label><input type="text" name="dir"/><br/><br/>
                                <?php
                                    if ((empty($_REQUEST["dir"])) && (isset($_REQUEST["submitPerfil"]))){
                                        $errorDIR = "El campo dirección es obligatorio. <br/>";
                                        echo $errorDIR;
                                    } if ((!empty($_REQUEST["dir"])) && (isset($_REQUEST["submitPerfil"]))) {
                                        if (!preg_match($patternDIR, $_REQUEST["dir"])){
                                        $errorDIR = "La dirección debe seguir el siguiente patrón: número de casa, calle, piso/letra, CP, localidad <br/>";
                                        echo $errorDIR;
                                        } else {
                                            $dir = $_REQUEST["dir"];
                                        }
                                    }?>
                                <label for="email">Email: </label><input type="email" name="email"/><br/><br/>
                                <?php
                                    if ((empty($_REQUEST["email"])) && (isset($_REQUEST["submitPerfil"]))){
                                        $errorEMAIL = "El campo email es obligatorio. <br/>";
                                        echo $errorEMAIL;
                                    }
                                    if ((!empty($_REQUEST["email"])) && (isset($_REQUEST["submitPerfil"]))) {
                                        if (!preg_match($patternEMAIL, $_REQUEST["email"])){
                                            $errorEMAIL = "El correo ha de tener la forma x@y.z, donde x solo pueden ser letras, números, puntos o guiones bajos <br/>";
                                            echo $errorEMAIL;
                                        } else {
                                            $email = $_REQUEST["email"];
                                        }
                                    }
                                    if ((isset($tlf)) && (isset($dir)) && (isset($email))){
                                        $fp = fopen("UT2 recursos/clientes.txt", "a");
                                        fwrite($fp, $_SESSION["user"]."\t".$tlf."\t".$dir."\t".$email."\n");
                                        fclose($fp);
                                    } ?>
                                    <button name="submitPerfil" type="submit">Comprobar datos</button><br/><br/>
                                    <button onclick="window.location.reload()">Refrescar</button><br/><br/>
                                </fieldset>
                                </form>
                        <?php }?>
            </article>
        </section>