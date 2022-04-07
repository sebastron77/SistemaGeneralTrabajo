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
    <div class="panel" style="background-color: #EEEAEA; border-radius: 10px;">
      <div class="jumbotron text-center" style="background-color: #f9f9f9; border-radius: 15px; border: 2px solid rgb(214, 214, 214);">
         <h1 style="color: #114987;">Página principal</h1> 
         <h4 style="color: #0b3766">Libro Electrónico de la Comisión Estatal de los Derechos Humanos</h4>    
      </div>
    </div>
 </div>
</div>
<?php include_once('layouts/footer.php'); ?>
