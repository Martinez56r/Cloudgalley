<?php
// MODELOS/Usuario.php
class Usuario {
    public $idusuario;
    public $nombre;
    public $username;
    public $email;
    public $edad;
    public $numero;
    public $password;

    public function __construct($nombre, $username, $password, $edad, $email, $numero, $idusuario=null) {
        $this->idusuario = $idusuario;
        $this->nombre = $nombre;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->edad = $edad;
        $this->numero = $numero;
    }
}
?>
