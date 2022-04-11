<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar Correspondencia';
require_once('includes/load.php');
$user = current_user();
$detalle = $user['id'];
$id_ori_canal = last_id_oricanal();
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
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['add_correspondencia'])) {

    $req_fields = array('fecha_recibido', 'nombre_remitente', 'asunto', 'medio_recepcion');
    validate_fields($req_fields);

    if (empty($errors)) {
        $fecha_recibido   = remove_junk($db->escape($_POST['fecha_recibido']));
        $nombre_remitente   = remove_junk($db->escape($_POST['nombre_remitente']));
        $nombre_institucion   = remove_junk($db->escape($_POST['nombre_institucion']));
        $cargo_funcionario   = remove_junk($db->escape($_POST['cargo_funcionario']));
        $asunto   = remove_junk(($db->escape($_POST['asunto'])));
        $medio_recepcion   = remove_junk(($db->escape($_POST['medio_recepcion'])));
        $seguimiento   = remove_junk(($db->escape($_POST['seguimiento'])));
        $medio_entrega   = remove_junk(($db->escape($_POST['medio_entrega'])));

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
        $folio = 'CEDH/' . $no_folio1 . '/' . $year . '-COR';

        $query = "INSERT INTO correspondencia (";
        $query .= "folio, fecha_recibido, nombre_remitente, nombre_institucion, cargo_funcionario, asunto, medio_recepcion, seguimiento, medio_entrega";
        $query .= ") VALUES (";
        $query .= " '{$folio}','{$fecha_recibido}','{$nombre_remitente}','{$nombre_institucion}','{$cargo_funcionario}','{$asunto}','{$medio_recepcion}','{$seguimiento}','{$medio_entrega}'";
        $query .= ")";

        $query2 = "INSERT INTO folios (";
        $query2 .= "folio, contador";
        $query2 .= ") VALUES (";
        $query2 .= " '{$folio}','{$no_folio1}'";
        $query2 .= ")";

        if ($db->query($query) && $db->query($query2)) {
            //sucess
            $session->msg('s', " La correspondencia ha sido agregada con éxito.");
            redirect('correspondencia.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar la correspondencia.');
            redirect('add_correspondencia.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_correspondencia.php', false);
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
                <span>Agregar correspondencia</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_correspondencia.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_recibido">Fecha de Recepción</label>
                            <input type="date" class="form-control" name="fecha_recibido" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nombre_remitente">Nombre de Remitente</label>
                            <input type="text" class="form-control" name="nombre_remitente" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nombre_institucion">Nombre de Institución</label>
                            <input type="text" class="form-control" name="nombre_institucion">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cargo_funcionario">Cargo de Funcionario</label>
                            <input type="text" class="form-control" name="cargo_funcionario">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="asunto">Asunto</label>
                            <input type="text" class="form-control" name="asunto" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="medio_recepcion">Medio de Recepción</label>
                            <select class="form-control" name="medio_recepcion">
                                <option value="Escoge una opción">Escoge una opción</option>
                                <option value="Correo">Correo</option>
                                <option value="Mediante Oficio">Mediante Oficio</option>
                                <option value="Oficialia de partes">Oficialia de partes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="seguimiento">Seguimiento</label><br>
                            <input type="text" class="form-control" name="seguimiento">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="medio_entrega">Medio de Entrega</label><br>
                            <input type="text" class="form-control" name="medio_entrega">
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="correspondencia.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="add_correspondencia" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>