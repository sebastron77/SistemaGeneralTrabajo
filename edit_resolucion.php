<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Editar Resolución';
require_once('includes/load.php');
$user = current_user();
$detalle = $user['id'];
$e_resolucion = find_by_id_resolucion((int)$_GET['id']);
$id_folio = last_id_folios();
page_require_level(5);
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['edit_resolucion'])) {

    $req_fields = array('num_expediente', 'visitaduria', 'fecha_recepcion', 'fecha_remite_proyecto', 'observaciones');
    validate_fields($req_fields);

    if (empty($errors)) {
        $id = (int)$e_resolucion['id'];
        $num_expediente   = remove_junk($db->escape($_POST['num_expediente']));
        $visitaduria   = remove_junk($db->escape($_POST['visitaduria']));
        $fecha_recepcion   = remove_junk($db->escape($_POST['fecha_recepcion']));
        $fecha_remite_proyecto   = remove_junk($db->escape($_POST['fecha_remite_proyecto']));
        $oficio_caratula   = remove_junk(upper_case($db->escape($_POST['oficio_caratula'])));
        $observaciones   = remove_junk(upper_case($db->escape($_POST['observaciones'])));
        $adjunto   = remove_junk($db->escape($_POST['adjunto']));

        $folio_editar = $e_detalle['folio'];
        $resultado = str_replace("/", "-", $folio_editar);
        $carpeta = 'uploads/resoluciones/' . $resultado;

        $name = $_FILES['adjunto']['name'];
        $size = $_FILES['adjunto']['size'];
        $type = $_FILES['adjunto']['type'];
        $temp = $_FILES['adjunto']['tmp_name'];

        if (is_dir($carpeta)) {
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        }

        if ($name != '') {
            $sql = "UPDATE orientacion_canalizacion SET correo_electronico='{$correo}', nombre_completo='{$nombre}', nivel_estudios='{$nestudios}', ocupacion='{$ocupacion}', edad='{$edad}', telefono='{$tel}', extension='{$ext}', sexo='{$sexo}', calle_numero='{$calle}', colonia='{$colonia}',codigo_postal='{$cpostal}', municipio_localidad='{$municipio}', entidad='{$entidad}', nacionalidad='{$nacionalidad}', medio_presentacion='{$medio}', observaciones='{$observaciones}', adjunto='{$name}' WHERE id='{$db->escape($id)}'";
        } 
        if ($name == '') {
            $sql = "UPDATE orientacion_canalizacion SET correo_electronico='{$correo}', nombre_completo='{$nombre}', nivel_estudios='{$nestudios}', ocupacion='{$ocupacion}', edad='{$edad}', telefono='{$tel}', extension='{$ext}', sexo='{$sexo}', calle_numero='{$calle}', colonia='{$colonia}',codigo_postal='{$cpostal}', municipio_localidad='{$municipio}', entidad='{$entidad}', nacionalidad='{$nacionalidad}', medio_presentacion='{$medio}', observaciones='{$observaciones}' WHERE id='{$db->escape($id)}'";
        }

        if ($db->query($query) && $db->query($query2)) {
            //sucess
            $session->msg('s', " La resolución ha sido agregada con éxito.");
            redirect('resoluciones.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar la resolución.');
            redirect('edit_resolucion.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_resolucion.php', false);
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
                <span>Agregar resolución</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="edit_resolucion.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="num_expediente">Número de Expediente</label>
                            <input type="text" class="form-control" name="num_expediente" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="visitaduria">Visitaduría</label>
                            <select class="form-control" name="visitaduria">
                                <option value="Escoge una opción">Escoge una opción</option>
                                <option value="Visitaduría Regional de Apatzingán">Visitaduría Regional de Apatzingán</option>
                                <option value="Visitaduría Regional de Lázaro Cárdenas">Visitaduría Regional de Lázaro Cárdenas</option>
                                <option value="Visitaduría Regional de Morelia">Visitaduría Regional de Morelia</option>
                                <option value="Visitaduría Regional de Uruapan">Visitaduría Regional de Uruapan</option>
                                <option value="Auxiliar de Paracho">Auxiliar de Paracho</option>
                                <option value="Visitaduría Regional de Zamora">Visitaduría Regional de Zamora</option>
                                <option value="Auxiliar de La Piedad">Auxiliar de La Piedad</option>
                                <option value="Visitaduría Regional de Zitácuaro">Visitaduría Regional de Zitácuaro</option>
                                <option value="Auxiliar de Huetamo">Auxiliar de Huetamo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_recepcion">Fecha de Recepción</label>
                            <input type="date" class="form-control" name="fecha_recepcion" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_remite_proyecto">Fecha Remite a Proyecto</label>
                            <input type="date" class="form-control" name="fecha_remite_proyecto" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="adjunto">Archivo adjunto (si es necesario)</label>
                            <input type="file" accept="application/pdf" class="form-control" name="adjunto" id="adjunto">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="observaciones">Observaciones</label><br>
                            <textarea name="observaciones" class="form-control" id="observaciones" cols="50" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="resoluciones.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="edit_resolucion" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>