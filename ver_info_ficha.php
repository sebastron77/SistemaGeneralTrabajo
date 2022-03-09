<?php
$page_title = 'Fichas Técnicas';
require_once('includes/load.php');
?>
<?php
page_require_level(2);
$a_ficha = find_by_id('fichas', (int)$_GET['id']);
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
                    <span>Fichas técnicas</span>
                </strong>
                <a href="add_ficha.php" class="btn btn-info pull-right">Agregar ficha</a>
            </div>

            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 3%;">Tipo</th>
                            <th style="width: 3%;">No. expediente</th>
                            <th style="width: 5%;">Solicitante</th>
                            <th style="width: 1%;">Visitaduria</th>
                            <th style="width: 5%;">Hechos</th>
                            <th style="width: 5%;">Autoridad</th>
                            <th style="width: 5%;">Presentante</th>
                            <th style="width: 3%;">Usuario</th>
                            <th style="width: 3%;">Parentesco</th>

                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td><?php echo remove_junk(ucwords($a_ficha['tipo_solicitud'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_ficha['num_expediente'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_ficha['solicitante'])) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_ficha['hechos']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_ficha['visitaduria']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_ficha['autoridad']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_ficha['quien_presenta']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_ficha['nombre_usuario']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_ficha['parentesco']))) ?></td>

                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 3%;">Edad</th>
                            <th style="width: 3%;">Fecha Nacimiento</th>
                            <th style="width: 3%;">Sexo</th>
                            <th style="width: 3%;">Grupo Vulnerable</th>
                            <th style="width: 3%;">Tutor</th>
                            <th style="width: 3%;">Contacto</th>
                            <th style="width: 3%;">Fecha Intervención</th>
                            <th style="width: 3%;">Hora y Lugar</th>
                            <th style="width: 3%;">Actividad realizada</th>
                            <th style="width: 3%;">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td><?php echo remove_junk(ucwords(($a_ficha['edad']))) ?></td>
                        <td><?php echo remove_junk(ucwords(($a_ficha['fecha_nacimiento']))) ?></td>
                        <td><?php echo remove_junk(ucwords(($a_ficha['sexo']))) ?></td>
                        <td><?php echo remove_junk(ucwords(($a_ficha['grupo_vulnerable']))) ?></td>
                        <td><?php echo remove_junk(ucwords(($a_ficha['tutor']))) ?></td>
                        <td><?php echo remove_junk(ucwords(($a_ficha['contacto']))) ?></td>
                        <td><?php echo remove_junk(ucwords(($a_ficha['fecha_intervencion']))) ?></td>
                        <td><?php echo remove_junk(ucwords(($a_ficha['hora_lugar']))) ?></td>
                        <td><?php echo remove_junk(ucwords(($a_ficha['actividad_realizada']))) ?></td>
                        <td><?php echo remove_junk(ucwords(($a_ficha['observaciones']))) ?></td>
                    </tbody>
                </table>
                <a href="fichas.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                    Regresar
                </a>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>