<?php
$page_title = 'Lista de cargos';
require_once('includes/load.php');

page_require_level(2);
$all_cargos = find_all_cargos('cargos');
$user = current_user();
$nivel = $user['user_level'];

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
                    <span>Cargos de la CEDH</span>
                </strong>
                <a href="add_cargo.php" class="btn btn-info pull-right btn-md"> Agregar cargo</a>
            </div>
            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead>
                        <tr class="info">
                            <th class="text-center" style="width: 5%;">#</th>
                            <th style="width: 20%;">Nombre del cargo</th>
                            <th class="text-center" style="width: 30%;">Área</th>
                            <th class="text-center" style="width: 10%;">Estatus</th>
                            <th class="text-center" style="width: 10%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_cargos as $a_cargo) : ?>
                            <tr>
                                <td class="text-center"><?php echo count_id(); ?></td>
                                <td><?php echo remove_junk(ucwords($a_cargo['nombre_cargo'])) ?></td>
                                <td class="text-center">
                                    <?php echo remove_junk(ucwords($a_cargo['nombre_area'])) ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($a_cargo['estatus_cargo'] === '1') : ?>
                                        <span class="label label-success"><?php echo "Activa"; ?></span>
                                    <?php else : ?>
                                        <span class="label label-danger"><?php echo "Inactiva"; ?></span>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="edit_cargo.php?id=<?php echo (int)$a_cargo['id']; ?>" class="btn btn-md btn-warning" data-toggle="tooltip" title="Editar">
                                            <i class="glyphicon glyphicon-pencil"></i>
                                        </a>
                                        <?php if (($nivel == 1) && ($a_cargo['id'] != 1)) : ?>
                                            <?php if ($a_cargo['estatus_cargo'] == 0) : ?>
                                                <a href="activate_cargo.php?id=<?php echo (int)$a_cargo['id']; ?>" class="btn btn-success btn-md" title="Activar" data-toggle="tooltip">
                                                <span class="glyphicon glyphicon-ok"></span>
                                                </a>
                                            <?php else : ?>
                                                <a href="inactivate_cargo.php?id=<?php echo (int)$a_cargo['id']; ?>" class="btn btn-danger btn-md" title="Inactivar" data-toggle="tooltip">
                                                    <span class="glyphicon glyphicon-ban-circle"></span>
                                                </a>
                                            <?php endif; ?>
                                            <a href="delete_cargo.php?id=<?php echo (int)$a_cargo['id']; ?>" class="btn btn-md btn-delete" data-toggle="tooltip" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar este cargo? Los trabajadores relacionados a este cargo se establecerán como *Sin cargo*.');">
                                                <i class="glyphicon glyphicon-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>