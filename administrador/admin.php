<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Página de Inicio';
require_once('includes/load.php');

$user = current_user();
$nivel_user = $user['user_level'];
// page_require_area(7);

if ($nivel_user <= 2) {
  page_require_level(2);
}
if ($nivel_user == 7) {
  page_require_level_exacto(7);
}
if ($nivel_user > 2 && $nivel_user < 7) :
  redirect('home.php');
endif;
if ($nivel_user > 7) :
  redirect('home.php');
endif;
?>
<?php
$c_user = count_by_id('users');
$c_atencion = count_by_id('atencion');
$c_trabajadores = count_by_id('detalles_usuario');
$c_areas = count_by_id('area');
$c_cargos = count_by_id('cargos');
$convenios = count_by_id('convenios');
$c_capacitacion = count_by_id('capacitaciones');
$c_orientacion = count_by_id_orientacion('orientacion_canalizacion');
$c_canalizacion = count_by_id_canalizacion('orientacion_canalizacion');
$c_med_psic = count_by_id_med_psic('fichas');
$c_quejas = count_by_id('quejas');
$c_resoluciones = count_by_id('resoluciones');
$c_consejo = count_by_id('consejo');
$c_correspondencia = count_by_id('correspondencia');
$c_env_correspondencia = count_by_id('envio_correspondencia');
$c_invitaciones = count_by_id('invitaciones');
$c_acuerdos = count_by_id('acuerdos');
$c_recomendaciones = count_by_id('recomendaciones');
$c_recomendaciones_generales = count_by_id('recomendaciones_generales');
$c_eventos = count_by_id('eventos');
$c_inf_anual = count_by_id('informes');
$c_poa = count_by_id('poa');
$c_fmedica = count_by_id_med('fichas', 1);
$c_fpsicologica = count_by_id_med('fichas', 2);
$c_jornada = count_by_id('jornadas');
$c_actuacion = count_by_id('actuaciones');
$c_agenda = count_by_id('agendas');
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="users.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet">
          <i class="large material-icons">account_circle</i>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%"> <?php echo $c_user['total']; ?> </h2>
          <p class="text-muted">Cuentas de Usuario</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="detalles_usuario.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet">
          <i class="glyphicon glyphicon-user"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%"> <?php echo $c_trabajadores['total']; ?> </h2>
          <p class="text-muted">Trabajadores</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="areas.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet"">
        <i class=" large material-icons">business</i>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%;"> <?php echo $c_areas['total']; ?> </h2>
          <p class="text-muted">Áreas</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="cargos.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet">
          <i class="large material-icons">business_center</i>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%"> <?php echo $c_cargos['total']; ?> </h2>
          <p class="text-muted">Cargos</p>
        </div>
      </div>
    </a>
  </div>
</div>


<div class="row" style="margin-top: 5px;">
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="convenios.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet" style="display: grid; place-content: center;">
          <svg style="width:40px;height:62px;" viewBox="0 0 24 24">
            <path fill="white" d="M14 2H6C4.9 2 4 2.9 4 4V20C4 21.1 4.9 22 6 22H18C19.1 22 20 21.1 20 20V8L14 2M18 20H6V4H13V9H18V20M9.5 18L10.2 15.2L8 13.3L10.9 13.1L12 10.4L13.1 13L16 13.2L13.8 15.1L14.5 17.9L12 16.5L9.5 18Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%"> <?php echo $convenios['total']; ?> </h2>
          <p class="text-muted">Convenios de colaboración</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="quejas.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet" style="display: grid; place-content: center;">
          <svg style="width:40px;height:62px" viewBox="0 0 24 24">
            <path fill="white" d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%"> <?php echo $c_quejas['total']; ?> </h2>
          <p class="text-muted">Quejas Registradas</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="orientaciones.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet" style="display: grid; place-content: center;">
          <svg style="width:40px;height:62px" viewBox="0 0 24 24">
            <path fill="white" d="M16.75 4.36C18.77 6.56 18.77 9.61 16.75 11.63L15.07 9.94C15.91 8.76 15.91 7.23 15.07 6.05L16.75 4.36M20.06 1C24 5.05 23.96 11.11 20.06 15L18.43 13.37C21.2 10.19 21.2 5.65 18.43 2.63L20.06 1M9 4C11.2 4 13 5.79 13 8S11.2 12 9 12 5 10.21 5 8 6.79 4 9 4M13 14.54C13 15.6 12.71 18.07 10.8 20.83L10 16L10.93 14.12C10.31 14.05 9.66 14 9 14S7.67 14.05 7.05 14.12L8 16L7.18 20.83C5.27 18.07 5 15.6 5 14.54C2.6 15.24 .994 16.5 .994 18V22H17V18C17 16.5 15.39 15.24 13 14.54Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%"> <?php echo $c_orientacion['total']; ?></h2>
          <p class="text-muted">Orientaciones</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="canalizaciones.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet" style="display: grid; place-content: center;">
          <svg style="width:40px;height:62px" viewBox="0 0 24 24">
            <path fill="white" d="M8,14V18L2,12L8,6V10H16V6L22,12L16,18V14H8Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%"> <?php echo $c_canalizacion['total']; ?></h2>
          <p class="text-muted">Canaliza-</p>
          <p class="text-muted" style="margin-top: -4%;">ciones</p>
        </div>
      </div>
    </a>
  </div>
