<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Editar Resolución';
require_once('includes/load.php');
$user = current_user();
$detalle = $user['id'];
$e_resolucion = find_by_id_resolucion((int)$_GET['id']);
$id_folio = last_id_folios();
page_require_level(2);
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['edit_resolucion'])) {

    $req_fields = array('num_expediente', 'visitaduria', 'fecha_recepcion', 'fecha_remite_proyecto', 'observaciones');
    validate_fields($req_fields);

    if (empty($errors)) {
        $id = (int)$e_resolucion['id'];
        $num_expediente   = remove_junk($db->escape($_POST['num_expediente']));
        $visitaduria   = remove_junk($db->escape($_POST['visitaduria']));
        $fecha_recepcion   = remove_junk($db->escape($_POST['fecha_recepcion']));
        $fecha_remite_proyecto   = remove_junk($db->escape($_POST['fecha_remite_proyecto']));
        // $oficio_caratula   = remove_junk(upper_case($db->escape($_POST['oficio_caratula'])));
        $observaciones   = remove_junk(upper_case($db->escape($_POST['observaciones'])));
        $adjunto   = remove_junk($db->escape($_POST['adjunto']));

        $folio_editar = $e_resolucion['folio'];
        $resultado = str_replace("/", "-", $folio_editar);
        $carpeta = 'uploads/resoluciones/' . $resultado;

        $name = $_FILES['adjunto']['name'];
        $size = $_FILES['adjunto']['size'];
        $type = $_FILES['adjunto']['type'];
        $temp = $_FILES['adjunto']['tmp_name'];

        if (is_dir($carpeta)) {
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        }

        if ($name != '') {
            $sql = "UPDATE resoluciones SET num_expediente='{$num_expediente}', visitaduria='{$visitaduria}', fecha_recepcion='{$fecha_recepcion}', fecha_remite_proyecto='{$fecha_remite_proyecto}', oficio_caratula='{$name}', observaciones='{$observaciones}' WHERE id='{$db->escape($id)}'";
        } 
        if ($name == '') {
            $sql = "UPDATE resoluciones SET num_expediente='{$num_expediente}', visitaduria='{$visitaduria}', fecha_recepcion='{$fecha_recepcion}', fecha_remite_proyecto='{$fecha_remite_proyecto}', observaciones='{$observaciones}' WHERE id='{$db->escape($id)}'";
        }
        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            //sucess
            $session->msg('s', " La resolución ha sido editada con éxito.");
            redirect('resoluciones.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo editar la resolución.');
            redirect('edit_resolucion.php?id=' . (int)$e_resolucion['id'], false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_resolucion.php?id=' . (int)$e_resolucion['id'], false);
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
                <span>Editar resolución</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="edit_resolucion.php?id=<?php echo (int)$e_resolucion['id']; ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="num_expediente">Número de Expediente</label>
                            <input type="text" class="form-control" name="num_expediente" value="<?php echo remove_junk($e_resolucion['num_expediente']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="visitaduria">Visitaduría</label>
                            <select class="form-control" name="visitaduria">
                                <option <?php if ($e_resolucion['visitaduria'] === 'Visitaduría Regional de Apatzingán') echo 'selected="selected"'; ?> value="Visitaduría Regional de Apatzingán">Visitaduría Regional de Apatzingán</option>
                                <option <?php if ($e_resolucion['visitaduria'] === 'Visitaduría Regional de Lázaro Cárdenas') echo 'selected="selected"'; ?> value="Visitaduría Regional de Lázaro Cárdenas">Visitaduría Regional de Lázaro Cárdenas</option>
                                <option <?php if ($e_resolucion['visitaduria'] === 'Visitaduría Regional de Morelia') echo 'selected="selected"'; ?> value="Visitaduría Regional de Morelia">Visitaduría Regional de Morelia</option>
                                <option <?php if ($e_resolucion['visitaduria'] === 'Visitaduría Regional de Uruapan') echo 'selected="selected"'; ?> value="Visitaduría Regional de Uruapan">Visitaduría Regional de Uruapan</option>
                                <option <?php if ($e_resolucion['visitaduria'] === 'Auxiliar de Paracho') echo 'selected="selected"'; ?> value="Auxiliar de Paracho">Auxiliar de Paracho</option>
                                <option <?php if ($e_resolucion['visitaduria'] === 'Visitaduría Regional de Zamora') echo 'selected="selected"'; ?> value="Visitaduría Regional de Zamora">Visitaduría Regional de Zamora</option>
                                <option <?php if ($e_resolucion['visitaduria'] === 'Auxiliar de La Piedad') echo 'selected="selected"'; ?> value="Auxiliar de La Piedad">Auxiliar de La Piedad</option>
                                <option <?php if ($e_resolucion['visitaduria'] === 'Visitaduría Regional de Zitácuaro') echo 'selected="selected"'; ?> value="Visitaduría Regional de Zitácuaro">Visitaduría Regional de Zitácuaro</option>
                                <option <?php if ($e_resolucion['visitaduria'] === 'Auxiliar de Huetamo') echo 'selected="selected"'; ?> value="Auxiliar de Huetamo">Auxiliar de Huetamo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_recepcion">Fecha de Recepción</label>
                            <input type="date" class="form-control" name="fecha_recepcion" value="<?php echo remove_junk($e_resolucion['fecha_recepcion']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_remite_proyecto">Fecha Remite a Proyecto</label>
                            <input type="date" class="form-control" name="fecha_remite_proyecto" value="<?php echo remove_junk($e_resolucion['fecha_remite_proyecto']); ?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="adjunto">Archivo adjunto</label>
                            <input type="file" accept="application/pdf" class="form-control" name="adjunto" id="adjunto">
                            <label style="font-size:12px; color:#E3054F;">Archivo Actual: <?php echo remove_junk($e_resolucion['oficio_caratula']); ?><?php ?></label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="observaciones">Observaciones</label><br>
                            <textarea name="observaciones" class="form-control" id="observaciones" cols="50" rows="2" value="<?php echo remove_junk($e_resolucion['observaciones']); ?>"><?php echo remove_junk($e_resolucion['observaciones']); ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="resoluciones.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="edit_resolucion" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>