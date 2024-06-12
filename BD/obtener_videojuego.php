<?php
require_once('database.php');
require_once('orm.php');
require_once('videojuegos.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $db = new Database();
    $encontrado = $db->verificarDriver();

    if ($encontrado) {
        $cnn = $db->getConnection();
        $videojuegosModelo = new Videojuegos($cnn);
        $videojuego = $videojuegosModelo->getByID($id);

        if ($videojuego) {
            echo json_encode($videojuego);
        } else {
            echo json_encode(array('error' => 'Videojuego no encontrado.'));
        }
    } else {
        echo json_encode(array('error' => 'Error al conectar a la base de datos.'));
    }
} else {
    echo json_encode(array('error' => 'ID no proporcionado.'));
}
?>
