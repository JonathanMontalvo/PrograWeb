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
                    <input type="text" class="form-control" id="name" name="name" placeholder="Ingresa el nombre" required>
                </div>
                <div class="form-group">
                    <label for="rating"><i class="fas fa-star"></i> Clasificación</label>
                    <input type="text" class="form-control" id="rating" name="rating" placeholder="Ingresa la clasificación" required>
                </div>
                <div class="form-group">
                    <label for="description"><i class="fas fa-scroll"></i> Descripción</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Ingresa la descripción" required></textarea>
                </div>
                <div class="form-group">
                    <label for="price"><i class="fas fa-tag"></i> Precio</label>
                    <input type="number" min="0.01" step="0.01" class="form-control" id="price" name="price" placeholder="Ingresa el precio" required>
                </div>
                <div class="form-group">
                    <label for="company"><i class="fas fa-industry"></i> Compañía</label>
                    <input type="text" class="form-control" id="company" name="company" placeholder="Ingresa la compañía" required>
                </div>
                <div class="form-group">
                    <label for="quantity"><i class="fas fa-dice"></i> Cantidad</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Ingresa la cantidad" required min="1" step="1">
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
                    var title = ["nombre", "clasificación", "descripción", "compañía"];
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
                    });
                });
            });
        </script>
    </div>

    <div class="container">
        <h1 class="mt-5 text-center">Lista de Videojuegos</h1>
        <table id="tablaVideojuegos" class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Clasificación</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Compañía</th>
                    <th>Fecha de Lanzamiento</th>
                    <th>Detalles</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se insertarán los datos dinámicamente -->
            </tbody>
        </table>

        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Editar Videojuego</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm">
                            <input type="hidden" id="edit-id" name="id">
                            <div class="form-group">
                                <label for="edit-name"><i class="fas fa-user-ninja"></i> Nombre</label>
                                <input type="text" class="form-control" id="edit-name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-rating"><i class="fas fa-star"></i> Clasificación</label>
                                <input type="text" class="form-control" id="edit-rating" name="rating" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-description"><i class="fas fa-scroll"></i> Descripción</label>
                                <textarea class="form-control" id="edit-description" name="description" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="edit-price"><i class="fas fa-tag"></i> Precio</label>
                                <input type="number" min="0.01" step="0.01" class="form-control" id="edit-price" name="price" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-company"><i class="fas fa-industry"></i> Compañía</label>
                                <input type="text" class="form-control" id="edit-company" name="company" required>
                            </div>
                            <div class="form-group">
                                <label for="edit-quantity"><i class="fas fa-dice"></i> Cantidad</label>
                                <input type="number" class="form-control" id="edit-quantity" name="quantity" required min="1" step="1">
                            </div>
                            <div class="form-group">
                                <label for="edit-release-date"><i class="fas fa-calendar-alt"></i> Fecha de Lanzamiento</label>
                                <input type="date" class="form-control" id="edit-release-date" name="release-date" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            // Cargar videojuegos
            $.ajax({
                url: '../BD/Consultar_videojuegos.php',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    $.each(response, function (index, videojuego) {
                        var row = '<tr>';
                        row += '<td>' + videojuego.id + '</td>';
                        row += '<td>' + videojuego.nombre + '</td>';
                        row += '<td>' + videojuego.clasificacion + '</td>';
                        row += '<td>' + videojuego.descripcion + '</td>';
                        row += '<td>' + videojuego.precio + '</td>';
                        row += '<td>' + videojuego.compania + '</td>';
                        row += '<td>' + videojuego.fecha_lanzamiento + '</td>';
                        row += '<td><button class="btn btn-success btn-sm">ver</button></td>';
                        row += '<td><button class="btn btn-info btn-sm btn-edit" data-id="' + videojuego.id + '">editar</button></td>';
                        row += '<td><button class="btn btn-danger btn-sm btn-delete" data-id="' + videojuego.id + '">eliminar</button></td>';
                        row += '</tr>';
                        $('#tablaVideojuegos tbody').append(row);
                    });
                },
                error: function (xhr, status, error) {
                    console.error('Error al obtener datos de videojuegos:', error);
                }
            });

            // Editar videojuego
            $('#tablaVideojuegos').on('click', '.btn-edit', function () {
                var id = $(this).data('id');
                $.ajax({
                    url: '../BD/obtener_videojuego.php',
                    method: 'GET',
                    data: { id: id },
                    dataType: 'json',
                    success: function (response) {
                        $('#edit-id').val(response.id);
                        $('#edit-name').val(response.nombre);
                        $('#edit-rating').val(response.clasificacion);
                        $('#edit-description').val(response.descripcion);
                        $('#edit-price').val(response.precio);
                        $('#edit-company').val(response.compania);
                        $('#edit-quantity').val(response.cantidad);
                        $('#edit-release-date').val(response.fecha_lanzamiento);
                        $('#editModal').modal('show');
                    },
                    error: function (xhr, status, error) {
                        console.error('Error al obtener datos del videojuego:', error);
                    }
                });
            });

            // Enviar formulario de edición
            $('#editForm').submit(function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: '../BD/editar_videojuego.php',
                    data: formData,
                    success: function (result) {
                        console.log(result);
                        $('#editModal').modal('hide');
                        window.location.reload();
                    },
                    error: function (xhr, status, error) {
                        console.error('Error al editar el videojuego:', error);
                    }
                });
            });
        });
    </script>
</body>

</html>
