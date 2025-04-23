<?php

namespace negocio\ministerio;

use Cassandra\Date;
use Exception;

class Ministerio
{
    private String      $nombre;
    private String      $mision;
    private String      $vision;
    private String      $fechaCreacion;
    private int       $activo;
    private int|null    $idLider;
    private int|null    $id;
    private array       $participantes;

    public function __construct($nombre, $mision, $vision, $fechaCreacion, $activo, $idLider= null, $id = null){
        $this->nombre =  $nombre;
        $this->mision = $mision;
        $this->vision = $vision;
        $this->fechaCreacion = $fechaCreacion;
        $this->activo = $activo;
        $this->idLider = $idLider;
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

    public function getLider(){
        return $this->idLider;
    }
    public function setLider($idLider){
        $this->idLider = $idLider;
    }
    public function getMision(){
        return $this->mision;
    }

    public function getVision(){
        return $this->vision;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getFechaCreacion(){
        return $this->fechaCreacion;
    }
    public function getActivo(){
        return $this->activo;
    }

    public function getMinisterioAsArray(){
        if($this->getId() == null){
            return [
                "nombre" => $this->getNombre(),
                "mision" => $this->getMision(),
                "vision" => $this->getVision(),
                "fechaCreacion" => $this->getFechaCreacion(),
                "activo" => $this->getActivo(),
                "idLider" => $this->getLider(),
            ];
        }else{
            return [
                "nombre" => $this->getNombre(),
                "mision" => $this->getMision(),
                "vision" => $this->getVision(),
                "fechaCreacion" => $this->getFechaCreacion(),
                "activo" => $this->getActivo(),
                "idLider" => $this->getLider(),
                "id" => $this->getId(),
            ];
        }

    }

    public function validateMinisterio(){
        if(strlen($this->getMision()) >15){
            if (strlen($this->getVision()) >15){
                if (strlen($this->getNombre()) > 5){
                    return true;
                }else{
                    return throw new Exception("Nombre debe contener mas de 5 caracteres");
                }
            }else{
                return throw new Exception("La Vision debe contener mas de 15 caracteres");
            }
        }else{
            return throw new Exception("La Mision debe contener mas de 5 caracteres");
        }
    }

    /**
     * Pone en NULL el Lider ID si viene el -1 desde el formulario
     * @return void
     */
    public function verifyNullAtLiderId(){
        if($this->getLider() == -1){
            $this->setLider(null);
        }
    }
}