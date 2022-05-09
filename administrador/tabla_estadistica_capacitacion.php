<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Estadísticas de Capacitaciones';
require_once('includes/load.php');
?>
<?php
// page_require_level(4);
// $a_orientacion = find_by_id('capacitaciones', (int)$_GET['id']);
//$all_detalles = find_all_detalles_busqueda($_POST['consulta']);
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
// page_require_area(4);
$id_user = $user['id'];

if ($nivel <= 2) {
    page_require_level(2);
}
if ($nivel == 7) {
    page_require_level_exacto(7);
}

$total_capacitacion = count_by_capacitacion('capacitaciones');
$total_conferencia = count_by_conferencia('capacitaciones');
$total_curso = count_by_curso('capacitaciones');
$total_taller = count_by_taller('capacitaciones');
$total_platica = count_by_platica('capacitaciones');
$total_diplomado = count_by_diplomado('capacitaciones');
$total_foro = count_by_foro('capacitaciones');

$total_presencial = count_by_presencial('capacitaciones');
$total_en_linea = count_by_en_linea('capacitaciones');
$total_hibrido = count_by_hibrido('capacitaciones');

?>
<?php include_once('layouts/header.php'); ?>


<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Capacitaciones por tipo de evento</span>
                </strong>
                <!-- <a href="add_capacitacion.php" class="btn btn-info pull-right">Agregar capacitación</a> -->
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <a href="estadistica_capacitacion_te.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Ver en gráfica
                    </a><br><br>
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th class="text-center" style="width: 70%;">Tipo de Evento</th>
                            <th class="text-center" style="width: 30%;">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Capacitación</td>
                            <td class="text-center"><?php echo $total_capacitacion['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Conferencia</td>
                            <td class="text-center"><?php echo $total_conferencia['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Curso</td>
                            <td class="text-center"><?php echo $total_curso['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Taller</td>
                            <td class="text-center"><?php echo $total_taller['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Plática</td>
                            <td class="text-center"><?php echo $total_platica['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Diplomado</td>
                            <td class="text-center"><?php echo $total_diplomado['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Foro</td>
                            <td class="text-center"><?php echo $total_foro['total'] ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:right;"><b>Total</b></td>
                            <td>
                                <?php echo $total_capacitacion['total'] + $total_conferencia['total'] + $total_curso['total'] + $total_taller['total'] + $total_platica['total'] +
                                    $total_diplomado['total'] + $total_foro['total']
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Capacitaciones Por Modalidad</span>
                </strong>
                <!-- <a href="add_capacitacion.php" class="btn btn-info pull-right">Agregar capacitación</a> -->
            </div>

            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <a href="estadistica_capacitacion_mod.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Ver en gráfica
                    </a><br><br>
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th class="text-center" style="width: 70%;">Grupo Vulnerable</th>
                            <th class="text-center" style="width: 30%;">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Presencial</td>
                            <td class="text-center"><?php echo $total_presencial['total'] ?></td>
                        </tr>
                        <tr>
                            <td>En línea</td>
                            <td class="text-center"><?php echo $total_en_linea['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Híbrido</td>
                            <td class="text-center"><?php echo $total_hibrido['total'] ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:right;"><b>Total</b></td>
                            <td>
                                <?php echo $total_presencial['total'] + $total_en_linea['total'] + $total_hibrido['total'] ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>