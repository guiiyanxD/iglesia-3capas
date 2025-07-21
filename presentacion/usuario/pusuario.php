<?php

use negocio\cargo\NCargo;
use negocio\usuario\NUsuario;
require_once("../../proyectoiglesia/negocio/usuario/nusuario.php");

class PUsuario
{
    private NUsuario $nusuario;
    private NCargo $ncargo;

    public function __construct(){
        session_start();
        $this->nusuario = new NUsuario();
        $this->ncargo = new NCargo();
    }
    public function table(array $datos, $error= null){
    /*<div class="grid-item">

        <button onclick=window.location.href="#" class="button-primary" ">Agregar Usuario</button>
    </div>*/
        $table = '
<div style="" class="grid-container-total-pantalla">
    
</div>
<div class="grid-container-total-pantalla">
    
    <div class="grid-item">
    <table >
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombres y Apellidos</th>
                <th>Cargo</th>
                <th>email</th>
                <th>Operaciones</th>
            </tr>
        </thead>
        <tbody>
    ';

            foreach ($datos as $dato) {
                $table .= '
            <tr>
                <td>' . ($dato['id']) . '</td>
                <td>' . ($dato['nombres']) . ' '. ($dato['apellidos']) .'</td>
                <td>' . ($dato['nombre']) . '</td>
                <td>' . ($dato['email']) . '</td>
                <td style="display: block">
                <form action="/usuario/cambiarCargo" method="POST">
                    <input type="hidden" name="id" value="'.$dato['id'].'">
                    <button class=" button button-primary">Cambiar Cargo</button>
                </form>
                
                <form action="/usuario/cambiarCargo" method="POST">
                    <input type="hidden" name="id" value="'.$dato['id'].'">
                    <button class=" button button-secondary">Asignar Ministerio</button>
                </form>
                <form action="/usuario/verHistorial" method="POST">
                    <input type="hidden" name="id" value="'.$dato['id'].'">
                    <button class=" button button-danger">Ver Historial</button>
                </form>
            </tr>
        ';
            }
                /*<form action="#" method="POST">
                    <input type="hidden" name="id" value="'.$dato['id'].'">
                    <button class=" button button-danger">Deshabilitar</button>
                </form>*/


        $table .= '
        </tbody>
    </table>
    </div>
</div>
    ';
        return $table;
    }

    public function renderTable(){
        $datos = $this->nusuario->getAll();
        if(gettype($datos) == 'array'){
            include('../../proyectoiglesia/presentacion/usuario/index.php');
            echo $this->table($datos);
        }else{
            include('../../proyectoiglesia/presentacion/usuario/index.php');
            echo $this->table([],$datos);
        }
    }

    public function cambiarCargoForm($id, $cargos){
        $editarForm = '
       
    <div id="grid-container-custom" >
        <div class="grid-item">
            <h2>Asignar nuevo Cargo </h2>
            <form  action="/usuario/cambiarCargo/actualizar" method="POST">
                <input type="hidden" value="'.$id.'" name="id">
                
                <div class="form-group">
                    <label for="cargo">Nombre del Cargo:</label>
                    <select class="form-control" name="idCargo">
                        <option value="">Seleccione el nuevo cargo </option>
                        ';
        foreach ($cargos as $cargo) {
            $editarForm .= '
                            <option  value="'.$cargo['id'].'">' . ($cargo['nombre']).'</option>';
        }
        $editarForm .='
                    </select>
                </div>
                <button type="submit" class="button-primary">Guardar Cambios</button>
            <button onclick=window.location.href="/usuario" class="button-danger" ">Cancelar</button>
            </form>
        </div>
    </div>
        ';
        return $editarForm;
    }
    public function cambiarCargo($id){
        $cargos = $this->ncargo->getAll();
        include('../../proyectoiglesia/presentacion/usuario/index.php');
        echo $this->cambiarCargoForm($id, $cargos);

    }

    public function cambiarCargoActualizar($id, $idCargo){
        $this->nusuario->cambiarCargo($id, $idCargo);
        header("Location:/usuario");
    }

