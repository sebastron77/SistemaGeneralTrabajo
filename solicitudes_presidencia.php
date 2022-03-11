<?php
$page_title = 'Solicitudes - Quejas';
require_once('includes/load.php');
$user = current_user();
$id_usuario = $user['id'];

// $user = current_user();
$id_user = $user['id'];
$busca_area = area_usuario($id_usuario);
$otro = $busca_area['id'];

page_require_level(2);

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
<h1>Solicitudes de Presidencia</h1>


<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>


<div class="row" style="margin-top: 10px;">
    <?php if (($otro <= 2)) : ?>
        <div class="col-md-3" style="height: 12.5rem;">
            <a href="quejas.php">
                <div class="panel panel-box clearfix">
                    <div class="panel-icon pull-left" style="background: #114987;">
                        <svg style="width:59px;height:58px" viewBox="0 0 24 24">
                            <path fill="white" d="M21,4H3A2,2 0 0,0 1,6V19A2,2 0 0,0 3,21H21A2,2 0 0,0 23,19V6A2,2 0 0,0 21,4M3,19V6H11V19H3M21,19H13V6H21V19M14,9.5H20V11H14V9.5M14,12H20V13.5H14V12M14,14.5H20V16H14V14.5Z" />
                        </svg>
                    </div>
                    <div class="panel-value pull-right">
                        <p style="font-size: 20px; margin-top:20%; color:#333333;">Resoluciones</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3" style="height: 12.5rem;">
            <a href="quejas.php">
                <div class="panel panel-box clearfix">
                    <div class="panel-icon pull-left" style="background: #114987;">
                        <svg style="width:59px;height:58px" viewBox="0 0 24 24">
                            <path fill="white" d="M21,4H3A2,2 0 0,0 1,6V19A2,2 0 0,0 3,21H21A2,2 0 0,0 23,19V6A2,2 0 0,0 21,4M3,19V6H11V19H3M21,19H13V6H21V19M14,9.5H20V11H14V9.5M14,12H20V13.5H14V12M14,14.5H20V16H14V14.5Z" />
                        </svg>
                    </div>
                    <div class="panel-value pull-right">
                        <p style="font-size: 20px; margin-top:20%; color:#333333;">Consejo de la CEDH</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3" style="height: 12.5rem;">
            <a href="quejas.php">
                <div class="panel panel-box clearfix">
                    <div class="panel-icon pull-left" style="background: #114987;">
                        <svg style="width:59px;height:58px" viewBox="0 0 24 24">
                            <path fill="white" d="M21,4H3A2,2 0 0,0 1,6V19A2,2 0 0,0 3,21H21A2,2 0 0,0 23,19V6A2,2 0 0,0 21,4M3,19V6H11V19H3M21,19H13V6H21V19M14,9.5H20V11H14V9.5M14,12H20V13.5H14V12M14,14.5H20V16H14V14.5Z" />
                        </svg>
                    </div>
                    <div class="panel-value pull-right">
                        <p style="font-size: 20px; margin-top:10%; color:#333333;">Recepción General de Correspondencia</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3" style="height: 12.5rem;">
            <a href="quejas.php">
                <div class="panel panel-box clearfix">
                    <div class="panel-icon pull-left" style="background: #114987;">
                        <svg style="width:59px;height:58px" viewBox="0 0 24 24">
                            <path fill="white" d="M21,4H3A2,2 0 0,0 1,6V19A2,2 0 0,0 3,21H21A2,2 0 0,0 23,19V6A2,2 0 0,0 21,4M3,19V6H11V19H3M21,19H13V6H21V19M14,9.5H20V11H14V9.5M14,12H20V13.5H14V12M14,14.5H20V16H14V14.5Z" />
                        </svg>
                    </div>
                    <div class="panel-value pull-right">
                        <p style="font-size: 20px; margin-top:20%; color:#333333;">Convenio de Colaboración</p>
                    </div>
                </div>
            </a>
        </div>
    <?php endif ?>
