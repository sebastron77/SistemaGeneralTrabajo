<?php
$page_title = 'Editar Acuerdo de No Violación';
require_once('includes/load.php');

// page_require_level(4);
?>
<?php
$e_acuerdo = find_by_id('acuerdos', (int)$_GET['id']);
if (!$e_acuerdo) {
    $session->msg("d", "id de acuerdo no encontrado.");
    redirect('acuerdos_no_violacion.php');
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
if (isset($_POST['edit_acuerdo_no_violacion'])) {
    $req_fields = array('autoridad_responsable', 'servidor_publico', 'fecha_acuerdo', 'observaciones');
    validate_fields($req_fields);
    if (empty($errors)) {
        $id = (int)$e_acuerdo['id'];
        $autoridad_responsable   = remove_junk($db->escape($_POST['autoridad_responsable']));
        $servidor_publico   = remove_junk($db->escape($_POST['servidor_publico']));
        $fecha_acuerdo   = remove_junk($db->escape($_POST['fecha_acuerdo']));
        $observaciones   = remove_junk($db->escape($_POST['observaciones']));
        $acuerdo_adjunto   = remove_junk(($db->escape($_POST['acuerdo_adjunto'])));

        $folio_editar = $e_acuerdo['folio_queja'];
        $resultado = str_replace("/", "-", $folio_editar);
        $carpeta = 'uploads/quejas/' . $resultado . '/acuerdosNoViolacion';

        $name = $_FILES['acuerdo_adjunto']['name'];
        $size = $_FILES['acuerdo_adjunto']['size'];
        $type = $_FILES['acuerdo_adjunto']['type'];
        $temp = $_FILES['acuerdo_adjunto']['tmp_name'];

        //Verificamos que exista la carpeta y si sí, guardamos el pdf
        if (is_dir($carpeta)) {
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
            // $move =  move_uploaded_file($temp, $carpeta . "/" . $name2);
        } else{
            mkdir($carpeta, 0777, true);
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
            // $move =  move_uploaded_file($temp, $carpeta . "/" . $name2);
        }

        $name2 = $_FILES['acuerdo_adjunto_publico']['name'];
        $size2 = $_FILES['acuerdo_adjunto_publico']['size'];
        $type2 = $_FILES['acuerdo_adjunto_publico']['type'];
        $temp2 = $_FILES['acuerdo_adjunto_publico']['tmp_name'];

        //Verificamos que exista la carpeta y si sí, guardamos el pdf
        if (is_dir($carpeta)) {
            // $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
            $move2 =  move_uploaded_file($temp2, $carpeta . "/" . $name2);
        } else{
            mkdir($carpeta, 0777, true);
            // $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
            $move2 =  move_uploaded_file($temp2, $carpeta . "/" . $name2);
        }

        if ($name != '' && $name2 != '') {
            $sql = "UPDATE acuerdos SET autoridad_responsable='{$autoridad_responsable}', servidor_publico='{$servidor_publico}', fecha_acuerdo='{$fecha_acuerdo}', observaciones='{$observaciones}', acuerdo_adjunto='{$name}', acuerdo_adjunto_publico='{$name2}' WHERE id='{$db->escape($id)}'";
        }
        if ($name == '' && $name2 == '') {
            $sql = "UPDATE acuerdos SET autoridad_responsable='{$autoridad_responsable}', servidor_publico='{$servidor_publico}', fecha_acuerdo='{$fecha_acuerdo}', observaciones='{$observaciones}' WHERE id='{$db->escape($id)}'";
        }
        if ($name != '' && $name2 == '') {
            $sql = "UPDATE acuerdos SET autoridad_responsable='{$autoridad_responsable}', servidor_publico='{$servidor_publico}', fecha_acuerdo='{$fecha_acuerdo}', observaciones='{$observaciones}', acuerdo_adjunto='{$name}' WHERE id='{$db->escape($id)}'";
        }
        if ($name == '' && $name2 != '') {
            $sql = "UPDATE acuerdos SET autoridad_responsable='{$autoridad_responsable}', servidor_publico='{$servidor_publico}', fecha_acuerdo='{$fecha_acuerdo}', observaciones='{$observaciones}', acuerdo_adjunto_publico='{$name2}' WHERE id='{$db->escape($id)}'";
        }

        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            $session->msg('s', "Información Actualizada ");
            redirect('acuerdos_no_violacion.php', false);
        } else {
            $session->msg('d', ' Lo siento no se actualizaron los datos.');
            redirect('edit_acuerdo_no_violacion.php?id=' . (int)$e_acuerdo['id'], false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_acuerdo_no_violacion.php?id=' . (int)$e_acuerdo['id'], false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Editar acuerdo <?php echo $e_acuerdo['folio_acuerdo']; ?></span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="edit_acuerdo_no_violacion.php?id=<?php echo (int)$e_acuerdo['id']; ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="autoridad_responsable">Autoridad Responsable</label>
                            <input type="text" class="form-control" name="autoridad_responsable" value="<?php echo remove_junk($e_acuerdo['autoridad_responsable']); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="servidor_publico">Servidor público</label>
                            <input type="text" class="form-control" name="servidor_publico" value="<?php echo remove_junk($e_acuerdo['servidor_publico']); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_acuerdo">Fecha de Acuerdo</label><br>
                            <input type="date" class="form-control" name="fecha_acuerdo" value="<?php echo remove_junk($e_acuerdo['fecha_acuerdo']); ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="observaciones">Observaciones</label>
                            <textarea class="form-control" name="observaciones" id="observaciones" cols="10" rows="1" value="<?php echo remove_junk($e_acuerdo['observaciones']); ?>"><?php echo remove_junk($e_acuerdo['observaciones']); ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <span>
                                <label for="acuerdo_adjunto">Acuerdo Adjunto</label>
                                <input id="acuerdo_adjunto" type="file" accept="application/pdf" class="form-control" name="acuerdo_adjunto">
                                <label style="font-size:12px; color:#E3054F;">Archivo Actual: <?php echo remove_junk($e_acuerdo['acuerdo_adjunto']); ?><?php ?></label>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <span>
                                <label for="acuerdo_adjunto_publico">Acuerdo Adjunto Público</label>
                                <input id="acuerdo_adjunto_publico" type="file" accept="application/pdf" class="form-control" name="acuerdo_adjunto_publico">
                                <label style="font-size:12px; color:#E3054F;">Archivo Actual: <?php echo remove_junk($e_acuerdo['acuerdo_adjunto_publico']); ?><?php ?></label>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="acuerdos_no_violacion.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="edit_acuerdo_no_violacion" class="btn btn-primary" value="subir">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>