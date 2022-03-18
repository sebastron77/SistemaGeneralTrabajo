<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Presidencia';
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
<h1>Solicitudes de Presidencia</h1>


<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>


<div class="row" style="margin-top: 10px;">
    <div class="col-md-3" style="height: 12.5rem;">
        <div class="panel panel-box clearfix">
            <div class="panel-icon pull-left" style="background: #114987;">
                <svg style="width:40px;height:58px" viewBox="0 0 24 24">
                    <path fill="white" d="M7.5,5.6L5,7L6.4,4.5L5,2L7.5,3.4L10,2L8.6,4.5L10,7L7.5,5.6M19.5,15.4L22,14L20.6,16.5L22,19L19.5,17.6L17,19L18.4,16.5L17,14L19.5,15.4M22,2L20.6,4.5L22,7L19.5,5.6L17,7L18.4,4.5L17,2L19.5,3.4L22,2M13.34,12.78L15.78,10.34L13.66,8.22L11.22,10.66L13.34,12.78M14.37,7.29L16.71,9.63C17.1,10 17.1,10.65 16.71,11.04L5.04,22.71C4.65,23.1 4,23.1 3.63,22.71L1.29,20.37C0.9,20 0.9,19.35 1.29,18.96L12.96,7.29C13.35,6.9 14,6.9 14.37,7.29Z" />
                </svg>
            </div>
            <div class="panel-value pull-right">
                <p style="font-size: 17px; margin-top:5%; color:#333333;">Resoluciones</p>
                <div style="margin-top:-4%;">
                    <?php if ($nivel_user <= 2) : ?>
                        <a href="add_resolucion.php" class="btn btn-success">Agregar</a>
                    <?php endif; ?>
                    <a href="resoluciones.php" class="btn btn-primary">Ver</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3" style="height: 12.5rem;">
        <div class="panel panel-box clearfix">
            <div class="panel-icon pull-left" style="background: #114987;">
                <svg style="width:40px;height:58px" viewBox="0 0 24 24">
                    <path fill="white" d="M12,5.5A3.5,3.5 0 0,1 15.5,9A3.5,3.5 0 0,1 12,12.5A3.5,3.5 0 0,1 8.5,9A3.5,3.5 0 0,1 12,5.5M5,8C5.56,8 6.08,8.15 6.53,8.42C6.38,9.85 6.8,11.27 7.66,12.38C7.16,13.34 6.16,14 5,14A3,3 0 0,1 2,11A3,3 0 0,1 5,8M19,8A3,3 0 0,1 22,11A3,3 0 0,1 19,14C17.84,14 16.84,13.34 16.34,12.38C17.2,11.27 17.62,9.85 17.47,8.42C17.92,8.15 18.44,8 19,8M5.5,18.25C5.5,16.18 8.41,14.5 12,14.5C15.59,14.5 18.5,16.18 18.5,18.25V20H5.5V18.25M0,20V18.5C0,17.11 1.89,15.94 4.45,15.6C3.86,16.28 3.5,17.22 3.5,18.25V20H0M24,20H20.5V18.25C20.5,17.22 20.14,16.28 19.55,15.6C22.11,15.94 24,17.11 24,18.5V20Z" />
                </svg>
            </div>
            <div class="panel-value pull-right">
                <p style="font-size: 17px; margin-top:1%; color:#333333;">Consejo de la CEDH</p>
                <div style="margin-top:-6%;">
                    <?php if ($nivel_user <= 2) : ?>
                        <a href="add_consejo.php" class="btn btn-success">Agregar</a>
                    <?php endif; ?>
                    <a href="consejo.php" class="btn btn-primary">Ver</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3" style="height: 12.5rem;">
        <div class="panel panel-box clearfix">
            <div class="panel-icon pull-left" style="background: #114987;">
                <svg style="width:40px;height:60px" viewBox="0 0 24 24">
                    <path fill="white" d="M17,4H7A5,5 0 0,0 2,9V20H20A2,2 0 0,0 22,18V9A5,5 0 0,0 17,4M10,18H4V9A3,3 0 0,1 7,6A3,3 0 0,1 10,9V18M19,15H17V13H13V11H19V15M9,11H5V9H9V11Z" />
                </svg>
            </div>
            <div class="panel-value pull-right">
                <p style="font-size: 17px; margin-top:2%; color:#333333;">Recepción General de Correspondencia</p>
                <div style="margin-top:-4%;">
                    <a href="correspondencia.php" class="btn btn-secondary btn-sm" style="margin-top: 3px;">Correspondencia</a>
                    <a href="invitaciones.php" class="btn btn-secondary btn-sm" style="margin-top: 3px;">Invitaciones</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3" style="height: 12.5rem;">
        <div class="panel panel-box clearfix">
            <div class="panel-icon pull-left" style="background: #114987;">
                <svg style="width:40px;height:63px" viewBox="0 0 24 24">
                    <path fill="white" d="M16 9C22 9 22 13 22 13V15H16V13C16 13 16 11.31 14.85 9.8C14.68 9.57 14.47 9.35 14.25 9.14C14.77 9.06 15.34 9 16 9M8 11C11.5 11 11.94 12.56 12 13H4C4.06 12.56 4.5 11 8 11M8 9C2 9 2 13 2 13V15H14V13C14 13 14 9 8 9M9 17V19H15V17L18 20L15 23V21H9V23L6 20L9 17M8 3C8.55 3 9 3.45 9 4S8.55 5 8 5 7 4.55 7 4 7.45 3 8 3M8 1C6.34 1 5 2.34 5 4S6.34 7 8 7 11 5.66 11 4 9.66 1 8 1M16 1C14.34 1 13 2.34 13 4S14.34 7 16 7 19 5.66 19 4 17.66 1 16 1Z" />
                </svg>
            </div>
            <div class="panel-value pull-right">
                <p style="font-size: 17px; margin-top:5%; color:#333333;">Convenio de Colaboración</p>
                <div style="margin-top:-6%;">
                    <?php if ($nivel_user <= 2) : ?>
                        <a href="add_convenio.php" class="btn btn-success">Agregar</a>
                    <?php endif; ?>
                    <a href="convenios.php" class="btn btn-primary">Ver</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" style="margin-top: 10px;">
    <div class="col-md-3" style="height: 12.5rem;">
        <div class="panel panel-box clearfix">
            <div class="panel-icon pull-left" style="background: #114987;">
                <svg style="width:40px;height:60px" viewBox="0 0 24 24">
                    <path fill="white" d="M19,11H13V5H19M19,19H13V13H19M11,11H5V5H11M11,19H5V13H11M3,21H21V3H3V21Z" />
                </svg>
            </div>
            <div class="panel-value pull-right">
                <p style="font-size: 17px; margin-top:15%; color:#333333;">Unidad de Gestión de Recursos</p>
            </div>
        </div>
    </div>
    <div class="col-md-3" style="height: 12.5rem;">
        <div class="panel panel-box clearfix">
            <div class="panel-icon pull-left" style="background: #114987;">
                <svg style="width:40px;height:60px" viewBox="0 0 24 24">
                    <path fill="white" d="M2.3,20.28L11.9,10.68L10.5,9.26L9.78,9.97C9.39,10.36 8.76,10.36 8.37,9.97L7.66,9.26C7.27,8.87 7.27,8.24 7.66,7.85L13.32,2.19C13.71,1.8 14.34,1.8 14.73,2.19L15.44,2.9C15.83,3.29 15.83,3.92 15.44,4.31L14.73,5L16.15,6.43C16.54,6.04 17.17,6.04 17.56,6.43C17.95,6.82 17.95,7.46 17.56,7.85L18.97,9.26L19.68,8.55C20.07,8.16 20.71,8.16 21.1,8.55L21.8,9.26C22.19,9.65 22.19,10.29 21.8,10.68L16.15,16.33C15.76,16.72 15.12,16.72 14.73,16.33L14.03,15.63C13.63,15.24 13.63,14.6 14.03,14.21L14.73,13.5L13.32,12.09L3.71,21.7C3.32,22.09 2.69,22.09 2.3,21.7C1.91,21.31 1.91,20.67 2.3,20.28M20,19A2,2 0 0,1 22,21V22H12V21A2,2 0 0,1 14,19H20Z" />
                </svg>
            </div>
            <div class="panel-value pull-right">
                <p style="font-size: 17px; margin-top:5%; color:#333333;">Gestiones Jurisdiccionales</p>
            </div>
        </div>
    </div>
    <div class="col-md-3" style="height: 12.5rem;">
        <div class="panel panel-box clearfix">
            <div class="panel-icon pull-left" style="background: #114987;">
                <svg style="width:40px;height:60px" viewBox="0 0 24 24">
                    <path fill="white" d="M19,3H18V1H16V3H8V1H6V3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H10V19H5V8H19V9H21V5A2,2 0 0,0 19,3M21.7,13.35L20.7,14.35L18.65,12.35L19.65,11.35C19.85,11.14 20.19,11.13 20.42,11.35L21.7,12.63C21.89,12.83 21.89,13.15 21.7,13.35M12,18.94L18.07,12.88L20.12,14.88L14.06,21H12V18.94Z" />
                </svg>
            </div>
            <div class="panel-value pull-right">
                <p style="font-size: 17px; margin-top:5%; color:#333333;">Informe Anual de Actividades</p>
                <div style="margin-top:-4%;">
                    <?php if ($nivel_user <= 2) : ?>
                        <a href="add_informe.php" class="btn btn-success">Agregar</a>
                    <?php endif; ?>
                    <a href="informes.php" class="btn btn-primary">Ver</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3" style="height: 12.5rem;">
        <div class="panel panel-box clearfix">
            <div class="panel-icon pull-left" style="background: #114987;">
                <svg style="width:40px;height:60px" viewBox="0 0 24 24">
                    <path fill="white" d="M19 1L14 6V17L19 12.5V1M21 5V18.5C19.9 18.15 18.7 18 17.5 18C15.8 18 13.35 18.65 12 19.5V6C10.55 4.9 8.45 4.5 6.5 4.5C4.55 4.5 2.45 4.9 1 6V20.65C1 20.9 1.25 21.15 1.5 21.15C1.6 21.15 1.65 21.1 1.75 21.1C3.1 20.45 5.05 20 6.5 20C8.45 20 10.55 20.4 12 21.5C13.35 20.65 15.8 20 17.5 20C19.15 20 20.85 20.3 22.25 21.05C22.35 21.1 22.4 21.1 22.5 21.1C22.75 21.1 23 20.85 23 20.6V6C22.4 5.55 21.75 5.25 21 5M10 18.41C8.75 18.09 7.5 18 6.5 18C5.44 18 4.18 18.19 3 18.5V7.13C3.91 6.73 5.14 6.5 6.5 6.5C7.86 6.5 9.09 6.73 10 7.13V18.41Z" />
                </svg>
            </div>
            <div class="panel-value pull-right">
                <p style="font-size: 17px; margin-top:10%; color:#333333;">Programa Operativo Anual (POA)</p>
                <div style="margin-top:-4%;">
                    <?php if ($nivel_user <= 2) : ?>
                        <a href="add_poa.php" class="btn btn-success">Agregar</a>
                    <?php endif; ?>
                    <a href="poa.php" class="btn btn-primary">Ver</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" style="margin-top: 10px;">
    <div class="col-md-3" style="height: 12.5rem;">
        <div class="panel panel-box clearfix">
            <div class="panel-icon pull-left" style="background: #114987;">
                <svg style="width:40px;height:63px" viewBox="0 0 24 24">
                    <path fill="white" d="M9.05,9H7.06V6H9.05V4.03H7.06V3.03C7.06,1.92 7.95,1.04 9.05,1.04H15.03V8L17.5,6.5L20,8V1.04H21C22.05,1.04 23,2 23,3.03V17C23,18.03 22.05,19 21,19H9.05C8,19 7.06,18.05 7.06,17V16H9.05V14H7.06V11H9.05V9M1,18H3V15H1V13H3V10H1V8H3V5H5V8H3V10H5V13H3V15H5V18H3V20H5V21H21V23H5A2,2 0 0,1 3,21V20H1V18Z" />
                </svg>
            </div>
            <div class="panel-value pull-right">
                <p style="font-size: 17px; margin-top:5%; color:#333333;">Plan estratégico Institucional</p>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>