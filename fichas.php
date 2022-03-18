<?php
$page_title = 'Fichas Técnicas';
require_once('includes/load.php');
?>
<?php
// page_require_level(4);
$all_fichas = find_all_fichas();
$user = current_user();
$nivel = $user['user_level'];
// page_require_area(4);
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
$nivel_user = $user['user_level'];

if ($nivel_user <= 2) {
    page_require_level(2);
}
if ($nivel_user == 4) {
    page_require_level_exacto(4);
}
if ($nivel_user == 7) {
    page_require_level_exacto(7);
}
if ($nivel_user > 2 && $nivel_user < 4):
    redirect('home.php');
endif;
if ($nivel_user > 4 && $nivel_user < 7):
    redirect('home.php');
endif;
if ($nivel_user > 7):
    redirect('home.php');
endif;
?>
<?php include_once('layouts/header.php'); ?>

<a href="solicitudes_medica_psic.php" class="btn btn-success">Regresar</a><br><br>

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
                    <span>Fichas técnicas</span>
                </strong>
                <?php if(($nivel_user <= 2) || ($nivel_user == 4)):?>
                    <a href="add_ficha.php" class="btn btn-info pull-right">Agregar ficha</a>
                <?php endif; ?>
            </div>

            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 5%;">Folio</th>
                            <th style="width: 5%;">Tipo</th>
                            <th style="width: 5%;">No. expediente</th>
                            <th style="width: 5%;">Solicitante</th>
                            <th style="width: 1%;">Visitaduria</th>
                            <th style="width: 5%;">Autoridad</th>
                            <th style="width: 5%;">Presenta</th>
                            <th style="width: 3%;">Grupo Vulnerable</th>
                            <th style="width: 3%;">Fecha Intervención</th>
                            <th style="width: 3%;">Hora y Lugar</th>
                            <?php if(($nivel_user <= 2) || ($nivel_user == 4)):?>
                            <th style="width: 5%;" class="text-center">Acciones</th>
                            <?php endif;?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_fichas as $a_ficha) : ?>
                            <tr>
                            <td><?php echo remove_junk(ucwords($a_ficha['folio'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_ficha['tipo_solicitud'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_ficha['num_expediente'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_ficha['solicitante'])) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_ficha['visitaduria']))) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_ficha['autoridad']))) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_ficha['quien_presenta']))) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_ficha['grupo_vulnerable']))) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_ficha['fecha_intervencion']))) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_ficha['hora_lugar']))) ?></td>
                                <?php if(($nivel_user <= 2) || ($nivel_user == 4)):?>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="ver_info_ficha.php?id=<?php echo (int)$a_ficha['id']; ?>" class="btn btn-md btn-info" data-toggle="tooltip" title="Ver información">
                                            <i class="glyphicon glyphicon-eye-open"></i>
                                        </a>
                                        <a href="edit_ficha.php?id=<?php echo (int)$a_ficha['id']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                    </div>
                                </td>
                                <?php endif;?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>