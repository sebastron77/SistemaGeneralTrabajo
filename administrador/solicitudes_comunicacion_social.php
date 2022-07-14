<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Solicitudes - Comunicación Social';
require_once('includes/load.php');
$user = current_user();
$id_usuario = $user['id'];

// $user = current_user();
// $id_user = $user['id'];
// $busca_area = area_usuario($id_usuario);
// $otro = $busca_area['id'];

$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
$nivel_user = $user['user_level'];

// if ($nivel_user <= 2) {
//     page_require_level(2);
// }
// if ($nivel_user == 15) {
//     page_require_level_exacto(15);
// }
// if ($nivel_user == 7) {
//     page_require_level_exacto(7);
// }
if (($nivel_user > 2 && $nivel_user < 7)) :
    redirect('home.php');
endif;
if (($nivel_user > 7 && $nivel_user < 15)) :
    redirect('home.php');
endif;
if ($nivel_user > 15) :
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

<a href="solicitudes.php" class="btn btn-info">Regresar a Áreas</a>
<h1>Solicitudes Comunicación Social</h1>


<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="row" style="margin-top: 10px;">
    <div class="col-md-3" style="height: 12.5rem;">
        <div class="panel panel-box clearfix">
            <div class="panel-icon pull-left" style="background: #114987; display: grid; place-content: center;">
                <svg style="width:40px;height:63px" viewBox="0 0 24 24">
                    <path fill="white" d="M17,4H7A5,5 0 0,0 2,9V20H20A2,2 0 0,0 22,18V9A5,5 0 0,0 17,4M10,18H4V9A3,3 0 0,1 7,6A3,3 0 0,1 10,9V18M19,15H17V13H13V11H19V15M9,11H5V9H9V11Z" />
                </svg>
            </div>
            <div class="panel-value pull-right">
                <p style="font-size: 15px; margin-top:5%; color:#333333; line-height: 100%;">Correspon-<br>dencia</p>
                <div style="margin-top:-5%;">
                    <?php if (($nivel <= 2) || ($nivel == 18)) : ?>
                    <a style="margin-top:5%;" href="add_correspondencia.php" class="btn btn-success btn-sm">Agregar</a>
                    <?php endif; ?>
                    <a style="margin-top:5%;" href="correspondencia.php" class="btn btn-primary btn-sm">Ver</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3" style="height: 13.5rem;">
        <div class="panel panel-box clearfix">
            <div class="panel-icon pull-left" style="background: #114987; display: grid; place-content: center;">
                <svg style="width:40px;height:73px" viewBox="0 0 24 24">
                    <path fill="white" d="M17,4H7A5,5 0 0,0 2,9V20H20A2,2 0 0,0 22,18V9A5,5 0 0,0 17,4M10,18H4V9A3,3 0 0,1 7,6A3,3 0 0,1 10,9V18M19,15H17V13H13V11H19V15M9,11H5V9H9V11Z" />
                </svg>
            </div>
            <div class="panel-value pull-right">
                <p style="font-size: 15px; margin-top:2%; color:#333333; line-height: 100%;">Envío de Correspon-<br>dencia Interna</p>
                <div style="margin-top:-5%;">
                    
                        <a style="margin-top:5%;" href="add_env_correspondencia.php" class="btn btn-success btn-sm">Agregar</a>
                    
                    <a style="margin-top:5%;" href="env_correspondencia.php" class="btn btn-primary btn-sm">Ver</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3" style="height: 13.5rem;">
        <div class="panel panel-box clearfix">
            <div class="panel-icon pull-left" style="background: #114987; display: grid; place-content: center;">
                <svg style="width:40px;height:72px" viewBox="0 0 24 24">
                    <path fill="white" d="M19,3H18V1H16V3H8V1H6V3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H10V19H5V8H19V9H21V5A2,2 0 0,0 19,3M21.7,13.35L20.7,14.35L18.65,12.35L19.65,11.35C19.85,11.14 20.19,11.13 20.42,11.35L21.7,12.63C21.89,12.83 21.89,13.15 21.7,13.35M12,18.94L18.07,12.88L20.12,14.88L14.06,21H12V18.94Z" />
                </svg>
            </div>
            <div class="panel-value pull-right">
                <p style="font-size: 16px; margin-top:5%; color:#333333;">Informe de Actividades</p>
                <div style="margin-top:-4%;">
                    <?php //if ($nivel_user <= 2) : ?>
                        <a style="margin-top:5%;" href="add_informe_areas.php" class="btn btn-success btn-sm">Agregar</a>
                    <?php //endif; ?>
                    <a style="margin-top:5%;" href="informes_areas.php" class="btn btn-primary btn-sm">Ver</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3" style="height: 13.5rem;">
        <div class="panel panel-box clearfix">
            <div class="panel-icon pull-left" style="background: #114987; display: grid; place-content: center;">
                <svg style="width:40px;height:72px" viewBox="0 0 24 24">
                    <path fill="white" d="M19,3H18V1H16V3H8V1H6V3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H10V19H5V8H19V9H21V5A2,2 0 0,0 19,3M21.7,13.35L20.7,14.35L18.65,12.35L19.65,11.35C19.85,11.14 20.19,11.13 20.42,11.35L21.7,12.63C21.89,12.83 21.89,13.15 21.7,13.35M12,18.94L18.07,12.88L20.12,14.88L14.06,21H12V18.94Z" />
                </svg>
            </div>
            <div class="panel-value pull-right">
                <p style="font-size: 16px; margin-top:5%; color:#333333;">Informe Trimestral/<br>Anual</p>
                <div style="margin-top:-10%;">
                    <?php //if ($nivel_user <= 2) : ?>
                        <a style="margin-top:5%;" href="add_informe.php" class="btn btn-success btn-sm">Agregar</a>
                    <?php //endif; ?>
                    <a style="margin-top:5%;" href="informes.php" class="btn btn-primary btn-sm">Ver</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>