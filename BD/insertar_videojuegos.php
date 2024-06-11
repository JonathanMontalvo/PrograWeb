<?php
require_once ('database.php');
require_once ('orm.php');
require_once ('videojuegos.php');

function validarDatos($data)
{
    $errores = [];

    // Validar que los campos no estén vacíos o solo contengan espacios en blanco
    foreach ($data as $campo => $valor) {
        if (trim($valor) === '') {
            $errores[] = "El campo '$campo' no puede estar vacío o solo contener espacios en blanco.";
        }
    }

    // Validar que 'precio' sea un entero
    if (!filter_var($data['precio'], FILTER_VALIDATE_INT)) {
        $errores[] = "El campo 'precio' debe ser un número entero.";
    }

    // Validar que 'cantidad' sea un double con hasta dos decimales
    if (!preg_match('/^\d+(\.\d{1,2})?$/', $data['cantidad'])) {
        $errores[] = "El campo 'cantidad' debe ser un número con hasta dos decimales.";
    }

    // Validar que 'fecha_lanzamiento' sea una fecha válida en formato YYYY-MM-DD
    $fecha = DateTime::createFromFormat('Y-m-d', $data['fecha_lanzamiento']);
    if (!$fecha || $fecha->format('Y-m-d') !== $data['fecha_lanzamiento']) {
        $errores[] = "El campo 'fecha_lanzamiento' debe ser una fecha válida en formato YYYY-MM-DD.";
    }

    return $errores;
}

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

    $errores = validarDatos($insertar);

    if (empty($errores)) {
        if ($videojuegosModelo->insert($insertar)) {
            echo "Datos insertados correctamente.";
            print_r($insertar);
        } else {
            echo "No se logró añadir.";
        }
    } else {
        foreach ($errores as $error) {
            echo $error . "<br>";
        }
    }
}
?>