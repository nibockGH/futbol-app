<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
        #usuarioForm {
            max-width: 500px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Gestión de Usuarios</h1>
    
        <h3>Modificar Usuario</h3>
        <form id="usuarioForm" action="FuncionModificarUsuario.php" method="POST">
            <input type="hidden" id="usuario_id" name="usuario_id" value="<?php echo $_GET['id']; ?>" required>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre del Usuario" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Email del Usuario" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password del usuario">
            </div>
            <button type="submit" class="btn btn-primary">Modificar Usuario</button>
        </form>

        <!-- Botón para volver al inicio -->
        <button onclick="location.href='../adminIndex.php'" class="btn btn-secondary">Volver al Inicio</button>
    </div>
    <script src="index.js"></script>
</body>
</html>
