<?php
$page_title = 'Secretaría Particular';
require_once('includes/load.php');
?>
<?php
// error_reporting(E_ALL ^ E_NOTICE);
$user = current_user();
$id_user = $user['id'];
$nivel_user = $user['user_level'];

// if ($nivel_user <= 2) :
//     page_require_level(2);
// endif;
// if ($nivel_user == 7) :
//     page_require_level_exacto(7);
// endif;
// if ($nivel_user == 8) :
//     page_require_level_exacto(8);
// endif;
if ($nivel_user > 2 && $nivel_user < 7) :
    redirect('home.php');
endif;
if ($nivel_user > 8) :
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
<h1>Solicitudes Secretaría Particular</h1>


<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>


<div class="row" style="margin-top: 10px;">
    <div class="col-md-3" style="height: 13.5rem;">
        <div class="panel panel-box clearfix">
            <div class="panel-icon pull-left" style="background: #114987; display: grid; place-content: center;">
                <svg style="width:40px;height:73px" viewBox="0 0 24 24">
                    <path fill="white" d="M17,4H7A5,5 0 0,0 2,9V20H20A2,2 0 0,0 22,18V9A5,5 0 0,0 17,4M10,18H4V9A3,3 0 0,1 7,6A3,3 0 0,1 10,9V18M19,15H17V13H13V11H19V15M9,11H5V9H9V11Z" />
                </svg>
            </div>
            <div class="panel-value pull-right">
                <p style="font-size: 15px; margin-top:2%; color:#333333; line-height: 100%;">Recepción General de Correspon-<br>dencia</p>
                <div style="margin-top:-1%;">
                    <a href="correspondencia.php" class="btn btn-secondary btn-xs" style="margin-top: 3px;">Correspondencia</a>
                    <a href="invitaciones.php" class="btn btn-secondary btn-xs" style="margin-top: 3px;">Invitaciones</a>
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
                <svg style="width:40px;height:73px" viewBox="0 0 24 24">
                    <path fill="white" d="M3,7V5H5V4C5,2.89 5.9,2 7,2H13V9L15.5,7.5L18,9V2H19C20.05,2 21,2.95 21,4V20C21,21.05 20.05,22 19,22H7C5.95,22 5,21.05 5,20V19H3V17H5V13H3V11H5V7H3M7,11H5V13H7V11M7,7V5H5V7H7M7,19V17H5V19H7Z" />
                </svg>
            </div>
            <div class="panel-value pull-right">
                <p style="font-size: 15px; margin-top:10%; color:#333333; line-height: 100%;">Eventos</p>
                <div style="margin-top:-8%;">

                    <a style="margin-top:10%;" href="add_evento.php" class="btn btn-success btn-sm">Agregar</a>

                    <a style="margin-top:10%;" href="eventos.php" class="btn btn-primary btn-sm">Ver</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3" style="height: 13.5rem;">
        <div class="panel panel-box clearfix">
            <div class="panel-icon pull-left" style="background: #114987; display: grid; place-content: center;">
                <svg style="width:40px;height:73px" viewBox="0 0 24 24">
                    <path fill="white" d="M9,5A4,4 0 0,1 13,9A4,4 0 0,1 9,13A4,4 0 0,1 5,9A4,4 0 0,1 9,5M9,15C11.67,15 17,16.34 17,19V21H1V19C1,16.34 6.33,15 9,15M16.76,5.36C18.78,7.56 18.78,10.61 16.76,12.63L15.08,10.94C15.92,9.76 15.92,8.23 15.08,7.05L16.76,5.36M20.07,2C24,6.05 23.97,12.11 20.07,16L18.44,14.37C21.21,11.19 21.21,6.65 18.44,3.63L20.07,2Z" />
                </svg>
            </div>
            <div class="panel-value pull-right">
                <p style="font-size: 15px; margin-top:10%; color:#333333; line-height: 100%;">Atención</p>
                <div style="margin-top:-8%;">
                    <?php if (($nivel_user <= 2) || ($nivel_user == 8)) : ?>
                        <a style="margin-top:10%;" href="add_atencion.php" class="btn btn-success btn-sm">Agregar</a>
                    <?php endif; ?>
                    <a style="margin-top:10%;" href="atencion.php" class="btn btn-primary btn-sm">Ver</a>
                </div>
            </div>
        </div>
    </div>
</div><br>
<div class="row">
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
                    <?php //if ($nivel_user <= 2) : 
                    ?>
                    <a style="margin-top:5%;" href="add_informe_areas.php" class="btn btn-success btn-sm">Agregar</a>
                    <?php //endif; 
                    ?>
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
                    <?php //if ($nivel_user <= 2) : 
                    ?>
                    <a style="margin-top:5%;" href="add_informe.php" class="btn btn-success btn-sm">Agregar</a>
                    <?php //endif; 
                    ?>
                    <a style="margin-top:5%;" href="informes.php" class="btn btn-primary btn-sm">Ver</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>