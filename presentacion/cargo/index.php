<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Cargos</title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>

<nav class="navbar">
    <div class="navbar-title" style="color: white">
        Bienvenido, <?=  $_SESSION['signin_user']['nombres']?>
    </div>
    <div class="logout-button">
        <a href="/logout">Cerrar Sesión</a>
    </div>
</nav>
<div style="margin: 20px">
    <button onclick=window.location.href="/menu" class="button-secondary" >Menu</button>
</div>
<div style="margin: 20px">
    <h1>Gestionar Cargos</h1>
</div>


</body>
</html>