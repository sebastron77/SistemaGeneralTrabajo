<?php
$page_title = 'Capacitaciones';
require_once('includes/load.php');
?>
<?php
page_require_level(4);
$all_capacitaciones = find_all_capacitaciones();
//$all_detalles = find_all_detalles_busqueda($_POST['consulta']);
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
page_require_area(4);
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
                            <th style="width: 7%;">Fecha</th>
                            <th style="width: 5%;">Hora</th>
                            <th style="width: 5%;">Lugar</th>
                            <th style="width: 2%;">Asistentes</th>
                            <th style="width: 5%;">Modalidad</th>
                            <th style="width: 5%;">Capacitador</th>
                            <th style="width: 2%;">Curriculum</th>
                            <!-- <th style="width: 3%;">Constancia</th> -->
                            <th style="width: 3%;" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_capacitaciones as $a_capacitacion) : ?>
                            <tr>
                                <td><?php echo remove_junk(ucwords($a_capacitacion['nombre_capacitacion'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_capacitacion['fecha'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_capacitacion['hora'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_capacitacion['lugar'])) ?></td>
                                <td class="text-center"><?php echo remove_junk(ucwords($a_capacitacion['no_asistentes'])) ?></td>
                                <td><?php echo remove_junk((ucwords($a_capacitacion['modalidad']))) ?></td>
                                <td><?php echo remove_junk((ucwords($a_capacitacion['capacitador']))) ?></td>
                                <?php
                                $folio_editar = $a_capacitacion['folio'];
                                $resultado = str_replace("/", "-", $folio_editar);
                                ?>
                                <td><a target="_blank" style="color: #23296B;" href="uploads/capacitaciones/curriculums/<?php echo $resultado . '/' . $a_capacitacion['curriculum']; ?>"><?php echo $a_capacitacion['curriculum']; ?></a></td>

                                <!-- <td class="text-center"> -->
                                    <!-- <?php if ($a_capacitacion['constancia'] == '') : ?>
                                        <a href="pdf.php?id=<?php echo (int)$a_capacitacion['id']; ?>" class="btn btn-success btn-md" title="Generar Constancia" data-toggle="tooltip">
                                            <span class="glyphicon glyphicon-ok"></span>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($a_capacitacion['constancia'] != '') : ?>
                                        <a target="_blank" href="uploads/capacitaciones/constancias/<?php echo $resultado . '/' . $a_capacitacion['constancia']; ?>"><?php echo $a_capacitacion['constancia']; ?></a>
                                    <?php endif; ?> -->

                                <!-- </td> -->
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="ver_info_capacitacion.php?id=<?php echo (int)$a_capacitacion['id']; ?>" class="btn btn-md btn-info" data-toggle="tooltip" title="Ver información">
                                            <i class="glyphicon glyphicon-eye-open"></i>
                                        </a>
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