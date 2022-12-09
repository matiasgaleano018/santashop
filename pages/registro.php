<?php
        require '../controlador/registrarse.php';
        require '../controlador/iniciar_sesion.php';
        $mensaje = "";
        $usuario = "";
        if(!empty($_POST['nombre']) && !empty($_POST['email']) && !empty($_POST['contrasenha']) && !empty($_POST['confir_contrasenha'])){
            $patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s]+$/";
            if(preg_match($patron_texto, $_POST['nombre'])){
                $nombre = trim($_POST['nombre']);
            }else{
                $mensaje = "invalidNom";
            }
            $email = trim($_POST['email']);
            if($_POST['contrasenha'] == $_POST['confir_contrasenha']){
                $contrasenha = md5($_POST['contrasenha']);
            }else{
                $mensaje = "contConfir";
            }
        }

        if(!empty($nombre) && !empty($email) && !empty($contrasenha)){
            $ctrl = new Controlador();
            $sql = "SELECT id FROM usuarios WHERE email = '$email'";
            $us_existente = $ctrl->ctrl_seleccionar($sql);
            if(empty($us_existente)){
                $ctrl = new Controlador();
                $sql = "INSERT INTO `usuarios`(`nombre`, `email`, `contrasenha`, `creadoel`) VALUES ('$nombre', '$email', '$contrasenha', NOW())";
                $resul = $ctrl->ctrl_ejecutar($sql);

                $sql = "SELECT id FROM usuarios WHERE email = '$email' AND contrasenha = '$contrasenha'";
                $us_id = $ctrl->ctrl_seleccionar($sql);
                
                if($resul == 'ok'){

                    //Iniciar sesion con el usuario recien creado
                    $ini = new IniciarSesion();
                    $ini->iniciar($us_id[0][0], $nombre, $email);
                } 
            }else{
                $mensaje = "UsuRep";
            }
        }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Registro - SantaShop</title>
        <link href="../css/styles.css" rel="stylesheet" />
        <link href="../css/styles2.css" rel="stylesheet" />
        <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    </head>
    <body class="fondo">
    <?php
        if($mensaje == "invalidUsu"){
            echo '<script type="text/javascript">sweetAlert("¡Atención!","Caracteres invalidos en el campo Usuario","error")</script>';
        }else if($mensaje == "invalidNom"){
            echo '<script type="text/javascript">sweetAlert("¡Atención!","Caracteres invalidos en el campo Nombre","error")</script>';
        }else if($mensaje == "contConfir"){
            echo '<script type="text/javascript">sweetAlert("¡Atención!","La contraseña y su confirmación no coinciden","error")</script>';
        }else if($mensaje == "UsuRep"){
            echo '<script type="text/javascript">sweetAlert("¡Atención!","Ya existe en el sistema alguien con el correo '.$email.'","error")</script>';
        }
        
    ?>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Registrarse</h3></div>
                                    
                                    <div class="card-body">
                                        <form action="registro.php" method="post">
                                            <div class="form-floating mb-3">
                                                <input required class="form-control" id="inputEmail" type="text" placeholder="juanperez123" name="nombre" />
                                                <label for="inputEmail">Nombre</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input required class="form-control" id="inputEmail" type="text" placeholder="juanperez123" name="email" />
                                                <label for="inputEmail">Correo Electronico</label>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPassword" type="password" placeholder="Create a password" name="contrasenha"/>
                                                        <label for="inputPassword">Contraseña</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input required class="form-control" id="inputPasswordConfirm" type="password" placeholder="Confirm password" name="confir_contrasenha" />
                                                        <label for="inputPasswordConfirm">Confirmar contraseña</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid"><input class="btn btn-primary btn-block" type="submit" value="Registrarse"></div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="login.php">¿Ya tienes una cuenta? Ir al login</a></div>
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
