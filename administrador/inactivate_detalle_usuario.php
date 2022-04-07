<?php
  require_once('includes/load.php');
  
   page_require_level(1);
?>
<?php
  $inactivate_id = inactivate_by_id('detalles_usuario',(int)$_GET['id'],'estatus_detalle');
  $inactivate_user = inactivate_by_id_user('users',(int)$_GET['id'],'status');
  $inactivate_asignacion = inactivate_by_id_asignacion('asignaciones',(int)$_GET['id'],'estatus_asignacion');
  $inactivate_asignacion_v = inactivate_by_id_asignacion_vehiculo('asignaciones_vehiculos',(int)$_GET['id'],'estatus_asignacion');
  
  $d_asignacion = find_by_id_detalle((int)$_GET['id']);
  foreach($d_asignacion as $asig){
  $product = find_by_id('componentes', $asig['id_componente']);

  $nueva_cantidad = -1 * (int)$asig['cantidad'];
  update_product_qty($nueva_cantidad, $product['id']);
  $session->msg("d", "{$product}");
  }
  
  $inactivate_id = inactivate_resguardo_trabajador('resguardos', (int)$_GET['id'], 'estatus_resguardo');

  

  if($inactivate_id){
      $session->msg("s","Trabajador inactivado");
      redirect('detalles_usuario.php');
  } else {
      $session->msg("d","Se ha producido un error en la inactivación del trabajador");
      redirect('detalles_usuario.php');
  }
?>
