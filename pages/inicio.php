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
        <link href="../templates/css/styles2.css" rel="stylesheet" />
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
    <body>
        <?php
            require_once('../controlador/conexion.php');
            require_once('../controlador/leerDeuda.php');
            $conn = new Conexion;

            $productos = $conn->consultar("SELECT `id`, `nombre`, `precio`, `imagen` FROM `productos`");
            //intent=pay-debt&merchant=santashop954&app=website&type=debt&doc_id=DEU20220000006
            if(!empty($_GET['intent']) && !empty($_GET['doc_id'])){
                if($_GET['intent'] == "pay-debt"){
                    $leerDeuda = new LeerDeuda;
                    $resLeer = $leerDeuda->leer($_GET['doc_id']);
                    if($resLeer == 'ok'){
                        echo '<script type="text/javascript">sweetAlert("Genial","El pago ha sido correctamente procesado. Nro Transacción: '.$_GET['doc_id'].'","success")</script>';
                    }else if($leerDeuda == 'payNot'){
                        echo '<script type="text/javascript">sweetAlert("Atencion","El producto aun no ha sido pagado","warning")</script>';
                    }else{
                        echo '<script type="text/javascript">sweetAlert("Atencion","No se procesaron los datos de la transaccion","error")</script>';
                    }
                }
            }
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
        <!-- Header-->
        <header class="py-5 fondo">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder title">Alegrando la navidad</h1>
                    <p class="lead fw-normal text-white-50 mb-0">La unica tienda de Santa Clous</p>
                </div>
            </div>
        </header>

        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <?php foreach($productos as $producto){ ?>
                        <div class="col mb-5">
                            
                            <div class="card h-100">
                                <!-- Product image-->
                                <img class="card-img-top" src="../img/<?php echo $producto[3];?>" alt="..." />
                                <!-- Product details-->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <h5 class="fw-bolder title"><?php echo $producto[1];?></h5>
                                        <!-- Product price-->
                                        <span class="text-muted price">Gs <?php echo number_format($producto[2], 0, ',', '.');?></span>
                                    </div>
                                </div>
                                <!-- Product actions-->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                
                                <div class="text-center">
                                <a href="pagar.php?produc=<?php echo $producto[0];?>" class="btn btn-outline-dark mt-auto aggCarrito">Ver Detalles</a></div>
                                </div>
                            </div>
                            </form>
                        </div>
                    <?php } ?>
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