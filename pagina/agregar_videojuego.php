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
        .modal-agregar {
            background: none;
            border: none;
        }
    </style>


</head>

<body>
    <div class="container mb-3 d-flex justify-content-center">
        <div class="bg-dark text-white p-3 rounded">
            <h2><i class="fas fa-gamepad"></i> Agregar un nuevo videojuego</h2>
            <form id="gameForm">
                <div class="form-group">
                    <label for="name"><i class="fas fa-user-ninja"></i> Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Ingresa el nombre"
                        pattern="^\S.*\S$" title="No se aceptan campos vacíos" required>
                </div>
                <div class="form-group">
                    <label for="rating"><i class="fas fa-star"></i> Clasificación</label>
                    <input type="text" class="form-control" id="rating" name="rating"
                        placeholder="Ingresa la clasificación" pattern="^\S.*\S$" title="No se aceptan campos vacíos"
                        required>
                </div>
                <div class="form-group">
                    <label for="description"><i class="fas fa-scroll"></i> Descripción</label>
                    <textarea class="form-control" id="description" name="description" rows="3"
                        placeholder="Ingresa la descripción" pattern="^\S.*\S$" title="No se aceptan campos vacíos"
                        required></textarea>
                </div>
                <div class="form-group">
                    <label for="price"><i class="fas fa-tag"></i> Precio</label>
                    <input type="number" min="0.01" step="0.01" class="form-control" id="price" name="price"
                        placeholder="Ingresa el precio" required>
                </div>
                <div class="form-group">
                    <label for="company"><i class="fas fa-industry"></i> Compañía</label>
                    <input type="text" class="form-control" id="company" name="company"
                        placeholder="Ingresa la compañía" pattern="^\S.*\S$" title="No se aceptan campos vacíos"
                        required>
                </div>
                <div class="form-group">
                    <label for="quantity"><i class="fas fa-dice"></i> Cantidad</label>
                    <input type="number" class="form-control" id="quantity" name="quantity"
                        placeholder="Ingresa la cantidad" required min="1" step="1">
                </div>
                <div class="form-group">
                    <label for="release-date"><i class="fas fa-calendar-alt"></i> Fecha de Lanzamiento</label>
                    <input type="date" class="form-control" id="release-date" name="release-date" required max="">
                </div>
                <button type="submit" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Guardar</button>
            </form>
        </div>

        <script>
            $(document).ready(function () {
                // Establecer la fecha máxima para "release-date" como la fecha de hoy
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); // Enero es 0!
                var yyyy = today.getFullYear();
                today = yyyy + '-' + mm + '-' + dd;
                document.getElementById("release-date").max = today;

                $("#gameForm").submit(function (e) {
                    e.preventDefault();

                    // Validar que los campos no estén vacíos ni contengan solo espacios en blanco
                    var fields = ["name", "rating", "description", "company"];
                    var title = ["nombre", "clasificación", "descripción", "compañia"]
                    for (var i = 0; i < fields.length; i++) {
                        var value = document.getElementById(fields[i]).value;
                        if (!value || !value.trim()) {
                            alert("El campo " + title[i] + " no puede estar vacío ni contener solo espacios en blanco.");
                            return false;
                        }
                    }

                    var formData = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: "../BD/insertar_videojuegos.php",
                        data: formData,
                        success: function (result) {
                            console.log(result);
                            // Redirigir a adminVideojuegos.php
                            window.location.href = 'adminVideojuegos.php';
                        }
                    })
                })
            })
        </script>
</body>

</html>