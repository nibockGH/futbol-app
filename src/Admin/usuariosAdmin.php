<?php 
session_start();

// Verifica si el usuario está logueado y es admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../Account/register.php");
    exit();
}

// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_db";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$error = "";


// Consulta para obtener todos los usuarios
$sql = "SELECT id, name, email, role FROM users"; // Cambia 'usuarios' por el nombre de tu tabla
$result = $conn->query($sql);



?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
        // Función para confirmar eliminación
        function confirmarEliminacion(id) {
            // Mostrar mensaje de confirmación
            let confirmar = confirm("¿Estás seguro de que deseas eliminar este usuario?");
            if (confirmar) {
                // Si confirma, redirige a la página de eliminación
                window.location.href = "ModificacionUsuarios/eliminarUsuario.php?id=" + id;
            }
        }
    </script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        h1 {
            color: #343a40;
            text-align: center;
            margin-top: 40px;
            margin-bottom: 20px;
        }
        h3 {
            color: #495057;
            text-align: center;
            margin-bottom: 30px;
        }
        #alumnoList {
            max-width: 600px;
            margin: 0 auto;
            padding: 0;
        }
        .list-group-item {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin-bottom: 10px;
            transition: transform 0.2s;
        }
        .list-group-item:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .list-group-item strong {
            color: #007bff;
        }
        .btn-secondary {
            margin-top: 20px; /* Espacio adicional para el botón de volver */
        }
        body {
            background-color: white; /* color zinc-300 de Tailwind */
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        header {
            background-color: #000000; /* color negro */
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 10; /* Asegura que el header esté encima del contenido */
            height: 56px; /* Ajustar la altura del header */
        }

        .main-content {
            display: flex;
            flex-grow: 1;
            margin-top: 56px; /* Ajustar el contenido principal para que no se superponga al header */
        }

        aside {
            background-color: #2d3748; /* Fondo oscuro para el sidebar */
            width: 250px; /* Ancho del sidebar */
            padding: 20px;
            box-sizing: border-box;
            height: 100vh; /* El sidebar debe ocupar toda la altura */
            position: fixed; /* Sidebar fijo a la izquierda */
            top: 56px; /* Colocar debajo del header */
            left: 0;
            overflow-y: auto; /* Si el contenido es largo, añade scroll */
        }

        main {
            margin-left: 250px; /* Espacio para el sidebar */
            padding: 20px;
            flex-grow: 1;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Gestión de Usuarios</h1>
        <h3>Lista de Usuarios</h3>

        <ul id="alumnoList" class="list-group">
            <?php
            if ($result->num_rows > 0) {
                // Mostrar cada usuario
                while($row = $result->fetch_assoc()) {
                    echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                    echo '<span><strong>' . $row['name'] . '</strong> (' . $row['email'] . ')</span>';
                    echo '<div>';
                    echo '<a href="ModificacionEquipos/modificarUsuario.php?id=' . $row['id'] . '" class="btn btn-primary btn-sm">Editar</a> ';
                    echo '<a href="ModificacionUsuarios/eliminarUsuario.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm">Eliminar</a>';
                    echo '</div>';
                    echo '</li>';
                }
            } else {
                echo '<p>No se encontraron usuarios.</p>';
            }
            ?>
        </ul>

        <!-- Botón para agregar un nuevo usuario -->
        <a href="ModificacionUsuarios/AgregarUsuario.php" class="btn btn-success mt-3">Agregar Usuario</a>

        <!-- Botón para volver al inicio -->
        <button onclick="location.href='adminIndex.php'" class="btn btn-secondary mt-3">Volver al Inicio</button>
    </div>

    <?php
    // Cerrar la conexión a la base de datos
    $conn->close();
    ?>
</body>
</html>
