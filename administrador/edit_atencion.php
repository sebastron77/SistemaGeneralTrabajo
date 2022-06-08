<?php
$page_title = 'Editar Atención';
require_once('includes/load.php');

// page_require_level(4);
?>
<?php
$e_atencion = find_by_id_atencion((int)$_GET['id']);
if (!$e_atencion) {
    $session->msg("d", "id de atención no encontrado.");
    redirect('atencion.php');
}
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
    page_require_level_exacto(8);
}
?>

<?php
if (isset($_POST['edit_atencion'])) {
    // $req_fields = array('asunto', 'peticion_audiencia', 'fecha_audiencia', 'personas_atendidas');
    // validate_fields($req_fields);
    if (empty($errors)) {
        $id = (int)$e_atencion['id'];
        $asunto   = remove_junk($db->escape($_POST['asunto']));
        $peticion_audiencia   = remove_junk($db->escape($_POST['peticion_audiencia']));
        $fecha_audiencia   = remove_junk($db->escape($_POST['fecha_audiencia']));
        $personas_atendidas   = remove_junk($db->escape($_POST['personas_atendidas']));
        $solicitud_peticion   = remove_junk(($db->escape($_POST['solicitud_peticion'])));

        $folio_editar = $e_atencion['folio'];
        $resultado = str_replace("/", "-", $folio_editar);
        $carpeta = 'uploads/atencion/' . $resultado;

        $name = $_FILES['solicitud_peticion']['name'];
        $size = $_FILES['solicitud_peticion']['size'];
        $type = $_FILES['solicitud_peticion']['type'];
        $temp = $_FILES['solicitud_peticion']['tmp_name'];

        //Verificamos que exista la carpeta y si sí, guardamos el pdf
        if (is_dir($carpeta)) {
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        } else {
            mkdir($carpeta, 0777, true);
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        }

        if ($name != '') {
            $sql = "UPDATE atencion SET asunto='{$asunto}', peticion_audiencia='{$peticion_audiencia}', fecha_audiencia='{$fecha_audiencia}', personas_atendidas='{$personas_atendidas}', solicitud_peticion='{$name}' WHERE id='{$db->escape($id)}'";
        }
        if ($name == '') {
            $sql = "UPDATE atencion SET asunto='{$asunto}', peticion_audiencia='{$peticion_audiencia}', fecha_audiencia='{$fecha_audiencia}', personas_atendidas='{$personas_atendidas}' WHERE id='{$db->escape($id)}'";
        }
        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            $session->msg('s', "Información Actualizada ");
            redirect('atencion.php', false);
        } else {
            $session->msg('d', ' Lo siento no se actualizaron los datos.');
            redirect('edit_atencion.php?id=' . (int)$e_atencion['id'], false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_atencion.php?id=' . (int)$e_atencion['id'], false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Editar atención <?php echo $e_atencion['folio']; ?></span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="edit_atencion.php?id=<?php echo (int)$e_atencion['id']; ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="asunto">Asunto</label>
                            <input type="text" class="form-control" name="asunto" value="<?php echo remove_junk($e_atencion['asunto']); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="peticion_audiencia">Peticion de audiencia</label>
                            <select class="form-control" name="peticion_audiencia">
                                <option <?php if ($e_atencion['peticion_audiencia'] === 'Realizado') echo 'selected="selected"'; ?> value="Realizado">Realizado</option>
                                <option <?php if ($e_atencion['peticion_audiencia'] === 'Pendiente') echo 'selected="selected"'; ?> value="Pendiente">Pendiente</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_audiencia">Fecha de audiencia</label><br>
                            <input type="date" class="form-control" name="fecha_audiencia" value="<?php echo remove_junk($e_atencion['fecha_audiencia']); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="solicitud_peticion">Adjuntar Convenio</label>
                            <input type="file" accept="application/pdf" class="form-control" name="solicitud_peticion" value="uploads/atencion/<?php echo remove_junk($e_atencion['solicitud_peticion']); ?>" id="solicitud_peticion">
                            <label style="font-size:12px; color:#E3054F;">Archivo Actual: <?php echo remove_junk($e_atencion['solicitud_peticion']); ?><?php ?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="personas_atendidas">Nombre(s) de la(s) persona(s) atendida(s) (separadas por comas)</label><br>
                            <textarea class="form-control" name="personas_atendidas" value="<?php echo remove_junk($e_atencion['personas_atendidas']); ?>" id="personas_atendidas" cols="30" rows="5"><?php echo remove_junk($e_atencion['personas_atendidas']); ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="atencion.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="edit_atencion" class="btn btn-primary" value="subir">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>