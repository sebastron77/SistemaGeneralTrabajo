<?php
$page_title = 'Editar Queja';
require_once('includes/load.php');

// page_require_level(4);
?>
<?php
$e_queja = find_by_id('quejas',(int)$_GET['id']);
if (!$e_queja) {
    $session->msg("d", "id de queja no encontrado.");
    redirect('quejas_agregadas.php');
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
    page_require_level(5);
}
if ($nivel == 6) {
    redirect('home.php');
}
if ($nivel == 7) {
    page_require_level(7);
}
?>

<?php
if (isset($_POST['edit_queja'])) {
    $req_fields = array('autoridad_responsable', 'agraviado');
    validate_fields($req_fields);
    if (empty($errors)) {
        $id = (int)$e_queja['id'];
        $autoridad_responsable   = remove_junk($db->escape($_POST['autoridad_responsable']));
        $agraviado   = remove_junk($db->escape($_POST['agraviado']));
        $estatus_queja   = remove_junk($db->escape($_POST['estatus_queja']));
        date_default_timezone_set('America/Mexico_City');
        $fecha_actualizacion = date('Y-m-d H:i:s');

        $sql = "UPDATE quejas SET ultima_actualizacion='{$fecha_actualizacion}', autoridad_responsable='{$autoridad_responsable}', creada_por='{$agraviado}', estatus_queja='$estatus_queja' WHERE id='{$db->escape($id)}'";
        
        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            $session->msg('s', "Información Actualizada ");
            redirect('quejas.php', false);
        } else {
            $session->msg('d', ' Lo siento no se actualizaron los datos.');
            redirect('edit_queja.php?id=' . (int)$e_queja['id'], false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_queja.php?id=' . (int)$e_queja['id'], false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Editar queja <?php echo $e_queja['folio_queja']; ?></span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="edit_queja.php?id=<?php echo (int)$e_queja['id']; ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="folio_queja">Folio de Queja</label>
                            <input type="text" class="form-control" name="folio_queja" value="<?php echo remove_junk($e_queja['folio_queja']);?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="autoridad_responsable">Autoridad Responsable</label>
                            <input type="text" class="form-control" name="autoridad_responsable" placeholder="Nombre Completo" value="<?php echo remove_junk(($e_queja['autoridad_responsable'])); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="agraviado">Agraviado</label><br>
                            <input type="text" class="form-control" name="agraviado" placeholder="Nombre Completo" value="<?php echo remove_junk(($e_queja['creada_por'])); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="estatus_queja">Estatus de Queja</label>
                            <input type="text" class="form-control" name="estatus_queja" value="<?php echo remove_junk($e_queja['estatus_queja']); ?>">
                        </div>
                    </div>
                </div>
                
                <div class="form-group clearfix">
                    <a href="quejas_agregadas.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="edit_queja" class="btn btn-primary" value="subir">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>