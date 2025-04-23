<?php


use negocio\login\NLogin;
use presentacion\cargo\PCargo;
use presentacion\login\PLogin;
use presentacion\login\PRegister;
use negocio\home\Nhome;
use presentacion\menu\PMenu;
use presentacion\tipoEvento\PTipoEvento;


require_once('../negocio/home/nhome.php');
require_once('../negocio/login/nlogin.php');
require_once('../presentacion/login/plogin.php');
require_once('../presentacion/login/pregister.php');
require_once('../presentacion/menu/pmenu.php');
require_once('../presentacion/cargo/pcargo.php');
require_once('../presentacion/tipoEvento/ptipoEvento.php');
require_once('../presentacion/ministerio/pministerio.php');
require_once('../presentacion/usuario/pusuario.php');


if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_SERVER['REQUEST_URI'] == '/') {
    $home = new NHome();
    $home->index();
    return;
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_SERVER['REQUEST_URI'] === '/login') {
    $plogin = new PLogin();
    $plogin->renderLoginForm();
    return;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] === '/login') {
    $plogin = new PLogin();
    $plogin->login($_POST['email'], $_POST['password']);
    return;
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_SERVER['REQUEST_URI'] === '/logout') {
    $plogin = new PLogin();
    $plogin->logout();
    return;
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_SERVER['REQUEST_URI'] === '/register') {
    $pregister = new PRegister();
    $pregister->renderRegisterForm();
    return;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] === '/register') {
    $pregister = new PRegister();
    $pregister->register(
        $_POST['nombres'], $_POST['apellidos'], $_POST['email'],
        $_POST['password'], $_POST['passwordConfirmation']
    );
    return;
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_SERVER['REQUEST_URI'] === '/menu') {
    $pmenu = new PMenu();
    $pmenu->index();
    return;
}
///////////GESTIONAR CARGO//////////////////////////////////
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_SERVER['REQUEST_URI'] === '/cargo') {
    $pcargo = new PCargo();
    $pcargo->renderTable();
    return;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] === '/cargo/eliminar') {
    $pcargo = new PCargo();
    $pcargo->eliminarCargo($_POST['idCargo']);
    return;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] === '/cargo') {
    $pcargo = new PCargo();
    $pcargo->agregarCargo($_POST['nombreCargo'],$_POST['descripcionCargo']);
    return;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] === '/cargo/editar') {
    $pcargo = new PCargo();
    $pcargo->renderEditarForm($_POST['idCargo'],$_POST['nombreCargo'],$_POST['descripcionCargo']);
    return;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] === '/cargo/editar/actualizar') {
    $pcargo = new PCargo();
    $pcargo->actualizarCargo($_POST['id'],$_POST['nombre'],$_POST['descripcion']);
    return;
}

////////////////////////////////GESTIONAR TIPO EVENTO///////////////////////////////////////////////////

if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_SERVER['REQUEST_URI'] === '/tipoEvento') {
    $ptipoevento = new PTipoEvento();
    $ptipoevento->renderTable();
    return;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] === '/tipoEvento') {
    $ptipoevento = new PTipoEvento();
    $ptipoevento->agregarTipoEvento($_POST['nombre'],$_POST['frecuencia'],$_POST['descripcion']);
    return;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] === '/tipoEvento/eliminar') {
    $ptipoevento = new PTipoEvento();
    $ptipoevento->eliminarTipoEvento($_POST['id']);
    return;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] === '/tipoEvento/editar') {
    $ptipoevento = new PTipoEvento();
    $ptipoevento->renderEditarForm([$_POST['id'],$_POST['nombre'], $_POST['frecuencia'],$_POST['descripcion']]);
    return;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] === '/tipoEvento/editar/actualizar') {
    $ptipoevento = new PTipoEvento();
    $ptipoevento->actualizarTipoEvento([$_POST['id'],$_POST['nombre'], $_POST['frecuencia'],$_POST['descripcion']]);
    return;
}
//////////////////////////////GESTIONAR MINISTERIO //////////////////////////////////////////////

if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_SERVER['REQUEST_URI'] === '/ministerio') {
    $pministerio = new PMinisterio();
    $pministerio->renderTable();
    return;
}
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_SERVER['REQUEST_URI'] === '/ministerio/crear') {
    $pministerio = new PMinisterio();
    $pministerio->agregar();
    return;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] === '/ministerio/crear/guardar') {
    $pministerio = new PMinisterio();
    $pministerio->guardarNuevoMinisterio($_POST['nombre'],$_POST['mision'],$_POST['vision'], $_POST['fechaCreacion'], $_POST['activo'], $_POST['idLider']);
    return;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] === '/ministerio/eliminar') {
    $pministerio = new PMinisterio();
    $pministerio->eliminar($_POST['id']);
    return;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] === '/ministerio/ver') {
    $pministerio = new PMinisterio();
    $pministerio->ver($_POST['id']);
    return;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] === '/ministerio/editar') {
    $pministerio = new PMinisterio();
    $pministerio->editar($_POST['id']);
    return;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] === '/ministerio/editar/actualizar') {
    $pministerio = new PMinisterio();
    $pministerio->actualizar($_POST['nombre'],$_POST['mision'],$_POST['vision'], $_POST['fechaCreacion'], $_POST['activo'], $_POST['idLider'],$_POST['id']);
    return;
}
///////////////////////GESTIONAR USUARIO //////////////////////////////////////////////////

if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_SERVER['REQUEST_URI'] === '/usuario') {
    $pusuario = new PUsuario();
    $pusuario->renderTable();
    return;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] === '/usuario/cambiarCargo') {
    $pusuario = new PUsuario();
    $pusuario->cambiarCargo($_POST['id']);
    return;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] === '/usuario/cambiarCargo/actualizar') {
    $pusuario = new PUsuario();
    $pusuario->cambiarCargoActualizar($_POST['id'], $_POST['idCargo']);
    return;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] === '/usuario/verHistorial') {
    $pusuario = new PUsuario();
    $pusuario->verHistorial($_POST['id']);
    return;
}
if ($_SERVER['REQUEST_METHOD'] == 'GET' && $_SERVER['REQUEST_URI'] === '/usuario/editarMiInformacion') {
    $pusuario = new PUsuario();
    $pusuario->editarMiInformacion($_SESSION['signin_user']['id']);
    return;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] === '/usuario/editarMiInformacion/actualizar') {
    $pusuario = new PUsuario();
    $pusuario->editarMiInformacionActualizar([
        $_POST['id'], $_POST['nombres'],$_POST['apellidos'], $_POST['email'],
        $_POST['actualContrasena'],$_POST['nuevaContrasena'],$_POST['confirmarContrasena'],
    ]);
    return;
}