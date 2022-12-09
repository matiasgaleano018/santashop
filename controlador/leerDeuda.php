<?php

    require_once('conexion.php');
    

    class LeerDeuda{
        public function leer($nro_deuda){
            $idDeuda = $nro_deuda;
            $apiUrl = 'https://staging.adamspay.com/api/v1/debts/' . $idDeuda;
            $apiKey = 'ap-45da85f94f228638261bf081';
            
            $curl = curl_init();
            
            curl_setopt_array($curl,[
            CURLOPT_URL => $apiUrl,
            CURLOPT_HTTPHEADER => ['apikey: '.$apiKey],
            CURLOPT_RETURNTRANSFER => true
            ]);
            
            $response = curl_exec($curl);
            if( $response ){
            $data = json_decode($response,true);
            
            // Verificar estado de pago
            $debt = isset($data['debt']) ? $data['debt'] : null;
            if( $debt ){
                $payUrl = $debt['payUrl'];
                $label = $debt['label'];
                $objStatus = $debt['objStatus']['status'];
                $payStatus = $debt['payStatus']['status'];
                $isActive = false !== array_search($objStatus,['active','alert','success']);
                $isPaid =$payStatus === 'paid';
            
                if( $isPaid ){
                    $conn = new Conexion;
                    $conn->ejecutar("UPDATE deudas SET estado = 'pagado' WHERE numero = '$idDeuda'");
                    return 'ok';
                }
                else {
                    return 'payNot';
                }
            
            } else {
                return 'not';
            }
            
            }
            else {
            echo 'curl_error: ',curl_error($curl);
            }
            curl_close($curl);
        }
    }