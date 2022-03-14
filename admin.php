<?php
$page_title = 'Página de Inicio';
require_once('includes/load.php');

page_require_level(2);
?>
<?php
$c_user = count_by_id('users');
$c_trabajadores = count_by_id('detalles_usuario');
$c_areas = count_by_id('area');
$c_cargos = count_by_id('cargos');
$c_convenios = count_by_id('convenios');
$c_capacitacion = count_by_id('capacitaciones');
$c_orientacion = count_by_id_orientacion('orientacion_canalizacion');
$c_canalizacion = count_by_id_canalizacion('orientacion_canalizacion');
$c_med_psic = count_by_id_med_psic('fichas');
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-3" style="height: 12.5rem;">
    <div class="panel panel-box clearfix">
      <div class="panel-icon pull-left bg-green">
        <i class="large material-icons">account_circle</i>
      </div>
      <div class="panel-value pull-right">
        <h2 class="margin-top"> <?php echo $c_user['total']; ?> </h2>
        <p class="text-muted">Cuentas de Usuario</p>
      </div>
    </div>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <div class="panel panel-box clearfix">
      <div class="panel-icon pull-left bg-violet">
        <i class="glyphicon glyphicon-user"></i>
      </div>
      <div class="panel-value pull-right">
        <h2 class="margin-top"> <?php echo $c_trabajadores['total']; ?> </h2>
        <p class="text-muted">Trabajadores</p>
      </div>
    </div>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <div class="panel panel-box clearfix">
      <div class="panel-icon pull-left bg-orange">
        <i class="large material-icons">business</i>
      </div>
      <div class="panel-value pull-right">
        <h2 class="margin-top"> <?php echo $c_areas['total']; ?> </h2>
        <p class="text-muted">Áreas</p>
      </div>
    </div>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <div class="panel panel-box clearfix">
      <div class="panel-icon pull-left bg-green2">
        <i class="large material-icons">business_center</i>
      </div>
      <div class="panel-value pull-right">
        <h2 class="margin-top"> <?php echo $c_cargos['total']; ?> </h2>
        <p class="text-muted">Cargos</p>
      </div>
    </div>
  </div>
</div><br>

<!-- <div class="row">
  <div class="col-md-3" style="height: 12.5rem;">
    <div class="panel panel-box clearfix">
      <div class="panel-icon pull-left bg-violet">
        <i class="glyphicon glyphicon-user"></i>
      </div>
      <div class="panel-value pull-right">
        <h2 class="margin-top"> <?php echo $c_trabajadores['total']; ?> </h2>
        <p class="text-muted">Trabajadores</p>
      </div>
    </div>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <div class="panel panel-box clearfix">
      <div class="panel-icon pull-left bg-orange">
        <i class="large material-icons">business</i>
      </div>
      <div class="panel-value pull-right">
        <h2 class="margin-top"> <?php echo $c_areas['total']; ?> </h2>
        <p class="text-muted">Áreas</p>
      </div>
    </div>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <div class="panel panel-box clearfix">
      <div class="panel-icon pull-left bg-green2">
        <i class="large material-icons">business_center</i>
      </div>
      <div class="panel-value pull-right">
        <h2 class="margin-top"> <?php echo $c_cargos['total']; ?> </h2>
        <p class="text-muted">Cargos</p>
      </div>
    </div>
  </div> -->
<!-- <div class="col-md-3" style="height: 12.5rem;">
    <div class="panel panel-box clearfix">
      <div class="panel-icon pull-left bg-purple">
        <i class="large material-icons">folder</i>
      </div>
      <div class="panel-value pull-right">
        <h2 class="margin-top"> <?php echo $c_resguardos['total']; ?></h2>
        <p class="text-muted">Resguardos componentes</p>
      </div>
    </div>
  </div> -->
<!-- </div><br> -->

<!-- <div class="row">
  <div class="col-md-3" style="height: 12.5rem;">
    <div class="panel panel-box clearfix">
      <div class="panel-icon pull-left bg-pink">
        <i class="glyphicon glyphicon-list"></i>
      </div>
      <div class="panel-value pull-right">
        <h2 class="margin-top"> <?php echo $c_tipos['total']; ?> </h2>
        <p class="text-muted">Tipos de vehículos</p>
      </div>
    </div>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <div class="panel panel-box clearfix">
      <div class="panel-icon pull-left bg-blue2">
        <svg style="width:50px; height:58px" viewBox="0 0 24 24">
          <path fill="white" d="M5,11L6.5,6.5H17.5L19,11M17.5,16A1.5,1.5 0 0,1 16,14.5A1.5,1.5 0 0,1 17.5,13A1.5,1.5 0 0,1 19,14.5A1.5,1.5 0 0,1 17.5,16M6.5,16A1.5,1.5 0 0,1 5,14.5A1.5,1.5 0 0,1 6.5,13A1.5,1.5 0 0,1 8,14.5A1.5,1.5 0 0,1 6.5,16M18.92,6C18.72,5.42 18.16,5 17.5,5H6.5C5.84,5 5.28,5.42 5.08,6L3,12V20A1,1 0 0,0 4,21H5A1,1 0 0,0 6,20V19H18V20A1,1 0 0,0 19,21H20A1,1 0 0,0 21,20V12L18.92,6Z" />
        </svg>
      </div>
      <div class="panel-value pull-right">
        <h2 class="margin-top"> <?php echo $c_vehiculos['total']; ?> </h2>
        <p class="text-muted">Vehículos</p>
      </div>
    </div>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <div class="panel panel-box clearfix">
      <div class="panel-icon pull-left bg-blue3">
        <i class="large material-icons">business_center</i>
      </div>
      <div class="panel-value pull-right">
        <h2 class="margin-top"> <?php echo $c_asignacionesv['total']; ?> </h2>
        <p class="text-muted">Asignaciones vehiculares</p>
      </div>
    </div>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <div class="panel panel-box clearfix">
      <div class="panel-icon pull-left bg-orange2">
        <i class="large material-icons">folder</i>
      </div>
      <div class="panel-value pull-right">
        <h2 class="margin-top"> <?php echo $c_resguardosv['total']; ?></h2>
        <p class="text-muted">Resguardos vehiculares</p>
      </div>
    </div>
  </div>
