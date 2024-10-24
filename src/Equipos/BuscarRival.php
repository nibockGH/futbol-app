<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: loginn.php");
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

// Manejar el envío del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];

    // Insertar nueva publicación en la base de datos
    $sql = "INSERT INTO posts (user_id, title, description) VALUES ('$user_id', '$title', '$description')";
    
    if ($conn->query($sql) === TRUE) {
        $message = "Publicación creada exitosamente";
    } else {
        $message = "Error: " . $conn->error;
    }
}

// Obtener todos los equipos de la base de datos para mostrarlos (si es necesario)
$sql_equipos = "SELECT nombre, numero_participante, tipo_cancha FROM equipos";
$result_equipos = $conn->query($sql_equipos);

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Equipo y Buscar Rivales</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<style>
        body {
            background-color: white; /* color zinc-300 de Tailwind */
        }
        header {
            background-color: #000000; /* color negro */
        }
        .bg-black {
            background-color: #000000; /* color negro */
        }
        .text-primary-foreground {
            color: #FFFFFF; /* texto blanco */
        }
        #boton {
            overflow: hidden; /* Evita que el texto agrandado se desborde del botón */
            transition: background-color 0.3s ease;
        }
        #boton:hover {
            background-color: #121111;
        }
        /* Estilos para el menú desplegable */
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #a1a1a1;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            opacity: 0;
            transform: scale(0.95); /* Escalado inicial */
            transition: transform 0.3s ease, opacity 0.3s ease; /* Transiciones */
        }
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-size: 14px;
            transition: transform 0.3s ease; /* Transición para agrandar texto */
        }
        .dropdown-content a:hover {
            background-color: #f1f1f1;
            transform: scale(1.05); /* Agranda el texto al pasar el cursor */
        }
        .dropdown:hover .dropdown-content {
            display: block;
            opacity: 1;
            transform: scale(1); /* Vuelve al tamaño original */
        }
        .dropdown:hover .dropbtn {
            background-color: #121111;
            text-decoration: underline;
        }
        /* Estilos para la sección de contacto */
        .contact-section {
            margin-top: 100px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .contact-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }
        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        .contact-form button {
            background-color: #000000;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .contact-form button:hover {
            background-color: #333;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> <!-- Tailwind CSS CDN -->
</head>
<body class="flex bg-zinc-300 flex-col min-h-screen">
    <header class="bg-black text-primary-foreground px-4 lg:px-6 h-14 flex items-center">
        <a class="flex items-center justify-center" href="../main.php">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="text-white size-6"
            >
                <path d="m8 3 4 8 5-5 5 15H2L8 3z"></path>
            </svg>
            <span class="sr-only">Encontrar Partido</span>
        </a>
        <nav class="ml-auto pr-10 mr-10 flex gap-4 sm:gap-6">
            <div class="space-x-3.5">
            <a href="../main.php" class="text-sm text-white font-medium hover:underline underline-offset-4">Inicio</a>
            <a href="BuscarRival.php" class="text-sm text-white font-medium hover:underline underline-offset-4">Partidos</a>
            <a href="CreacionEquipos.php" class="text-sm text-white font-medium hover:underline underline-offset-4">Equipos</a>
            </div>  
            <!-- Dropdown "Mi cuenta" -->
            <div class="dropdown">
                <a href="../Account/micuenta.php" class="text-sm text-white font-medium hover:underline underline-offset-4 dropbtn">Mi cuenta</a>
                <div class="dropdown-content">
                    <a href="../Account/micuenta.php">Configuración</a>
                    <a href="../Scripts/CerrarSesion.php">Cerrar sesión</a>
                </div>
            </div>
        </nav>
    </header>
    <main>
                <div class=" justify-center items-center m-6 bg-white px-4 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6 mt-2 text-center">Equipos Disponibles</h2>

    <?php if ($result_equipos->num_rows > 0): ?>
        <table class="min-w-full bg-white mb-6">
    <thead>
        <tr>
            <th class="py-2 bg-gray-200 font-bold uppercase text-gray-700 text-sm text-left">Participantes</th>
            <th class="py-2 bg-gray-200 font-bold uppercase text-gray-700 text-sm text-left">Nombre del Equipo</th>
            <th class="py-2 bg-gray-200 font-bold uppercase text-gray-700 text-sm text-left">Tipo de Cancha</th>
            <th class="py-2 bg-gray-200 font-bold uppercase text-gray-700 text-sm text-center">Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $result_equipos->fetch_assoc()): ?>
            <tr>
                <td class="py-2 pl-6 border-b border-gray-200"><?php echo $row['nombre']; ?></td>
                <td class="py-2 pl-6 border-b border-gray-200"><?php echo $row['numero_participante']; ?></td>
                <td class="py-2 pl-6 border-b border-gray-200"><?php echo $row['tipo_cancha']; ?></td>
                <td class="py-2 border-b border-gray-200 text-center">
                    <button class="py-2 px-4 bg-green-400 text-white font-bold uppercase text-sm">DESAFIAR</button>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

    <?php else: ?>
        <p class="text-gray-700 text-center">No se encontraron equipos.</p>
    <?php endif; ?>
</div>
</main>
</body>
</html>
