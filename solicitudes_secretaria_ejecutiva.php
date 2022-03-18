<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Solicitudes - Secretaría Ejecutiva';
require_once('includes/load.php');
$user = current_user();
$id_usuario = $user['id'];

// page_require_level(10);
$id_user = $user['id'];
$busca_area = area_usuario($id_user);
$otro = $busca_area['id'];

// page_require_area(3);

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


?>

<?php
$c_categoria     = count_by_id('categorias');
$c_user          = count_by_id('users');
$c_trabajadores          = count_by_id('detalles_usuario');
$c_areas          = count_by_id('area');
$c_cargos          = count_by_id('cargos');
?>

<?php include_once('layouts/header.php'); ?>

<a href="solicitudes.php" class="btn btn-info">Regresar a Áreas</a>
<h1>Solicitudes de Secretaría Ejecutiva</h1>


<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="row" style="margin-top: 10px;">
    <?php if (($otro <= 3)) : ?>
        <div href="#" class="col-md-3" style="height: 12.5rem;">
            <div class="panel panel-box clearfix">
                <div class="panel-icon pull-left" style="background: #5AA82A;">
                    <svg style="width:59px;height:58px" viewBox="0 0 24 24">
                        <path fill="white" d="M14 2H6C4.9 2 4 2.9 4 4V20C4 21.1 4.9 22 6 22H18C19.1 22 20 21.1 20 20V8L14 2M18 20H6V4H13V9H18V20M9.5 18L10.2 15.2L8 13.3L10.9 13.1L12 10.4L13.1 13L16 13.2L13.8 15.1L14.5 17.9L12 16.5L9.5 18Z" />
                    </svg>
                </div>
                <div class="panel-value pull-right">
                    <p style="font-size: 20px; margin-top:8%;">Convenios</p>
                    <div><br>
                        <?php if (($nivel_user <= 2) || ($nivel_user == 3)) : ?>
                            <a href="add_convenio.php" class="btn btn-success">Agregar</a>
                        <?php endif; ?>
                        <a href="convenios.php" class="btn btn-primary">Ver</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>
</div>

<?php include_once('layouts/footer.php'); ?>