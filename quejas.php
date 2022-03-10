<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Lista de componentes';

require_once('includes/load.php');

page_require_level(1);


?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<?php
require_once('includes/sql2.php');
$quejas = quejas();
?>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Quejas</span> &nbsp &nbsp | &nbsp &nbsp <a target="_blank" href="http://177.229.209.29/quejas/upload/scp/" class="btn btn-primary">Agregar o ver seguimiento de Queja</a>
        </strong>
      </div>
      <div class="panel-body">
        <table class="datatable table table-bordered table-striped">
          <thead>
            <tr class="info">
              <th class="text-center" style="width: 1%;"> Folio / Queja</th>
              <th class="text-center" style="width: 2%;"> Última Actualización </th>
              <th class="text-center" style="width: 5%;"> Autoridad Responsable </th>
              <th class="text-center" style="width: 5%;"> Creado por </th>
              <th class="text-center" style="width: 1%;"> Estatus </th>
              <th class="text-center" style="width: 5%;"> Asignado a </th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($quejas as $queja) : ?>
              <tr>
                <td class="text-center"> <?php echo remove_junk(ucwords($queja['Folio_Queja'])); ?></td>
                <td class="text-center"> <?php echo remove_junk(ucwords($queja['Ultima_Actualizacion'])); ?></td>
                <td> <?php echo remove_junk(utf8_encode($queja['Autoridad_Responsable'])); ?></td>
                <td> <?php echo remove_junk(utf8_encode($queja['Creado_Por'])); ?></td>
                <td class="text-center"> <?php
                      if($queja['isanswered']==1){
                        echo '<strong><div style="color:#00B023">';
                        echo 'Cerrada';
                        echo '</div></strong>';
                      }
                      if(($queja['isanswered']==0) && ($queja['isoverdue']==1)){
                        echo '<strong><div style="color:#2268FE">';
                        echo 'Abierta';
                        echo '</div></strong>';
                      }
                      if(($queja['isanswered']==0) && ($queja['isoverdue']==0)){
                        echo '<strong><div style="color:orange">';
                        echo 'Pendiente';
                        echo '</div></strong>';
                      }
                      if(($queja['isanswered']==0) && ($queja['isoverdue']==1)){
                        echo '<strong><div style="color:#FE3B29">';
                        echo 'No atendido';
                        echo '</div></strong>';
                      }
                      ?>
                </td>
                <td> <?php echo remove_junk(utf8_encode($queja['Asignado_Nombre'])) . " " . utf8_encode($queja['Asignado_Apellido']); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>