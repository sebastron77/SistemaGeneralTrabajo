<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Resoluciones';
require_once('includes/load.php');
?>
<?php
// page_require_level(2);
$all_resoluciones = find_all_resoluciones();
$user = current_user();
$nivel = $user['user_level'];

$id_user = $user['id'];
$busca_area = area_usuario($id_usuario);
$otro = $busca_area['id'];

$nivel_user = $user['user_level'];
if ($nivel_user <= 2) {
    page_require_level(2);
}
if ($nivel_user == 7) {
    page_require_level_exacto(7);
}

if ($nivel_user > 2 && $nivel_user < 7):
    redirect('home.php');
  endif;
// page_require_area(4);
$conexion = mysqli_connect ("localhost", "root", "");
mysqli_set_charset($conexion,"utf8");
mysqli_select_db ($conexion, "probar_antes_server");
$sql = "SELECT * FROM resoluciones";
$resultado = mysqli_query ($conexion, $sql) or die;
$resoluciones = array();
while( $rows = mysqli_fetch_assoc($resultado) ) {
    $resoluciones[] = $rows;
}

mysqli_close($conexion);

if (isset($_POST["export_data"])) {
    if (!empty($resoluciones)) {
        header('Content-Encoding: UTF-8');
        header('Content-type: application/vnd.ms-excel;charset=UTF-8');
        header("Content-Disposition: attachment; filename=resoluciones.xls");        
        $filename = "resoluciones.xls";
        $mostrar_columnas = false;

        foreach ($resoluciones as $resolucion) {
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
                    <span>Resoluciones</span>
                </strong>
                <?php if($nivel_user <= 2):?>
                    <a href="add_resolucion.php" style="margin-left: 10px" class="btn btn-info pull-right">Agregar Resolución</a>
                <?php endif;?>
                <form action=" <?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <button style="float: right; margin-top: -20px" type="submit" id="export_data" name='export_data' value="Export to excel" class="btn btn-excel">Exportar a Excel</button>
                </form>
            </div>

            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 5%;">Folio</th>
                            <th style="width: 1%;">Núm. Expediente</th>
                            <th style="width: 15%;">Visitaduría</th>
                            <th style="width: 5%;">Fecha de Recepción</th>
                            <th style="width: 1%;">Fecha Remite a Proyecto</th>
                            <th style="width: 5%;">Oficio o Caratula de Expediente</th>
                            <th style="width: 15%;">Observaciones</th>
                            <?php if($nivel_user <= 2):?>
                                <th style="width: 2%;" class="text-center">Acciones</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_resoluciones as $a_resolucion) : ?>
                            <?php
                            $folio_editar = $a_resolucion['folio'];
                            $resultado = str_replace("/", "-", $folio_editar);
                            ?>
                            <tr>
                                <td><?php echo remove_junk(ucwords($a_resolucion['folio'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_resolucion['num_expediente'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_resolucion['visitaduria'])) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_resolucion['fecha_recepcion']))) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_resolucion['fecha_remite_proyecto']))) ?></td>
                                <td><a target="_blank" style="color: #23296B;" href="uploads/resoluciones/<?php echo $resultado . '/' . $a_resolucion['oficio_caratula']; ?>"><?php echo $a_resolucion['oficio_caratula']; ?></a></td>
                                <td><?php echo remove_junk(ucwords(($a_resolucion['observaciones']))) ?></td>
                                <?php if($nivel_user <= 2):?>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="edit_resolucion.php?id=<?php echo (int)$a_resolucion['id']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
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