<?php
require_once ('database.php');
require_once ('orm.php');
require_once ('videojuegos.php');

$db = new Database();
$encontrado = $db->verificarDriver();

if ($encontrado) {
    $cnn = $db->getConnection();
    $videojuegosModelo = new Videojuegos($cnn);
    $insertar = [];

    $insertar['nombre'] = $_POST['name'];
    $insertar['clasificacion'] = $_POST['rating'];
    $insertar['descripcion'] = $_POST['description'];
    $insertar['precio'] = $_POST['price'];
    $insertar['compania'] = $_POST['company'];
    $insertar['cantidad'] = $_POST['quantity'];
    $insertar['fecha_lanzamiento'] = $_POST['release-date'];

    print_r($insertar);

    /*if ($videojuegosModelo->insert($insertar))
        print_r($insertar);
    else
        echo "No se logro añadir";*/
}
?>