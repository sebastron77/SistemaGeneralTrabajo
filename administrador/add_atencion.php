<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar Atención';
require_once('includes/load.php');
$id_folio = last_id_folios_general();
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];

$area_user = area_usuario2($id_user);
$area = $area_user['nombre_area'];

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
    redirect('home.php');
}
if ($nivel == 6) {
    redirect('home.php');
}
if ($nivel == 7) {
    page_require_level(7);
}
if ($nivel == 8) {
    page_require_level(8);
}
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['add_atencion'])) {

    $req_fields = array('asunto', 'peticion_audiencia', 'fecha_audiencia');
    validate_fields($req_fields);

    if (empty($errors)) {
        $asunto   = remove_junk($db->escape($_POST['asunto']));
        $peticion_audiencia   = remove_junk($db->escape($_POST['peticion_audiencia']));
        $fecha_audiencia   = remove_junk($db->escape($_POST['fecha_audiencia']));
        $personas_atendidas   = remove_junk($db->escape($_POST['personas_atendidas']));
        $solicitud_peticion   = remove_junk(($db->escape($_POST['solicitud_peticion'])));
        // $fecha_creacion   = remove_junk(($db->escape($_POST['fecha_creacion'])));
        date_default_timezone_set('America/Mexico_City');
        $fecha_creacion = date('Y-m-d');

        //Suma el valor del id anterior + 1, para generar ese id para el nuevo resguardo
        //La variable $no_folio sirve para el numero de folio

        if (count($id_folio) == 0) {
            $nuevo_id_folio = 1;
            $no_folio1 = sprintf('%04d', 1);
        } else {
            foreach ($id_folio as $nuevo) {
                $nuevo_id_folio = (int)$nuevo['id'] + 1;
                $no_folio1 = sprintf('%04d', (int)$nuevo['id'] + 1);
            }
        }

        //Se crea el número de folio
        $year = date("Y");
        // Se crea el folio orientacion
        $folio = 'CEDH/' . $no_folio1 . '/' . $year . '-ATE';

        $folio_carpeta = 'CEDH-' . $no_folio1 . '-' . $year . '-ATE';
        $carpeta = 'uploads/atencion/' . $folio_carpeta;

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $name = $_FILES['solicitud_peticion']['name'];
        $size = $_FILES['solicitud_peticion']['size'];
        $type = $_FILES['solicitud_peticion']['type'];
        $temp = $_FILES['solicitud_peticion']['tmp_name'];

        $move =  move_uploaded_file($temp, $carpeta . "/" . $name);

        if ($move && $name != '') {
            $query = "INSERT INTO atencion (";
            $query .= "folio, asunto, peticion_audiencia, fecha_audiencia, personas_atendidas, solicitud_peticion, fecha_creacion, creador";
            $query .= ") VALUES (";
            $query .= " '{$folio}','{$asunto}','{$peticion_audiencia}','{$fecha_audiencia}','{$personas_atendidas}','{$name}','{$fecha_creacion}','{$id_user}'";
            $query .= ")";

            $query2 = "INSERT INTO folios_general (";
            $query2 .= "folio, contador";
            $query2 .= ") VALUES (";
            $query2 .= " '{$folio}','{$no_folio1}'";
            $query2 .= ")";
        } else {
            $query = "INSERT INTO atencion (";
            $query .= "folio, asunto, peticion_audiencia, fecha_audiencia, personas_atendidas, fecha_creacion, creador";
            $query .= ") VALUES (";
            $query .= " '{$folio}','{$asunto}','{$peticion_audiencia}','{$fecha_audiencia}','{$personas_atendidas}','{$fecha_creacion}','{$id_user}'";
            $query .= ")";

            $query2 = "INSERT INTO folios_general (";
            $query2 .= "folio, contador";
            $query2 .= ") VALUES (";
            $query2 .= " '{$folio}','{$no_folio1}'";
            $query2 .= ")";
        }
        if ($db->query($query) && $db->query($query2)) {
            //sucess
            $session->msg('s', " La atencion ha sido agregada con éxito.");
            redirect('atencion.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar la atencion.');
            redirect('add_atencion.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_atencion.php', false);
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
                <span>Agregar atención</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_atencion.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="asunto">Asunto</label>
                            <input type="text" class="form-control" name="asunto" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="peticion_audiencia">Petición de audiencia</label>
                            <!-- <input type="text" class="form-control" name="peticion_audiencia" required> -->
                            <select class="form-control" name="peticion_audiencia">
                                <option value="Escoge una opción">Escoge una opción</option>
                                <option value="Realizado">Realizado</option>
                                <option value="Pendiente">Pendiente</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_audiencia">Fecha audiencia</label><br>
                            <input type="date" class="form-control" name="fecha_audiencia">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <span>
                                <label for="solicitud_peticion">Solicitud de petición</label>
                                <input type="file" accept="application/pdf" class="form-control" name="solicitud_peticion">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="personas_atendidas">Nombre(s) de la(s) persona(s) atendida(s) (Separadas por comas)</label>
                            <textarea name="personas_atendidas" class="form-control" id="personas_atendidas" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="atencion.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="add_atencion" class="btn btn-primary" value="subir">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>