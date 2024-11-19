<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css2/all.min.css">
    <link rel="stylesheet" href="css2/menu.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            color: #fff;
            padding: 10px 0;
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
        main {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
        }
        main form {
            display: flex;
            flex-direction: column;
        }
        main form label {
            margin: 10px 0 5px;
        }
        main form input[type="text"],
        main form input[type="file"],
        main form input[type="submit"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        main form input[type="submit"] {
            background-color: #28a745;
            color: white;
            cursor: pointer;
            border: none;
        }
        main form input[type="submit"]:hover {
            background-color: #218838;
        }

        
        

         input.valido {
            border: 1px solid green !important;
        }

        input.novalido {
            border: 1px solid red !important;
        }
    </style>
    <title>INTERFAZ MENU</title>
</head>
<body>
<?php
require_once '../DAO/conn.php'; 
require_once '../modelos/Usuario.php'; 
require_once '../DAO/DAOfotos.php';
$error = false;
$form_validado = "";
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user'])) {
    // Si el usuario no ha iniciado sesión, redirige a la página de inicio de sesión
    header("Location: ../index.php");
    exit;
}

// Obtener el ID de usuario de la sesión
$idUsuario = $_SESSION['user'];

// Verificar si el formulario ha sido enviado y hay un archivo
if (isset($_FILES['file']) && isset($_POST['desc'])) {
    $file = $_FILES['file'];
    $desc = trim($_POST['desc']);
    $maxSizeInBytes = 5 * 1024 * 1024; // 5 MB
    $errorMessage = '';
    $errorMessage2 = '';
	$error=false;
    // Validar descripción y archivo en un solo if
    if (strlen($desc) < 1 || strlen($desc) > 10) {
        $errorMessage2 = 'a';
    } elseif ($file['error'] === UPLOAD_ERR_NO_FILE) {
        $errorMessage = 'a';
    } elseif ($file['size'] > $maxSizeInBytes) {
        $errorMessage = 'a';
    }

    // Mostrar errores
    if (!empty($errorMessage) || !empty($errorMessage2)) {
      $form_validado = "validado";
			$error=true;
    } else {
        // Llamar a la función para guardar la foto si no hay errores
        
        $resultado = DAOfotos::guardarFoto($idUsuario, $file, $desc);

        // Verificar el resultado y mostrar un mensaje adecuado
        if ($resultado === null) {
			$form_validado = "validado";
			$error=true;
            echo "<script>console.error('Error SQL');</script>";
        } else {
            if ($resultado === true) {
                echo "Foto subida exitosamente.";
                header("Location: home.php");
                exit;
            } else {
				$form_validado = "validado";
				$error=true;
                echo "<script>console.error('Error al subir la foto.');</script>";
            }
        }
    }
}
?>
    <header>
        <nav>
            <ul>
                <li><a href="home.php">Cloud Gallery</a></li>
                <li><a href="#">Subir Fotos</a></li>
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
        <form action="" method="post" class="<?= $form_validado ?>" enctype="multipart/form-data">
            <label for="file">Subir Imagen</label><br>
            <input type="file" id="file" name="file" accept="image/*" required>
            <div id="errorMessage" style="color:red;"></div>

            <label for="desc">Descripción de la imagen</label>
            <input type="text" id="desc" name="desc" minlength="1" maxlength="10" required>
            <div id="errorMessage2" style="color:red;"></div>
			<?php if ($error): ?>
                    <div class="alert alert-danger" style="color:red;">
                        Alguno de los Datos no cumple con el formato valido
                    </div>
                <?php endif; ?>
            <input type="submit" value="Subir" id="btnSubir">
        </form>
    </main>
    <script src="JS/imagen.js"></script>
</body>
