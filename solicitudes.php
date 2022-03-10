<?php
$page_title = 'Admin - Página de Inicio';
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


<h1>Solicitudes de servicios</h1>


<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row" style="margin-top: 10px;">
  <?php if (($otro <= 2)) : ?>
    <div href="#" class="col-md-3" style="height: 12.5rem;">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left" style="background: #c48840;">
          <svg style="width:59px;height:58px" viewBox="0 0 24 24">
            <path fill="white" d="M12 3C14.21 3 16 4.79 16 7S14.21 11 12 11 8 9.21 8 7 9.79 3 12 3M16 13.54C16 14.6 15.72 17.07 13.81 19.83L13 15L13.94 13.12C13.32 13.05 12.67 13 12 13S10.68 13.05 10.06 13.12L11 15L10.19 19.83C8.28 17.07 8 14.6 8 13.54C5.61 14.24 4 15.5 4 17V21H20V17C20 15.5 18.4 14.24 16 13.54Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <p style="font-size: 20px; margin-top:8%;">Presidencia</p>
          <div><br>
            <!-- <a href="add_convenio.php" class="btn btn-success">Agregar</a>
          <a href="convenios.php" class="btn btn-primary">Ver</a> -->
          </div>
        </div>
      </div>
    </div>
  <?php endif ?>
  <?php if (($otro <= 3)) : ?>
    <div href="#" class="col-md-3" style="height: 12.5rem;">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left" style="background: #5AA82A;">
          <svg style="width:59px;height:58px" viewBox="0 0 24 24">
            <path fill="white" d="M14 2H6C4.9 2 4 2.9 4 4V20C4 21.1 4.9 22 6 22H18C19.1 22 20 21.1 20 20V8L14 2M18 20H6V4H13V9H18V20M9.5 18L10.2 15.2L8 13.3L10.9 13.1L12 10.4L13.1 13L16 13.2L13.8 15.1L14.5 17.9L12 16.5L9.5 18Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <p style="font-size: 20px; margin-top:8%;">Convenios</p>
          <div><br>
            <a href="add_convenio.php" class="btn btn-success">Agregar</a>
            <a href="convenios.php" class="btn btn-primary">Ver</a>
          </div>
        </div>
      </div>
    </div>
  <?php endif ?>
  <?php if (($otro == 4) || ($otro <= 2)) : ?>
    <div href="#" class="col-md-3" style="height: 12.5rem;">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left" style="background: #37B6FE;">
          <svg style="width:59px;height:58px" viewBox="0 0 24 24">
            <path fill="white" d="M13 3C16.9 3 20 6.1 20 10C20 12.8 18.4 15.2 16 16.3V21H9V18H8C6.9 18 6 17.1 6 16V13H4.5C4.1 13 3.8 12.5 4.1 12.2L6 9.7C6.2 5.9 9.2 3 13 3M13 1C8.4 1 4.6 4.4 4.1 8.9L2.5 11C1.9 11.7 1.8 12.7 2.2 13.6C2.6 14.3 3.2 14.8 4 15V16C4 17.9 5.3 19.4 7 19.9V23H18V17.5C20.5 15.9 22 13.1 22 10C22 5 18 1 13 1M17 10H14V13H12V10H9V8H12V5H14V8H17V10Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <p style="font-size: 20px; margin-top:8%;">Capacitación</p>
          <div><br>
            <a href="add_capacitacion.php" class="btn btn-success">Agregar</a>
            <a href="capacitaciones.php" class="btn btn-primary">Ver</a>
          </div>
        </div>
      </div>
    </div>
  <?php endif ?>
  <?php if (($otro == 4) || ($otro <= 2)) : ?>
    <div class="col-md-3" style="height: 12.5rem;">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left" style="background: #F52929;">
          <svg style="width:59px;height:58px" viewBox="0 0 24 24">
            <path fill="white" d="M18,14H14V18H10V14H6V10H10V6H14V10H18M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
          </svg>
        </div>
        <div>
          <p style="font-size: 20px; margin-top:3%;">Área Médica y <br> Psicológica</p>
          <div>
            <a href="add_ficha.php" class="btn btn-success">Agregar</a>
            <a href="fichas.php" class="btn btn-primary">Ver</a>
          </div>
        </div>
      </div>
    </div>
  <?php endif ?>

