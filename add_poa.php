<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar POA';
require_once('includes/load.php');
$user = current_user();
$detalle = $user['id'];
$id_ori_canal = last_id_oricanal();
$id_folio = last_id_folios();
page_require_level(2);
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['add_poa'])) {

    $req_fields = array('anio_ejercicio', 'fecha_recepcion');
    validate_fields($req_fields);

    if (empty($errors)) {
        $anio_ejercicio   = remove_junk($db->escape($_POST['anio_ejercicio']));
        $oficio_recibido   = remove_junk($db->escape($_POST['oficio_recibido']));
        $poa   = remove_junk($db->escape($_POST['poa']));
        $fecha_recepcion   = remove_junk($db->escape($_POST['fecha_recepcion']));
        $oficio_entrega   = remove_junk(($db->escape($_POST['oficio_entrega'])));

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
        $folio = 'CEDH/' . $no_folio1 . '/' . $year . '-POA';

        $folio_carpeta = 'CEDH-' . $no_folio1 . '-' . $year . '-POA';
        $carpeta = 'uploads/poa/' . $folio_carpeta;

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $name = $_FILES['oficio_recibido']['name'];
        $size = $_FILES['oficio_recibido']['size'];
        $type = $_FILES['oficio_recibido']['type'];
        $temp = $_FILES['oficio_recibido']['tmp_name'];

        $move =  move_uploaded_file($temp, $carpeta . "/" . $name);

        $name2 = $_FILES['poa']['name'];
        $size2 = $_FILES['poa']['size'];
        $type2 = $_FILES['poa']['type'];
        $temp2 = $_FILES['poa']['tmp_name'];

        $move2 =  move_uploaded_file($temp2, $carpeta . "/" . $name2);

        $name3 = $_FILES['oficio_entrega']['name'];
        $size3 = $_FILES['oficio_entrega']['size'];
        $type3 = $_FILES['oficio_entrega']['type'];
        $temp3 = $_FILES['oficio_entrega']['tmp_name'];

        $move3 =  move_uploaded_file($temp3, $carpeta . "/" . $name3);

        if ($move && $name != '' && $name2 != '' && $name3 != '') {
            $query = "INSERT INTO poa (";
            $query .= "folio, anio_ejercicio, oficio_recibido, poa, fecha_recepcion, oficio_entrega";
            $query .= ") VALUES (";
            $query .= " '{$folio}','{$anio_ejercicio}','{$name}','{$name2}','{$fecha_recepcion}','{$name3}'";
            $query .= ")";

            $query2 = "INSERT INTO folios (";
            $query2 .= "folio, contador";
            $query2 .= ") VALUES (";
            $query2 .= " '{$folio}','{$no_folio1}'";
            $query2 .= ")";
        }

        if ($db->query($query) && $db->query($query2)) {
            //sucess
            $session->msg('s', " El POA ha sido agregado con éxito.");
            redirect('poa.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar el POA.');
            redirect('add_poa.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_poa.php', false);
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
                <span>Agregar POA</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_poa.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="form-group">
                            <label for="anio_ejercicio">Año o Ejercicio Fiscal</label>
                            <select class="form-control" name="anio_ejercicio">
                                <option value="Escoge una opción">Escoge una opción</option>
                                <option value="2012">2012</option>
                                <option value="2013">2013</option>
                                <option value="2014">2014</option>
                                <option value="2015">2015</option>
                                <option value="2016">2016</option>
                                <option value="2017">2017</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                            </select>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="oficio_recibido">Adjuntar oficio recibido</label>
                            <input type="file" accept="application/pdf" class="form-control" name="oficio_recibido" id="oficio_recibido">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="poa">POA</label>
                            <input type="file" accept="application/pdf" class="form-control" name="poa" id="poa">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha_recepcion">Fecha de Recepción</label>
                            <input type="date" class="form-control" name="fecha_recepcion" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="oficio_entrega">Adjuntar Oficio de Entrega</label>
                            <input type="file" accept="application/pdf" class="form-control" name="oficio_entrega" id="oficio_entrega">
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="poa.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="add_poa" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>