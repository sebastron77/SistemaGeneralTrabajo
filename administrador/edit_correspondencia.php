<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Editar Correspondencia';
require_once('includes/load.php');
$user = current_user();
$detalle = $user['id'];
$e_correspondencia = find_by_id_correspondencia((int)$_GET['id']);
$id_folio = last_id_folios();
// page_require_level(2);
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
$nivel_user = $user['user_level'];

if ($nivel_user <= 2) {
    page_require_level(2);
}
if ($nivel_user == 7) {
    page_require_level_exacto(7);
}
if ($nivel_user == 8) {
    page_require_level_exacto(8);
}

if ($nivel_user > 2 && $nivel_user < 7):
    redirect('home.php');
endif;
if ($nivel_user > 8):
    redirect('home.php');
endif;
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['edit_correspondencia'])) {

    $req_fields = array('fecha_recibido', 'nombre_remitente', 'nombre_institucion', 'cargo_funcionario', 'asunto');
    validate_fields($req_fields);

    if (empty($errors)) {
        $id = (int)$e_correspondencia['id'];
        $fecha_recibido   = remove_junk($db->escape($_POST['fecha_recibido']));
        $nombre_remitente   = remove_junk($db->escape($_POST['nombre_remitente']));
        $nombre_institucion   = remove_junk($db->escape($_POST['nombre_institucion']));
        $cargo_funcionario   = remove_junk($db->escape($_POST['cargo_funcionario']));
        $asunto   = remove_junk(($db->escape($_POST['asunto'])));
        $medio_recepcion   = remove_junk(($db->escape($_POST['medio_recepcion'])));
        $seguimiento   = remove_junk(($db->escape($_POST['seguimiento'])));
        $medio_entrega   = remove_junk($db->escape($_POST['medio_entrega']));

        $folio_editar = $e_correspondencia['folio'];
        $resultado = str_replace("/", "-", $folio_editar);
        $carpeta = 'uploads/correspondencia/' . $resultado;

        $sql = "UPDATE correspondencia SET fecha_recibido='{$fecha_recibido}', nombre_remitente='{$nombre_remitente}', nombre_institucion='{$nombre_institucion}', cargo_funcionario='{$cargo_funcionario}', asunto='{$asunto}', medio_recepcion='{$medio_recepcion}', seguimiento='{$seguimiento}', medio_entrega='{$medio_entrega}' WHERE id='{$db->escape($id)}'";

        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            //sucess
            $session->msg('s', " La correspondencia ha sido editada con éxito.");
            redirect('correspondencia.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo editar la correspondencia.');
            redirect('edit_correspondencia.php?id=' . (int)$e_correspondencia['id'], false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_correspondencia.php?id=' . (int)$e_correspondencia['id'], false);
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
                <span>Editar correspondencia</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="edit_correspondencia.php?id=<?php echo (int)$e_correspondencia['id']; ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_recibido">Fecha de Recepción</label>
                            <input type="date" class="form-control" name="fecha_recibido" value="<?php echo remove_junk($e_correspondencia['fecha_recibido']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nombre_remitente">Nombre de Remitente</label>
                            <input type="text" class="form-control" name="nombre_remitente" value="<?php echo remove_junk($e_correspondencia['nombre_remitente']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nombre_institucion">Nombre de Institución</label>
                            <input type="text" class="form-control" name="nombre_institucion" value="<?php echo remove_junk($e_correspondencia['nombre_institucion']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cargo_funcionario">Cargo de Funcionario</label>
                            <input type="text" class="form-control" name="cargo_funcionario" value="<?php echo remove_junk($e_correspondencia['cargo_funcionario']); ?>" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="asunto">Asunto</label>
                            <input type="text" class="form-control" name="asunto" value="<?php echo remove_junk($e_correspondencia['asunto']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="medio_recepcion">Medio de Recepción</label>
                            <select class="form-control" name="medio_recepcion">
                                <option <?php if ($e_correspondencia['medio_recepcion'] === 'Correo') echo 'selected="selected"'; ?> value="Correo">Correo</option>
                                <option <?php if ($e_correspondencia['medio_recepcion'] === 'Mediante Oficio') echo 'selected="selected"'; ?> value="Mediante Oficio">Mediante Oficio</option>
                                <option <?php if ($e_correspondencia['medio_recepcion'] === 'Oficialia de partes') echo 'selected="selected"'; ?> value="Oficialia de partes">Oficialia de partes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="seguimiento">Seguimiento</label><br>
                            <input type="text" class="form-control" name="seguimiento" value="<?php echo remove_junk($e_correspondencia['seguimiento']); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="medio_entrega">Medio de Entrega</label><br>
                            <input type="text" class="form-control" name="medio_entrega" value="<?php echo remove_junk($e_correspondencia['medio_entrega']); ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="correspondencia.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="edit_correspondencia" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>