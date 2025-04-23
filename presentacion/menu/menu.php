<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
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

<div style="margin: 5px">
    <h1>Menu Principal</h1>
    <p>En este menu podra encontrar todas las funcionalidades que usted puede realizar dentro del sistema</p>
</div>



<div class="contenedor-tarjetas">
    <div class="tarjeta-opcion">
        <a href="/usuario">Gestionar Usuarios</a>
    </div>
    <div class="tarjeta-opcion">
        <a href="/cargo">Gestionar Cargos</a>
    </div>
    <div class="tarjeta-opcion">
        <a href="/tipoEvento">Gestionar Tipos de Eventos</a>
    </div>
    <div class="tarjeta-opcion">
        <a href="/ministerio">Gestionar Ministerio</a>
    </div>
    <div class="tarjeta-opcion">
        <a href="/usuario/editarMiInformacion">Editar Mi Perfil</a>
    </div>
    <div class="tarjeta-opcion">
        <a href="#">Item 4 de la Lista 1</a>
    </div>
    <div class="tarjeta-opcion">
        <a href="#">Item 5 de la Lista 1</a>
    </div>
</div>
</body>
</html>