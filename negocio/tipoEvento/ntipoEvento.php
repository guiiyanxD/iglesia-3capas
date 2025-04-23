<?php

namespace negocio\tipoEvento;

use datos\tipoEvento\DTipoEvento;
require_once("../../proyectoiglesia/datos/tipoevento/dtipoevento.php");

class NTipoEvento
{
    private $dtipoEvento;

    public function __construct(){
        $this->dtipoEvento = new DTipoEvento();
    }

    public function getAll(){
        try {
            $result = $this->dtipoEvento->getAll();
            if($result){
                return $result;
            }else{
                throw new \Exception("NTipoEvento: result es false");
            }
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function agregarTipoEvento(array $data){
        //hacer una validacion para la frecuencia
        try {
            if(strlen($data['nombre']) > 5){
                if(strlen($data['descripcion']) > 10) {
                    return $this->dtipoEvento->agregarTipoEvento($data);
                }else{
                    return throw new \Exception("la descripcion del tipo de evento debe tener al menos 10 letras");
                }
            }else{
                return throw new \Exception("El nombre del tipo de evento debe tener al menos 5 letras");
            }
        }catch (\Exception $e){
            return "NtipoEvento: ". $e->getMessage();
        }
    }
    public function eliminarTipoEvento($id){
        try {
            $result =  $this->dtipoEvento->eliminarTipoEvento($id);
                if($result){
                    return $this->dtipoEvento->eliminarTipoEvento($id);
                }else{
                    throw new \Exception(" Result es false");
                }
        }catch (\Exception $e){
            return "NTipoEvento: ". $e->getMessage();
        }
    }

    public function actualizarTipoEvento(array $data): bool|string
    {
        try {
            if(strlen($data['nombre']) > 5){
                if(strlen($data['descripcion']) > 10) {
                    $result = $this->dtipoEvento->actualizarTipoEvento($data);
                    $_SESSION['actualizar'] = "NTipoEvento". $result;
                    return $result;
                }else{
                    return throw new \Exception("la descripcion del cargo debe tener al menos 10 letras");
                }
            }else{
                return throw new \Exception("El nombre del cargo debe tener al menos 5 letras");
            }
        }catch (\Exception $e){
            return "NTipoEvento: ". $e->getMessage();
        }
    }
}