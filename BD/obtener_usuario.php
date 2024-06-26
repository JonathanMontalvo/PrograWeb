<?php
require_once ('database.php');
require_once ('orm.php');
require_once ('usuarios.php');
session_start();


$id = $_SESSION["id"];

$db = new Database();
$encontrado = $db->verificarDriver();

if ($encontrado) {
    $cnn = $db->getConnection();
    $usuariosModelo = new Usuarios($cnn);
    $usuario = $usuariosModelo->getByID($id);

    if ($usuario) {
        echo json_encode($usuario);
    } else {
        echo json_encode(array('error' => 'Usuario no encontrado.'));
    }
} else {
    echo json_encode(array('error' => 'Error al conectar a la base de datos.'));
}

?>