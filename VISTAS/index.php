<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/Estilos.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js" defer></script>
</head>
<body>

<?php
require_once '../modelos/Usuario.php';
require_once '../dao/DAOregistro.php';



                $error=false;
        $username=$password=$form_validado="";
        if(isset($_POST["txtEmail"]) && isset($_POST["txtPassword"])){
                // Obtener los valores del formulario
                $username = $_POST['txtEmail'];
                $password = $_POST['txtPassword'];

                if(filter_var($username,FILTER_VALIDATE_EMAIL)!==false &&
                strlen(trim($password))>0){
                // Autenticar el usuario
                $resultado = DAOregistro::autenticar($username, $password);
                $resultado2 = DAOregistro::autenticar2($username, $password);

                if ($resultado != null) {
                    session_start();
                    $_SESSION['user'] = $resultado;
                    header("Location: home.php");
                    exit;
                } else {
                    $error=true;
                    
                }
                if ($resultado2 != null) {
                    session_start();
                    $_SESSION['user'] = $resultado2;
                    header("Location: ../Admin/home.php");
                    exit;
                } else {
                    $error=true;
                    
                }




            }else{
            $form_validado="validado";
        }
    }


?>

<main class="d-flex">
        <div class="container my-4 align-self-center">
            <div class="card w-50 mx-auto">
            <img src="img/CG.png" alt="Imagen" class="imagen-arriba"><br>
                
                <div class="card-body">
                    <form action="" method="post" class="<?=$form_validado?>">
                        <div class="row">                       <div class="mb-3">
                            <label for="txtEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" pattern="^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$"
                                 name="txtEmail" id="txtEmail" value="<?=$username?>" required>
                            <div>Ingresa el correo electrónico y que tenga formato válido</div>
                        </div>
                        <div class="mb-3">
                            <label for="txtPassword" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="txtPassword" maxlength="50" 
                                    id="txtPassword" value="<?=$password?>" required>
                                <button class="input-group-text" type="button" id="btnMostrarOcultar">Ver</button>
                            </div>
                            <div>Ingresa la contraseña</div>
                        </div>
                        
                        <?php
                        if($error){
                        ?>
                        <div class="alert alert-danger">
                            Usuario y/o contraseña incorrectos
                        </div>
                        <?php
                        }
                        ?>

                        <div class="button-container">
                            <button id="verificarBtn" type="submit" class="btn btn-outline-success" name="function" value="Verificar">Verificar</button>
                            
                        </div>
                    </form>
                    <div class="button-container">
    <!-- <button id="btnRegistrar" type="submit" class="btn btn-outline-success" name="function" value="Registrar">Registrar</button>

-->
<a href="Register.php">Registrar</a>
                        </div>
                </div>
                
            </div>
            
        </div>
        
    </main>
    
    
<script src="JS/login.js"></script>
<script src="Admin/js/all.min.js"></script>
</body>
</html>
