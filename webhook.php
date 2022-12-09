<?php
 require_once('controlador/conexion.php');
 $conn = new Conexion;
 $post = file_get_contents('php://input'); // el POST
 $secret = '689f977ffbbd9836225fe897cc39de9e'; // Obtener del UI de administración
  
 $hmac_esperado = md5( 'adams' . $post . $secret );
 $hmac_recibido = @$_SERVER['HTTP_X_ADAMS_NOTIFY_HASH'];

  $data = json_decode($post);
  
  // Verificar estado de pago
  $debt = isset($data['debt']) ? $data['debt'] : null;
  if( $debt ){
    $payUrl = $debt['payUrl'];
    $label = $debt['label'];
    $docId = $debt['docId'];
    $objStatus = $debt['objStatus']['status'];
    $payStatus = $debt['payStatus']['status'];
    $isActive = false !== array_search($objStatus,['active','alert','success']);
    $isPaid =$payStatus === 'paid';
 
    echo "Deuda encontrada, URL=$payUrl\n";
    echo "Concepto: $label\n";
    echo "Activa: ",($isActive?'Si':'No'),"\n";
    echo "Pagada: ";
    if( $isPaid ){
      $payTime  = $debt['payStatus']['time'];
      echo "Si, en fecha $payTime\n";
      

      $conn->ejecutar("UPDATE deudas SET estado = 'pagado' WHERE numero = '$docId'");
    }else {
      echo "No\n";
    }
 
  } else {
    echo "No se pudo obtener datos de la deuda\n";
  }

 if( $hmac_esperado !== $hmac_recibido ){
    echo 'Validación ha fallado'; 
 }

 $conn->ejecutar("UPDATE deudas SET estado = 'pendi'");

  http_response_code(200);
