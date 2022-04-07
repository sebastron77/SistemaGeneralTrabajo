<?php
$page_title = 'Agregar usuarios';
require_once('includes/load.php');

page_require_level(1);
$groups = find_all('grupo_usuarios');
$trabajadores = find_all_trabajadores();
?>
<?php
if (isset($_POST['add_user'])) {

  $req_fields = array('detalle-usuario', 'username', 'contraseña', 'level');
  validate_fields($req_fields);

  if (empty($errors)) {
    $detalle   = remove_junk($db->escape($_POST['detalle-usuario']));
    $username   = remove_junk($db->escape($_POST['username']));
    $password   = remove_junk($db->escape($_POST['contraseña']));
    $user_level = (int)$db->escape($_POST['level']);
    $password = sha1($password);
    $query = "INSERT INTO users (";
    $query .= "id_detalle_user,username,password,user_level,status";
    $query .= ") VALUES (";
    $query .= " '{$detalle}', '{$username}', '{$password}', '{$user_level}','1'";
    $query .= ")";
    if ($db->query($query)) {
      //sucess
      $session->msg('s', " La cuenta de usuario ha sido creada con éxito.");
      redirect('add_user.php', false);
    } else {
      //failed
      $session->msg('d', ' No se pudo crear la cuenta.');
      redirect('add_user.php', false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('add_user.php', false);
  }
}
?>
<?php include_once('layouts/header.php'); ?>
<?php echo display_msg($msg); ?>
<div class="row">
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong>
        <span class="glyphicon glyphicon-th"></span>
        <span>Agregar usuario</span>
      </strong>
    </div>
    <div class="panel-body">
      <div class="col-md-6">
        <form method="post" action="add_user.php">
          <div class="form-group">
            <label for="level">Trabajador</label>
            <select class="form-control" name="detalle-usuario">
              <?php foreach ($trabajadores as $trabajador) : ?>
                <option value="<?php echo $trabajador['detalleID']; ?>"><?php echo ucwords($trabajador['nombre']); ?> <?php echo ucwords($trabajador['apellidos']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" placeholder="Nombre de usuario">
          </div>
          <div class="form-group">
            <label for="contraseña">Contraseña</label>
            <input type="password" class="form-control" name="contraseña" placeholder="Contraseña">
          </div>
          <div class="form-group">
            <label for="level">Rol de usuario</label>
            <select class="form-control" name="level">
              <?php foreach ($groups as $group) : ?>
                <option value="<?php echo $group['nivel_grupo']; ?>"><?php echo ucwords($group['nombre_grupo']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group clearfix">
            <a href="users.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
              Regresar
            </a>
            <button type="submit" name="add_user" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>

    </div>

  </div>
</div>

<?php include_once('layouts/footer.php'); ?>