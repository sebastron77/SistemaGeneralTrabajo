<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Editar Informe';
require_once('includes/load.php');
$user = current_user();
$detalle = $user['id'];
$e_informe = find_by_id('informes', (int)$_GET['id']);
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
};
// page_require_area(4);
if ($nivel_user > 2 && $nivel_user < 7):
    redirect('home.php');
endif;
if ($nivel_user > 7):
    redirect('home.php');
endif;
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['edit_informe'])) {

    $req_fields = array('num_informe', 'fecha_informe', 'fecha_entrega', 'liga_url');
    validate_fields($req_fields);

    if (empty($errors)) {
        $id = (int)$e_informe['id'];
        $num_informe   = remove_junk($db->escape($_POST['num_informe']));
        $fecha_informe   = remove_junk($db->escape($_POST['fecha_informe']));
        $fecha_entrega   = remove_junk($db->escape($_POST['fecha_entrega']));
        $oficio_entrega_congreso   = remove_junk($db->escape($_POST['oficio_entrega_congreso']));
        $caratula_informe   = remove_junk(($db->escape($_POST['caratula_informe'])));
        $liga_url   = remove_junk(($db->escape($_POST['liga_url'])));

        $folio_editar = $e_informe['folio'];
        $resultado = str_replace("/", "-", $folio_editar);
        $carpeta = 'uploads/informes/' . $resultado;

        $name = $_FILES['oficio_entrega_congreso']['name'];
        $size = $_FILES['oficio_entrega_congreso']['size'];
        $type = $_FILES['oficio_entrega_congreso']['type'];
        $temp = $_FILES['oficio_entrega_congreso']['tmp_name'];

        if (is_dir($carpeta)) {
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        } else{
            mkdir($carpeta, 0777, true);
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        }

        $name2 = $_FILES['caratula_informe']['name'];
        $size2 = $_FILES['caratula_informe']['size'];
        $type2 = $_FILES['caratula_informe']['type'];
        $temp2 = $_FILES['caratula_informe']['tmp_name'];

        if (is_dir($carpeta)) {
            $move2 =  move_uploaded_file($temp2, $carpeta . "/" . $name2);
        } else{
            mkdir($carpeta, 0777, true);
            $move2 =  move_uploaded_file($temp, $carpeta . "/" . $name);
        }

        if ($name != '' && $name2 != '') {
            $sql = "UPDATE informes SET num_informe='{$num_informe}', fecha_informe='{$fecha_informe}', fecha_entrega='{$fecha_entrega}', oficio_entrega_congreso='{$name}', caratula_informe='{$name2}', liga_url='{$liga_url}' WHERE id='{$db->escape($id)}'";
        }
        if ($name == '' && $name2 == '') {
            $sql = "UPDATE informes SET num_informe='{$num_informe}', fecha_informe='{$fecha_informe}', fecha_entrega='{$fecha_entrega}', liga_url='{$liga_url}' WHERE id='{$db->escape($id)}'";
        }
        if ($name != '' && $name2 == '') {
            $sql = "UPDATE informes SET num_informe='{$num_informe}', fecha_informe='{$fecha_informe}', fecha_entrega='{$fecha_entrega}', oficio_entrega_congreso='{$name}', liga_url='{$liga_url}' WHERE id='{$db->escape($id)}'";
        }
        if ($name == '' && $name2 != '') {
            $sql = "UPDATE informes SET num_informe='{$num_informe}', fecha_informe='{$fecha_informe}', fecha_entrega='{$fecha_entrega}', caratula_informe='{$name2}', liga_url='{$liga_url}' WHERE id='{$db->escape($id)}'";
        }
        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            //sucess
            $session->msg('s', " El informe ha sido editado con éxito.");
            redirect('informes.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo editar el informe.');
            redirect('edit_informe.php?id=' . (int)$e_informe['id'], false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_informe.php?id=' . (int)$e_informe['id'], false);
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
            <form method="post" action="edit_informe.php?id=<?php echo (int)$e_informe['id']; ?>" enctype="multipart/form-data">
            <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="num_informe">Número de Informe</label>
                            <input type="text" class="form-control" name="num_informe" value="<?php echo remove_junk($e_informe['num_informe']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_informe">Fecha del informe</label>
                            <input type="date" class="form-control" name="fecha_informe" value="<?php echo remove_junk($e_informe['fecha_informe']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_entrega">Fecha del entrega</label>
                            <input type="date" class="form-control" name="fecha_entrega" value="<?php echo remove_junk($e_informe['fecha_entrega']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="oficio_entrega_congreso">Adjuntar oficio de entrega Congreso</label>
                            <input type="file" accept="application/pdf" class="form-control" name="oficio_entrega_congreso" value="<?php echo remove_junk($e_informe['oficio_entrega_congreso']); ?>" id="oficio_entrega_congreso">
                            <label style="font-size:12px; color:#E3054F;" >Archivo Actual: <?php echo remove_junk($e_informe['oficio_entrega_congreso']); ?><?php ?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="caratula_informe">Caratula del Informe</label>
                            <input type="file" accept="application/pdf" class="form-control" name="caratula_informe" value="<?php echo remove_junk($e_informe['caratula_informe']); ?>" id="caratula_informe">
                            <label style="font-size:12px; color:#E3054F;" >Archivo Actual: <?php echo remove_junk($e_informe['caratula_informe']); ?><?php ?></label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="liga_url">URL</label>
                            <input type="text" accept="application/pdf" class="form-control" name="liga_url" id="liga_url" value="<?php echo remove_junk($e_informe['liga_url']); ?>">
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