    public function perfil($datosCompletos){
        $html = '';

// Sección de Datos de Usuario
        $html .= '<div class="seccion">';
        $html .= '<h2>Datos de Usuario:</h2>';
        if (!empty($datosCompletos["datosUsuario"])) {
            foreach ($datosCompletos["datosUsuario"] as $usuario) {
                $html .= '<div class="dato-item"><span class="dato-etiqueta">Nombres:</span> ' . htmlspecialchars($usuario["userNombres"]) . '</div>';
                $html .= '<div class="dato-item"><span class="dato-etiqueta">Apellidos:</span> ' . htmlspecialchars($usuario["userApellidos"]) . '</div>';
                $html .= '<div class="dato-item"><span class="dato-etiqueta">Email:</span> ' . htmlspecialchars($usuario["userEmail"]) . '</div>';
                $html .= '<div class="dato-item"><span class="dato-etiqueta">Cargo:</span> ' . htmlspecialchars($usuario["cargoNombre"]) . '</div>';
            }
        } else {
            $html .= '<p>No hay datos de usuario disponibles.</p>';
        }
        $html .= '</div>';

// Sección de Datos de Ministerio
        $html .= '<div class="seccion">';
        $html .= '<h2>Datos de Liderazgo Ministerial:</h2>';
        if (!empty($datosCompletos["datosMinisterio"])) {
            foreach ($datosCompletos["datosMinisterio"] as $ministerio) {
                $html .= '<div class="dato-item"><span class="dato-etiqueta">Nombre:</span> ' . htmlspecialchars($ministerio["nombre"]) . '</div>';
            }
        } else {
            $html .= '<p>No hay datos de ministerio disponibles.</p>';
        }
        $html .= '</div>';

// Sección de Datos de Miembro
        $html .= '<div class="seccion">';
        $html .= '<h2>Datos de Miembresia Ministerial: </h2>';
        if (!empty($datosCompletos["datosMiembro"])) {
            foreach ($datosCompletos["datosMiembro"] as $miembro) {
                $html .= '<div class="dato-item"><span class="dato-etiqueta">Ministerio:</span> <bold>' . htmlspecialchars($miembro["nombre"]) . '</bold></div>';
                $html .= '<div class="dato-item"><span class="dato-etiqueta">Rol:</span> ' . htmlspecialchars($miembro["idRol"]) . '</div>';
                $html .= '<div class="dato-item"><span class="dato-etiqueta">Incorporación:</span> ' . htmlspecialchars($miembro["fechaIncorpporacion"]) . '</div> <br>';

            }
        } else {
            $html .= '<p>No hay datos de miembros disponibles.</p>';
        }
        $html .= '</div>  <button onclick=window.location.href="/usuario" class="button-danger" >Volver</button>  ';

        $html .= '</body>';

        echo $html;
    }


    /**
     * Obtendra todos los datos del usuario, si es lider/participante de algun(os) minisiterio(s),
     * cursos, eventos, etc
     * @param $id
     * @return void
     */
    public function verHistorial($id){
        $datosUsuario = $this->nusuario->verHistorial($id);
        include('../../proyectoiglesia/presentacion/usuario/index.php');
        echo $this->perfil($datosUsuario);
    }

    public function editarMiInformacionForm($usuarioActual){
        $form = '
        <div class="grid-container-total-pantalla">
            <h2>Editar Información del Usuario</h2> 
        </div>
        <div class="grid-container-total-pantalla">
            <form action="/usuario/editarMiInformacion/actualizar" method="POST">
                <input type="hidden" name="id" value="' . ($usuarioActual[0]["id"]) . '">
    
                <div class="form-group">
                    <label for="nombres">Nombres:</label>
                    <input type="text" class="form-control" id="nombres" name="nombres" value="' . ($usuarioActual[0]["nombres"]) . '" required>
                </div>
    
                <div class="form-group">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" class="form-control" id="apellidos" name="apellidos" value="' . ($usuarioActual[0]["apellidos"]) . '" required>
                </div>
    
                    <input type="hidden" name="email" value="' . ($usuarioActual[0]["email"]) . '" required>
    
                <div class="form-group">
                    <label for="actual_constrasena">Actual Contraseña:</label>
                    <input class="form-control" type="password" id="actualConstrasena" name="actualContrasena" placeholder="Dejar en blanco para no cambiar">
                </div>
    
                <div class="form-group">
                    <label for="nueva_contrasena">Nueva Contraseña:</label>
                    <input class="form-control" type="password" id="nuevaContrasena" name="nuevaContrasena" placeholder="Dejar en blanco para no cambiar">
                </div>
    
                <div class="form-group">
                    <label for="confirmar_contrasena">Confirmar Nueva Contraseña:</label>
                    <input class="form-control" type="password" id="confirmarContrasena" name="confirmarContrasena" placeholder="Confirmar nueva contraseña">
                </div>
    
                <div class="form-group">
                    <button class="button-primary" type="submit">Guardar Cambios</button>
                </div>
            </form>
        </div>';
        return $form;
    }
    public function editarMiInformacion($id){
//        echo "este es el ID: ". $id;
        $result = $this->nusuario->getInfoPropiaById($id);
        include('../../proyectoiglesia/presentacion/usuario/index.php');

        echo $this->editarMiInformacionForm($result);
    }

    public function editarMiInformacionActualizar(array $userData){
        var_dump($userData);
        $result = $this->nusuario->editarMiInformacionActualizar($userData);
        echo($result);
        header('location: /usuario/editarMiInformacion');
    }
}