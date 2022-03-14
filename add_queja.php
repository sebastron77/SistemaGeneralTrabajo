<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Agregar Queja';
require_once('includes/load.php');
page_require_level(5);
?>
<?php
// $queja = find_by_id('ost_ticket',(int)$_GET['id']);
require_once('includes/load2.php');
$queja = find_by_id_quejas((int)$_GET['id']);
if (!$queja) {
    $session->msg("d", "Error al agregar.");
    redirect('quejas.php');
}
$user = current_user();
$nivel = $user['user_level'];
?>

<?php
if (isset($_POST['add_queja'])) {
    $req_fields = array('folio_queja', 'ultima_actualizacion', 'autoridad_responsable', 'creada_por', 'estatus_queja', 'asignada_a');
    validate_fields($req_fields);
    if (empty($errors)) {
        // $id = (int)$queja['id'];
        $folio_queja   = remove_junk($db->escape($_POST['folio_queja']));
        $ultima_actualizacion   = remove_junk($db->escape($_POST['ultima_actualizacion']));
        $autoridad_responsable   = remove_junk($db->escape($_POST['autoridad_responsable']));
        $creada_por   = remove_junk($db->escape($_POST['creada_por']));
        $estatus_queja   = remove_junk($db->escape($_POST['estatus_queja']));
        $asignada_a   = remove_junk(($db->escape($_POST['asignada_a'])));
        //$name = remove_junk((int)$db->escape($_POST['detalle-user']));

        // $folio_editar = $queja['folio'];
        // $resultado = str_replace("/", "-", $folio_editar);
        // $carpeta = 'uploads/orientacioncanalizacion/canalizacion/' . $resultado;

        // $name = $_FILES['adjunto']['name'];
        // $size = $_FILES['adjunto']['size'];
        // $type = $_FILES['adjunto']['type'];
        // $temp = $_FILES['adjunto']['tmp_name'];

        // if (is_dir($carpeta)) {
        //     $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        // }

        // if ($name != '') {
        $sql = "INSERT INTO quejas (";
        $sql .= "folio_queja,ultima_actualizacion,autoridad_responsable,creada_por,estatus_queja,asignada_a";
        $sql .= ") VALUES (";
        $sql .= " '{$folio_queja}','{$ultima_actualizacion}','{$autoridad_responsable}','{$creada_por}','{$estatus_queja}','{$asignada_a}'";
        $sql .= ")";
        // }
        // if ($name == '') {
        //     $sql = "UPDATE orientacion_canalizacion SET correo_electronico='{$correo}', nombre_completo='{$nombre}', nivel_estudios='{$nestudios}', ocupacion='{$ocupacion}', edad='{$edad}', telefono='{$tel}', extension='{$ext}', sexo='{$sexo}', calle_numero='{$calle}', colonia='{$colonia}',codigo_postal='{$cpostal}', municipio_localidad='{$municipio}', entidad='{$entidad}', nacionalidad='{$nacionalidad}', medio_presentacion='{$medio}', observaciones='{$observaciones}' WHERE id='{$db->escape($id)}'";
        // }
        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            $session->msg('s', "Queja guardada en la base de datos.");
            redirect('quejas.php', false);
        } else {
            $session->msg('d', 'Lo siento no se guardó la queja.');
            redirect('quejas.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('quejas.php', false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<?php echo display_msg($msg); ?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Agregar queja</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_queja.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="folio_queja">Folio Queja</label>
                            <input type="text" class="form-control" name="folio_queja" value="<?php echo remove_junk($queja['Folio_Queja']); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ultima_actualizacion">Última Actualización</label>
                            <input type="text" class="form-control" name="ultima_actualizacion" value="<?php echo remove_junk($queja['Ultima_Actualizacion']); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="autoridad_responsable">Autoridad Responsable</label>
                            <input type="text" class="form-control" name="autoridad_responsable" value="<?php echo remove_junk($queja['Autoridad_Responsable']); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="creada_por">Creada por</label>
                            <input type="text" class="form-control" name="creada_por" value="<?php echo remove_junk($queja['Creado_Por']); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="estatus_queja">Estatus Queja</label>
                            <input type="text" class="form-control" name="estatus_queja" value="<?php if ($queja['isanswered'] == 1) {
                                                                                                    echo 'Cerrada';
                                                                                                }
                                                                                                if (($queja['isanswered'] == 0) && ($queja['isoverdue'] == 1)) {
                                                                                                    echo 'Abierta';
                                                                                                }
                                                                                                if (($queja['isanswered'] == 0) && ($queja['isoverdue'] == 0)) {
                                                                                                    echo 'Pendiente';
                                                                                                }
                                                                                                if (($queja['isanswered'] == 0) && ($queja['isoverdue'] == 1)) {
                                                                                                    echo 'No atendido';
                                                                                                }
                                                                                                ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="asignada_a">Asignada a</label>
                            <input type="text" class="form-control" name="asignada_a" value="<?php echo remove_junk($queja['Asignado_Nombre'] . " " . $queja['Asignado_Apellido']); ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group clearfix">
                    <a href="quejas.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="add_queja" class="btn btn-primary" value="subir">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>