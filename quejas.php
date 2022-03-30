<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Lista de quejas';

require_once('includes/load.php');

// page_require_level(1);
// page_require_level(5);
$quejas_libro = find_all('quejas');
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
<a href="solicitudes_quejas.php" class="btn btn-success">Regresar</a>
<a href="quejas_agregadas.php" class="btn btn-primary">Quejas Registradas en Libro Electrónico</a><br><br>
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
          <span>Quejas</span> &nbsp &nbsp | &nbsp &nbsp <a target="_blank" href="http://177.229.209.29/quejas/upload/scp/" style="text-decoration: none; color:#F08800; border: ridge #F08800 1px; border-radius: 3px;">Agregar queja en el Sistema de Quejas</a>
        </strong>
      </div>
      <div class="panel-body">
        <table class="datatable table table-bordered table-striped">
          <thead>
            <tr class="info">
              <!-- <th class="text-center" style="width: 1%;">Folio / Queja</th> -->
              <th style="width: 1%;">Última Actualización</th>
              <th style="width: 3%;">Autoridad Responsable</th>
              <th style="width: 3%;">Agraviado</th>
              <th style="width: 1%;">Estatus Queja</th>
              <th style="width: 3%;">Asignado a</th>
              <?php if (($nivel <= 2) || ($nivel == 5)) : ?>
                <th style="width: 3%;">Agregar a Libro Electrónico</th>
              <?php endif; ?>

            </tr>
          </thead>
          <tbody>
            <?php foreach ($quejas as $queja) : ?>
              <?php if ($quejas_libro[0] != 0) : ?>
                <?php foreach ($quejas_libro as $queja_libro) : ?>
                  <tr>
                    <!-- <td class="text-center"> <?php echo remove_junk(ucwords($queja['Folio_Queja'])); ?></td> -->
                    <td class="text-center"> <?php echo remove_junk(ucwords($queja['Ultima_Actualizacion'])); ?></td>
                    <td> <?php echo remove_junk(($queja['n_autoridad'])); ?></td>
                    <td> <?php echo remove_junk(($queja['Creado_Por'])); ?></td> <!-- Es el agraviado -->
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
                    <td> <?php echo remove_junk(($queja['Asignado_Nombre'])) . " " . ($queja['Asignado_Apellido']); ?></td>
                    <?php if (($nivel <= 2) || ($nivel == 5)) : ?>
                      <td class="text-center">
                        <?php if (($queja['Ultima_Actualizacion'] != $queja_libro['ultima_actualizacion']) && ($queja['ticket_id'] != $queja_libro['ticket_id'])) : ?>
                          <a href="add_queja.php?id=<?php echo (int)$queja['ticket_id']; ?>" class="btn btn-success btn-sm" data-toggle="tooltip">
                            Agregar
                          </a>
                        <?php else : echo 'Queja ya registrada.' ?>
                        <?php endif; ?>
                      </td>
                    <?php endif; ?>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
              <?php if ($quejas_libro[0] == 0) : ?>
                <tr>
                  <!-- <td class="text-center"> <?php echo remove_junk(ucwords($queja['Folio_Queja'])); ?></td> -->
                  <td class="text-center"> <?php echo remove_junk(ucwords($queja['Ultima_Actualizacion'])); ?></td>
                  <td> <?php echo remove_junk(($queja['n_autoridad'])); ?></td>
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
                  <td> <?php echo remove_junk(($queja['Asignado_Nombre'])) . " " . ($queja['Asignado_Apellido']); ?></td>
                  <?php if (($nivel <= 2) || ($nivel == 5)) : ?>
                    <td class="text-center">
                      <?php if (($queja['Ultima_Actualizacion'] != $queja_libro['ultima_actualizacion']) && ($queja['ticket_id'] != $queja_libro['ticket_id'])) : ?>
                        <a href="add_queja.php?id=<?php echo (int)$queja['ticket_id']; ?>" class="btn btn-success btn-sm" data-toggle="tooltip">
                          Agregar
                        </a>
                      <?php else : echo 'Queja ya registrada.' ?>
                      <?php endif; ?>
                    </td>
                  <?php endif; ?>
                </tr>
              <?php endif; ?>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>