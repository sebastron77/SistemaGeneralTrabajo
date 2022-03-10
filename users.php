<?php
$page_title = 'Cuentas de usuarios';
require_once('includes/load.php');
?>
<?php

page_require_level(2);
//encuentra toda la informacion de las cuentas de usuario
$all_users = find_all_cuentas();
$user = current_user();
$nivel = $user['user_level'];


$id_usuario = $user['id'];
$id_user = $user['id'];
$busca_area = area_usuario($id_usuario);
$otro = $busca_area['id'];
?>

<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Lista de Cuentas de Usuarios</span>
        </strong>
        <?php if ($otro == 1) : ?>
          <a href="add_user.php" class="btn btn-info pull-right">Agregar usuario</a>
        <?php endif ?>
      </div>
      <div class="panel-body">
        <table class="datatable table table-bordered table-striped">
          <thead>
            <tr class="info">
              <th class="text-center" style="width: 50px;">#</th>
              <!-- <th class="text-center" style="width: 5%;">ID Usuario </th> -->
              <!--SE PUEDE AGREGAR UN LINK QUE TE LLEVE A EDITAR EL USUARIO, COMO EN EL PANEL DE CONTROL EN ULTIMAS ASIGNACIONES-->
              <th>Nombre</th>
              <th>Apellidos</th>
              <th style="width: 10%;">Usuario</th>
              <th class="text-center" style="width: 10%;">Rol de usuario</th>
              <th class="text-center" style="width: 10%;">Estado</th>
              <th style="width: 15%;">Último login</th>
              <?php if ($otro == 1) : ?>
                <th style="width: 15%;">Acciones</th>
              <?php endif ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($all_users as $a_user) : ?>
              <tr>
                <td class="text-center"><?php echo count_id(); ?></td>
                <!-- <td class="text-center"><?php echo remove_junk(ucwords($a_user['id'])) ?></td> -->
                <td><?php echo remove_junk(ucwords($a_user['nombre'])) ?></td>
                <td><?php echo remove_junk(ucwords($a_user['apellidos'])) ?></td>
                <td><?php echo remove_junk($a_user['username']) ?></td>
                <td class="text-center"><?php echo remove_junk(ucwords($a_user['nombre_grupo'])) ?></td>
                <td class="text-center">
                  <?php if ($a_user['status'] === '1') : ?>
                    <span class="label label-success"><?php echo "Activo"; ?></span>
                  <?php else : ?>
                    <span class="label label-danger"><?php echo "Inactivo"; ?></span>
                  <?php endif; ?>
                </td>
                <td><?php echo read_date($a_user['ultimo_login']) ?></td>
                <?php if ($otro == 1) : ?>
                  <td class="text-center">
                    <div class="btn-group">
                      <a href="edit_user.php?id=<?php echo (int)$a_user['id']; ?>" class="btn btn-md btn-warning" data-toggle="tooltip" title="Editar">
                        <i class="glyphicon glyphicon-pencil"></i>
                      </a>
                      <?php if ($nivel == 1) : ?>
                        <?php if ($a_user['status'] == 0) : ?>
                          <a href="activate_user.php?id=<?php echo (int)$a_user['id']; ?>" class="btn btn-success btn-md" title="Activar" data-toggle="tooltip">
                            <span class="glyphicon glyphicon-ok"></span>
                          </a>
                          <a href="delete_user.php?id=<?php echo (int)$a_user['id']; ?>" class="btn btn-md btn-delete" data-toggle="tooltip" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar este usuario?');">
                            <i class="glyphicon glyphicon-trash"></i>
                          </a>
                        <?php else : ?>
                          <a href="inactivate_user.php?id=<?php echo (int)$a_user['id']; ?>" class="btn btn-md btn-danger" data-toggle="tooltip" title="Inactivar">
                            <i class="glyphicon glyphicon-ban-circle"></i>
                          </a>
                          <a href="delete_user.php?id=<?php echo (int)$a_user['id']; ?>" class="btn btn-md btn-delete" data-toggle="tooltip" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar este usuario?');">
                            <i class="glyphicon glyphicon-trash"></i>
                          </a>
                        <?php endif; ?>
                      <?php endif; ?>
                      <!-- <?php if ($nivel == 2) : ?>
                      <?php if ($a_user['status'] == 0) : ?>
                        <span class="label label-default"><?php echo "Usuario inactivado. Pide al Super Administrador"; ?></span>
                        <span class="label label-default"><?php echo "que lo active para poder editarlo."; ?></span>
                      <?php endif; ?>
                    <?php endif; ?> -->
                    </div>
                  </td>
                <?php endif ?>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>