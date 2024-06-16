<?php
include('../layout/Nav.php');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X.UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresate</title>
    <link rel="stylesheet" href="../CSS/Estilos.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
    <form id="myForm" class="form" method="post">
        <h2 class="form_title">Inicia Sesión</h2>
            <p style="color: #9e2020" id="Error"></p>
        <p class="form_paragraph">¿No eres cliente? <a href="../pagina/registrarUsuarios.php" class="form_link" style="color: #076bad;">Entra aquí</a></p>
        <div class="form_container">
            <div class="form_group">
                <input type="email" name="Correo" id="Correo" class="form_input" placeholder=" " required>
                <label for="Correo" class="form_label">Correo: </label>
                <span class="form_line"></span>
            </div>
            <div class="form_group">
                <input type="password" name="pws" id="pws" class="form_input" placeholder=" " required>
                <label for="pws" class="form_label">Contraseña: </label>
                <span class="form_line"></span>
            </div>
            <button type="submit" name="Entrar">Entrar</button>
        </div> <!-- Cierre de la primera sección form_container -->
    </form>
    <?php include('../layout/footer.php'); ?>
    <script>
        $(document).ready(function() {

            $('#myForm').submit(function(event) {
                // Evitar el envío predeterminado del formulario
                event.preventDefault();
                $('#Error').text('')
                // Validación del correo electrónico con expresión regular
                var correo = $('#Correo').val();
                var errores = {};

                if (!/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(correo)) {
                    errores['correo'] = "El correo electrónico no es válido.";
                }

                // Si hay errores, mostrar mensajes y no enviar el formulario
                if (Object.keys(errores).length > 0) {
                    // Aquí puedes mostrar mensajes de error, por ejemplo:
                    console.log(errores);
                    $('#Error').text(errores['correo']);
                    return;
                }

                // Si no hay errores, proceder con el envío mediante AJAX
                var formData = {
                    'Correo': correo,
                    'pws': $('#pws').val()
                };

                // Enviar la solicitud POST usando AJAX
                $.ajax({
                    type: "POST",
                    url: '../BD/login.php', // The URL where you want to POST the data
                    data: formData,
                    success: function (result) {
                        if(result.success==true){
                        if(result.role=="ADMIN")
                        {
                            window.location.href = 'adminVideojuegos.php';
                        }else{
                            window.location.href = 'usuario_videojuegos.php';
                        }
                        }else
                        {
                            $('#Error').text("Credenciales no Validas");
                        }
                    } ,error: function (xhr, status, error) {
                        console.error("Error en la solicitud:", status, error);
                        $('#Error').text("Hubo un Error en el Sistema");
                    }
                });
            });
        });
    </script>

</body>

</html>