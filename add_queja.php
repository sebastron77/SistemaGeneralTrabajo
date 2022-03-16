<?php
// $queja = find_by_id('ost_ticket',(int)$_GET['id']);
require_once('includes/load2.php');
$queja = find_by_id_quejas((int)$_GET['id']);

if (!$queja) {
    $session->msg("d", "Error al agregar.");
    redirect('quejas.php');
}
?>

<?php header('Content-type: text/html; charset=utf-8');
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Agregar Queja';
require_once('includes/load.php');
page_require_level(5);
$user = current_user();
$nivel = $user['user_level'];
$id_folio = last_id_folios();
$id_user = $user['id'];
$busca_area = area_usuario($id_user);
$otro = $busca_area['id'];
page_require_area(5);
?>

<?php header('Content-type: text/html; charset=utf-8');
// ini_set('display_errors', 1);
if (isset($_POST['add_queja'])) {

    $req_fields = array('ultima_actualizacion', 'autoridad_responsable', 'creada_por', 'estatus_queja', 'asignada_a');
    validate_fields($req_fields);

    if (empty($errors)) {
        // $folio_queja   = remove_junk($db->escape($_POST['folio_queja']));
        $ultima_actualizacion   = remove_junk($db->escape($_POST['ultima_actualizacion']));
        $autoridad_responsable   = remove_junk($db->escape($_POST['autoridad_responsable']));
        $creada_por   = remove_junk($db->escape($_POST['creada_por']));
        $estatus_queja   = remove_junk($db->escape($_POST['estatus_queja']));
        $asignada_a   = remove_junk(($db->escape($_POST['asignada_a'])));

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
        $folio = 'CEDH/' . $no_folio1 . '/' . $year . '-Q';

        // $name = $_FILES['adjunto']['name'];
        // $size = $_FILES['adjunto']['size'];
        // $type = $_FILES['adjunto']['type'];
        // $temp = $_FILES['adjunto']['tmp_name'];

        // if (is_dir($carpeta)) {
        //     $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        // }

        // if ($name != '') {
        $query = "INSERT INTO quejas (";
        $query .= "folio_queja,ultima_actualizacion,autoridad_responsable,creada_por,estatus_queja,asignada_a";
        $query .= ") VALUES (";
        $query .= " '{$folio}','{$ultima_actualizacion}','{$autoridad_responsable}','{$creada_por}','{$estatus_queja}','{$asignada_a}'";
        $query .= ")";

        $query2 = "INSERT INTO folios (";
        $query2 .= "folio, contador";
        $query2 .= ") VALUES (";
        $query2 .= " '{$folio}','{$no_folio1}'";
        $query2 .= ")";
        // $result = $db->query($query);

        if ($db->query($query) && $db->query($query2)) {
            $session->msg('s', "Queja guardada en la base de datos.");
            redirect('quejas.php', false);
        } else {
            $session->msg('d', 'Lo siento no se guardó la queja.');
            redirect('quejas.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('quejas.php', false);
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
                <span>Agregar queja a Libro Electrónico</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_queja.php">
                <div class="row">
                    <!-- <div class="col-md-4">
                        <div class="form-group">
                            <label for="folio_queja">Folio Queja</label>
                            <input type="text" class="form-control" name="folio_queja" value="<?php echo remove_junk($queja['Folio_Queja']); ?>">
                        </div>
                    </div> -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ultima_actualizacion">Última Actualización</label>
                            <input type="text" class="form-control" name="ultima_actualizacion" value="<?php echo remove_junk($queja['Ultima_Actualizacion']); ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="autoridad_responsable">Autoridad Responsable</label>
                            <input type="text" class="form-control" name="autoridad_responsable" value="<?php echo remove_junk($queja['Autoridad_Responsable']); ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="creada_por">Creada por</label>
                            <input type="text" class="form-control" name="creada_por" value="<?php echo remove_junk($queja['Creada_Por']); ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="estatus_queja">Estatus Queja</label>
                            <input type="text" class="form-control" name="estatus_queja" value="<?php if ($queja['isanswered'] == 1) {
                                                                                                    echo 'Cerrada' . ' ';
                                                                                                }
                                                                                                if (($queja['isanswered'] == 0) && ($queja['isoverdue'] == 1)) {
                                                                                                    echo 'Abierta' . ' ';
                                                                                                }
                                                                                                if (($queja['isanswered'] == 0) && ($queja['isoverdue'] == 0)) {
                                                                                                    echo 'Pendiente' . ' ';
                                                                                                }
                                                                                                if (($queja['isanswered'] == 0) && ($queja['isoverdue'] == 1)) {
                                                                                                    echo 'No atendido' . ' ';
                                                                                                }
                                                                                                ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="asignada_a">Asignada a</label>
                            <input type="text" class="form-control" name="asignada_a" value="<?php echo remove_junk($queja['Asignado_Nombre'] . " " . $queja['Asignado_Apellido']); ?>" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-group clearfix">
                    <a href="quejas.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="add_queja" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>