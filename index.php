<?php
    session_start();

    if(!empty($_SESSION['usuario_id'])){
        header('pages/inicio.php');
    }else{
        header('pages/login.php');
    }
        
?>
