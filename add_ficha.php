<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar Ficha Técnica';
require_once('includes/load.php');
$user = current_user();
$detalle = $user['id'];
$id_folio = last_id_folios();
page_require_level(2);
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['add_ficha'])) {

    $req_fields = array('tipo_sol', 'num_expediente', 'solicitante', 'visitaduria', 'hechos', 'autoridad', 'quien_presenta', 'edad', 'fecha_nacimiento', 'sexo', 'grupo_vulnerable', 'contacto', 'fecha_intervencion', 'hora_lugar', 'actividad_realizada');
    validate_fields($req_fields);

    if (empty($errors)) {
        $tipo_sol   = remove_junk($db->escape($_POST['tipo_sol']));
        $num_expediente   = remove_junk($db->escape($_POST['num_expediente']));
        $solicitante   = remove_junk($db->escape($_POST['solicitante']));
        $visitaduria   = remove_junk($db->escape($_POST['visitaduria']));
        $hechos   = remove_junk(($db->escape($_POST['hechos'])));
        $autoridad   = remove_junk(($db->escape($_POST['autoridad'])));
        $quien_presenta   = remove_junk($db->escape($_POST['quien_presenta']));
        $nombre_usuario   = remove_junk($db->escape($_POST['nombre_usuario']));
        $parentesco   = remove_junk($db->escape($_POST['parentesco']));
        $edad   = remove_junk($db->escape($_POST['edad']));
        $fecha_nacimiento   = remove_junk($db->escape($_POST['fecha_nacimiento']));
        $sexo   = remove_junk($db->escape($_POST['sexo']));
        $grupo_vulnerable   = remove_junk($db->escape($_POST['grupo_vulnerable']));
        $tutor   = remove_junk($db->escape($_POST['tutor']));
        $contacto   = remove_junk($db->escape($_POST['contacto']));
        $fecha_intervencion   = remove_junk($db->escape($_POST['fecha_intervencion']));
        $hora_lugar   = remove_junk($db->escape($_POST['hora_lugar']));
        $actividad_realizada   = remove_junk($db->escape($_POST['actividad_realizada']));
        $observaciones   = remove_junk($db->escape($_POST['observaciones']));

        if (count($id_folio) == 0) {
            $nuevo_id_folio = 1;
            $no_folio1 = sprintf('%04d', 1);
        } else {
            foreach ($id_folio as $nuevo) {
                $nuevo_id_folio = (int)$nuevo['id'] + 1;
                $no_folio1 = sprintf('%04d', (int)$nuevo['id'] + 1);
            }
        }
        // Se crea el número de folio
        $year = date("Y");
        // Se crea el folio de convenio
        $folio = 'CEDH/' . $no_folio1 . '/' . $year . '-FT';


        $query = "INSERT INTO fichas (";
        $query .= "folio,tipo_solicitud,num_expediente,solicitante,visitaduria,hechos,autoridad,quien_presenta,nombre_usuario,parentesco,edad,fecha_nacimiento,sexo,grupo_vulnerable,tutor,contacto,fecha_intervencion,hora_lugar,actividad_realizada,observaciones";
        $query .= ") VALUES (";
        $query .= " '{$folio}','{$tipo_sol}','{$num_expediente}','{$solicitante}','{$visitaduria}','{$hechos}','{$autoridad}','{$quien_presenta}','{$nombre_usuario}','{$parentesco}','{$edad}','{$fecha_nacimiento}','{$sexo}','{$grupo_vulnerable}','{$tutor}','{$contacto}','{$fecha_intervencion}','{$hora_lugar}','{$actividad_realizada}','{$observaciones}'";
        $query .= ")";

        $query2 = "INSERT INTO folios (";
        $query2 .= "folio, contador";
        $query2 .= ") VALUES (";
        $query2 .= " '{$folio}','{$no_folio1}'";
        $query2 .= ")";

        if ($db->query($query) && $db->query($query2)) {
            //sucess
            $session->msg('s', " La orientación ha sido agregada con éxito.");
            redirect('fichas.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar la orientación.');
            redirect('add_ficha.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_ficha.php', false);
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
                <span>Agregar Ficha Técnica</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_ficha.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="tipo_sol">Tipo de ficha</label>
                            <select class="form-control" name="tipo_sol">
                                <option value="">Elige una opción</option>
                                <option value="Dictamen">Dictamen</option>
                                <option value="Certificado">Certificado</option>
                                <option value="Valoración">Valoración</option>
                                <option value="Contención">Contención</option>
                                <option value="Psicológica">Psicológica</option>
                                <option value="Inspección">Inspección</option>
                                <option value="Orientación médica">Orientación médica</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="correo">Número de expediente</label>
                            <input type="text" class="form-control" name="num_expediente" placeholder="Signado por visitaduria correspondiente" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="solicitante">Solicitante</label>
                            <input type="text" class="form-control" name="solicitante" placeholder="Nombre de visitador y/o instancia" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="visitaduria">Visitaduria</label>
                            <select class="form-control" name="visitaduria">
                                <option value="">Elige una opción</option>
                                <option value="Regional de Apatzingán">Regional de Apatzingán</option>
                                <option value="Regional de Lázaro Cárdenas">Regional de Lázaro Cárdenas</option>
                                <option value="Regional de Morelia">Regional de Morelia</option>
                                <option value="Regional de Uruapan">Regional de Uruapan</option>
                                <option value="Auxiliar de Paracho">Auxiliar de Paracho</option>
                                <option value="Regional de Zamora">Regional de Zamora</option>
                                <option value="Auxiliar de La Piedad">Auxiliar de La Piedad</option>
                                <option value="Regional de Zitácuaro">Regional de Zitácuaro</option>
                                <option value="Auxiliar de Huetamo">Auxiliar de Huetamo</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="hechos">Presuntos hechos violatorios</label>
                            <textarea type="text" class="form-control" name="hechos" cols="30" rows="1" placeholder="Generales" required></textarea>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="autoridad">Autoridad señalada</label>
                            <select class="form-control" name="autoridad">
                                <option value="">Elige una opción</option>
                                <option value="Secretaría de Seguridad Pública">Secretaría de Seguridad Pública</option>
                                <option value="Fiscalía General en el Estado">Fiscalía General en el Estado</option>
                                <option value="Aeropuerto de Morelia">Aeropuerto de Morelia</option>
                                <option value="Colegio de Bachilleres del Estado de Michoacán COBAEM">Colegio de Bachilleres del Estado de Michoacán COBAEM</option>
                                <option value="Colegio de Estudios Científicos y Tecnológicos del Estado de Michoacán CECYTEM">Colegio de Estudios Científicos y Tecnológicos del Estado de Michoacán CECYTEM</option>
                                <option value="Colegio Nacional de Educación Profesional Técnica CONALEP">Colegio Nacional de Educación Profesional Técnica CONALEP</option>
                                <option value="Comisión Coordinadora del Transporte Publico en Michoacán">Comisión Coordinadora del Transporte Publico en Michoacán</option>
                                <option value="Comisión Ejecutiva Estatal de Atención a Victimas">Comisión Ejecutiva Estatal de Atención a Victimas</option>
                                <option value="Comisión Estatal de Cultura Física y Deporte">Comisión Estatal de Cultura Física y Deporte</option>
                                <option value="Comisión Estatal del Agua y Gestión de Cuencas">Comisión Estatal del Agua y Gestión de Cuencas</option>
                                <option value="Comisión Nacional de los Derechos Humanos CNDH">Comisión Nacional de los Derechos Humanos CNDH</option>
                                <option value="Comisión Nacional del Agua CONAGUA">Comisión Nacional del Agua CONAGUA</option>
                                <option value="Comisión Nacional Para la Protección y Defensa de los Usuarios de Servicios Financieros CONDUSEF">Comisión Nacional Para la Protección y Defensa de los Usuarios de Servicios Financieros CONDUSEF</option>
                                <option value="Comisión Para la Regularización de la Tenencia de la Tierra CORETT">Comisión Para la Regularización de la Tenencia de la Tierra CORETT</option>
                                <option value="Consejería Jurídica del Ejecutivo del Estado">Consejería Jurídica del Ejecutivo del Estado</option>
                                <option value="Consejo Nacional Para Prevenir la Discriminación">Consejo Nacional Para Prevenir la Discriminación</option>
                                <option value="Coordinación de Comunicación Social">Coordinación de Comunicación Social</option>
                                <option value="Coordinación del Sistema Penitenciario del Estado de Michoacán">Coordinación del Sistema Penitenciario del Estado de Michoacán</option>
                                <option value="Defensoría Publica Federal">Defensoría Publica Federal</option>
                                <option value="Despacho del C Gobernador">Despacho del C Gobernador</option>
                                <option value="Dirección de Registro Civil">Dirección de Registro Civil</option>
                                <option value="Dirección de Trabajo y Previsión Social">Dirección de Trabajo y Previsión Social</option>
                                <option value="Dirección General de Educación Tecnológica Industrial DGTI">Dirección General de Educación Tecnológica Industrial DGTI</option>
                                <option value="Dirección General de Institutos Tecnológicos">Dirección General de Institutos Tecnológicos</option>
                                <option value="Fiscalía General de la República">Fiscalía General de la República</option>
                                <option value="FOVISSSTE Michoacán">FOVISSSTE Michoacán</option>
                                <option value="Honorable Congreso del Estado de Michoacán">Honorable Congreso del Estado de Michoacán</option>
                                <option value="Instituto de la Defensoría Publica del Estado">Instituto de la Defensoría Publica del Estado</option>
                                <option value="Instituto de la Juventud Michoacana">Instituto de la Juventud Michoacana</option>
                                <option value="Instituto de Seguridad y Servicios Sociales de los Trabajadores al Servicio del Estado">Instituto de Seguridad y Servicios Sociales de los Trabajadores al Servicio del Estado</option>
                                <option value="Instituto de Vivienda de Michoacán IVEM">Instituto de Vivienda de Michoacán IVEM</option>
                                <option value="Instituto del Fondo Nacional de la Vivienda Para los Trabajadores INFONAVIT">Instituto del Fondo Nacional de la Vivienda Para los Trabajadores INFONAVIT</option>
                                <option value="Instituto Electoral de Michoacán">Instituto Electoral de Michoacán</option>
                                <option value="Instituto Mexicano del Seguro Social IMSS">Instituto Mexicano del Seguro Social IMSS</option>
                                <option value="Instituto Michoacano de Ciencias de la Educación José María Morelos">Instituto Michoacano de Ciencias de la Educación José María Morelos</option>
                                <option value="Instituto Nacional de Educación Para los Adultos INEA">Instituto Nacional de Educación Para los Adultos INEA</option>
                                <option value="Instituto Nacional de Migración">Instituto Nacional de Migración</option>
                                <option value="Junta de Asistencia Privada del Gobierno del Estado">Junta de Asistencia Privada del Gobierno del Estado</option>
                                <option value="Junta de Caminos del Estado de Michoacán">Junta de Caminos del Estado de Michoacán</option>
                                <option value="Junta Local de Conciliación y Arbitraje">Junta Local de Conciliación y Arbitraje</option>
                                <option value="Parque Zoológico Benito Juárez">Parque Zoológico Benito Juárez</option>
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
                                <option value="Presidencia Municipal de la Huacana">Presidencia Municipal de la Huacana</option>
                                <option value="Presidencia Municipal de la Piedad">Presidencia Municipal de la Piedad</option>
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
                                <option value="Procuraduría Agraria En Michoacán">Procuraduría Agraria En Michoacán</option>
                                <option value="Procuraduría Auxiliar de la Defensa del Trabajo">Procuraduría Auxiliar de la Defensa del Trabajo</option>
                                <option value="Procuraduría Federal de la Defensa del Trabajo">Procuraduría Federal de la Defensa del Trabajo</option>
                                <option value="Procuraduría Federal del Consumidor PROFECO">Procuraduría Federal del Consumidor PROFECO</option>
                                <option value="Quejas Sin Autoridad Señalada Como Responsable">Quejas Sin Autoridad Señalada Como Responsable</option>
                                <option value="Secretaria de Contraloría del Estado">Secretaria de Contraloría del Estado</option>
                                <option value="Secretaría de Bienestar">Secretaría de Bienestar</option>
                                <option value="Secretaria de Comunicaciones y Obras Publicas">Secretaria de Comunicaciones y Obras Publicas</option>
                                <option value="Secretaria de Comunicaciones y Transportes SCT">Secretaria de Comunicaciones y Transportes SCT</option>
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
                                <option value="Secretaria de la Defensa Nacional Ejercito Mexicano">Secretaria de la Defensa Nacional Ejercito Mexicano</option>
                                <option value="Secretaria de los Migrantes En El Extranjero">Secretaria de los Migrantes En El Extranjero</option>
                                <option value="Secretaria de Marina y Armada de México">Secretaria de Marina y Armada de México</option>
                                <option value="Secretaria de Relaciones Exteriores SRE">Secretaria de Relaciones Exteriores SRE</option>
                                <option value="Secretaria de Salud">Secretaria de Salud</option>
                                <option value="Secretaria de Seguridad Publica Estatal">Secretaria de Seguridad Publica Estatal</option>
                                <option value="Secretaria de Seguridad Publica Federal">Secretaria de Seguridad Publica Federal</option>
                                <option value="Secretaria de Seguridad y Protección Ciudadana">Secretaria de Seguridad y Protección Ciudadana</option>
                                <option value="Secretaria del Trabajo y Previsión Social">Secretaria del Trabajo y Previsión Social</option>
                                <option value="Sistema Integral de Financiamiento para el Desarrollo de Michoacán Si Financia">Sistema Integral de Financiamiento para el Desarrollo de Michoacán Si Financia</option>
                                <option value="Sistema Michoacano de Radio y Televisión">Sistema Michoacano de Radio y Televisión</option>
                                <option value="Sistema Para el Desarrollo Integral de la Familia DIF">Sistema Para el Desarrollo Integral de la Familia DIF</option>
                                <option value="Supremo Tribunal de Justicia">Supremo Tribunal de Justicia</option>
                                <option value="Telebachillerato de Michoacán">Telebachillerato de Michoacán</option>
                                <option value="Tribunal de Conciliación y Arbitraje del Estado de Michoacán">Tribunal de Conciliación y Arbitraje del Estado de Michoacán</option>
                                <option value="Tribunal de Justicia Administrativa del Estado de Michoacán">Tribunal de Justicia Administrativa del Estado de Michoacán</option>
                                <option value="Universidad Intercultural Indígena de Michoacán">Universidad Intercultural Indígena de Michoacán</option>
                                <option value="Universidad Michoacana de San Nicolas de Hidalgo UMSNH">Universidad Michoacana de San Nicolas de Hidalgo UMSNH</option>
                                <option value="Universidad Virtual del Estado de Michoacán">Universidad Virtual del Estado de Michoacán</option>
                                <option value="Visitaduría Morelia">Visitaduría Morelia</option>
                                <option value="Visitaduría Uruapan">Visitaduría Uruapan</option>
                                <option value="Presidencia Municipal de Tzitzio">Presidencia Municipal de Tzitzio</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="quien_presenta">Nombre de quien presenta la queja</label>
                            <input type="text" class="form-control" name="quien_presenta" placeholder="Nombre Completo" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nombre_usuario">Nombre del usuario</label>
                            <input type="text" class="form-control" name="nombre_usuario" placeholder="Nombre Completo">
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="parentesco">Parentesco</label>
                            <!-- <input type="text" class="form-control" name="parentesco" placeholder="En caso de ser distinto a quien presenta queja"> -->
                            <select class="form-control" name="parentesco">
                                <option value="">Elige una opción</option>
                                <option value="Hijo(a)">Hijo(a)</option>
                                <option value="Padre">Padre</option>
                                <option value="Madre">Madre</option>
                                <option value="Abuelo(a)">Abuelo(a)</option>
                                <option value="Nieto(a)">Nieto(a)</option>
                                <option value="Hermano(a)">Hermano(a)</option>
                                <option value="Bisabuelo(a)">Bisabuelo(a)</option>
                                <option value="Bisnieto(a)">Bisnieto(a)</option>
                                <option value="Tío(a)">Tío(a)</option>
                                <option value="Sobrino(a)">Sobrino(a)</option>
                                <option value="Tatarabuelo(a)">Tatarabuelo(a)</option>
                                <option value="Tataranieto(a)">Tataranieto(a)</option>
                                <option value="Primo(a)">Primo(a)</option>
                                <option value="Suegro(a)">Suegro(a)</option>
                                <option value="Yerno">Yerno</option>
                                <option value="Nuera">Nuera</option>
                                <option value="Abuelo(a) del cónyugue">Abuelo(a) del cónyugue</option>
                                <option value="Hermano(a) del cónyugue">Hermano(a) del cónyugue</option>
                                <option value="Sobrino(a) del cónyugue">Sobrino del cónyugue</option>
                                <option value="Tío(a) del cónyugue">Tío del cónyugue</option>
                                <option value="Bisabuelo(a) del cónyugue">Bisabuelo del cónyugue</option>
                                <option value="Primo(a) del cónyugue">Primo(a) del cónyugue</option>
                                <option value="Tatarabuelo(a) del cónyugue">tatarabuelo(a) del cónyugue</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="edad">Edad</label>
                            <input type="number" class="form-control" min="1" max="120" name="edad" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" name="fecha_nacimiento" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="sexo">Sexo</label>
                            <select class="form-control" name="sexo">
                                <option value="Mujer">Mujer</option>
                                <option value="Hombre">Hombre</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="grupo_vulnerable">Grupo Vulnerable</label>
                            <select class="form-control" name="grupo_vulnerable">
                                <option value="">Elige una opción</option>
                                <option value="Comunidad LGBT">Comunidad LGBT</option>
                                <option value="Derecho de las mujeres">Derecho de las mujeres</option>
                                <option value="Niños y adolescentes">Niños y adolecentes</option>
                                <option value="Personas con discapacidad">Personas con discapacidad</option>
                                <option value="Personas migrantes">Personas migrantes</option>
                                <option value="Personas que viven con VIH SIDA">Personas que viven con VIH SIDA</option>
                                <option value="Grupos indígenas">Grupos indígenas</option>
                                <option value="Periodistas">Periodistas</option>
                                <option value="Defensores de los derechos humanos">Defensores de los derechos humanos</option>
                                <option value="Adultos mayores">Adultos mayores</option>
                                <option value="Internos">Internos</option>
                                <option value="Otros">Otros</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tutor">Nombre de tutor</label>
                            <input type="text" class="form-control" placeholder="Nombre Completo" name="tutor">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="contacto">Número de contacto</label>
                            <input type="text" class="form-control" maxlength="10" name="contacto">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha_intervencion">Fecha de Intervención</label>
                            <input type="date" class="form-control" name="fecha_intervencion" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="hora_lugar">Hora y lugar de Intervención</label>
                            <textarea type="text" class="form-control" name="hora_lugar" cols="50" rows="1"></textarea>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="actividad_realizada">Actividad realizada</label>
                            <textarea type="text" class="form-control" name="actividad_realizada" cols="50" rows="1"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="observaciones">Observaciones Generales</label>
                            <textarea type="text" class="form-control" name="observaciones" cols="50" rows="1"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="fichas.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="add_ficha" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>