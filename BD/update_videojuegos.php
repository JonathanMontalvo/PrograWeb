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

    // Validar que 'cantidad' sea un entero
    if (!filter_var($data['cantidad'], FILTER_VALIDATE_INT)) {
        $errores[] = "El campo 'cantidad' debe ser un número entero.";
    }

    // Validar que 'precio' sea un double con hasta dos decimales
    if (!preg_match('/^\d+(\.\d{1,2})?$/', $data['precio'])) {
        $errores[] = "El campo 'precio' debe ser un número con hasta dos decimales.";
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

    // Verificar si se recibió un ID válido
    $id = $_POST['id'] ?? null;

    if ($id) {
        // Datos para actualizar
        $actualizar = [
            'nombre' => $_POST['name'],
            'clasificacion' => $_POST['rating'],
            'descripcion' => $_POST['description'],
            'precio' => $_POST['price'],
            'compania' => $_POST['company'],
            'cantidad' => $_POST['quantity'],
            'fecha_lanzamiento' => $_POST['release-date']
        ];

        // Validar los datos antes de la actualización
        $errores = validarDatos($actualizar);

        if (empty($errores)) {
            // Actualizar el videojuego
            if ($videojuegosModelo->updateByID($id, $actualizar)) {
                echo "Datos actualizados correctamente.";
            } else {
                echo "No se logró actualizar.";
            }
        } else {
            foreach ($errores as $error) {
                echo $error . "<br>";
            }
        }
    } else {
        echo "ID de videojuego no válido.";
    }
}
?>