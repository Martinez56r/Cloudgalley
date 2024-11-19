<?php
require_once 'conn.php'; 
require_once '../modelos/Usuario.php'; 

class DAOregistro {

    private static function conectar(){
        try {
            return Conexion::conectar(); 
        } catch(Exception $e) {
            die($e->getMessage());
        }
    }

    public static function autenticar($correo, $password) {
        try { 
            $conexion = self::conectar();
            $sentenciaSQL = $conexion->prepare("SELECT * FROM usuarios WHERE tipo_usuario=0 and (email = ? OR username = ?) AND password = ENCODE(DIGEST(?, 'sha224'), 'hex') AND estado = 1");
            $sentenciaSQL->execute([$correo, $correo, $password]);
            $row = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return $row['idusuario'];
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo "<script>console.error('Error SQL: " . $e->getMessage() . "');</script>";
            return null;
        } finally {
            Conexion::desconectar();
        }
    }
    
    public static function autenticar2($correo, $password) {
        try { 
            $conexion = self::conectar();
            $sentenciaSQL = $conexion->prepare("SELECT * FROM usuarios WHERE tipo_usuario=1 and (email = ? OR username = ?) AND password = ENCODE(DIGEST(?, 'sha224'), 'hex') AND estado = 1");
            $sentenciaSQL->execute([$correo, $correo, $password]);
            $row = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                return $row['idusuario'];
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo "<script>console.error('Error SQL: " . $e->getMessage() . "');</script>";
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    public static function agregar(Usuario $usuario) {
        try {
            $sql = "INSERT INTO usuarios (tipo_usuario, nombre, username, password, edad, email, numero) 
            VALUES (0, ?, ?, ENCODE(DIGEST(?, 'sha224'), 'hex'), ?, ?, ?)";
            $conexion = self::conectar();
            $stmt = $conexion->prepare($sql);
            $stmt->execute([
                $usuario->nombre,
                $usuario->username,
                $usuario->password,
                $usuario->edad,
                $usuario->email,
                $usuario->numero,
            ]);
            return true;
         
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        } finally {
            Conexion::desconectar();
        }
    }

    public static function obtenerTodos() {
        try {
            $conexion = self::conectar();
            $lista = array();
            $sentenciaSQL = $conexion->prepare("SELECT idusuario, nombre, username, email, edad, numero FROM usuarios");
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
            foreach($resultado as $fila) {
                $usuario = new Usuario(
                    $fila['nombre'],
                    $fila['username'],
                    '',  
                    $fila['edad'],
                    $fila['email'],
                    $fila['numero'],
                    $fila['idusuario']
                );
                $lista[] = $usuario;
            }
            return $lista;
        } catch(PDOException $e) {
            var_dump($e);
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    public static function eliminar($idusuario) {
        try {
            $conexion = self::conectar();
            $sentenciaSQL = $conexion->prepare("DELETE FROM usuarios WHERE idusuario = ?");
            $sentenciaSQL->execute([$idusuario]);
            return $sentenciaSQL->rowCount() > 0; 
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        } finally {
            Conexion::desconectar();
        }
    }



    public static function suspender($idusuario) {
        try {
            $conexion = self::conectar();
            $sentenciaSQL = $conexion->prepare("UPDATE usuarios SET estado = 0 WHERE idusuario = ?");
            $sentenciaSQL->execute([$idusuario]);
            return $sentenciaSQL->rowCount() > 0; // Return true if a row was updated
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        } finally {
            Conexion::desconectar();
        }
    }
	
	   public static function cerrar() {
       
session_start();

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir a la página de inicio de sesión
header("Location: ../index.php");
exit;


    }
}





?>
