<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar Recomendación';
require_once('includes/load.php');
$id_folio_acuerdo = last_id_folios_recomendaciones();
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

if (isset($_POST['add_recomendacion'])) {

    $req_fields = array('servidor_publico', 'fecha_recomendacion', 'observaciones');
    validate_fields($req_fields);

    if (empty($errors)) {
        $folio_queja   = remove_junk($db->escape($_POST['folio_queja']));
        $autoridad_responsable   = remove_junk($db->escape($_POST['autoridad_responsable']));
        $servidor_publico   = remove_junk($db->escape($_POST['servidor_publico']));
        $fecha_acuerdo   = remove_junk($db->escape($_POST['fecha_recomendacion']));
        $observaciones   = remove_junk($db->escape($_POST['observaciones']));
        $acuerdo_adjunto   = remove_junk(($db->escape($_POST['recomendacion_adjunto'])));

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
        $folio_acuerdo = 'CEDH/' . $no_folio1 . '/' . $year . '-REC';

        $folio_queja_original = $folio_queja;
        $folio_carpeta = str_replace("/", "-", $folio_queja_original);
        $carpeta = 'uploads/quejas/' . $folio_carpeta . '/' . 'recomendacion';

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $name = $_FILES['recomendacion_adjunto']['name'];
        $size = $_FILES['recomendacion_adjunto']['size'];
        $type = $_FILES['recomendacion_adjunto']['type'];
        $temp = $_FILES['recomendacion_adjunto']['tmp_name'];

        $move =  move_uploaded_file($temp, $carpeta . "/" . $name);

        $name2 = $_FILES['recomendacion_adjunto_publico']['name'];
        $size2 = $_FILES['recomendacion_adjunto_publico']['size'];
        $type2 = $_FILES['recomendacion_adjunto_publico']['type'];
        $temp2 = $_FILES['recomendacion_adjunto_publico']['tmp_name'];

        $move2 =  move_uploaded_file($temp2, $carpeta . "/" . $name2);

        if ($move && $name != '') {
            $query = "INSERT INTO recomendaciones (";
            $query .= "folio_recomendacion,folio_queja,autoridad_responsable,servidor_publico,fecha_recomendacion,observaciones,recomendacion_adjunto,recomendacion_adjunto_publico";
            $query .= ") VALUES (";
            $query .= " '{$folio_acuerdo}','{$folio_queja}','{$autoridad_responsable}','{$servidor_publico}','{$fecha_acuerdo}','{$observaciones}','{$name}','{$name2}'";
            $query .= ")";

            $query2 = "INSERT INTO folios_recomendaciones (";
            $query2 .= "folio, contador";
            $query2 .= ") VALUES (";
            $query2 .= " '{$folio_acuerdo}','{$no_folio1}'";
            $query2 .= ")";
        } else {
            $query = "INSERT INTO recomendaciones (";
            $query .= "folio_recomendacion,folio_queja,autoridad_responsable,servidor_publico,fecha_recomendacion,observaciones";
            $query .= ") VALUES (";
            $query .= " '{$folio_acuerdo}','{$folio_queja}','{$autoridad_responsable}','{$servidor_publico}','{$fecha_acuerdo}','{$observaciones}'";
            $query .= ")";

            $query2 = "INSERT INTO folios_recomendaciones (";
            $query2 .= "folio, contador";
            $query2 .= ") VALUES (";
            $query2 .= " '{$folio_acuerdo}','{$no_folio1}'";
            $query2 .= ")";
        }
        if ($db->query($query) && $db->query($query2)) {
            //sucess
            $session->msg('s', " La recomendación ha sido agregada con éxito.");
            redirect('recomendaciones.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar la recomendación.');
            redirect('add_recomendacion.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_recomendacion.php', false);
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
                <span>Agregar Recomendación</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_recomendacion.php" enctype="multipart/form-data">
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
                            <select class="form-control" name="autoridad_responsable">
                                <option value="">Escoge una opción</option>
                                <option value="Otra">Otra</option>
                                <option value="Fiscalía General en el Estado">Fiscalía General en el Estado</option>
                                <option value="Aeropuerto de Morelia">Aeropuerto de Morelia</option>
                                <option value="Colegio de Bachilleres del Estado de Michoacán COBAEM">Colegio de Bachilleres del Estado de Michoacán COBAEM</option>
                                <option value="Colegio de Estudios Científicos y Tecnológicos del Estado de Michoacán CECYTEM">Colegio de Estudios Científicos y Tecnológicos del Estado de Michoacán CECYTEM</option>
                                <option value="Comisarias regionales/Guardia Civil">Comisarias regionales/Guardia Civil</option>
                                <option value="Comisión de Búsqueda de Personas del Estado de Michoacán de Ocampo">Comisión de Búsqueda de Personas del Estado de Michoacán de Ocampo</option>
                                <option value="Comisión Coordinadora del Transporte Publico en Michoacán">Comisión Coordinadora del Transporte Publico en Michoacán</option>
                                <option value="Comisión Ejecutiva Estatal de Atención a Victimas">Comisión Ejecutiva Estatal de Atención a Victimas</option>
                                <option value="Comisión Estatal de Cultura Física y Deporte">Comisión Estatal de Cultura Física y Deporte</option>
                                <option value="Comisión Estatal del Agua y Gestión de Cuencas">Comisión Estatal del Agua y Gestión de Cuencas</option>
                                <option value="Comisión Municipal de Seguridad Ciudadana (Policía Morelia)">Comisión Municipal de Seguridad Ciudadana (Policía Morelia)</option>
                                <option value="Coordinación del Sistema Penitenciario del Estado de Michoacán">Coordinación del Sistema Penitenciario del Estado de Michoacán</option>
                                <option value="Dirección de Registro Civil">Dirección de Registro Civil</option>                                
                                <option value="Instituto de la Defensoría Publica del Estado">Instituto de la Defensoría Publica del Estado</option>
                                <option value="Instituto de la Juventud Michoacana">Instituto de la Juventud Michoacana</option>                                
                                <option value="Instituto de Vivienda de Michoacán IVEM">Instituto de Vivienda de Michoacán IVEM</option>                                
                                <option value="Instituto Michoacano de Ciencias de la Educación José María Morelos">Instituto Michoacano de Ciencias de la Educación José María Morelos</option>
                                <option value="Junta de Asistencia Privada del Gobierno del Estado">Junta de Asistencia Privada del Gobierno del Estado</option>
                                <option value="Organismos operadores de agua potable de los municipios">Organismos operadores de agua potable de los municipios</option>
                                <option value="Pensiones Civiles del Estado">Pensiones Civiles del Estado</option>
                                <option value="Presidencia Municipal de Acuitzio">Presidencia Municipal de Acuitzio</option>
                                <option value="Presidencia Municipal de Aguililla">Presidencia Municipal de Aguililla</option>
                                <option value="Presidencia Municipal de Álvaro Obregón">Presidencia Municipal de Álvaro Obregón</option>
                                <option value="Presidencia Municipal de Angamacutiro">Presidencia Municipal de Angamacutiro</option>
                                <option value="Presidencia Municipal de Angangueo">Presidencia Municipal de Angangueo</option>
                                <option value="Presidencia Municipal de Apatzingán">Presidencia Municipal de Apatzingán</option>
                                <option value="Presidencia Municipal de Aquila">Presidencia Municipal de Aquila</option>
                                <option value="Presidencia Municipal de Ario">Presidencia Municipal de Ario</option>
                                <option value="Presidencia Municipal de Arteaga">Presidencia Municipal de Arteaga</option>
                                <option value="Presidencia Municipal de Briseñas">Presidencia Municipal de Briseñas</option>
                                <option value="Presidencia Municipal de Buenavista">Presidencia Municipal de Buenavista</option>
                                <option value="Presidencia Municipal de Carácuaro">Presidencia Municipal de Carácuaro</option>
                                <option value="Presidencia Municipal de Charapan">Presidencia Municipal de Charapan</option>
                                <option value="Presidencia Municipal de Charo">Presidencia Municipal de Charo</option>
                                <option value="Presidencia Municipal de Chavinda">Presidencia Municipal de Chavinda</option>
                                <option value="Presidencia Municipal de Cheran">Presidencia Municipal de Cheran</option>
                                <option value="Presidencia Municipal de Chilchota">Presidencia Municipal de Chilchota</option>
                                <option value="Presidencia Municipal de Chucándiro">Presidencia Municipal de Chucándiro</option>
                                <option value="Presidencia Municipal de Churintzio">Presidencia Municipal de Churintzio</option>
                                <option value="Presidencia Municipal de Coeneo">Presidencia Municipal de Coeneo</option>
                                <option value="Presidencia Municipal de Cotija">Presidencia Municipal de Cotija</option>
                                <option value="Presidencia Municipal de Cuitzeo">Presidencia Municipal de Cuitzeo</option>
                                <option value="Presidencia Municipal de Ecuandureo">Presidencia Municipal de Ecuandureo</option>
                                <option value="Presidencia Municipal de Epitacio Huerta">Presidencia Municipal de Epitacio Huerta</option>
                                <option value="Presidencia Municipal de Erongarícuaro">Presidencia Municipal de Erongarícuaro</option>
                                <option value="Presidencia Municipal de Gabriel Zamora">Presidencia Municipal de Gabriel Zamora</option>
                                <option value="Presidencia Municipal de Hidalgo">Presidencia Municipal de Hidalgo</option>
                                <option value="Presidencia Municipal de Huandacareo">Presidencia Municipal de Huandacareo</option>
                                <option value="Presidencia Municipal de Huaniqueo">Presidencia Municipal de Huaniqueo</option>
                                <option value="Presidencia Municipal de Huetamo">Presidencia Municipal de Huetamo</option>
                                <option value="Presidencia Municipal de Huiramba">Presidencia Municipal de Huiramba</option>
                                <option value="Presidencia Municipal de Indaparapeo">Presidencia Municipal de Indaparapeo</option>
                                <option value="Presidencia Municipal de Irimbo">Presidencia Municipal de Irimbo</option>
                                <option value="Presidencia Municipal de Ixtlán">Presidencia Municipal de Ixtlán</option>
                                <option value="Presidencia Municipal de Jacona">Presidencia Municipal de Jacona</option>
                                <option value="Presidencia Municipal de Jiménez">Presidencia Municipal de Jiménez</option>
                                <option value="Presidencia Municipal de Jiquilpan">Presidencia Municipal de Jiquilpan</option>
                                <option value="Presidencia Municipal de José Sixto Verduzco">Presidencia Municipal de José Sixto Verduzco</option>
                                <option value="Presidencia Municipal de Jungapeo">Presidencia Municipal de Jungapeo</option>
                                <option value="Presidencia Municipal de La Huacana">Presidencia Municipal de La Huacana</option>
                                <option value="Presidencia Municipal de La Piedad">Presidencia Municipal de La Piedad</option>
                                <option value="Presidencia Municipal de Lagunillas">Presidencia Municipal de Lagunillas</option>
                                <option value="Presidencia Municipal de Lázaro Cárdenas">Presidencia Municipal de Lázaro Cárdenas</option>
                                <option value="Presidencia Municipal de Los Reyes">Presidencia Municipal de los Reyes</option>
                                <option value="Presidencia Municipal de Madero">Presidencia Municipal de Madero</option>
                                <option value="Presidencia Municipal de Maravatío">Presidencia Municipal de Maravatío</option>
                                <option value="Presidencia Municipal de Marcos Castellanos">Presidencia Municipal de Marcos Castellanos</option>
                                <option value="Presidencia Municipal de Morelia">Presidencia Municipal de Morelia</option>
                                <option value="Presidencia Municipal de Morelos">Presidencia Municipal de Morelos</option>
                                <option value="Presidencia Municipal de Múgica">Presidencia Municipal de Múgica</option>
                                <option value="Presidencia Municipal de Nahuatzen">Presidencia Municipal de Nahuatzen</option>
                                <option value="Presidencia Municipal de Nocupétaro">Presidencia Municipal de Nocupétaro</option>
                                <option value="Presidencia Municipal de Nuevo Parangaricutiro">Presidencia Municipal de Nuevo Parangaricutiro</option>
                                <option value="Presidencia Municipal de Nuevo Urecho">Presidencia Municipal de Nuevo Urecho</option>
                                <option value="Presidencia Municipal de Numarán">Presidencia Municipal de Numarán</option>
                                <option value="Presidencia Municipal de Ocampo">Presidencia Municipal de Ocampo</option>
                                <option value="Presidencia Municipal de Pajacuarán">Presidencia Municipal de Pajacuarán</option>
                                <option value="Presidencia Municipal de Panindícuaro">Presidencia Municipal de Panindícuaro</option>
                                <option value="Presidencia Municipal de Paracho">Presidencia Municipal de Paracho</option>
                                <option value="Presidencia Municipal de Pátzcuaro">Presidencia Municipal de Pátzcuaro</option>
                                <option value="Presidencia Municipal de Penjamillo">Presidencia Municipal de Penjamillo</option>
                                <option value="Presidencia Municipal de Peribán">Presidencia Municipal de Peribán</option>
                                <option value="Presidencia Municipal de Purépero">Presidencia Municipal de Purépero</option>
                                <option value="Presidencia Municipal de Puruándiro">Presidencia Municipal de Puruándiro</option>
                                <option value="Presidencia Municipal de Queréndaro">Presidencia Municipal de Queréndaro</option>
                                <option value="Presidencia Municipal de Quiroga">Presidencia Municipal de Quiroga</option>
                                <option value="Presidencia Municipal de Sahuayo">Presidencia Municipal de Sahuayo</option>
                                <option value="Presidencia Municipal de Salvador Escalante">Presidencia Municipal de Salvador Escalante</option>
                                <option value="Presidencia Municipal de Santa Ana Maya">Presidencia Municipal de Santa Ana Maya</option>
                                <option value="Presidencia Municipal de Senguio">Presidencia Municipal de Senguio</option>
                                <option value="Presidencia Municipal de Tacámbaro">Presidencia Municipal de Tacámbaro</option>
                                <option value="Presidencia Municipal de Tancítaro">Presidencia Municipal de Tancítaro</option>
                                <option value="Presidencia Municipal de Tangamandapio">Presidencia Municipal de Tangamandapio</option>
                                <option value="Presidencia Municipal de Tangancicuaro">Presidencia Municipal de Tangancicuaro</option>
                                <option value="Presidencia Municipal de Tanhuato">Presidencia Municipal de Tanhuato</option>
                                <option value="Presidencia Municipal de Taretan">Presidencia Municipal de Taretan</option>
                                <option value="Presidencia Municipal de Tarímbaro">Presidencia Municipal de Tarímbaro</option>
                                <option value="Presidencia Municipal de Tepalcatepec">Presidencia Municipal de Tepalcatepec</option>
                                <option value="Presidencia Municipal de Tingambato">Presidencia Municipal de Tingambato</option>
                                <option value="Presidencia Municipal de Tingüindín">Presidencia Municipal de Tingüindín</option>
                                <option value="Presidencia Municipal de Tiquicheo">Presidencia Municipal de Tiquicheo</option>
                                <option value="Presidencia Municipal de Tlalpujahua">Presidencia Municipal de Tlalpujahua</option>
                                <option value="Presidencia Municipal de Tlazazalca">Presidencia Municipal de Tlazazalca</option>
                                <option value="Presidencia Municipal de Tocumbo">Presidencia Municipal de Tocumbo</option>
                                <option value="Presidencia Municipal de Tuxpan">Presidencia Municipal de Tuxpan</option>
                                <option value="Presidencia Municipal de Tuzantla">Presidencia Municipal de Tuzantla</option>
                                <option value="Presidencia Municipal de Tzintzuntzan">Presidencia Municipal de Tzintzuntzan</option>
                                <option value="Presidencia Municipal de Uruapan">Presidencia Municipal de Uruapan</option>
                                <option value="Presidencia Municipal de Venustiano Carranza">Presidencia Municipal de Venustiano Carranza</option>
                                <option value="Presidencia Municipal de Villamar">Presidencia Municipal de Villamar</option>
                                <option value="Presidencia Municipal de Vista Hermosa">Presidencia Municipal de Vista Hermosa</option>
                                <option value="Presidencia Municipal de Yurécuaro">Presidencia Municipal de Yurécuaro</option>
                                <option value="Presidencia Municipal de Zacapu">Presidencia Municipal de Zacapu</option>
                                <option value="Presidencia Municipal de Zamora">Presidencia Municipal de Zamora</option>
                                <option value="Presidencia Municipal de Zináparo">Presidencia Municipal de Zináparo</option>
                                <option value="Presidencia Municipal de Zinapécuaro">Presidencia Municipal de Zinapécuaro</option>
                                <option value="Presidencia Municipal de Ziracuaretiro">Presidencia Municipal de Ziracuaretiro</option>
                                <option value="Presidencia Municipal de Zitácuaro">Presidencia Municipal de Zitácuaro</option>
                                <option value="Quejas Sin Autoridad Señalada Como Responsable">Quejas Sin Autoridad Señalada Como Responsable</option>
                                <option value="Secretaria de Contraloría del Estado">Secretaria de Contraloría del Estado</option>
                                <option value="Secretaría de Bienestar">Secretaría de Bienestar</option>
                                <option value="Secretaria de Comunicaciones y Obras Publicas">Secretaria de Comunicaciones y Obras Publicas</option>                                
                                <option value="Secretaria de Cultura en el Estado">Secretaria de Cultura en el Estado</option>
                                <option value="Secretaria de Desarrollo Económico">Secretaria de Desarrollo Económico</option>
                                <option value="Secretaria de Desarrollo Rural y Agroalimentario">Secretaria de Desarrollo Rural y Agroalimentario</option>
                                <option value="Secretaría de Desarrollo Social y Humano">Secretaría de Desarrollo Social y Humano</option>
                                <option value="Secretaria de Desarrollo Territorial Urbano y Movilidad">Secretaria de Desarrollo Territorial Urbano y Movilidad</option>
                                <option value="Secretaria de Educación del Estado">Secretaria de Educación del Estado</option>
                                <option value="Secretaria de Educación Pública Federal">Secretaria de Educación Pública Federal</option>
                                <option value="Secretaria de Finanzas y Administración">Secretaria de Finanzas y Administración</option>
                                <option value="Secretaría de Gobernación">Secretaría de Gobernación</option>
                                <option value="Secretaria de Gobierno">Secretaria de Gobierno</option>
                                <option value="Secretaria de Igualdad Sustantiva y Desarrollo de Las Mujeres Michoacanas">Secretaria de Igualdad Sustantiva y Desarrollo de Las Mujeres Michoacanas</option>                                
                                <option value="Secretaria de los Migrantes En El Extranjero">Secretaria de los Migrantes En El Extranjero</option>
                                <option value="Secretaria de Salud">Secretaria de Salud</option>
                                <option value="Secretaria del Trabajo y Previsión Social">Secretaria del Trabajo y Previsión Social</option>
                                <option value="Sistema Integral de Financiamiento para el Desarrollo de Michoacán Si Financia">Sistema Integral de Financiamiento para el Desarrollo de Michoacán Si Financia</option>                                
                                <option value="Sistema Para el Desarrollo Integral de la Familia DIF">Sistema Para el Desarrollo Integral de la Familia DIF</option>
                                <option value="Supremo Tribunal de Justicia">Supremo Tribunal de Justicia</option>
                                <option value="Telebachillerato de Michoacán">Telebachillerato de Michoacán</option>
                                <option value="Tribunal de Conciliación y Arbitraje del Estado de Michoacán">Tribunal de Conciliación y Arbitraje del Estado de Michoacán</option>
                                <option value="Tribunal de Justicia Administrativa del Estado de Michoacán">Tribunal de Justicia Administrativa del Estado de Michoacán</option>
                                <option value="Universidad de la Ciénega">Universidad de la Ciénega</option>
                                <option value="Universidad Intercultural Indígena de Michoacán">Universidad Intercultural Indígena de Michoacán</option>                                
                                <option value="Universidad Tecnológica de Morelia (UTM)">Universidad Tecnológica de Morelia (UTM)</option>  
                                <option value="Universidad Virtual del Estado de Michoacán (UNIVIM)">Universidad Virtual del Estado de Michoacán (UNIVIM)</option>
                                <option value="Visitaduría Morelia">Visitaduría Morelia</option>
                                <option value="Visitaduría Uruapan">Visitaduría Uruapan</option>
                                <option value="Presidencia Municipal de Tzitzio">Presidencia Municipal de Tzitzio</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="servidor_publico">Servidor público</label>
                            <input type="text" class="form-control" name="servidor_publico" placeholder="Nombre Completo" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_recomendacion">Fecha de Recomendación</label><br>
                            <input type="date" class="form-control" name="fecha_recomendacion">
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
                                <label for="recomendacion_adjunto">Adjuntar Recomendación</label>
                                <input id="recomendacion_adjunto" type="file" accept="application/pdf" class="form-control" name="recomendacion_adjunto">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <span>
                                <label for="recomendacion_adjunto_publico">Adjuntar Recomendación Versión Pública</label>
                                <input id="recomendacion_adjunto_publico" type="file" accept="application/pdf" class="form-control" name="recomendacion_adjunto_publico">
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group clearfix">
                    <a href="recomendaciones.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="add_recomendacion" class="btn btn-primary" value="subir">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>