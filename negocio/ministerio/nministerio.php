<?php

namespace negocio\ministerio;

use Cassandra\Date;
use datos\ministerio\DMinisterio;
use Exception;
require_once("../../proyectoiglesia/datos/ministerio/dministerio.php");
require_once("../../proyectoiglesia/negocio/ministerio/ministerio.php");

class NMinisterio
{

    private DMinisterio $dministerio;
    private Ministerio $ministerio;

    public function __construct(){
        $this->dministerio = new DMinisterio();


    }

    public function getAll(){
        try {
            return $this->dministerio->getAll();
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
    public function guardarNuevoMinisterio(array $datosMinisterio){
        $this->ministerio = new Ministerio(
            $datosMinisterio[0],
            $datosMinisterio[1],
            $datosMinisterio[2],
            $datosMinisterio[3],
            $datosMinisterio[4],
            $datosMinisterio[5],
        );

//        $_SESSION['msgMinisterio'] = $datosMinisterio;
        try{
            $validacion = $this->ministerio->validateMinisterio();
            if($validacion){
                $this->ministerio->verifyNullAtLiderId();
//                $_SESSION['msgMinisterio'] = $this->ministerio->getMinisterioAsArray();
                $ministerio = $this->ministerio->getMinisterioAsArray();
                $result = $this->dministerio->guardarNuevoMinisterio($ministerio);
                $_SESSION['msgMinisterio'] = $ministerio;
                return $result;
            }else{
                return throw new Exception("");
            }
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function eliminar($id){
        try {
            $result =  $this->dministerio->eliminar($id);
            if($result){
                return $result;
            }else{
                throw new \Exception(" Result es false");
            }
        }catch (\Exception $e){
            return  $e->getMessage();
        }
    }

    public function ver($id){
        try{
            $result = $this->dministerio->getById($id);
            return $result;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }
    public function verMinisterioInfo($id)
    {
        try{
            $result = $this->dministerio->getById($id);
            return $result['MinisterioInfo'];
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function actualizarMinisterio(array $datosMinisterio){
        $this->ministerio = new Ministerio(
            $datosMinisterio[0],
            $datosMinisterio[1],
            $datosMinisterio[2],
            $datosMinisterio[3],
            $datosMinisterio[4],
            $datosMinisterio[5],
            $datosMinisterio[6],
        );

        $result = [];
        try{
            $validacion = $this->ministerio->validateMinisterio();
            if($validacion){
                $this->ministerio->verifyNullAtLiderId();
                $result = $this->dministerio->actualizarMinisterio($this->ministerio->getMinisterioAsArray());
                return $result;
            }else{
                return throw new Exception("");
            }
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

}