</div>
<div class="row" style="margin-top: 5px;">
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="acuerdos_no_violacion.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet" style="display: grid; place-content: center;">
          <svg style="width:40px;height:62px" viewBox="0 0 24 24">
            <path fill="white" d="M19.7 12.9L14 18.6H11.7V16.3L17.4 10.6L19.7 12.9M23.1 12.1C23.1 12.4 22.8 12.7 22.5 13L20 15.5L19.1 14.6L21.7 12L21.1 11.4L20.4 12.1L18.1 9.8L20.3 7.7C20.5 7.5 20.9 7.5 21.2 7.7L22.6 9.1C22.8 9.3 22.8 9.7 22.6 10C22.4 10.2 22.2 10.4 22.2 10.6C22.2 10.8 22.4 11 22.6 11.2C22.9 11.5 23.2 11.8 23.1 12.1M3 20V4H10V9H15V10.5L17 8.5V8L11 2H3C1.9 2 1 2.9 1 4V20C1 21.1 1.9 22 3 22H15C16.1 22 17 21.1 17 20H3M11 17.1C10.8 17.1 10.6 17.2 10.5 17.2L10 15H8.5L6.4 16.7L7 14H5.5L4.5 19H6L8.9 16.4L9.5 18.7H10.5L11 18.6V17.1Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%"> <?php echo $c_acuerdos['total']; ?></h2>
          <p class="text-muted">Acuerdos de No Violación</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="recomendaciones.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet" style="display: grid; place-content: center;">
          <svg style="width:40px;height:62px;" viewBox="0 0 24 24">
            <path fill="white" d="M20 17H22V15H20V17M20 7V13H22V7H20M11 9H16.5L11 3.5V9M4 2H12L18 8V20C18 21.11 17.11 22 16 22H4C2.89 22 2 21.1 2 20V4C2 2.89 2.89 2 4 2M13 18V16H4V18H13M16 14V12H4V14H16Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%"> <?php echo $c_recomendaciones['total']; ?></h2>
          <p class="text-muted">Recomenda-</p>
          <p class="text-muted" style="margin-top: -8%;">ciones</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="recomendaciones_generales.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet" style="display: grid; place-content: center;">
          <svg style="width:40px;height:62px;" viewBox="0 0 24 24">
            <path fill="white" d="M20 17H22V15H20V17M20 7V13H22V7H20M11 9H16.5L11 3.5V9M4 2H12L18 8V20C18 21.11 17.11 22 16 22H4C2.89 22 2 21.1 2 20V4C2 2.89 2.89 2 4 2M13 18V16H4V18H13M16 14V12H4V14H16Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%"> <?php echo $c_recomendaciones_generales['total']; ?></h2>
          <p class="text-muted">Recomenda-</p>
          <p class="text-muted" style="margin-top: -8%;">ciones generales</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="atencion.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet" style="display: grid; place-content: center;">
          <svg style="width:40px;height:62px" viewBox="0 0 24 24">
            <path fill="white" d="M10 4A4 4 0 0 1 14 8A4 4 0 0 1 10 12A4 4 0 0 1 6 8A4 4 0 0 1 10 4M10 14C14.42 14 18 15.79 18 18V20H2V18C2 15.79 5.58 14 10 14M20 12V7H22V13H20M20 17V15H22V17H20Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%"> <?php echo $c_atencion['total']; ?></h2>
          <p class="text-muted">Atención</p>
        </div>
      </div>
    </a>
  </div>
