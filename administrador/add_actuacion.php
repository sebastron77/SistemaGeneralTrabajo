<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar Actuación';
require_once('includes/load.php');
$id_folio = last_id_folios();
// $queja = find_by_id_quejas((int)$_GET['id']);
$user = current_user();
$nivel_user = $user['user_level'];
$id_user = $user['id'];
$areas = find_all('area');
$area_user = area_usuario2($id_user);
$area = $area_user['nombre_area'];

if ($nivel_user <= 2) {
    page_require_level(2);
}
if ($nivel_user == 5) {
    page_require_level_exacto(5);
}
if ($nivel_user == 7) {
    page_require_level_exacto(7);
}
if ($nivel_user > 2 && $nivel_user < 5) :
    redirect('home.php');
endif;
if ($nivel_user > 5 && $nivel_user < 7) :
    redirect('home.php');
endif;
if ($nivel_user > 7) :
    redirect('home.php');
endif;
?>
<?php header('Content-type: text/html; charset=utf-8');

if (isset($_POST['add_actuacion'])) {

    $req_fields = array('catalogo_actas', 'peticion');
    validate_fields($req_fields);

    if (empty($errors)) {
        $fecha_captura_acta = remove_junk($db->escape($_POST['fecha_captura_acta']));
        $catalogo_actas   = remove_junk($db->escape($_POST['catalogo_actas']));
        $descripcion   = remove_junk($db->escape($_POST['descripcion']));
        $autoridades   = remove_junk($db->escape($_POST['autoridades']));
        $autoridades_federales   = remove_junk($db->escape($_POST['autoridades_federales']));
        $peticion   = remove_junk($db->escape($_POST['peticion']));
        date_default_timezone_set('America/Mexico_City');
        $fecha_creacion_sistema = date('Y-m-d');

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
        $folio = 'CEDH/' . $no_folio1 . '/' . $year . '-ACT';

        $folio_carpeta = 'CEDH-' . $no_folio1 . '-' . $year . '-ACT';
        $carpeta = 'uploads/actuaciones/' . $folio_carpeta;

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $name = $_FILES['adjunto']['name'];
        $size = $_FILES['adjunto']['size'];
        $type = $_FILES['adjunto']['type'];
        $temp = $_FILES['adjunto']['tmp_name'];

        $move =  move_uploaded_file($temp, $carpeta . "/" . $name);

        if ($move && $name != '') {
            $query = "INSERT INTO actuaciones (";
            $query .= "folio_actuacion,fecha_captura_acta,catalogo,descripcion,autoridades,autoridades_federales,peticion,adjunto,fecha_creacion_sistema,area_creacion";
            $query .= ") VALUES (";
            $query .= " '{$folio}','{$fecha_captura_acta}','{$catalogo_actas}','{$descripcion}','{$autoridades}','{$autoridades_federales}','{$peticion}','{$name}','{$fecha_creacion_sistema}','{$area}'";
            $query .= ")";

            $query2 = "INSERT INTO folios (";
            $query2 .= "folio, contador";
            $query2 .= ") VALUES (";
            $query2 .= " '{$folio}','{$no_folio1}'";
            $query2 .= ")";
        } else {
            $query = "INSERT INTO actuaciones (";
            $query .= "folio_actuacion,fecha_captura_acta,catalogo,descripcion,autoridades,autoridades_federales,peticion,fecha_creacion_sistema,area_creacion";
            $query .= ") VALUES (";
            $query .= " '{$folio}','{$fecha_captura_acta}','{$catalogo_actas}','{$descripcion}','{$autoridades}','{$autoridades_federales}','{$peticion}','{$fecha_creacion_sistema}','{$area}'";
            $query .= ")";

            $query2 = "INSERT INTO folios (";
            $query2 .= "folio, contador";
            $query2 .= ") VALUES (";
            $query2 .= " '{$folio}','{$no_folio1}'";
            $query2 .= ")";
        }
        if ($db->query($query) && $db->query($query2)) {
            //sucess
            $session->msg('s', " La actuación ha sido agregada con éxito.");
            redirect('actuaciones.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar la actuación.');
            redirect('add_actuacion.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_actuacion.php', false);
    }
}
?>
<script languague="javascript">
    function mostrar() {
        div = document.getElementById('flotante');
        div.style.display = '';
    }

    function cerrar() {
        div = document.getElementById('flotante');
        div.style.display = 'none';
    }

    function mostrar2() {
        div = document.getElementById('flotante2');
        div.style.display = '';
    }

    function cerrar2() {
        div = document.getElementById('flotante2');
        div.style.display = 'none';
    }

    function mostrar3() {
        div = document.getElementById('flotante3');
        div.style.display = '';
    }

    function cerrar3() {
        div = document.getElementById('flotante3');
        div.style.display = 'none';
    }
</script>
<?php header('Content-type: text/html; charset=utf-8');
include_once('layouts/header.php'); ?>
<?php echo display_msg($msg); ?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Agregar actuación</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_actuacion.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <div id="flotante" style=" background-color: #EBEBEB; display:none; border-radius: 8px;">
                                <div id="close" align="right" style="margin-bottom: -15px;">
                                    <svg onclick="javascript:cerrar();" style="width:24px;height:24px" viewBox="0 0 24 24">
                                        <path fill="red" d="M13.46,12L19,17.54V19H17.54L12,13.46L6.46,19H5V17.54L10.54,12L5,6.46V5H6.46L12,10.54L17.54,5H19V6.46L13.46,12Z" />
                                    </svg>
                                </div>
                                Fecha en que fué capturada la actuación.
                            </div>
                            <label for="fecha_captura_acta">Fecha de captura de actuación</label>
                            <svg onclick="javascript:mostrar();" style="width:20px;height:20px" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M15.07,11.25L14.17,12.17C13.45,12.89 13,13.5 13,15H11V14.5C11,13.39 11.45,12.39 12.17,11.67L13.41,10.41C13.78,10.05 14,9.55 14,9C14,7.89 13.1,7 12,7A2,2 0 0,0 10,9H8A4,4 0 0,1 12,5A4,4 0 0,1 16,9C16,9.88 15.64,10.67 15.07,11.25M13,19H11V17H13M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12C22,6.47 17.5,2 12,2Z" />
                            </svg><br>
                            <input type="date" class="form-control" name="fecha_captura_acta">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="catalogo_actas">Tipo de actuación</label>
                            <select class="form-control" name="catalogo_actas">
                                <option value="">Elige una opción</option>
                                <option value="Acta Circunstanciada">Acta Circunstanciada</option>
                                <option value="Acompañamientos">Acompañamientos</option>
                                <option value="Solicitud de Información">Solicitud de Información</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <div id="flotante2" style=" background-color: #EBEBEB; display:none; border-radius: 8px;">
                                <div id="close2" align="right" style="margin-bottom: -15px;">
                                    <svg onclick="javascript:cerrar2();" style="width:24px;height:24px" viewBox="0 0 24 24">
                                        <path fill="red" d="M13.46,12L19,17.54V19H17.54L12,13.46L6.46,19H5V17.54L10.54,12L5,6.46V5H6.46L12,10.54L17.54,5H19V6.46L13.46,12Z" />
                                    </svg>
                                </div>
                                Catálogo estatal de autoridades señaladas.
                            </div>
                            <label for="autoridades">Autoridad señalada (Estatal)</label>
                            <svg onclick="javascript:mostrar2();" style="width:20px;height:20px" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M15.07,11.25L14.17,12.17C13.45,12.89 13,13.5 13,15H11V14.5C11,13.39 11.45,12.39 12.17,11.67L13.41,10.41C13.78,10.05 14,9.55 14,9C14,7.89 13.1,7 12,7A2,2 0 0,0 10,9H8A4,4 0 0,1 12,5A4,4 0 0,1 16,9C16,9.88 15.64,10.67 15.07,11.25M13,19H11V17H13M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12C22,6.47 17.5,2 12,2Z" />
                            </svg><br>
                            <select class="form-control" name="autoridades">
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
                        <div id="flotante3" style=" background-color: #EBEBEB; display:none; border-radius: 8px;">
                                <div id="close3" align="right" style="margin-bottom: -15px;">
                                    <svg onclick="javascript:cerrar3();" style="width:24px;height:24px" viewBox="0 0 24 24">
                                        <path fill="red" d="M13.46,12L19,17.54V19H17.54L12,13.46L6.46,19H5V17.54L10.54,12L5,6.46V5H6.46L12,10.54L17.54,5H19V6.46L13.46,12Z" />
                                    </svg>
                                </div>
                                Catálogo federal de autoridades señaladas.
                            </div>
                            <label for="autoridades_federales">Autoridad Señalada (Federal)</label>
                            <svg onclick="javascript:mostrar3();" style="width:20px;height:20px" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M15.07,11.25L14.17,12.17C13.45,12.89 13,13.5 13,15H11V14.5C11,13.39 11.45,12.39 12.17,11.67L13.41,10.41C13.78,10.05 14,9.55 14,9C14,7.89 13.1,7 12,7A2,2 0 0,0 10,9H8A4,4 0 0,1 12,5A4,4 0 0,1 16,9C16,9.88 15.64,10.67 15.07,11.25M13,19H11V17H13M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12C22,6.47 17.5,2 12,2Z" />
                            </svg><br>
                            <select class="form-control" name="autoridades_federales">
                                <option value="">Escoge una opción</option>
                                <option value="Otra">Otra</option>
                                <option value="Colegio Nacional de Educación Profesional Técnica CONALEP">Colegio Nacional de Educación Profesional Técnica CONALEP</option>
                                <option value="Comisión Nacional de los Derechos Humanos CNDH">Comisión Nacional de los Derechos Humanos CNDH</option>
                                <option value="Comisión Nacional del Agua CONAGUA">Comisión Nacional del Agua CONAGUA</option>
                                <option value="Comisión Nacional Para la Protección y Defensa de los Usuarios de Servicios Financieros CONDUSEF">Comisión Nacional Para la Protección y Defensa de los Usuarios de Servicios Financieros CONDUSEF</option>
                                <option value="Comisión Para la Regularización de la Tenencia de la Tierra CORETT">Comisión Para la Regularización de la Tenencia de la Tierra CORETT</option>
                                <option value="Consejería Jurídica del Ejecutivo del Estado">Consejería Jurídica del Ejecutivo del Estado</option>
                                <option value="Consejo Nacional Para Prevenir la Discriminación">Consejo Nacional Para Prevenir la Discriminación</option>
                                <option value="Coordinación de Comunicación Social">Coordinación de Comunicación Social</option>
                                <option value="Junta de Caminos del Estado de Michoacán">Junta de Caminos del Estado de Michoacán</option>
                                <option value="Junta Local de Conciliación y Arbitraje">Junta Local de Conciliación y Arbitraje</option>
                                <option value="Parque Zoológico Benito Juárez">Parque Zoológico Benito Juárez</option>
                                <option value="Defensoría Publica Federal">Defensoría Publica Federal</option>
                                <option value="Despacho del C. Gobernador">Despacho del C. Gobernador</option>
                                <option value="Dirección de Trabajo y Previsión Social">Dirección de Trabajo y Previsión Social</option>
                                <option value="Dirección General de Educación Tecnológica Industrial DGTI">Dirección General de Educación Tecnológica Industrial DGTI</option>
                                <option value="Dirección General de Institutos Tecnológicos">Dirección General de Institutos Tecnológicos</option>
                                <option value="Fiscalía General de la República">Fiscalía General de la República</option>
                                <option value="FOVISSSTE Michoacán">FOVISSSTE Michoacán</option>
                                <option value="Honorable Congreso del Estado de Michoacán">Honorable Congreso del Estado de Michoacán</option>
                                <option value="Instituto de Seguridad y Servicios Sociales de los Trabajadores al Servicio del Estado">Instituto de Seguridad y Servicios Sociales de los Trabajadores al Servicio del Estado</option>
                                <option value="Instituto del Fondo Nacional de la Vivienda Para los Trabajadores INFONAVIT">Instituto del Fondo Nacional de la Vivienda Para los Trabajadores INFONAVIT</option>
                                <option value="Instituto Electoral de Michoacán">Instituto Electoral de Michoacán</option>
                                <option value="Instituto Mexicano del Seguro Social IMSS">Instituto Mexicano del Seguro Social IMSS</option>
                                <option value="Instituto Nacional de Educación Para los Adultos INEA">Instituto Nacional de Educación Para los Adultos INEA</option>
                                <option value="Instituto Nacional de Migración">Instituto Nacional de Migración</option>
                                <option value="Procuraduría Agraria En Michoacán">Procuraduría Agraria En Michoacán</option>
                                <option value="Procuraduría Auxiliar de la Defensa del Trabajo">Procuraduría Auxiliar de la Defensa del Trabajo</option>
                                <option value="Procuraduría Federal de la Defensa del Trabajo">Procuraduría Federal de la Defensa del Trabajo</option>
                                <option value="Procuraduría Federal del Consumidor PROFECO">Procuraduría Federal del Consumidor PROFECO</option>
                                <option value="Secretaria de Comunicaciones y Transportes SCT">Secretaria de Comunicaciones y Transportes SCT</option>
                                <option value="Secretaria de Seguridad Publica Federal">Secretaria de Seguridad Publica Federal</option>
                                <option value="Secretaria de la Defensa Nacional Ejercito Mexicano">Secretaria de la Defensa Nacional Ejercito Mexicano</option>
                                <option value="Secretaria de Marina y Armada de México">Secretaria de Marina y Armada de México</option>
                                <option value="Secretaria de Relaciones Exteriores SRE">Secretaria de Relaciones Exteriores SRE</option>
                                <option value="Secretaria de Seguridad Publica Estatal">Secretaria de Seguridad Publica Estatal</option>
                                <option value="Secretaria de Seguridad y Protección Ciudadana">Secretaria de Seguridad y Protección Ciudadana</option>
                                <option value="Sistema Michoacano de Radio y Televisión">Sistema Michoacano de Radio y Televisión</option>
                                <option value="Universidad Michoacana de San Nicolas de Hidalgo UMSNH">Universidad Michoacana de San Nicolas de Hidalgo UMSNH</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="peticion">Peticion</label>
                            <select class="form-control" name="peticion">
                                <option value="">Elige una opción</option>
                                <option value="Nacional">Nacional</option>
                                <option value="Oficio">Oficio</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="descripcion">Descripción</label><br>
                            <textarea name="descripcion" class="form-control" id="descripcion" cols="50" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="adjunto">Adjuntar archivo</label>
                            <input type="file" accept="application/pdf" class="form-control" name="adjunto" id="adjunto">
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="actuaciones.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="add_actuacion" class="btn btn-primary" value="subir">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>