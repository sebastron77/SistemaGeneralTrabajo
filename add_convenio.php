<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar Convenio';
require_once('includes/load.php');
$id_folio = last_id_folios();
page_require_level(3);
?>
<?php header('Content-type: text/html; charset=utf-8');

if (isset($_POST['add_convenio'])) {

    $req_fields = array('fecha_convenio', 'institucion', 'ambito_institucion', 'tipo_institucion', 'descripcion_convenio', 'vigencia', 'direccion_institucion', 'telefono');
    validate_fields($req_fields);

    if (empty($errors)) {
        $fecha_convenio = remove_junk($db->escape($_POST['fecha_convenio']));
        $institucion   = remove_junk($db->escape($_POST['institucion']));
        $ambito_institucion   = remove_junk($db->escape($_POST['ambito_institucion']));
        $tipo_institucion   = remove_junk($db->escape($_POST['tipo_institucion']));
        $descripcion_convenio   = remove_junk($db->escape($_POST['descripcion_convenio']));
        $vigencia   = remove_junk($db->escape($_POST['vigencia']));
        $direccion_institucion   = remove_junk(($db->escape($_POST['direccion_institucion'])));
        $telefono   = remove_junk(($db->escape($_POST['telefono'])));

        if (count($id_folio) == 0) {
            $nuevo_id_folio = 1;
            $no_folio1 = sprintf('%04d', 1);
        } else {
            foreach ($id_folio as $nuevo) {
                $nuevo_id_folio = (int)$nuevo['id'] + 1;
                $no_folio1 = sprintf('%04d', (int)$nuevo['id'] + 1);
            }
        }
        // Se crea el número de folio
        $year = date("Y");
        // Se crea el folio de convenio
        $folio = 'CEDH/' . $no_folio1 . '/' . $year . '-CONV';

        $query = "INSERT INTO convenios (";
        $query .= "folio_solicitud,fecha_convenio,institucion,ambito_institucion,tipo_institucion,descripcion_convenio,vigencia,direccion_institucion,telefono";
        $query .= ") VALUES (";
        $query .= " '{$folio}','{$fecha_convenio}','{$institucion}','{$ambito_institucion}','{$tipo_institucion}','{$descripcion_convenio}','{$vigencia}','{$direccion_institucion}','{$telefono}'";
        $query .= ")";

        $query2 = "INSERT INTO folios (";
        $query2 .= "folio, contador";
        $query2 .= ") VALUES (";
        $query2 .= " '{$folio}','{$no_folio1}'";
        $query2 .= ")";

        if ($db->query($query) && $db->query($query2)) {
            //sucess
            $session->msg('s', " El convenio ha sido agregado con éxito.");
            redirect('convenios.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar el convenio.');
            redirect('add_convenio.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_convenio.php', false);
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
                <span>Agregar convenio</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_convenio.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_convenio">Fecha de convenio</label><br>
                            <input type="date" class="form-control" name="fecha_convenio">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="vigencia">Vigencia del convenio</label><br>
                            <input type="date" class="form-control" name="vigencia">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="institucion">Institución</label>
                            <input type="text" class="form-control" name="institucion" placeholder="Nombre de la institución" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control" name="telefono" maxlength="10" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="ambito_institucion">Ámbito institucional</label>
                            <select class="form-control" name="ambito_institucion">
                                <option value="">Elige una opción</option>
                                <option value="Estatal">Estatal</option>
                                <option value="Nacional">Nacional</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tipo_institucion">Tipo de institución</label>
                            <select class="form-control" name="tipo_institucion">
                                <option value="">Elige una opción</option>
                                <option value="Instituciones">Instituciones</option>
                                <option value="Dependencias Gubernamentales">Dependencias Gubernamentales</option>
                                <option value="ONG y Organismos Públicos de Derechos Humanos">ONG y Organismos Públicos de Derechos Humanos</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="direccion_institucion">Dirección de la institución</label>
                            <input type="text" class="form-control" name="direccion_institucion" required>
                        </div>
                    </div>                    
                </div>
                <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="descripcion_convenio">Descripción del convenio</label><br>
                                <textarea name="descripcion_convenio" class="form-control" id="descripcion_convenio" cols="50" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                <div class="form-group clearfix">
                    <a href="convenios.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="add_convenio" class="btn btn-primary" value="subir">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>