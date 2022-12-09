<?php
    require_once('conexion.php');
    class crearDeuda{
        public function crear($id, $cantidad, $usuario_id){
            if($cantidad < 1){
                return "cantMen";
            }else{
                $conn = new Conexion;
                $prod_precio = $conn->consultar("SELECT precio FROM productos WHERE id = $id");
                $anho = date("Y");
                $total_pagar = $prod_precio[0][0]*$cantidad;
    
                $nro_deuda = $conn->consultar("SELECT numero FROM deudas WHERE anho = $anho ORDER BY id DESC LIMIT 1");

                $nro_d = "";
                if(empty($nro_deuda[0][0])){
                    $nro_d = 'DEU'.$anho.'0000001'; //Nro interno de la deuda compuesto por "DEU" + año actual + numero autoincremental de 7 digitos
                }else{
                    $num1 = 'DEU'.$anho;
                    $num2 = intval(substr($nro_deuda[0][0], -7))+1;
                    $nro_d = $num1."".str_pad($num2, 7, "0", STR_PAD_LEFT);
                }
    
            }
    
    
    
            /* ---------------------  Enviar deuda a AdamsPay -------------------------------------------- */
            $idDeuda = $nro_d; 
            $siExiste= 'update';
            $apiUrl = 'https://staging.adamspay.com/api/v1/debts';
            $apiKey = 'ap-45da85f94f228638261bf081';
            
            // Hora DEBE ser en UTC!
            $ahora = new DateTimeImmutable('now',new DateTimeZone('UTC'));
            $expira = $ahora->add(new DateInterval('P2D'));
            
            // Crear modelo de la deuda
            $deuda = [
                'docId'=>$idDeuda,
                'label'=>'Compra de articulo',
                'amount'=>['currency'=>'PYG','value'=>$total_pagar],
                'validPeriod'=>[
                    'start'=>$ahora->format(DateTime::ATOM),
                    'end'=>$expira->format(DateTime::ATOM)
                ]
            ];
            
            // Crear JSON para el post
            $post = json_encode( ['debt'=>$deuda] );
            
            
            // Hacer el POST
            $curl = curl_init();
            
            curl_setopt_array($curl,[
            CURLOPT_URL => $apiUrl,
            CURLOPT_HTTPHEADER => ['apikey: '.$apiKey,'Content-Type: application/json','x-if-exists'=>$siExiste],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST=>'POST',
            CURLOPT_POSTFIELDS=>$post
            ]);
            
            $response = curl_exec($curl);
            if( $response ){
            $data = json_decode($response,true);
            
            // Deuda es retornada en la propiedad "debt"
            $payUrl = isset($data['debt']) ? $data['debt']['payUrl'] : null;
            if( $payUrl ) {
                $conn->ejecutar("INSERT INTO `deudas`(`numero`, `monto`, `anho`, `usuario_id`, `direccion`, `estado`, `creadoel`) VALUES ('$nro_d', $total_pagar, $anho, $usuario_id, '$payUrl', 'pendiente', NOW())");
                return $payUrl;
            } else {
                return "deuNo";
            }
            
            }
            else {
            echo 'curl_error: ',curl_error($curl);
            }
            curl_close($curl);
            
        }
    }