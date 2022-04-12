<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Solicitudes - Quejas';
require_once('includes/load.php');
$user = current_user();
$id_usuario = $user['id'];

$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
$nivel_user = $user['user_level'];

if ($nivel_user <= 2) {
    page_require_level(2);
}
if ($nivel_user == 5) {
    page_require_level_exacto(5);
}
if ($nivel_user == 7) {
    page_require_level_exacto(7);
}
if ($nivel_user > 2 && $nivel_user < 5) :
    redirect('home.php');
endif;
if ($nivel_user > 5 && $nivel_user < 7) :
    redirect('home.php');
endif;
if ($nivel_user > 7) :
    redirect('home.php');
endif;
?>

<?php
$c_categoria     = count_by_id('categorias');
$c_user          = count_by_id('users');
$c_trabajadores          = count_by_id('detalles_usuario');
$c_areas          = count_by_id('area');
$c_cargos          = count_by_id('cargos');
?>

<?php include_once('layouts/header.php'); ?>

<a href="solicitudes.php" class="btn btn-info">Regresar a Áreas</a><br><br>
<!-- <h1>Solicitudes de Orientación Legal, Quejas y Seguimiento</h1> -->


<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>


<div class="row" style="margin-top: 10px;">
    <?php if (($otro == 5) || ($otro <= 2)) : ?>
        <div class="col-md-3" style="height: 12.5rem;">
            <a href="quejas.php">
                <div class="panel panel-box clearfix">
                    <div class="panel-icon pull-left" style="background: #114987;">
                        <svg style="width:59px;height:58px" viewBox="0 0 24 24">
                            <path fill="white" d="M21,4H3A2,2 0 0,0 1,6V19A2,2 0 0,0 3,21H21A2,2 0 0,0 23,19V6A2,2 0 0,0 21,4M3,19V6H11V19H3M21,19H13V6H21V19M14,9.5H20V11H14V9.5M14,12H20V13.5H14V12M14,14.5H20V16H14V14.5Z" />
                        </svg>
                    </div>
                    <div class="panel-value pull-right">
                        <p style="font-size: 20px; margin-top:20%; color:#333333;">Quejas</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3" style="height: 12.5rem;">
            <div class="panel panel-box clearfix">
                <div class="panel-icon pull-left" style="background: #114987;">
                    <svg style="width:59px;height:58px" viewBox="0 0 24 24">
                        <path fill="white" d="M16.75 4.36C18.77 6.56 18.77 9.61 16.75 11.63L15.07 9.94C15.91 8.76 15.91 7.23 15.07 6.05L16.75 4.36M20.06 1C24 5.05 23.96 11.11 20.06 15L18.43 13.37C21.2 10.19 21.2 5.65 18.43 2.63L20.06 1M9 4C11.2 4 13 5.79 13 8S11.2 12 9 12 5 10.21 5 8 6.79 4 9 4M13 14.54C13 15.6 12.71 18.07 10.8 20.83L10 16L10.93 14.12C10.31 14.05 9.66 14 9 14S7.67 14.05 7.05 14.12L8 16L7.18 20.83C5.27 18.07 5 15.6 5 14.54C2.6 15.24 .994 16.5 .994 18V22H17V18C17 16.5 15.39 15.24 13 14.54Z" />
                    </svg>
                </div>
                <div>
                    <p style="font-size: 20px; margin-top:5%;">Orientación</p>
                    <div><br>
                        <?php if (($nivel <= 2) || ($nivel == 5)) : ?>
                            <a href="add_orientacion.php" class="btn btn-success">Agregar</a>
                        <?php endif; ?>
                        <a href="orientaciones.php" class="btn btn-primary">Ver</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3" style="height: 12.5rem;">
            <div class="panel panel-box clearfix">
                <div class="panel-icon pull-left" style="background: #114987;">
                    <svg style="width:59px;height:58px" viewBox="0 0 24 24">
                        <path fill="white" d="M8,14V18L2,12L8,6V10H16V6L22,12L16,18V14H8Z" />
                    </svg>
                </div>
                <div>
                    <p style="font-size: 20px; margin-top:5%;">Canalización</p>
                    <div><br>
                        <?php if (($nivel <= 2) || ($nivel == 5)) : ?>
                            <a href="add_canalizacion.php" class="btn btn-success">Agregar</a>
                        <?php endif; ?>
                        <a href="canalizaciones.php" class="btn btn-primary">Ver</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3" style="height: 12.5rem;">
            <div class="panel panel-box clearfix">
                <div class="panel-icon pull-left" style="background: #114987;">
                    <svg style="width:59px;height:58px" viewBox="0 0 24 24">
                        <path fill="white" d="M19.7 12.9L14 18.6H11.7V16.3L17.4 10.6L19.7 12.9M23.1 12.1C23.1 12.4 22.8 12.7 22.5 13L20 15.5L19.1 14.6L21.7 12L21.1 11.4L20.4 12.1L18.1 9.8L20.3 7.7C20.5 7.5 20.9 7.5 21.2 7.7L22.6 9.1C22.8 9.3 22.8 9.7 22.6 10C22.4 10.2 22.2 10.4 22.2 10.6C22.2 10.8 22.4 11 22.6 11.2C22.9 11.5 23.2 11.8 23.1 12.1M3 20V4H10V9H15V10.5L17 8.5V8L11 2H3C1.9 2 1 2.9 1 4V20C1 21.1 1.9 22 3 22H15C16.1 22 17 21.1 17 20H3M11 17.1C10.8 17.1 10.6 17.2 10.5 17.2L10 15H8.5L6.4 16.7L7 14H5.5L4.5 19H6L8.9 16.4L9.5 18.7H10.5L11 18.6V17.1Z" />
                    </svg>
                </div>
                <div>
                    <p style="font-size: 20px; margin-top:1%;">Acuerdos de No Violación</p>
                    <div>
                        <a href="acuerdos_no_violacion.php" class="btn btn-primary">Ver</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>
</div><br>
<div class="row">
    <div class="col-md-3" style="height: 12.5rem;">
        <div class="panel panel-box clearfix">
            <div class="panel-icon pull-left" style="background: #114987;">
                <svg style="width:59px;height:58px" viewBox="0 0 24 24">
                    <path fill="white" d="M16.75 4.36C18.77 6.56 18.77 9.61 16.75 11.63L15.07 9.94C15.91 8.76 15.91 7.23 15.07 6.05L16.75 4.36M20.06 1C24 5.05 23.96 11.11 20.06 15L18.43 13.37C21.2 10.19 21.2 5.65 18.43 2.63L20.06 1M9 4C11.2 4 13 5.79 13 8S11.2 12 9 12 5 10.21 5 8 6.79 4 9 4M13 14.54C13 15.6 12.71 18.07 10.8 20.83L10 16L10.93 14.12C10.31 14.05 9.66 14 9 14S7.67 14.05 7.05 14.12L8 16L7.18 20.83C5.27 18.07 5 15.6 5 14.54C2.6 15.24 .994 16.5 .994 18V22H17V18C17 16.5 15.39 15.24 13 14.54Z" />
                </svg>
            </div>
            <div>
                <p style="font-size: 18px; margin-top:5%;">Recomendaciones</p>
                <div>
                    <a href="recomendaciones.php" class="btn btn-primary">Ver</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>