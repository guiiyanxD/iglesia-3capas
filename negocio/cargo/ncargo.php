<?php

namespace negocio\cargo;

use datos\cargo\DCargo;
require_once("../../proyectoiglesia/datos/cargo/dcargo.php");

class NCargo
{
    private $dcargo;
    public function __construct()
    {
        $this->dcargo = new DCargo();
    }

    public function getAll(){
        try {
            $result = $this->dcargo->getAll();
            return $result;
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
    public function eliminarCargo($id){
        try {
            return $this->dcargo->eliminarCargo($id);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function agregarCargo(array $dataCargo){
        try {
            if(strlen($dataCargo['nombre']) > 5){
                if(strlen($dataCargo['descripcion']) > 10) {
                    return $this->dcargo->agregarCargo($dataCargo);
                }else{
                    return throw new \Exception("la descripcion del cargo debe tener al menos 10 letras");
                }
            }else{
                return throw new \Exception("El nombre del cargo debe tener al menos 5 letras");
            }
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function actualizarCargo(array $dataCargo){
        try {
            $_SESSION['datacargo'] = $dataCargo;
            if(strlen($dataCargo['nombre']) > 5){
                if(strlen($dataCargo['descripcion']) > 10) {
                    $_SESSION['resultEditarCargo'] = "llego el ncargo";
                    return $this->dcargo->actualizarCargo($dataCargo);
                }else{
                    return throw new \Exception("la descripcion del cargo debe tener al menos 10 letras");
                }
            }else{
                return throw new \Exception("El nombre del cargo debe tener al menos 5 letras");
            }
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }


}