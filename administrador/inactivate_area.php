<?php
    require_once('includes/load.php');

    page_require_level(1);
?>
<?php
  
    $inactivate_id = inactivate_by_id('area',(int)$_GET['id'],'estatus_area');
    $inactivate_cargo = inactivate_area_cargo((int)$_GET['id']);
    //---------------------------------------------------------------------------------------------------------
    //EN CASO DE QUE SÍ SE QUIERA INACTIVAR TAMBIEN LOS USUARIOS Y SUS ASIGNACIONE CUANDO SE INACTIVA UN AREA,
    //SOLO HAY QUE DESCOMENTAR LAS LINEAS DE ABAJO
    //---------------------------------------------------------------------------------------------------------
    //$inactivate_trabajador = inactivate_area_trabajador('detalles_usuario',(int)$_GET['id'],'estatus_detalle');
    //$inactivate_user = inactivate_area_user('users',(int)$_GET['id'],'status');
    //$inactivate_asignacion = inactivate_area_asignacion('asignaciones',(int)$_GET['id'],'estatus_asignacion');

    if($inactivate_id){
        $session->msg("s","Área inactivada");
        redirect('areas.php');
    } else {
        $session->msg("d","Inactivación falló");
        redirect('areas.php');
    }
?>
