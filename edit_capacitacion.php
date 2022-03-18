<?php
$page_title = 'Editar Capacitación';
require_once('includes/load.php');

// page_require_level(4);
?>
<?php
$e_detalle = find_by_id_capacitacion((int)$_GET['id']);
if (!$e_detalle) {
    $session->msg("d", "id de capacitación no encontrado.");
    redirect('capacitaciones.php');
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
    page_require_level_exacto(4);
}
if ($nivel == 5) {
    redirect('home.php');
}
if ($nivel == 6) {
    page_require_level_exacto(6);
}
if ($nivel == 7) {
    redirect('home.php');
}
?>

<?php
if (isset($_POST['edit_capacitacion'])) {
    $req_fields = array('nombre_capacitacion', 'quien_solicita', 'fecha', 'hora', 'lugar', 'no_asistentes', 'modalidad', 'depto_org', 'capacitador');
    validate_fields($req_fields);
    if (empty($errors)) {
        $id = (int)$e_detalle['id'];
        $nombre   = remove_junk($db->escape($_POST['nombre_capacitacion']));
        $solicita   = remove_junk($db->escape($_POST['quien_solicita']));
        $fecha   = remove_junk($db->escape($_POST['fecha']));
        $hora   = remove_junk($db->escape($_POST['hora']));
        $lugar   = remove_junk(($db->escape($_POST['lugar'])));
        $asistentes   = remove_junk(($db->escape($_POST['no_asistentes'])));
        $modalidad   = remove_junk($db->escape($_POST['modalidad']));
        $depto   = remove_junk($db->escape($_POST['depto_org']));
        $capacitador   = remove_junk($db->escape($_POST['capacitador']));
        $curriculum   = remove_junk($db->escape($_POST['curriculum']));
        $constancia   = remove_junk($db->escape($_POST['constancia']));

        $folio_editar = $e_detalle['folio'];
        $resultado = str_replace("/", "-", $folio_editar);
        $carpeta = 'uploads/capacitaciones/curriculums/' . $resultado;

        $name = $_FILES['curriculum']['name'];
        $size = $_FILES['curriculum']['size'];
        $type = $_FILES['curriculum']['type'];
        $temp = $_FILES['curriculum']['tmp_name'];

        //Verificamos que exista la carpeta y si sí, guardamos el pdf
        if (is_dir($carpeta)) {
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        }

        if ($name != '') {
            $sql = "UPDATE capacitaciones SET nombre_capacitacion='{$nombre}', quien_solicita='{$solicita}', fecha='{$fecha}', hora='{$hora}', lugar='{$lugar}', no_asistentes='{$asistentes}', modalidad='{$modalidad}', depto_org='{$depto}', capacitador='{$capacitador}', curriculum='{$name}', constancia='{$constancia}' WHERE id='{$db->escape($id)}'";
        }
        if ($name == '') {
            $sql = "UPDATE capacitaciones SET nombre_capacitacion='{$nombre}', quien_solicita='{$solicita}', fecha='{$fecha}', hora='{$hora}', lugar='{$lugar}', no_asistentes='{$asistentes}', modalidad='{$modalidad}', depto_org='{$depto}', capacitador='{$capacitador}', constancia='{$constancia}' WHERE id='{$db->escape($id)}'";
        }
        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            $session->msg('s', "Información Actualizada ");
            redirect('capacitaciones.php', false);
        } else {
            $session->msg('d', ' Lo siento no se actualizaron los datos.');
            redirect('edit_capacitacion.php?id=' . (int)$e_detalle['id'], false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_capacitacion.php?id=' . (int)$e_detalle['id'], false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Editar capacitación <?php echo $e_detalle['folio']; ?></span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="edit_capacitacion.php?id=<?php echo (int)$e_detalle['id']; ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="nombre_capacitacion">Nombre de la capacitación</label>
                            <input type="text" class="form-control" name="nombre_capacitacion" value="<?php echo remove_junk($e_detalle['nombre_capacitacion']); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="quien_solicita">¿Quién lo solicita?</label>
                            <input type="text" class="form-control" name="quien_solicita" placeholder="Nombre Completo" value="<?php echo remove_junk(($e_detalle['quien_solicita'])); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha">Fecha</label><br>
                            <input type="date" class="form-control" name="fecha" value="<?php echo remove_junk($e_detalle['fecha']); ?>">
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="hora">Hora</label><br>
                            <input type="time" class="form-control" name="hora" value="<?php echo remove_junk($e_detalle['hora']); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="lugar">Lugar</label>
                            <input type="text" class="form-control" name="lugar" value="<?php echo remove_junk($e_detalle['lugar']); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="no_asistentes">No. de asistentes</label>
                            <input type="number" min="1" max="1000" class="form-control" name="no_asistentes" value="<?php echo remove_junk($e_detalle['no_asistentes']); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="modalidad">Modalidad</label>
                            <select class="form-control" name="modalidad">
                                <option value="Presencial" <?php if ($e_detalle['modalidad'] === 'Presencial') echo 'selected="selected"'; ?>>Presencial</option>
                                <option value="En línea" <?php if ($e_detalle['modalidad'] === 'En línea') echo 'selected="selected"'; ?>>En línea</option>
                                <option value="Híbrido" <?php if ($e_detalle['modalidad'] === 'Híbrido') echo 'selected="selected"'; ?>>Híbrido</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="depto_org">Departamento/Organización</label>
                            <input type="text" class="form-control" name="depto_org" value="<?php echo remove_junk(($e_detalle['depto_org'])); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="capacitador">Capacitador</label>
                            <input type="text" class="form-control" name="capacitador" placeholder="Nombre Completo" value="<?php echo remove_junk(($e_detalle['capacitador'])); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="curriculum">Curriculum</label>
                            <input type="file" accept="application/pdf" class="form-control" name="curriculum" id="curriculum" value="uploads/curriculums/<?php echo $e_detalle['curriculum']; ?>">
                            <label style="font-size:12px; color:#E3054F;">Archivo Actual: <?php echo remove_junk($e_detalle['curriculum']); ?><?php ?></label>
                        </div>
                    </div>
                    <!-- <div class="col-md-3">
                        <div class="form-group">
                            <label for="constancia">Constancia</label>
                            <input type="file" accept="application/pdf" class="form-control" name="constancia">
                        </div>
                    </div> -->
                </div>
                <div class="form-group clearfix">
                    <a href="capacitaciones.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="edit_capacitacion" class="btn btn-primary" value="subir">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>