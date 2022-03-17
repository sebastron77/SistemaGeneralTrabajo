<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Áreas';
require_once('includes/load.php');
$user = current_user();
$id_usuario = $user['id'];

// $user = current_user();
$id_user = $user['id'];
$busca_area = area_usuario($id_usuario);
$otro = $busca_area['id'];

page_require_level(10);

?>

<?php
$c_categoria     = count_by_id('categorias');
$c_user          = count_by_id('users');
$c_trabajadores          = count_by_id('detalles_usuario');
$c_areas          = count_by_id('area');
$c_cargos          = count_by_id('cargos');
?>

<?php include_once('layouts/header.php'); ?>


<h1>Áreas</h1>


<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<div class="row" style="margin-top: 10px;">
  <?php if (($otro <= 2)) : ?>
    <a href="solicitudes_presidencia.php" class="col-md-3" style="height: 12.5rem;">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left" style="background: #c48840;">
          <svg style="width:59px;height:58px" viewBox="0 0 24 24">
            <path fill="white" d="M12 3C14.21 3 16 4.79 16 7S14.21 11 12 11 8 9.21 8 7 9.79 3 12 3M16 13.54C16 14.6 15.72 17.07 13.81 19.83L13 15L13.94 13.12C13.32 13.05 12.67 13 12 13S10.68 13.05 10.06 13.12L11 15L10.19 19.83C8.28 17.07 8 14.6 8 13.54C5.61 14.24 4 15.5 4 17V21H20V17C20 15.5 18.4 14.24 16 13.54Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <p style="font-size: 20px; margin-top:8%; color:black;">Presidencia</p>
          <div><br>
            <!-- <a href="add_convenio.php" class="btn btn-success">Agregar</a>
          <a href="convenios.php" class="btn btn-primary">Ver</a> -->
          </div>
        </div>
      </div>
    </a>
  <?php endif ?>
  <?php if (($otro <= 2)) : ?>
    <a href="solicitudes_secretaria_tecnica.php" class="col-md-3" style="height: 12.5rem;">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left" style="background: #3B86EB;">
          <svg style="width:59px;height:58px" viewBox="0 0 24 24">
            <path fill="white" d="M15,14C12.33,14 7,15.33 7,18V20H23V18C23,15.33 17.67,14 15,14M15,12A4,4 0 0,0 19,8A4,4 0 0,0 15,4A4,4 0 0,0 11,8A4,4 0 0,0 15,12M5,13.28L7.45,14.77L6.8,11.96L9,10.08L6.11,9.83L5,7.19L3.87,9.83L1,10.08L3.18,11.96L2.5,14.77L5,13.28Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <p style="font-size: 20px; margin-top:8%; color:black;">Secretaría Técnica</p>
          <!-- <div>
            <a href="add_convenio.php" class="btn btn-success">Agregar</a>
            <a href="convenios.php" class="btn btn-primary">Ver</a>
          </div> -->
        </div>
      </div>
    </a>
  <?php endif ?>
  <?php if (($otro <= 3)) : ?>
    <a href="solicitudes_secretaria_ejecutiva.php" class="col-md-3" style="height: 12.5rem;">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left" style="background: #71EB85;">
          <svg style="width:59px;height:58px" viewBox="0 0 24 24">
            <path fill="white" d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <p style="font-size: 20px; margin-top:8%; color:black;">Secretaría Ejecutiva</p>
          <div><br>
            <!-- <a href="add_convenio.php" class="btn btn-success">Agregar</a>
          <a href="convenios.php" class="btn btn-primary">Ver</a> -->
          </div>
        </div>
      </div>
    </a>
  <?php endif ?>
  <?php if (($otro == 6) || ($otro <= 2)) : ?>
    <a href="solicitudes_centro_estudios.php" class="col-md-3" style="height: 12.5rem;">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left" style="background: #EB693B;">
          <svg style="width:59px;height:58px" viewBox="0 0 24 24">
            <path fill="white" d="M17.5 14.33C18.29 14.33 19.13 14.41 20 14.57V16.07C19.38 15.91 18.54 15.83 17.5 15.83C15.6 15.83 14.11 16.16 13 16.82V15.13C14.17 14.6 15.67 14.33 17.5 14.33M13 12.46C14.29 11.93 15.79 11.67 17.5 11.67C18.29 11.67 19.13 11.74 20 11.9V13.4C19.38 13.24 18.54 13.16 17.5 13.16C15.6 13.16 14.11 13.5 13 14.15M17.5 10.5C15.6 10.5 14.11 10.82 13 11.5V9.84C14.23 9.28 15.73 9 17.5 9C18.29 9 19.13 9.08 20 9.23V10.78C19.26 10.59 18.41 10.5 17.5 10.5M21 18.5V7C19.96 6.67 18.79 6.5 17.5 6.5C15.45 6.5 13.62 7 12 8V19.5C13.62 18.5 15.45 18 17.5 18C18.69 18 19.86 18.16 21 18.5M17.5 4.5C19.85 4.5 21.69 5 23 6V20.56C23 20.68 22.95 20.8 22.84 20.91C22.73 21 22.61 21.08 22.5 21.08C22.39 21.08 22.31 21.06 22.25 21.03C20.97 20.34 19.38 20 17.5 20C15.45 20 13.62 20.5 12 21.5C10.66 20.5 8.83 20 6.5 20C4.84 20 3.25 20.36 1.75 21.07C1.72 21.08 1.68 21.08 1.63 21.1C1.59 21.11 1.55 21.12 1.5 21.12C1.39 21.12 1.27 21.08 1.16 21C1.05 20.89 1 20.78 1 20.65V6C2.34 5 4.18 4.5 6.5 4.5C8.83 4.5 10.66 5 12 6C13.34 5 15.17 4.5 17.5 4.5Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <p style="font-size: 20px; margin-top:8%; color:black;">Centro de Estudios</p>
          <div><br>
            <!-- <a href="add_convenio.php" class="btn btn-success">Agregar</a>
          <a href="convenios.php" class="btn btn-primary">Ver</a> -->
          </div>
        </div>
      </div>
    </a>
  <?php endif ?>
</div><br>
<div class="row">
  <?php if (($otro == 4) || ($otro <= 2)) : ?>
    <a href="solicitudes_medica_psic.php" class="col-md-3" style="height: 12.5rem;">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left" style="background: #F52929;">
          <svg style="width:59px;height:58px" viewBox="0 0 24 24">
            <path fill="white" d="M18,14H14V18H10V14H6V10H10V6H14V10H18M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <p style="font-size: 20px; margin-top:8%; color:black;">Área Médica y Psicológica</p>
          <div><br>
            <!-- <a href="add_convenio.php" class="btn btn-success">Agregar</a>
          <a href="convenios.php" class="btn btn-primary">Ver</a> -->
          </div>
        </div>
      </div>
    </a>
  <?php endif ?>
  <?php if (($otro == 5) || ($otro <= 2)) : ?>
    <a href="solicitudes_quejas.php" class="col-md-3" style="height: 12.5rem;">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left" style="background: #5243DE;">
          <svg style="width:59px;height:58px" viewBox="0 0 24 24">
            <path fill="white" d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <p style="font-size: 20px; margin-top:8%; color:black;">Orientación Legal, Quejas y Seguimiento</p>
          <div><br>
            <!-- <a href="add_convenio.php" class="btn btn-success">Agregar</a>
          <a href="convenios.php" class="btn btn-primary">Ver</a> -->
          </div>
        </div>
      </div>
    </a>
  <?php endif ?>
</div>

<?php include_once('layouts/footer.php'); ?>