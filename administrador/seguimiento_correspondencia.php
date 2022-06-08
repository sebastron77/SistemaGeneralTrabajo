<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Seguimiento Correspondencia';
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
$trabajadores = find_all_trabajadores();

if ($nivel_user <= 2) {
    page_require_level(2);
}
// if ($nivel_user == 7) {
//     page_require_level_exacto(7);
// }
if ($nivel_user == 8) {
    page_require_level_exacto(8);
}

if ($nivel_user > 2 && $nivel_user <= 7) :
    redirect('home.php');
endif;
if ($nivel_user > 8) :
    redirect('home.php');
endif;
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['seguimiento_correspondencia'])) {

    // $req_fields = array('fecha_recibido', 'nombre_remitente', 'nombre_institucion', 'cargo_funcionario', 'asunto');
    // validate_fields($req_fields);

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
        $accion_realizada   = remove_junk($db->escape($_POST['accion_realizada']));
        $fecha_seguimiento   = remove_junk($db->escape($_POST['fecha_seguimiento']));
        $respuesta   = remove_junk($db->escape($_POST['respuesta']));
        $quien_realizo   = remove_junk($db->escape($_POST['detalle-usuario']));

        $folio_editar = $e_correspondencia['folio'];
        $resultado = str_replace("/", "-", $folio_editar);
        $carpeta = 'uploads/correspondencia/' . $resultado;

        $name = $_FILES['respuesta']['name'];
        $size = $_FILES['respuesta']['size'];
        $type = $_FILES['respuesta']['type'];
        $temp = $_FILES['respuesta']['tmp_name'];

        if (is_dir($carpeta)) {
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        } else {
            mkdir($carpeta, 0777, true);
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        }

        if ($name != '') {
            $sql = "UPDATE correspondencia SET fecha_recibido='{$fecha_recibido}', nombre_remitente='{$nombre_remitente}', nombre_institucion='{$nombre_institucion}', cargo_funcionario='{$cargo_funcionario}', asunto='{$asunto}', medio_recepcion='{$medio_recepcion}', seguimiento='{$seguimiento}', medio_entrega='{$medio_entrega}',accion_realizada='{$accion_realizada}',fecha_seguimiento='{$fecha_seguimiento}',respuesta='{$name}',quien_realizo='{$quien_realizo}' WHERE id='{$db->escape($id)}'";
        }
        if ($name == '') {
            $sql = "UPDATE correspondencia SET fecha_recibido='{$fecha_recibido}', nombre_remitente='{$nombre_remitente}', nombre_institucion='{$nombre_institucion}', cargo_funcionario='{$cargo_funcionario}', asunto='{$asunto}', medio_recepcion='{$medio_recepcion}', seguimiento='{$seguimiento}', medio_entrega='{$medio_entrega}',accion_realizada='{$accion_realizada}',fecha_seguimiento='{$fecha_seguimiento}',quien_realizo='{$quien_realizo}' WHERE id='{$db->escape($id)}'";
        }
        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            //sucess
            $session->msg('s', " La correspondencia ha sido editada con éxito.");
            redirect('correspondencia.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo editar la correspondencia.');
            redirect('seguimiento_correspondencia.php?id=' . (int)$e_correspondencia['id'], false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('seguimiento_correspondencia.php?id=' . (int)$e_correspondencia['id'], false);
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
                <span>Seguimiento de correspondencia</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="seguimiento_correspondencia.php?id=<?php echo (int)$e_correspondencia['id']; ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_recibido">Fecha de Recepción</label>
                            <input type="date" class="form-control" name="fecha_recibido" value="<?php echo remove_junk($e_correspondencia['fecha_recibido']); ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nombre_remitente">Nombre de Remitente</label>
                            <input type="text" class="form-control" name="nombre_remitente" value="<?php echo remove_junk($e_correspondencia['nombre_remitente']); ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nombre_institucion">Nombre de Institución</label>
                            <input type="text" class="form-control" name="nombre_institucion" value="<?php echo remove_junk($e_correspondencia['nombre_institucion']); ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cargo_funcionario">Cargo de Funcionario</label>
                            <input type="text" class="form-control" name="cargo_funcionario" value="<?php echo remove_junk($e_correspondencia['cargo_funcionario']); ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="asunto">Asunto</label>
                            <input type="text" class="form-control" name="asunto" value="<?php echo remove_junk($e_correspondencia['asunto']); ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="medio_recepcion">Medio de Recepción</label>
                            <input type="text" class="form-control" name="asunto" value="<?php echo remove_junk($e_correspondencia['medio_recepcion']); ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="seguimiento">Seguimiento</label><br>
                            <input type="text" class="form-control" name="seguimiento" value="<?php echo remove_junk($e_correspondencia['seguimiento']); ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="medio_entrega">Medio de Entrega</label><br>
                            <input type="text" class="form-control" name="medio_entrega" value="<?php echo remove_junk($e_correspondencia['medio_entrega']); ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="accion_realizada">Acción realizada</label><br>
                            <input type="text" class="form-control" name="accion_realizada" value="<?php echo remove_junk($e_correspondencia['accion_realizada']); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_seguimiento">Fecha de Seguimiento</label><br>
                            <input type="date" class="form-control" name="fecha_seguimiento" value="<?php echo remove_junk($e_correspondencia['fecha_seguimiento']); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="respuesta">Adjuntar Respuesta</label>
                            <input type="file" accept="application/pdf" class="form-control" name="respuesta" value="<?php echo remove_junk($e_correspondencia['respuesta']); ?>" id="respuesta">
                            <label style="font-size:12px; color:#E3054F;">Archivo Actual: <?php echo remove_junk($e_correspondencia['respuesta']); ?><?php ?></label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="level">Quién realizó</label>
                            <select class="form-control" name="detalle-usuario">
                                <?php foreach ($trabajadores as $trabajador) : ?>
                                    <option value="<?php echo $trabajador['nombre'] . ' ' . $trabajador['apellidos']; ?>"><?php echo ucwords($trabajador['nombre']); ?> <?php echo ucwords($trabajador['apellidos']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label style="font-size:12px; color:#E3054F;">Persona Actual: <?php echo remove_junk($e_correspondencia['quien_realizo']); ?><?php ?></label>
                        </div>
                    </div>
                </div>
                <br>
                <div class="form-group clearfix">
                    <a href="correspondencia.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="seguimiento_correspondencia" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>