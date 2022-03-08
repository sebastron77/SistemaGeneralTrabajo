<?php
$page_title = 'Capacitaciones';
require_once('includes/load.php');
?>
<?php
page_require_level(2);
$a_capacitacion = find_by_id('capacitaciones', (int)$_GET['id']);
//$all_detalles = find_all_detalles_busqueda($_POST['consulta']);
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
page_require_area(2);
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
                    <span>Información de la Capacitación <?php echo $a_capacitacion['folio'] ?></span>
                </strong>
                <!-- <a href="add_capacitacion.php" class="btn btn-info pull-right">Agregar capacitación</a> -->
            </div>

            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 3%;">Folio</th>
                            <th style="width: 10%;">Nombre de la Capacitación</th>
                            <th style="width: 8%;">Solicita</th>
                            <th style="width: 4%;">Fecha</th>
                            <th style="width: 1%;">Hora</th>
                            <th style="width: 5%;">Lugar</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo remove_junk(ucwords($a_capacitacion['folio'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_capacitacion['nombre_capacitacion'])) ?></td>
                            <td><?php echo remove_junk((ucwords($a_capacitacion['quien_solicita']))) ?></td>
                            <td><?php echo remove_junk(ucwords($a_capacitacion['fecha'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_capacitacion['hora'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_capacitacion['lugar'])) ?></td>

                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 1%;">Asistentes</th>
                            <th style="width: 5%;">Modalidad</th>
                            <th style="width: 3%;">Depto./ Org.</th>
                            <th style="width: 5%;">Capacitador</th>
                            <th style="width: 2%;">Curriculum</th>
                            <th style="width: 5%;">Constancia</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center"><?php echo remove_junk(ucwords($a_capacitacion['no_asistentes'])) ?></td>
                            <td><?php echo remove_junk((ucwords($a_capacitacion['modalidad']))) ?></td>
                            <td><?php echo remove_junk((ucwords($a_capacitacion['depto_org']))) ?></td>
                            <td><?php echo remove_junk((ucwords($a_capacitacion['capacitador']))) ?></td>
                            <?php
                            $folio_editar = $a_capacitacion['folio'];
                            $resultado = str_replace("/", "-", $folio_editar);
                            ?>
                            <td><a target="_blank" href="uploads/capacitaciones/curriculums/<?php echo $resultado . '/' . $a_capacitacion['curriculum']; ?>"><?php echo $a_capacitacion['curriculum']; ?></a></td>

                            <td class="text-center">
                                <!-- <?php if ($a_capacitacion['constancia'] == '') : ?>
                                    <a href="pdf.php?id=<?php echo (int)$a_capacitacion['id']; ?>" class="btn btn-success btn-md" title="Generar Constancia" data-toggle="tooltip">
                                        <span class="glyphicon glyphicon-ok"></span>
                                    </a>
                                <?php endif; ?>
                                <?php if ($a_capacitacion['constancia'] != '') : ?>
                                    <a target="_blank" href="uploads/capacitaciones/constancias/<?php echo $resultado . '/' . $a_capacitacion['constancia']; ?>"><?php echo $a_capacitacion['constancia']; ?></a>
                                <?php endif; ?> -->
                            </td>
                        </tr>
                    </tbody>
                </table>
                <a href="capacitaciones.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                    Regresar
                </a>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>