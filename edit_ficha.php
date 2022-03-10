<?php
$page_title = 'Editar Ficha';
require_once('includes/load.php');

page_require_level(4);
?>
<?php
$e_ficha = find_by_id_ficha((int)$_GET['id']);
if (!$e_ficha) {
    $session->msg("d", "id de ficha no encontrado.");
    redirect('fichas.php');
}
$user = current_user();
$nivel = $user['user_level'];
?>

<?php
if (isset($_POST['edit_ficha'])) {
    $req_fields = array('tipo_sol', 'num_expediente', 'solicitante', 'visitaduria', 'hechos', 'autoridad', 'quien_presenta', 'edad', 'fecha_nacimiento', 'sexo', 'grupo_vulnerable', 'contacto', 'fecha_intervencion', 'hora_lugar', 'actividad_realizada');
    validate_fields($req_fields);
    if (empty($errors)) {
        $id = (int)$e_ficha['id'];
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

        $sql = "UPDATE fichas SET tipo_solicitud='{$tipo_sol}', num_expediente='{$num_expediente}', solicitante='{$solicitante}', visitaduria='{$visitaduria}', hechos='{$hechos}', autoridad='{$autoridad}', quien_presenta='{$quien_presenta}', nombre_usuario='{$nombre_usuario}', parentesco='{$parentesco}', edad='{$edad}',fecha_nacimiento='{$fecha_nacimiento}', sexo='{$sexo}', grupo_vulnerable='{$grupo_vulnerable}', tutor='{$tutor}', contacto='{$contacto}', fecha_intervencion='{$fecha_intervencion}', hora_lugar='{$hora_lugar}', actividad_realizada='{$actividad_realizada}', observaciones='{$observaciones}' WHERE id='{$db->escape($id)}'";

        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            $session->msg('s', "Información Actualizada ");
            redirect('fichas.php', false);
        } else {
            $session->msg('d', ' Lo siento no se actualizaron los datos.');
            redirect('edit_fichas', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_ficha.php?id=' . (int)$e_ficha['id'], false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Editar ficha</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="edit_ficha.php?id=<?php echo (int)$e_ficha['id']; ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="tipo_sol">Tipo de ficha</label>
                            <select class="form-control" name="tipo_sol">
                                <option value="">Elige una opción</option>
                                <option <?php if ($e_ficha['tipo_solicitud'] === 'Dictamen') echo 'selected="selected"'; ?> value="Dictamen">Dictamen</option>
                                <option <?php if ($e_ficha['tipo_solicitud'] === 'Certificado') echo 'selected="selected"'; ?> value="Certificado">Certificado</option>
                                <option <?php if ($e_ficha['tipo_solicitud'] === 'Valoración') echo 'selected="selected"'; ?> value="Valoración">Valoración</option>
                                <option <?php if ($e_ficha['tipo_solicitud'] === 'Contención') echo 'selected="selected"'; ?> value="Contención">Contención</option>
                                <option <?php if ($e_ficha['tipo_solicitud'] === 'Psicológica') echo 'selected="selected"'; ?> value="Psicológica">Psicológica</option>
                                <option <?php if ($e_ficha['tipo_solicitud'] === 'Inspección') echo 'selected="selected"'; ?> value="Inspección">Inspección</option>
                                <option <?php if ($e_ficha['tipo_solicitud'] === 'Orientación') echo 'selected="selected"'; ?> value="Orientación médica">Orientación médica</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="correo">Número de expediente</label>
                            <input type="text" class="form-control" name="num_expediente" value="<?php echo remove_junk($e_ficha['num_expediente']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="solicitante">Solicitante</label>
                            <input type="text" class="form-control" name="solicitante" value="<?php echo remove_junk($e_ficha['solicitante']); ?>" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="visitaduria">Visitaduria</label>
                            <select class="form-control" name="visitaduria">
                                <option value="">Elige una opción</option>
                                <option <?php if ($e_ficha['visitaduria'] === 'Regional de Apatzingán') echo 'selected="selected"'; ?> value="Regional de Apatzingán">Regional de Apatzingán</option>
                                <option <?php if ($e_ficha['visitaduria'] === 'Regional de Lázaro Cárdenas') echo 'selected="selected"'; ?> value="Regional de Lázaro Cárdenas">Regional de Lázaro Cárdenas</option>
                                <option <?php if ($e_ficha['visitaduria'] === 'Regional de Morelia') echo 'selected="selected"'; ?> value="Regional de Morelia">Regional de Morelia</option>
                                <option <?php if ($e_ficha['visitaduria'] === 'Regional de Uruapan') echo 'selected="selected"'; ?> value="Regional de Uruapan">Regional de Uruapan</option>
                                <option <?php if ($e_ficha['visitaduria'] === 'Auxiliar de Paracho') echo 'selected="selected"'; ?> value="Auxiliar de Paracho">Auxiliar de Paracho</option>
                                <option <?php if ($e_ficha['visitaduria'] === 'Regional de Zamora') echo 'selected="selected"'; ?> value="Regional de Zamora">Regional de Zamora</option>
                                <option <?php if ($e_ficha['visitaduria'] === 'Auxiliar de La Piedad') echo 'selected="selected"'; ?> value="Auxiliar de La Piedad">Auxiliar de La Piedad</option>
                                <option <?php if ($e_ficha['visitaduria'] === 'Regional de Zitácuaro') echo 'selected="selected"'; ?> value="Regional de Zitácuaro">Regional de Zitácuaro</option>
                                <option <?php if ($e_ficha['visitaduria'] === 'Auxiliar de Huetamo') echo 'selected="selected"'; ?> value="Auxiliar de Huetamo">Auxiliar de Huetamo</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="hechos">Presuntos hechos violatorios</label>
                            <textarea type="text" class="form-control" name="hechos" cols="30" rows="1" value="<?php echo remove_junk($e_ficha['hechos']); ?>" required><?php echo remove_junk($e_ficha['hechos']); ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="autoridad">Autoridad señalada</label>
                            <select class="form-control" name="autoridad">
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaría de Seguridad Pública') echo 'selected="selected"'; ?> value="Secretaría de Seguridad Pública">Secretaría de Seguridad Pública</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Fiscalía General en el Estado') echo 'selected="selected"'; ?> value="Fiscalía General en el Estado">Fiscalía General en el Estado</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Aeropuerto de Morelia') echo 'selected="selected"'; ?> value="Aeropuerto de Morelia">Aeropuerto de Morelia</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Colegio de Bachilleres del Estado de Michoacán COBAEM') echo 'selected="selected"'; ?> value="Colegio de Bachilleres del Estado de Michoacán COBAEM">Colegio de Bachilleres del Estado de Michoacán COBAEM</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Colegio de Estudios Científicos y Tecnológicos del Estado de Michoacán CECYTEM') echo 'selected="selected"'; ?> value="Colegio de Estudios Científicos y Tecnológicos del Estado de Michoacán CECYTEM">Colegio de Estudios Científicos y Tecnológicos del Estado de Michoacán CECYTEM</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Colegio Nacional de Educación Profesional Técnica CONALEP') echo 'selected="selected"'; ?> value="Colegio Nacional de Educación Profesional Técnica CONALEP">Colegio Nacional de Educación Profesional Técnica CONALEP</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Comisión Coordinadora del Transporte Publico en Michoacán') echo 'selected="selected"'; ?> value="Comisión Coordinadora del Transporte Publico en Michoacán">Comisión Coordinadora del Transporte Publico en Michoacán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Comisión Ejecutiva Estatal de Atención a Victimas') echo 'selected="selected"'; ?> value="Comisión Ejecutiva Estatal de Atención a Victimas">Comisión Ejecutiva Estatal de Atención a Victimas</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Comisión Estatal de Cultura Física y Deporte') echo 'selected="selected"'; ?> value="Comisión Estatal de Cultura Física y Deporte">Comisión Estatal de Cultura Física y Deporte</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Comisión Estatal del Agua y Gestión de Cuencas') echo 'selected="selected"'; ?> value="Comisión Estatal del Agua y Gestión de Cuencas">Comisión Estatal del Agua y Gestión de Cuencas</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Comisión Nacional de los Derechos Humanos CNDH') echo 'selected="selected"'; ?> value="Comisión Nacional de los Derechos Humanos CNDH">Comisión Nacional de los Derechos Humanos CNDH</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Comisión Nacional del Agua CONAGUA') echo 'selected="selected"'; ?> value="Comisión Nacional del Agua CONAGUA">Comisión Nacional del Agua CONAGUA</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Comisión Nacional Para la Protección y Defensa de los Usuarios de Servicios Financieros CONDUSEF') echo 'selected="selected"'; ?> value="Comisión Nacional Para la Protección y Defensa de los Usuarios de Servicios Financieros CONDUSEF">Comisión Nacional Para la Protección y Defensa de los Usuarios de Servicios Financieros CONDUSEF</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Comisión Para la Regularización de la Tenencia de la Tierra CORETT') echo 'selected="selected"'; ?> value="Comisión Para la Regularización de la Tenencia de la Tierra CORETT">Comisión Para la Regularización de la Tenencia de la Tierra CORETT</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Consejería Jurídica del Ejecutivo del Estado') echo 'selected="selected"'; ?> value="Consejería Jurídica del Ejecutivo del Estado">Consejería Jurídica del Ejecutivo del Estado</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Consejo Nacional Para Prevenir la Discriminación') echo 'selected="selected"'; ?> value="Consejo Nacional Para Prevenir la Discriminación">Consejo Nacional Para Prevenir la Discriminación</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Coordinación de Comunicación Socia') echo 'selected="selected"'; ?> value="Coordinación de Comunicación Social">Coordinación de Comunicación Social</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Coordinación del Sistema Penitenciario del Estado de Michoacán') echo 'selected="selected"'; ?> value="Coordinación del Sistema Penitenciario del Estado de Michoacán">Coordinación del Sistema Penitenciario del Estado de Michoacán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Defensoría Publica Federal') echo 'selected="selected"'; ?> value="Defensoría Publica Federal">Defensoría Publica Federal</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Despacho del C Gobernador') echo 'selected="selected"'; ?> value="Despacho del C Gobernador">Despacho del C Gobernador</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Dirección de Registro Civil') echo 'selected="selected"'; ?> value="Dirección de Registro Civil">Dirección de Registro Civil</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Dirección de Trabajo y Previsión Social') echo 'selected="selected"'; ?> value="Dirección de Trabajo y Previsión Social">Dirección de Trabajo y Previsión Social</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Dirección General de Educación Tecnológica Industrial DGTI') echo 'selected="selected"'; ?> value="Dirección General de Educación Tecnológica Industrial DGTI">Dirección General de Educación Tecnológica Industrial DGTI</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Dirección General de Institutos Tecnológicos') echo 'selected="selected"'; ?> value="Dirección General de Institutos Tecnológicos">Dirección General de Institutos Tecnológicos</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Fiscalía General de la República') echo 'selected="selected"'; ?> value="Fiscalía General de la República">Fiscalía General de la República</option>
                                <option <?php if ($e_ficha['autoridad'] === 'FOVISSSTE Michoacán') echo 'selected="selected"'; ?> value="FOVISSSTE Michoacán">FOVISSSTE Michoacán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Honorable Congreso del Estado de Michoacán') echo 'selected="selected"'; ?> value="Honorable Congreso del Estado de Michoacán">Honorable Congreso del Estado de Michoacán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Instituto de la Defensoría Publica del Estado') echo 'selected="selected"'; ?> value="Instituto de la Defensoría Publica del Estado">Instituto de la Defensoría Publica del Estado</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Instituto de la Juventud Michoacana') echo 'selected="selected"'; ?> value="Instituto de la Juventud Michoacana">Instituto de la Juventud Michoacana</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Instituto de Seguridad y Servicios Sociales de los Trabajadores al Servicio del Estado') echo 'selected="selected"'; ?> value="Instituto de Seguridad y Servicios Sociales de los Trabajadores al Servicio del Estado">Instituto de Seguridad y Servicios Sociales de los Trabajadores al Servicio del Estado</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Instituto de Vivienda de Michoacán IVEM') echo 'selected="selected"'; ?> value="Instituto de Vivienda de Michoacán IVEM">Instituto de Vivienda de Michoacán IVEM</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Instituto del Fondo Nacional de la Vivienda Para los Trabajadores INFONAVIT') echo 'selected="selected"'; ?> value="Instituto del Fondo Nacional de la Vivienda Para los Trabajadores INFONAVIT">Instituto del Fondo Nacional de la Vivienda Para los Trabajadores INFONAVIT</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Instituto Electoral de Michoacán') echo 'selected="selected"'; ?> value="Instituto Electoral de Michoacán">Instituto Electoral de Michoacán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Instituto Mexicano del Seguro Social IMSS') echo 'selected="selected"'; ?> value="Instituto Mexicano del Seguro Social IMSS">Instituto Mexicano del Seguro Social IMSS</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Instituto Michoacano de Ciencias de la Educación José María Morelos') echo 'selected="selected"'; ?> value="Instituto Michoacano de Ciencias de la Educación José María Morelos">Instituto Michoacano de Ciencias de la Educación José María Morelos</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Instituto Nacional de Educación Para los Adultos INEA') echo 'selected="selected"'; ?> value="Instituto Nacional de Educación Para los Adultos INEA">Instituto Nacional de Educación Para los Adultos INEA</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Instituto Nacional de Migración') echo 'selected="selected"'; ?> value="Instituto Nacional de Migración">Instituto Nacional de Migración</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Junta de Asistencia Privada del Gobierno del Estado') echo 'selected="selected"'; ?> value="Junta de Asistencia Privada del Gobierno del Estado">Junta de Asistencia Privada del Gobierno del Estado</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Junta de Caminos del Estado de Michoacán') echo 'selected="selected"'; ?> value="Junta de Caminos del Estado de Michoacán">Junta de Caminos del Estado de Michoacán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Junta Local de Conciliación y Arbitraje') echo 'selected="selected"'; ?> value="Junta Local de Conciliación y Arbitraje">Junta Local de Conciliación y Arbitraje</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Parque Zoológico Benito Juárez') echo 'selected="selected"'; ?> value="Parque Zoológico Benito Juárez">Parque Zoológico Benito Juárez</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Pensiones Civiles del Estad') echo 'selected="selected"'; ?> value="Pensiones Civiles del Estado">Pensiones Civiles del Estado</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Acuitzio') echo 'selected="selected"'; ?> value="Presidencia Municipal de Acuitzio">Presidencia Municipal de Acuitzio</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Aguililla') echo 'selected="selected"'; ?> value="Presidencia Municipal de Aguililla">Presidencia Municipal de Aguililla</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Álvaro Obregó') echo 'selected="selected"'; ?> value="Presidencia Municipal de Álvaro Obregón">Presidencia Municipal de Álvaro Obregón</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Angamacutiro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Angamacutiro">Presidencia Municipal de Angamacutiro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Angangue') echo 'selected="selected"'; ?> value="Presidencia Municipal de Angangueo">Presidencia Municipal de Angangueo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Apatzingán') echo 'selected="selected"'; ?> value="Presidencia Municipal de Apatzingán">Presidencia Municipal de Apatzingán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Aquil') echo 'selected="selected"'; ?> value="Presidencia Municipal de Aquila">Presidencia Municipal de Aquila</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Ario') echo 'selected="selected"'; ?> value="Presidencia Municipal de Ario">Presidencia Municipal de Ario</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Arteaga') echo 'selected="selected"'; ?> value="Presidencia Municipal de Arteaga">Presidencia Municipal de Arteaga</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Briseñas') echo 'selected="selected"'; ?> value="Presidencia Municipal de Briseñas">Presidencia Municipal de Briseñas</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Buenavista') echo 'selected="selected"'; ?> value="Presidencia Municipal de Buenavista">Presidencia Municipal de Buenavista</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Carácuaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Carácuaro">Presidencia Municipal de Carácuaro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Charapan') echo 'selected="selected"'; ?> value="Presidencia Municipal de Charapan">Presidencia Municipal de Charapan</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Charo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Charo">Presidencia Municipal de Charo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Chavinda') echo 'selected="selected"'; ?> value="Presidencia Municipal de Chavinda">Presidencia Municipal de Chavinda</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Cheran') echo 'selected="selected"'; ?> value="Presidencia Municipal de Cheran">Presidencia Municipal de Cheran</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Chilchota') echo 'selected="selected"'; ?> value="Presidencia Municipal de Chilchota">Presidencia Municipal de Chilchota</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Chucándiro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Chucándiro">Presidencia Municipal de Chucándiro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Churintzio') echo 'selected="selected"'; ?> value="Presidencia Municipal de Churintzio">Presidencia Municipal de Churintzio</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Coeneo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Coeneo">Presidencia Municipal de Coeneo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Cotija') echo 'selected="selected"'; ?> value="Presidencia Municipal de Cotija">Presidencia Municipal de Cotija</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Cuitzeo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Cuitzeo">Presidencia Municipal de Cuitzeo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Ecuandureo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Ecuandureo">Presidencia Municipal de Ecuandureo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Epitacio Huerta') echo 'selected="selected"'; ?> value="Presidencia Municipal de Epitacio Huerta">Presidencia Municipal de Epitacio Huerta</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Erongarícuaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Erongarícuaro">Presidencia Municipal de Erongarícuaro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Gabriel Zamora') echo 'selected="selected"'; ?> value="Presidencia Municipal de Gabriel Zamora">Presidencia Municipal de Gabriel Zamora</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Hidalgo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Hidalgo">Presidencia Municipal de Hidalgo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Huandacareo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Huandacareo">Presidencia Municipal de Huandacareo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Huaniqueo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Huaniqueo">Presidencia Municipal de Huaniqueo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Huetamo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Huetamo">Presidencia Municipal de Huetamo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Huiramba') echo 'selected="selected"'; ?> value="Presidencia Municipal de Huiramba">Presidencia Municipal de Huiramba</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Indaparapeo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Indaparapeo">Presidencia Municipal de Indaparapeo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Irimbo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Irimbo">Presidencia Municipal de Irimbo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Ixtlán') echo 'selected="selected"'; ?> value="Presidencia Municipal de Ixtlán">Presidencia Municipal de Ixtlán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Jacona') echo 'selected="selected"'; ?> value="Presidencia Municipal de Jacona">Presidencia Municipal de Jacona</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Jiménez') echo 'selected="selected"'; ?> value="Presidencia Municipal de Jiménez">Presidencia Municipal de Jiménez</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Jiquilpan') echo 'selected="selected"'; ?> value="Presidencia Municipal de Jiquilpan">Presidencia Municipal de Jiquilpan</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de José Sixto Verduzco') echo 'selected="selected"'; ?> value="Presidencia Municipal de José Sixto Verduzco">Presidencia Municipal de José Sixto Verduzco</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Jungapeo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Jungapeo">Presidencia Municipal de Jungapeo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de La Huacana') echo 'selected="selected"'; ?> value="Presidencia Municipal de La Huacana">Presidencia Municipal de la Huacana</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de La Piedad') echo 'selected="selected"'; ?> value="Presidencia Municipal de La Piedad">Presidencia Municipal de la Piedad</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Lagunillas') echo 'selected="selected"'; ?> value="Presidencia Municipal de Lagunillas">Presidencia Municipal de Lagunillas</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Lázaro Cárdenas') echo 'selected="selected"'; ?> value="Presidencia Municipal de Lázaro Cárdenas">Presidencia Municipal de Lázaro Cárdenas</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Los Reyes') echo 'selected="selected"'; ?> value="Presidencia Municipal de Los Reyes">Presidencia Municipal de los Reyes</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Madero') echo 'selected="selected"'; ?> value="Presidencia Municipal de Madero">Presidencia Municipal de Madero</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Maravatío') echo 'selected="selected"'; ?> value="Presidencia Municipal de Maravatío">Presidencia Municipal de Maravatío</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Marcos Castellanos') echo 'selected="selected"'; ?> value="Presidencia Municipal de Marcos Castellanos">Presidencia Municipal de Marcos Castellanos</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Morelia') echo 'selected="selected"'; ?> value="Presidencia Municipal de Morelia">Presidencia Municipal de Morelia</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Morelos') echo 'selected="selected"'; ?> value="Presidencia Municipal de Morelos">Presidencia Municipal de Morelos</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Múgica') echo 'selected="selected"'; ?> value="Presidencia Municipal de Múgica">Presidencia Municipal de Múgica</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Nahuatzen') echo 'selected="selected"'; ?> value="Presidencia Municipal de Nahuatzen">Presidencia Municipal de Nahuatzen</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Nocupétaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Nocupétaro">Presidencia Municipal de Nocupétaro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Nuevo Parangaricutiro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Nuevo Parangaricutiro">Presidencia Municipal de Nuevo Parangaricutiro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Nuevo Urecho') echo 'selected="selected"'; ?> value="Presidencia Municipal de Nuevo Urecho">Presidencia Municipal de Nuevo Urecho</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Numarán') echo 'selected="selected"'; ?> value="Presidencia Municipal de Numarán">Presidencia Municipal de Numarán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Ocampo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Ocampo">Presidencia Municipal de Ocampo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Pajacuarán') echo 'selected="selected"'; ?> value="Presidencia Municipal de Pajacuarán">Presidencia Municipal de Pajacuarán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Panindícuaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Panindícuaro">Presidencia Municipal de Panindícuaro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Paracho') echo 'selected="selected"'; ?> value="Presidencia Municipal de Paracho">Presidencia Municipal de Paracho</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Pátzcuaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Pátzcuaro">Presidencia Municipal de Pátzcuaro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Penjamillo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Penjamillo">Presidencia Municipal de Penjamillo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Peribán') echo 'selected="selected"'; ?> value="Presidencia Municipal de Peribán">Presidencia Municipal de Peribán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Purépero') echo 'selected="selected"'; ?> value="Presidencia Municipal de Purépero">Presidencia Municipal de Purépero</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Puruándiro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Puruándiro">Presidencia Municipal de Puruándiro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Queréndaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Queréndaro">Presidencia Municipal de Queréndaro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Quiroga') echo 'selected="selected"'; ?> value="Presidencia Municipal de Quiroga">Presidencia Municipal de Quiroga</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Sahuayo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Sahuayo">Presidencia Municipal de Sahuayo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Salvador Escalante') echo 'selected="selected"'; ?> value="Presidencia Municipal de Salvador Escalante">Presidencia Municipal de Salvador Escalante</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Santa Ana Maya') echo 'selected="selected"'; ?> value="Presidencia Municipal de Santa Ana Maya">Presidencia Municipal de Santa Ana Maya</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Senguio') echo 'selected="selected"'; ?> value="Presidencia Municipal de Senguio">Presidencia Municipal de Senguio</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tacámbaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tacámbaro">Presidencia Municipal de Tacámbaro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tancítaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tancítaro">Presidencia Municipal de Tancítaro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tangamandapio') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tangamandapio">Presidencia Municipal de Tangamandapio</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tangancicuaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tangancicuaro">Presidencia Municipal de Tangancicuaro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tanhuato') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tanhuato">Presidencia Municipal de Tanhuato</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Taretan') echo 'selected="selected"'; ?> value="Presidencia Municipal de Taretan">Presidencia Municipal de Taretan</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tarímbaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tarímbaro">Presidencia Municipal de Tarímbaro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tepalcatepec') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tepalcatepec">Presidencia Municipal de Tepalcatepec</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tingambato') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tingambato">Presidencia Municipal de Tingambato</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tingüindín') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tingüindín">Presidencia Municipal de Tingüindín</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tiquicheo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tiquicheo">Presidencia Municipal de Tiquicheo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tlalpujahua') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tlalpujahua">Presidencia Municipal de Tlalpujahua</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tlazazalca') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tlazazalca">Presidencia Municipal de Tlazazalca</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tocumbo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tocumbo">Presidencia Municipal de Tocumbo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tuxpan') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tuxpan">Presidencia Municipal de Tuxpan</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tuzantla') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tuzantla">Presidencia Municipal de Tuzantla</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tzintzuntzan') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tzintzuntzan">Presidencia Municipal de Tzintzuntzan</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Uruapan') echo 'selected="selected"'; ?> value="Presidencia Municipal de Uruapan">Presidencia Municipal de Uruapan</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Venustiano Carranza') echo 'selected="selected"'; ?> value="Presidencia Municipal de Venustiano Carranza">Presidencia Municipal de Venustiano Carranza</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Villamar') echo 'selected="selected"'; ?> value="Presidencia Municipal de Villamar">Presidencia Municipal de Villamar</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Vista Hermosa') echo 'selected="selected"'; ?> value="Presidencia Municipal de Vista Hermosa">Presidencia Municipal de Vista Hermosa</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Yurécuaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Yurécuaro">Presidencia Municipal de Yurécuaro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Zacapu') echo 'selected="selected"'; ?> value="Presidencia Municipal de Zacapu">Presidencia Municipal de Zacapu</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Zamora') echo 'selected="selected"'; ?> value="Presidencia Municipal de Zamora">Presidencia Municipal de Zamora</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Zináparo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Zináparo">Presidencia Municipal de Zináparo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Zinapécuaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Zinapécuaro">Presidencia Municipal de Zinapécuaro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Ziracuaretiro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Ziracuaretiro">Presidencia Municipal de Ziracuaretiro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Zitácuaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Zitácuaro">Presidencia Municipal de Zitácuaro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Procuraduría Agraria En Michoacán') echo 'selected="selected"'; ?> value="Procuraduría Agraria En Michoacán">Procuraduría Agraria En Michoacán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Procuraduría Auxiliar de la Defensa del Trabajo') echo 'selected="selected"'; ?> value="Procuraduría Auxiliar de la Defensa del Trabajo">Procuraduría Auxiliar de la Defensa del Trabajo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Procuraduría Federal de la Defensa del Trabajo') echo 'selected="selected"'; ?> value="Procuraduría Federal de la Defensa del Trabajo">Procuraduría Federal de la Defensa del Trabajo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Procuraduría Federal del Consumidor PROFECO') echo 'selected="selected"'; ?> value="Procuraduría Federal del Consumidor PROFECO">Procuraduría Federal del Consumidor PROFECO</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Quejas Sin Autoridad Señalada Como Responsable') echo 'selected="selected"'; ?> value="Quejas Sin Autoridad Señalada Como Responsable">Quejas Sin Autoridad Señalada Como Responsable</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Contraloría del Estado') echo 'selected="selected"'; ?> value="Secretaria de Contraloría del Estado">Secretaria de Contraloría del Estado</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaría de Secretaría de Bienesta') echo 'selected="selected"'; ?> value="Secretaría de Bienestar">Secretaría de Bienestar</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Secretaria de Comunicaciones y Obras Publicas') echo 'selected="selected"'; ?> value="Secretaria de Comunicaciones y Obras Publicas">Secretaria de Comunicaciones y Obras Publicas</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Secretaria de Comunicaciones y Transportes SCT') echo 'selected="selected"'; ?> value="Secretaria de Comunicaciones y Transportes SCT">Secretaria de Comunicaciones y Transportes SCT</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Cultura en el Estado') echo 'selected="selected"'; ?> value="Secretaria de Cultura en el Estado">Secretaria de Cultura en el Estado</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Desarrollo Económico') echo 'selected="selected"'; ?> value="Secretaria de Desarrollo Económico">Secretaria de Desarrollo Económico</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Desarrollo Rural y Agroalimentario') echo 'selected="selected"'; ?> value="Secretaria de Desarrollo Rural y Agroalimentario">Secretaria de Desarrollo Rural y Agroalimentario</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaría de Desarrollo Social y Humano') echo 'selected="selected"'; ?> value="Secretaría de Desarrollo Social y Humano">Secretaría de Desarrollo Social y Humano</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Secretaria de Desarrollo Territorial Urbano y Movilidad') echo 'selected="selected"'; ?> value="Secretaria de Desarrollo Territorial Urbano y Movilidad">Secretaria de Desarrollo Territorial Urbano y Movilidad</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Educación del Estado') echo 'selected="selected"'; ?> value="Secretaria de Educación del Estado">Secretaria de Educación del Estado</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Educación Pública Federal') echo 'selected="selected"'; ?> value="Secretaria de Educación Pública Federal">Secretaria de Educación Pública Federal</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Finanzas y Administración') echo 'selected="selected"'; ?> value="Secretaria de Finanzas y Administración">Secretaria de Finanzas y Administración</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaría de Gobernación') echo 'selected="selected"'; ?> value="Secretaría de Gobernación">Secretaría de Gobernación</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Gobierno') echo 'selected="selected"'; ?> value="Secretaria de Gobierno">Secretaria de Gobierno</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Igualdad Sustantiva y Desarrollo de Las Mujeres Michoacanas') echo 'selected="selected"'; ?> value="Secretaria de Igualdad Sustantiva y Desarrollo de Las Mujeres Michoacanas">Secretaria de Igualdad Sustantiva y Desarrollo de Las Mujeres Michoacanas</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de la Defensa Nacional Ejercito Mexicano') echo 'selected="selected"'; ?> value="Secretaria de la Defensa Nacional Ejercito Mexicano">Secretaria de la Defensa Nacional Ejercito Mexicano</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de los Migrantes En El Extranjero') echo 'selected="selected"'; ?> value="Secretaria de los Migrantes En El Extranjero">Secretaria de los Migrantes En El Extranjero</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Marina y Armada de México') echo 'selected="selected"'; ?> value="Secretaria de Marina y Armada de México">Secretaria de Marina y Armada de México</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Relaciones Exteriores SRE') echo 'selected="selected"'; ?> value="Secretaria de Relaciones Exteriores SRE">Secretaria de Relaciones Exteriores SRE</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Salud') echo 'selected="selected"'; ?> value="Secretaria de Salud">Secretaria de Salud</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Seguridad Publica Estatal') echo 'selected="selected"'; ?> value="Secretaria de Seguridad Publica Estatal">Secretaria de Seguridad Publica Estatal</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Seguridad Publica Federal') echo 'selected="selected"'; ?> value="Secretaria de Seguridad Publica Federal">Secretaria de Seguridad Publica Federal</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Seguridad y Protección Ciudadana') echo 'selected="selected"'; ?> value="Secretaria de Seguridad y Protección Ciudadana">Secretaria de Seguridad y Protección Ciudadana</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria del Trabajo y Previsión Social') echo 'selected="selected"'; ?> value="Secretaria del Trabajo y Previsión Social">Secretaria del Trabajo y Previsión Social</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Sistema Integral de Financiamiento para el Desarrollo de Michoacán Si Financia') echo 'selected="selected"'; ?> value="Sistema Integral de Financiamiento para el Desarrollo de Michoacán Si Financia">Sistema Integral de Financiamiento para el Desarrollo de Michoacán Si Financia</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Sistema Michoacano de Radio y Televisión') echo 'selected="selected"'; ?> value="Sistema Michoacano de Radio y Televisión">Sistema Michoacano de Radio y Televisión</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Sistema Para el Desarrollo Integral de la Familia DIF') echo 'selected="selected"'; ?> value="Sistema Para el Desarrollo Integral de la Familia DIF">Sistema Para el Desarrollo Integral de la Familia DIF</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Supremo Tribunal de Justicia') echo 'selected="selected"'; ?> value="Supremo Tribunal de Justicia">Supremo Tribunal de Justicia</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Telebachillerato de Michoacán') echo 'selected="selected"'; ?> value="Telebachillerato de Michoacán">Telebachillerato de Michoacán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Tribunal de Conciliación y Arbitraje del Estado de Michoacán') echo 'selected="selected"'; ?> value="Tribunal de Conciliación y Arbitraje del Estado de Michoacán">Tribunal de Conciliación y Arbitraje del Estado de Michoacán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Tribunal de Justicia Administrativa del Estado de Michoacán') echo 'selected="selected"'; ?> value="Tribunal de Justicia Administrativa del Estado de Michoacán">Tribunal de Justicia Administrativa del Estado de Michoacán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Universidad Intercultural Indígena de Michoacán') echo 'selected="selected"'; ?> value="Universidad Intercultural Indígena de Michoacán">Universidad Intercultural Indígena de Michoacán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Universidad Michoacana de San Nicolas de Hidalgo UMSNH') echo 'selected="selected"'; ?> value="Universidad Michoacana de San Nicolas de Hidalgo UMSNH">Universidad Michoacana de San Nicolas de Hidalgo UMSNH</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Universidad Virtual del Estado de Michoacán') echo 'selected="selected"'; ?> value="Universidad Virtual del Estado de Michoacán">Universidad Virtual del Estado de Michoacán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Visitaduría Morelia') echo 'selected="selected"'; ?> value="Visitaduría Morelia">Visitaduría Morelia</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Visitaduría Uruapan') echo 'selected="selected"'; ?> value="Visitaduría Uruapan">Visitaduría Uruapan</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tzitzio') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tzitzio">Presidencia Municipal de Tzitzio</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="quien_presenta">Nombre de quien presenta la queja</label>
                            <input type="text" class="form-control" name="quien_presenta" value="<?php echo remove_junk($e_ficha['quien_presenta']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nombre_usuario">Nombre del usuario</label>
                            <input type="text" class="form-control" name="nombre_usuario" value="<?php echo remove_junk($e_ficha['nombre_usuario']); ?>">
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="parentesco">Parentesco</label>
                            <select class="form-control" name="parentesco">
                                <option value="">Elige una opción</option>
                                <option <?php if ($e_ficha['parentesco'] === 'Hijo(a)') echo 'selected="selected"'; ?> value="Hijo(a)">Hijo(a)</option>
                                <option <?php if ($e_ficha['parentesco'] === 'Padre') echo 'selected="selected"'; ?> value="Padre">Padre</option>
                                <option <?php if ($e_ficha['parentesco'] === 'Madre') echo 'selected="selected"'; ?> value="Madre">Madre</option>
                                <option <?php if ($e_ficha['parentesco'] === 'Abuelo(a)') echo 'selected="selected"'; ?> value="Abuelo(a)">Abuelo(a)</option>
                                <option <?php if ($e_ficha['parentesco'] === 'Nieto(a)') echo 'selected="selected"'; ?> value="Nieto(a)">Nieto(a)</option>
                                <option <?php if ($e_ficha['parentesco'] === 'Hermano(a)') echo 'selected="selected"'; ?> value="Hermano(a)">Hermano(a)</option>
                                <option <?php if ($e_ficha['parentesco'] === 'Bisabuelo(a)') echo 'selected="selected"'; ?> value="Bisabuelo(a)">Bisabuelo(a)</option>
                                <option <?php if ($e_ficha['parentesco'] === 'Bisnieto(a)') echo 'selected="selected"'; ?> value="Bisnieto(a)">Bisnieto(a)</option>
                                <option <?php if ($e_ficha['parentesco'] === 'Tío(a)') echo 'selected="selected"'; ?> value="Tío(a)">Tío(a)</option>
                                <option <?php if ($e_ficha['parentesco'] === 'Sobrino(a)') echo 'selected="selected"'; ?> value="Sobrino(a)">Sobrino(a)</option>
                                <option <?php if ($e_ficha['parentesco'] === 'Tatarabuelo(a)') echo 'selected="selected"'; ?> value="Tatarabuelo(a)">Tatarabuelo(a)</option>
                                <option <?php if ($e_ficha['parentesco'] === 'Tataranieto(a)') echo 'selected="selected"'; ?> value="Tataranieto(a)">Tataranieto(a)</option>
                                <option <?php if ($e_ficha['parentesco'] === 'Primo(a)') echo 'selected="selected"'; ?> value="Primo(a)">Primo(a)</option>
                                <option <?php if ($e_ficha['parentesco'] === 'Suegro(a)') echo 'selected="selected"'; ?> value="Suegro(a)">Suegro(a)</option>
                                <option <?php if ($e_ficha['parentesco'] === 'Yerno') echo 'selected="selected"'; ?> value="Yerno">Yerno</option>
                                <option <?php if ($e_ficha['parentesco'] === 'Nuera') echo 'selected="selected"'; ?> value="Nuera">Nuera</option>
                                <option <?php if ($e_ficha['parentesco'] === 'Abuelo(a) del cónyugue') echo 'selected="selected"'; ?> value="Abuelo(a) del cónyugue">Abuelo(a) del cónyugue</option>
                                <option <?php if ($e_ficha['parentesco'] === 'Hermano(a) del cónyugue') echo 'selected="selected"'; ?> value="Hermano(a) del cónyugue">Hermano(a) del cónyugue</option>
                                <option <?php if ($e_ficha['parentesco'] === 'Sobrino(a) del cónyugue') echo 'selected="selected"'; ?> value="Sobrino(a) del cónyugue">Sobrino del cónyugue</option>
                                <option <?php if ($e_ficha['parentesco'] === 'Tío(a) del cónyugue') echo 'selected="selected"'; ?> value="Tío(a) del cónyugue">Tío del cónyugue</option>
                                <option <?php if ($e_ficha['parentesco'] === 'Bisabuelo(a) del cónyugue') echo 'selected="selected"'; ?> value="Bisabuelo(a) del cónyugue">Bisabuelo del cónyugue</option>
                                <option <?php if ($e_ficha['parentesco'] === 'Primo(a) del cónyugue') echo 'selected="selected"'; ?> value="Primo(a) del cónyugue">Primo(a) del cónyugue</option>
                                <option <?php if ($e_ficha['parentesco'] === 'Tatarabuelo(a) del cónyugue') echo 'selected="selected"'; ?> value="Tatarabuelo(a) del cónyugue">tatarabuelo(a) del cónyugue</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="edad">Edad</label>
                            <input type="number" class="form-control" min="1" max="120" name="edad" value="<?php echo remove_junk($e_ficha['edad']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" name="fecha_nacimiento" value="<?php echo remove_junk($e_ficha['fecha_nacimiento']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="sexo">Sexo</label>
                            <select class="form-control" name="sexo">
                                <option <?php if ($e_ficha['sexo'] === 'Mujer') echo 'selected="selected"'; ?> value="Mujer">Mujer</option>
                                <option <?php if ($e_ficha['sexo'] === 'Hombre') echo 'selected="selected"'; ?> value="Hombre">Hombre</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="grupo_vulnerable">Grupo Vulnerable</label>
                            <select class="form-control" name="grupo_vulnerable">
                                <option value="">Elige una opción</option>
                                <option <?php if ($e_ficha['grupo_vulnerable'] === 'Comunidad LGBT') echo 'selected="selected"'; ?> value="Comunidad LGBT">Comunidad LGBT</option>
                                <option <?php if ($e_ficha['grupo_vulnerable'] === 'Derecho de las mujeres') echo 'selected="selected"'; ?> value="Derecho de las mujeres">Derecho de las mujeres</option>
                                <option <?php if ($e_ficha['grupo_vulnerable'] === 'Niños y adolescentes') echo 'selected="selected"'; ?> value="Niños y adolescentes">Niños y adolecentes</option>
                                <option <?php if ($e_ficha['grupo_vulnerable'] === 'Personas con discapacidad') echo 'selected="selected"'; ?> value="Personas con discapacidad">Personas con discapacidad</option>
                                <option <?php if ($e_ficha['grupo_vulnerable'] === 'Personas migrantes') echo 'selected="selected"'; ?> value="Personas migrantes">Personas migrantes</option>
                                <option <?php if ($e_ficha['grupo_vulnerable'] === 'Personas que viven con VIH SIDA') echo 'selected="selected"'; ?> value="Personas que viven con VIH SIDA">Personas que viven con VIH SIDA</option>
                                <option <?php if ($e_ficha['grupo_vulnerable'] === 'Grupos indígenas') echo 'selected="selected"'; ?> value="Grupos indígenas">Grupos indígenas</option>
                                <option <?php if ($e_ficha['grupo_vulnerable'] === 'Periodistas') echo 'selected="selected"'; ?> value="Periodistas">Periodistas</option>
                                <option <?php if ($e_ficha['grupo_vulnerable'] === 'Defensores de los derechos humanos') echo 'selected="selected"'; ?> value="Defensores de los derechos humanos">Defensores de los derechos humanos</option>
                                <option <?php if ($e_ficha['grupo_vulnerable'] === 'Adultos mayores') echo 'selected="selected"'; ?> value="Adultos mayores">Adultos mayores</option>
                                <option <?php if ($e_ficha['grupo_vulnerable'] === 'Internos') echo 'selected="selected"'; ?> value="Internos">Internos</option>
                                <option <?php if ($e_ficha['grupo_vulnerable'] === 'Otros') echo 'selected="selected"'; ?> value="Otros">Otros</option>
                            </select>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                <div class="col-md-4">
                        <div class="form-group">
                            <label for="tutor">Nombre de tutor</label>
                            <input type="text" class="form-control" value="<?php echo remove_junk($e_ficha['tutor']); ?>" name="tutor">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="contacto">Número de contacto</label>
                            <input type="text" class="form-control" maxlength="10" value="<?php echo remove_junk($e_ficha['contacto']); ?>" name="contacto">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha_intervencion">Fecha de Intervención</label>
                            <input type="date" class="form-control" value="<?php echo remove_junk($e_ficha['fecha_intervencion']); ?>" name="fecha_intervencion" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="hora_lugar">Hora y lugar de Intervención</label>
                            <textarea type="text" class="form-control" value="<?php echo remove_junk($e_ficha['hora_lugar']); ?>" name="hora_lugar" cols="50" rows="1"><?php echo remove_junk($e_ficha['hora_lugar']); ?></textarea>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                <div class="col-md-6">
                        <div class="form-group">
                            <label for="actividad_realizada">Actividad realizada</label>
                            <textarea type="text" class="form-control" value="<?php echo remove_junk($e_ficha['actividad_realizada']); ?>" name="actividad_realizada" cols="50" rows="1"><?php echo remove_junk($e_ficha['actividad_realizada']); ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="observaciones">Observaciones Generales</label>
                            <textarea type="text" class="form-control" name="observaciones" value="<?php echo remove_junk($e_ficha['observaciones']); ?>" cols="30" rows="1"><?php echo remove_junk($e_ficha['observaciones']); ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="fichas.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="edit_ficha" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>