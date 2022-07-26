<?php
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home.php', false);}
?>
<div class="body2">
<div class="login-page">
  <div class="text-center">
    <h1 style="margin-top:25px">Bienvenido</h1>
    <!-- <i class="large material-icons">account_circle</i> -->
    <p style="font-size:16px;">Iniciar sesión </p>
  </div>
  <?php echo display_msg($msg); ?>
  <form method="post" action="auth.php" class="clearfix">
    <div class="form-group">
      <label for="username" class="control-label">Usuario</label>
      <input type="name" class="form-control" name="username" placeholder="Usuario">
    </div>
    <div class="form-group">
      <label for="Password" class="control-label">Contraseña</label>
      <input type="password" name= "password" class="form-control" placeholder="Contraseña">
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-info  pull-right">Entrar</button>
    </div>
  </form>
</div>
</div>
<?php include_once('layouts/header.php'); ?>
