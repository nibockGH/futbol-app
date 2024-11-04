<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_db";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir y limpiar los datos del formulario
$nombre = $conn->real_escape_string($_POST['nombre']);
$tipo_cancha = $conn->real_escape_string($_POST['tipo_cancha']);
$numero_participante = $conn->real_escape_string($_POST['cantidad_jugadores']);

    // Insertar el equipo en la base de datos
    $sql = "INSERT INTO equipos (nombre, tipo_cancha, numero_participante) VALUES ('$nombre', '$tipo_cancha', '$numero_participante')";

    if ($conn->query($sql) === TRUE) {
        echo "Equipo agregado exitosamente.";
        header("Location: ../equiposAdmin.php");
        exit();
    } else {
        echo "Error al agregar el equipo: " . $conn->error;
    }


// Cerrar conexión
$conn->close();
?>
