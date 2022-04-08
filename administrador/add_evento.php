<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar Evento';
require_once('includes/load.php');
$id_folio = last_id_folios();
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
    // page_require_level_exacto(4);
    redirect('home.php');
}
if ($nivel == 5) {
    redirect('home.php');
}
if ($nivel == 6) {
    redirect('home.php');    
}
if ($nivel == 7) {
    page_require_level_exacto(7);
}

// page_require_level(4);
?>
<?php header('Content-type: text/html; charset=utf-8');

if (isset($_POST['add_evento'])) {

    $req_fields = array('nombre_evento', 'tipo_evento', 'quien_solicita', 'fecha', 'hora', 'lugar', 'no_asistentes', 'modalidad', 'depto_org', 'quien_asiste');
    validate_fields($req_fields);

    if (empty($errors)) {
        $nombre   = remove_junk($db->escape($_POST['nombre_evento']));
        $solicita   = remove_junk($db->escape($_POST['quien_solicita']));
        $tipo_evento   = remove_junk($db->escape($_POST['tipo_evento']));
        $fecha   = remove_junk($db->escape($_POST['fecha']));
        $hora   = remove_junk($db->escape($_POST['hora']));
        $lugar   = remove_junk(($db->escape($_POST['lugar'])));
        $asistentes   = remove_junk(($db->escape($_POST['no_asistentes'])));
        $modalidad   = remove_junk($db->escape($_POST['modalidad']));
        $depto   = remove_junk($db->escape($_POST['depto_org']));
        $quien_asiste   = remove_junk($db->escape($_POST['quien_asiste']));
        $invitacion   = remove_junk($db->escape($_POST['invitacion']));
        $constancia   = remove_junk($db->escape($_POST['constancia']));

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
        // Se crea el folio de capacitacion
        $folio = 'CEDH/' . $no_folio1 . '/' . $year . '-EVEN';

        $folio_carpeta = 'CEDH-' . $no_folio1 . '-' . $year . '-EVEN';
        $carpeta = 'uploads/eventos/invitaciones/' . $folio_carpeta;

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $name = $_FILES['invitacion']['name'];
        $size = $_FILES['invitacion']['size'];
        $type = $_FILES['invitacion']['type'];
        $temp = $_FILES['invitacion']['tmp_name'];

        $move =  move_uploaded_file($temp, $carpeta . "/" . $name);

        if ($move && $name != '') {
            $query = "INSERT INTO eventos (";
            $query .= "nombre_evento,tipo_evento,quien_solicita,fecha,hora,lugar,no_asistentes,modalidad,depto_org,quien_asiste,invitacion,constancia,folio";
            $query .= ") VALUES (";
            $query .= " '{$nombre}','{$tipo_evento}','{$solicita}','{$fecha}','{$hora}','{$lugar}','{$asistentes}','{$modalidad}','{$depto}','{$quien_asiste}','{$name}','{$constancia}','{$folio}'";
            $query .= ")";

            $query2 = "INSERT INTO folios (";
            $query2 .= "folio, contador";
            $query2 .= ") VALUES (";
            $query2 .= " '{$folio}','{$no_folio1}'";
            $query2 .= ")";
        } else {
            $query = "INSERT INTO eventos (";
            $query .= "nombre_evento,tipo_evento,quien_solicita,fecha,hora,lugar,no_asistentes,modalidad,depto_org,quien_asiste,invitacion,constancia,folio";
            $query .= ") VALUES (";
            $query .= " '{$nombre}','{$tipo_evento}','{$solicita}','{$fecha}','{$hora}','{$lugar}','{$asistentes}','{$modalidad}','{$depto}','{$quien_asiste}','{$name}','{$constancia}','{$folio}'";
            $query .= ")";

            $query2 = "INSERT INTO folios (";
            $query2 .= "folio, contador";
            $query2 .= ") VALUES (";
            $query2 .= " '{$folio}','{$no_folio1}'";
            $query2 .= ")";
        }
        if ($db->query($query) && $db->query($query2)) {
            //sucess
            $session->msg('s', " El evento ha sido agregado con éxito.");
            redirect('eventos.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar el evento.');
            redirect('add_evento.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_evento.php', false);
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
                <span>Agregar evento</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_evento.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nombre_evento">Nombre del evento</label>
                            <input type="text" class="form-control" name="nombre_evento" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="tipo_evento">Tipo de evento</label>
                            <select class="form-control" name="tipo_evento">
                                <option value="Conferencia">Conferencia</option>
                                <option value="Rueda de Prensa">Rueda de Prensa</option>
                                <option value="Representación">Representación</option>
                                <option value="Mesa de Diálogo">Mesa de Diálogo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="quien_solicita">¿Quién lo solicita?</label>
                            <input type="text" class="form-control" name="quien_solicita" placeholder="Nombre Completo" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha">Fecha</label><br>
                            <input type="date" class="form-control" name="fecha">
                        </div>
                    </div>                    
                </div>

                <div class="row">
                <div class="col-md-2">
                        <div class="form-group">
                            <label for="hora">Hora</label><br>
                            <input type="time" class="form-control" name="hora">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="lugar">Lugar</label>
                            <input type="text" class="form-control" name="lugar" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="no_asistentes">No. de asistentes</label>
                            <input type="number" min="1" class="form-control" max="1000" name="no_asistentes" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="modalidad">Modalidad</label>
                            <select class="form-control" name="modalidad">
                                <option value="Presencial">Presencial</option>
                                <option value="En línea">En línea</option>
                                <option value="Híbrido">Híbrido</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="depto_org">Departamento/Organización</label>
                            <input type="text" class="form-control" name="depto_org" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="quien_asiste">¿Quién asiste? (separado por comas)</label>
                            <textarea name="quien_asiste" class="form-control" id="quien_asiste" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <span>
                                <label for="invitacion">Invitación</label>
                                <input id="invitacion" type="file" accept="application/pdf" class="form-control" name="invitacion">
                            </span>
                        </div>
                    </div>
                    <!-- <div class="col-md-4">
                        <div class="form-group">
                            <label for="constancia">Constancia</label>
                            <input type="file" accept="application/pdf" class="form-control" name="constancia">
                        </div>
                    </div> -->
                </div>

                <div class="form-group clearfix">
                    <a href="eventos.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="add_evento" class="btn btn-primary" value="subir">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>