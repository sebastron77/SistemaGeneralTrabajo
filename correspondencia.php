<?php
$page_title = 'Correspondencia';
require_once('includes/load.php');
?>
<?php
page_require_level(2);
$all_correspondencia = find_all_correspondencia();
$user = current_user();
$nivel = $user['user_level'];
// page_require_area(4);
?>
<?php include_once('layouts/header.php'); ?>

<a href="solicitudes_presidencia.php" class="btn btn-success">Regresar</a><br><br>

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
                    <span>Correspondencia</span>
                </strong>
                <a href="add_correspondencia.php" class="btn btn-info pull-right">Agregar Correspondencia</a>
            </div>

            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 5%;">Folio</th>
                            <th style="width: 1%;">Fecha Recibido</th>
                            <th style="width: 15%;">Remitente</th>
                            <th style="width: 5%;">Institución</th>
                            <th style="width: 1%;">Cargo Funcionario</th>
                            <th style="width: 5%;">Asunto</th>
                            <th style="width: 15%;">Medio de Recepción</th>
                            <th style="width: 15%;">Seguimiento</th>
                            <th style="width: 15%;">Medio de Entrega</th>
                            <th style="width: 2%;" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_correspondencia as $a_correspondencia) : ?>
                            <?php
                            $folio_editar = $a_correspondencia['folio'];
                            $resultado = str_replace("/", "-", $folio_editar);
                            ?>
                            <tr>
                                <td><?php echo remove_junk(ucwords($a_correspondencia['folio'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_correspondencia['fecha_recibido'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_correspondencia['nombre_remitente'])) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_correspondencia['nombre_institucion']))) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_correspondencia['cargo_funcionario']))) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_correspondencia['asunto']))) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_correspondencia['medio_recepcion']))) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_correspondencia['seguimiento']))) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_correspondencia['medio_entrega']))) ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="ver_info_correspondencia.php?id=<?php echo (int)$a_correspondencia['id']; ?>" class="btn btn-md btn-info" data-toggle="tooltip" title="Ver información">
                                            <i class="glyphicon glyphicon-eye-open"></i>
                                        </a>
                                        <a href="edit_correspondencia.php?id=<?php echo (int)$a_correspondencia['id']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
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