</div>
<div class="row" style="margin-top: 5px;">
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="capacitaciones.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet" style="display: grid; place-content: center;">
          <svg style="width:40px;height:62px" viewBox="0 0 24 24">
            <path fill="white" d="M13 3C16.9 3 20 6.1 20 10C20 12.8 18.4 15.2 16 16.3V21H9V18H8C6.9 18 6 17.1 6 16V13H4.5C4.1 13 3.8 12.5 4.1 12.2L6 9.7C6.2 5.9 9.2 3 13 3M13 1C8.4 1 4.6 4.4 4.1 8.9L2.5 11C1.9 11.7 1.8 12.7 2.2 13.6C2.6 14.3 3.2 14.8 4 15V16C4 17.9 5.3 19.4 7 19.9V23H18V17.5C20.5 15.9 22 13.1 22 10C22 5 18 1 13 1M17 10H14V13H12V10H9V8H12V5H14V8H17V10Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%"> <?php echo $c_capacitacion['total']; ?> </h2>
          <p class="text-muted">Capacitaciones</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="resoluciones.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet" style="display: grid; place-content: center;">
          <svg style="width:40px;height:62px" viewBox="0 0 24 24">
            <path fill="white" d="M7.5,5.6L5,7L6.4,4.5L5,2L7.5,3.4L10,2L8.6,4.5L10,7L7.5,5.6M19.5,15.4L22,14L20.6,16.5L22,19L19.5,17.6L17,19L18.4,16.5L17,14L19.5,15.4M22,2L20.6,4.5L22,7L19.5,5.6L17,7L18.4,4.5L17,2L19.5,3.4L22,2M13.34,12.78L15.78,10.34L13.66,8.22L11.22,10.66L13.34,12.78M14.37,7.29L16.71,9.63C17.1,10 17.1,10.65 16.71,11.04L5.04,22.71C4.65,23.1 4,23.1 3.63,22.71L1.29,20.37C0.9,20 0.9,19.35 1.29,18.96L12.96,7.29C13.35,6.9 14,6.9 14.37,7.29Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%"> <?php echo $c_resoluciones['total']; ?> </h2>
          <p class="text-muted">Resoluciones</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="consejo.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet" style="display: grid; place-content: center;">
          <svg style="width:40px;height:62px" viewBox="0 0 24 24">
            <path fill="white" d="M12,5.5A3.5,3.5 0 0,1 15.5,9A3.5,3.5 0 0,1 12,12.5A3.5,3.5 0 0,1 8.5,9A3.5,3.5 0 0,1 12,5.5M5,8C5.56,8 6.08,8.15 6.53,8.42C6.38,9.85 6.8,11.27 7.66,12.38C7.16,13.34 6.16,14 5,14A3,3 0 0,1 2,11A3,3 0 0,1 5,8M19,8A3,3 0 0,1 22,11A3,3 0 0,1 19,14C17.84,14 16.84,13.34 16.34,12.38C17.2,11.27 17.62,9.85 17.47,8.42C17.92,8.15 18.44,8 19,8M5.5,18.25C5.5,16.18 8.41,14.5 12,14.5C15.59,14.5 18.5,16.18 18.5,18.25V20H5.5V18.25M0,20V18.5C0,17.11 1.89,15.94 4.45,15.6C3.86,16.28 3.5,17.22 3.5,18.25V20H0M24,20H20.5V18.25C20.5,17.22 20.14,16.28 19.55,15.6C22.11,15.94 24,17.11 24,18.5V20Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%"> <?php echo $c_consejo['total']; ?> </h2>
          <p class="text-muted">Consejo</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="correspondencia.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet" style="display: grid; place-content: center;">
          <svg style="width:40px;height:62px" viewBox="0 0 24 24">
            <path fill="white" d="M17,4H7A5,5 0 0,0 2,9V20H20A2,2 0 0,0 22,18V9A5,5 0 0,0 17,4M10,18H4V9A3,3 0 0,1 7,6A3,3 0 0,1 10,9V18M19,15H17V13H13V11H19V15M9,11H5V9H9V11Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%"> <?php echo $c_correspondencia['total']; ?> </h2>
          <p class="text-muted">Corresponden-</p>
          <p class="text-muted" style="margin-top: -8%">cia</p>
        </div>
      </div>
    </a>
  </div>
