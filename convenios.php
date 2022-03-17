<?php
$page_title = 'Convenios';
require_once('includes/load.php');
?>
<?php
page_require_level(3);
$all_convenios = find_all_convenios();
$user = current_user();
$nivel = $user['user_level'];
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<?php if($user['user_level'] <= 2): ?>
    <a href="solicitudes_presidencia.php" class="btn btn-success">Regresar</a><br><br>
<?php endif; ?>
<?php if($user['user_level'] == 3): ?>
    <a href="solicitudes_secretaria_ejecutiva.php" class="btn btn-success">Regresar</a><br><br>
<?php endif; ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Convenios</span>
                </strong>
                <a href="add_convenio.php" class="btn btn-info pull-right">Agregar convenio</a>
            </div>

            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 4%;">Folio</th>
                            <th style="width: 1%;">Fecha Convenio</th>
                            <th style="width: 1%;">Vigencia</th>
                            <th style="width: 5%;">Institución</th>
                            <th style="width: 3%;">Descripción</th>
                            <!-- <th style="width: 5%;">Dirección Institución</th>
                            <th style="width: 1%;">Teléfono</th> -->
                            <th style="width: 1%;" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_convenios as $a_convenio) : ?>
                            <tr>
                                <td><?php echo remove_junk(ucwords($a_convenio['folio_solicitud'])) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_convenio['fecha_convenio']))) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_convenio['vigencia']))) ?></td>
                                <td><?php echo remove_junk((ucwords($a_convenio['institucion']))) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_convenio['descripcion_convenio']))) ?></td>
                                <!-- <td><?php echo remove_junk(ucwords(($a_convenio['direccion_institucion']))) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_convenio['telefono']))) ?></td>                                 -->
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="ver_info_conv.php?id=<?php echo (int)$a_convenio['id']; ?>" class="btn btn-md btn-info" data-toggle="tooltip" title="Ver información completa">
                                            <i class="glyphicon glyphicon-eye-open"></i>
                                        </a>
                                        <a href="edit_convenio.php?id=<?php echo (int)$a_convenio['id']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
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