</div>
<div class="row" style="margin-top: 10px;">
    <?php if (($otro <= 2)) : ?>
        <div class="col-md-3" style="height: 12.5rem;">
            <a href="quejas.php">
                <div class="panel panel-box clearfix">
                    <div class="panel-icon pull-left" style="background: #114987;">
                        <svg style="width:59px;height:58px" viewBox="0 0 24 24">
                            <path fill="white" d="M21,4H3A2,2 0 0,0 1,6V19A2,2 0 0,0 3,21H21A2,2 0 0,0 23,19V6A2,2 0 0,0 21,4M3,19V6H11V19H3M21,19H13V6H21V19M14,9.5H20V11H14V9.5M14,12H20V13.5H14V12M14,14.5H20V16H14V14.5Z" />
                        </svg>
                    </div>
                    <div class="panel-value pull-right">
                        <p style="font-size: 20px; margin-top:20%; color:#333333;">Unidad de Gestión de Recursos</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3" style="height: 12.5rem;">
            <a href="quejas.php">
                <div class="panel panel-box clearfix">
                    <div class="panel-icon pull-left" style="background: #114987;">
                        <svg style="width:59px;height:58px" viewBox="0 0 24 24">
                            <path fill="white" d="M21,4H3A2,2 0 0,0 1,6V19A2,2 0 0,0 3,21H21A2,2 0 0,0 23,19V6A2,2 0 0,0 21,4M3,19V6H11V19H3M21,19H13V6H21V19M14,9.5H20V11H14V9.5M14,12H20V13.5H14V12M14,14.5H20V16H14V14.5Z" />
                        </svg>
                    </div>
                    <div class="panel-value pull-right">
                        <p style="font-size: 20px; margin-top:20%; color:#333333;">Gestiones Jurisdiccionales</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3" style="height: 12.5rem;">
            <a href="quejas.php">
                <div class="panel panel-box clearfix">
                    <div class="panel-icon pull-left" style="background: #114987;">
                        <svg style="width:59px;height:58px" viewBox="0 0 24 24">
                            <path fill="white" d="M21,4H3A2,2 0 0,0 1,6V19A2,2 0 0,0 3,21H21A2,2 0 0,0 23,19V6A2,2 0 0,0 21,4M3,19V6H11V19H3M21,19H13V6H21V19M14,9.5H20V11H14V9.5M14,12H20V13.5H14V12M14,14.5H20V16H14V14.5Z" />
                        </svg>
                    </div>
                    <div class="panel-value pull-right">
                        <p style="font-size: 20px; margin-top:10%; color:#333333;">Informe Anual de Actividades</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3" style="height: 12.5rem;">
            <a href="quejas.php">
                <div class="panel panel-box clearfix">
                    <div class="panel-icon pull-left" style="background: #114987;">
                        <svg style="width:59px;height:58px" viewBox="0 0 24 24">
                            <path fill="white" d="M21,4H3A2,2 0 0,0 1,6V19A2,2 0 0,0 3,21H21A2,2 0 0,0 23,19V6A2,2 0 0,0 21,4M3,19V6H11V19H3M21,19H13V6H21V19M14,9.5H20V11H14V9.5M14,12H20V13.5H14V12M14,14.5H20V16H14V14.5Z" />
                        </svg>
                    </div>
                    <div class="panel-value pull-right">
                        <p style="font-size: 20px; margin-top:20%; color:#333333;">Programa Operativo Anual (POA)</p>
                    </div>
                </div>
            </a>
        </div>
    <?php endif ?>
</div>
<div class="row" style="margin-top: 10px;">
    <?php if (($otro <= 2)) : ?>
        <div class="col-md-3" style="height: 12.5rem;">
            <a href="quejas.php">
                <div class="panel panel-box clearfix">
                    <div class="panel-icon pull-left" style="background: #114987;">
                        <svg style="width:59px;height:58px" viewBox="0 0 24 24">
                            <path fill="white" d="M21,4H3A2,2 0 0,0 1,6V19A2,2 0 0,0 3,21H21A2,2 0 0,0 23,19V6A2,2 0 0,0 21,4M3,19V6H11V19H3M21,19H13V6H21V19M14,9.5H20V11H14V9.5M14,12H20V13.5H14V12M14,14.5H20V16H14V14.5Z" />
                        </svg>
                    </div>
                    <div class="panel-value pull-right">
                        <p style="font-size: 20px; margin-top:20%; color:#333333;">Plan estratégico Institucional</p>
                    </div>
                </div>
            </a>
        </div>
    <?php endif ?>
</div>

<?php include_once('layouts/footer.php'); ?>