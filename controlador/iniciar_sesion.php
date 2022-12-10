<?php
    session_start();
    class IniciarSesion{
        public function iniciar($id, $nombre, $usuario){


            $_SESSION['usuario_id']     = $id;
            $_SESSION['usuario_nombre'] = $nombre;
            $_SESSION['usuario_email']   = $usuario;
            
            header("location:../pages/inicio.php");
        }
    }
?>