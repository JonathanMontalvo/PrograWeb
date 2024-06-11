<?php
require_once ('database.php');
require_once ('orm.php');
require_once ('videojuegos.php');

$db = new Database();
$encontrado = $db->verificarDriver();

if ($encontrado) {
    $cnn = $db->getConnection();
    $videojuegosModelo = new Videojuegos($cnn);
    $id = $_POST['videojuegoId'];
    if ($videojuegosModelo->deleteByID($id))
        echo "Videojuego eliminado exitosamente";
    else
        echo "Ocurrio un error al eliminar un dato";
}
?>