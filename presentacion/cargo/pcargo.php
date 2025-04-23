<?php

namespace presentacion\cargo;
use negocio\cargo\NCargo;
require_once("../../proyectoiglesia/negocio/cargo/ncargo.php");
class PCargo
{
    private $nombreCargo;
    private $descripcionCargo;
    private $ncargo;

    public function __construct(){
        session_start();
        $this->ncargo = new NCargo();
    }
    public function table($datos, $error= null){
        $table = '
<div class="grid-container-custom">
<div class="grid-item">
    '. $this->formularioNuevoCargo().'
</div>               

<div class="grid-item">
<table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
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
                <td>' . ($dato['descripcion']) . '</td>
                <td>
                <form action="/cargo/editar" method="POST">
                    <input type="hidden" name="idCargo" value="'.$dato['id'].'">
                    <input type="hidden" name="nombreCargo" value="'.$dato['nombre'].'">
                    <input type="hidden" name="descripcionCargo" value="'.$dato['descripcion'].'">
                    <button class="button-primary">Editar</button>
                </form>
                <form action="/cargo/eliminar" method="POST">
                    <input type="hidden" name="idCargo" value="'.$dato['id'].'">
                    <button class="button-danger">Eliminar</button>
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

    public function renderTable($error = null){
        $datos = $this->ncargo->getAll();
        include('../../proyectoiglesia/presentacion/cargo/index.php');
        echo $this->table($datos, $error);
    }
    public function formularioNuevoCargo() {
        $formulario = '
    <div class="">
        <h2>Agregar Nuevo Cargo</h2>
        <form action="#" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre del Cargo:</label>
                <input type="text" class="form-control" id="nombreCargo" name="nombreCargo" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción del Cargo:</label>
                <textarea class="form-control" id="descripcionCargo" name="descripcionCargo" rows="3" required></textarea>
            </div>
            <button type="submit" class="button-primary">Guardar Cargo</button>
        </form>
    </div>
    ';
        return $formulario;
    }

    public function eliminarCargo($id){
        try {
            $result = $this->ncargo->eliminarCargo($id);
            if($result){
                header("Location: /cargo");
            }else{
                include('../../proyectoiglesia/presentacion/cargo/index.php');
                $error = "No se pudo eliminar el Cargo";
                $this->renderTable($error);
            }
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function alertScript($mensaje){
        return $scriptAlerta = '<script>alert('.$mensaje.')</script>';
    }

    public function agregarCargo($nombre, $descripcion){
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->nombreCargo      = $nombre;
            $this->descripcionCargo = $descripcion;
        }
        try {
            $this->ncargo->agregarCargo($this->getDataCargo());
            header('location: /cargo');
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function getDataCargo(){
        return [
            'nombre' => $this->nombreCargo,
            'descripcion' => $this->descripcionCargo,
        ];
    }

    public function renderEditarForm($id, $nombre, $descripcion){
        include_once('../../proyectoiglesia/presentacion/cargo/index.php');
        echo $this->editarForm($id, $nombre, $descripcion);
    }
    public function editarForm($id, $nombre, $descripcion){
        $editarForm = '
    <div id="grid-container-custom" >
        <div class="grid-item">
            <h2>Editar Cargo '.$nombre.'  </h2>
            <form  action="/cargo/editar/actualizar" method="POST">
                <input type="hidden" value="'.$id.'" name="id">
                
                <div class="form-group">
                    <label for="nombre">Nombre del Cargo:</label>
                    <input type="text" id="nombre" class="form-control" value="'.$nombre.'" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción del Cargo:</label>
                    <input class="form-control" id="descripcion" value="' . $descripcion. '" name="descripcion" required>
                </div>
                <button type="submit" class="button-primary">Guardar Cambios</button>
                <a type="button" href="/cargo" style="text-decoration: none" class="button-danger">Cancelar</a>
            </form>
        </div>
    </div>
        ';
        return $editarForm;
    }

    public function actualizarCargo($id, $nombre, $descripcion){
        $data = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id'            => $id,
                'nombre'        => $nombre,
                'descripcion'   => $descripcion,
            ];
        }
        try {
            $result = $this->ncargo->actualizarCargo($data);
            header('location: /cargo');
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }


}