<?php
$page_title = 'Eventos';
require_once('includes/load.php');
?>
<?php

$all_eventos = find_all_eventos();
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
                    <span>Lista de Eventos</span>
                </strong>
                <?php if (($nivel <= 2) || ($nivel == 4) || ($nivel == 6)) : ?>
                    <a href="add_evento.php" class="btn btn-info pull-right">Agregar evento</a>
                <?php endif; ?>
            </div>

            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 10%;">Folio</th>
                            <th style="width: 10%;">Evento</th>
                            <th style="width: 10%;">Tipo Evento</th>
                            <th style="width: 7%;">Fecha</th>
                            <th style="width: 5%;">Hora</th>
                            <th style="width: 5%;">Lugar</th>
                            <th style="width: 2%;">Asistentes</th>
                            <th style="width: 5%;">Modalidad</th>
                            <th style="width: 2%;">Invitación</th>
                            <!-- <th style="width: 3%;">Constancia</th> -->
                            <?php if (($nivel <= 2) || ($nivel == 7)) : ?>
                                <th style="width: 3%;" class="text-center">Acciones</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_eventos as $a_evento) : ?>
                            <tr>
                            <td><?php echo remove_junk(ucwords($a_evento['folio'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_evento['nombre_evento'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_evento['tipo_evento'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_evento['fecha'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_evento['hora'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_evento['lugar'])) ?></td>
                                <td class="text-center"><?php echo remove_junk(ucwords($a_evento['no_asistentes'])) ?></td>
                                <td><?php echo remove_junk((ucwords($a_evento['modalidad']))) ?></td>
                                <?php
                                $folio_editar = $a_evento['folio'];
                                $resultado = str_replace("/", "-", $folio_editar);
                                ?>
                                <td><a target="_blank" style="color: #23296B;" href="uploads/eventos/invitaciones/<?php echo $resultado . '/' . $a_evento['invitacion']; ?>"><?php echo $a_evento['invitacion']; ?></a></td>

                                <?php if (($nivel <= 2) || ($nivel == 7)) : ?>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="ver_info_evento.php?id=<?php echo (int)$a_evento['id']; ?>" class="btn btn-md btn-info" data-toggle="tooltip" title="Ver información">
                                                <i class="glyphicon glyphicon-eye-open"></i>
                                            </a>
                                            <a href="edit_evento.php?id=<?php echo (int)$a_evento['id']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
                                                <span class="glyphicon glyphicon-edit"></span>
                                            </a>
                                            <?php if ($nivel == 1) : ?>
                                                <!-- <a href="delete_orientacion.php?id=<?php echo (int)$a_evento['id']; ?>" class="btn btn-delete btn-md" title="Eliminar" data-toggle="tooltip" onclick="return confirm('¿Seguro(a) que deseas eliminar esta orientación?');">
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