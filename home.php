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
    <div class="panel">
      <div class="jumbotron text-center">
         <h1>Página principal</h1> 
         <h4>Sistema Integral para la Gestión del Inventario de Equipo de Cómputo de la CEDH (SIGIEC)</h4>    
      </div>
    </div>
 </div>
</div>
<?php include_once('layouts/footer.php'); ?>
