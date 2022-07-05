<?php
  require_once('includes/load.php');
  
   page_require_level(1);
?>
<?php
  //$delete_id = delete_by_id('users',(int)$_GET['id']);
  
  // $d_asignacion = find_by_id_detalle((int)$_GET['id']);

  // $d_asignacion2 = find_by_id_detalle_vehiculo((int)$_GET['id']);  
  
  //$activar_vehiculo = update_estatus_vehiculo_disponible($vehiculo['id'], $vehiculo['placas']);

  // foreach($d_asignacion2 as $asig2){
  //   $vehiculo = find_by_id('vehiculos', $asig2['id_vehiculo']);    
  //   update_estatus_vehiculo_disponible($vehiculo['id'], $vehiculo['placas']);
  //   $session->msg("d", "{$vehiculo}");
  // }

  // foreach($d_asignacion as $asig){
  //   $product = find_by_id('componentes', $asig['id_componente']);

  //   $nueva_cantidad = -1 * (int)$asig['cantidad'];
  //   update_product_qty($nueva_cantidad, $product['id']);
  //   $session->msg("d", "{$product}");
  // }

  $delete_id = delete_by_id('detalles_usuario',(int)$_GET['id']);
  //$delete_asignacion = inactivate_by_id_asignacion('asignaciones',(int)$_GET['id'],'estatus_asignacion');
  if($delete_id){
      $session->msg("s","Trabajador eliminado");
      redirect('detalles_usuario.php');
  } else {
      $session->msg("d","Se ha producido un error en la eliminación del trabajador");
      redirect('detalles_usuario.php');
  }
?>
