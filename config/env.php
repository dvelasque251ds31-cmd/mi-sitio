<?php
declare(strict_types=1);
 
/** Lee el .env de la raíz y devuelve un arreglo clave => valor. */
function cargar_env(): array
{
    static $variables = null;
    if ($variables !== null) {
        return $variables;
    }
 
    $variables = [];
    $ruta = __DIR__ . '/../.env';
 
    if (!is_readable($ruta)) {
        throw new RuntimeException('No se encontró el archivo .env');
    }
 
    foreach (file($ruta, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $linea) {
        $linea = trim($linea);
        if ($linea === '' || $linea[0] === '#' || !str_contains($linea, '=')) {
            continue;
        }
        [$clave, $valor] = explode('=', $linea, 2);
        $variables[trim($clave)] = trim($valor);
    }
 
    return $variables;
}
