<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Usuario</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>

    <nav class="navbar">
        <div class="navbar-title" style="color: white">
            Bienvenido, <?=  $_SESSION['signin_user']['email']?>
        </div>
        <div class="logout-button">
            <a href="/logout">Cerrar Sesión</a>
        </div>
    </nav>
    <div style="margin: 20px">
        <button onclick=window.location.href="/menu" class="button-secondary" >Menu</button>

    </div>
    <div style="margin: 20px">
        <h1>Gestionar Usuarios</h1>
    </div>
</body>
</html>