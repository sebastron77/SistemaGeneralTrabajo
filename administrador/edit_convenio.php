<?php
$page_title = 'Editar Convenio';
require_once('includes/load.php');

page_require_level(3);

?>
<?php
$e_detalle = find_by_id('convenios', (int)$_GET['id']);
if (!$e_detalle) {
    $session->msg("d", "id de convenio no encontrado.");
    redirect('convenio.php');
}
$user = current_user();
$nivel = $user['user_level'];
$id_folio = last_id_folios();
?>

<?php
if (isset($_POST['edit_convenio'])) {

    $req_fields = array('fecha_convenio', 'institucion', 'ambito_institucion', 'tipo_institucion', 'descripcion_convenio', 'vigencia', 'direccion_institucion', 'telefono');
    validate_fields($req_fields);

    if (empty($errors)) {
        $id = (int)$e_detalle['id'];
        $fecha_convenio = remove_junk($db->escape($_POST['fecha_convenio']));
        $institucion   = remove_junk($db->escape($_POST['institucion']));
        $ambito_institucion   = remove_junk($db->escape($_POST['ambito_institucion']));
        $tipo_institucion   = remove_junk($db->escape($_POST['tipo_institucion']));
        $descripcion_convenio   = remove_junk($db->escape($_POST['descripcion_convenio']));
        $vigencia   = remove_junk($db->escape($_POST['vigencia']));
        $direccion_institucion   = remove_junk(($db->escape($_POST['direccion_institucion'])));
        $telefono   = remove_junk(($db->escape($_POST['telefono'])));
        $adjunto   = remove_junk(($db->escape($_POST['adjunto'])));

        $folio_editar = $e_detalle['folio_solicitud'];
        $resultado = str_replace("/", "-", $folio_editar);
        $carpeta = 'uploads/convenios/' . $resultado;

        $name = $_FILES['adjunto']['name'];
        $size = $_FILES['adjunto']['size'];
        $type = $_FILES['adjunto']['type'];
        $temp = $_FILES['adjunto']['tmp_name'];

        if (is_dir($carpeta)) {
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        }
        else {
            mkdir($carpeta, 0777, true);
        }

        if ($name != '') {
            $sql = "UPDATE convenios SET fecha_convenio='{$fecha_convenio}', institucion='{$institucion}', ambito_institucion='{$ambito_institucion}', tipo_institucion='{$tipo_institucion}', descripcion_convenio='{$descripcion_convenio}', vigencia='{$vigencia}', direccion_institucion='{$direccion_institucion}', telefono='{$telefono}', convenio='{$name}' WHERE id='{$db->escape($id)}'";
        }
        if($name == ''){
            $sql = "UPDATE convenios SET fecha_convenio='{$fecha_convenio}', institucion='{$institucion}', ambito_institucion='{$ambito_institucion}', tipo_institucion='{$tipo_institucion}', descripcion_convenio='{$descripcion_convenio}', vigencia='{$vigencia}', direccion_institucion='{$direccion_institucion}', telefono='{$telefono}' WHERE id='{$db->escape($id)}'";
        }
        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            $session->msg('s', "Información Actualizada ");
            redirect('convenios.php', false);
        } else {
            $session->msg('d', ' Lo siento no se actualizaron los datos.');
            redirect('edit_convenio.php?id=' . (int)$e_detalle['id'], false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_convenio.php?id=' . (int)$e_detalle['id'], false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Editar convenio <?php echo $e_detalle['folio_solicitud']; ?></span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="edit_convenio.php?id=<?php echo (int)$e_detalle['id']; ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_convenio">Fecha de convenio</label>
                            <input type="date" class="form-control" name="fecha_convenio" value="<?php echo remove_junk($e_detalle['fecha_convenio']); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="vigencia">Vigencia del convenio</label><br>
                            <input type="date" class="form-control" name="vigencia" value="<?php echo remove_junk($e_detalle['vigencia']); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="institucion">Institución</label>
                            <input type="text" class="form-control" name="institucion" value="<?php echo remove_junk($e_detalle['institucion']); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control" name="telefono" maxlength="10" value="<?php echo remove_junk($e_detalle['telefono']); ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="ambito_institucion">Ámbito institucional</label>
                            <select class="form-control" name="ambito_institucion">
                                <option <?php if ($e_detalle['ambito_institucion'] === 'Nacional') echo 'selected="selected"'; ?> value="Nacional">Nacional</option>
                                <option <?php if ($e_detalle['ambito_institucion'] === 'Estatal') echo 'selected="selected"'; ?> value="Estatal">Estatal</option>
                                <option <?php if ($e_detalle['ambito_institucion'] === 'Federal') echo 'selected="selected"'; ?> value="Federal">Federal</option>
                                <option <?php if ($e_detalle['ambito_institucion'] === 'Municipal') echo 'selected="selected"'; ?> value="Municipal">Municipal</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tipo_institucion">Tipo de institución</label>
                            <select class="form-control" name="tipo_institucion">
                                <option <?php if ($e_detalle['tipo_institucion'] === 'Instituciones') echo 'selected="selected"'; ?> value="Instituciones">Instituciones</option>
                                <option <?php if ($e_detalle['tipo_institucion'] === 'Dependencias Gubernamentales') echo 'selected="selected"'; ?> value="Dependencias Gubernamentales">Dependencias Gubernamentales</option>
                                <option <?php if ($e_detalle['tipo_institucion'] === 'Organismos Públicos de Derechos Humanos') echo 'selected="selected"'; ?> value="Organismos Públicos de Derechos Humanos">Organismos Públicos de Derechos Humanos</option>
                                <option <?php if ($e_detalle['tipo_institucion'] === 'ONG') echo 'selected="selected"'; ?> value="ONG">ONG</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="direccion_institucion">Dirección Institución</label>
                            <input type="text" class="form-control" name="direccion_institucion" value="<?php echo remove_junk($e_detalle['direccion_institucion']); ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="descripcion_convenio">Descripción del convenio</label>
                            <textarea name="descripcion_convenio" id="descripcion_convenio" cols="50" rows="2" min="1" class="form-control" value="<?php echo remove_junk($e_detalle['descripcion_convenio']); ?>"> <?php echo remove_junk($e_detalle['descripcion_convenio']); ?> </textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="adjunto">Adjuntar Convenio</label>
                            <input type="file" accept="application/pdf" class="form-control" name="adjunto" value="<?php echo remove_junk($e_detalle['convenio']); ?>" id="adjunto">
                            <label style="font-size:12px; color:#E3054F;" >Archivo Actual: <?php echo remove_junk($e_detalle['convenio']); ?><?php ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="convenios.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="edit_convenio" class="btn btn-primary" value="subir">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>