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

// Verificar si se ha enviado el formulario para crear equipo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['crear_equipo'])) {
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

// Suponiendo que los datos del usuario están almacenados en la sesión (puedes ajustar según tu sistema de autenticación)
session_start();
$user_id = $_SESSION['user_id'];
$sql_user = "SELECT name, email FROM users WHERE id = $user_id";
$result_users = $conn->query($sql_user);
$users = $result_users->fetch_assoc();

// Generar un código de invitación único
$invitacion_codigo = bin2hex(random_bytes(4)); // Genera un código de invitación único

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
    </style>
</head>
<body class="flex bg-white flex-col min-h-screen">
<header class="bg-black text-primary-foreground px-4 lg:px-6 h-14 flex items-center">
    <a class="flex items-center justify-center" href="main.php">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white size-6">
            <path d="m8 3 4 8 5-5 5 15H2L8 3z"></path>
        </svg>
        <span class="sr-only">Encontrar Partido</span>
    </a>
    <nav class="ml-auto pr-10 mr-10 flex gap-4 sm:gap-6">
        <div class="space-x-3.5">
            <a href="main.php" class="text-sm text-white font-medium hover:underline underline-offset-4">Inicio</a>
            <a href="#" class="text-sm text-white font-medium hover:underline underline-offset-4">Crear Equipo</a>
        </div>
    </nav>
</header>

<div class="w-full max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <h2 class="text-2xl font-bold mb-4">Mi Equipo</h2>
            <div class="rounded-lg border bg-white text-black shadow-sm">
                <div class="flex flex-col space-y-1.5 p-6">
                    <h3 class="whitespace-nowrap text-2xl font-semibold leading-none tracking-tight">Miembros del Equipo</h3>
                    <div class="mt-4">
                        <p>Invita a otros a unirse a tu equipo mediante este código:</p>
                        <div class="flex items-center mt-2">
                            <input type="text" value="<?php echo $invitacion_codigo; ?>" class="border p-2 mr-2" readonly>
                            <button class="bg-blue-500 text-white px-4 py-2 rounded">Copiar Código</button>
                        </div>
                        <!-- Código para invitar a otros mediante un enlace -->
                        <p class="mt-2">O comparte este enlace:</p>
                        <input type="text" value="https://tuaplicacion.com/invitar?codigo=<?php echo $invitacion_codigo; ?>" class="border p-2 w-full" readonly>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Ejemplos de miembros del equipo -->
                        <div class="flex items-center space-x-4">
                            <span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full">
                                <img class="aspect-square h-full w-full" alt="Juana Pérez" src="/placeholder-user.jpg" />
                            </span>
                            <div>
                                <div class="font-medium">Juana Pérez</div>
                                <div class="text-muted-foreground text-sm">Líder de Equipo</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full">
                                <img class="aspect-square h-full w-full" alt="Miguel Sánchez" src="/placeholder-user.jpg" />
                            </span>
                            <div>
                                <div class="font-medium">Miguel Sánchez</div>
                                <div class="text-muted-foreground text-sm">Desarrollador</div>
                            </div>
                        </div>
                        <!-- Fin de ejemplos -->
                    </div>
                </div>
            </div>

            <div class="rounded-lg border bg-white text-black shadow-sm mt-6">
                <div class="flex flex-col space-y-1.5 p-6">
                    <h3 class="whitespace-nowrap text-2xl font-semibold leading-none tracking-tight">Detalles de Contacto</h3>
                </div>
                <div class="p-6">
                    <div class="grid gap-4">
                        <div class="flex items-center space-x-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-muted-foreground">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7 2 2 0 0 1 1.72 2z"></path>
                            </svg>
                            <div>
                                <div class="text-sm font-medium">Teléfono</div>
                                <div class="text-muted-foreground text-sm"><?php echo $usuario['telefono']; ?></div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-muted-foreground">
                                <path d="M3 5h18M8 9h8m-6 4h4m-9 4h14M5 19h14"></path>
                            </svg>
                            <div>
                                <div class="text-sm font-medium">Correo Electrónico</div>
                                <div class="text-muted-foreground text-sm"><?php echo $usuario['email']; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Crear Equipo -->
        <div class="bg-white rounded-lg">
            <h2 class="text-2xl font-bold py-2 px-4 mb-4">Crear Equipo</h2>
            <form action="" method="post" class="rounded-lg border bg-card text-card-foreground shadow-sm p-6 space-y-4">
                <div class="space-y-2">
                    <label for="name" class="text-sm font-medium leading-none">Nombre del Equipo</label>
                    <input id="name" name="nombre" class="flex h-10 w-full rounded-md border px-3 py-2 text-sm" placeholder="Ingrese el nombre del equipo" required>
                </div>
                <div class="space-y-2">
                    <label for="email" class="text-sm font-medium leading-none">Número de Participantes</label>
                    <input id="email" type="number" name="participantes" class="flex h-10 w-full rounded-md border px-3 py-2 text-sm" placeholder="Ingrese el número de participantes" required>
                </div>
                <div class="space-y-2">
                    <label for="phone" class="text-sm font-medium leading-none">Tipo de Cancha</label>
                    <select id="phone" name="cancha" class="flex h-10 w-full rounded-md border px-3 py-2 text-sm">
                        <option value="5">Cancha 5</option>
                        <option value="7">Cancha 7</option>
                        <option value="11">Cancha 11</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="submit" name="crear_equipo" class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Crear Equipo</button>
                </div>
            </form>
            <!-- Mostrar mensaje de éxito o error -->
            <?php if ($mensaje) : ?>
                <div class="mt-4 p-3 bg-blue-100 text-blue-800 rounded"><?php echo $mensaje; ?></div>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
