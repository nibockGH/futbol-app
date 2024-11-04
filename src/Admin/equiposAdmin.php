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


// Consulta para obtener todos los equipos
$sql = "SELECT id, nombre, tipo_cancha, usuario_id, numero_participante, puntos FROM equipos";
$result = $conn->query($sql);



?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Equipos</title>
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
        <h1 class="mt-5">Gestión de Equipos</h1>
        <h3>Lista de Equipo</h3>

        <ul id="equipoList" class="list-group">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
            
            // Mostrar el nombre, ID del creador y el total de puntos
            echo '<span><strong>' . $row['nombre'] . '</strong> (Id del creador: ' . $row['usuario_id'] . ') (Total de pts: ' . $row['puntos'] . ')</span>';
            
            echo '<div>';
            echo '<a href="#.php?id=' . $row['id'] . '" class="btn btn-primary btn-sm">Editar</a> ';
            echo '<a href="ModificacionEquipos/eliminarEquipo.php?id=' . $row['id'] . '" class="btn btn-danger btn-sm">Eliminar</a>';
            
            // Botones para sumar puntos
            echo '<form method="post" action="../Scripts/sumarPuntos.php" style="display:inline-block; margin-left: 5px;">';
            echo '<input type="hidden" name="equipo_id" value="' . $row['id'] . '">';
            echo '<input type="hidden" name="puntos" value="3">';
            echo '<button type="submit" class="btn btn-success btn-sm">+3</button>';
            echo '</form>';
            
            echo '<form method="post" action="../Scripts/sumarPuntos.php" style="display:inline-block; margin-left: 5px;">';
            echo '<input type="hidden" name="equipo_id" value="' . $row['id'] . '">';
            echo '<input type="hidden" name="puntos" value="1">';
            echo '<button type="submit" class="btn btn-warning btn-sm">+1</button>';
            echo '</form>';

            echo '</div>';
            echo '</li>';
        }
    } else {
        echo '<p>No se encontraron equipos.</p>';
    }
    ?>
</ul>



        <!-- Botón para agregar un nuevo usuario -->
        <a href="ModificacionEquipos/AgregarEquipo.php" class="btn btn-success mt-3">Agregar Equipo</a>

        <!-- Botón para volver al inicio -->
        <button onclick="location.href='adminIndex.php'" class="btn btn-secondary mt-3">Volver al Inicio</button>
    </div>

    <?php
    // Cerrar la conexión a la base de datos
    $conn->close();
    ?>
</body>
</html>
