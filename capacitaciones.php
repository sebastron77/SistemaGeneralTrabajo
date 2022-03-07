<?php
$page_title = 'Capacitaciones';
require_once('includes/load.php');
?>
<?php
page_require_level(2);
$all_capacitaciones = find_all_capacitaciones();
//$all_detalles = find_all_detalles_busqueda($_POST['consulta']);
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
                    <span>Lista de Capacitaciones</span>
                </strong>
                <a href="add_capacitacion.php" class="btn btn-info pull-right">Agregar capacitación</a>
            </div>

            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 10%;">Capacitación</th>
                            <th style="width: 10%;">Solicita</th>
                            <th style="width: 10%;">Fecha</th>
                            <th style="width: 10%;">Hora</th>
                            <th style="width: 5%;">Lugar</th>
                            <th style="width: 2%;">Asistentes</th>
                            <th style="width: 5%;">Modalidad</th>
                            <th style="width: 3%;">Depto./ Org.</th>
                            <th style="width: 5%;">Capacitador</th>
                            <th style="width: 2%;">Curriculum</th>
                            <th style="width: 5%;">Constancia</th>
                            <th style="width: 3%;" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_capacitaciones as $a_capacitacion) : ?>
                            <tr>
                                <td><?php echo remove_junk(ucwords($a_capacitacion['nombre_capacitacion'])) ?></td>
                                <td><?php echo remove_junk(utf8_decode(ucwords($a_capacitacion['quien_solicita']))) ?></td>
                                <td><?php echo remove_junk(ucwords($a_capacitacion['fecha'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_capacitacion['hora'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_capacitacion['lugar'])) ?></td>
                                <td class="text-center"><?php echo remove_junk(ucwords($a_capacitacion['no_asistentes'])) ?></td>
                                <td><?php echo remove_junk((ucwords($a_capacitacion['modalidad']))) ?></td>
                                <td><?php echo remove_junk(utf8_decode(ucwords($a_capacitacion['depto_org']))) ?></td>
                                <td><?php echo remove_junk(utf8_decode(ucwords($a_capacitacion['capacitador']))) ?></td>
                                <?php
                                    $folio_editar = $a_capacitacion['folio'];
                                    $resultado = str_replace("/", "-", $folio_editar);
                                ?>
                                <td><a target="_blank" href="uploads/capacitaciones/curriculums/<?php echo $resultado . '/' . $a_capacitacion['curriculum']; ?>"><?php echo $a_capacitacion['curriculum']; ?></a></td>
                                
                                <td><?php echo remove_junk(ucwords($a_capacitacion['constancia'])) ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="edit_capacitacion.php?id=<?php echo (int)$a_capacitacion['id']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                        <?php if ($nivel == 1) : ?>
                                            <!-- <a href="delete_orientacion.php?id=<?php echo (int)$a_capacitacion['id']; ?>" class="btn btn-delete btn-md" title="Eliminar" data-toggle="tooltip" onclick="return confirm('¿Seguro(a) que deseas eliminar esta orientación?');">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </a> -->
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