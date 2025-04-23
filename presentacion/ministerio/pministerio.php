<?php

use negocio\ministerio\NMinisterio;
use negocio\usuario\NUsuario;

require_once("../../proyectoiglesia/negocio/ministerio/nministerio.php");
require_once("../../proyectoiglesia/negocio/usuario/nusuario.php");

class PMinisterio
{
    private NMinisterio $nministerio;
    private NUsuario $nusuario;
    public function __construct(){
        session_start();
        $this->nministerio = new NMinisterio();
        $this->nusuario = new NUsuario();
    }
    public function table(array $datos, $error= null){
        $table = '
<div style="" class="grid-container-custom">
    
    <div class="grid-item">
    
        <button onclick=window.location.href="/ministerio/crear" class="button-primary" ">Agregar Ministerio</button>
    </div>
</div>
<div class="grid-container-total-pantalla">
    <div class="grid-item">
    
    </div>
    <div class="grid-item">
    <table >
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Lider</th>
                <th>Activo</th>
                <th>Fecha de Creacion</th>
                <th>Operaciones</th>
            </tr>
        </thead>
        <tbody>
    ';

        if(count($datos) > 0 ){
            foreach ($datos as $dato) {
                ($dato['activo'] == 0) ? $dato['activo'] = "Inactivo" : $dato['activo'] = "Activo";
                (empty($dato['idLider'])) ? $dato['idLider'] = "Sin asignar" : $dato['idLider'];
                $table .= '
            <tr>
                <td>' . ($dato['id']) . '</td>
                <td>' . ($dato['nombre']) . '</td>
                <td>' . ($dato['nombres']) . ' '. ($dato['apellidos']) .'</td>
                <td>' . ($dato['activo']) . '</td>
                <td>' . ($dato['fechaCreacion']) . '</td>
                <td style="display: block">
                <form action="/ministerio/ver" method="POST">
                    <input type="hidden" name="id" value="'.$dato['id'].'">
                    <button class=" button button-primary">Ver info</button>
                </form>
                <form action="/ministerio/editar" method="POST">
                    <input type="hidden" name="id" value="'.$dato['id'].'">
                    <button class=" button  button-secondary">Editar</button>
                </form>
                <form action="/ministerio/eliminar" method="POST">
                    <input type="hidden" name="id" value="'.$dato['id'].'">
                    <button class=" button button-danger">Eliminar</button>
                </form>
            </tr>
        ';
            }
        }else{
            $table .= $error;
        }

        $table .= '
        </tbody>
    </table>
    </div>
</div>
    ';
        return $table;
    }
    public function renderTable(){
        $datos = $this->nministerio->getAll();
        if(gettype($datos) == 'array'){
            include('../../proyectoiglesia/presentacion/ministerio/index.php');
            echo $this->table($datos);
        }else{
            include('../../proyectoiglesia/presentacion/ministerio/index.php');
            echo $this->table([],$datos);

        }
    }
    public function formularioNuevoMinisterio($datosUsuario, $error=null): string
    {
//        '.  isset($_SESSION['MsgMinisterioDebug']) .'
        $formulario = '
        <div class="contenedor-tabla♦">
            <div class="grid-item">
                <h2>Nuevo Ministerio</h2>
            </div>
        </div>
        <div class="grid-container">
            <h3>Rellene el formulario</h3>
               <form action="/ministerio/crear/guardar" method="POST">
                    <div class="form-group" >
                        <label for="nombre">Nombre:</label><br>
                        <input class="form-control" type="text" id="nombre" name="nombre" style=" padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
                    </div>
                    <div class="form-group" >
                        <label for="mision">Mision:</label><br>
                        <textarea class="form-control" id="mision" name="mision" rows="2" style=" padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required></textarea>
                    </div>
                    <div class="form-group" >
                        <label for="vision">Vision:</label><br>
                        <textarea  class="form-control"  name="vision" rows="2" style=" padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required></textarea>
                    </div>
                    <div class="form-group"  >
                        <label for="fechaCreacion">Fecha de Creacion:</label><br>
                        <input class="form-control" type="date" id="fechaCreacion" name="fechaCreacion" required>
                    </div>
                    <div class="form-group" >
                        <label for="Estado">Estado:</label><br>
                        <select class="form-control" name="activo" id="" required> 
                            <option value="0">Inactivo</option>
                            <option value="1">Activo</option>
                        </select>
                    </div>
                    
                    <div class="form-group" >
                        <label for="lider_id">Líder del Ministerio:</label><br>
                        <select class="form-control" name="idLider" > 
                            <option selected>Seleccion un usuario para ser lider del ministerio</option>
                            <option value="-1">El ministerio no tiene asignado ningun lider aun</option>
                            ';
                    foreach ($datosUsuario as $dato) {
                        $formulario .= '
                            <option value="'.$dato['id'].'">' . ($dato['nombre']) . ' - '.($dato['nombres']) .' '. ($dato['apellidos']).'</option>
                    ';
                    }
            $formulario .=' </select>
                        <small>Ingrese el ID del asistente que será el líder (opcional).</small>
                    </div>
                    <div>
                        <button type="submit" style="background-color: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer;">Crear Ministerio</button>
                    </div>
               </form>    
        </div>
        ';
        return $formulario;
    }
    public function agregar(){
        $datosUsuario = $this->nusuario->getAll();
        if(gettype($datosUsuario) == 'array'){
            include('../../proyectoiglesia/presentacion/ministerio/index.php');
            echo $this->formularioNuevoMinisterio($datosUsuario);
        }else{
            include('../../proyectoiglesia/presentacion/ministerio/index.php');
            echo $this->formularioNuevoMinisterio([],$datosUsuario);
        }

    }
    public function guardarNuevoMinisterio($nombre, $mision, $vision, $fechaCreacion, $activo, $idLider){

        $arrayData = [$nombre, $mision, $vision, $fechaCreacion, $activo, $idLider];
        $result = $this->nministerio->guardarNuevoMinisterio($arrayData);
        if(gettype($result) == 'array'){
            header('location: /ministerio');
        }else{
            header('location: /ministerio');
        }

    }
    public function eliminar($id){

        $result = $this->nministerio->eliminar($id);
        if($result){
            header("Location: /ministerio");
        }else{
            include('../../proyectoiglesia/presentacion/ministerio/index.php');
            $error = "No se pudo eliminar el Tipo de Evento";
            $this->renderTable($error);
        }

    }
    public function verPage($result){
        $table = '';
        foreach ($result['MinisterioInfo'] as $dato) {
            ($dato['activo'] == 0) ? $dato['activo'] = "Inactivo" : $dato['activo'] = "Activo";
            $table .= '
            <h1 style="text-align: center"><bold>Ministerio:</bold>  ' . ($dato['nombre']) . '</h1>
            <h3>Nombre del Lider:</h3> <p> ' . ($dato['liderName']).'  '. ($dato['liderLastName']). '</p>
            <h3>Mision: </h3><p>' . ($dato['mision']) . '</p>
            <h3>Vision: </h3><p>' . ($dato['vision']) . '</p>
            <h3>Fecha De Creacion: </h3><p>' . ($dato['fechaCreacion']) . '</p>
            <h3>Estado: </h3><p>' . ($dato['activo']) . '</p>
            <h2 style="text-align: center">Miembros del ministerio:</h2>
            <br>
        ';
        }

        foreach ($result['MiembroInfo'] as $index =>$dato) {
            $table .= '
            <p>'. $index + 1 .'. '. ($dato['miembroName']) . ' '. ($dato['miembroLastName']).'</p>
        ';
        }
        return $table;

    }
    public function ver($id){
        $result = $this->nministerio->ver($id);
        include('../../proyectoiglesia/presentacion/ministerio/index.php');
        echo $this->verPage($result);
    }
    public function editarForm($result, $datosUsuario){
        $formulario = '
        <div class="contenedor-tabla♦">
            <div class="grid-item">
            <div style="display: inline-flex">
                <h2 style="color: tomato">Esta editando la informacion del Ministerio:  </h2> <h2>'. $result[0]['nombre'].'</h2>
            </div>
            </div>
        </div>
        <div class="grid-container">
               <form action="/ministerio/editar/actualizar" method="POST">
                    <div class="form-group" >
                        <label for="nombre">Nombre:</label><br>
                        <input class="form-control" type="text" value="'. $result[0]['nombre'].'" name="nombre" style=" padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required>
                    </div>
                    <div class="form-group" >
                        <label for="mision">Mision:</label><br>
                        <input type="text" class="form-control" value="'. $result[0]['mision'].'" name="mision"  style=" padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required></input>
                    </div>
                    <div class="form-group" >
                        <label for="vision">Vision:</label><br>
                        <input type="text" class="form-control" value="'. $result[0]['vision'].'"  name="vision" style=" padding: 8px; border: 1px solid #ccc; border-radius: 4px;" required></input>
                    </div>
                    <div class="form-group"  >
                        <label for="fechaCreacion">Fecha de Creacion: (Mes/Dia/Año)</label><br>
                        <input class="form-control" type="date" value="'. $result[0]['fechaCreacion'].'" name="fechaCreacion" required>
                    </div>
                    <div class="form-group" >
                        <label for="Estado">Estado:</label><br>
                        <select class="form-control" name="activo" id="" required> 
                            <option value="'. $result[0]['activo'].'"> '. $result[0]['activoNombre'].' (Valor actual) </option>
                            <option value="0">Inactivo</option>
                            <option value="1">Activo</option>
                        </select>
                    </div>
                    <input type="hidden" name="id" value="'. $result[0]['id'].'">
                    <div class="form-group" >
                        <label for="lider_id">Líder del Ministerio:</label><br>
                        <select class="form-control" name="idLider" > 
                            <option value="-1">El ministerio no tiene asignado ningun lider aun</option>
                            <option value="'. $result[0]['idLider'].'"selected> '. $result[0]['liderName'].' '. $result[0]['liderLastName'].'(Lider Actual)</option>
                            
                            ';
        foreach ($datosUsuario as $dato) {
            $formulario .= '
                            <option value="'.$dato['id'].'">' . ($dato['nombre']) . ' - '.($dato['nombres']) .' '. ($dato['apellidos']).'</option>
                    ';
        }
        $formulario .=' </select>
                        <small>Puede dejar el ministerio sin lider (opcional).</small>
                    </div>
                    <div>
                        <button type="submit" style="background-color: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer;">Actualizar Ministerio</button>
                    </div>
               </form>    
        </div>
        ';
        return $formulario;
    }
    public function editar($id){
        $datosUsuario = $this->nusuario->getAll();

        $result = $this->nministerio->verMinisterioInfo($id);
        $activoNombre = $result[0]['activo'] == 0 ? 'Inactivo' : 'Activo';
        $result[0]['activoNombre'] = $activoNombre;
        include('../../proyectoiglesia/presentacion/ministerio/index.php');
        echo $this->editarForm($result, $datosUsuario);
    }
    public function actualizar( $nombre, $mision, $vision, $fechaCreacion, $activo, $idLider, $id){
        $arrayData = [ $nombre, $mision, $vision, $fechaCreacion, $activo, $idLider, $id];
        $result = $this->nministerio->actualizarMinisterio($arrayData);
        if(gettype($result) == 'array'){
            header('location: /ministerio');
        }else{
            header('location: /ministerio');
        }
    }

}