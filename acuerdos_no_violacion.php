<?php
$page_title = 'Acuerdos de No Violación';
require_once('includes/load.php');
?>
<?php

$all_acuerdos = find_all_acuerdos();
//$all_detalles = find_all_detalles_busqueda($_POST['consulta']);
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];

if ($nivel <= 2) {
    page_require_level(2);
}
if ($nivel == 3) {
    redirect('home.php');
}
if ($nivel == 4) {
    page_require_level_exacto(4);
}
if ($nivel == 5) {
    redirect('home.php');
}
if ($nivel == 6) {
    page_require_level_exacto(6);
}
if ($nivel == 7) {
    page_require_level_exacto(7);
}
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<a href="solicitudes.php" class="btn btn-success">Regresar</a><br><br>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Acuerdos de No Violación</span>
                </strong>
                <?php if (($nivel <= 2) || ($nivel == 4) || ($nivel == 6)) : ?>
                    <a href="add_capacitacion.php" class="btn btn-info pull-right">Agregar capacitación</a>
                <?php endif; ?>
            </div>

            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 10%;">Folio Acuerdo</th>
                            <th style="width: 10%;">Folio Queja</th>
                            <th style="width: 7%;">Autoridad Responsable</th>
                            <th style="width: 5%;">Servidor Público</th>
                            <th style="width: 5%;">Fecha de Acuerdo</th>
                            <th style="width: 2%;">Observaciones</th>
                            <th style="width: 5%;">Acuerdo adjunto</th>
                            <!-- <th style="width: 3%;">Constancia</th> -->
                            <?php if (($nivel <= 2) || ($nivel == 4) || ($nivel == 6)) : ?>
                                <th style="width: 3%;" class="text-center">Acciones</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_acuerdos as $a_acuerdo) : ?>
                            <tr>
                                <td><?php echo remove_junk(ucwords($a_acuerdo['folio_acuerdo'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_acuerdo['folio_queja'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_acuerdo['autoridad_responsable'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_acuerdo['servidor_publico'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_acuerdo['fecha_acuerdo'])) ?></td>
                                <td class="text-center"><?php echo remove_junk(ucwords($a_acuerdo['observaciones'])) ?></td>
                                <?php
                                $folio_editar = $a_acuerdo['folio_queja'];
                                $resultado = str_replace("/", "-", $folio_editar);
                                ?>
                                <td><a target="_blank" style="color: #23296B;" href="uploads/quejas/<?php echo $resultado . '/' . 'acuerdosNoViolacion/' . $a_acuerdo['acuerdo_adjunto']; ?>"><?php echo $a_acuerdo['acuerdo_adjunto']; ?></a></td>

                                <?php if (($nivel <= 2) || ($nivel == 4) || ($nivel == 6)) : ?>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="edit_acuerdo_no_violacion.php?id=<?php echo (int)$a_acuerdo['id']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
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