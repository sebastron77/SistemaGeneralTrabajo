<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Lista de quejas';

require_once('includes/load.php');

// page_require_level(1);
// page_require_level(5);
$quejas_libro = find_all('quejas');

$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
$nivel_user = $user['user_level'];

if ($nivel_user <= 2) {
  page_require_level(2);
}
if ($nivel_user == 5) {
  page_require_level_exacto(5);
}
if ($nivel_user == 7) {
  page_require_level_exacto(7);
}

if ($nivel_user > 2 && $nivel_user < 5) :
  redirect('home.php');
endif;
if ($nivel_user > 5 && $nivel_user < 7) :
  redirect('home.php');
endif;
if ($nivel_user > 7) :
  redirect('home.php');
endif;

?>
<?php include_once('layouts/header.php'); ?>
<a href="solicitudes_quejas.php" class="btn btn-success">Regresar</a>
<a href="quejas_agregadas.php" class="btn btn-primary">Quejas Registradas en Libro Electrónico</a><br><br>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>

<?php
require_once('includes/sql2.php');
$quejas = quejas();
?>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Quejas</span> &nbsp &nbsp | &nbsp &nbsp <a target="_blank" href="http://177.229.209.29/quejas/upload/scp/" style="text-decoration: none; color:#F08800; border: ridge #F08800 1px; border-radius: 3px;">Agregar queja en el Sistema de Quejas</a>
        </strong>
      </div>
      <div class="panel-body">
        <table class="datatable table table-bordered table-striped">
          <thead>
            <tr class="info">
              <th style="width: 1%;">Última Actualización</th>
              <th style="width: 3%;">Autoridad Responsable</th>
              <th style="width: 3%;">Agraviado</th>
              <th style="width: 1%;">Estatus Queja</th>
              <th style="width: 3%;">Asignado a</th>
              <?php if (($nivel <= 2) || ($nivel == 5)) : ?>
                <th style="width: 3%;">Agregar a Libro Electrónico</th>
              <?php endif; ?>

            </tr>
          </thead>
          <tbody>
            <?php foreach ($quejas as $queja) : ?>
              <?php $a = count($quejas_libro) ?>
              <?php if ($a != 0) : ?>
                <?php $c = 0; ?>
                <?php foreach ($quejas_libro as $queja_libro) : ?>
                  <?php if ($queja['ticket_id'] != $queja_libro['ticket_id']) : ?>
                    <?php $c = $c + 1; ?>
                    <?php if (($c <= 1)) : ?>
                      <tr>
                        <td class="text-center"> <?php echo remove_junk(ucwords($queja['Ultima_Actualizacion'])); ?></td>
                        <td> <?php echo remove_junk(($queja['n_autoridad'])); ?></td>
                        <td> <?php echo remove_junk(($queja['Creado_Por'])); ?></td> <!-- Es el agraviado -->
                        <td class="text-center">
                          <?php
                          if ($queja['isanswered'] == 1) {
                            echo '<strong><div style="color:#00B023">';
                            echo 'Cerrada';
                            echo '</div></strong>';
                          }
                          if (($queja['isanswered'] == 0) && ($queja['isoverdue'] == 1)) {
                            echo '<strong><div style="color:#2268FE">';
                            echo 'Abierta';
                            echo '</div></strong>';
                          }
                          if (($queja['isanswered'] == 0) && ($queja['isoverdue'] == 0)) {
                            echo '<strong><div style="color:orange">';
                            echo 'Pendiente';
                            echo '</div></strong>';
                          }
                          if (($queja['isanswered'] == 0) && ($queja['isoverdue'] == 1)) {
                            echo '<strong><div style="color:#FE3B29">';
                            echo 'No atendido';
                            echo '</div></strong>';
                          }
                          ?>
                        </td>
                        <td> <?php echo remove_junk(($queja['Asignado_Nombre'])) . " " . ($queja['Asignado_Apellido']); ?></td>
                        <?php if (($nivel <= 2) || ($nivel == 5)) : ?>
                          <td class="text-center">
                            <?php
                              // ----------------------------------------- OPCION DE CONEXION 1 -----------------------------------------
                              // $dbhost = "localhost";
                              // $dbuser = "root";
                              // $dbpass = "";
                              // $dbname = "libro_electronico2";
                              
                              // $obj_conexion = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

                              //   if(!$obj_conexion)
                              //     {
                              //       echo "Existe un problema con la conexión a la base de datos";
                              //     }
                              //     else
                              //     {
                              //       $link = mysqli_connect($dbhost, $dbuser, $dbpass) or die ("Conection Error: " . mysqli_error());
                              //         mysqli_select_db($link,$dbname) or die("Error conecting to db.");
                              //     }
                              // --------------------------------------------------------------------------------------------------------
                              
                              
                              // ----------------------------------------- OPCION DE CONEXION 2 -----------------------------------------                              

                              // $busca = find_by_ticket_id('quejas',$queja['ticket_id']); 
                              $link = mysqli_connect('localhost', 'root', '', 'libro_electronico2');
                              // mysqli_select_db($link,'libro_electronico2');
                              $sql = "SELECT * FROM quejas WHERE ticket_id = '{$queja['ticket_id']}'";
                              // En la linea de abajpo para que funcione con la otra forma de conexion, en lugar de $link es $obj_conexion
                              $resultado = mysqli_query($link, $sql); //or die(mysqli_error($link));
                              $row = mysqli_fetch_array($resultado);
                              // --------------------------------------------------------------------------------------------------------
                            ?>
                            <?php if (($queja['ticket_id'] != $row['ticket_id'])) : ?>
                              <a href="add_queja.php?id=<?php echo (int)$queja['ticket_id']; ?>" class="btn btn-success btn-sm" data-toggle="tooltip">
                                Agregar
                              </a>
                              <?php //echo $row['ticket_id'];?>
                            <?php else : echo 'Queja ya registrada.' ?>
                            <?php endif; ?>
                          </td>
                        <?php endif; ?>
                      </tr>
                    <?php endif; ?>
                  <?php endif; ?>
                <?php endforeach; ?>
              <?php endif; ?>
              <?php if ($a == 0) : ?>
                <?php if (($queja['ticket_id'] != $queja_libro['ticket_id'])) : ?>
                  <tr>
                    <td class="text-center"> <?php echo remove_junk(ucwords($queja['Ultima_Actualizacion'])); ?></td>
                    <td> <?php echo remove_junk(($queja['n_autoridad'])); ?></td>
                    <td> <?php echo remove_junk(($queja['Creado_Por'])); ?></td>
                    <td class="text-center">
                      <?php
                      if ($queja['isanswered'] == 1) {
                        echo '<strong><div style="color:#00B023">';
                        echo 'Cerrada';
                        echo '</div></strong>';
                      }
                      if (($queja['isanswered'] == 0) && ($queja['isoverdue'] == 1)) {
                        echo '<strong><div style="color:#2268FE">';
                        echo 'Abierta';
                        echo '</div></strong>';
                      }
                      if (($queja['isanswered'] == 0) && ($queja['isoverdue'] == 0)) {
                        echo '<strong><div style="color:orange">';
                        echo 'Pendiente';
                        echo '</div></strong>';
                      }
                      if (($queja['isanswered'] == 0) && ($queja['isoverdue'] == 1)) {
                        echo '<strong><div style="color:#FE3B29">';
                        echo 'No atendido';
                        echo '</div></strong>';
                      }
                      ?>
                    </td>
                    <td> <?php echo remove_junk(($queja['Asignado_Nombre'])) . " " . ($queja['Asignado_Apellido']); ?></td>
                    <?php if (($nivel <= 2) || ($nivel == 5)) : ?>
                      <td class="text-center">
                        <?php if (($queja['ticket_id'] != $queja_libro['ticket_id'])) : ?>
                          <a href="add_queja.php?id=<?php echo (int)$queja['ticket_id']; ?>" class="btn btn-success btn-sm" data-toggle="tooltip">
                            Agregar
                          </a>
                        <?php else : echo 'Queja ya registrada.' ?>
                        <?php endif; ?>
                      </td>
                    <?php endif; ?>
                  </tr>
                <?php endif; ?>
              <?php endif; ?>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>