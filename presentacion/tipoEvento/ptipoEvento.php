<?php

namespace presentacion\tipoEvento;

use negocio\tipoEvento\NTipoEvento;
require_once("../../proyectoiglesia/negocio/tipoEvento/ntipoevento.php");


class PTipoEvento
{
    private $ntipoEvento;
    public function __construct()
    {
        session_start();
        $this->ntipoEvento = new NTipoEvento();
    }



    public function table($datos, $error= null){
        $table = '
<div class="grid-container-custom">
<div class="grid-item">
   '. $this->formularioNuevoTipoEvento().'
</div>

<div class="grid-item">
<table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Frecuencia</th>
                <th>Descripción</th>
                <th>Operaciones</th>
            </tr>
        </thead>
        <tbody>
    ';
        foreach ($datos as $dato) {
            $table .= '
            <tr>
                <td>' . ($dato['id']) . '</td>
                <td>' . ($dato['nombre']) . '</td>
                <td>' . ($dato['frecuencia']) . '</td>
                <td>' . ($dato['descripcion']) . '</td>
                <td>
                <form action="/tipoEvento/editar" method="POST">
                    <input type="hidden" name="id" value="'.$dato['id'].'">
                    <input type="hidden" name="nombre" value="'.$dato['nombre'].'">
                    <input type="hidden" name="frecuencia" value="'.$dato['frecuencia'].'">
                    <input type="hidden" name="descripcion" value="'.$dato['descripcion'].'">
                    <button class="button button-primary">Editar</button>
                </form>
                <form action="/tipoEvento/eliminar" method="POST">
                    <input type="hidden" name="id" value="'.$dato['id'].'">
                    <button class="button button-danger">Eliminar</button>
                </form>
            </tr>
        ';
        }

        $table .= '
        </tbody>
    </table>
</div>

</div>
    ';
        return $table;
    }

    public function renderTable($errors = null){
        $datos = $this->ntipoEvento->getAll();
        include('../../proyectoiglesia/presentacion/tipoEvento/index.php');
        echo $this->table($datos, $errors);
    }

    public function formularioNuevoTipoEvento() {
        $formulario = '
    <div class="">
        <h2>Agregar Nuevo Tipo de Evento</h2>
        <form action="#" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="frecuencia">Frecuencia:</label>
                <input type="text" class="form-control" id="frecuencia" name="frecuencia" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            <button type="submit" class="button-primary">Guardar Tipo Evento</button>
        </form>
    </div>
    ';
        return $formulario;
    }
    public function agregarTipoEvento($nombre, $frecuencia, $descripcion){
        $data = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre'        => $nombre,
                'frecuencia'    => $frecuencia,
                'descripcion'   => $descripcion,
            ];
        }
        try {
            $this->ntipoEvento->agregarTipoEvento($data);
            header('location: /tipoEvento');
        }catch (\Exception $e){
            return "Error: ".$e->getMessage();
        }
    }

    public function eliminarTipoEvento($id){
        try {
            $result = $this->ntipoEvento->eliminarTipoEvento($id);
            if($result){
                header("Location: /tipoEvento");
            }else{
                include('../../proyectoiglesia/presentacion/tipoEvento/index.php');
                $error = "No se pudo eliminar el Tipo de Evento";
                $this->renderTable($error);
            }
        }catch (\Exception $e){
            return "Error: " . $e->getMessage();
        }
    }

    public function renderEditarForm(array $dataTipoEvento){
        $data = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id'            => $dataTipoEvento[0],
                'nombre'        => $dataTipoEvento[1],
                'frecuencia'    => $dataTipoEvento[2],
                'descripcion'   => $dataTipoEvento[3],
            ];
        }
        include_once('../../proyectoiglesia/presentacion/tipoEvento/index.php');
        echo $this->editarForm($data);
    }
    public function editarForm($data){
        $editarForm = '
    <div id="grid-container-custom" >
        <div class="grid-item">
            <h2>Editar Tipo de Evento:</h2> <h2 style="color: darkslateblue">'.$data['nombre'].'</h2>  
            <form  action="/tipoEvento/editar/actualizar" method="POST">
                <input type="hidden" value="'.$data['id'].'" name="id">
                
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" class="form-control" value="'.$data['nombre'].'" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="frecuencia">Frecuencia:</label>
                    <input class="form-control" id="frecuencia" value="' . $data['descripcion']. '" name="frecuencia" required>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <input class="form-control" id="descripcion" value="' . $data['descripcion']. '" name="descripcion" required>
                </div>
                <button type="submit" class="button-primary">Guardar Cambios</button>
                <a type="button" href="/tipoEvento" style="text-decoration: none" class="button-danger">Cancelar</a>
            </form>
        </div>
    </div>
        ';
        return $editarForm;
    }

    public function actualizarTipoEvento(array $dataTipoEvento){
        $data = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id'            => $dataTipoEvento[0],
                'nombre'        => $dataTipoEvento[1],
                'frecuencia'    => $dataTipoEvento[2],
                'descripcion'   => $dataTipoEvento[3],
            ];
        }
        try {
            $result = $this->ntipoEvento->actualizarTipoEvento($data);
            header('location: /tipoEvento');
        }catch (\Exception $e){
            return "PTipoEvento: " .$e->getMessage();
        }
    }

}