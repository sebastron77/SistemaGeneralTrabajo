<?php
$page_title = 'Editar Recomendación';
require_once('includes/load.php');

// page_require_level(4);
?>
<?php
$e_recomendacion = find_by_id('recomendaciones', (int)$_GET['id']);
if (!$e_recomendacion) {
    $session->msg("d", "id de recomendación no encontrado.");
    redirect('recomendaciones.php');
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
    page_require_level_exacto(5);
}
if ($nivel == 6) {
    redirect('home.php');
}
if ($nivel == 7) {
    redirect('home.php');
}
?>

<?php
if (isset($_POST['edit_recomendacion'])) {
    $req_fields = array('autoridad_responsable', 'servidor_publico', 'fecha_acuerdo', 'observaciones');
    validate_fields($req_fields);
    if (empty($errors)) {
        $id = (int)$e_recomendacion['id'];
        $autoridad_responsable   = remove_junk($db->escape($_POST['autoridad_responsable']));
        $servidor_publico   = remove_junk($db->escape($_POST['servidor_publico']));
        $fecha_acuerdo   = remove_junk($db->escape($_POST['fecha_acuerdo']));
        $observaciones   = remove_junk($db->escape($_POST['observaciones']));
        $recomendacion_adjunto   = remove_junk(($db->escape($_POST['recomendacion_adjunto'])));

        $folio_editar = $e_recomendacion['folio_queja'];
        $resultado = str_replace("/", "-", $folio_editar);
        $carpeta = 'uploads/quejas/' . $resultado . '/recomendacion';

        $name = $_FILES['recomendacion_adjunto']['name'];
        $size = $_FILES['recomendacion_adjunto']['size'];
        $type = $_FILES['recomendacion_adjunto']['type'];
        $temp = $_FILES['recomendacion_adjunto']['tmp_name'];

        //Verificamos que exista la carpeta y si sí, guardamos el pdf
        if (is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        }

        if ($name != '') {
            $sql = "UPDATE recomendaciones SET autoridad_responsable='{$autoridad_responsable}', servidor_publico='{$servidor_publico}', fecha_recomendacion='{$fecha_acuerdo}', observaciones='{$observaciones}', recomendacion_adjunto='{$name}' WHERE id='{$db->escape($id)}'";
        }
        if ($name == '') {
            $sql = "UPDATE recomendaciones SET autoridad_responsable='{$autoridad_responsable}', servidor_publico='{$servidor_publico}', fecha_recomendacion='{$fecha_acuerdo}', observaciones='{$observaciones}' WHERE id='{$db->escape($id)}'";
        }
        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            $session->msg('s', "Información Actualizada ");
            redirect('recomendaciones.php', false);
        } else {
            $session->msg('d', ' Lo siento no se actualizaron los datos.');
            redirect('edit_recomendacion.php?id=' . (int)$e_recomendacion['id'], false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_recomendacion.php?id=' . (int)$e_recomendacion['id'], false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Editar recomendación <?php echo $e_recomendacion['folio_recomendacion']; ?></span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="edit_recomendacion.php?id=<?php echo (int)$e_recomendacion['id']; ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="autoridad_responsable">Autoridad Responsable</label>
                            <input type="text" class="form-control" name="autoridad_responsable" value="<?php echo remove_junk($e_recomendacion['autoridad_responsable']); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="servidor_publico">Servidor público</label>
                            <input type="text" class="form-control" name="servidor_publico" value="<?php echo remove_junk($e_recomendacion['servidor_publico']); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_acuerdo">Fecha de Recomendación</label><br>
                            <input type="date" class="form-control" name="fecha_acuerdo" value="<?php echo remove_junk($e_recomendacion['fecha_recomendacion']); ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="observaciones">Observaciones</label>
                            <textarea class="form-control" name="observaciones" id="observaciones" cols="10" rows="1" value="<?php echo remove_junk($e_recomendacion['observaciones']); ?>"><?php echo remove_junk($e_recomendacion['observaciones']); ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <span>
                                <label for="recomendacion_adjunto">Recomendación Adjunto</label>
                                <input id="recomendacion_adjunto" type="file" accept="application/pdf" class="form-control" name="recomendacion_adjunto">
                                <label style="font-size:12px; color:#E3054F;">Archivo Actual: <?php echo remove_junk($e_recomendacion['recomendacion_adjunto']); ?><?php ?></label>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="recomendaciones.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="edit_recomendacion" class="btn btn-primary" value="subir">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>