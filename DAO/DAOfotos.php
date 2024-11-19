<?php
// Importa la clase conexión y el modelo para usarlos
require_once 'conn.php'; 
require_once '../modelos/Usuario.php'; 
require_once '../modelos/Foto.php'; 

class DAOfotos
{
    
  
   
  public static function obtenerFotosPorUsuario($idUsuario) {
        try {
            $conexion = Conexion::conectar();
            
            $sentenciaSQL = $conexion->prepare("SELECT IdFoto, Nombre, Descripcion, Fecha, IdUsuario, IdCarpeta, Ruta FROM foto WHERE IdUsuario = ?");
            $sentenciaSQL->execute([$idUsuario]);
            
            $Fotos = array();

            while ($fetch = $sentenciaSQL->fetch(PDO::FETCH_ASSOC)) {
                // Obtener los datos binarios de la imagen desde la base de datos como recurso
                $imageResource = $fetch['ruta'];

                // Convertir el recurso a una cadena binaria
                if (is_resource($imageResource)) {
                    $imageData = stream_get_contents($imageResource);

                    // Verificar si se obtuvieron los datos correctamente
                    if ($imageData !== false) {
                        // Convertir los datos de la imagen a un formato base64
                        $imageBase64 = base64_encode($imageData);

                        // Crear una URL de imagen válida usando los datos base64
                        $imageUrl = 'data:image/jpeg;base64,' . $imageBase64;

                        // Crear una instancia de la clase Foto con los datos obtenidos
                        $foto = new Foto(
                            $fetch['idfoto'],
                            $fetch['nombre'],
                            $fetch['descripcion'],
                            $fetch['fecha'],
                            $fetch['idusuario'],
                            $fetch['idcarpeta'],
                            $imageUrl
                        );

                        // Agregar la instancia del objeto Foto a la lista
                        $Fotos[] = $foto;
                    } else {
                        // Si no se obtuvieron datos, mostrar un mensaje de error
                        echo "<script>console.error('Error: No se pudieron obtener los datos de la imagen.');</script>";
                    }
                } else {
                    // Si no se obtuvo un recurso válido, mostrar un mensaje de error
                    echo "<script>console.error('Error: Los datos obtenidos no son un recurso válido.');</script>";
                }
            }

            return $Fotos;
        } catch (Exception $e) {
            // Manejar cualquier excepción que ocurra durante la ejecución de la consulta SQL
            echo "<script>console.error('Error SQL: " . $e->getMessage() . "');</script>";
            return null;
        } finally {
            // Asegurarse de desconectar la conexión a la base de datos al finalizar
            Conexion::desconectar($conexion);
        }
    }








public static function guardarFoto($idUsuario, $file, $descripcion) {
    try {
        $conexion = Conexion::conectar();

        // Leer el contenido del archivo
        $imgData = file_get_contents($file['tmp_name']);

        // Preparar la consulta SQL para insertar los datos
        $sql = "INSERT INTO foto (Nombre, Descripcion, IdUsuario, Ruta) VALUES (:nombre, :descripcion, :idUsuario, :ruta)";
        $stmt = $conexion->prepare($sql);

        // Ejecutar la consulta con los valores proporcionados
        $stmt->bindParam(':nombre', $file['name'], PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
        $stmt->bindParam(':ruta', $imgData, PDO::PARAM_LOB);

        $stmt->execute();

        // Verificar si la inserción fue exitosa
        if ($stmt->rowCount() > 0) {
            // Redirigir si la inserción fue exitosa
            
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        echo "<script>console.error('Error: " . $e->getMessage() . "');</script>";
        return null;
    } finally {
        Conexion::desconectar($conexion);
    }
}
public static function borrar($idFoto) {
    try {
        // Obtener la conexión a la base de datos
        $conexion = Conexion::conectar();

        // Preparar la consulta SQL para eliminar la imagen por su ID
        $sql = "DELETE FROM foto WHERE idFoto = ?";
        $stmt = $conexion->prepare($sql);

        // Vincular el parámetro ID a la consulta
        $stmt->bindParam(1, $idFoto, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Redirigir a la página principal después de borrar
        header("Location: home.php");
        exit();
    } catch (Exception $e) {
        // Manejar cualquier excepción que ocurra durante la ejecución de la consulta SQL
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    } finally {
        // Asegurarse de desconectar la conexión a la base de datos al finalizar
        Conexion::desconectar($conexion);
    }
}










}

?>
