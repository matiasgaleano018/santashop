<?php
    require_once 'conexion.php';
    class Loguearse{
        public function acceder($email, $contrasenha){
            $selec = new Conexion;

            $res = $selec->consultar("SELECT contrasenha, email FROM usuarios WHERE email = '$email'");

            $contrasenha_enc = md5($contrasenha);
            if(!empty($res[0][1])){
                if($res[0][0] == $contrasenha_enc){
                    return "ok";
                }else{
                    return "pass_inco";
                }
            }else{
                return "us_inex";
            }
        }
    }
?>