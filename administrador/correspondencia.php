<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Correspondencia - Oficialia de Partes';
require_once('includes/load.php');
?>
<?php
// page_require_level(200);
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
$nivel_user = $user['user_level'];

// Identificamos a que área pertenece el usuario logueado
$area_user = area_usuario2($id_user);
$area = $area_user['nombre_area'];

if (($nivel_user <= 2) || ($nivel_user == 7) || ($nivel_user == 8) || ($nivel_user == 18)) {
    $all_correspondencia = find_all_correspondenciaAdmin();
} else {
    $all_correspondencia = find_all_correspondencia($area);
}

$conexion = mysqli_connect("localhost", "root", "");
mysqli_set_charset($conexion, "utf8");
mysqli_select_db($conexion, "probar_antes_server");
if (($nivel_user <= 2) || ($nivel_user == 7) || ($nivel_user == 8)) {
    $sql = "SELECT * FROM correspondencia";
} else {
    $sql = "SELECT * FROM correspondencia WHERE se_turna_a_area='{$area}'";
}
$resultado = mysqli_query($conexion, $sql) or die;
$correspondencias = array();
while ($rows = mysqli_fetch_assoc($resultado)) {
    $correspondencias[] = $rows;
}

mysqli_close($conexion);

if (isset($_POST["export_data"])) {
    if (!empty($correspondencias)) {
        header('Content-Encoding: UTF-8');
        header('Content-type: application/vnd.ms-excel;charset=UTF-8');
        header("Content-Disposition: attachment; filename=correspondencias_oficialia.xls");

        $filename = "correspondencias_oficialia.xls";
        $mostrar_columnas = false;

        foreach ($correspondencias as $correspondencia) {
            if (!$mostrar_columnas) {
                echo implode("\t", array_keys($correspondencia)) . "\n";
                $mostrar_columnas = true;
            }
            echo implode("\t", array_values($correspondencia)) . "\n";
        }
    } else {
        echo 'No hay datos a exportar';
    }
    exit;
}

// -------------------------------------------- SE COMENTARON POR QUE TODAS LAS ÁREAS VERÁN CORRESPONDENCIA --------------------------------------------
// if ($nivel_user <= 2) {
//     page_require_level(2);
// }
// if ($nivel_user == 7) {
//     page_require_level_exacto(7);
// }
//Estaba como == 8
// if ($nivel_user <= 8) {
//     page_require_level_exacto(8);
// }

// if ($nivel_user > 2 && $nivel_user < 7):
//     redirect('home.php');
// endif;
// if ($nivel_user > 8):
//     redirect('home.php');
// endif;
// page_require_area(4);

page_require_level(50);

?>
<?php include_once('layouts/header.php'); ?>

<a href="solicitudes.php" class="btn btn-success">Regresar</a><br><br>

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
                    <span>Correspondencia - Oficialia de partes</span>
                </strong>
                <?php if (($nivel_user <= 2) || ($nivel_user == 18)) : ?>
                    <a href="add_correspondencia.php" style="margin-left: 10px" class="btn btn-info pull-right">Agregar Correspondencia</a>                
                <?php endif; ?>

                <form action=" <?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <button style="float: right; margin-top: -20px" type="submit" id="export_data" name='export_data' value="Export to excel" class="btn btn-excel">Exportar a Excel</button>
                </form>
                <!-- <table id="" class="table table-striped table-bordered">
                    <tr>
                    <th>Asunto</th>
                    </tr>

                    <tbody>
                        <?php foreach ($all_correspondencia as $a_correspondencia) { ?>
                            <tr>
                                <td><?php echo $a_correspondencia['asunto']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table> -->

                <!-- <button style="float: right;" type="submit" id="export_data" name='export_data' value="Export to excel" class="btn btn-excel">Exportar a Excel</button> -->
                <!-- <?php //endif; 
                        ?> -->
            </div>

            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 3%;">Semáforo</th>
                            <th style="width: 5%;">Folio</th>
                            <th style="width: 1%;">Fecha Recibido</th>
                            <th style="width: 1%;">Fecha espera respuesta</th>
                            <th style="width: 10%;">Remitente</th>
                            <th style="width: 10%;">Institución</th>
                            <th style="width: 5%;">Medio de Recepción</th>
                            <th style="width: 20%;">Área a la que se turnó</th>
                            <!-- <th style="width: 15%;">Medio de Entrega</th> -->
                            <!-- <?php if (($nivel_user <= 2) || ($nivel_user == 7) || ($nivel_user == 8)) : ?>
                                <th style="width: 2%;" class="text-center">Acciones</th>
                            <?php endif; ?> -->

                            <th style="width: 2%;" class="text-center">Acciones</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_correspondencia as $a_correspondencia) : ?>
                            <?php
                            $folio_editar = $a_correspondencia['folio'];
                            $resultado = str_replace("/", "-", $folio_editar);
                            date_default_timezone_set('America/Mexico_City');
                            $creacion = date('Y-m-d');
                            ?>
                            <tr>
                                <?php if ($a_correspondencia['fecha_espera_respuesta'] > $creacion) : ?>
                                    <td class="text-center">
                                        <h1><span class="green">v</span>
                                    </td>
                                <?php endif; ?>
                                <?php if ($a_correspondencia['fecha_espera_respuesta'] == $creacion) : ?>
                                    <td class="text-center">
                                        <h1><span class="yellow">a</span>
                                    </td>
                                <?php endif; ?>
                                <?php if ($a_correspondencia['fecha_espera_respuesta'] < $creacion) : ?>
                                    <td class="text-center">
                                        <h1><span class="red">r</span>
                                    </td>
                                <?php endif; ?>
                                <td><?php echo remove_junk(ucwords($a_correspondencia['folio'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_correspondencia['fecha_recibido'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_correspondencia['fecha_espera_respuesta'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_correspondencia['nombre_remitente'])) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_correspondencia['nombre_institucion']))) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_correspondencia['medio_recepcion']))) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_correspondencia['se_turna_a_area']))) ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="ver_info_correspondencia.php?id=<?php echo (int)$a_correspondencia['id']; ?>" class="btn btn-md btn-info" data-toggle="tooltip" title="Ver información">
                                            <i class="glyphicon glyphicon-eye-open"></i>
                                        </a>
                                        <?php if (/*($nivel_user <= 2) || ($nivel_user == 8)*/($nivel_user <= 50)) : ?>
                                            <a href="edit_correspondencia.php?id=<?php echo (int)$a_correspondencia['id']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
                                                <span class="glyphicon glyphicon-edit"></span>
                                            </a>
                                            <a href="seguimiento_correspondencia.php?id=<?php echo (int)$a_correspondencia['id']; ?>" class="btn btn-secondary btn-md" title="Seguimiento" data-toggle="tooltip">
                                                <span class="glyphicon glyphicon-arrow-right"></span>
                                            </a>
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