</div><br> -->
<br>
<div class="row">
  <div class="col-md-3" style="height: 12.5rem;">
    <div class="panel panel-box clearfix">
      <div class="panel-icon pull-left" style="background: #98F551;">
        <svg style="width:59px;height:59px" viewBox="0 0 24 24">
          <path fill="white" d="M14 2H6C4.9 2 4 2.9 4 4V20C4 21.1 4.9 22 6 22H18C19.1 22 20 21.1 20 20V8L14 2M18 20H6V4H13V9H18V20M9.5 18L10.2 15.2L8 13.3L10.9 13.1L12 10.4L13.1 13L16 13.2L13.8 15.1L14.5 17.9L12 16.5L9.5 18Z" />
        </svg>
      </div>
      <div class="panel-value pull-right">
        <h2 class="margin-top"> <?php echo $c_convenios['total']; ?> </h2>
        <p class="text-muted">Convenios</p>
      </div>
    </div>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <div class="panel panel-box clearfix">
      <div class="panel-icon pull-left" style="background: #37B6FE;">
        <svg style="width:59px;height:59px" viewBox="0 0 24 24">
          <path fill="white" d="M13 3C16.9 3 20 6.1 20 10C20 12.8 18.4 15.2 16 16.3V21H9V18H8C6.9 18 6 17.1 6 16V13H4.5C4.1 13 3.8 12.5 4.1 12.2L6 9.7C6.2 5.9 9.2 3 13 3M13 1C8.4 1 4.6 4.4 4.1 8.9L2.5 11C1.9 11.7 1.8 12.7 2.2 13.6C2.6 14.3 3.2 14.8 4 15V16C4 17.9 5.3 19.4 7 19.9V23H18V17.5C20.5 15.9 22 13.1 22 10C22 5 18 1 13 1M17 10H14V13H12V10H9V8H12V5H14V8H17V10Z" />
        </svg>
      </div>
      <div class="panel-value pull-right">
        <h2 class="margin-top"> <?php echo $c_capacitacion['total']; ?> </h2>
        <p class="text-muted">Capacitaciones</p>
      </div>
    </div>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <div class="panel panel-box clearfix">
      <div class="panel-icon pull-left" style="background: #5338FF;">
        <svg style="width:59px;height:59px" viewBox="0 0 24 24">
          <path fill="white" d="M16.75 4.36C18.77 6.56 18.77 9.61 16.75 11.63L15.07 9.94C15.91 8.76 15.91 7.23 15.07 6.05L16.75 4.36M20.06 1C24 5.05 23.96 11.11 20.06 15L18.43 13.37C21.2 10.19 21.2 5.65 18.43 2.63L20.06 1M9 4C11.2 4 13 5.79 13 8S11.2 12 9 12 5 10.21 5 8 6.79 4 9 4M13 14.54C13 15.6 12.71 18.07 10.8 20.83L10 16L10.93 14.12C10.31 14.05 9.66 14 9 14S7.67 14.05 7.05 14.12L8 16L7.18 20.83C5.27 18.07 5 15.6 5 14.54C2.6 15.24 .994 16.5 .994 18V22H17V18C17 16.5 15.39 15.24 13 14.54Z" />
        </svg>
      </div>
      <div class="panel-value pull-right">
        <h2 class="margin-top"> <?php echo $c_orientacion['total']; ?></h2>
        <p class="text-muted">Orientaciones</p>
      </div>
    </div>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <div class="panel panel-box clearfix">
      <div class="panel-icon pull-left" style="background: #FFD31A;">
        <svg style="width:59px;height:59px" viewBox="0 0 24 24">
          <path fill="white" d="M8,14V18L2,12L8,6V10H16V6L22,12L16,18V14H8Z" />
        </svg>
      </div>
      <div class="panel-value pull-right">
        <h2 class="margin-top"> <?php echo $c_canalizacion['total']; ?></h2>
        <p class="text-muted">Canalizaciones</p>
      </div>
    </div>
  </div>
</div><br><br>
<div class="row">
  <div class="col-md-3" style="height: 12.5rem;">
    <div class="panel panel-box clearfix">
      <div class="panel-icon pull-left" style="background: #F52929;">
        <svg style="width:59px;height:59px" viewBox="0 0 24 24">
          <path fill="white" d="M18,14H14V18H10V14H6V10H10V6H14V10H18M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
        </svg>
      </div>
      <div class="panel-value pull-right">
        <h2 class="margin-top"> <?php echo $c_med_psic['total']; ?></h2>
        <p class="text-muted">Área Médica y Psicológica</p>
      </div>
    </div>
  </div>
</div>



<?php include_once('layouts/footer.php'); ?>