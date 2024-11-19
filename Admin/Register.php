<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/Estilos.css">
</head>
<body>

<?php
require_once '../modelos/Usuario.php';
require_once '../dao/DAOregistro.php';
$error = false;
$form_validado = "";
$valor1="";
$valor2="";
$valor3="";
$valor4="";
$valor5="";
$valor6="";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['funcion'])) {
    // Recoger los datos del formulario
    $nombre = $_POST['floatingName'];
    $username = $_POST['floatingUsername'];
    $password = $_POST['floatingPassword'];
    $email = $_POST['floatingEmail'];
    $edad = $_POST['floatingDateOfBirth'];
    $numero = $_POST['floatingPhoneNumber'];

    // Validar los datos del formulario
    $nombre_valido = strlen(trim($nombre)) >= 2 && strlen(trim($nombre)) <= 60;
    $username_valido = strlen(trim($username)) >= 2 && strlen(trim($username)) <= 60;
    $password_valido = strlen(trim($password)) >= 8 && strlen(trim($password)) <= 20;
    $email_valido = filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    $edad_valida = (new DateTime($edad))->diff(new DateTime())->y >= 18;
    $numero_valido = preg_match('/^[0-9]{10}$/', $numero);

    if ($nombre_valido && $username_valido && $password_valido && $email_valido && $edad_valida && $numero_valido) {
        // Crear una instancia del objeto Usuario
        $usuario = new Usuario($nombre, $username, $password, $edad, $email, $numero);
		$form_validado = "";
        // Conectar a la base de datos y llamar a la funcion agregar
        $resultado = DAOregistro::agregar($usuario);
		
        // Verificar el resultado
        if ($resultado) {
            // Redirigir al index.php
            header("Location: index.php");
            exit;
        } else {
			$valor1=nombre;
$valor2=$username;
$valor3=$password;
$valor4=$email;
$valor5=$edad;
$valor6=$numero;
            $error = true;
            echo "<script>alert('Error al registrar el usuario');</script>";
        }
    } else {
		$valor1=$nombre;
$valor2=$username;
$valor3=$password;
$valor4=$email;
$valor5=$edad;
$valor6=$numero;
        $form_validado = "validado";
    }
}
?>



<body class="bg-light">
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card p-4 shadow-lg" style="width: 100%; max-width: 500px;">
        <img src="img/CG.png" alt="Imagen" class="imagen-arriba mx-auto mb-4" style="width: 300px;">
        <form action="" method="post" class="<?= $form_validado ?>">
            <div class="row">
                <div class="mb-3 col-12">
                    <label for="floatingName">Name</label>
                    <input type="text" class="form-control" name="floatingName" id="floatingName" placeholder="Name" required minlength="2" maxlength="60" value="<?php echo $valor1; ?>">
                    <div>El nombre es obligatorio (entre 2 y 60 caracteres)</div>
                </div>

                <div class="mb-3 col-12">
                    <label for="floatingUsername">User name</label>
                    <input type="text" class="form-control" name="floatingUsername" id="floatingUsername" placeholder="User name" required autocomplete="off" minlength="2" maxlength="60" value="<?php echo $valor2; ?>" >
                    <div>El nombre de usuario es obligatorio</div>
                </div>

                <div class="mb-3 col-12">
                    <label for="floatingPassword">Password</label>
                    <input type="password" class="form-control" name="floatingPassword" id="floatingPassword" placeholder="Password" minlength="8" maxlength="20" value="<?php echo $valor3; ?>" required autocomplete="off">
                    <div>La contraseña es obligatoria (entre 8 y 20 caracteres)</div>
                </div>

                <div class="mb-3 col-12">
                    <label for="floatingEmail">Email</label>
                    <input type="email" class="form-control" name="floatingEmail" id="floatingEmail" placeholder="name@example.com" value="<?php echo $valor4; ?>" required>
                    <div>El email es obligatorio y debe tener un formato valido</div>
                </div>

                <div class="mb-3 col-12">
                    <label for="floatingDateOfBirth">Date of birth</label>
                    <input type="date" class="form-control" name="floatingDateOfBirth" id="floatingDateOfBirth" placeholder="Date of birth" value="<?php echo $valor5; ?>">
                    <div class="invalid-feedback">Debe ser mayor de 18 años</div>
                </div>

                <div class="mb-3 col-12">
                    <label for="floatingPhoneNumber">Phone number</label>
                    <input type="tel" class="form-control" name="floatingPhoneNumber" id="floatingPhoneNumber" placeholder="Phone number" pattern="[0-9]{10}" minlength="10" maxlength="10" required value="<?php echo $valor6; ?>">
                    <div>El telefono debe tener 10 digitos</div>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        Alguno de los Datos no cumple con el formato valido
                    </div>
                <?php endif; ?>

                <div class="col-12">
                    <button type="submit" class="btn btn-success w-100" name="funcion" id="btnAceptar" value="Enviar">Register</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="Admin/js/all.min.js"></script>
<script src="JS/validar.js"></script>
</body>
</html>