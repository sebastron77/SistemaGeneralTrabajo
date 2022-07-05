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

page_require_level(50);

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
        <div class="panel-icon pull-left" style="background: #114987; display: grid; place-content: center;">
          <svg style="width:40px;height:63px" viewBox="0 0 24 24">
            <path fill="white" d="M12 3C14.21 3 16 4.79 16 7S14.21 11 12 11 8 9.21 8 7 9.79 3 12 3M16 13.54C16 14.6 15.72 17.07 13.81 19.83L13 15L13.94 13.12C13.32 13.05 12.67 13 12 13S10.68 13.05 10.06 13.12L11 15L10.19 19.83C8.28 17.07 8 14.6 8 13.54C5.61 14.24 4 15.5 4 17V21H20V17C20 15.5 18.4 14.24 16 13.54Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <p style="font-size: 16px; margin-top:8%; color:black;">Presidencia</p>
          <div><br>
            <!-- <a href="add_convenio.php" class="btn btn-success">Agregar</a>
          <a href="convenios.php" class="btn btn-primary">Ver</a> -->
          </div>
        </div>
      </div>
    </a>
  <?php endif ?>
  <?php if (($otro == 8) || ($otro <= 2)) : ?>
    <a href="solicitudes_secParticular.php" class="col-md-3" style="height: 12.5rem;">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left" style="background: #114987; display: grid; place-content: center;">
          <svg style="width:40px;height:63px" viewBox="0 0 24 24">
            <path fill="white" d="M12,2C6.47,2 2,6.5 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M15.6,8.34C16.67,8.34 17.53,9.2 17.53,10.27C17.53,11.34 16.67,12.2 15.6,12.2A1.93,1.93 0 0,1 13.67,10.27C13.66,9.2 14.53,8.34 15.6,8.34M9.6,6.76C10.9,6.76 11.96,7.82 11.96,9.12C11.96,10.42 10.9,11.5 9.6,11.5C8.3,11.5 7.24,10.42 7.24,9.12C7.24,7.81 8.29,6.76 9.6,6.76M9.6,15.89V19.64C7.2,18.89 5.3,17.04 4.46,14.68C5.5,13.56 8.13,13 9.6,13C10.13,13 10.8,13.07 11.5,13.21C9.86,14.08 9.6,15.23 9.6,15.89M12,20C11.72,20 11.46,20 11.2,19.96V15.89C11.2,14.47 14.14,13.76 15.6,13.76C16.67,13.76 18.5,14.15 19.44,14.91C18.27,17.88 15.38,20 12,20Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <p style="font-size: 16px; margin-top:8%; color:black;">Secretaría Particular</p>
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
        <div class="panel-icon pull-left" style="background: #114987; display: grid; place-content: center;">
          <svg style="width:40px;height:63px" viewBox="0 0 24 24">
            <path fill="white" d="M15,14C12.33,14 7,15.33 7,18V20H23V18C23,15.33 17.67,14 15,14M15,12A4,4 0 0,0 19,8A4,4 0 0,0 15,4A4,4 0 0,0 11,8A4,4 0 0,0 15,12M5,13.28L7.45,14.77L6.8,11.96L9,10.08L6.11,9.83L5,7.19L3.87,9.83L1,10.08L3.18,11.96L2.5,14.77L5,13.28Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <p style="font-size: 16px; margin-top:8%; color:black;">Secretaría Técnica</p>
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
        <div class="panel-icon pull-left" style="background: #114987; display: grid; place-content: center;">
          <svg style="width:40px;height:63px" viewBox="0 0 24 24">
            <path fill="white" d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <p style="font-size: 16px; margin-top:8%; color:black;">Secretaría Ejecutiva</p>
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
  <?php if (($otro == 6) || ($otro <= 2)) : ?>
    <a href="solicitudes_centro_estudios.php" class="col-md-3" style="height: 12.5rem;">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left" style="background: #114987; display: grid; place-content: center;">
          <svg style="width:40px;height:63px" viewBox="0 0 24 24">
            <path fill="white" d="M17.5 14.33C18.29 14.33 19.13 14.41 20 14.57V16.07C19.38 15.91 18.54 15.83 17.5 15.83C15.6 15.83 14.11 16.16 13 16.82V15.13C14.17 14.6 15.67 14.33 17.5 14.33M13 12.46C14.29 11.93 15.79 11.67 17.5 11.67C18.29 11.67 19.13 11.74 20 11.9V13.4C19.38 13.24 18.54 13.16 17.5 13.16C15.6 13.16 14.11 13.5 13 14.15M17.5 10.5C15.6 10.5 14.11 10.82 13 11.5V9.84C14.23 9.28 15.73 9 17.5 9C18.29 9 19.13 9.08 20 9.23V10.78C19.26 10.59 18.41 10.5 17.5 10.5M21 18.5V7C19.96 6.67 18.79 6.5 17.5 6.5C15.45 6.5 13.62 7 12 8V19.5C13.62 18.5 15.45 18 17.5 18C18.69 18 19.86 18.16 21 18.5M17.5 4.5C19.85 4.5 21.69 5 23 6V20.56C23 20.68 22.95 20.8 22.84 20.91C22.73 21 22.61 21.08 22.5 21.08C22.39 21.08 22.31 21.06 22.25 21.03C20.97 20.34 19.38 20 17.5 20C15.45 20 13.62 20.5 12 21.5C10.66 20.5 8.83 20 6.5 20C4.84 20 3.25 20.36 1.75 21.07C1.72 21.08 1.68 21.08 1.63 21.1C1.59 21.11 1.55 21.12 1.5 21.12C1.39 21.12 1.27 21.08 1.16 21C1.05 20.89 1 20.78 1 20.65V6C2.34 5 4.18 4.5 6.5 4.5C8.83 4.5 10.66 5 12 6C13.34 5 15.17 4.5 17.5 4.5Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <p style="font-size: 16px; margin-top:8%; color:black;">Centro de Estudios</p>
          <div><br>
          </div>
        </div>
      </div>
    </a>
  <?php endif ?>
  <?php if (($otro == 4) || ($otro <= 2)) : ?>
    <a href="solicitudes_medica_psic.php" class="col-md-3" style="height: 12.5rem;">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left" style="background: #114987; display: grid; place-content: center;">
          <svg style="width:40px;height:63px" viewBox="0 0 24 24">
            <path fill="white" d="M18,14H14V18H10V14H6V10H10V6H14V10H18M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <p style="font-size: 16px; margin-top:8%; color:black;">Subcoor-<br>dinación de Servicios Técnicos</p>
          <div><br>
          </div>
        </div>
      </div>
    </a>
  <?php endif ?>
  <?php if (($otro == 5) || ($otro <= 2)) : ?>
    <a href="solicitudes_quejas.php" class="col-md-3" style="height: 12.5rem;">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left" style="background: #114987; display: grid; place-content: center;">
          <svg style="width:40px;height:63px" viewBox="0 0 24 24">
            <path fill="white" d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <p style="font-size: 16px; margin-top:8%; color:black;">Registro de Quejas y Seguimiento</p>
          <div><br>
          </div>
        </div>
      </div>
    </a>
  <?php endif ?>
  <?php if (($otro == 13) || ($otro <= 2)) : ?>
    <a href="solicitudes_sistemas.php" class="col-md-3" style="height: 12.5rem;">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left" style="background: #114987; display: grid; place-content: center;">
          <svg style="width:40px;height:63px" viewBox="0 0 24 24">
            <path fill="white" d="M6,2C4.89,2 4,2.89 4,4V12C4,13.11 4.89,14 6,14H18C19.11,14 20,13.11 20,12V4C20,2.89 19.11,2 18,2H6M6,4H18V12H6V4M4,15C2.89,15 2,15.89 2,17V20C2,21.11 2.89,22 4,22H20C21.11,22 22,21.11 22,20V17C22,15.89 21.11,15 20,15H4M8,17H20V20H8V17M9,17.75V19.25H13V17.75H9M15,17.75V19.25H19V17.75H15Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <p style="font-size: 16px; margin-top:8%; color:black;">Coordinación de Sistemas de Informática</p>
          <div><br>
          </div>
        </div>
      </div>
    </a>
  <?php endif ?>
