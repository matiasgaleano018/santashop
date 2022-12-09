<?php
    session_start();
    session_destroy();

    unset($_SESSION['usuario_id']);
    unset($_POST);
    header("location:../pages/login.php");
    
?>