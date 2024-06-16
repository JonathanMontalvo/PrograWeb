<?php
require_once ('database.php');
require_once ('orm.php');
require_once ('videojuegos.php');

$db = new Database();
$encontrado = $db->verificarDriver();

if ($encontrado) {
    $cnn = $db->getConnection();
    $videojuegosmodelo = new Videojuegos($cnn);
    $videojuegos = $videojuegosmodelo->getAll();

    // Preparar los datos para enviar
    $data = array();
    foreach ($videojuegos as $videojuego) {
        $data[] = array(
            'id' => $videojuego['id'],
            'nombre' => $videojuego['nombre'],
            'clasificacion' => $videojuego['clasificacion'],
            'descripcion' => $videojuego['descripcion'],
            'precio' => $videojuego['precio'],
            'compania' => $videojuego['compania'],
            'fecha_lanzamiento' => $videojuego['fecha_lanzamiento'],
            'cantidad' => $videojuego['cantidad']
        );
    }

    // Convertir el array de datos a JSON
    $jsonData = json_encode($data);

    // Devolver los datos JSON
    echo $jsonData;
}
?>