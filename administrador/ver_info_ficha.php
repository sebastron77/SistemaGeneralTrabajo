<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Fichas Técnicas';
require_once('includes/load.php');
?>
<?php
$a_ficha = find_by_id('fichas', (int)$_GET['id']);
$user = current_user();
$nivel = $user['user_level'];

if ($nivel <= 2) {
    page_require_level(2);
}
if ($nivel == 3) {
    redirect('home.php');
}
if ($nivel == 4) {
    page_require_level(4);
}
if ($nivel == 5) {
    redirect('home.php');
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
                    <span>Fichas técnicas</span>
                </strong>
                <!-- <a href="add_ficha.php" class="btn btn-info pull-right">Agregar ficha</a> -->
            </div>

            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 3%;">Folio</th>
                            <th style="width: 3%;">No. expediente</th>
                            <th style="width: 3%;">Tipo</th>
                            <th style="width: 5%;">Solicitante</th>
                            <th style="width: 1%;">Visitaduria</th>
                            <th style="width: 15%;">Hechos</th>
                            <th style="width: 10%;">Autoridad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo remove_junk(ucwords($a_ficha['folio'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_ficha['num_expediente'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_ficha['tipo_solicitud'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_ficha['solicitante'])) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_ficha['visitaduria']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_ficha['hechos']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_ficha['autoridad']))) ?></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 4%;">Presentante</th>
                            <th style="width: 3%;">Usuario</th>
                            <th style="width: 2%;">Parentesco</th>
                            <th style="width: 1%;">Edad</th>
                            <th style="width: 1%;">Fecha Nacimiento</th>
                            <th style="width: 1%;">Género</th>
                            <th style="width: 4%;">Grupo Vulnerable</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td><?php echo remove_junk(ucwords(($a_ficha['quien_presenta']))) ?></td>
                        <td><?php echo remove_junk(ucwords(($a_ficha['nombre_usuario']))) ?></td>
                        <td><?php echo remove_junk(ucwords(($a_ficha['parentesco']))) ?></td>
                        <td><?php echo remove_junk(ucwords(($a_ficha['edad']))) ?></td>
                        <td><?php echo remove_junk(ucwords(($a_ficha['fecha_nacimiento']))) ?></td>
                        <td><?php echo remove_junk(ucwords(($a_ficha['sexo']))) ?></td>
                        <td><?php echo remove_junk(ucwords(($a_ficha['grupo_vulnerable']))) ?></td>
                    </tbody>
                </table>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 3%;">Tutor</th>
                            <th style="width: 1%;">Contacto</th>
                            <th style="width: 3%;">Fecha Intervención</th>
                            <th style="width: 3%;">Hora y Lugar</th>
                            <th style="width: 3%;">Actividad realizada</th>
                            <th style="width: 3%;">Observaciones</th>
                            <th style="width: 3%;">Fecha de Entrega de Documento</th>
                            <th style="width: 3%;">Ficha-Adjunto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo remove_junk(ucwords(($a_ficha['tutor']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_ficha['contacto']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_ficha['fecha_intervencion']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_ficha['hora_lugar']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_ficha['actividad_realizada']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_ficha['observaciones']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_ficha['fecha_entrega_documento']))) ?></td>
                            <?php
                            $folio_editar = $a_ficha['folio'];
                            $resultado = str_replace("/", "-", $folio_editar);
                            ?>
                            <td><a target="_blank" style="color: #23296B;" href="uploads/fichastecnicas/<?php echo $resultado . '/' . $a_ficha['ficha_adjunto']; ?>"><?php echo $a_ficha['ficha_adjunto']; ?></a></td>
                        </tr>
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