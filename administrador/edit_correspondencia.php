<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Editar Correspondencia - Oficialia de Partes';
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
$areas = find_all('area');
// $area = $area_user['nombre_area'];

// if ($nivel_user <= 2) {
//     page_require_level(2);
// }
// if ($nivel_user == 7) {
//     page_require_level_exacto(7);
// }
// if ($nivel_user == 8) {
//     page_require_level_exacto(8);
// }

// if ($nivel_user > 2 && $nivel_user < 7):
//     redirect('home.php');
// endif;
// if ($nivel_user > 8):
//     redirect('home.php');
// endif;
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['edit_correspondencia'])) {

    $req_fields = array('fecha_recibido', 'nombre_remitente', 'nombre_institucion', 'cargo_funcionario', 'asunto');
    validate_fields($req_fields);

    if (empty($errors)) {
        $id = (int)$e_correspondencia['id'];
        $fecha_recibido   = remove_junk($db->escape($_POST['fecha_recibido']));
        $num_oficio_recepcion   = remove_junk($db->escape($_POST['num_oficio_recepcion']));
        $nombre_remitente   = remove_junk($db->escape($_POST['nombre_remitente']));
        $nombre_institucion   = remove_junk($db->escape($_POST['nombre_institucion']));
        $cargo_funcionario   = remove_junk($db->escape($_POST['cargo_funcionario']));
        $asunto   = remove_junk(($db->escape($_POST['asunto'])));
        $medio_recepcion   = remove_junk(($db->escape($_POST['medio_recepcion'])));
        $medio_entrega   = remove_junk(($db->escape($_POST['medio_entrega'])));
        $se_turna_a_area   = remove_junk(($db->escape($_POST['se_turna_a_area'])));
        $fecha_en_que_se_turna   = remove_junk(($db->escape($_POST['fecha_en_que_se_turna'])));
        $fecha_espera_respuesta   = remove_junk(($db->escape($_POST['fecha_espera_respuesta'])));
        $tipo_tramite   = remove_junk(($db->escape($_POST['tipo_tramite'])));
        $observaciones   = remove_junk(($db->escape($_POST['observaciones'])));

        $folio_editar = $e_correspondencia['folio'];
        $resultado = str_replace("/", "-", $folio_editar);
        $carpeta = 'uploads/correspondencia/' . $resultado;

        $sql = "UPDATE correspondencia SET fecha_recibido='{$fecha_recibido}',num_oficio_recepcion='{$num_oficio_recepcion}',nombre_remitente='{$nombre_remitente}', 
                nombre_institucion='{$nombre_institucion}', cargo_funcionario='{$cargo_funcionario}', asunto='{$asunto}', medio_recepcion='{$medio_recepcion}', 
                medio_entrega='{$medio_entrega}',se_turna_a_area='{$se_turna_a_area}',fecha_en_que_se_turna='{$fecha_en_que_se_turna}',
                fecha_espera_respuesta='{$fecha_espera_respuesta}',tipo_tramite='{$tipo_tramite}',observaciones='{$observaciones}' WHERE id='{$db->escape($id)}'";

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
                <span>Editar Correspondencia - Oficialia de Partes</span>
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
                            <label for="num_oficio_recepcion">Número de Oficio de Recepción</label>
                            <input type="text" class="form-control" name="num_oficio_recepcion" value="<?php echo remove_junk($e_correspondencia['num_oficio_recepcion']); ?>" required>
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
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cargo_funcionario">Cargo de Funcionario</label>
                            <input type="text" class="form-control" name="cargo_funcionario" value="<?php echo remove_junk($e_correspondencia['cargo_funcionario']); ?>" required>
                        </div>
                    </div>
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
                                <option <?php if ($e_correspondencia['medio_recepcion'] === 'Paquetería') echo 'selected="selected"'; ?> value="Paquetería">Paquetería</option>
                                <option <?php if ($e_correspondencia['medio_recepcion'] === 'Fax') echo 'selected="selected"'; ?> value="Fax">Fax</option>
                                <option <?php if ($e_correspondencia['medio_recepcion'] === 'WhatsApp') echo 'selected="selected"'; ?> value="WhatsApp">WhatsApp</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr style="height:2px;border-width:0;background-color:#aaaaaa">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="medio_entrega">Medio de Entrega</label><br>
                            <select class="form-control" name="medio_entrega">
                                <option <?php if ($e_correspondencia['medio_entrega'] === 'Correo') echo 'selected="selected"'; ?> value="Correo">Correo</option>
                                <option <?php if ($e_correspondencia['medio_entrega'] === 'Mediante Oficio') echo 'selected="selected"'; ?> value="Mediante Oficio">Mediante Oficio</option>
                                <option <?php if ($e_correspondencia['medio_entrega'] === 'Paquetería') echo 'selected="selected"'; ?> value="Paquetería">Paquetería</option>
                                <option <?php if ($e_correspondencia['medio_entrega'] === 'WhatsApp') echo 'selected="selected"'; ?> value="WhatsApp">WhatsApp</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="se_turna_a_area">Área</label>
                            <select class="form-control" name="se_turna_a_area">
                                <?php foreach ($areas as $area) : ?>
                                    <option <?php if ($area['nombre_area'] === $e_correspondencia['se_turna_a_area']) echo 'selected="selected"'; ?> value="<?php echo $area['nombre_area']; ?>"><?php echo ucwords($area['nombre_area']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_en_que_se_turna">Fecha en que se turna oficio</label>
                            <input type="date" class="form-control" value="<?php echo remove_junk($e_correspondencia['fecha_en_que_se_turna']); ?>" name="fecha_en_que_se_turna" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_espera_respuesta">Fecha en que se espera respuesta</label>
                            <input type="date" class="form-control" value="<?php echo remove_junk($e_correspondencia['fecha_espera_respuesta']); ?>" name="fecha_espera_respuesta" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tipo_tramite">Tipo de Trámite</label><br>
                            <select class="form-control" name="tipo_tramite">
                                <option <?php if ($e_correspondencia['tipo_tramite'] === 'Respuesta') echo 'selected="selected"'; ?> value="Respuesta">Respuesta</option>
                                <option <?php if ($e_correspondencia['tipo_tramite'] === 'Conocimiento') echo 'selected="selected"'; ?> value="Conocimiento">Conocimiento</option>
                                <option <?php if ($e_correspondencia['tipo_tramite'] === 'Circular') echo 'selected="selected"'; ?> value="Circular">Circular</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="observaciones">Observaciones</label>
                            <textarea class="form-control" value="<?php echo remove_junk($e_correspondencia['observaciones']); ?>" name="observaciones" id="observaciones" cols="10" rows="5"><?php echo remove_junk($e_correspondencia['observaciones']); ?></textarea>
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