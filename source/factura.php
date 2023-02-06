<?php
    include 'funciones.php';
    $checkCliente = true;
    //definir $menu para la función LeerArchivo
    $menu = "UT2 recursos/menu.txt";
    $arraySushi = LeerArchivo($menu);
    //inicialización de variables
    $arrayTotalQty = array();
    $arrayTotalPrecio = array();
    $arrayNigiri = array();
    $precioNigiri = array();
    $arrayMaki = array();
    $precioMaki = array();
    $sumaNigiri = 0;
    $numBandejasNigiri = 0;
    $descuentoNigiri = 0;
    $sumaMaki = 0;
    $numBandejasMaki = 0;
    $descuentoMaki = 0;
?>
        <section>
            <article>
            <?php
                if (isset($_REQUEST["hacerPedido"])) {?>
                <form action="perfil2.php" method="get">
                <div class="tablewrapper">
                <table>
                    <tr>
                        <th>Tipo</th>
                        <th>Sabor</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                    <?php 
                     for ($i=0; $i<count($arraySushi); $i++){
                            if (empty($_REQUEST["qty$i"])){
                                $_SESSION["pedido$i"] = "";

                            }
                            if (!empty($_REQUEST["qty$i"])){
                                $_SESSION["pedido$i"] = $_REQUEST["qty$i"];
                                array_push($arrayTotalQty, $_REQUEST["qty$i"]);
                                array_push($arrayTotalPrecio, ($_REQUEST["qty$i"]*$arraySushi[$i][2]));
                                
                                if ($arraySushi[$i][0] == "Nigiri"){
                                    array_push($arrayNigiri, $_REQUEST["qty$i"]);
                                    array_push($precioNigiri, $arraySushi[$i][2]*2);
                                }
    
                                if ($arraySushi[$i][0] == "Maki"){
                                    array_push($arrayMaki, $_REQUEST["qty$i"]);
                                    array_push($arrayMaki, $arraySushi[$i][2]*8);
                                }
                            
                            ?>
                                <tr>
                                    <td><?=$arraySushi[$i][0]?></td>
                                    <td><?=$arraySushi[$i][1]?></td>
                                    <td><?php printf("%'#7.2f€",$arraySushi[$i][2])?></td>
                                    <td><?php printf("%'#7.2f",$_REQUEST["qty$i"])?></td>
                                    <td><?php printf("%'#7.2f€",$_REQUEST["qty$i"]*$arraySushi[$i][2])?></td>
                                </tr>
                            <?php
                            }
                        }
                        // si hay 6 de cada
                        if (count($arrayNigiri)==6){
                            //cada 2 va a ser una bandeja
                            $numBandejasNigiri = min($arrayNigiri)/2;
                            $precioNigiriSum = array_sum($precioNigiri);
                            $descuentoNigiri = (($precioNigiriSum*0.25)*$numBandejasNigiri);
                        }
                        // si hay 6 de cada
                        if (count($arrayMaki)==6){
                            //cada 8 va a ser una bandeja
                            $numBandejasMaki = min($arrayMaki)/8;
                            $precioMakiSum = array_sum($precioMaki);
                            $descuentoMaki = (($precioMakiSum*0.25)*$numBandejasMaki);
                        }
                    ?>
                </table>
                </div><br/><br/>
                <div class="tablewrapper">
                <table>
                    <tr>
                        <th>CANTIDAD TOTAL</th>
                        <th>PRECIO TOTAL</th>
                    </tr>
                    <tr>
                        <?php
                        $arrayTotalQty = array_sum($arrayTotalQty);
                        // guardamos en la sesión la cantidad total para pedidos.txt
                        $_SESSION["totalQty"] = intval($arrayTotalQty);
                        $arrayTotalPrecio = array_sum($arrayTotalPrecio);
                        // aplicamos el descuento. Si no hay, no se aplicará (será 0)
                        $arrayTotalPrecio = $arrayTotalPrecio - $descuentoMaki;
                        $arrayTotalPrecio = $arrayTotalPrecio - $descuentoNigiri;
                        //guardamos en la sesión el precio para pedidos.txt
                        $_SESSION["totalPrecio"] = $arrayTotalPrecio;
                        ?>
                        <td><?php printf("%'#7.2f",$arrayTotalQty)?></td>
                        <td><?php printf("%'#7.2f€",$arrayTotalPrecio)?></td>
                    </tr>
                </table>
                </div><br/><br/>
                <button type="submit" name="confirmarPerfil">Confirmar perfil</button>
                <button type="button" onclick="history.go(-1)">Ir atrás</button>
                </form>
            <?php }?>
            </article>
        </section>