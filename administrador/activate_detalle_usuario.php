<?php
  require_once('includes/load.php');
  
   page_require_level(1);
?>
<?php
  $activate_id = activate_by_id('detalles_usuario',(int)$_GET['id'],'estatus_detalle');
  $activate_user = activate_by_id_user('users',(int)$_GET['id'],'status');
  $activate_asignacion = activate_by_id_asignacion('asignaciones',(int)$_GET['id'],'estatus_asignacion');
  $activate_asignacion = activate_by_id_asignacion_vehiculo('asignaciones_vehiculos',(int)$_GET['id'],'estatus_asignacion');

  $d_asignacion = find_by_id_detalle((int)$_GET['id']);
  foreach($d_asignacion as $asig){
  $product = find_by_id('componentes', $asig['id_componente']);

  $nueva_cantidad = 1 * (int)$asig['cantidad'];
  update_product_qty($nueva_cantidad, $product['id']);
  $session->msg("d", "{$product}");
  }

  $activate_id = activate_resguardo_trabajador('resguardos', (int)$_GET['id'], 'estatus_resguardo');
  if($activate_id){
      $session->msg("s","Trabajador activado");
      redirect('detalles_usuario.php');
  } else {
      $session->msg("d","Se ha producido un error en la activación del trabajador");
      redirect('detalles_usuario.php');
  }
?>
