<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario ha iniciado sesión y tiene un ID en la sesión
if (!isset($_SESSION['user_id'])) {
    // Si no hay usuario en la sesión, redirigir a la página de inicio de sesión
    header("Location: ../Account/login.php");
    exit();
}

$usuario_id = $_SESSION['user_id']; // Obtener el ID del usuario desde la sesión

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
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $participantes = intval($_POST['participantes']);
    $cancha = intval($_POST['cancha']);

    // Verificar si el usuario ya tiene un equipo
    $sql_verificar = "SELECT id FROM equipos WHERE usuario_id = '$usuario_id'";
    $resultado = $conn->query($sql_verificar);

    if ($resultado->num_rows > 0) {
        // Si el usuario ya tiene un equipo
        $mensaje = "Ya has creado un equipo. No puedes crear más de uno.";
    } else {
        // Si el usuario no tiene equipo, insertarlo en la base de datos
        $sql = "INSERT INTO equipos (nombre, numero_participante, tipo_cancha, usuario_id) 
                VALUES ('$nombre', $participantes, '$cancha', '$usuario_id')";
        
        if ($conn->query($sql) === TRUE) {
            $mensaje = "Equipo guardado exitosamente.";
            header("Location: ../Equipos/CreacionEquipos.php?success=1"); // Redirigir después de guardar con éxito
            exit(); // Detener la ejecución después de la redirección
        } else {
            $mensaje = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}


// Cerrar la conexión
$conn->close();
?>

