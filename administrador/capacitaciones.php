<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Capacitaciones';
require_once('includes/load.php');
?>
<?php

// $all_capacitaciones = find_all_capacitaciones();
//$all_detalles = find_all_detalles_busqueda($_POST['consulta']);
// page_require_level(200);
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
$nivel_user = $user['user_level'];

// Identificamos a que área pertenece el usuario logueado
$area_user = area_usuario2($id_user);
$area = $area_user['nombre_area'];

if (($nivel_user <= 2) || ($nivel_user == 7)) {
    $all_capacitaciones = find_all_capacitaciones();
} else {
    $all_capacitaciones = find_all_capacitaciones_area($area);
}

$conexion = mysqli_connect ("localhost", "root", "");
mysqli_set_charset($conexion,"utf8");
mysqli_select_db ($conexion, "probar_antes_server");
$sql = "SELECT * FROM capacitaciones";
$resultado = mysqli_query ($conexion, $sql) or die;
$capacitaciones = array();
while( $rows = mysqli_fetch_assoc($resultado) ) {
    $capacitaciones[] = $rows;
}

mysqli_close($conexion);

if (isset($_POST["export_data"])) {
    if (!empty($capacitaciones)) {
        header('Content-Encoding: UTF-8');
        header('Content-type: application/vnd.ms-excel;charset=UTF-8');
        header("Content-Disposition: attachment; filename=capacitaciones.xls");        
        $filename = "capacitaciones.xls";
        $mostrar_columnas = false;

        foreach ($capacitaciones as $resolucion) {
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

<a href="solicitudes.php" class="btn btn-success">Regresar</a><br><br>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Lista de Capacitaciones</span>
                </strong>
                <?php //if (($nivel <= 2) || ($nivel == 4) || ($nivel == 6) || ($nivel == 7)) : ?>
                    <a href="add_capacitacion.php" style="margin-left: 10px" class="btn btn-info pull-right">Agregar capacitación</a>
                <?php //endif; ?>
                <form action=" <?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <button style="float: right; margin-top: -20px" type="submit" id="export_data" name='export_data' value="Export to excel" class="btn btn-excel">Exportar a Excel</button>
                </form>
            </div>
            </div>

            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 10%;">Folio</th>
                            <th style="width: 10%;">Capacitación</th>
                            <th style="width: 7%;">Fecha</th>
                            <th style="width: 5%;">Hora</th>
                            <th style="width: 5%;">Lugar</th>
                            <th style="width: 2%;">Asistentes</th>
                            <th style="width: 5%;">Modalidad</th>
                            <th style="width: 5%;">Capacitador</th>
                            <th style="width: 2%;">Curriculum</th>
                            <!-- <th style="width: 3%;">Constancia</th> -->
                            
                                <th style="width: 3%;" class="text-center">Acciones</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_capacitaciones as $a_capacitacion) : ?>
                            <tr>
                            <td><?php echo remove_junk(ucwords($a_capacitacion['folio'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_capacitacion['nombre_capacitacion'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_capacitacion['fecha'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_capacitacion['hora'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_capacitacion['lugar'])) ?></td>
                                <td class="text-center"><?php echo remove_junk(ucwords($a_capacitacion['no_asistentes'])) ?></td>
                                <td><?php echo remove_junk((ucwords($a_capacitacion['modalidad']))) ?></td>
                                <td><?php echo remove_junk((ucwords($a_capacitacion['capacitador']))) ?></td>
                                <?php
                                $folio_editar = $a_capacitacion['folio'];
                                $resultado = str_replace("/", "-", $folio_editar);
                                ?>
                                <td><a target="_blank" style="color: #23296B;" href="uploads/capacitaciones/curriculums/<?php echo $resultado . '/' . $a_capacitacion['curriculum']; ?>"><?php echo $a_capacitacion['curriculum']; ?></a></td>

                                <!-- <td class="text-center"> -->
                                <!-- <?php if ($a_capacitacion['constancia'] == '') : ?>
                                        <a href="pdf.php?id=<?php echo (int)$a_capacitacion['id']; ?>" class="btn btn-success btn-md" title="Generar Constancia" data-toggle="tooltip">
                                            <span class="glyphicon glyphicon-ok"></span>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($a_capacitacion['constancia'] != '') : ?>
                                        <a target="_blank" href="uploads/capacitaciones/constancias/<?php echo $resultado . '/' . $a_capacitacion['constancia']; ?>"><?php echo $a_capacitacion['constancia']; ?></a>
                                    <?php endif; ?> -->

                                <!-- </td> -->
                                
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="ver_info_capacitacion.php?id=<?php echo (int)$a_capacitacion['id']; ?>" class="btn btn-md btn-info" data-toggle="tooltip" title="Ver información">
                                                <i class="glyphicon glyphicon-eye-open"></i>
                                            </a>
                                            <a href="edit_capacitacion.php?id=<?php echo (int)$a_capacitacion['id']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
                                                <span class="glyphicon glyphicon-edit"></span>
                                            </a>
                                            <?php if ($nivel == 1) : ?>
                                                <!-- <a href="delete_orientacion.php?id=<?php echo (int)$a_capacitacion['id']; ?>" class="btn btn-delete btn-md" title="Eliminar" data-toggle="tooltip" onclick="return confirm('¿Seguro(a) que deseas eliminar esta orientación?');">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </a> -->
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