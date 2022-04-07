<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar Resolución';
require_once('includes/load.php');
$user = current_user();
$detalle = $user['id'];
$id_ori_canal = last_id_oricanal();
$id_folio = last_id_folios();
page_require_level(2);
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['add_resolucion'])) {

    $req_fields = array('num_expediente', 'visitaduria', 'fecha_recepcion', 'fecha_remite_proyecto');
    validate_fields($req_fields);

    if (empty($errors)) {
        $num_expediente   = remove_junk($db->escape($_POST['num_expediente']));
        $visitaduria   = remove_junk($db->escape($_POST['visitaduria']));
        $fecha_recepcion   = remove_junk($db->escape($_POST['fecha_recepcion']));
        $fecha_remite_proyecto   = remove_junk($db->escape($_POST['fecha_remite_proyecto']));
        $oficio_caratula   = remove_junk(($db->escape($_POST['oficio_caratula'])));
        $observaciones   = remove_junk(($db->escape($_POST['observaciones'])));
        $adjunto   = remove_junk($db->escape($_POST['adjunto']));

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
        $folio = 'CEDH/' . $no_folio1 . '/' . $year . '-RES';

        $folio_carpeta = 'CEDH-' . $no_folio1 . '-' . $year . '-RES';
        $carpeta = 'uploads/resoluciones/' . $folio_carpeta;

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $name = $_FILES['adjunto']['name'];
        $size = $_FILES['adjunto']['size'];
        $type = $_FILES['adjunto']['type'];
        $temp = $_FILES['adjunto']['tmp_name'];

        $move =  move_uploaded_file($temp, $carpeta . "/" . $name);

        if ($move && $name != '') {
            $query = "INSERT INTO resoluciones (";
            $query .= "folio,num_expediente,visitaduria,fecha_recepcion,fecha_remite_proyecto,oficio_caratula,observaciones";
            $query .= ") VALUES (";
            $query .= " '{$folio}','{$num_expediente}','{$visitaduria}','{$fecha_recepcion}','{$fecha_remite_proyecto}','{$name}','{$observaciones}'";
            $query .= ")";

            $query2 = "INSERT INTO folios (";
            $query2 .= "folio, contador";
            $query2 .= ") VALUES (";
            $query2 .= " '{$folio}','{$no_folio1}'";
            $query2 .= ")";
        } else {
            $query = "INSERT INTO resoluciones (";
            $query .= "folio,num_expediente,visitaduria,fecha_recepcion,fecha_remite_proyecto,oficio_caratula,observaciones";
            $query .= ") VALUES (";
            $query .= " '{$folio}','{$num_expediente}','{$visitaduria}','{$fecha_recepcion}','{$fecha_remite_proyecto}','{$name}','{$observaciones}'";
            $query .= ")";

            $query2 = "INSERT INTO folios (";
            $query2 .= "folio, contador";
            $query2 .= ") VALUES (";
            $query2 .= " '{$folio}','{$no_folio1}'";
            $query2 .= ")";
        }

        if ($db->query($query) && $db->query($query2)) {
            //sucess
            $session->msg('s', " La resolución ha sido agregada con éxito.");
            redirect('resoluciones.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar la resolución.');
            redirect('add_resolucion.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_resolucion.php', false);
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
            <form method="post" action="add_resolucion.php" enctype="multipart/form-data">
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
                    <button type="submit" name="add_resolucion" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>