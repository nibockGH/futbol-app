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

// Obtener todas las publicaciones
$sql = "SELECT posts.*, users.name FROM posts JOIN users ON posts.user_id = users.id ORDER BY created_at DESC";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Rival y Crear Equipos</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<header class="bg-gray-50 w-full text-center">
    <h1 class="text-2xl font-bold bg-gray-50 mb-4">PartidoYa</h1>
</header>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-2xl">
        <h2 class="text-3xl font-bold mb-6 text-center">Buscar Rival y Crear Equipos</h2>

        <?php if (isset($message)): ?>
            <p class="text-green-500 mb-4"><?php echo $message; ?></p>
        <?php endif; ?>

        <form action="buscarrival.php" method="POST" class="mb-6">
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-semibold mb-2">Título</label>
                <input type="text" name="title" id="title" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-semibold mb-2">Descripción</label>
                <textarea name="description" id="description" rows="4" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required></textarea>
            </div>
            <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">Crear Publicación</button>
        </form>

        <h3 class="text-2xl font-bold mb-4">Publicaciones Recientes</h3>
        <div class="space-y-4">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="p-4 bg-gray-50 rounded-lg shadow">
                        <h4 class="text-xl font-bold"><?php echo htmlspecialchars($row['title']); ?></h4>
                        <p class="text-gray-700"><?php echo htmlspecialchars($row['description']); ?></p>
                        <p class="text-sm text-gray-500 mt-2">Publicado por <?php echo htmlspecialchars($row['name']); ?> el <?php echo htmlspecialchars($row['created_at']); ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-gray-600">No hay publicaciones aún.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
