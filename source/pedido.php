<?php
    $cont=0;
    $menu = fopen("UT2 recursos/menu.txt", "r");
    while (!feof($menu)){
        $linea = fgets($menu);
        if (!empty($linea)){
            $arrayLinea = explode("\t", $linea);
            $arraySushi[$cont] = $arrayLinea;
            $cont++;
        }
    }
    $i=0;
?>
        <section>
            <article>
                <div class="tablewrapper">
                <table>
                    <form action="factura.php" method="get">
                <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Sabor</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                    <th>Alérgenos</th>
                    <th>Cantidad</th>
                </tr>
                </thead>
                <?php for ($j=0; $j<count($arraySushi); ++$j){?>
                    <tr>
                        <td><?=$arraySushi[$j][0]?></td>
                        <td><?=$arraySushi[$j][1]?></td>
                        <td><?php printf("%.2f€", $arraySushi[$j][2])?></td>
                        <td><img src="UT2 recursos/<?=$arraySushi[$j][3]?>" width="150"/></td>
                        <td>
                            <?php
                            if (($arraySushi[$j][0]=="Nigiri") || ($arraySushi[$j][0]=="Maki") || ($arraySushi[$j][0]=="Temaki") || ($arraySushi[$j][0]=="Sashimi")){
                                echo "<img src='UT2 recursos/Icono-sulfitos.png' width='40'/>";
                            }
                            if (($arraySushi[$j][1]==strstr($arraySushi[$j][1], "Salmón")) || ($arraySushi[$j][1]==strstr($arraySushi[$j][1], "Atún")) || ($arraySushi[$j][1]==strstr($arraySushi[$j][1], "Anguila"))){
                                echo "<img src='UT2 recursos/Icono-pescado.png' width='40'/>";
                            }
                            if (($arraySushi[$j][1]==strstr($arraySushi[$j][1], "Cangrejo")) || ($arraySushi[$j][1]=strstr($arraySushi[$j][1], "Langostino"))){
                                echo "<img src='UT2 recursos/Icono-crustaceos.png' width='40'/>";
                            }
                            if (strstr($arraySushi[$j][4], "gluten")){
                                echo "<img src='UT2 recursos/Icono-gluten.png' width='40'/>";
                            }
                            if (strstr($arraySushi[$j][4], "soja")){
                                echo "<img src='UT2 recursos/Icono-soja.png' width='40'/>";
                            }
                            if (strstr($arraySushi[$j][4], "moluscos")){
                                echo "<img src='UT2 recursos/Icono-moluscos.png' width='40'/>";
                            }
                            if (strstr($arraySushi[$j][4], "lacteos")){
                                echo "<img src='UT2 recursos/Icono-lacteos.png' width='40'/>";
                            }
                            if (strstr($arraySushi[$j][4], "mostaza")){
                                echo "<img src='UT2 recursos/Icono-mostaza.png' width='40'/>";
                            }
                            if (strstr($arraySushi[$j][4], "huevos")){
                                echo "<img src='UT2 recursos/Icono-huevos.png' width='40'/>";
                            }
                            if (strstr($arraySushi[$j][4], "sesamo")){
                                echo "<img src='UT2 recursos/Icono-sesamo.png' width='40'/>";
                            }
                            ?></td>
                        <td><?php if ($arraySushi[$j][0]=="Nigiri"){?>
                            <input step="2" max="24" type="number" name="qty<?=$i?>" value="<?php echo isset($_SESSION["pedido$i"]) ? $_SESSION["pedido$i"] : ""?>"/>
                        <?php } elseif ($arraySushi[$j][0]=="Sashimi"){?>
                            <input step="4" max="24" type="number" name="qty<?=$i?>" value="<?php echo isset($_SESSION["pedido$i"]) ? $_SESSION["pedido$i"] : ""?>"/>
                        <?php } elseif ($arraySushi[$j][0]=="Maki"){?>
                            <input step="8" max="24" type="number" name="qty<?=$i?>" value="<?php echo isset($_SESSION["pedido$i"]) ? $_SESSION["pedido$i"] : ""?>"/>
                        <?php } else {?>
                            <input type="number" name="qty<?=$i?>" value="<?php echo isset($_SESSION["pedido$i"]) ? $_SESSION["pedido$i"] : ""?>"/>
                        <?php }?></td>
                    </tr>
                    <?php $i++ ?>
                <?php }?>
                    </table>
                    </div><br/>
                        <button type="submit" name="hacerPedido">Hacer pedido</button>
                    </form>
            </article>
        </section>