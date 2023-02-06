<?php
    $arrayClientes = array();
    $fp = fopen('UT2 recursos/pedidos.txt', 'r');
    while (!feof($fp)){
        $linea = fgets($fp);
        if (!empty($linea)){
            $arrayLinea = explode("\t", $linea);
            if (array_key_exists($arrayLinea[0], $arrayClientes)){
                $arrayClientes[$arrayLinea[0]] += $arrayLinea[1];
            } else {
                $arrayClientes[$arrayLinea[0]] = $arrayLinea[1];
            }
        }
    }

?>
        <section>
            <article>
                <?php
                arsort($arrayClientes);
                ?>
                <div class="tablewrapper">
                <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Total pedido</th>
                    </tr>
                </thead>
                <?php 
                $cont=0;
                foreach ($arrayClientes as $nombre => $gasto){
                    if ($cont==0){
                        echo "<tr><td> $nombre 🥇</td> <td>$gasto €</td></tr>";
                    }
                    elseif ($cont==1){
                        echo "<tr><td> $nombre 🥈</td> <td>$gasto €</td></tr>";
                    }
                    elseif ($cont==2){
                        echo "<tr><td> $nombre 🥉</td> <td>$gasto €</td></tr>";
                    }
                    else {
                        echo "<tr><td> $nombre</td> <td>$gasto €</td></tr>";
                    }
                    ++$cont;
                }?>
                </table>
                </div><br/>
                <button onclick="window.history.go(-1)">Volver atrás</button> 
            </article>
        </section>