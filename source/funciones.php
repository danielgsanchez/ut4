<?php

//función para leer archivos
function LeerArchivo(string $archivo): array {
    $arrayContenido = [];
    $fp = fopen($archivo, "r");
    while (!feof($fp)){
        $linea = fgets($fp);
        if (!empty($linea)){
            $arrayLinea = explode("\t", $linea);
            $arrayContenido[] = $arrayLinea;
            
        }
    }
    fclose($fp);
    return $arrayContenido;
}

//función para limpiar datos (trim+strip quotes+transformar en caracteres html)
function LimpiarDatos(string &$var): string {
    $var = trim($var); //quita los espacios delante y detrás
    $var = stripslashes($var); //quita los quotes
    $var = htmlspecialchars($var); //transforma los caracteres especiales
    return $var;
}