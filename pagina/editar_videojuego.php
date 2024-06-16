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
    <div class="container mb-3 d-flex justify-content-center">
        <div class="bg-dark text-white p-3 rounded">
            <h2><i class="fas fa-gamepad"></i> Editar Videojuego</h2>
            <form id="gameForm">
                <input type="hidden" id="id" name="id"> <!-- Agregar un campo oculto para almacenar el ID -->
                <div class="form-group">
                    <label for="name"><i class="fas fa-user-ninja"></i> Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Ingresa el nombre"
                        required>
                </div>
                <div class="form-group">
                    <label for="rating"><i class="fas fa-star"></i> Clasificación</label>
                    <input type="text" class="form-control" id="rating" name="rating"
                        placeholder="Ingresa la clasificación" required>
                </div>
                <div class="form-group">
                    <label for="description"><i class="fas fa-scroll"></i> Descripción</label>
                    <textarea class="form-control" id="description" name="description" rows="3"
                        placeholder="Ingresa la descripción" required></textarea>
                </div>
                <div class="form-group">
                    <label for="price"><i class="fas fa-tag"></i> Precio</label>
                    <input type="number" min="0.01" step="0.01" class="form-control" id="price" name="price"
                        placeholder="Ingresa el precio" required>
                </div>
                <div class="form-group">
                    <label for="company"><i class="fas fa-industry"></i> Compañía</label>
                    <input type="text" class="form-control" id="company" name="company"
                        placeholder="Ingresa la compañía" required>
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
                <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Guardar</button>
            </form>
        </div>
    </div>
    <?php
    $id = $_GET['id']; // Obtén el id que enviaste
    ?>
    <script>
        $(document).ready(function () {
            // Obtener el ID del videojuego de la URL
            var id = "<?php echo $id; ?>";

            if (id) {
                $.ajax({
                    url: '../BD/obtener_videojuego.php', 
                    method: 'GET',
                    data: { id: id },
                    dataType: 'json',
                    success: function (response) {
                        if (response.error) {
                            console.error('Error:', response.error);
                            return;
                        }
                        // Llenar el formulario con los datos del videojuego
                        $('#name').val(response.nombre);
                        $('#rating').val(response.clasificacion);
                        $('#description').val(response.descripcion);
                        $('#price').val(response.precio);
                        $('#company').val(response.compania);
                        $('#quantity').val(response.cantidad);
                        $('#release-date').val(response.fecha_lanzamiento);
                    },
                    error: function (xhr, status, error) {
                        console.error('Error al obtener datos del videojuego:', error);
                    }
                });
            }

            $("#gameForm").submit(function (e) {
                e.preventDefault();

                var formData = $(this).serialize() + '&id=' + id; // Incluye el ID en los datos del formulario

                $.ajax({
                    type: "POST",
                    url: "../BD/update_videojuegos.php",
                    data: formData,
                    success: function (result) {
                        console.log(result);
                        // Redirigir a adminVideojuegos.php
                        window.location.href = 'adminVideojuegos.php';
                    }
                });
            });
        });
    </script>
</body>

</html>