<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: sans-serif;
        }

        form {
            opacity: 1.3; /* Set the background opacity using inline style */
        }

        /* Estilos para los modales de error */
        .error-modal {
            display: none;
            position: absolute;
            background-color: #f44336;
            color: white;
            padding: 5px;
            border-radius: 5px;
            z-index: 1;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container-fluid vh-100 d-flex justify-content-center align-items-center" style="background-image: url('./assets/registro.jpeg'); background-size: cover; background-position: center;">
        <form method="post" class="bg-white p-4 rounded shadow-sm" style="width: 300px;">
            <h2 class="text-center mb-3">Registro de Usuario</h2>

            <div class="mb-2">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
                <div id="nombreError" class="error-modal"></div>
            </div>

            <div class="mb-2">
                <label for="apellido_paterno" class="form-label">Apellido Paterno:</label>
                <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" required>
                <div id="apellidoPaternoError" class="error-modal"></div>
            </div>

            <div class="mb-2">
                <label for="apellido_materno" class="form-label">Apellido Materno:</label>
                <input type="text" class="form-control" id="apellido_materno" name="apellido_materno" required>
                <div id="apellidoMaternoError" class="error-modal"></div>
            </div>

            <div class="mb-2">
                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento:</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                <div id="fechaNacimientoError" class="error-modal"></div>
            </div>

            <div class="mb-2">
                <label for="correo" class="form-label">Correo Electrónico:</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
                <div id="correoError" class="error-modal"></div>
            </div>

            <div class="mb-2">
                <label for="contrasenia" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" id="contrasenia" name="contrasenia" required>
                <div id="contraseniaError" class="error-modal"></div>
            </div>

            <button type="submit" class="btn btn-success w-100">Registrar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript para la validación del formulario
        const form = document.querySelector('form');
        const errorModals = document.querySelectorAll('.error-modal');

        form.addEventListener('submit', (event) => {
            event.preventDefault(); // Evita el envío del formulario por defecto

            let isValid = true; // Variable para rastrear si el formulario es válido

            // Validación de campos
            const fields = ['nombre', 'apellido_paterno', 'apellido_materno', 'fecha_nacimiento', 'correo', 'contrasenia'];
            fields.forEach(field => {
                const input = document.getElementById(field);
                const errorModal = document.getElementById(field + 'Error');
                
                if (input.value.trim() === '') {
                    errorModal.textContent = 'Este campo es obligatorio';
                    errorModal.style.display = 'block';
                    isValid = false;
                } else if (field === 'correo' && !validateEmail(input.value)) {
                    errorModal.textContent = 'Por favor, ingrese un correo electrónico válido';
                    errorModal.style.display = 'block';
                    isValid = false;
                } else {
                    errorModal.style.display = 'none';
                }
            });

            // Si todos los campos son válidos, envía el formulario
            if (isValid) {
                form.submit();
            }
        });

        // Función para validar el formato del correo electrónico
        function validateEmail(email) {
            const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        }
    </script>
</body>
</html>