</div><br>
<div class="row">
  <?php if (($otro == 9) || ($otro <= 2)) : ?>
    <a href="solicitudes_servicios_tecnicos.php" class="col-md-3" style="height: 12.5rem;">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left" style="background: #114987; display: grid; place-content: center;">
          <svg style="width:40px;height:63px" viewBox="0 0 24 24">
            <path fill="white" d="M5,3C3.89,3 3,3.89 3,5V19C3,20.11 3.89,21 5,21H11V3M13,3V11H21V5C21,3.89 20.11,3 19,3M13,13V21H19C20.11,21 21,20.11 21,19V13" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <p style="font-size: 16px; margin-top:8%; color:black;">Servicios Técnicos</p>
          <div><br>
          </div>
        </div>
      </div>
    </a>
  <?php endif ?>
  <?php if (($otro == 10) || ($otro <= 2)) : ?>
    <a href="solicitudes_transparencia.php" class="col-md-3" style="height: 12.5rem;">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left" style="background: #114987; display: grid; place-content: center;">
          <svg style="width:40px;height:63px" viewBox="0 0 24 24">
            <path fill="white" d="M9.3 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4H10L12 6H20C21.1 6 22 6.9 22 8V14.6C21.4 14.2 20.7 13.8 20 13.5V8H4V18H9.3C9.3 18.1 9.2 18.2 9.2 18.3L8.8 19L9.1 19.7C9.2 19.8 9.2 19.9 9.3 20M23 19C22.1 21.3 19.7 23 17 23S11.9 21.3 11 19C11.9 16.7 14.3 15 17 15S22.1 16.7 23 19M19.5 19C19.5 17.6 18.4 16.5 17 16.5S14.5 17.6 14.5 19 15.6 21.5 17 21.5 19.5 20.4 19.5 19M17 18C16.4 18 16 18.4 16 19S16.4 20 17 20 18 19.6 18 19 17.6 18 17 18" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <p style="font-size: 16px; margin-top:8%; color:black;">Transparen-<br>cia</p>
          <div><br>
          </div>
        </div>
      </div>
    </a>
  <?php endif ?>
  <?php if (($otro == 11) || ($otro <= 2)) : ?>
    <a href="solicitudes_archivo.php" class="col-md-3" style="height: 12.5rem;">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left" style="background: #114987; display: grid; place-content: center;">
          <svg style="width:40px;height:63px" viewBox="0 0 24 24">
            <path fill="white" d="M2,10.96C1.5,10.68 1.35,10.07 1.63,9.59L3.13,7C3.24,6.8 3.41,6.66 3.6,6.58L11.43,2.18C11.59,2.06 11.79,2 12,2C12.21,2 12.41,2.06 12.57,2.18L20.47,6.62C20.66,6.72 20.82,6.88 20.91,7.08L22.36,9.6C22.64,10.08 22.47,10.69 22,10.96L21,11.54V16.5C21,16.88 20.79,17.21 20.47,17.38L12.57,21.82C12.41,21.94 12.21,22 12,22C11.79,22 11.59,21.94 11.43,21.82L3.53,17.38C3.21,17.21 3,16.88 3,16.5V10.96C2.7,11.13 2.32,11.14 2,10.96M12,4.15V4.15L12,10.85V10.85L17.96,7.5L12,4.15M5,15.91L11,19.29V12.58L5,9.21V15.91M19,15.91V12.69L14,15.59C13.67,15.77 13.3,15.76 13,15.6V19.29L19,15.91M13.85,13.36L20.13,9.73L19.55,8.72L13.27,12.35L13.85,13.36Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <p style="font-size: 16px; margin-top:8%; color:black;">Archivo</p>
          <div><br>
          </div>
        </div>
      </div>
    </a>
  <?php endif ?>
  <?php if (($otro == 12) || ($otro <= 2)) : ?>
    <a href="solicitudes_desaparecidos.php" class="col-md-3" style="height: 12.5rem;">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left" style="background: #114987; display: grid; place-content: center;">
          <svg style="width:40px;height:63px" viewBox="0 0 24 24">
            <path fill="white" d="M12,2A2,2 0 0,1 14,4A2,2 0 0,1 12,6A2,2 0 0,1 10,4A2,2 0 0,1 12,2M10.5,7H13.5A2,2 0 0,1 15.5,9V14.5H14V22H10V14.5H8.5V9A2,2 0 0,1 10.5,7Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <p style="font-size: 16px; margin-top:8%; color:black;">Desapare-<br>cidos</p>
          <div><br>
          </div>
        </div>
      </div>
    </a>
  <?php endif ?>
