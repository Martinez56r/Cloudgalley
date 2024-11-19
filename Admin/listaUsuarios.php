<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="../VISTAS/css2/menu.css">
    <title>Cloud Gallery - User Catalog</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="home.php">Cloud Gallery</a></li>
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
        <div class="container pt-4">
            <?php
            require_once("../DAO/DAOregistro.php");
            session_start();

            if (isset($_POST["id"]) && is_numeric($_POST["id"])) {
                $dao = new DAOregistro();
                
                if ($dao->eliminar($_POST["id"])) {
                    $_SESSION["msg"] = "alert-success--Usuario eliminado exitosamente";
                } else {
                    $_SESSION["msg"] = "alert-danger--No se ha podido eliminar al usuario seleccionado.";
                }
                header("Location: listaUsuarios.php");
                exit();
            }

            if (isset($_POST["suspenderId"]) && is_numeric($_POST["suspenderId"])) {
                $dao = new DAOregistro();
                
                if ($dao->suspender($_POST["suspenderId"])) {
                    $_SESSION["msg"] = "alert-success--Usuario suspendido exitosamente";
                } else {
                    $_SESSION["msg"] = "alert-danger--No se ha podido suspender al usuario seleccionado.";
                }
                header("Location: listaUsuarios.php");
                exit();
            }

            if (isset($_SESSION["msg"])) {
                $msgInfo = explode("--", $_SESSION["msg"]);
                echo "<div class='alert $msgInfo[0]'>$msgInfo[1]</div>";
                unset($_SESSION["msg"]);
            }
            ?>
            <div>
                <a href="Register.php" class="btn btn-primary">Agregar</a>
            </div>
            <table id="tblUsuarios" class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Fecha Nacimiento</th>
                        <th>Número</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $dao = new DAOregistro();
                    $lista = $dao->obtenerTodos();
                    if ($lista) {
                        foreach ($lista as $usuario) {
                            echo "<tr>
                                <td>{$usuario->nombre}</td>
                                <td>{$usuario->username}</td>
                                <td>{$usuario->email}</td>
                                <td>{$usuario->edad}</td>
                                <td>{$usuario->numero}</td>
                                <td>
                                    <form action='listaUsuarios.php' method='post' style='display:inline-block;'>
                                        <input type='hidden' name='suspenderId' value='{$usuario->idusuario}'>
                                        <button type='submit' class='btn btn-warning'>Suspender</button>
                                    </form>
                                    <button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#mdlEliminar' value='{$usuario->idusuario}' nombre='{$usuario->nombre}'>Eliminar</button>
                                </td>
                            </tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
    <!-- Modal de Confirmación de Eliminación -->
    <div class="modal" tabindex="-1" id="mdlEliminar" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Confirmar eliminación</h5>
                    <button type="button" class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class="modal-body">
                    Está a punto de eliminar al usuario <b id="UsuarioEliminar"></b>, ¿Desea continuar?
                </div>
                <div class="modal-footer">
                    <form action="listaUsuarios.php" method="post" id="formEliminarUsuario">
                        <input type="hidden" id="idUsuarioEliminar" name="id" value="">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <!-- Aquí puedes incluir tu pie de página -->
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $('#tblUsuarios').DataTable();
        });

        $('#mdlEliminar').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.val();
            var nombre = button.attr('nombre');
            var modal = $(this);
            modal.find('#UsuarioEliminar').text(nombre);
            modal.find('#idUsuarioEliminar').val(id);
        });
    </script>
</body>
</html>
