<?php
$page_title = 'Canalización';
require_once('includes/load.php');
?>
<?php
page_require_level(5);
$e_detalle = find_by_id('orientacion_canalizacion', (int)$_GET['id']);
//$all_detalles = find_all_detalles_busqueda($_POST['consulta']);
$user = current_user();
$nivel = $user['user_level'];
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
                    <span>Lista de Orientaciones</span>
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
                            <th style="width: 5%;">Colonia</th>
                            <th style="width: 3%;">Código Postal</th>
                            <th style="width: 2%;">Municipio</th>
                            <th style="width: 3%;">Entidad</th>
                            <th style="width: 1%;">Nacionalidad</th>                            
                            <th style="width: 5%;">Calle-Num.</th>
                            <th style="width: 5%;">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td><?php echo remove_junk(ucwords(utf8_encode($e_detalle['colonia']))) ?></td>
                            <td><?php echo remove_junk(ucwords($e_detalle['codigo_postal'])) ?></td>
                            <td><?php echo remove_junk(ucwords(utf8_encode($e_detalle['municipio_localidad']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($e_detalle['entidad']))) ?></td>
                            <td><?php echo remove_junk(ucwords($e_detalle['nacionalidad'])) ?></td>                            
                            <td><?php echo remove_junk(ucwords(utf8_encode($e_detalle['calle_numero']))) ?></td>                                                        
                            <td><?php echo remove_junk(ucwords($e_detalle['observaciones'])) ?></td>
                        </tr>
                    </tbody>
                </table>
                <a href="canalizaciones.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                    Regresar
                </a>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>