</div>
<div class="row" style="margin-top: 5px;">
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="env_correspondencia.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet" style="display: grid; place-content: center;">
          <svg style="width:40px;height:62px" viewBox="0 0 24 24">
            <path fill="white" d="M17,4H7A5,5 0 0,0 2,9V20H20A2,2 0 0,0 22,18V9A5,5 0 0,0 17,4M10,18H4V9A3,3 0 0,1 7,6A3,3 0 0,1 10,9V18M19,15H17V13H13V11H19V15M9,11H5V9H9V11Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%"> <?php echo $c_env_correspondencia['total']; ?> </h2>
          <p class="text-muted">Corresponden-</p>
          <p class="text-muted" style="margin-top: -8%">cia interna</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="invitaciones.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet" style="display: grid; place-content: center;">
          <svg style="width:40px;height:62px" viewBox="0 0 24 24">
            <path fill="white" d="M22,3H2A2,2 0 0,0 0,5V19A2,2 0 0,0 2,21H22A2,2 0 0,0 24,19V5A2,2 0 0,0 22,3M22,19H2V5H22V19M21,6H14V11H21V6M20,8L17.5,9.75L15,8V7L17.5,8.75L20,7V8M9,12A3,3 0 0,0 12,9A3,3 0 0,0 9,6A3,3 0 0,0 6,9A3,3 0 0,0 9,12M9,8A1,1 0 0,1 10,9A1,1 0 0,1 9,10A1,1 0 0,1 8,9A1,1 0 0,1 9,8M15,16.59C15,14.09 11.03,13 9,13C6.97,13 3,14.09 3,16.59V18H15V16.59M5.5,16C6.22,15.5 7.7,15 9,15C10.3,15 11.77,15.5 12.5,16H5.5Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%"> <?php echo $c_invitaciones['total']; ?> </h2>
          <p class="text-muted">Invitaciones</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="informes.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet" style="display: grid; place-content: center;">
          <svg style="width:40px;height:62px" viewBox="0 0 24 24">
            <path fill="white" d="M19,3H18V1H16V3H8V1H6V3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H10V19H5V8H19V9H21V5A2,2 0 0,0 19,3M21.7,13.35L20.7,14.35L18.65,12.35L19.65,11.35C19.85,11.14 20.19,11.13 20.42,11.35L21.7,12.63C21.89,12.83 21.89,13.15 21.7,13.35M12,18.94L18.07,12.88L20.12,14.88L14.06,21H12V18.94Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%"> <?php echo $c_inf_anual['total']; ?> </h2>
          <p class="text-muted">Informe Anual de Actividades</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="poa.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet" style="display: grid; place-content: center;">
          <svg style="width:40px;height:62px" viewBox="0 0 24 24">
            <path fill="white" d="M19 1L14 6V17L19 12.5V1M21 5V18.5C19.9 18.15 18.7 18 17.5 18C15.8 18 13.35 18.65 12 19.5V6C10.55 4.9 8.45 4.5 6.5 4.5C4.55 4.5 2.45 4.9 1 6V20.65C1 20.9 1.25 21.15 1.5 21.15C1.6 21.15 1.65 21.1 1.75 21.1C3.1 20.45 5.05 20 6.5 20C8.45 20 10.55 20.4 12 21.5C13.35 20.65 15.8 20 17.5 20C19.15 20 20.85 20.3 22.25 21.05C22.35 21.1 22.4 21.1 22.5 21.1C22.75 21.1 23 20.85 23 20.6V6C22.4 5.55 21.75 5.25 21 5M10 18.41C8.75 18.09 7.5 18 6.5 18C5.44 18 4.18 18.19 3 18.5V7.13C3.91 6.73 5.14 6.5 6.5 6.5C7.86 6.5 9.09 6.73 10 7.13V18.41Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%"> <?php echo $c_poa['total']; ?> </h2>
          <p class="text-muted">Programa Operativo Anual</p>
        </div>
      </div>
    </a>
  </div>
