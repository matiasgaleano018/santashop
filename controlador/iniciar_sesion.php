<?php
    session_start();
    require_once 'conexion.php';
    class IniciarSesion{
        public function iniciar($id, $nombre, $usuario){

            $selec = new conexion;

            $_SESSION['usuario_id']     = $id;
            $_SESSION['usuario_nombre'] = $nombre;
            $_SESSION['usuario_email']   = $usuario;
            
            header("location:../pages/inicio.php");
        }
    }
?>