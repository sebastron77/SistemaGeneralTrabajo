<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar Invitación';
require_once('includes/load.php');
$user = current_user();
$detalle = $user['id'];
$id_ori_canal = last_id_oricanal();
$id_folio = last_id_folios();
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];

if ($nivel <= 2) {
    page_require_level(2);
}
if ($nivel == 3) {
    redirect('home.php');
}
if ($nivel == 4) {
    redirect('home.php');
}
if ($nivel == 5) {
    redirect('home.php');    
}
if ($nivel == 6) {
    redirect('home.php');
}
if ($nivel == 7) {
    page_require_level(7);
}
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['add_invitacion'])) {

    $req_fields = array('nombre_evento', 'fecha_evento', 'hora', 'lugar', 'num_asistentes');
    validate_fields($req_fields);

    if (empty($errors)) {
        $nombre_evento   = remove_junk($db->escape($_POST['nombre_evento']));
        $fecha_evento   = remove_junk($db->escape($_POST['fecha_evento']));
        $hora   = remove_junk($db->escape($_POST['hora']));
        $lugar   = remove_junk($db->escape($_POST['lugar']));
        $num_asistentes   = remove_junk(($db->escape($_POST['num_asistentes'])));
        $adjunto   = remove_junk(($db->escape($_POST['adjunto'])));

        //Suma el valor del id anterior + 1, para generar ese id para el nuevo resguardo
        //La variable $no_folio sirve para el numero de folio

        if (count($id_folio) == 0) {
            $nuevo_id_folio = 1;
            $no_folio1 = sprintf('%04d', 1);
        } else {
            foreach ($id_folio as $nuevo) {
                $nuevo_id_folio = (int)$nuevo['id'] + 1;
                $no_folio1 = sprintf('%04d', (int)$nuevo['id'] + 1);
            }
        }

        //Se crea el número de folio
        $year = date("Y");
        // Se crea el folio orientacion
        $folio = 'CEDH/' . $no_folio1 . '/' . $year . '-INV';

        $folio_carpeta = 'CEDH-' . $no_folio1 . '-' . $year . '-INV';
        $carpeta = 'uploads/invitaciones/' . $folio_carpeta;

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $name = $_FILES['adjunto']['name'];
        $size = $_FILES['adjunto']['size'];
        $type = $_FILES['adjunto']['type'];
        $temp = $_FILES['adjunto']['tmp_name'];

        $move =  move_uploaded_file($temp, $carpeta . "/" . $name);

        if ($move && $name != '') {
            $query = "INSERT INTO invitaciones (";
            $query .= "folio, nombre_evento, fecha_evento, hora, lugar, num_asistentes, adjunto";
            $query .= ") VALUES (";
            $query .= " '{$folio}','{$nombre_evento}','{$fecha_evento}','{$hora}','{$lugar}','{$num_asistentes}','{$name}'";
            $query .= ")";

            $query2 = "INSERT INTO folios (";
            $query2 .= "folio, contador";
            $query2 .= ") VALUES (";
            $query2 .= " '{$folio}','{$no_folio1}'";
            $query2 .= ")";
        } else {
            $query = "INSERT INTO invitaciones (";
            $query .= "folio, nombre_evento, fecha_evento, hora, lugar, num_asistentes";
            $query .= ") VALUES (";
            $query .= " '{$folio}','{$nombre_evento}','{$fecha_evento}','{$hora}','{$lugar}','{$num_asistentes}'";
            $query .= ")";

            $query2 = "INSERT INTO folios (";
            $query2 .= "folio, contador";
            $query2 .= ") VALUES (";
            $query2 .= " '{$folio}','{$no_folio1}'";
            $query2 .= ")";
        }

        if ($db->query($query) && $db->query($query2)) {
            //sucess
            $session->msg('s', " La invitacion ha sido agregada con éxito.");
            redirect('invitaciones.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar la invitacion.');
            redirect('add_invitacion.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_invitacion.php', false);
    }
}
?>
<?php header('Content-type: text/html; charset=utf-8');
include_once('layouts/header.php'); ?>
<?php echo display_msg($msg); ?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Agregar Invitación</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_invitacion.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="nombre_evento">Nombre del evento</label>
                            <input type="text" class="form-control" name="nombre_evento" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_evento">Fecha del evento</label>
                            <input type="date" class="form-control" name="fecha_evento" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="hora">Hora</label>
                            <input type="time" class="form-control" name="hora" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="num_asistentes">Numero de asistentes</label><br>
                            <input type="number" class="form-control" min="1" name="num_asistentes" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="lugar">Lugar</label>
                            <input type="text" class="form-control" name="lugar" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="adjunto">Adjuntar Fomato</label>
                            <input type="file" accept="application/pdf" class="form-control" name="adjunto" id="adjunto">
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="invitaciones.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="add_invitacion" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>