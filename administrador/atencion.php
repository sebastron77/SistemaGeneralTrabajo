<?php
$page_title = 'Atención';
require_once('includes/load.php');
?>
<?php

$all_atenciones = find_all_atenciones();
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
    redirect('home.php');
}
if ($nivel == 5) {
    redirect('home.php');
}
if ($nivel == 6) {
    redirect('home.php');
}
if ($nivel == 7) {
    page_require_level_exacto(7);
}
if ($nivel == 8) {
    page_require_level_exacto(8);
}
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<a href="solicitudes_secParticular.php" class="btn btn-success">Regresar</a><br><br>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Lista de Atención</span>
                </strong>
                <?php if (($nivel <= 2) || ($nivel == 8)) : ?>
                    <a href="add_atencion.php" class="btn btn-info pull-right">Agregar atención</a>
                <?php endif; ?>
            </div>

            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 7%;">Folio</th>
                            <th style="width: 10%;">Asunto</th>
                            <th style="width: 7%;">Petición de Audiencia</th>
                            <th style="width: 2%;">Fecha de Audiencia</th>
                            <th style="width: 15%;">Personas Atendidas</th>
                            <th style="width: 2%;">Solicitud de Peticion</th>
                            <!-- <th style="width: 5%;">Modalidad</th>
                            <th style="width: 5%;">Capacitador</th>
                            <th style="width: 2%;">Curriculum</th> -->
                            <!-- <th style="width: 3%;">Constancia</th> -->
                            <?php if (($nivel <= 2) || ($nivel == 8)) : ?>
                                <th style="width: 3%;" class="text-center">Acciones</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_atenciones as $a_atencion) : ?>
                            <tr>
                                <td><?php echo remove_junk(ucwords($a_atencion['folio'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_atencion['asunto'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_atencion['peticion_audiencia'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_atencion['fecha_audiencia'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_atencion['personas_atendidas'])) ?></td>
                                <!-- <td class="text-center"><?php echo remove_junk(ucwords($a_atencion['solicitud_peticion'])) ?></td> -->
                                <!-- <td><?php echo remove_junk((ucwords($a_atencion['modalidad']))) ?></td>
                                <td><?php echo remove_junk((ucwords($a_atencion['capacitador']))) ?></td> -->
                                <?php
                                $folio_editar = $a_atencion['folio'];
                                $resultado = str_replace("/", "-", $folio_editar);
                                ?>
                                <td><a target="_blank" style="color: #23296B;" href="uploads/atencion/<?php echo $resultado . '/' . $a_atencion['solicitud_peticion']; ?>"><?php echo $a_atencion['solicitud_peticion']; ?></a></td>

                                <!-- <td class="text-center"> -->
                                <!-- <?php if ($a_atencion['constancia'] == '') : ?>
                                        <a href="pdf.php?id=<?php echo (int)$a_atencion['id']; ?>" class="btn btn-success btn-md" title="Generar Constancia" data-toggle="tooltip">
                                            <span class="glyphicon glyphicon-ok"></span>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($a_atencion['constancia'] != '') : ?>
                                        <a target="_blank" href="uploads/capacitaciones/constancias/<?php echo $resultado . '/' . $a_atencion['constancia']; ?>"><?php echo $a_atencion['constancia']; ?></a>
                                    <?php endif; ?> -->

                                <!-- </td> -->
                                <?php if (($nivel <= 2) || ($nivel == 8)) : ?>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <!-- <a href="ver_info_capacitacion.php?id=<?php echo (int)$a_atencion['id']; ?>" class="btn btn-md btn-info" data-toggle="tooltip" title="Ver información">
                                                <i class="glyphicon glyphicon-eye-open"></i>
                                            </a> -->
                                            <a href="edit_atencion.php?id=<?php echo (int)$a_atencion['id']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
                                                <span class="glyphicon glyphicon-edit"></span>
                                            </a>
                                            <?php if ($nivel == 1) : ?>
                                                <!-- <a href="delete_orientacion.php?id=<?php echo (int)$a_atencion['id']; ?>" class="btn btn-delete btn-md" title="Eliminar" data-toggle="tooltip" onclick="return confirm('¿Seguro(a) que deseas eliminar esta orientación?');">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </a> -->
                                            <?php endif; ?>
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