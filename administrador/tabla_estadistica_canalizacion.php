<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Estadísticas de Canalizaciones';
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

if ($nivel <= 3) {
    page_require_level(3);
}
if ($nivel == 5) {
    page_require_level_exacto(5);
}
if ($nivel == 7) {
    page_require_level_exacto(7);
}

$total_mujeres = count_by_id_mujer('orientacion_canalizacion', 2);
$total_hombres = count_by_id_hombre('orientacion_canalizacion', 2);
$total_lgbtiq = count_by_id_lgbt('orientacion_canalizacion', 2);

$total_gv_lgbt = count_by_comLg('orientacion_canalizacion', 2);
$total_gv_lgbt2 = count_by_comLg2('orientacion_canalizacion', 2);
$total_der_mujer = count_by_derMuj('orientacion_canalizacion', 2);
$total_nna = count_by_nna('orientacion_canalizacion', 2);
$total_nna2 = count_by_nna2('orientacion_canalizacion', 2);
$total_disc = count_by_disc('orientacion_canalizacion', 2);
$total_mig = count_by_mig('orientacion_canalizacion', 2);
$total_vih = count_by_vih('orientacion_canalizacion', 2);
$total_gi = count_by_gi('orientacion_canalizacion', 2);
$total_perio = count_by_perio('orientacion_canalizacion', 2);
$total_ddh = count_by_ddh('orientacion_canalizacion', 2);
$total_am = count_by_am('orientacion_canalizacion', 2);
$total_int = count_by_int('orientacion_canalizacion', 2);
$total_otros = count_by_otros('orientacion_canalizacion', 2);
$total_na = count_by_na('orientacion_canalizacion', 2);

$total_asesorv = count_by_asesorv('orientacion_canalizacion', 2);
$total_asistentev = count_by_asistentev('orientacion_canalizacion', 2);
$total_comp = count_by_comp('orientacion_canalizacion', 2);
$total_escrito = count_by_escrito('orientacion_canalizacion', 2);
$total_vt = count_by_vt('orientacion_canalizacion', 2);
$total_ve = count_by_ve('orientacion_canalizacion', 2);
$total_cndh = count_by_cndh('orientacion_canalizacion', 2);

