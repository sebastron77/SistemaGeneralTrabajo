<?php
$page_title = 'POA';
require_once('includes/load.php');
?>
<?php
// page_require_level(2);
$all_poa = find_all('poa');
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
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
if ($nivel_user > 7):
    redirect('home.php');
endif;
// page_require_area(4);

$conexion = mysqli_connect ("localhost", "root", "");
mysqli_set_charset($conexion,"utf8");
mysqli_select_db ($conexion, "probar_antes_server");
$sql = "SELECT * FROM poa";
$resultado = mysqli_query ($conexion, $sql) or die;
$poa = array();
while( $rows = mysqli_fetch_assoc($resultado) ) {
    $poa[] = $rows;
}

mysqli_close($conexion);

if (isset($_POST["export_data"])) {
    if (!empty($poa)) {
        header('Content-Encoding: UTF-8');
        header('Content-type: application/vnd.ms-excel;charset=UTF-8');
        header("Content-Disposition: attachment; filename=poa.xls");        
        $filename = "poa.xls";
        $mostrar_columnas = false;

        foreach ($poa as $resolucion) {
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
                    <span>POA</span>
                </strong>
                <?php if (($nivel_user <= 2) || ($nivel_user == 7)) : ?>
                    <a href="add_poa.php" style="margin-left: 10px" class="btn btn-info pull-right">Agregar POA</a>
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
                            <th style="width: 4%;">Folio</th>
                            <th style="width: 1%;">Año o Ejercicio Fiscal</th>
                            <th style="width: 8%;">Oficio Recibido</th>
                            <th style="width: 8%;">POA</th>
                            <th style="width: 1%;">Fecha de Recepción</th>
                            <th style="width: 8%;">Oficio de Entrega</th>
                            <?php if (($nivel_user <= 2) || ($nivel_user == 7)) : ?>
                                <th style="width: 1%;" class="text-center">Acciones</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_poa as $a_poa) : ?>
                            <?php
                            $folio_editar = $a_poa['folio'];
                            $resultado = str_replace("/", "-", $folio_editar);
                            ?>
                            <tr>
                                <td><?php echo remove_junk(ucwords($a_poa['folio'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_poa['anio_ejercicio'])) ?></td>
                                <td><a target="_blank" style="color: #23296B;" href="uploads/poa/<?php echo $resultado . '/' . $a_poa['oficio_recibido']; ?>"><?php echo $a_poa['oficio_recibido']; ?></a></td>
                                <td><a target="_blank" style="color: #23296B;" href="uploads/poa/<?php echo $resultado . '/' . $a_poa['poa']; ?>"><?php echo $a_poa['poa']; ?></a></td>
                                <td><?php echo remove_junk(ucwords($a_poa['fecha_recepcion'])) ?></td>
                                <td><a target="_blank" style="color: #23296B;" href="uploads/poa/<?php echo $resultado . '/' . $a_poa['oficio_entrega']; ?>"><?php echo $a_poa['oficio_entrega']; ?></a></td>
                                <?php if (($nivel_user <= 2) || ($nivel_user == 7)) : ?>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="edit_poa.php?id=<?php echo (int)$a_poa['id']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
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