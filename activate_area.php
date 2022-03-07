<?php
  require_once('includes/load.php');
  
   page_require_level(1);
?>
<?php
  //$delete_id = delete_by_id('area',(int)$_GET['id']);
  $activate_id = activate_by_id('area',(int)$_GET['id'],'estatus_area');
  $activate_cargo = activate_area_cargo((int)$_GET['id']);
  $activate_trabajador = activate_area_trabajador('detalles_usuario',(int)$_GET['id'],'estatus_detalle');
  $activate_user = activate_area_user('users',(int)$_GET['id'],'status');
  $activate_asignacion = activate_area_asignacion('asignaciones',(int)$_GET['id'],'estatus_asignacion');

  if($activate_id){
      $session->msg("s","Área activada");
      redirect('areas.php');
  } else {
      $session->msg("d","Activación falló");
      redirect('areas.php');
  }
?>
