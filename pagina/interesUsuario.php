<?php
include ('../layout/navUsuario.php');
?>
<!DOCTYPE html>
<html>

<head>
    <!-- CSS de Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        .modal-editar {
            background: none;
            border: none;
        }
    </style>
</head>

<body>
    <h1>-</h1>
    <h1 class="mt-5 text-center sty">Datos de usuario</h1>
    <div class="container mb-3 d-flex justify-content-center">
        <div class="bg-dark text-white p-3 rounded">
            <h2><i class="fas fa-gamepad"></i> Editar Usuario</h2>
            <form id="userForm">
                <input type="hidden" id="id" name="id"> <!-- Agregar un campo oculto para almacenar el ID -->
                <div class="form-group">
                    <label for="email"><i class="fas fa-user-ninja"></i> Correo</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Ingresa el correo"
                        required>
                </div>
                <div class="form-group">
                    <label for="password"><i class="fas fa-industry"></i>Contraseña</label>
                    <input type="password" class="form-control" id="pws" name="pws" placeholder="Ingresa la contraseña "
                        required>
                </div>
                <div class="form-group">
                    <label for="release-date"><i class="fas fa-calendar-alt"></i> Fecha de Nacimiento</label>
                    <input type="date" class="form-control" id="release-date" name="release-date" required max="">
                </div>
                <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Guardar</button>
            </form>
        </div>
    </div>
    <?php
    $id = $_GET['id']; // Obtén el id que enviaste
    ?>
    <script>
        $(document).ready(function () {
            // Obtener el ID del usuario de la URL
            var id = "<?php echo $id; ?>";

            if (id) {
                $.ajax({
                    url: '../BD/obtener_usuario.php', // Cambia esto al nombre del archivo PHP que obtenga los datos del videojuego
                    method: 'GET',
                    data: { id: id },
                    dataType: 'json',
                    success: function (response) {
                        if (response.error) {
                            console.error('Error:', response.error);
                            return;
                        }
                        // Llenar el formulario con los datos del videojuego
                        $('#email').val(response.nombre);
                        $('#password').val(response.cantidad);
                        $('#release-date').val(response.fecha_lanzamiento);
                    },
                    error: function (xhr, status, error) {
                        console.error('Error al obtener datos del usuario:', error);
                    }
                });
            }

            $("#userForm").submit(function (e) {
                e.preventDefault();

                var formData = $(this).serialize() + '&id=' + id; // Incluye el ID en los datos del formulario

                $.ajax({
                    type: "POST",
                    url: "../BD/update_usuario.php",
                    data: formData,
                    success: function (result) {
                        console.log(result);
                        // Redirigir a adminVideojuegos.php
                        window.location.href = 'usuario_videojuegos.php';
                    }
                });
            });
        });
    </script>
</body>

</html>