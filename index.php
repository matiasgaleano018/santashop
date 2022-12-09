<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SantaShop</title>
</head>
<body>
    <h1>Santa Shop</h1>


    <?php
 
        $idDeuda = 'prueba004mg'; 
        $siExiste= 'update';
        $apiUrl = 'https://staging.adamspay.com/api/v1/debts';
        $apiKey = 'ap-45da85f94f228638261bf081';
        
        // Hora DEBE ser en UTC!
        $ahora = new DateTimeImmutable('now',new DateTimeZone('UTC'));
        $expira = $ahora->add(new DateInterval('P2D'));
        
        // Crear modelo de la deuda
        $deuda = [
            'docId'=>$idDeuda,
            'label'=>'Aporte almuerzo',
            'amount'=>['currency'=>'PYG','value'=>'15000'],
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
            echo "Deuda creada exitosamente\n";
            echo "URL=$payUrl\n";
        } else {
            echo "No se pudo crear la deuda\n";
            print_r($data['meta']);
        }
        
        }
        else {
        echo 'curl_error: ',curl_error($curl);
        }
        curl_close($curl);
    ?>
</body>
</html>