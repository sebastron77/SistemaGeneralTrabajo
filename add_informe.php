<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar Informe';
require_once('includes/load.php');
$user = current_user();
$detalle = $user['id'];
$id_ori_canal = last_id_oricanal();
$id_folio = last_id_folios();
page_require_level(2);
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['add_informe'])) {

    $req_fields = array('num_informe', 'fecha_informe', 'fecha_entrega', 'liga_url');
    validate_fields($req_fields);

    if (empty($errors)) {
        $num_informe   = remove_junk($db->escape($_POST['num_informe']));
        $fecha_informe   = remove_junk($db->escape($_POST['fecha_informe']));
        $fecha_entrega   = remove_junk($db->escape($_POST['fecha_entrega']));
        $oficio_entrega_congreso   = remove_junk($db->escape($_POST['oficio_entrega_congreso']));
        $caratula_informe   = remove_junk(($db->escape($_POST['caratula_informe'])));
        $liga_url   = remove_junk(($db->escape($_POST['liga_url'])));

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
        $folio = 'CEDH/' . $no_folio1 . '/' . $year . '-INF';

        $folio_carpeta = 'CEDH-' . $no_folio1 . '-' . $year . '-INF';
        $carpeta = 'uploads/informes/' . $folio_carpeta;

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $name = $_FILES['oficio_entrega_congreso']['name'];
        $size = $_FILES['oficio_entrega_congreso']['size'];
        $type = $_FILES['oficio_entrega_congreso']['type'];
        $temp = $_FILES['oficio_entrega_congreso']['tmp_name'];

        $move =  move_uploaded_file($temp, $carpeta . "/" . $name);

        $name2 = $_FILES['caratula_informe']['name'];
        $size2 = $_FILES['caratula_informe']['size'];
        $type2 = $_FILES['caratula_informe']['type'];
        $temp2 = $_FILES['caratula_informe']['tmp_name'];

        $move2 =  move_uploaded_file($temp2, $carpeta . "/" . $name2);

        if ($move && $name != '' && $name2 != '') {
            $query = "INSERT INTO informes (";
            $query .= "folio, num_informe, fecha_informe, fecha_entrega, oficio_entrega_congreso, caratula_informe, liga_url";
            $query .= ") VALUES (";
            $query .= " '{$folio}','{$num_informe}','{$fecha_informe}','{$fecha_entrega}','{$name}','{$name2}','{$liga_url}'";
            $query .= ")";

            $query2 = "INSERT INTO folios (";
            $query2 .= "folio, contador";
            $query2 .= ") VALUES (";
            $query2 .= " '{$folio}','{$no_folio1}'";
            $query2 .= ")";
        }

        if ($db->query($query) && $db->query($query2)) {
            //sucess
            $session->msg('s', " El informe ha sido agregada con éxito.");
            redirect('informes.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar el informe.');
            redirect('add_informe.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_informe.php', false);
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
                <span>Agregar Informe</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_informe.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="num_informe">Número de Informe</label>
                            <input type="text" class="form-control" name="num_informe" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_informe">Fecha del informe</label>
                            <input type="date" class="form-control" name="fecha_informe" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_entrega">Fecha del entrega</label>
                            <input type="date" class="form-control" name="fecha_entrega" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="oficio_entrega_congreso">Adjuntar oficio de entrega Congreso</label>
                            <input type="file" accept="application/pdf" class="form-control" name="oficio_entrega_congreso" id="oficio_entrega_congreso">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="caratula_informe">Caratula del Informe</label>
                            <input type="file" accept="application/pdf" class="form-control" name="caratula_informe" id="caratula_informe">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="liga_url">URL</label>
                            <input type="text" accept="application/pdf" class="form-control" name="liga_url" id="liga_url">
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="informes.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="add_informe" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>