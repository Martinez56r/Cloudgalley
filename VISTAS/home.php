<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user'])) {
    // Si el usuario no ha iniciado sesión, redirige a la página de inicio de sesión
    header("Location: index.php");
    exit;
}

// Obtener el ID de usuario de la sesión
$idUsuario = $_SESSION['user'];

require_once '../modelos/Usuario.php';
require_once '../dao/DAOfotos.php';
require_once '../MODELOS/Foto.php';

// Asegúrate de que el ID de usuario está establecido
if(isset($_POST['function'])) {
    $function = $_POST['function'];

    switch ($function) {
        case 'Borrar':
            $idFoto = $_POST['id'];
            DAOfotos::borrar($idFoto);
            break;
        default:
            echo 'Función no válida';
    }
}

// Obtener las fotos del usuario
$fotos = DAOfotos::obtenerFotosPorUsuario($idUsuario);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css2/all.min.css">
    <link rel="stylesheet" href="css2/styless.css">
    <link rel="stylesheet" href="css2/menu.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            color: #fff;
        }
        nav ul {
            list-style-type: none;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin-right: 15px;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
        }
        nav ul li form {
            display: inline;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5px;
        }
        .gallery-item {
            flex: 1 1 calc(20% - 3px);
            box-sizing: border-box;
            margin-bottom: 10px;
        }
        .gallery-item img {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 5px;
            transition: transform 0.2s;
        }
        .gallery-item img:hover {
            transform: scale(1.05);
        }
        .video-detailss {
            text-align: center;
            margin: 5px 0;
        }
        .video-detailss h6 {
            margin: 0;
            font-size: 16px;
            color: #333;
        }
        .btn-container {
            text-align: center;
            margin-top: 5px;
        }
        .btn-container button {
        padding: 5px 10px; /* Padding para espaciado interno */
        margin: 2px; /* Margen exterior */
        border: none; /* Sin borde */
        background-color: #007bff; /* Color de fondo */
        color: white; /* Color del texto */
        cursor: pointer; /* Cursor al pasar sobre el botón */
        border-radius: 3px; /* Bordes redondeados */
        transition: background-color 0.2s; /* Transición suave del color de fondo */
        text-decoration: none; /* Sin subrayado en los enlaces */
        display: inline-block; /* Mostrar en línea */
        width: 100px; /* Ancho fijo */
        text-align: center; /* Alineación del texto centrada */
    }
    .btn-container a{
        padding: 3.8px 5px; /* Padding para espaciado interno */
        margin: 2px; /* Margen exterior */
        border: none; /* Sin borde */
        background-color: #007bff; /* Color de fondo */
        color: white; /* Color del texto */
        cursor: pointer; /* Cursor al pasar sobre el botón */
        border-radius: 3px; /* Bordes redondeados */
        transition: background-color 0.2s; /* Transición suave del color de fondo */
        text-decoration: none; /* Sin subrayado en los enlaces */
        display: inline-block; /* Mostrar en línea */
        width: 100px; /* Ancho fijo */
        text-align: center; /* Alineación del texto centrada */
    }

    .btn-container button:hover,
    .btn-container a:hover {
        background-color: #0056b3; /* Cambio de color al pasar el cursor */
    }

    .btn-container form {
        display: inline; /* Mostrar el formulario en línea */
    }
    </style>
    <title>INTERFAZ MENU</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="">Cloud Gallery</a></li>
                <li><a href="upload.php">Subir Fotos</a></li>

            </ul>
            <ul>
                <li>
                    <form action="">
                        <input type="text" placeholder="Buscar">
                    </form>
                </li>
                <li>
                    <a href="../dao/Logout.php"><img src="imgs/usuario.png" alt="Imagen Usuario"></a>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="container">
            <div class="gallery">
<?php
// Verificar si hay fotos
if (!empty($fotos)) {
    foreach ($fotos as $foto) {
        echo '<div class="gallery-item">';
        echo '<div class="video-detailss">';
        echo '</div>';
        echo '<img src="' . $foto->getRuta() . '" alt="Imagen del Usuario">'; // Usando el método getRuta() del objeto Foto
        echo '<div class="btn-container">';
        echo '<form action="" method="post" style="display:inline;">';
        echo '<input type="hidden" name="id" value="' . $foto->getId() . '">'; // Usando el método getId() del objeto Foto
        echo '<button type="submit" name="function" value="Borrar">Borrar</button>';
        echo '</form>';
        echo '<a href="' . $foto->getRuta() . '" download="' . basename($foto->getRuta()) . '">Descargar</a>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<p>No hay fotos disponibles para este usuario.</p>';
}
?>
            </div>
        </div>
    </main>
</body>
</html>