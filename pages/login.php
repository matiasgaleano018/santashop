<?php
    require_once '../controlador/loguearse.php';
    require_once '../controlador/conexion.php';
    require_once '../controlador/iniciar_sesion.php';
    $log_res = "";
    if(!empty($_POST['email']) && !empty($_POST['contrasenha'])){
        $email = $_POST['email'];
        $contrasenha = $_POST['contrasenha'];
        $log = new Loguearse;
        $log_res = $log->acceder($email, $contrasenha);
        if($log_res == 'ok'){
            $selec = new Conexion;
            $res = $selec->consultar("SELECT id, nombre FROM usuarios WHERE email = '$email'");

            $ini = new IniciarSesion;
            $ini->iniciar($res[0][0], $res[0][1], $email);
        }
        $_POST = null;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Iniciar Sesion</title>
        <link href="../css/styles.css" rel="stylesheet" />
        <link href="../css/styles2.css" rel="stylesheet" />
        <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
    <body class="fondo">
        <?php
           if($log_res == 'pass_inco'){
                echo '<script type="text/javascript">sweetAlert("¡Atención!","Contraseña incorrecta","error")</script>';
            }else if($log_res == 'us_inex'){
                echo '<script type="text/javascript">sweetAlert("¡Atención!","El email '.$usuario.' no esta registrado en el sistema","warning")</script>';
            }
            $log_res = null;
            
        ?>


        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-4">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Iniciar Sesión</h3></div>
                                    <div class="card-body">
                                        <form action="login.php" method="post">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="email" placeholder="name@example.com" autofocus name="email"/>
                                                <label for="inputEmail">Correo Electronico</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" type="password" placeholder="Password" name="contrasenha"/>
                                                <label for="inputPassword">Contraseña</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <input type="submit" value="Ingresar" class="btn btn-primary w-100">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="registro.php">¿Aún no tienes una cuenta? ¡Create una!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

        <script src="../js/scripts.js"></script>
    </body>
</html>
