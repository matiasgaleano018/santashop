<?php
    session_start();
    
    $mensaje = "";
    if(isset($_SESSION['usuario_id'])){
        $usuario_nombre = !empty($_SESSION['usuario_nombre']) ? $_SESSION['usuario_nombre'] : "Usuario";
        $usuario_id     = !empty($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : 0;
    }else{
        header("location:login.php");
    }
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>SantaShop</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="../templates/css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <?php
            require_once('../controlador/conexion.php');
            require_once('../controlador/crearDeuda.php');
            if(!empty($_POST['prodCod']) && !empty($_POST['prodCant'])){
                $deuda = new crearDeuda;

                $res_deuda = $deuda->crear($_POST['prodCod'], $_POST['prodCant'], $usuario_id);
                if($res_deuda == 'cantMen'){
                    echo '<script type="text/javascript">sweetAlert("¡Atención!","La cantidad no puede ser menor a uno","warning")</script>';
                }else if($res_deuda == 'deuNo'){
                    echo '<script type="text/javascript">sweetAlert("Error","No se ha podido generar la peticion, comuniquese a servicio tecnico","error")</script>';
                }else{
                    echo "<div class='alert alert-dark' role='alert'>
                    Link de pago: <a href="$res_deuda" class='btn btn-dark'>Click aquí</a>
                  </div>";
                    //header("Location: ".$res_deuda target="_blank");
                }
            }

            if(!empty($_GET['produc'])){
                $producto_id = $_GET['produc'];
                
            }else if(!empty($_POST['prodCod'])){
                $producto_id = $_POST['prodCod'];
            }else{
                header('inicio.php');
            }

            $conn = new Conexion;

            $producto = $conn->consultar("SELECT `nombre`, `precio`, `imagen`, `descripcion` FROM `productos` WHERE `id` = $producto_id");

            $prod_nombre = !empty($producto[0][0]) ? $producto[0][0] : "";
            $prod_precio = !empty($producto[0][1]) ? $producto[0][1] : "";
            $prod_img = !empty($producto[0][2]) ? $producto[0][2] : "";
            $prod_descipcion = !empty($producto[0][3]) ? $producto[0][3] : "";
        ?>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="inicio.php">SantaShop</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="inicio.php">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="mis_pedidos.php">Mis pedidos</a></li>
                        <li class="nav-item"><a class="nav-link" href="../controlador/cerrar_session.php">Salir</a></li>
                    </ul>
                    <div class="d-flex">
                        <div>
                            Bienvenido/a <?php echo $usuario_nombre; ?>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <!-- Product section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="../img/<?php echo $prod_img;?>" alt="..." /></div>
                    <div class="col-md-6">
                        <h1 class="display-5 fw-bolder"><?php echo $prod_nombre;?></h1>
                        <div class="fs-5 mb-5">
                            <span>Gs <?php echo number_format($prod_precio, 0, ',', '.');?></span>
                        </div>
                        <p class="lead"><?php echo $prod_descipcion;?></p>
                       
                            <div class="d-flex">
                                <form action="pagar.php" method="post">
                                    <input class="form-control text-center me-3" id="inputQuantity" name="prodCant" type="number" value="1" style="max-width: 3rem" />
                                    <input type="number" style="display: none;" value="<?php echo $producto_id;?>" name="prodCod">
                                    <button type="submit" class="btn btn-outline-dark flex-shrink-0">
                                        <i class="bi-cart-fill me-1"></i>
                                        Comprar
                                    </button>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; SantaShop 2022</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="../templates/js/scripts.js"></script>
    </body>
</html>
