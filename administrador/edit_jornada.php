<?php
$page_title = 'Editar Jornada';
require_once('includes/load.php');
?>
<?php
$user = current_user();
$nivel = $user['user_level'];
$areas = find_all_area_orden('area');


if ($nivel <= 2) {
    page_require_level(2);
}
if ($nivel == 3) {
    redirect('home.php');
}
if ($nivel == 4) {
    page_require_level(4);
}
if ($nivel == 5) {
    redirect('home.php');
}
if ($nivel == 6) {
    redirect('home.php');
}
if ($nivel == 7) {
    redirect('home.php');
}
?>
<?php
$e_jornada = find_by_id_jornadas((int)$_GET['id']);
if (!$e_jornada) {
    $session->msg("d", "id de jornada no encontrado.");
    redirect('jornadas.php');
}
?>
<?php
if (isset($_POST['edit_jornada'])) {
    $req_fields = array('nombre_actividad', 'objetivo_actividad', 'area_responsable', 'mujeres', 'hombres', 'lgbtiq', 'fecha_actividad', 'alcance', 'colaboracion_institucional');
    validate_fields($req_fields);
    if (empty($errors)) {
        $id = (int)$e_jornada['id'];
        $nombre_actividad   = remove_junk($db->escape($_POST['nombre_actividad']));
        $objetivo_actividad   = remove_junk($db->escape($_POST['objetivo_actividad']));
        $mujeres   = remove_junk($db->escape($_POST['mujeres']));
        $area_responsable   = remove_junk($db->escape($_POST['area_responsable']));
        $hombres   = remove_junk(($db->escape($_POST['hombres'])));
        $lgbtiq   = remove_junk(($db->escape($_POST['lgbtiq'])));
        $fecha_actividad   = remove_junk(($db->escape($_POST['fecha_actividad'])));
        $alcance   = remove_junk(($db->escape($_POST['alcance'])));
        $colaboracion_institucional   = remove_junk($db->escape($_POST['colaboracion_institucional']));
        $evidencia_fotografica   = remove_junk($db->escape($_POST['evidencia_fotografica']));

        $folio_editar = $e_jornada['folio'];
        $resultado = str_replace("/", "-", $folio_editar);
        $carpeta = 'uploads/jornadas/' . $resultado;

        $name = $_FILES['ficha_adjunto']['name'];
        $size = $_FILES['ficha_adjunto']['size'];
        $type = $_FILES['ficha_adjunto']['type'];
        $temp = $_FILES['ficha_adjunto']['tmp_name'];

        if (is_dir($carpeta)) {
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        } else {
            mkdir($carpeta, 0777, true);
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        }

        if ($name != '') {
            $sql = "UPDATE jornadas SET nombre_actividad='{$nombre_actividad}', objetivo_actividad='{$objetivo_actividad}', area_responsable='{$area_responsable}', mujeres='{$mujeres}', hombres='{$hombres}', lgbtiq='{$lgbtiq}', fecha_actividad='{$fecha_actividad}', alcance='{$alcance}', colaboracion_institucional='{$colaboracion_institucional}' WHERE id='{$db->escape($id)}'";
        }
        if ($name == '') {
            $sql = "UPDATE jornadas SET nombre_actividad='{$nombre_actividad}', objetivo_actividad='{$objetivo_actividad}', area_responsable='{$area_responsable}', mujeres='{$mujeres}', hombres='{$hombres}', lgbtiq='{$lgbtiq}', fecha_actividad='{$fecha_actividad}', alcance='{$alcance}', colaboracion_institucional='{$colaboracion_institucional}' WHERE id='{$db->escape($id)}'";
        }
        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            $session->msg('s', "Información Actualizada ");
            redirect('jornadas.php', false);
        } else {
            $session->msg('d', ' Lo siento no se actualizaron los datos.');
            redirect('jornadas.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_jornada.php?id=' . (int)$e_jornada['id'], false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Editar Jornada</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="edit_jornada.php?id=<?php echo (int)$e_jornada['id']; ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nombre_actividad">Nombre de la Actividad</label>
                            <input type="text" class="form-control" value="<?php echo remove_junk($e_jornada['nombre_actividad']); ?>" name="nombre_actividad" required>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="objetivo_actividad">Objetivo de la actividad</label>
                            <textarea type="text" class="form-control" value="<?php echo remove_junk($e_jornada['objetivo_actividad']); ?>" name="objetivo_actividad" cols="30" rows="1" required><?php echo remove_junk($e_jornada['objetivo_actividad']); ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="area_responsable">Área Responsable</label>
                            <select class="form-control" name="area_responsable">
                                <option <?php if ($e_jornada['area_responsable'] === 'Área Médica') echo 'selected="selected"'; ?> value="Área Médica">Área Médica</option>
                                <option <?php if ($e_jornada['area_responsable'] === 'Área Psicológica') echo 'selected="selected"'; ?> value="Área Psicológica">Área Psicológica</option>
                                <option <?php if ($e_jornada['area_responsable'] === 'Ambas Áreas') echo 'selected="selected"'; ?> value="Ambas Áreas">Ambas Áreas</option>
                            </select>
                        </div>
                    </div>
                </div>
                Personas Atendidas:
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>Mujeres</label>
                            <input type="number" class="form-control" value="<?php echo remove_junk($e_jornada['mujeres']); ?>" min="1" max="120" name="mujeres" required>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>Hombres</label>
                            <input type="number" class="form-control" value="<?php echo remove_junk($e_jornada['hombres']); ?>" min="1" max="120" name="hombres" required>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>LGBTIQ+</label>
                            <input type="number" class="form-control" value="<?php echo remove_junk($e_jornada['lgbtiq']); ?>" min="1" max="120" name="lgbtiq" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Fecha de Actividad</label>
                            <input type="date" class="form-control" value="<?php echo remove_junk($e_jornada['fecha_actividad']); ?>" name="fecha_actividad" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="alcance">Alcance</label>
                            <select class="form-control" name="alcance">
                                <option <?php if ($e_jornada['alcance'] === 'Servidores Públicos') echo 'selected="selected"'; ?> value="Servidores Públicos">Servidores Públicos</option>
                                <option <?php if ($e_jornada['alcance'] === 'Sector Privado') echo 'selected="selected"'; ?> value="Sector Privado">Sector Privado</option>
                                <option <?php if ($e_jornada['alcance'] === 'Grupos Vulnerables') echo 'selected="selected"'; ?> value="Grupos Vulnerables">Grupos Vulnerables</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="colaboracion_institucional">Colaboración Institucional</label>
                            <textarea type="text" class="form-control" value="<?php echo remove_junk($e_jornada['colaboracion_institucional']); ?>" name="colaboracion_institucional" cols="30" rows="1" required><?php echo remove_junk($e_jornada['colaboracion_institucional']); ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="jornadas.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="edit_jornada" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>