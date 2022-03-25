<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Orientación';
require_once('includes/load.php');
?>
<?php
$e_detalle = find_by_id('orientacion_canalizacion', (int)$_GET['id']);
//$all_detalles = find_all_detalles_busqueda($_POST['consulta']);
$user = current_user();
$nivel = $user['user_level'];

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
    page_require_level(5);
}
if ($nivel == 6) {
    redirect('home.php');
}
if ($nivel == 7) {
    redirect('home.php');
}

?>
<?php include_once('layouts/header.php'); ?>

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
                    <span>Información de Orientación</span>
                </strong>
            </div>

            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;">
                            <th style="width: 3%;">Folio</th>
                            <th style="width: 3%;">Medio de presentación</th>
                            <th style="width: 3%;">Correo</th>
                            <!--SE PUEDE AGREGAR UN LINK QUE TE LLEVE A EDITAR EL USUARIO, COMO EN EL PANEL DE CONTROL EN ULTIMAS ASIGNACIONES-->
                            <th style="width: 5%;">Nombre Completo</th>
                            <th style="width: 5%;">Nivel de Estudios</th>
                            <th style="width: 5%;">Ocupación</th>
                            <th style="width: 1%;">Edad</th>
                            <th style="width: 1%;">Telefono</th>
                            <th style="width: 1%;">Extensión</th>
                            <th style="width: 1%;">Sexo</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td><?php echo remove_junk(ucwords($e_detalle['folio'])) ?></td>
                            <td><?php echo remove_junk(ucwords($e_detalle['medio_presentacion'])) ?></td>
                            <td><?php echo remove_junk(ucwords($e_detalle['correo_electronico'])) ?></td>
                            <td><?php echo remove_junk(ucwords(($e_detalle['nombre_completo']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($e_detalle['nivel_estudios']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($e_detalle['ocupacion']))) ?></td>
                            <td><?php echo remove_junk(ucwords($e_detalle['edad'])) ?></td>
                            <td><?php echo remove_junk(ucwords($e_detalle['telefono'])) ?></td>
                            <td><?php echo remove_junk($e_detalle['extension']) ?></td>
                            <td><?php echo remove_junk(ucwords($e_detalle['sexo'])) ?></td>
                        </tr>

                    </tbody>
                </table>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 3%;">Grupo Vulnerable</th>
                            <th style="width: 3%;">Lengua</th>
                            <th style="width: 5%;">Colonia</th>
                            <th style="width: 1%;">Código Postal</th>
                            <th style="width: 2%;">Municipio</th>
                            <th style="width: 2%;">Entidad</th>
                            <th style="width: 1%;">Nacionalidad</th>                            
                            <th style="width: 5%;">Calle-Num.</th>
                            <th style="width: 5%;">Observaciones</th>
                            <th style="width: 5%;">Adjunto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo remove_junk(ucwords($e_detalle['grupo_vulnerable'])) ?></td>
                            <td><?php echo remove_junk(ucwords($e_detalle['lengua'])) ?></td>
                            <td><?php echo remove_junk(ucwords(($e_detalle['colonia']))) ?></td>
                            <td><?php echo remove_junk(ucwords($e_detalle['codigo_postal'])) ?></td>
                            <td><?php echo remove_junk(ucwords(($e_detalle['municipio_localidad']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($e_detalle['entidad']))) ?></td>
                            <td><?php echo remove_junk(ucwords($e_detalle['nacionalidad'])) ?></td>                            
                            <td><?php echo remove_junk(ucwords(($e_detalle['calle_numero']))) ?></td>                                                        
                            <td><?php echo remove_junk(ucwords($e_detalle['observaciones'])) ?></td>
                            <?php
                                $folio_editar = $e_detalle['folio'];
                                $resultado = str_replace("/", "-", $folio_editar);
                            ?>
                            <td><a target="_blank" href="uploads/orientacioncanalizacion/orientacion/<?php echo $resultado . '/' . $e_detalle['adjunto']; ?>"><?php echo $e_detalle['adjunto']; ?></a></td>
                        </tr>
                    </tbody>
                </table>
                <a href="orientaciones.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                    Regresar
                </a>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>