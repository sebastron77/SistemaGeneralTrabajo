<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar Jornada';
require_once('includes/load.php');
$user = current_user();
$detalle = $user['id'];
$id_folio = last_id_folios_general();
page_require_level(4);
$id_user = $user['id'];
$busca_area = area_usuario($id_user);
$otro = $busca_area['id'];
$areas = find_all_area_orden('area');
page_require_area(4);
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['add_jornada'])) {
    // Contamos la cantidad de imagenes
    $countfiles = count($_FILES['files']['name']);
    $req_fields = array('nombre_actividad', 'objetivo_actividad', 'area_responsable', 'mujeres', 'hombres', 'lgbtiq', 'fecha_actividad', 'alcance', 'colaboracion_institucional');
    validate_fields($req_fields);

    if (empty($errors)) {
        $nombre_actividad   = remove_junk($db->escape($_POST['nombre_actividad']));
        $objetivo_actividad   = remove_junk($db->escape($_POST['objetivo_actividad']));
        $mujeres   = remove_junk($db->escape($_POST['mujeres']));
        $area_responsable   = remove_junk($db->escape($_POST['area_responsable']));
        $hombres   = remove_junk(($db->escape($_POST['hombres'])));
        $lgbtiq   = remove_junk(($db->escape($_POST['lgbtiq'])));
        $fecha_actividad   = remove_junk(($db->escape($_POST['fecha_actividad'])));
        $alcance   = remove_junk(($db->escape($_POST['alcance'])));
        $colaboracion_institucional   = remove_junk($db->escape($_POST['colaboracion_institucional']));
        // $evidencia_fotografica   = remove_junk($db->escape($_POST['evidencia_fotografica']));
        date_default_timezone_set('America/Mexico_City');
        $creacion = date('Y-m-d');

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
        $folio = 'CEDH/' . $no_folio1 . '/' . $year . '-JOR';

        $folio_carpeta = 'CEDH-' . $no_folio1 . '-' . $year . '-JOR';
        $carpeta = 'uploads/jornadas/' . $folio_carpeta;

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        // $name = $_FILES['adjunto']['name'];
        // $size = $_FILES['adjunto']['size'];
        // $type = $_FILES['adjunto']['type'];
        // $temp = $_FILES['adjunto']['tmp_name'];
        // $move =  move_uploaded_file($temp, $carpeta . "/" . $name);

        // Generamos el bucle de todos los archivos
        for ($i = 0; $i < $countfiles; $i++) {

            // Extraemos en variable el nombre de archivo
            $filename = $_FILES['files']['name'][$i];

            // Designamos la carpeta de subida
            $target_file = 'uploads/jornadas/' . $folio_carpeta . '/' . $filename;

            // Obtenemos la extension del archivo
            $file_extension = pathinfo($target_file, PATHINFO_EXTENSION);

            $file_extension = strtolower($file_extension);

            // Validamos la extensión de la imagen
            $valid_extension = array("png", "jpeg", "jpg");

            if (in_array($file_extension, $valid_extension)) {

                // Subimos la imagen al servidor
                move_uploaded_file($_FILES['files']['tmp_name'][$i], $target_file);
            }
        }

        $query = "INSERT INTO jornadas (";
        $query .= "folio,nombre_actividad,objetivo_actividad,area_responsable,mujeres,hombres,lgbtiq,fecha_actividad,alcance,colaboracion_institucional,creacion";
        $query .= ") VALUES (";
        $query .= " '{$folio}','{$nombre_actividad}','{$objetivo_actividad}','{$area_responsable}','{$mujeres}','{$hombres}','{$lgbtiq}','{$fecha_actividad}','{$alcance}','{$colaboracion_institucional}','{$creacion}'";
        $query .= ")";

        $query2 = "INSERT INTO folios_general (";
        $query2 .= "folio, contador";
        $query2 .= ") VALUES (";
        $query2 .= " '{$folio}','{$no_folio1}'";
        $query2 .= ")";

        if ($db->query($query) && $db->query($query2)) {
            //sucess
            $session->msg('s', " La jornada ha sido agregada con éxito.");
            redirect('jornadas.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar la jornada.');
            redirect('add_jornada.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_jornada.php', false);
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
                <span>Agregar Jornada</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_jornada.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nombre_actividad">Nombre de la Actividad</label>
                            <input type="text" class="form-control" name="nombre_actividad" required>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="objetivo_actividad">Objetivo de la actividad</label>
                            <textarea type="text" class="form-control" name="objetivo_actividad" cols="30" rows="1" required></textarea>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="area_responsable">Área Responsable</label>
                            <select class="form-control" name="area_responsable">
                                <option value="">Escoge una opción</option>
                                <option value="Área Médica">Área Médica</option>
                                <option value="Área Psicológica">Área Psicológica</option>
                                <option value="Ambas Áreas">Ambas Áreas</option>
                            </select>
                        </div>
                    </div>
                </div>
                Personas Atendidas:
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>Mujeres</label>
                            <input type="number" class="form-control" min="1" max="120" name="mujeres" required>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>Hombres</label>
                            <input type="number" class="form-control" min="1" max="120" name="hombres" required>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>LGBTIQ+</label>
                            <input type="number" class="form-control" min="1" max="120" name="lgbtiq" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Fecha de Actividad</label>
                            <input type="date" class="form-control" name="fecha_actividad" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="alcance">Alcance</label>
                            <select class="form-control" name="alcance">
                                <option value="">Escoge una opción</option>
                                <option value="Servidores Públicos">Servidores Públicos</option>
                                <option value="Sector Privado">Sector Privado</option>
                                <option value="Grupos Vulnerables">Grupos Vulnerables</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="colaboracion_institucional">Colaboración Institucional</label>
                            <textarea type="text" class="form-control" name="colaboracion_institucional" cols="30" rows="1" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="evidencia_fotografica">Evidencia Fotográfica</label>
                        <input type='file' class="custom-file-input form-control" id="inputGroupFile01" name='files[]' multiple />
                    </div>
                </div><br>
                <div class="form-group clearfix">
                    <a href="jornadas.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="add_jornada" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>