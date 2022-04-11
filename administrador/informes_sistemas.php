<?php
$page_title = 'Informes de Actividades de Sistemas';
require_once('includes/load.php');
?>
<?php
// page_require_level(2);
$all_informe = find_all('informe_actividades_sistemas');
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
$nivel_user = $user['user_level'];

if ($nivel_user <= 2) {
    page_require_level(2);
}
if ($nivel_user == 7) {
    page_require_level_exacto(7);
};
// page_require_area(4);
if ($nivel_user > 2 && $nivel_user < 7):
    redirect('home.php');
endif;
if ($nivel_user > 7):
    redirect('home.php');
endif;
?>
<?php include_once('layouts/header.php'); ?>

<a href="solicitudes_sistemas.php" class="btn btn-success">Regresar</a><br><br>

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
                    <span>Informes de Actividades de Sistemas</span>
                </strong>
                <?php if ($nivel_user <= 2) : ?>
                    <a href="add_informe_sistemas.php" class="btn btn-info pull-right">Agregar informe</a>
                <?php endif; ?>
            </div>

            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 13%;">Folio</th>
                            <th style="width: 7%;">No. Informe</th>
                            <th style="width: 15%;">Oficio de Entrega</th>
                            <th style="width: 7%;">Fecha de Informe</th>
                            <th style="width: 7%;">Fecha de Entrega</th>
                            <th style="width: 15%;">Informe</th>
                            <?php if ($nivel_user <= 2) : ?>
                                <th style="width: 1%;" class="text-center">Acciones</th>
                            <?php endif; ?>
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
                                <td class="text-center"><?php echo remove_junk(ucwords($a_informe['no_informe'])) ?></td>
                                <td><a target="_blank" style="color: #23296B;" href="uploads/informesistemas/<?php echo $resultado . '/' . $a_informe['oficio_entrega']; ?>"><?php echo $a_informe['oficio_entrega']; ?></a></td>
                                <td class="text-center"><?php echo remove_junk(ucwords($a_informe['fecha_informe'])) ?></td>
                                <td class="text-center"><?php echo remove_junk(ucwords(($a_informe['fecha_entrega']))) ?></td>
                                <td><a target="_blank" style="color: #23296B;" href="uploads/informesistemas/<?php echo $resultado . '/' . $a_informe['informe_adjunto']; ?>"><?php echo $a_informe['informe_adjunto']; ?></a></td>
                                <?php if ($nivel_user <= 2) : ?>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="edit_informe_actividades_sistemas.php?id=<?php echo (int)$a_informe['id']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
                                                <span class="glyphicon glyphicon-edit"></span>
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