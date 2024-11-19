<?php
class Foto {
    public $idFoto;
    public $nombre;
    public $descripcion;
    public $fecha;
    public $idUsuario;
    public $idCarpeta;
    public $ruta;

    public function __construct($idFoto, $nombre, $descripcion, $fecha, $idUsuario, $idCarpeta, $ruta) {
        $this->idFoto = $idFoto;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->fecha = $fecha;
        $this->idUsuario = $idUsuario;
        $this->idCarpeta = $idCarpeta;
        $this->ruta = $ruta;
    }

    public function getId() {
        return $this->idFoto;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function getIdCarpeta() {
        return $this->idCarpeta;
    }

    public function getRuta() {
        return $this->ruta;
    }
}

?>