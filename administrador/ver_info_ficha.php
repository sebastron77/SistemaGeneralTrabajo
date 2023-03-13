<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once('includes/load.php');
?>
<?php
$a_ficha = find_by_id('fichas', (int)$_GET['id']);
$tipo_ficha = find_tipo_ficha((int)$_GET['id']);
$user = current_user();
$nivel = $user['user_level'];

if ($tipo_ficha['tipo_ficha'] == 1) :
    $page_title = 'Ficha Técnica - Área Médica';
else :
    $page_title = 'Ficha Técnica - Área Psicológica';
endif;

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
                    <?php if ($tipo_ficha['tipo_ficha'] == 1) : ?>
                        <span>Ficha técnica - Área Médica</span>
                    <?php else : ?>
                        <span>Ficha técnica - Área Psicológica</span>
                    <?php endif; ?>
                </strong>
                <!-- <a href="add_ficha.php" class="btn btn-info pull-right">Agregar ficha</a> -->
            </div>

            <div class="panel-body">
                <table class="table table-dark table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="table-info">
                            <th class="text-center" style="width: 1%;">Folio</th>
                            <th class="text-center" style="width: 4%;">Función</th>
                            <th class="text-center" style="width: 3%;">No. Queja</th>
                            <th class="text-center" style="width: 4%;">Visitaduría</th>
                            <th class="text-center" style="width: 7%;">Área Solicitante</th>
                            <th class="text-center" style="width: 5%;">Ocupación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center"><?php echo remove_junk(ucwords($a_ficha['folio'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_ficha['funcion'])) ?></td>
                            <td class="text-center"><?php echo remove_junk(ucwords($a_ficha['num_queja'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_ficha['visitaduria'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_ficha['area_solicitante'])) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_ficha['ocupacion']))) ?></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-dark table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="table-info">
                            <th class="text-center" style="width: 3%;">Escolaridad</th>
                            <th class="text-center" style="width: 10%;">Presuntos Hechos Violatorios</th>
                            <th class="text-center" style="width: 7%;">Autoridad Responsable</th>
                            <th class="text-center" style="width: 7%;">Nombre de Usuario</th>
                            <th class="text-center" style="width: 1%;">Edad</th>
                            <th class="text-center" style="width: 1%;">Género</th>

                        </tr>
                    </thead>
                    <tbody>
                        <td><?php echo remove_junk(ucwords(($a_ficha['escolaridad']))) ?></td>
                        <td><?php echo remove_junk((($a_ficha['hechos']))) ?></td>
                        <td><?php echo remove_junk(ucwords(($a_ficha['autoridad']))) ?></td>
                        <td><?php echo remove_junk(ucwords(($a_ficha['nombre_usuario']))) ?></td>
                        <td class="text-center"><?php echo remove_junk(ucwords(($a_ficha['edad']))) ?></td>
                        <td class="text-center"><?php echo remove_junk(ucwords(($a_ficha['sexo']))) ?></td>

                    </tbody>
                </table>
                <table class="table table-dark table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="table-info">
                            <th class="text-center" style="width: 4%;">Grupo Vulnerable</th>
                            <th class="text-center" style="width: 2%">Fecha de Intervención</th>
                            <?php if ($a_ficha['protocolo_estambul'] != '') : ?>
                                <th class="text-center" style="width: 2%">Protocolo de Estambul</th>
                            <?php endif; ?>
                            <th class="text-center" style="width: 2%;">Resultado</th>
                            <th class="text-center" style="width: 2%;">Documento Emitido</th>
                            <th class="text-center" style="width: 7%;">Nombre del especialista que emitió</th>
                            <th class="text-center" style="width: 7%;">Clave del documento</th>
                            <th class="text-center" style="width: 5%;">Documento emitido</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo remove_junk(ucwords(($a_ficha['grupo_vulnerable']))) ?></td>
                            <td class="text-center"><?php echo remove_junk(ucwords(($a_ficha['fecha_intervencion']))) ?></td>
                            <?php if ($a_ficha['protocolo_estambul'] != '') : ?>
                                <td class="text-center"><?php echo remove_junk(ucwords(($a_ficha['protocolo_estambul']))) ?></td>
                            <?php endif; ?>
                            <td class="text-center"><?php echo remove_junk(ucwords(($a_ficha['resultado']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_ficha['documento_emitido']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_ficha['nombre_especialista']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_ficha['clave_documento']))) ?></td>
                            <?php
                            $folio_editar = $a_ficha['folio'];
                            $resultado = str_replace("/", "-", $folio_editar);
                            ?>
                            <td><a target="_blank" style="color: #23296B;" href="uploads/fichastecnicas/<?php echo $resultado . '/' . $a_ficha['ficha_adjunto']; ?>"><?php echo $a_ficha['ficha_adjunto']; ?></a></td>
                        </tr>
                    </tbody>
                </table>
                
                <?php if ($tipo_ficha['tipo_ficha'] == 1) : ?>
                    <a href="fichas.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                <?php else : ?>
                    <a href="fichas_psic.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>