</div><br>
<div class="row" style="margin-top: 50px;">
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
        <div class="panel-icon pull-left" style="background: #5338FF;">
          <svg style="width:59px;height:58px" viewBox="0 0 24 24">
            <path fill="white" d="M16.75 4.36C18.77 6.56 18.77 9.61 16.75 11.63L15.07 9.94C15.91 8.76 15.91 7.23 15.07 6.05L16.75 4.36M20.06 1C24 5.05 23.96 11.11 20.06 15L18.43 13.37C21.2 10.19 21.2 5.65 18.43 2.63L20.06 1M9 4C11.2 4 13 5.79 13 8S11.2 12 9 12 5 10.21 5 8 6.79 4 9 4M13 14.54C13 15.6 12.71 18.07 10.8 20.83L10 16L10.93 14.12C10.31 14.05 9.66 14 9 14S7.67 14.05 7.05 14.12L8 16L7.18 20.83C5.27 18.07 5 15.6 5 14.54C2.6 15.24 .994 16.5 .994 18V22H17V18C17 16.5 15.39 15.24 13 14.54Z" />
          </svg>
        </div>
        <div>
          <p style="font-size: 20px; margin-top:5%;">Orientación</p>
          <div><br>
            <a href="add_orientacion.php" class="btn btn-success">Agregar</a>
            <a href="orientaciones.php" class="btn btn-primary">Ver</a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3" style="height: 12.5rem;">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left" style="background: #FFD31A;">
          <svg style="width:59px;height:58px" viewBox="0 0 24 24">
            <path fill="white" d="M8,14V18L2,12L8,6V10H16V6L22,12L16,18V14H8Z" />
          </svg>
        </div>
        <div>
          <p style="font-size: 20px; margin-top:5%;">Canalización</p>
          <div><br>
            <a href="add_canalizacion.php" class="btn btn-success">Agregar</a>
            <a href="canalizaciones.php" class="btn btn-primary">Ver</a>
          </div>
        </div>
      </div>
    </div>
  <?php endif ?>

  
  <?php if (($otro <= 2)) : ?>
    <div class="col-md-3" style="height: 12.5rem;">
      <a href="#">
        <div class="panel panel-box clearfix">
          <div class="panel-icon pull-left" style="background: #278A5A;">
            <svg style="width:59px;height:58px" viewBox="0 0 24 24">
              <path fill="white" d="M22.61,19L13.53,9.91C14.46,7.57 14,4.81 12.09,2.91C9.79,0.61 6.21,0.4 3.66,2.26L7.5,6.11L6.08,7.5L2.25,3.69C0.39,6.23 0.6,9.82 2.9,12.11C4.76,13.97 7.47,14.46 9.79,13.59L18.9,22.7C19.29,23.09 19.92,23.09 20.31,22.7L22.61,20.4C23,20 23,19.39 22.61,19M19.61,20.59L10.15,11.13C9.54,11.58 8.86,11.85 8.15,11.95C6.79,12.15 5.36,11.74 4.32,10.7C3.37,9.76 2.93,8.5 3,7.26L6.09,10.35L10.33,6.11L7.24,3C8.5,2.95 9.73,3.39 10.68,4.33C11.76,5.41 12.17,6.9 11.92,8.29C11.8,9 11.5,9.66 11.04,10.25L20.5,19.7L19.61,20.59Z" />
            </svg>
          </div>
          <div class="panel-value pull-right">
            <p style="font-size: 20px; margin-top:20%; color:#333333;">Gestión</p>
          </div>
        </div>
      </a>
    </div>
  <?php endif ?>
</div><br>
<?php include_once('layouts/footer.php'); ?>