<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Solicitudes - Área Médica y Psicológica';
require_once('includes/load.php');
$user = current_user();
$id_usuario = $user['id'];

// $user = current_user();
$id_user = $user['id'];
$busca_area = area_usuario($id_usuario);
$otro = $busca_area['id'];

$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
$nivel_user = $user['user_level'];

if ($nivel_user <= 2) {
    page_require_level(2);
}
if ($nivel_user == 4) {
    page_require_level_exacto(4);
}
if ($nivel_user == 7) {
    page_require_level_exacto(7);
}
if ($nivel_user > 2 && $nivel_user < 4):
    redirect('home.php');
  endif;
  if ($nivel_user > 4 && $nivel_user < 7):
    redirect('home.php');
  endif;
  if ($nivel_user > 7):
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
<h1>Solicitudes de Área Médica y Psicológica</h1>


<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="row" style="margin-top: 10px;">
    <?php if (($otro == 4) || ($otro <= 2)) : ?>
        <div class="col-md-3" style="height: 12.5rem;">
            <div class="panel panel-box clearfix">
                <div class="panel-icon pull-left" style="background: #114987; display: grid; place-content: center;">
                    <svg style="width:40px;height:63px" viewBox="0 0 24 24">
                        <path fill="white" d="M18,14H14V18H10V14H6V10H10V6H14V10H18M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
                    </svg>
                </div>
                <div>
                    <p style="font-size: 16px; margin-top:3%;">Fichas Técnicas</p>
                    <div style="margin-top:-5%;">
                        <?php if (($nivel <= 2) || ($nivel == 4)) : ?>
                            <a style="margin-top:3%;" href="add_ficha.php" class="btn btn-success btn-sm">Agregar</a>
                        <?php endif; ?>
                        <a style="margin-top:3%;" href="fichas.php" class="btn btn-primary btn-sm">Ver</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3" style="height: 12.5rem;">
            <div class="panel panel-box clearfix">
                <div class="panel-icon pull-left" style="background: #114987; display: grid; place-content: center;">
                    <svg style="width:40px;height:63px" viewBox="0 0 24 24">
                        <path fill="white" d="M13 3C16.9 3 20 6.1 20 10C20 12.8 18.4 15.2 16 16.3V21H9V18H8C6.9 18 6 17.1 6 16V13H4.5C4.1 13 3.8 12.5 4.1 12.2L6 9.7C6.2 5.9 9.2 3 13 3M13 1C8.4 1 4.6 4.4 4.1 8.9L2.5 11C1.9 11.7 1.8 12.7 2.2 13.6C2.6 14.3 3.2 14.8 4 15V16C4 17.9 5.3 19.4 7 19.9V23H18V17.5C20.5 15.9 22 13.1 22 10C22 5 18 1 13 1M17 10H14V13H12V10H9V8H12V5H14V8H17V10Z" />
                    </svg>
                </div>
                <div class="panel-value pull-right">
                    <p style="font-size: 16px; margin-top:8%;">Capacitación</p>
                    <div style="margin-top:-5%;">
                        <?php if (($nivel <= 2) || ($nivel == 4)) : ?>
                            <a style="margin-top:5%;" href="add_capacitacion.php" class="btn btn-success btn-sm">Agregar</a>
                        <?php endif; ?>
                        <a style="margin-top:5%;" href="capacitaciones.php" class="btn btn-primary btn-sm">Ver</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>
</div>

<?php include_once('layouts/footer.php'); ?>