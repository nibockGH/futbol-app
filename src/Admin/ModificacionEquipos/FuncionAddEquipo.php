<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_db";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir y limpiar los datos del formulario
    $nombre = $conn->real_escape_string($_POST['nombre']);
    $email = $conn->real_escape_string($_POST['tipo_cancha']);
    $password = $conn->real_escape_string($_POST['cantidad_jugadores']);

    
        // Insertar el usuario en la base de datos
        $sql = "INSERT INTO users (name, email, password) VALUES ('$nombre', '$email', '$password_encriptado')";

        if ($conn->query($sql) === TRUE) {
            echo "Usuario agregado exitosamente.";
            header("Location: ../usuariosAdmin.php");
            exit();
        } else {
            echo "Error al agregar usuario: " . $conn->error;
        }
    }
}

// Cerrar conexión
$conn->close();
?>
