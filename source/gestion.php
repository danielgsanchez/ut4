<?php
    include 'funciones.php';
    if (isset($_REQUEST["modifDatos"])){
        $fp = fopen('UT2 recursos/menu.txt', 'r');
        $cont = 0;
        while (!feof($fp)){
            $linea = fgets($fp);
            if (!empty($linea)){
            $arrayLinea = explode("\t", $linea);
            $arrayCarta[$cont] = $arrayLinea;
            $cont++;
            }
        }
        fclose($fp);
        $fp = fopen('UT2 recursos/menu.txt', 'w');
        fwrite($fp, "");
        fclose($fp);
        $fp = fopen('UT2 recursos/menu.txt', 'a');
        for ($j=0; $j<count($arrayCarta); ++$j){
            if ((!empty($_REQUEST["tipo$j"])) && (!empty($_REQUEST["sabor$j"])) && (!empty($_REQUEST["precio$j"])) && (!empty($_REQUEST["imagen$j"]))) {
                if (!empty($_REQUEST["alergenos$j"])){
                fwrite($fp, $_REQUEST["tipo$j"]."\t".$_REQUEST["sabor$j"]."\t".$_REQUEST["precio$j"]."\t".$_REQUEST["imagen$j"]."\t".$_REQUEST["alergenos$j"].PHP_EOL);
                }
                else {
                    fwrite($fp, $_REQUEST["tipo$j"]."\t".$_REQUEST["sabor$j"]."\t".$_REQUEST["precio$j"]."\t".$_REQUEST["imagen$j"]."\t".PHP_EOL);
                }
            }
        }
        fclose($fp);
    }
    // función LeerArchivo
    $menu = "UT2 recursos/menu.txt";
    $arraySushi = LeerArchivo($menu);
    $i=0;
?>
        <section>
            <article>
            <div class="tablewrapper">
            <table>
                <form action="gestion.php" method="get">
                <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Sabor</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                    <th>Alérgenos</th>
                </tr>
                </thead>
                <?php for ($i=0; $i<count($arraySushi); ++$i){?>
                    <tr>
                        <td><input type="text" name="tipo<?=$i?>" value="<?=$arraySushi[$i][0]?>"/></td>
                        <td><input type="text" name="sabor<?=$i?>" value="<?=$arraySushi[$i][1]?>"/></td>
                        <td><input type="number" min="0" step="any" name="precio<?=$i?>" value="<?=$arraySushi[$i][2]?>"/></td>
                        <td><input type="text" name="imagen<?=$i?>" value="<?=$arraySushi[$i][3]?>"/></td>
                        <td><input type="text" name="alergenos<?=$i?>" value="<?=$arraySushi[$i][4]?>"/></td>
                    </tr>
                <?php
                    }?>
                </table>
                </div><br/>
                <button type="submit" name="modifDatos">Modificar carta</button>
                </form>
            </article>
            <article>
                <?php if (empty($_REQUEST["numMenus"])) {?>
                <form action="gestion.php" method="get">
                    <label for="addMenu">Número de menús a añadir:</label> <input type="number" min="0" name="numMenus"/> <button name="addMenu" type="submit">+</button>
                </form>
                <?php }
                    if (isset($_REQUEST["addMenu"]) && (!empty($_REQUEST["numMenus"]))){
                        $_SESSION["numMenus"] = $_REQUEST["numMenus"];
                    ?>
                    <form action="gestion.php" method="get">
                    <div class="tablewrapper">
                    <table>
                    <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Sabor</th>
                        <th>Precio</th>
                        <th>Imagen</th>
                        <th>Alérgenos</th>
                    </tr>
                    </thead>
                    <?php
                    for ($n=0; $n<$_SESSION["numMenus"]; ++$n){?>
                        <tr>
                            <td><input type="text" name="tipoNew<?=$n?>"/></td>
                            <td><input type="text" name="saborNew<?=$n?>"/></td>
                            <td><input type="number" min="0" step="any" name="precioNew<?=$n?>"/></td>
                            <td><input type="text" name="imagenNew<?=$n?>"/></td>
                            <td><input type="text" name="alergenosNew<?=$n?>"/></td>
                        </tr>
                    <?php }?>
                    </table>
                    </div><br/>
                    <button name="anadir" type="submit">Añadir a la carta</button>
                    </form>
                    <?php }
                    if (isset($_REQUEST["anadir"])){
                        $fp = fopen('UT2 recursos/menu.txt', 'r');
                        $cont = 0;
                        while (!feof($fp)){
                            $linea = fgets($fp);
                            if (!empty($linea)){
                            $arrayLinea = explode("\t", $linea);
                            $arrayCarta[$cont] = $arrayLinea;
                            $cont++;
                            }
                        }
                        fclose($fp);
                        $fp = fopen('UT2 recursos/menu.txt', 'a+');
                        for ($j=0; $j<count($arrayCarta); ++$j){
                            if ((!empty($_REQUEST["tipoNew$j"])) && (!empty($_REQUEST["saborNew$j"])) && (!empty($_REQUEST["precioNew$j"])) && (!empty($_REQUEST["imagenNew$j"]))) {
                                if (!empty($_REQUEST["alergenosNew$j"])){
                                    fwrite($fp, $_REQUEST["tipoNew$j"]."\t".$_REQUEST["saborNew$j"]."\t".$_REQUEST["precioNew$j"]."\t".$_REQUEST["imagenNew$j"]."\t".$_REQUEST["alergenosNew$j"].PHP_EOL);
                                } else {
                                    fwrite($fp, $_REQUEST["tipoNew$j"]."\t".$_REQUEST["saborNew$j"]."\t".$_REQUEST["precioNew$j"]."\t".$_REQUEST["imagenNew$j"]."\t".PHP_EOL);
                                }
                            }
                        }
                        fclose($fp);
                    unset($_SESSION["numMenus"]);
                }?>
            </article>
            <article>
                <form action="mejoresclientes.php" method="get">
                    <button type="submit"> Mostrar mejores clientes </button>
                </form>
            </article>
        </section>