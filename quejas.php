<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Lista de quejas';

require_once('includes/load.php');

// page_require_level(1);
page_require_level(5);


?>
<?php include_once('layouts/header.php'); ?>
<a href="solicitudes.php" class="btn btn-success">Regresar</a><br><br>
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
              <th class="text-center" style="width: 1%;">Folio / Queja</th>
              <th class="text-center" style="width: 1%;">Última Actualización</th>
              <th class="text-center" style="width: 5%;">Autoridad Responsable</th>
              <th class="text-center" style="width: 5%;">Creado por</th>
              <th class="text-center" style="width: 1%;">Estatus Queja</th>
              <th class="text-center" style="width: 1%;">Estatus en Base de Datos</th>
              <th class="text-center" style="width: 5%;">Asignado a</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($quejas as $queja) : ?>
              <tr>
                <td class="text-center"> <?php echo remove_junk(ucwords($queja['Folio_Queja'])); ?></td>
                <td class="text-center"> <?php echo remove_junk(ucwords($queja['Ultima_Actualizacion'])); ?></td>
                <td> <?php echo remove_junk(($queja['Autoridad_Responsable'])); ?></td>
                <td> <?php echo remove_junk(($queja['Creado_Por'])); ?></td>
                <td class="text-center">
                  <?php
                  if ($queja['isanswered'] == 1) {
                    echo '<strong><div style="color:#00B023">';
                    echo 'Cerrada';
                    echo '</div></strong>';
                  }
                  if (($queja['isanswered'] == 0) && ($queja['isoverdue'] == 1)) {
                    echo '<strong><div style="color:#2268FE">';
                    echo 'Abierta';
                    echo '</div></strong>';
                  }
                  if (($queja['isanswered'] == 0) && ($queja['isoverdue'] == 0)) {
                    echo '<strong><div style="color:orange">';
                    echo 'Pendiente';
                    echo '</div></strong>';
                  }
                  if (($queja['isanswered'] == 0) && ($queja['isoverdue'] == 1)) {
                    echo '<strong><div style="color:#FE3B29">';
                    echo 'No atendido';
                    echo '</div></strong>';
                  }
                  ?>
                </td>
                <!-- En lugar de Folio_Queja va a ir el número de consecutivo y yo creo que se haga el folio aquí mismo
                     para ver como quedaría el folio y ver si con ese número de consecutivo no existe un folio así ya
                     para checar eso sería con el contador que está en la tabla de folios. -->
                <td class="text-center">
                  <?php if ($folio != $queja['Folio_Queja']) : ?>
                    <a href="add_queja.php?id=<?php echo (int)$queja['ticket_id']; ?>" class="btn btn-success btn-sm" data-toggle="tooltip">
                      Agregar
                    </a>
                  <?php endif ?>
                </td>
                <td> <?php echo remove_junk(($queja['Asignado_Nombre'])) . " " . ($queja['Asignado_Apellido']); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>