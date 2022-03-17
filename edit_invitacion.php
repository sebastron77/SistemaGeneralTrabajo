<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Editar Invitación';
require_once('includes/load.php');
$user = current_user();
$detalle = $user['id'];
$e_invitacion = find_by_id('invitaciones', (int)$_GET['id']);
$id_folio = last_id_folios();
page_require_level(2);
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['edit_invitacion'])) {

    $req_fields = array('nombre_evento', 'fecha_evento', 'hora', 'lugar', 'num_asistentes');
    validate_fields($req_fields);

    if (empty($errors)) {
        $id = (int)$e_invitacion['id'];
        $nombre_evento   = remove_junk($db->escape($_POST['nombre_evento']));
        $fecha_evento   = remove_junk($db->escape($_POST['fecha_evento']));
        $hora   = remove_junk($db->escape($_POST['hora']));
        $lugar   = remove_junk($db->escape($_POST['lugar']));
        $num_asistentes   = remove_junk(($db->escape($_POST['num_asistentes'])));
        $adjunto   = remove_junk(($db->escape($_POST['adjunto'])));

        $folio_editar = $e_invitacion['folio'];
        $resultado = str_replace("/", "-", $folio_editar);
        $carpeta = 'uploads/invitaciones/' . $resultado;

        $name = $_FILES['adjunto']['name'];
        $size = $_FILES['adjunto']['size'];
        $type = $_FILES['adjunto']['type'];
        $temp = $_FILES['adjunto']['tmp_name'];

        if (is_dir($carpeta)) {
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        }

        if ($name != '') {
            $sql = "UPDATE invitaciones SET nombre_evento='{$nombre_evento}', fecha_evento='{$fecha_evento}', hora='{$hora}', lugar='{$lugar}', num_asistentes='{$num_asistentes}', adjunto='{$name}' WHERE id='{$db->escape($id)}'";
        }
        if ($name == '') {
            $sql = "UPDATE invitaciones SET nombre_evento='{$nombre_evento}', fecha_evento='{$fecha_evento}', hora='{$hora}', lugar='{$lugar}', num_asistentes='{$num_asistentes}' WHERE id='{$db->escape($id)}'";
        }
        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            //sucess
            $session->msg('s', " La invitación ha sido editada con éxito.");
            redirect('invitaciones.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo editar la invitación.');
            redirect('edit_invitacion.php?id=' . (int)$e_invitacion['id'], false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_invitacion.php?id=' . (int)$e_invitacion['id'], false);
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
                <span>Editar invitación</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="edit_invitacion.php?id=<?php echo (int)$e_invitacion['id']; ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="nombre_evento">Nombre del evento</label>
                            <input type="text" class="form-control" name="nombre_evento" value="<?php echo remove_junk($e_invitacion['nombre_evento']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_evento">Fecha del evento</label>
                            <input type="date" class="form-control" name="fecha_evento" value="<?php echo remove_junk($e_invitacion['fecha_evento']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="hora">Hora</label>
                            <input type="time" class="form-control" name="hora" value="<?php echo remove_junk($e_invitacion['hora']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="num_asistentes">Numero de asistentes</label><br>
                            <input type="number" class="form-control" min="1" name="num_asistentes" value="<?php echo remove_junk($e_invitacion['num_asistentes']); ?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="lugar">Lugar</label>
                            <input type="text" class="form-control" name="lugar" value="<?php echo remove_junk($e_invitacion['lugar']); ?>" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="adjunto">Adjuntar Fomato</label>
                            <input type="file" accept="application/pdf" class="form-control" name="adjunto" value="<?php echo remove_junk($e_invitacion['adjunto']); ?>" id="adjunto">
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="invitaciones.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="edit_invitacion" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>