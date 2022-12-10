<?php

    class conexion {
        private $servidor = "localhost";
        private $usuario  = "id19988927_root";
        private $pass     = "Matias@18062000";
        private $conexion;

        public function __construct(){
            try{
                $this->conexion = new PDO("mysql:host=$this->servidor;dbname=id19988927_santashop", $this->usuario, $this->pass);
                $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                return "Error en la base de datos ".$e;
            }
        }

        public function ejecutar($sql){
            try{
                $this->conexion->exec($sql);
                return 'ok';
            }catch(PDOException $e){
                return 'not';
            }     
        }

        public function consultar($sql){
            $sentencia = $this->conexion->prepare($sql);
            $sentencia->execute();
            return $sentencia->fetchAll();
        }
    }