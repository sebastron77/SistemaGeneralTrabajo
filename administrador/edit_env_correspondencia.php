<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Editar Correspondencia';
require_once('includes/load.php');
$user = current_user();
$detalle = $user['id'];
$e_correspondencia = find_by_id_env_correspondencia((int)$_GET['id']);
$id_folio = last_id_folios();
// page_require_level(2);
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
$nivel_user = $user['user_level'];
$areas = find_all('area');


$detalle = $user['id'];
// $id_folio = last_id_folios_general();
$id_folio = last_id_folios_env_cor();
$area_user = area_usuario2($id_user);
$area_creacion = $area_user['nombre_area'];
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['edit_env_correspondencia'])) {

    $req_fields = array('fecha_emision');
    validate_fields($req_fields);

    if (empty($errors)) {
        $id = (int)$e_correspondencia['id'];
        $fecha_emision   = remove_junk($db->escape($_POST['fecha_emision']));
        $asunto   = remove_junk(($db->escape($_POST['asunto'])));
        $medio_envio   = remove_junk(($db->escape($_POST['medio_envio'])));
        $se_turna_a_area   = remove_junk(($db->escape($_POST['se_turna_a_area'])));
        // $fecha_en_que_se_turna   = remove_junk(($db->escape($_POST['fecha_en_que_se_turna'])));
        $fecha_espera_respuesta   = remove_junk(($db->escape($_POST['fecha_espera_respuesta'])));
        $tipo_tramite   = remove_junk(($db->escape($_POST['tipo_tramite'])));
        $observaciones   = remove_junk(($db->escape($_POST['observaciones'])));
        $expediente   = remove_junk(($db->escape($_POST['expediente'])));
        $con_copia_para   = remove_junk(($db->escape($_POST['con_copia_para'])));
        $cuerpo_oficio   = remove_junk(($db->escape($_POST['cuerpo_oficio'])));
        $se_turna_a_trabajador   = remove_junk(($db->escape($_POST['se_turna_a_trabajador'])));

        $folio_editar = $e_correspondencia['folio'];
        $resultado = str_replace("/", "-", $folio_editar);
        $carpeta = 'uploads/correspondencia/' . $resultado;

        $name = $_FILES['oficio_enviado']['name'];
        $size = $_FILES['oficio_enviado']['size'];
        $type = $_FILES['oficio_enviado']['type'];
        $temp = $_FILES['oficio_enviado']['tmp_name'];

        if (is_dir($carpeta)) {
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        } else {
            mkdir($carpeta, 0777, true);
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        }
        if ($name != '') {
            $sql = "UPDATE envio_correspondencia SET fecha_emision='{$fecha_emision}',asunto='{$asunto}',medio_envio='{$medio_envio}',se_turna_a_area='{$se_turna_a_area}',fecha_espera_respuesta='{$fecha_espera_respuesta}',tipo_tramite='{$tipo_tramite}',observaciones='{$observaciones}',se_turna_a_trabajador='{$se_turna_a_trabajador}',expediente='{$expediente}',con_copia_para='{$con_copia_para}',cuerpo_oficio='{$cuerpo_oficio}' WHERE id='{$db->escape($id)}'";
        }
        if ($name == '') {
            $sql = "UPDATE envio_correspondencia SET fecha_emision='{$fecha_emision}',asunto='{$asunto}',medio_envio='{$medio_envio}',se_turna_a_area='{$se_turna_a_area}',fecha_espera_respuesta='{$fecha_espera_respuesta}',tipo_tramite='{$tipo_tramite}',observaciones='{$observaciones}',se_turna_a_trabajador='{$se_turna_a_trabajador}',expediente='{$expediente}',con_copia_para='{$con_copia_para}',cuerpo_oficio='{$cuerpo_oficio}' WHERE id='{$db->escape($id)}'";
        }
        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            //sucess
            $session->msg('s', " La correspondencia ha sido editada con éxito.");
            redirect('env_correspondencia.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo editar la correspondencia.');
            redirect('edit_env_correspondencia.php?id=' . (int)$e_correspondencia['id'], false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_env_correspondencia.php?id=' . (int)$e_correspondencia['id'], false);
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
            <form method="post" action="edit_env_correspondencia.php?id=<?php echo (int)$e_correspondencia['id']; ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_emision">Fecha de Emisión de Oficio</label>
                            <input type="date" class="form-control" name="fecha_emision" value="<?php echo remove_junk($e_correspondencia['fecha_emision']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="asunto">Asunto</label>
                            <input type="text" class="form-control" name="asunto" maxlength="60" value="<?php echo remove_junk($e_correspondencia['asunto']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="expediente">Expediente</label>
                            <input type="text" class="form-control" name="expediente" maxlength="60" value="<?php echo remove_junk($e_correspondencia['expediente']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="medio_envio">Medio de Envío</label>
                            <select class="form-control" name="medio_envio">
                                <option <?php if ($e_correspondencia['medio_envio'] === 'Correo') echo 'selected="selected"'; ?> value="Correo">Correo</option>
                                <option <?php if ($e_correspondencia['medio_envio'] === 'Mediante Oficio') echo 'selected="selected"'; ?> value="Mediante Oficio">Mediante Oficio</option>
                                <option <?php if ($e_correspondencia['medio_envio'] === 'Oficialia de partes') echo 'selected="selected"'; ?> value="Oficialia de partes">Oficialia de partes</option>
                                <option <?php if ($e_correspondencia['medio_envio'] === 'Paquetería') echo 'selected="selected"'; ?> value="Paquetería">Paquetería</option>
                                <option <?php if ($e_correspondencia['medio_envio'] === 'Fax') echo 'selected="selected"'; ?> value="Fax">Fax</option>
                                <option <?php if ($e_correspondencia['medio_envio'] === 'WhatsApp') echo 'selected="selected"'; ?> value="WhatsApp">WhatsApp</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="se_turna_a_area">Área a la que se turna</label>
                            <select class="form-control" id="se_turna_a_area" name="se_turna_a_area">
                                <?php foreach ($areas as $area) : ?>
                                    <option <?php if ($area['nombre_area'] === $e_correspondencia['se_turna_a_area']) echo 'selected="selected"'; ?> value="<?php echo $area['nombre_area']; ?>"><?php echo ucwords($area['nombre_area']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <?php $trabajadores = find_all_trabajadores_area($area['nombre_area']) ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="se_turna_a_trabajador_editar">Trabajador al que se dirige oficio</label>
                            <select class="form-control" id="se_turna_a_trabajador_editar" name="se_turna_a_trabajador"></select>
                        </div>
                    </div>
                    <!-- <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_en_que_se_turna">Fecha en que se turna oficio</label>
                            <input type="date" class="form-control" value="<?php echo remove_junk($e_correspondencia['fecha_en_que_se_turna']); ?>" name="fecha_en_que_se_turna" required>
                        </div>
                    </div> -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_espera_respuesta">Fecha en que se espera respuesta</label>
                            <input type="date" class="form-control" value="<?php echo remove_junk($e_correspondencia['fecha_espera_respuesta']); ?>" name="fecha_espera_respuesta">
                        </div>
                    </div>
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
                    <!-- <div class="col-md-3">
                        <div class="form-group">
                            <label for="oficio_enviado">Oficio enviado</label>
                            <input type="file" accept="application/pdf" class="form-control" name="oficio_enviado" value="<?php echo remove_junk($e_correspondencia['oficio_enviado']); ?>" id="oficio_enviado">
                            <label style="font-size:12px; color:#E3054F;">Archivo Actual: <?php echo remove_junk($e_correspondencia['oficio_enviado']); ?><?php ?></label>
                        </div>
                    </div> -->
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="con_copia_para">C.C.P</label><br>
                            <select class="form-control" id="con_copia_para" name="con_copia_para">
                                <?php foreach ($areas as $area) : ?>
                                    <!-- <option value="<?php echo $area['nombre_area']; ?>"><?php echo ucwords($area['nombre_area']); ?></option> -->
                                    <option <?php if ($area['nombre_area'] === $e_correspondencia['con_copia_para']) echo 'selected="selected"'; ?> value="<?php echo $area['nombre_area']; ?>"><?php echo ucwords($area['nombre_area']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cuerpo_oficio">Cuerpo del oficio</label>
                            <textarea class="form-control" name="cuerpo_oficio" id="cuerpo" cols="15" rows="3" style="white-space: pre-line;"><?php echo remove_junk($e_correspondencia['cuerpo_oficio']); ?></textarea>
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
                    <a href="env_correspondencia.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="edit_env_correspondencia" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>