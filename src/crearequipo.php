<?php
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
$mensaje = ""; // Variable para almacenar el mensaje

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $nombre = $_POST['nombre'];
    $participantes = $_POST['participantes'];
    $cancha = $_POST['cancha'];

    // Verificar si el equipo ya existe
    $sql_verificar = "SELECT id FROM equipos WHERE nombre = '$nombre'";
    $resultado = $conn->query($sql_verificar);

    if ($resultado->num_rows > 0) {
        // Si el equipo ya existe
        $mensaje = "Equipo ya existente";
    } else {
        // Si el equipo no existe, insertarlo en la base de datos
        $sql = "INSERT INTO equipos (nombre, numero_participante, tipo_cancha) VALUES ('$nombre', $participantes, '$cancha')";
        header("Location: micuenta.php");
        
        if ($conn->query($sql) === TRUE) {
            $mensaje = "Equipo guardado exitosamente";
        } else {
            $mensaje = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
// Obtener todos los equipos de la base de datos para mostrarlos
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
    <style>
    body {
            background-color: #989da6; /* color zinc-300 de Tailwind */
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
</head>
<body class="flex bg-zinc-300 flex-col min-h-screen">
<header class="bg-black text-primary-foreground px-4 lg:px-6 h-14 flex items-center">
        <a class="flex items-center justify-center" href="#">
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
            <a href="main.php" class="text-sm text-white font-medium hover:underline underline-offset-4">Inicio</a>
            <a href="#" class="text-sm text-white font-medium hover:underline underline-offset-4">Partidos</a>
            <a href="crearequipo.php" class="text-sm text-white font-medium hover:underline underline-offset-4">Equipos</a>
            <a href="#" class="text-sm text-white font-medium hover:underline underline-offset-4">Contacto</a>
            </div>
            <!-- Dropdown "Mi cuenta" -->
            <div class="dropdown">
                <a href="#" class="text-sm text-white font-medium hover:underline underline-offset-4 dropbtn">Mi cuenta</a>
                <div class="dropdown-content">
                    <a href="#">Configuración</a>
                    <a href="logout.php">Cerrar sesión</a>
                </div>
            </div>
        </nav>
    </header>
    <div class="flex justify-center mt-8 space-x-8">
        <!-- Sección Crear Equipo -->
        <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-6 text-center">Crear Equipo</h1>

            <!-- Mostrar el mensaje si existe -->
            <?php if (!empty($mensaje)): ?>
                <div class="<?php echo ($mensaje == 'Equipo guardado exitosamente') ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700'; ?> px-4 py-3 rounded mb-4">
                    <?php echo $mensaje; ?>
                </div>
            <?php endif; ?>

            <form action="crearequipo.php" method="POST">
                <div class="mb-4">
                    <label for="nombre" class="block text-gray-700 font-bold mb-2">Nombre del Equipo:</label>
                    <input type="text" id="nombre" name="nombre" class="border border-gray-300 rounded-lg w-full p-2" required>
                </div>
                <div class="mb-4">
                    <label for="participantes" class="block text-gray-700 font-bold mb-2">Número de Participantes:</label>
                    <input type="number" id="participantes" name="participantes" class="border border-gray-300 rounded-lg w-full p-2" max="22" required>
                </div>
                <div class="mb-4">
                    <label for="cancha" class="block text-gray-700 font-bold mb-2">Tipo de Cancha:</label>
                    <select id="cancha" name="cancha" class="border border-gray-300 rounded-lg w-full p-2" required>
                        <option value="Fútbol 5">Fútbol 5</option>
                        <option value="Fútbol 7">Fútbol 7</option>
                        <option value="Fútbol 8">Fútbol 8</option>
                        <option value="Fútbol 8">Fútbol 11</option>

                    </select>
                </div>
                <button type="submit" class="bg-green-500 text-white font-bold py-2 px-4 rounded-lg w-full">
                    <a href="micuenta.php">Guardar Equipo</a></button>
            </form>
        </div>

        <!-- Sección Buscar Rivales -->

        <!-- <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-6 text-center">Buscar Rivales</h2>

            <?php if ($result_equipos->num_rows > 0): ?>
                <table class="min-w-full bg-white mb-6">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 bg-gray-200 font-bold uppercase text-gray-700 text-sm">Nombre del Equipo</th>
                            <th class="py-2 px-4 bg-gray-200 font-bold uppercase text-gray-700 text-sm">Participantes</th>
                            <th class="py-2 px-4 bg-gray-200 font-bold uppercase text-gray-700 text-sm">Tipo de Cancha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $result_equipos->fetch_assoc()): ?>
                            <tr>
                                <td class="py-2 px-4 border-b border-gray-200"><?php echo $row['nombre']; ?></td>
                                <td class="py-2 px-4 border-b border-gray-200"><?php echo $row['numero_participante']; ?></td>
                                <td class="py-2 px-4 border-b border-gray-200"><?php echo $row['tipo_cancha']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-gray-700 text-center">No se encontraron equipos.</p>
            <?php endif; ?>
        </div>
    </div> -->
</body>
</html>