<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Estadísticas de Orientaciones';
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

$total_mujeres = count_by_id_mujer('orientacion_canalizacion', 1);
$total_hombres = count_by_id_hombre('orientacion_canalizacion', 1);
$total_lgbtiq = count_by_id_lgbt('orientacion_canalizacion', 1);
$total_lgbt = count_by_id_lgbt2('orientacion_canalizacion', 1);

$total_gv_lgbt = count_by_comLg('orientacion_canalizacion', 1);
$total_gv_lgbt2 = count_by_comLg2('orientacion_canalizacion', 1);
$total_der_mujer = count_by_derMuj('orientacion_canalizacion', 1);
$total_nna = count_by_nna('orientacion_canalizacion', 1);
$total_nna2 = count_by_nna2('orientacion_canalizacion', 1);
$total_disc = count_by_disc('orientacion_canalizacion', 1);
$total_mig = count_by_mig('orientacion_canalizacion', 1);
$total_vih = count_by_vih('orientacion_canalizacion', 1);
$total_gi = count_by_gi('orientacion_canalizacion', 1);
$total_perio = count_by_perio('orientacion_canalizacion', 1);
$total_ddh = count_by_ddh('orientacion_canalizacion', 1);
$total_am = count_by_am('orientacion_canalizacion', 1);
$total_int = count_by_int('orientacion_canalizacion', 1);
$total_otros = count_by_otros('orientacion_canalizacion', 1);
$total_na = count_by_na('orientacion_canalizacion', 1);

$total_asesorv = count_by_asesorv('orientacion_canalizacion', 1);
$total_asistentev = count_by_asistentev('orientacion_canalizacion', 1);
$total_comp = count_by_comp('orientacion_canalizacion', 1);
$total_escrito = count_by_escrito('orientacion_canalizacion', 1);
$total_vt = count_by_vt('orientacion_canalizacion', 1);
$total_ve = count_by_ve('orientacion_canalizacion', 1);
$total_cndh = count_by_cndh('orientacion_canalizacion', 1);

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
                    <span>Orientaciones por medio de presentación</span>
                </strong>
                <!-- <a href="add_capacitacion.php" class="btn btn-info pull-right">Agregar capacitación</a> -->
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <a href="estadistica_orientaciones_medioP.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Ver en gráfica
                    </a><br><br>
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th class="text-center" style="width: 70%;">Medio de presentación</th>
                            <th class="text-center" style="width: 30%;">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Asesor Virtual</td>
                            <td class="text-center"><?php echo $total_asesorv['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Asistente Virtual</td>
                            <td class="text-center"><?php echo $total_asistentev['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Comparecencia</td>
                            <td class="text-center"><?php echo $total_comp['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Escrito</td>
                            <td class="text-center"><?php echo $total_escrito['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Vía telefónica</td>
                            <td class="text-center"><?php echo $total_vt['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Vía electrónica</td>
                            <td class="text-center"><?php echo $total_ve['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Comisión Nacional de los Derechos Humanos</td>
                            <td class="text-center"><?php echo $total_cndh['total'] ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:right;"><b>Total</b></td>
                            <td>
                                <?php echo $total_asesorv['total'] + $total_asistentev['total'] + $total_comp['total'] + $total_escrito['total'] + $total_vt['total'] +
                                    $total_ve['total'] + $total_cndh['total']
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Orientaciones por género</span>
                </strong>
                <!-- <a href="add_capacitacion.php" class="btn btn-info pull-right">Agregar capacitación</a> -->
            </div>

            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <a href="estadistica_orientaciones_medioGen.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Ver en gráfica
                    </a><br><br>
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th class="text-center" style="width: 70%;">Género</th>
                            <th class="text-center" style="width: 30%;">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Mujer</td>
                            <td class="text-center"><?php echo $total_mujeres['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Hombre</td>
                            <td class="text-center"><?php echo $total_hombres['total'] ?></td>
                        </tr>
                        <tr>
                            <td>LGBTIQ+</td>
                            <td class="text-center"><?php echo $total_lgbtiq['total'] + $total_lgbt['total'] ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:right;"><b>Total</b></td>
                            <td>
                                <?php echo $total_mujeres['total'] + $total_hombres['total'] + $total_lgbtiq['total'] + $total_lgbt['total']?>
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
                    <span>Orientaciones por grupo vulnerable</span>
                </strong>
                <!-- <a href="add_capacitacion.php" class="btn btn-info pull-right">Agregar capacitación</a> -->
            </div>

            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <a href="estadistica_orientaciones_medioGV.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
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
                            <td>Comunidad LGBTIQ+</td>
                            <td class="text-center"><?php echo $total_gv_lgbt['total'] + $total_gv_lgbt2['total']?></td>
                        </tr>
                        <tr>
                            <td>Derechos de las mujeres</td>
                            <td class="text-center"><?php echo $total_der_mujer['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Niñas, niños y adolescentes</td>
                            <td class="text-center"><?php echo $total_nna['total'] + $total_nna2['total']?></td>
                        </tr>
                        <tr>
                            <td>Personas con discapacidad</td>
                            <td class="text-center"><?php echo $total_disc['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Personas migrantes</td>
                            <td class="text-center"><?php echo $total_mig['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Personas que viven con VIH SIDA</td>
                            <td class="text-center"><?php echo $total_vih['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Grupos indígenas</td>
                            <td class="text-center"><?php echo $total_gi['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Periodistas</td>
                            <td class="text-center"><?php echo $total_perio['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Defensores de los derechos humanos</td>
                            <td class="text-center"><?php echo $total_ddh['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Adultos Mayores</td>
                            <td class="text-center"><?php echo $total_am['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Internos</td>
                            <td class="text-center"><?php echo $total_int['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Otros</td>
                            <td class="text-center"><?php echo $total_otros['total'] ?></td>
                        </tr>
                        <tr>
                            <td>No aplica</td>
                            <td class="text-center"><?php echo $total_na['total'] ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:right;"><b>Total</b></td>
                            <td>
                                <?php echo $total_gv_lgbt['total'] + $total_gv_lgbt2['total'] + $total_der_mujer['total'] + $total_nna['total'] + $total_nna2['total']  + $total_disc['total'] + 
                                $total_mig['total'] + $total_vih['total'] + $total_gi['total'] + $total_perio['total'] + $total_ddh['total'] + $total_am['total'] + 
                                $total_int['total'] + $total_otros['total'] +$total_na['total'] ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>