</div><br>
<div class="row">
  <?php if (($otro == 14) || ($otro <= 2)) : ?>
    <a href="solicitudes_administrativo.php" class="col-md-3" style="height: 12.5rem;">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left" style="background: #114987; display: grid; place-content: center;">
          <svg style="width:40px;height:63px" viewBox="0 0 24 24">
            <path fill="white" d="M12.9 4.22C18.73 6.84 20 2 20 2S18.89 8.07 13.79 10.55C12.75 11.06 12.1 11.33 12.1 11.33L3.73 7.25L12.1 3.82C12.1 3.82 11.9 3.76 12.9 4.22M11.12 22L3.33 17.78V9.07L11.12 13.04V22M12.88 22L20.68 17.78V9.07L12.88 13.04V22Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <p style="font-size: 16px; margin-top:8%; color:black;">Coordina-<br>ción Administra-<br>tiva</p>
          <div><br>
          </div>
        </div>
      </div>
    </a>
  <?php endif ?>
  <?php if (($otro == 15) || ($otro <= 2)) : ?>
    <a href="solicitudes_comunicacion_social.php" class="col-md-3" style="height: 12.5rem;">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left" style="background: #114987; display: grid; place-content: center;">
          <svg style="width:40px;height:63px" viewBox="0 0 24 24">
            <path fill="white" d="M9,5A4,4 0 0,1 13,9A4,4 0 0,1 9,13A4,4 0 0,1 5,9A4,4 0 0,1 9,5M9,15C11.67,15 17,16.34 17,19V21H1V19C1,16.34 6.33,15 9,15M16.76,5.36C18.78,7.56 18.78,10.61 16.76,12.63L15.08,10.94C15.92,9.76 15.92,8.23 15.08,7.05L16.76,5.36M20.07,2C24,6.05 23.97,12.11 20.07,16L18.44,14.37C21.21,11.19 21.21,6.65 18.44,3.63L20.07,2Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <p style="font-size: 16px; margin-top:8%; color:black;">Comunica-<br>ción Social</p>
          <div><br>
          </div>
        </div>
      </div>
    </a>
  <?php endif ?>
  <?php if (($otro == 16) || ($otro <= 2)) : ?>
    <a href="solicitudes_organo_interno.php" class="col-md-3" style="height: 12.5rem;">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left" style="background: #114987; display: grid; place-content: center;">
          <svg style="width:40px;height:63px" viewBox="0 0 24 24">
            <path fill="white" d="M12,2C6.47,2 2,6.5 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M15.6,8.34C16.67,8.34 17.53,9.2 17.53,10.27C17.53,11.34 16.67,12.2 15.6,12.2A1.93,1.93 0 0,1 13.67,10.27C13.66,9.2 14.53,8.34 15.6,8.34M9.6,6.76C10.9,6.76 11.96,7.82 11.96,9.12C11.96,10.42 10.9,11.5 9.6,11.5C8.3,11.5 7.24,10.42 7.24,9.12C7.24,7.81 8.29,6.76 9.6,6.76M9.6,15.89V19.64C7.2,18.89 5.3,17.04 4.46,14.68C5.5,13.56 8.13,13 9.6,13C10.13,13 10.8,13.07 11.5,13.21C9.86,14.08 9.6,15.23 9.6,15.89M12,20C11.72,20 11.46,20 11.2,19.96V15.89C11.2,14.47 14.14,13.76 15.6,13.76C16.67,13.76 18.5,14.15 19.44,14.91C18.27,17.88 15.38,20 12,20Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <p style="font-size: 16px; margin-top:8%; color:black;">Órgano Interno de Control</p>
          <div><br>
          </div>
        </div>
      </div>
    </a>
  <?php endif ?>
  <?php if (($otro == 17) || ($otro <= 2)) : ?>
    <a href="solicitudes_agendas.php" class="col-md-3" style="height: 12.5rem;">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left" style="background: #114987; display: grid; place-content: center;">
          <svg style="width:40px;height:63px" viewBox="0 0 24 24">
            <path fill="white" d="M9.05,9H7.06V6H9.05V4.03H7.06V3.03C7.06,1.92 7.95,1.04 9.05,1.04H15.03V8L17.5,6.5L20,8V1.04H21C22.05,1.04 23,2 23,3.03V17C23,18.03 22.05,19 21,19H9.05C8,19 7.06,18.05 7.06,17V16H9.05V14H7.06V11H9.05V9M1,18H3V15H1V13H3V10H1V8H3V5H5V8H3V10H5V13H3V15H5V18H3V20H5V21H21V23H5A2,2 0 0,1 3,21V20H1V18Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <p style="font-size: 16px; margin-top:8%; color:black;">Agendas y Mecanismos</p>
          <div><br>
          </div>
        </div>
      </div>
    </a>
  <?php endif ?>
</div><br>
<div class="row">

</div>

<?php include_once('layouts/footer.php'); ?>