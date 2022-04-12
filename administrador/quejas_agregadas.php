<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Lista de quejas agregadas';

require_once('includes/load.php');

// page_require_level(1);
// page_require_level(5);
$quejas_libro = find_all_quejas();
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
$nivel_user = $user['user_level'];

if ($nivel_user <= 2) {
  page_require_level(2);
}
if ($nivel_user == 5) {
  page_require_level_exacto(5);
}
if ($nivel_user == 7) {
  page_require_level_exacto(7);
}

if ($nivel_user > 2 && $nivel_user < 5) :
  redirect('home.php');
endif;
if ($nivel_user > 5 && $nivel_user < 7) :
  redirect('home.php');
endif;
if ($nivel_user > 7) :
  redirect('home.php');
endif;
?>
<?php include_once('layouts/header.php'); ?>
<a href="quejas.php" class="btn btn-success">Regresar</a><br><br>
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
          <span>Quejas Agregadas</span>
        </strong>
      </div>
      <div class="panel-body">
        <table class="datatable table table-bordered table-striped">
          <thead>
            <tr class="info">
              <th class="text-center" style="width: 2%;">Folio Queja</th>
              <th style="width: 1%;">Última Actualización</th>
              <th style="width: 3%;">Autoridad Responsable</th>
              <th style="width: 3%;">Agraviado</th>
              <th style="width: 1%;">Estatus</th>
              <th style="width: 3%;">Asignado a</th>
              <?php if (($nivel <= 2) || ($nivel == 5)) : ?>
                <th class="text-center" style="width: 25%;">Acciones</th>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($quejas_libro as $queja) : ?>
              <tr>
                <td class="text-center"> <?php echo remove_junk(ucwords($queja['folio_queja'])); ?></td>
                <td class="text-center"> <?php echo remove_junk(ucwords($queja['ultima_actualizacion'])); ?></td>
                <td> <?php echo remove_junk(($queja['autoridad_responsable'])); ?></td>
                <td> <?php echo remove_junk(($queja['creada_por'])); ?></td>
                <td class="text-center"> <?php echo remove_junk(($queja['estatus_queja'])); ?> </td>
                <td> <?php echo remove_junk($queja['asignada_a']); ?></td>
                <?php if (($nivel <= 2) || ($nivel == 5)) : ?>
                  <td class="text-center">
                    <a href="add_acuerdo_no_violacion.php?id=<?php echo (int)$queja['id']; ?>" class="btn btn-success btn-sm" data-toggle="tooltip" title="Agregar un Acuerdo de No Violación">
                      Acuerdo
                    </a>
                    <a href="add_recomendacion.php?id=<?php echo (int)$queja['id']; ?>" class="btn btn-success btn-sm" data-toggle="tooltip" title="Agregar una Recomendación">
                      Recomendación
                    </a>
                    <a href="http://177.229.209.29/quejas/upload/scp/tickets.php?id=<?php echo (int)$queja['ticket_id']; ?>" class="btn btn-queja btn-sm" data-toggle="tooltip" title="Ver en Sistema de Quejas">
                      Ver Queja
                    </a>
                    <div class="btn-group">
                      <a href="edit_queja.php?id=<?php echo (int)$queja['id']; ?>" style="color: black" class="btn btn-warning btn-sm" title="Editar en Libro Electrónico" data-toggle="tooltip">
                        Editar
                      </a>
                    </div>
                  </td>
                <?php endif; ?>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>