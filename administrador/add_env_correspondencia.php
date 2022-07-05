<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar Correspondencia Interna';
require_once('includes/load.php');
$user = current_user();
$detalle = $user['id'];
$id_ori_canal = last_id_oricanal();
$id_folio = last_id_folios_general();
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
$areas = find_all('area');
$area_user = area_usuario2($id_user);
$area = $area_user['nombre_area'];

// if ($nivel <= 2) {
//     page_require_level(2);
// }
// if ($nivel == 3) {
//     redirect('home.php');
// }
// if ($nivel == 4) {
//     redirect('home.php');
// }
// if ($nivel == 5) {
//     redirect('home.php');    
// }
// if ($nivel == 6) {
//     redirect('home.php');
// }
// if ($nivel == 7) {
//     page_require_level(7);
// }
// if ($nivel == 8) {
//     page_require_level(8);
// }
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['add_env_correspondencia'])) {

    $req_fields = array('fecha_emision', 'asunto', 'medio_envio');
    validate_fields($req_fields);

    if (empty($errors)) {
        $fecha_emision   = remove_junk($db->escape($_POST['fecha_emision']));
        $asunto   = remove_junk(($db->escape($_POST['asunto'])));
        $medio_envio   = remove_junk(($db->escape($_POST['medio_envio'])));
        $se_turna_a_area   = remove_junk(($db->escape($_POST['se_turna_a_area'])));
        $fecha_en_que_se_turna   = remove_junk(($db->escape($_POST['fecha_en_que_se_turna'])));
        $fecha_espera_respuesta   = remove_junk(($db->escape($_POST['fecha_espera_respuesta'])));
        $tipo_tramite   = remove_junk(($db->escape($_POST['tipo_tramite'])));
        $observaciones   = remove_junk(($db->escape($_POST['observaciones'])));

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
        $folio = 'CEDH/' . $no_folio1 . '/' . $year . '-ECOR';

        $query = "INSERT INTO envio_correspondencia (";
        $query .= "folio,fecha_emision,asunto,medio_envio,se_turna_a_area,fecha_en_que_se_turna,fecha_espera_respuesta,tipo_tramite,observaciones,area_creacion";
        $query .= ") VALUES (";
        $query .= " '{$folio}','{$fecha_emision}','{$asunto}','{$medio_envio}','{$se_turna_a_area}','{$fecha_en_que_se_turna}','{$fecha_espera_respuesta}','{$tipo_tramite}','{$observaciones}','{$area}'";
        $query .= ")";

        $query2 = "INSERT INTO folios_general (";
        $query2 .= "folio, contador";
        $query2 .= ") VALUES (";
        $query2 .= " '{$folio}','{$no_folio1}'";
        $query2 .= ")";

        if ($db->query($query) && $db->query($query2)) {
            //sucess
            $session->msg('s', " La correspondencia interna ha sido agregada con éxito.");
            redirect('env_correspondencia.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar la correspondencia interna.');
            redirect('add_env_correspondencia.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_env_correspondencia.php', false);
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
                <span>Agregar correspondencia interna</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_env_correspondencia.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_emision">Fecha de Emisión de Oficio</label>
                            <input type="date" class="form-control" name="fecha_emision" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="asunto">Asunto</label>
                            <input type="text" class="form-control" name="asunto" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="medio_envio">Medio de Envío</label>
                            <select class="form-control" name="medio_envio">
                                <option value="Escoge una opción">Escoge una opción</option>
                                <option value="Correo">Correo</option>
                                <option value="Mediante Oficio">Mediante Oficio</option>
                                <option value="Paquetería">Paquetería</option>
                                <option value="WhatsApp">WhatsApp</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="se_turna_a_area">Área a la que se turna</label>
                            <select class="form-control" name="se_turna_a_area">
                                <?php foreach ($areas as $area) : ?>
                                    <option value="<?php echo $area['nombre_area']; ?>"><?php echo ucwords($area['nombre_area']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_en_que_se_turna">Fecha en que se turna oficio</label>
                            <input type="date" class="form-control" name="fecha_en_que_se_turna" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_espera_respuesta">Fecha en que se espera respuesta</label>
                            <input type="date" class="form-control" name="fecha_espera_respuesta" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tipo_tramite">Tipo de Trámite</label><br>
                            <select class="form-control" name="tipo_tramite">
                                <option value="Escoge una opción">Escoge una opción</option>
                                <option value="Respuesta">Respuesta</option>
                                <option value="Conocimiento">Conocimiento</option>
                                <option value="Circular">Circular</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="observaciones">Observaciones</label>
                            <textarea class="form-control" name="observaciones" id="observaciones" cols="10" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="env_correspondencia.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="add_env_correspondencia" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>