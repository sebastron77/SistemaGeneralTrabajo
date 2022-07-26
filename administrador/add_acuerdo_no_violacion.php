<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar Acuerdo de No Violación';
require_once('includes/load.php');
$id_folio_acuerdo = last_id_folios_acuerdos();
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
    redirect('home.php');
}
if ($nivel == 5) {
    page_require_level_exacto(5);
}
if ($nivel == 6) {
    redirect('home.php');
}
if ($nivel == 7) {
    redirect('home.php');
}

$queja = find_by_id_queja((int)$_GET['id']);
// page_require_level(4);
?>
<?php header('Content-type: text/html; charset=utf-8');

if (isset($_POST['add_acuerdo_no_violacion'])) {

    $req_fields = array('autoridad_responsable', 'servidor_publico', 'fecha_acuerdo', 'observaciones');
    validate_fields($req_fields);

    if (empty($errors)) {
        $folio_queja   = remove_junk($db->escape($_POST['folio_queja']));
        $autoridad_responsable   = remove_junk($db->escape($_POST['autoridad_responsable']));
        $servidor_publico   = remove_junk($db->escape($_POST['servidor_publico']));
        $fecha_acuerdo   = remove_junk($db->escape($_POST['fecha_acuerdo']));
        $observaciones   = remove_junk($db->escape($_POST['observaciones']));
        $acuerdo_adjunto   = remove_junk(($db->escape($_POST['acuerdo_adjunto'])));

        if (count($id_folio_acuerdo) == 0) {
            $nuevo_id_folio_acuerdo = 1;
            $no_folio1 = sprintf('%04d', 1);
        } else {
            foreach ($id_folio_acuerdo as $nuevo) {
                $nuevo_id_folio_acuerdo = (int)$nuevo['id'] + 1;
                $no_folio1 = sprintf('%04d', (int)$nuevo['id'] + 1);
            }
        }
        //Se crea el número de folio
        $year = date("Y");
        // Se crea el folio de acuerdo
        $folio_acuerdo = 'CEDH/' . $no_folio1 . '/' . $year . '-ANV';

        $folio_queja_original = $folio_queja;
        $folio_carpeta = str_replace("/", "-", $folio_queja_original);
        $carpeta = 'uploads/quejas/' . $folio_carpeta . '/' . 'acuerdosNoViolacion';

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $name = $_FILES['acuerdo_adjunto']['name'];
        $size = $_FILES['acuerdo_adjunto']['size'];
        $type = $_FILES['acuerdo_adjunto']['type'];
        $temp = $_FILES['acuerdo_adjunto']['tmp_name'];

        $move =  move_uploaded_file($temp, $carpeta . "/" . $name);

        $name2 = $_FILES['acuerdo_adjunto_publico']['name'];
        $size2 = $_FILES['acuerdo_adjunto_publico']['size'];
        $type2 = $_FILES['acuerdo_adjunto_publico']['type'];
        $temp2 = $_FILES['acuerdo_adjunto_publico']['tmp_name'];

        $move2 =  move_uploaded_file($temp2, $carpeta . "/" . $name2);

        if ($move && $name != '') {
            $query = "INSERT INTO acuerdos (";
            $query .= "folio_acuerdo,folio_queja,autoridad_responsable,servidor_publico,fecha_acuerdo,observaciones,acuerdo_adjunto,acuerdo_adjunto_publico";
            $query .= ") VALUES (";
            $query .= " '{$folio_acuerdo}','{$folio_queja}','{$autoridad_responsable}','{$servidor_publico}','{$fecha_acuerdo}','{$observaciones}','{$name}','{$name2}'";
            $query .= ")";

            $query2 = "INSERT INTO folios_acuerdos (";
            $query2 .= "folio, contador";
            $query2 .= ") VALUES (";
            $query2 .= " '{$folio_acuerdo}','{$no_folio1}'";
            $query2 .= ")";
        } else {
            $query = "INSERT INTO acuerdos (";
            $query .= "folio_acuerdo,folio_queja,autoridad_responsable,servidor_publico,fecha_acuerdo,observaciones";
            $query .= ") VALUES (";
            $query .= " '{$folio_acuerdo}','{$folio_queja}','{$autoridad_responsable}','{$servidor_publico}','{$fecha_acuerdo}','{$observaciones}'";
            $query .= ")";

            $query2 = "INSERT INTO folios_acuerdos (";
            $query2 .= "folio, contador";
            $query2 .= ") VALUES (";
            $query2 .= " '{$folio_acuerdo}','{$no_folio1}'";
            $query2 .= ")";
        }
        if ($db->query($query) && $db->query($query2)) {
            //sucess
            $session->msg('s', " El Acuerdo de No Violación ha sido agregada con éxito.");
            redirect('acuerdos_no_violacion.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar el Acuerdo de No Violación.');
            redirect('add_acuerdo_no_violacion.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_acuerdo_no_violacion.php', false);
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
                <span>Agregar Acuerdo de No Violación</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_acuerdo_no_violacion.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="folio_queja">Folio de Queja</label>
                            <input type="text" class="form-control" name="folio_queja" value="<?php echo remove_junk($queja['folio_queja']); ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="autoridad_responsable">Autoridad Responsable</label>
                            <input type="text" class="form-control" name="autoridad_responsable" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="servidor_publico">Servidor público</label>
                            <input type="text" class="form-control" name="servidor_publico" placeholder="Nombre Completo" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha_acuerdo">Fecha de Acuerdo</label><br>
                            <input type="date" class="form-control" name="fecha_acuerdo">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="observaciones">Observaciones</label>
                            <textarea class="form-control" name="observaciones" id="observaciones" cols="10" rows="1"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <span>
                                <label for="acuerdo_adjunto">Adjuntar Acuerdo</label>
                                <input id="acuerdo_adjunto" type="file" accept="application/pdf" class="form-control" name="acuerdo_adjunto">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <span>
                                <label for="acuerdo_adjunto_publico">Adjuntar Acuerdo Público</label>
                                <input id="acuerdo_adjunto_publico" type="file" accept="application/pdf" class="form-control" name="acuerdo_adjunto_publico">
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group clearfix">
                    <a href="acuerdos_no_violacion.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="add_acuerdo_no_violacion" class="btn btn-primary" value="subir">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>