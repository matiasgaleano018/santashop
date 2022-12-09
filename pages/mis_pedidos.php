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
    </head>
    <body>
        <?php
            require_once('../controlador/conexion.php');

            $conn = new Conexion;

            $deudas = $conn->consultar("SELECT `numero`, `monto`, `direccion`, `estado`, `creadoel` FROM `deudas` WHERE `usuario_id` = $usuario_id ORDER BY creadoel DESC");
            
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
                    <h1 class="display-4 fw-bolder title">Mis pedidos</h1>
                </div>
            </div>
        </header>


        <div class="container my-5">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nro</th>
                        <th scope="col">Monto</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Link de pago</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($deudas as $deuda){ ?>
                        <tr>
                            <th scope="row"><?php echo $deuda[0]; ?></th>
                            <td>Gs <?php echo number_format($deuda[1], 0, ',', '.');?></td>
                            <td><?php echo $deuda[4]; ?></td>
                            <td><?php echo strtoupper($deuda[3]); ?></td>
                            <td><a href="<?php echo $deuda[2]; ?>">Ir al pago</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; SantaShop 2022</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="../templates/js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    </body>
</html>