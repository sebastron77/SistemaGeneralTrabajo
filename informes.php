<?php
$page_title = 'Informes';
require_once('includes/load.php');
?>
<?php
page_require_level(2);
$all_informe = find_all('informes');
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
                    <span>Informes</span>
                </strong>
                <a href="add_informe.php" class="btn btn-info pull-right">Agregar informe</a>
            </div>

            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 5%;">Folio</th>
                            <th style="width: 1%;"># Informe</th>
                            <th style="width: 1%;">Fecha Informe</th>
                            <th style="width: 1%;">Fecha de Entrega</th>
                            <th style="width: 2%;">Oficio de Entrega a Congreso</th>
                            <th style="width: 1%;">Caratula de Informe</th>
                            <th style="width: 15%;">URL</th>
                            <th style="width: 10%;" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_informe as $a_informe) : ?>
                            <?php
                            $folio_editar = $a_informe['folio'];
                            $resultado = str_replace("/", "-", $folio_editar);
                            ?>
                            <tr>
                                <td><?php echo remove_junk(ucwords($a_informe['folio'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_informe['num_informe'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_informe['fecha_informe'])) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_informe['fecha_entrega']))) ?></td>
                                <td><a target="_blank" style="color: #23296B;" href="uploads/informes/<?php echo $resultado . '/' . $a_informe['oficio_entrega_congreso']; ?>"><?php echo $a_informe['oficio_entrega_congreso']; ?></a></td>
                                <td><a target="_blank" style="color: #23296B;" href="uploads/informes/<?php echo $resultado . '/' . $a_informe['caratula_informe']; ?>"><?php echo $a_informe['caratula_informe']; ?></a></td>
                                <td><?php echo remove_junk(ucwords(($a_informe['liga_url']))) ?></td>                                
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="edit_informe.php?id=<?php echo (int)$a_informe['id']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
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