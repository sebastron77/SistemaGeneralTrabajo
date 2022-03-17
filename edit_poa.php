<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Editar POA';
require_once('includes/load.php');
$user = current_user();
$detalle = $user['id'];
$e_poa = find_by_id('poa', (int)$_GET['id']);
$id_folio = last_id_folios();
page_require_level(2);
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['edit_informe'])) {

    $req_fields = array('anio_ejercicio', 'fecha_recepcion');
    validate_fields($req_fields);

    if (empty($errors)) {
        $id = (int)$e_poa['id'];
        $anio_ejercicio   = remove_junk($db->escape($_POST['anio_ejercicio']));
        $oficio_recibido   = remove_junk($db->escape($_POST['oficio_recibido']));
        $poa   = remove_junk($db->escape($_POST['poa']));
        $fecha_recepcion   = remove_junk($db->escape($_POST['fecha_recepcion']));
        $oficio_entrega   = remove_junk(($db->escape($_POST['oficio_entrega'])));

        $folio_editar = $e_poa['folio'];
        $resultado = str_replace("/", "-", $folio_editar);
        $carpeta = 'uploads/informes/' . $resultado;

        $name = $_FILES['oficio_recibido']['name'];
        $size = $_FILES['oficio_recibido']['size'];
        $type = $_FILES['oficio_recibido']['type'];
        $temp = $_FILES['oficio_recibido']['tmp_name'];

        if (is_dir($carpeta)) {
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        }

        $name2 = $_FILES['poa']['name'];
        $size2 = $_FILES['poa']['size'];
        $type2 = $_FILES['poa']['type'];
        $temp2 = $_FILES['poa']['tmp_name'];

        if (is_dir($carpeta)) {
            $move2 =  move_uploaded_file($temp2, $carpeta . "/" . $name2);
        }

        $name3 = $_FILES['oficio_entrega']['name'];
        $size3 = $_FILES['oficio_entrega']['size'];
        $type3 = $_FILES['oficio_entrega']['type'];
        $temp3 = $_FILES['oficio_entrega']['tmp_name'];

        if (is_dir($carpeta)) {
            $move3 =  move_uploaded_file($temp3, $carpeta . "/" . $name3);
        }

        if ($name != '' && $name2 != '' && $name3 != '') {
            $sql = "UPDATE poa SET anio_ejercicio='{$anio_ejercicio}', oficio_recibido='{$name}', poa='{$name2}', fecha_recepcion='{$fecha_recepcion}', oficio_entrega='{$name3}' WHERE id='{$db->escape($id)}'";
        }
        if ($name == '' && $name2 == '' && $name3 == '') {
            $sql = "UPDATE poa SET anio_ejercicio='{$anio_ejercicio}', oficio_recibido='{$name}', poa='{$name2}', fecha_recepcion='{$fecha_recepcion}', oficio_entrega='{$name3}' WHERE id='{$db->escape($id)}'";
        }
        if ($name != '' && $name2 == '') {
            $sql = "UPDATE poa SET anio_ejercicio='{$anio_ejercicio}', oficio_recibido='{$name}', poa='{$name2}', fecha_recepcion='{$fecha_recepcion}', oficio_entrega='{$name3}' WHERE id='{$db->escape($id)}'";
        }
        if ($name == '' && $name2 != '') {
            $sql = "UPDATE poa SET anio_ejercicio='{$anio_ejercicio}', oficio_recibido='{$name}', poa='{$name2}', fecha_recepcion='{$fecha_recepcion}', oficio_entrega='{$name3}' WHERE id='{$db->escape($id)}'";
        }
        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            //sucess
            $session->msg('s', " El POA ha sido editado con éxito.");
            redirect('poa.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo editar el POA.');
            redirect('edit_poa.php?id=' . (int)$e_poa['id'], false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_poa.php?id=' . (int)$e_poa['id'], false);
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
                <span>Editar informe</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="edit_informe.php?id=<?php echo (int)$e_poa['id']; ?>" enctype="multipart/form-data">
            <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="num_informe">Número de Informe</label>
                            <input type="text" class="form-control" name="num_informe" value="<?php echo remove_junk($e_poa['num_informe']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_informe">Fecha del informe</label>
                            <input type="date" class="form-control" name="fecha_informe" value="<?php echo remove_junk($e_poa['fecha_informe']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_entrega">Fecha del entrega</label>
                            <input type="date" class="form-control" name="fecha_entrega" value="<?php echo remove_junk($e_poa['fecha_entrega']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="oficio_entrega_congreso">Adjuntar oficio de entrega Congreso</label>
                            <input type="file" accept="application/pdf" class="form-control" name="oficio_entrega_congreso" value="<?php echo remove_junk($e_poa['oficio_entrega_congreso']); ?>" id="oficio_entrega_congreso">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="caratula_informe">Caratula del Informe</label>
                            <input type="file" accept="application/pdf" class="form-control" name="caratula_informe" value="<?php echo remove_junk($e_poa['caratula_informe']); ?>" id="caratula_informe">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="liga_url">URL</label>
                            <input type="text" accept="application/pdf" class="form-control" name="liga_url" id="liga_url" value="<?php echo remove_junk($e_poa['liga_url']); ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="informes.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="edit_informe" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>