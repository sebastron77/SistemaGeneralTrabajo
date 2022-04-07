<?php
$page_title = 'Convenios';
require_once('includes/load.php');
?>
<?php
page_require_level(3);
$all_convenios = find_all_convenios();
$a_convenio = find_by_id('convenios', (int)$_GET['id']);
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
                    <span>Convenio <?php echo $a_convenio['folio_solicitud'] ?></span>
                </strong>
                <!-- <a href="add_convenio.php" class="btn btn-info pull-right">Agregar convenio</a> -->
            </div>

            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 4%;">Folio</th>
                            <th style="width: 1%;">Fecha Convenio</th>
                            <th style="width: 1%;">Vigencia</th>
                            <th style="width: 5%;">Institución</th>
                            <th style="width: 5%;">Ámbito Institucional</th>
                            <th style="width: 5%;">Tipo de Institución</th>
                            <th style="width: 3%;">Descripción del Convenio</th>
                            <th style="width: 5%;">Dirección Institución</th>
                            <th style="width: 1%;">Teléfono</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo remove_junk(ucwords($a_convenio['folio_solicitud'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_convenio['fecha_convenio'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_convenio['vigencia'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_convenio['institucion'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_convenio['ambito_institucion'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_convenio['tipo_institucion'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_convenio['descripcion_convenio'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_convenio['direccion_institucion'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_convenio['telefono'])) ?></td>
                        </tr>
                    </tbody>
                </table>
                <a href="convenios.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                    Regresar
                </a>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>