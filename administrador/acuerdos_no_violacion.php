<?php
$page_title = 'Acuerdos de No Violación';
require_once('includes/load.php');
?>
<?php

$all_acuerdos = find_all_acuerdos();
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
    page_require_level_exacto(5);
}
if ($nivel == 6) {
    redirect('home.php');
}
if ($nivel == 7) {
    page_require_level_exacto(7);
}

$conexion = mysqli_connect ("localhost", "root", "");
mysqli_set_charset($conexion,"utf8");
mysqli_select_db ($conexion, "probar_antes_server");
$sql = "SELECT * FROM acuerdos";
$resultado = mysqli_query ($conexion, $sql) or die;
$acuerdos = array();
while( $rows = mysqli_fetch_assoc($resultado) ) {
    $acuerdos[] = $rows;
}

mysqli_close($conexion);

if (isset($_POST["export_data"])) {
    if (!empty($acuerdos)) {
        header('Content-Encoding: UTF-8');
        header('Content-type: application/vnd.ms-excel;charset=UTF-8');
        header("Content-Disposition: attachment; filename=acuerdos.xls");        
        $filename = "acuerdos.xls";
        $mostrar_columnas = false;

        foreach ($acuerdos as $resolucion) {
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

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<a href="solicitudes_quejas.php" class="btn btn-success">Regresar a solicitudes</a>
<?php if (($nivel <= 2) || ($nivel == 5) || ($nivel == 7)) : ?>
    <a href="quejas_agregadas.php" class="btn btn-success">Regresar a quejas agregadas</a>
<?php endif; ?>
<br><br>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Acuerdos de No Violación</span>
                </strong>
                <!-- <?php if (($nivel <= 1) || ($nivel == 5)) : ?>
                    <a href="quejas_agregadas.php" class="btn btn-info pull-right">Agregar Acuerdo de No Violación</a>
                <?php endif; ?> -->
                <form action=" <?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <button style="float: right; margin-top: -20px" type="submit" id="export_data" name='export_data' value="Export to excel" class="btn btn-excel">Exportar a Excel</button>
                </form>
            </div>
            </div>

            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 10%;">Folio Acuerdo</th>
                            <th style="width: 10%;">Folio Queja</th>
                            <th style="width: 7%;">Autoridad Responsable</th>
                            <th style="width: 5%;">Servidor Público</th>
                            <th style="width: 5%;">Fecha de Acuerdo</th>
                            <th style="width: 2%;">Observaciones</th>
                            <th style="width: 5%;">Acuerdo adjunto</th>
                            <th style="width: 5%;">Acuerdo público adjunto</th>
                            <!-- <th style="width: 3%;">Constancia</th> -->
                            <?php if (($nivel <= 2) || ($nivel == 5)) : ?>
                                <th style="width: 3%;" class="text-center">Acciones</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_acuerdos as $a_acuerdo) : ?>
                            <tr>
                                <td><?php echo remove_junk(ucwords($a_acuerdo['folio_acuerdo'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_acuerdo['folio_queja'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_acuerdo['autoridad_responsable'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_acuerdo['servidor_publico'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_acuerdo['fecha_acuerdo'])) ?></td>
                                <td class="text-center"><?php echo remove_junk(ucwords($a_acuerdo['observaciones'])) ?></td>
                                <?php
                                $folio_editar = $a_acuerdo['folio_queja'];
                                $resultado = str_replace("/", "-", $folio_editar);
                                ?>
                                <td><a target="_blank" style="color: #23296B;" href="uploads/quejas/<?php echo $resultado . '/' . 'acuerdosNoViolacion/' . $a_acuerdo['acuerdo_adjunto']; ?>"><?php echo $a_acuerdo['acuerdo_adjunto']; ?></a></td>
                                <td><a target="_blank" style="color: #23296B;" href="uploads/quejas/<?php echo $resultado . '/' . 'acuerdosNoViolacion/' . $a_acuerdo['acuerdo_adjunto_publico']; ?>"><?php echo $a_acuerdo['acuerdo_adjunto_publico']; ?></a></td>

                                <?php if (($nivel <= 2) || ($nivel == 5)) : ?>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="edit_acuerdo_no_violacion.php?id=<?php echo (int)$a_acuerdo['id']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
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