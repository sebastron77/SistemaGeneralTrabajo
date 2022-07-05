<?php
$page_title = 'Convenios';
require_once('includes/load.php');
?>
<?php
// page_require_level(3);
$all_convenios = find_all_convenios();
// $user = current_user();
// $nivel = $user['user_level'];

$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
$nivel_user = $user['user_level'];

if ($nivel_user <= 2) {
    page_require_level(2);
}
if ($nivel_user == 3) {
    page_require_level_exacto(3);
}
if ($nivel_user == 7) {
    page_require_level_exacto(7);
}

if ($nivel_user > 3 && $nivel_user < 7):
    redirect('home.php');
endif;
if ($nivel_user > 7):
    redirect('home.php');
endif;

$conexion = mysqli_connect ("localhost", "root", "");
mysqli_set_charset($conexion,"utf8");
mysqli_select_db ($conexion, "probar_antes_server");
$sql = "SELECT * FROM convenios";
$resultado = mysqli_query ($conexion, $sql) or die;
$convenios = array();
while( $rows = mysqli_fetch_assoc($resultado) ) {
    $convenios[] = $rows;
}

mysqli_close($conexion);

if (isset($_POST["export_data"])) {
    if (!empty($convenios)) {
        header('Content-Encoding: UTF-8');
        header('Content-type: application/vnd.ms-excel;charset=UTF-8');
        header("Content-Disposition: attachment; filename=convenios.xls");        
        $filename = "convenios.xls";
        $mostrar_columnas = false;

        foreach ($convenios as $resolucion) {
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

<?php if ($user['user_level'] <= 2) : ?>
    <a href="solicitudes.php" class="btn btn-success">Regresar</a><br><br>
<?php endif; ?>
<?php if ($user['user_level'] == 3) : ?>
    <a href="solicitudes_secretaria_ejecutiva.php" class="btn btn-success">Regresar</a><br><br>
<?php endif; ?>
<?php if ($user['user_level'] == 7) : ?>
    <a href="solicitudes.php" class="btn btn-success">Regresar</a><br><br>
<?php endif; ?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Convenios</span>
                </strong>
                <?php if (($nivel_user <= 2) || ($nivel_user == 3) || ($nivel_user == 7)) : ?>
                    <a href="add_convenio.php" style="margin-left: 10px" class="btn btn-info pull-right">Agregar convenio</a>
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
                            <th style="width: 1%;">Fecha Convenio</th>
                            <th style="width: 1%;">Vigencia</th>
                            <th style="width: 5%;">Institución</th>
                            <th style="width: 3%;">Convenio</th>
                            <th style="width: 3%;">Descripción</th>
                            <?php if ($nivel_user <= 2 || ($nivel_user == 3) || ($nivel_user == 7)) : ?>
                                <th style="width: 1%;" class="text-center">Acciones</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_convenios as $a_convenio) : ?>
                            <tr>
                                <td><?php echo remove_junk(ucwords($a_convenio['folio_solicitud'])) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_convenio['fecha_convenio']))) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_convenio['vigencia']))) ?></td>
                                <td><?php echo remove_junk((ucwords($a_convenio['institucion']))) ?></td>
                                <?php 
                                    $folio_editar = $a_convenio['folio_solicitud'];
                                    $resultado = str_replace("/", "-", $folio_editar); 
                                ?>
                                
                                <td><a target="_blank" style="color: #23296B;" href="uploads/convenios/<?php echo $resultado . '/' . $a_convenio['convenio']; ?>"><?php echo $a_convenio['convenio']; ?></a></td>
                                <td><?php echo remove_junk(ucwords(($a_convenio['descripcion_convenio']))) ?></td>
                                <?php if (($nivel_user <= 2) || ($nivel_user == 3) || ($nivel_user == 7)) : ?>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="ver_info_conv.php?id=<?php echo (int)$a_convenio['id']; ?>" class="btn btn-md btn-info" data-toggle="tooltip" title="Ver información completa">
                                                <i class="glyphicon glyphicon-eye-open"></i>
                                            </a>
                                            <a href="edit_convenio.php?id=<?php echo (int)$a_convenio['id']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
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