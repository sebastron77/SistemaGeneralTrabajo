<?php
$page_title = 'Jornadas';
require_once('includes/load.php');
?>
<?php
// page_require_level(4);
$all_fichas = find_all_jornadas();
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
if ($nivel_user > 2 && $nivel_user < 4) :
    redirect('home.php');
endif;
if ($nivel_user > 4 && $nivel_user < 7) :
    redirect('home.php');
endif;
if ($nivel_user > 7) :
    redirect('home.php');
endif;

$conexion = mysqli_connect ("localhost", "root", "");
mysqli_set_charset($conexion,"utf8");
mysqli_select_db ($conexion, "probar_antes_server");
$sql = "SELECT * FROM jornadas";
$resultado = mysqli_query ($conexion, $sql) or die;
$jornadas = array();
while( $rows = mysqli_fetch_assoc($resultado) ) {
    $jornadas[] = $rows;
}

mysqli_close($conexion);

if (isset($_POST["export_data"])) {
    if (!empty($jornadas)) {
        header('Content-Encoding: UTF-8');
        header('Content-type: application/vnd.ms-excel;charset=UTF-8');
        header("Content-Disposition: attachment; filename=jornadas.xls");        
        $filename = "jornadas.xls";
        $mostrar_columnas = false;

        foreach ($jornadas as $resolucion) {
            if (!$mostrar_columnas) {
                echo implode("\t", array_keys($resolucion)) . "\n";
                $mostrar_columnas = true;
            }
            echo implode("\t", array_values($resolucion)) . "\n";
        }
    } else {
        echo 'No hay datos a exportar';
    }
    exit;
}

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
                    <span>Jornadas</span>
                </strong>
                <?php if (($nivel_user <= 2) || ($nivel_user == 4)) : ?>
                    <a href="add_jornada.php" style="margin-left: 10px" class="btn btn-info pull-right">Agregar jornada</a>
                <?php endif; ?>
                <form action=" <?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <button style="float: right; margin-top: -20px" type="submit" id="export_data" name='export_data' value="Export to excel" class="btn btn-excel">Exportar a Excel</button>
                </form>
            </div>
            </div>

            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th class="text-center" style="width: 2%;">Folio</th>
                            <th class="text-center" style="width: 5%;">Nombre Actividad</th>
                            <th class="text-center" style="width: 5%;">Objetivo de Actividad</th>
                            <th class="text-center" style="width: 1%;">Total atendidos</th>
                            <th class="text-center" style="width: 3%;">Fecha de actividad</th>
                            <?php if (($nivel_user <= 2) || ($nivel_user == 4)) : ?>
                                <th style="width: 3%;" class="text-center">Acciones</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_fichas as $a_ficha) : ?>
                            <tr>
                                <td><?php echo remove_junk(ucwords($a_ficha['folio'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_ficha['nombre_actividad'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_ficha['objetivo_actividad'])) ?></td>
                                <td class="text-center"><?php echo remove_junk($a_ficha['mujeres'] + $a_ficha['hombres'] + $a_ficha['lgbtiq']) ?></td>
                                <td class="text-center"><?php echo remove_junk(ucwords($a_ficha['fecha_actividad'])) ?></td>
                                <?php if (($nivel_user <= 2) || ($nivel_user == 4)) : ?>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="ver_imagenes.php?carpeta=<?php echo $a_ficha['carpeta']; ?>" class="btn btn-md btn-secondary" data-toggle="tooltip" title="Ver evidencia fotográfica">
                                                <i class="glyphicon glyphicon-picture"></i>
                                            </a>
                                            <a href="ver_info_jornada.php?id=<?php echo (int)$a_ficha['id']; ?>" class="btn btn-md btn-info" data-toggle="tooltip" title="Ver información">
                                                <i class="glyphicon glyphicon-eye-open"></i>
                                            </a>
                                            <a href="edit_jornada.php?id=<?php echo (int)$a_ficha['id']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
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