<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Editar Informe Trimestral/Anual';
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
// if ($nivel_user <= 2) {
//     page_require_level(2);
// }
// if ($nivel_user == 7) {
//     page_require_level_exacto(7);
// };
// // page_require_area(4);
// if ($nivel_user > 2 && $nivel_user < 7) :
//     redirect('home.php');
// endif;
// if ($nivel_user > 7) :
//     redirect('home.php');
// endif;
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['edit_informe'])) {

    $req_fields = array('num_nom_informe', 'fecha_inicio_informe', 'fecha_fin_informe');
    validate_fields($req_fields);

    if (empty($errors)) {
        $id = (int)$e_informe['id'];
        $num_nom_informe   = remove_junk($db->escape($_POST['num_nom_informe']));
        $fecha_inicio_informe   = remove_junk($db->escape($_POST['fecha_inicio_informe']));
        $fecha_fin_informe   = remove_junk($db->escape($_POST['fecha_fin_informe']));
        $fecha_entrega_informe   = remove_junk($db->escape($_POST['fecha_entrega_informe']));
        $institucion_a_quien_se_entrega   = remove_junk(($db->escape($_POST['institucion_a_quien_se_entrega'])));
        $caratula_informe   = remove_junk(($db->escape($_POST['caratula_informe'])));
        $informe_adjunto   = remove_junk($db->escape($_POST['informe_adjunto']));

        $folio_editar = $e_informe['folio'];
        $resultado = str_replace("/", "-", $folio_editar);
        $carpeta = 'uploads/informes/' . $resultado;

        $name = $_FILES['informe_adjunto']['name'];
        $size = $_FILES['informe_adjunto']['size'];
        $type = $_FILES['informe_adjunto']['types'];
        $temp = $_FILES['informe_adjunto']['tmp_name'];

        if (is_dir($carpeta)) {
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name2);
        } else {
            mkdir($carpeta, 0777, true);
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name2);
        }

        $name2 = $_FILES['caratula_informe']['name'];
        $size2 = $_FILES['caratula_informe']['size'];
        $type2 = $_FILES['caratula_informe']['type'];
        $temp2 = $_FILES['caratula_informe']['tmp_name'];

        if (is_dir($carpeta)) {
            $move2 =  move_uploaded_file($temp2, $carpeta . "/" . $name2);
        } else {
            mkdir($carpeta, 0777, true);
            $move2 =  move_uploaded_file($temp, $carpeta . "/" . $name);
        }

        if ($name != '' && $name2 != '') {
            $sql = "UPDATE informes SET num_nom_informe='{$num_nom_informe}', fecha_inicio_informe='{$fecha_inicio_informe}',fecha_fin_informe='{$fecha_fin_informe}', fecha_entrega_informe='{$fecha_entrega_informe}',institucion_a_quien_se_entrega='{$institucion_a_quien_se_entrega}', caratula_informe='{$name2}', informe_adjunto='{$name}' WHERE id='{$db->escape($id)}'";
        }
        if ($name == '' && $name2 == '') {
            $sql = "UPDATE informes SET num_nom_informe='{$num_nom_informe}', fecha_inicio_informe='{$fecha_inicio_informe}',fecha_fin_informe='{$fecha_fin_informe}', fecha_entrega_informe='{$fecha_entrega_informe}',institucion_a_quien_se_entrega='{$institucion_a_quien_se_entrega}' WHERE id='{$db->escape($id)}'";
        }
        if ($name != '' && $name2 == '') {
            $sql = "UPDATE informes SET num_nom_informe='{$num_nom_informe}', fecha_inicio_informe='{$fecha_inicio_informe}',fecha_fin_informe='{$fecha_fin_informe}', fecha_entrega_informe='{$fecha_entrega_informe}',institucion_a_quien_se_entrega='{$institucion_a_quien_se_entrega}', informe_adjunto='{$name}' WHERE id='{$db->escape($id)}'";
        }
        if ($name == '' && $name2 != '') {
            $sql = "UPDATE informes SET num_nom_informe='{$num_nom_informe}', fecha_inicio_informe='{$fecha_inicio_informe}',fecha_fin_informe='{$fecha_fin_informe}', fecha_entrega_informe='{$fecha_entrega_informe}',institucion_a_quien_se_entrega='{$institucion_a_quien_se_entrega}', caratula_informe='{$name2}' WHERE id='{$db->escape($id)}'";
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="num_nom_informe">Número de Informe</label>
                            <input type="text" class="form-control" name="num_nom_informe" value="<?php echo remove_junk($e_informe['num_nom_informe']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_entrega_informe">Fecha de entrega del reporte</label>
                            <input type="date" class="form-control" name="fecha_entrega_informe" value="<?php echo remove_junk($e_informe['fecha_entrega_informe']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Periodo del informe</label>
                            <div class="input-group input-daterange">
                                <input type="date" style="width: 125px;" name="fecha_inicio_informe" value="<?php echo remove_junk($e_informe['fecha_inicio_informe']); ?>" class="form-control">
                                <div class="input-group-addon" style="width: 12px;">-</div>
                                <input type="date" style="width: 125px;" name="fecha_fin_informe" value="<?php echo remove_junk($e_informe['fecha_fin_informe']); ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-4">
                        <div class="form-group">
                            <label for="institucion_a_quien_se_entrega">Institución a quien se entrega reporte</label>
                            <select class="form-control" name="institucion_a_quien_se_entrega">
                                <option <?php if ($e_informe['institucion_a_quien_se_entrega'] === 'Consejo') echo 'selected="selected"'; ?> value="Consejo">Consejo</option>
                                <option <?php if ($e_informe['institucion_a_quien_se_entrega'] === 'Congreso') echo 'selected="selected"'; ?> value="Congreso">Congreso</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="caratula_informe">Caratula del Informe</label>
                            <input type="file" accept="application/pdf" class="form-control" name="caratula_informe" value="<?php echo remove_junk($e_informe['caratula_informe']); ?>" id="caratula_informe">
                            <label style="font-size:12px; color:#E3054F;">Archivo Actual: <?php echo remove_junk($e_informe['caratula_informe']); ?><?php ?></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="informe_adjunto">Adjuntar oficio de entrega Congreso</label>
                            <input type="file" accept="application/pdf" class="form-control" name="informe_adjunto" value="<?php echo remove_junk($e_informe['informe_adjunto']); ?>" id="informe_adjunto">
                            <label style="font-size:12px; color:#E3054F;">Archivo Actual: <?php echo remove_junk($e_informe['informe_adjunto']); ?><?php ?></label>
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