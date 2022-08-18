<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar Correspondencia Interna';
require_once('includes/load.php');
$user = current_user();
$detalle = $user['id'];
$id_ori_canal = last_id_oricanal();
// $id_folio = last_id_folios_general();
$id_folio = last_id_folios_env_cor();
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
$areas = find_all('area');
$area_user = area_usuario2($id_user);
$area_creacion = $area_user['nombre_area'];
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

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
        $adjunto   = remove_junk($db->escape($_POST['oficio_enviado']));
        $trabajador   = remove_junk($db->escape($_POST['se_turna_a_trabajador']));
        $expediente   = remove_junk($db->escape($_POST['expediente']));
        $cuerpo_oficio   = remove_junk($db->escape($_POST['cuerpo_oficio']));
        $ccp   = remove_junk(($db->escape($_POST['con_copia_para[]'])));

        $json = json_encode($ccp, true);

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

        $folio_carpeta = 'CEDH-' . $no_folio1 . '-' . $year . '-ECOR';
        $carpeta = 'uploads/correspondencia/' . $folio_carpeta;

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $name = $_FILES['oficio_enviado']['name'];
        $size = $_FILES['oficio_enviado']['size'];
        $type = $_FILES['oficio_enviado']['type'];
        $temp = $_FILES['oficio_enviado']['tmp_name'];

        $move =  move_uploaded_file($temp, $carpeta . "/" . $name);

        if ($move && $name != '') {
            $query = "INSERT INTO envio_correspondencia (";
            $query .= "folio,fecha_emision,asunto,medio_envio,se_turna_a_area,fecha_espera_respuesta,tipo_tramite,oficio_enviado,observaciones,area_creacion,se_turna_a_trabajador,expediente,con_copia_para,cuerpo_oficio";
            $query .= ") VALUES (";
            $query .= " '{$folio}','{$fecha_emision}','{$asunto}','{$medio_envio}','{$se_turna_a_area}','{$fecha_espera_respuesta}','{$tipo_tramite}','{$name}','{$observaciones}','{$area_creacion}','{$trabajador}','{$expediente}','{$json}','{$cuerpo_oficio}'";
            $query .= ")";

            $query2 = "INSERT INTO folios_env_correspondencia (";
            $query2 .= "folio, contador";
            $query2 .= ") VALUES (";
            $query2 .= " '{$folio}','{$no_folio1}'";
            $query2 .= ")";
        } else {

            $query = "INSERT INTO envio_correspondencia (";
            $query .= "folio,fecha_emision,asunto,medio_envio,se_turna_a_area,fecha_espera_respuesta,tipo_tramite,observaciones,area_creacion,se_turna_a_trabajador,expediente,con_copia_para,cuerpo_oficio";
            $query .= ") VALUES (";
            $query .= " '{$folio}','{$fecha_emision}','{$asunto}','{$medio_envio}','{$se_turna_a_area}','{$fecha_espera_respuesta}','{$tipo_tramite}','{$observaciones}','{$area_creacion}','{$trabajador}','{$expediente}','{$json}','{$cuerpo_oficio}'";
            $query .= ")";

            $query2 = "INSERT INTO folios_env_correspondencia (";
            $query2 .= "folio, contador";
            $query2 .= ") VALUES (";
            $query2 .= " '{$folio}','{$no_folio1}'";
            $query2 .= ")";
        }

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
                            <input type="text" id="asunto" maxlength="60" class="form-control" name="asunto" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="expediente">Expediente</label>
                            <input type="text" id="expediente" class="form-control" name="expediente" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="medio_envio">Medio de Envío</label>
                            <select class="form-control" name="medio_envio">
                                <option value="Escoge una opción">Escoge una opción</option>
                                <option value="Mediante esta plataforma">Mediante esta plataforma</option>
                                <option value="Correo">Correo</option>
                                <option value="Mediante Oficio">Mediante Oficio</option>
                                <option value="Paquetería">Paquetería</option>
                                <option value="WhatsApp">WhatsApp</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="se_turna_a_area">Área a la que se turna</label>
                            <select class="form-control" id="se_turna_a_area" name="se_turna_a_area">
                                <?php foreach ($areas as $area) : ?>
                                    <option value="<?php echo $area['nombre_area']; ?>"><?php echo ucwords($area['nombre_area']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <?php $trabajadores = find_all_trabajadores_area($area['nombre_area']) ?>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="se_turna_a_trabajador">Trabajador al que se dirige oficio</label>

                            <!-- <select class="form-control" id="se_turna_a_trabajador" name="se_turna_a_trabajador">
                                <?php //foreach ($trabajadores as $trabajador) : 
                                ?>
                                    <option value="<?php //echo $trabajador['nombre'] . " " . $trabajador['apellidos']; 
                                                    ?>"><?php echo ucwords($trabajador['nombre'] . " " . $trabajador['apellidos']); ?></option>
                                <?php //endforeach; 
                                ?>
                            </select> -->
                            <select class="form-control" id="se_turna_a_trabajador" name="se_turna_a_trabajador"></select>

                        </div>
                    </div>
                    <!-- <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_en_que_se_turna">Fecha en que se turna oficio</label>
                            <input type="date" class="form-control" name="fecha_en_que_se_turna" required>
                        </div>
                    </div> -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_espera_respuesta">Fecha en que se espera respuesta</label>
                            <input type="date" class="form-control" name="fecha_espera_respuesta">
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
                    <!-- <div class="col-md-3">
                        <div class="form-group">
                            <label for="oficio_enviado">Adjuntar Oficio para enviar</label>
                            <input type="file" accept="application/pdf" class="form-control" name="oficio_enviado" id="oficio_enviado">
                        </div>
                    </div> -->
                </div>
                <script>
                    $(function() {
                        $("#se_turna_a_area").on("change", function() {
                            var variable = $(this).val();
                            $("#selected").html(variable);
                        })

                    });
                    $(function() {
                        $("#se_turna_a_trabajador").on("change", function() {
                            var variable2 = $(this).val();
                            $("#selected2").html(variable2);
                        })

                    });
                    $(function() {
                        $("#con_copia_para").on("change", function() {
                            var variable3 = $(this).val();
                            $("#selected3").html(variable3);
                        })

                    });
                </script>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
                <script src="js/chosen.jquery.js" type="text/javascript"></script>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $(".chosen-select").chosen({
                            no_results_text: 'No hay resultados para '
                        });
                    });
                </script>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="con_copia_para">C.C.P</label><br>
                            <select class="form-control chosen-select" data-placeholder="Selecciona una o más áreas" id="con_copia_para" name="con_copia_para[]" multiple>
                                <?php foreach ($areas as $area) : ?>
                                    <option value="<?php echo " " .  $area['nombre_area']; ?>"><?php echo ucwords($area['nombre_area']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cuerpo_oficio">Cuerpo del oficio</label>
                            <textarea class="form-control" name="cuerpo_oficio" id="cuerpo" cols="15" rows="3" style="white-space: pre-line;"></textarea>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="observaciones">Observaciones</label>
                            <textarea class="form-control" name="observaciones" id="observaciones" cols="10" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <hr style="border-width: 5px; color: #474547">
                <?php
                if (count($id_folio) == 0) {
                    $nuevo_id_folio = 1;
                    $no_folio1 = sprintf('%04d', 1);
                } else {
                    foreach ($id_folio as $nuevo) {
                        $nuevo_id_folio = (int)$nuevo['id'] + 1;
                        $no_folio1 = sprintf('%04d', (int)$nuevo['id'] + 1);
                    }
                }
                $year = date("Y");
                $folio = 'CEDH/' . $no_folio1 . '/' . $year . '-ECOR';
                $exp = '<span id="copiaExpediente"></span>';
                ?>

                <h1 style="font-weight: 600;">Previsualización de datos que se mostrarán en el oficio en PDF</h1>
                <div class="row">
                    <div style="margin-top: 20px; width: 50%;">
                        <p><b>Área emisora: </b><?php echo $area_creacion ?></p>
                        <p><b>Número de oficio: </b><?php echo $folio ?></p>
                        <p><b>Expediente: </b> <span id="copiaExpediente"></span></p>
                        <p><b>Asunto: </b> <span id="copiaAsunto"></span></p>
                        <p><b>Área receptora: </b> <span id="selected"></span></p>
                        <p><b>Se dirige a: </b> <span id="selected2"></span></p>
                        <p><b>Con copia para: </b> <span id="selected3"></span></p>
                    </div>
                    <div style="margin-top: 20px; width: 50%;">
                        <p><b>Cuerpo del oficio: </b><span id="copiaCuerpo"></span></p>
                    </div>
                </div><br>
                <div class="form-group clearfix">
                    <a href="env_correspondencia.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <center>
                        <button type="submit" name="add_env_correspondencia" class="btn btn-primary">Guardar</button>
                    </center>
                </div>
            </form>
            <form method="post" action="pdf2.php" name="pdf2">
                <center>
                    <!-- <input type="button" onclick="GeneratePdf();" value="GeneratePdf" style="font-size: 14px;" class="btn btn-danger"> -->
                    <!-- <a href="pdf2.php?area_creacion=<?php echo $area_creacion; ?>&folio=<?php echo $folio; ?>&expediente=<?php $expediente; ?>&asunto=<?php $asunto; ?>" class="btn btn-danger btn-md" title="Descargar" data-toggle="tooltip">
                      Generar oficio
                    </a> -->
                </center>
            </form>
        </div>
    </div>
</div>
<script>
    // Function to GeneratePdf
    function GeneratePdf() {
        var element = document.getElementById('form-print');
        html2pdf(element);
    }
</script>
<!-- <select id="peligroppls" class="form-select" aria-label="Default select example">
  <option selected >Open this select menu</option>
  <option value="1">One</option>
  <option value="2">Two</option>
  <option value="3">Three</option>
</select>
<br><br>
<label>Valor de la opcion seleccionada <span id="selected"></span>  </label> -->

<script>
    // ---------------------- Expediente ----------------------
    let txtInput = document.querySelector('#expediente');
    let divCopia = document.getElementById('copiaExpediente');

    txtInput.addEventListener('keyup', () => {
        divCopia.innerHTML = txtInput.value;
    });
    // ------------------------ Asunto ------------------------
    let txtInput2 = document.querySelector('#asunto');
    let divCopia2 = document.getElementById('copiaAsunto');

    txtInput2.addEventListener('keyup', () => {
        divCopia2.innerHTML = txtInput2.value;
    });
    // ------------------- Cuerpo del oficio -------------------
    let txtInput3 = document.querySelector('#Cuerpo');
    let divCopia3 = document.getElementById('copiaCuerpo');

    txtInput3.addEventListener('keyup', () => {
        divCopia3.innerHTML = txtInput3.value;
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<?php include_once('layouts/footer.php'); ?>