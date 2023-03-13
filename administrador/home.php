<?php
  $page_title = 'Principal';
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
 <div class="col-md-12">
    <div class="panel" style="background-color: #1E2630; border-radius: 15px;">
      <div class="jumbotron text-center" style="background: #1E2630; color: white; border-radius: 15px; border: 1px solid rgb(5, 109, 205);">
         <h1 style="color: white;">Página principal</h1> 
         <h4 style="color: white">Libro Electrónico de la Comisión Estatal de los Derechos Humanos</h4>    
      </div>
    </div>
 </div>
</div>
<?php include_once('layouts/footer.php'); ?>
