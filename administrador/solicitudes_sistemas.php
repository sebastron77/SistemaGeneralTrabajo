<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Secretaría Coordinación de Sistemas';
require_once('includes/load.php');
$user = current_user();
$id_usuario = $user['id'];

// $user = current_user();
$id_user = $user['id'];
$busca_area = area_usuario($id_usuario);
$otro = $busca_area['id'];

$nivel_user = $user['user_level'];
if ($nivel_user <= 2) {
    page_require_level(2);
}
if ($nivel_user == 7) {
    page_require_level_exacto(7);
}
if ($nivel_user > 2 && $nivel_user < 7) :
    redirect('home.php');
endif;

// page_require_level(2);
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
<h1>Solicitudes de Coordinación de Sistemas de Informática</h1>


<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>


<div class="row" style="margin-top: 10px;">
    <div class="col-md-3" style="height: 13.5rem;">
        <div class="panel panel-box clearfix">
            <div class="panel-icon pull-left" style="background: #114987;">
                <svg style="width:59px;height:68px" viewBox="0 0 24 24">
                    <path fill="white" d="M13 3C16.9 3 20 6.1 20 10C20 12.8 18.4 15.2 16 16.3V21H9V18H8C6.9 18 6 17.1 6 16V13H4.5C4.1 13 3.8 12.5 4.1 12.2L6 9.7C6.2 5.9 9.2 3 13 3M13 1C8.4 1 4.6 4.4 4.1 8.9L2.5 11C1.9 11.7 1.8 12.7 2.2 13.6C2.6 14.3 3.2 14.8 4 15V16C4 17.9 5.3 19.4 7 19.9V23H18V17.5C20.5 15.9 22 13.1 22 10C22 5 18 1 13 1M17 10H14V13H12V10H9V8H12V5H14V8H17V10Z" />
                </svg>
            </div>
            <div class="panel-value pull-right">
                <p style="font-size: 20px; margin-top:8%;">Capacitación</p>
                <div>
                    <?php if (($nivel_user <= 2)) : ?>
                        <a href="add_capacitacion.php" class="btn btn-success btn-sm"">Agregar</a>
                    <?php endif; ?>
                    <a href="capacitaciones.php" class="btn btn-primary btn-sm"">Ver</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3" style="height: 13.5rem;">
        <div class="panel panel-box clearfix">
            <div class="panel-icon pull-left" style="background: #114987;">
                <svg style="width:40px;height:68px " viewBox="0 0 24 24">
                    <path fill="white" d="M19,20H5V9H19M16,2V4H8V2H6V4H5A2,2 0 0,0 3,6V20A2,2 0 0,0 5,22H19A2,2 0 0,0 21,20V6A2,2 0 0,0 19,4H18V2M10.88,13H7.27L10.19,15.11L9.08,18.56L12,16.43L14.92,18.56L13.8,15.12L16.72,13H13.12L12,9.56L10.88,13Z" />
                </svg>
            </div>
            <div class="panel-value pull-right">
                <p style="font-size: 18px; margin-top:10%; color:#333333;">Eventos</p>
                <div style="margin-top:-3%;">
                    <?php if (($nivel_user <= 2)) : ?>
                        <a style="margin-top:5%;" href="add_evento.php" class="btn btn-success btn-sm">Agregar</a>
                    <?php endif; ?>
                    <a style="margin-top:5%;"  href="eventos.php" class="btn btn-primary btn-sm">Ver</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3" style="height: 13.5rem;">
        <div class="panel panel-box clearfix">
            <div class="panel-icon pull-left" style="background: #114987;">
                <svg style="width:40px;height:68px" viewBox="0 0 24 24">
                    <path fill="white" d="M19,3H18V1H16V3H8V1H6V3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H10V19H5V8H19V9H21V5A2,2 0 0,0 19,3M21.7,13.35L20.7,14.35L18.65,12.35L19.65,11.35C19.85,11.14 20.19,11.13 20.42,11.35L21.7,12.63C21.89,12.83 21.89,13.15 21.7,13.35M12,18.94L18.07,12.88L20.12,14.88L14.06,21H12V18.94Z" />
                </svg>
            </div>
            <div class="panel-value pull-right">
                <p style="font-size: 16px; margin-top:5%; color:#333333;">Informe de Actividades</p>
                <div style="margin-top:-4%;">
                    <?php if ($nivel_user <= 2) : ?>
                        <a style="margin-top:5%;"  href="add_informe_sistemas.php" class="btn btn-success btn-sm">Agregar</a>
                    <?php endif; ?>
                    <a style="margin-top:5%;"  href="informes_sistemas.php" class="btn btn-primary btn-sm">Ver</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>