$total_sin_est = count_by_sin_est('orientacion_canalizacion', 2);
$total_primaria = count_by_primaria('orientacion_canalizacion', 2);
$total_secundaria = count_by_secundaria('orientacion_canalizacion', 2);
$total_preparatoria = count_by_preparatoria('orientacion_canalizacion', 2);
$total_licenciatura = count_by_licenciatura('orientacion_canalizacion', 2);
$total_especialidad = count_by_especialidad('orientacion_canalizacion', 2);
$total_maestria = count_by_maestria('orientacion_canalizacion', 2);
$total_doctorado = count_by_doctorado('orientacion_canalizacion', 2);
$total_posdoctorado = count_by_posdoctorado('orientacion_canalizacion', 2);

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
                    <span>Canalizaciones por medio de presentación</span>
                </strong>
                <!-- <a href="add_capacitacion.php" class="btn btn-info pull-right">Agregar capacitación</a> -->
            </div>
            <div class="panel-body">
                <table class="table table-dark table-bordered table-striped">
                    <a href="estadistica_canalizacion_medioP.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Ver en gráfica
                    </a>
                    <a href="javascript:abrir()" class="btn btn-primary" style="float: right">Gráfica por rango de fechas</a>
                    <br><br>
                    <thead>
                        <tr style="height: 10px;" class="table-info">
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
                            <td class="text-center"><?php echo $total_asesorv['total'] + $total_asistentev['total'] + $total_comp['total'] + $total_escrito['total'] + 
                                $total_vt['total'] + $total_ve['total'] + $total_cndh['total']?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Canalizaciones por género</span>
                </strong>
                <!-- <a href="add_capacitacion.php" class="btn btn-info pull-right">Agregar capacitación</a> -->
            </div>

            <div class="panel-body">
                <table class="table table-dark table-bordered table-striped">
                    <a href="estadistica_canalizacion_medioGen.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Ver en gráfica
                    </a>
                    <a href="javascript:abrir2()" class="btn btn-primary" style="float: right">Gráfica por rango de fechas</a>
                    <br><br>
                    <thead>
                        <tr style="height: 10px;" class="table-info">
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
                            <td class="text-center"><?php echo $total_lgbtiq['total'] ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:right;"><b>Total</b></td>
                            <td class="text-center"><?php echo $total_mujeres['total'] + $total_hombres['total'] + $total_lgbtiq['total'] ?></td>
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
                    <span>Canalizaciones por grupo vulnerable</span>
                </strong>
                <!-- <a href="add_capacitacion.php" class="btn btn-info pull-right">Agregar capacitación</a> -->
            </div>

            <div class="panel-body">
                <table class="table table-dark table-bordered table-striped">
                    <a href="estadistica_canalizaciones_medioGV.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Ver en gráfica
                    </a>
                    <a href="javascript:abrir3()" class="btn btn-primary" style="float: right">Gráfica por rango de fechas</a>
                    <br><br>
                    <thead>
                        <tr style="height: 10px;" class="table-info">
                            <th class="text-center" style="width: 70%;">Grupo Vulnerable</th>
                            <th class="text-center" style="width: 30%;">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Comunidad LGBTIQ+</td>
                            <td class="text-center"><?php echo $total_gv_lgbt['total'] + $total_gv_lgbt2['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Derechos de las mujeres</td>
                            <td class="text-center"><?php echo $total_der_mujer['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Niñas, niños y adolescentes</td>
                            <td class="text-center"><?php echo $total_nna['total'] + $total_nna2['total'] ?></td>
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
                            <td class="text-center"><?php echo $total_gv_lgbt['total'] + $total_gv_lgbt2['total'] + $total_der_mujer['total'] + $total_nna['total'] + 
                                $total_nna2['total'] + $total_disc['total'] + $total_mig['total'] + $total_vih['total'] + $total_gi['total'] + $total_perio['total'] +
                                $total_ddh['total'] + $total_am['total'] + $total_int['total'] + $total_otros['total'] + $total_na['total']?>
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
                    <span>Orientaciones por Nivel de Estudios</span>
                </strong>
            </div>

            <div class="panel-body">
                <table class="table table-dark table-bordered table-striped">
                    <a href="estadistica_canalizaciones_nivelEst.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Ver en gráfica
                    </a>
                    <a href="javascript:abrir2()" class="btn btn-primary" style="float: right">Gráfica por rango de fechas</a>
                    <br><br>
                    <thead>
                        <tr style="height: 10px;" class="table-info">
                            <th class="text-center" style="width: 70%;">Nivel de estudios</th>
                            <th class="text-center" style="width: 30%;">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Sin estudios</td>
                            <td class="text-center"><?php echo $total_sin_est['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Primaria</td>
                            <td class="text-center"><?php echo $total_primaria['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Secundaria</td>
                            <td class="text-center"><?php echo $total_secundaria['total']?></td>
                        </tr>
                        <tr>
                            <td>Preparatoria</td>
                            <td class="text-center"><?php echo $total_preparatoria['total']?></td>
                        </tr>
                        <tr>
                            <td>Licenciatura</td>
                            <td class="text-center"><?php echo $total_licenciatura['total']?></td>
                        </tr>
                        <tr>
                            <td>Especialidad</td>
                            <td class="text-center"><?php echo $total_especialidad['total']?></td>
                        </tr>
                        <tr>
                            <td>Maestría</td>
                            <td class="text-center"><?php echo $total_maestria['total']?></td>
                        </tr>
                        <tr>
                            <td>Doctorado</td>
                            <td class="text-center"><?php echo $total_doctorado['total']?></td>
                        </tr>
                        <tr>
                            <td>Posdoctorado</td>
                            <td class="text-center"><?php echo $total_posdoctorado['total']?></td>
                        </tr>
                        <tr>
                            <td style="text-align:right;"><b>Total</b></td>
                            <td>
                                <?php echo $total_sin_est['total'] + $total_primaria['total'] + $total_secundaria['total'] + $total_preparatoria['total'] +
                                 $total_licenciatura['total'] + $total_especialidad['total'] + $total_maestria['total'] +
                                 $total_doctorado['total'] + $total_posdoctorado['total']?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="ventana" id="vent">
    <div id="cerrar">
        <a href="javascript:cerrar()"><img src="cerrar.png" height="25px" width="25px"></a>
    </div>
    <span></span>
    <h4 style="margin-top: 5%;">Selecciona el rango a graficar</h4>

    <form class="clearfix" method="post" action="grafica_fecha_medioP_can.php">
        <div class="form-group">
            <label class="form-label">Rango de fechas</label>
            <div class="input-group">
                <input type="text" class="datepicker form-control" name="start-date" placeholder="Desde">
                <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                <input type="text" class="datepicker form-control" name="end-date" placeholder="Hasta">
            </div>
        </div>
        <div class="form-group">
            <button type="submit" name="submit" class="btn btn-primary">Generar gráfica</button>
        </div>
    </form>
</div>

<div class="ventana2" id="vent2">
    <div id="cerrar2">
        <a href="javascript:cerrar2()"><img src="cerrar.png" height="25px" width="25px"></a>
    </div>
    <span></span>
    <h4 style="margin-top: 5%;">Selecciona el rango a graficar2</h4>

    <form class="clearfix" method="post" action="grafica_fecha_generoC.php">
        <div class="form-group">
            <label class="form-label">Rango de fechas</label>
            <div class="input-group">
                <input type="text" class="datepicker form-control" name="start-date" placeholder="Desde">
                <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                <input type="text" class="datepicker form-control" name="end-date" placeholder="Hasta">
            </div>
        </div>
        <div class="form-group">
            <button type="submit" name="submit" class="btn btn-primary">Generar gráfica</button>
        </div>
    </form>
</div>

<div class="ventana3" id="vent3">
    <div id="cerrar3">
        <a href="javascript:cerrar3()"><img src="cerrar.png" height="25px" width="25px"></a>
    </div>
    <span></span>
    <h4 style="margin-top: 5%;">Selecciona el rango a graficar3</h4>

    <form class="clearfix" method="post" action="grafica_fecha_grupoVC.php">
        <div class="form-group">
            <label class="form-label">Rango de fechas</label>
            <div class="input-group">
                <input type="text" class="datepicker form-control" name="start-date" placeholder="Desde">
                <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                <input type="text" class="datepicker form-control" name="end-date" placeholder="Hasta">
            </div>
        </div>
        <div class="form-group">
            <button type="submit" name="submit" class="btn btn-primary">Generar gráfica</button>
        </div>
    </form>
</div>

<script>
    function abrir() {
        document.getElementById("vent").style.display = "block";
    }

    function cerrar() {
        document.getElementById("vent").style.display = "none"
    }

    function abrir2() {
        document.getElementById("vent2").style.display = "block";
    }

    function cerrar2() {
        document.getElementById("vent2").style.display = "none"
    }

    function abrir3() {
        document.getElementById("vent3").style.display = "block";
    }

    function cerrar3() {
        document.getElementById("vent3").style.display = "none"
    }
</script>
<?php include_once('layouts/footer.php'); ?>