<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Seguimiento Correspondencia';
require_once('includes/load.php');
$user = current_user();
$detalle = $user['id'];
$e_correspondencia = find_by_id_env_correspondencia((int)$_GET['id']);
$id_folio = last_id_folios();
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
$nivel_user = $user['user_level'];
$trabajadores = find_all_trabajadores();
$areas = find_all('area');
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['seguimiento_env_correspondencia'])) {

    if (empty($errors)) {
        $id = (int)$e_correspondencia['id'];
        $accion_realizada   = remove_junk($db->escape($_POST['accion_realizada']));
        $fecha   = remove_junk($db->escape($_POST['fecha']));
        $quien_realizo   = remove_junk($db->escape($_POST['quien_realizo']));

        $folio_editar = $e_correspondencia['folio'];
        $resultado = str_replace("/", "-", $folio_editar);
        $carpeta = 'uploads/correspondencia/' . $resultado;

        $name = $_FILES['oficio']['name'];
        $size = $_FILES['oficio']['size'];
        $type = $_FILES['oficio']['type'];
        $temp = $_FILES['oficio']['tmp_name'];

        if (is_dir($carpeta)) {
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        } else {
            mkdir($carpeta, 0777, true);
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        }

        if ($name != '') {
            $sql = "UPDATE envio_correspondencia SET accion_realizada='{$accion_realizada}',fecha='{$fecha}',oficio='{$name}',quien_realizo='{$quien_realizo}' WHERE id='{$db->escape($id)}'";
        }
        if ($name == '') {
            $sql = "UPDATE envio_correspondencia SET accion_realizada='{$accion_realizada}',fecha='{$fecha}',quien_realizo='{$quien_realizo}' WHERE id='{$db->escape($id)}'";
        }
        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            //sucess
            $session->msg('s', " La correspondencia interna ha sido editada con éxito.");
            redirect('env_correspondencia.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo editar la correspondencia interna.');
            redirect('seguimiento_env_correspondencia.php?id=' . (int)$e_correspondencia['id'], false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('seguimiento_env_correspondencia.php?id=' . (int)$e_correspondencia['id'], false);
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
                <span>Seguimiento de correspondencia interna <?php echo $e_correspondencia['folio'] ?></span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="seguimiento_env_correspondencia.php?id=<?php echo (int)$e_correspondencia['id']; ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_emision">Fecha de Emisión</label>
                            <input type="date" class="form-control" name="fecha_emision" value="<?php echo remove_junk($e_correspondencia['fecha_emision']); ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="asunto">Asunto</label>
                            <input type="text" class="form-control" name="asunto" value="<?php echo remove_junk($e_correspondencia['asunto']); ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="medio_envio">Medio de Envío</label>
                            <input type="text" class="form-control" name="medio_envio" value="<?php echo remove_junk($e_correspondencia['medio_envio']); ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="se_turna_a_area">Se turna a Área</label>
                            <input type="text" class="form-control" name="se_turna_a_area" value="<?php echo remove_junk($e_correspondencia['se_turna_a_area']); ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_en_que_se_turna">Fecha en que se turna oficio</label>
                            <input type="date" class="form-control" value="<?php echo remove_junk($e_correspondencia['fecha_en_que_se_turna']); ?>" name="fecha_en_que_se_turna" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_espera_respuesta">Fecha en que se espera respuesta</label>
                            <input type="date" class="form-control" value="<?php echo remove_junk($e_correspondencia['fecha_espera_respuesta']); ?>" name="fecha_espera_respuesta" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tipo_tramite">Tipo de Trámite</label><br>
                            <input type="text" class="form-control" name="tipo_tramite" value="<?php echo remove_junk($e_correspondencia['tipo_tramite']); ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="oficio_enviado" style="margin-bottom: 10px;">Oficio Enviado</label><br>
                            <?php
                            $folio_editar = $e_correspondencia['folio'];
                            $resultado = str_replace("/", "-", $folio_editar);
                            ?>
                            <span><a target="_blank" style="color: #23296B;" href="uploads/correspondencia/<?php echo $resultado . '/' . $e_correspondencia['oficio_enviado']; ?>"><?php echo $e_correspondencia['oficio_enviado']; ?></a></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="observaciones">Observaciones</label>
                            <textarea class="form-control" value="<?php echo remove_junk($e_correspondencia['observaciones']); ?>" name="observaciones" id="observaciones" cols="10" rows="3" readonly><?php echo remove_junk($e_correspondencia['observaciones']); ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="area_creacion">Área que turnó el oficio</label><br>
                            <input type="text" class="form-control" name="area_creacion" value="<?php echo remove_junk($e_correspondencia['area_creacion']); ?>" readonly>
                        </div>
                    </div>
                </div>

                <!-- <hr style="margin-top: 5px;height:2px;border-width:0;background-color:#aaaaaa"> -->
                <!-- <h4>Seguimiento de Correspondencia</h4> -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="accion_realizada">Acción Realizada</label><br>
                            <input type="text" class="form-control" value="<?php echo remove_junk($e_correspondencia['accion_realizada']); ?>" name="accion_realizada">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha">Fecha del seguimiento</label>
                            <input type="date" class="form-control" value="<?php echo remove_junk($e_correspondencia['fecha']); ?>" name="fecha">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="oficio_respuesta">Adjuntar Oficio de Respuesta</label>
                            <input type="file" accept="application/pdf" class="form-control" name="oficio_respuesta" value="<?php echo remove_junk($e_correspondencia['oficio_respuesta']); ?>" id="oficio_respuesta">
                            <label style="font-size:12px; color:#E3054F;">Archivo Actual: <?php echo remove_junk($e_correspondencia['oficio_respuesta']); ?><?php ?></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="level">Quién realizó seguimiento: </label> <label style="font-size:12px; color:#E3054F;"> <?php echo remove_junk($e_correspondencia['quien_realizo']) . ' (actual)'; ?><?php ?></label>
                            <select class="form-control" name="quien_realizo">
                                <?php foreach ($trabajadores as $trabajador) : ?>
                                    <option value="<?php echo $trabajador['nombre'] . ' ' . $trabajador['apellidos']; ?>"><?php echo ucwords($trabajador['nombre']); ?> <?php echo ucwords($trabajador['apellidos']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <!-- <label style="font-size:12px; color:#E3054F;">Persona Actual: <?php echo remove_junk($e_correspondencia['quien_realizo']); ?><?php ?></label> -->
                        </div>
                    </div>
                </div>
                <br>
                <div class="form-group clearfix">
                    <a href="env_correspondencia.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="seguimiento_env_correspondencia" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>