</div>
<div class="row" style="margin-top: 5px;">
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="eventos.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet" style="display: grid; place-content: center;">
          <svg style="width:40px;height:62px" viewBox="0 0 24 24">
            <path fill="white" d="M19,20H5V9H19M16,2V4H8V2H6V4H5A2,2 0 0,0 3,6V20A2,2 0 0,0 5,22H19A2,2 0 0,0 21,20V6A2,2 0 0,0 19,4H18V2M10.88,13H7.27L10.19,15.11L9.08,18.56L12,16.43L14.92,18.56L13.8,15.12L16.72,13H13.12L12,9.56L10.88,13Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%"> <?php echo $c_eventos['total']; ?> </h2>
          <p class="text-muted">Eventos</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="fichas.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet" style="display: grid; place-content: center;">
          <svg style="width:40px;height:62px" viewBox="0 0 24 24">
            <path fill="white" d="M18 14H14V18H10V14H6V10H10V6H14V10H18M20 2H4C2.9 2 2 2.9 2 4V20C2 21.1 2.9 22 4 22H20C21.1 22 22 21.1 22 20V4C22 2.9 21.1 2 20 2M20 20H4V4H20V20Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%"> <?php echo $c_fmedica['total']; ?> </h2>
          <p class="text-muted">Fichas Médicas</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="fichas_psic.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet" style="display: grid; place-content: center;">
          <svg style="width:40px;height:62px" viewBox="0 0 24 24">
            <path fill="white" d="M13 3C16.88 3 20 6.14 20 10C20 12.8 18.37 15.19 16 16.31V21H9V18H8C6.89 18 6 17.11 6 16V13H4.5C4.08 13 3.84 12.5 4.08 12.19L6 9.66C6.19 5.95 9.23 3 13 3M13 1C8.41 1 4.61 4.42 4.06 8.9L2.5 11L2.47 11L2.45 11.03C1.9 11.79 1.83 12.79 2.26 13.62C2.62 14.31 3.26 14.79 4 14.94V16C4 17.85 5.28 19.42 7 19.87V23H18V17.5C20.5 15.83 22 13.06 22 10C22 5.03 17.96 1 13 1M17.33 9.3L15.37 9.81L16.81 11.27C17.16 11.61 17.16 12.19 16.81 12.54S15.88 12.89 15.54 12.54L14.09 11.1L13.57 13.06C13.45 13.55 12.96 13.82 12.5 13.7C12 13.57 11.72 13.08 11.84 12.59L12.37 10.63L10.41 11.16C9.92 11.28 9.43 11 9.3 10.5C9.18 10.05 9.46 9.55 9.94 9.43L11.9 8.91L10.46 7.46C10.11 7.12 10.11 6.55 10.46 6.19C10.81 5.84 11.39 5.84 11.73 6.19L13.19 7.63L13.7 5.67C13.82 5.18 14.32 4.9 14.79 5.03C15.28 5.16 15.56 5.65 15.43 6.13L14.9 8.1L16.87 7.57C17.35 7.44 17.84 7.72 17.97 8.21C18.1 8.68 17.82 9.18 17.33 9.3Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%"> <?php echo $c_fpsicologica['total']; ?> </h2>
          <p class="text-muted">Fichas Psicológicas</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="jornadas.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet" style="display: grid; place-content: center;">
          <svg style="width:40px;height:62px" viewBox="0 0 24 24">
            <path fill="white" d="M5 6C3.9 6 3 6.9 3 8S3.9 10 5 10 7 9.11 7 8 6.11 6 5 6M12 4C10.9 4 10 4.89 10 6S10.9 8 12 8 14 7.11 14 6 13.11 4 12 4M19 2C17.9 2 17 2.9 17 4S17.9 6 19 6 21 5.11 21 4 20.11 2 19 2M3.5 11C2.67 11 2 11.67 2 12.5V17H3V22H7V17H8V12.5C8 11.67 7.33 11 6.5 11H3.5M10.5 9C9.67 9 9 9.67 9 10.5V15H10V20H14V15H15V10.5C15 9.67 14.33 9 13.5 9H10.5M17.5 7C16.67 7 16 7.67 16 8.5V13H17V18H21V13H22V8.5C22 7.67 21.33 7 20.5 7H17.5Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%"> <?php echo $c_jornada['total']; ?> </h2>
          <p class="text-muted">Jornadas</p>
        </div>
      </div>
    </a>
  </div>
</div>
<div class="row" style="margin-top:5px;">
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="jornadas.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet" style="display: grid; place-content: center;">
          <svg style="width:40px;height:62px" viewBox="0 0 24 24">
            <path fill="white" d="M7 12C9.2 12 11 10.2 11 8S9.2 4 7 4 3 5.8 3 8 4.8 12 7 12M11 20V14.7C9.9 14.3 8.5 14 7 14C3.1 14 0 15.8 0 18V20H11M15 4C13.9 4 13 4.9 13 6V18C13 19.1 13.9 20 15 20H22C23.1 20 24 19.1 24 18V6C24 4.9 23.1 4 22 4H15Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%"> <?php echo $c_actuacion['total']; ?> </h2>
          <p class="text-muted">Actuaciones</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="jornadas.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet" style="display: grid; place-content: center;">
          <svg style="width:40px;height:62px" viewBox="0 0 24 24">
            <path fill="white" d="M3,7V5H5V4C5,2.89 5.9,2 7,2H13V9L15.5,7.5L18,9V2H19C20.05,2 21,2.95 21,4V20C21,21.05 20.05,22 19,22H7C5.95,22 5,21.05 5,20V19H3V17H5V13H3V11H5V7H3M7,11H5V13H7V11M7,7V5H5V7H7M7,19V17H5V19H7Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%"> <?php echo $c_actuacion['total']; ?> </h2>
          <p class="text-muted">Agenda de Actividades</p>
        </div>
      </div>
    </a>
  </div>
</div>


<?php include_once('layouts/footer.php'); ?>