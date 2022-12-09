<?php
    require_once('conexion.php');
    if(!empty($_POST)){
        $conn = new Conexion;
        $us_email = $_POST['email'];
        $us_pass = md5($_POST['pass']);
        $us_cedula = $_POST['cedula'];

        $us = $conn->consultar("SELECT contrasenha FROM usuarios WHERE cedula = $us_cedula");
        
        if(empty($us)){
            $conn->ejecutar("INSERT INTO `usuarios`(`email`, `contrasenha`, `cedula`, `creadoel`) VALUES ('$us_email', '$us_pass', '$us_cedula', NOW())");
        }
    }