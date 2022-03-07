<?php
  require_once('includes/load.php');
  
   page_require_level(1);
?>
<?php

    $inactivate_id = inactivate_by_id('cargos',(int)$_GET['id'],'estatus_cargo');    
    //------------------------------------------------------------------------------------------------------
    //EN CASO DE QUE SÍ SE QUIERA INACTIVAR TAMBIEN LOS USUARIOS Y SUS ASIGNACIONES Y TRABAJADORES CUANDO SE 
    //INACTIVA UN CARGO, SOLO HAY QUE DESCOMENTAR LAS LINEAS DE ABAJO
    //------------------------------------------------------------------------------------------------------    
    //$inactivate_trabajador = inactivate_cargo_trabajador('detalles_usuario',(int)$_GET['id'],'estatus_detalle');
    //$inactivate_user = inactivate_cargo_user('users',(int)$_GET['id'],'status');
    //$inactivate_asignacion = inactivate_cargo_asignacion('asignaciones',(int)$_GET['id'],'estatus_asignacion');
    
    if($inactivate_id){
        $session->msg("s","Cargo inactivado");
        redirect('cargos.php');
    } else {
        $session->msg("d","Inactivación falló");
        redirect('cargos.php');
    }
?>
