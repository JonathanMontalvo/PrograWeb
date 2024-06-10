<?php
require_once('database.php');
require_once('orm.php');
require_once('usuarios.php');

$db = new Database();
$encontrado = $db->verificarDriver();

if ($encontrado) {
    $cnn = $db->getConnection();
    $usuariosmodelo = new Usuarios($cnn);
    $usuarios = $usuariosmodelo->getAll();

    // Preparar los datos para enviar
    $data = array();
    foreach ($usuarios as $usuario) {
        $data[] = array(
            'id' => $usuario['id'],
            'apellido_paterno' => $usuario['apellido_paterno'],
            'apellido_materno' => $usuario['apellido_materno'],
            'nombre' => $usuario['nombre'],
            'fecha_nacimiento' => $usuario['fecha_nacimiento'],
            'correo' => $usuario['correo'],
            'contrasenia' => $usuario['contrasenia'],
            'rol'=>$usuario['rol']
        );
    }

    // Convertir el array de datos a JSON
    $jsonData = json_encode($data);

    // Devolver los datos JSON
    echo $jsonData;
}
?>