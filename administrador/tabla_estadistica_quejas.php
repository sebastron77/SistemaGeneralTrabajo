<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Estadística de Quejas';
require_once('includes/load.php');
?>
<?php
// page_require_level(4);
// $a_orientacion = find_by_id('capacitaciones', (int)$_GET['id']);
//$all_detalles = find_all_detalles_busqueda($_POST['consulta']);
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
// page_require_area(4);
$id_user = $user['id'];
$all_quejas = total_porAutoridad('quejas');

if ($nivel <= 2) {
    page_require_level(2);
}
if ($nivel == 3) {
    page_require_level(3);
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
    page_require_level_exacto(7);
}

$total_aeropuerto = count_by_aeropuerto('quejas');
$total_cobaem = count_by_cobaem('quejas');
$total_cecytem = count_by_cecytem('quejas');
$total_conalep = count_by_conalep('quejas');
$total_cocotra = count_by_cocotra('quejas');
$total_ceeav = count_by_ceeav('quejas');
$total_cecufid = count_by_cecufid('quejas');
$total_ceagc = count_by_ceagc('quejas');
$total_cfe = count_by_cfe('quejas');
$total_cndh = count_by_cndh4('quejas');
$total_conagua = count_by_conagua('quejas');
$total_condusef = count_by_condusef('quejas');
$total_corett = count_by_corett('quejas');
$total_cjee = count_by_cjee('quejas');
$total_cnpd = count_by_cnpd('quejas');
$total_ccs = count_by_ccs('quejas');
$total_cspem = count_by_cspem('quejas');
$total_dpf = count_by_dpf('quejas');
$total_dcg = count_by_dcg('quejas');
$total_drc = count_by_drc('quejas');
$total_dtps = count_by_dtps('quejas');
$total_dgti = count_by_dgti('quejas');
$total_dgit = count_by_dgit('quejas');
$total_fge = count_by_fge('quejas');
$total_fgr = count_by_fgr('quejas');
$total_fovissste = count_by_fovissste('quejas');
$total_hcem = count_by_hcem('quejas');
$total_idpe = count_by_idpe('quejas');
$total_injuve = count_by_injuve('quejas');
$total_issste = count_by_issste('quejas');
$total_ivem = count_by_ivem('quejas');
$total_infonavit = count_by_infonavit('quejas');
$total_iem = count_by_iem('quejas');
$total_imss = count_by_imss('quejas');
$total_imced = count_by_imced('quejas');
$total_inea = count_by_inea('quejas');
$total_inm = count_by_inm('quejas');
$total_japge = count_by_japge('quejas');
$total_jcem = count_by_jcem('quejas');
$total_jlca = count_by_jlca('quejas');
$total_zoo = count_by_zoo('quejas');
$total_pce = count_by_pce('quejas');
$total_pmacu = count_by_pmacu('quejas');
$total_pmag = count_by_pmag('quejas');
$total_pmao = count_by_pmao('quejas');
$total_pmangama = count_by_pmangama('quejas');
$total_pmangan = count_by_pmangan('quejas');
$total_pmapat = count_by_pmapat('quejas');
$total_pmaquila = count_by_pmaquila('quejas');
$total_pmario = count_by_pmario('quejas');
$total_pmart = count_by_pmart('quejas');
$total_pmbris = count_by_pmbris('quejas');
$total_pmbv = count_by_pmbv('quejas');
$total_pmcarac = count_by_pmcarac('quejas');
$total_pmcharapan = count_by_pmcharapan('quejas');
$total_pmcharo = count_by_pmcharo('quejas');
$total_pmchav = count_by_pmchav('quejas');
$total_pmcheran = count_by_cheran('quejas');
$total_pmchil = count_by_pmchil('quejas');
$total_pmchucan = count_by_pmchucan('quejas');
$total_pmchuri = count_by_pmchuri('quejas');
$total_pmcoah = count_by_pmcoah('quejas');
$total_pmcoeneo = count_by_pmcoeneo('quejas');
$total_pmcotija = count_by_pmcotija('quejas');
$total_pmcuitzeo = count_by_pmcuitzeo('quejas');
$total_pmecuan = count_by_pmecuan('quejas');
$total_pmeh = count_by_pmeh('quejas');
$total_pmeron = count_by_pmeron('quejas');
$total_pmzamora = count_by_pmzamora('quejas');
$total_pmhidalgo = count_by_pmhidalgo('quejas');
$total_pmhuanda = count_by_pmhuanda('quejas');
$total_pmhuani = count_by_pmhuani('quejas');
$total_pmhuet = count_by_pmhuet('quejas');
$total_pmhuiramba = count_by_pmhuiramba('quejas');
$total_pminda = count_by_pminda('quejas');
$total_pmirim = count_by_pmirim('quejas');
$total_pmixt = count_by_pmixt('quejas');
$total_pmjac = count_by_pmjac('quejas');
$total_pmjime = count_by_pmjime('quejas');
$total_pmjiq = count_by_pmjiq('quejas');
$total_pmsixver = count_by_pmsixver('quejas');
$total_pmjunga = count_by_pmjunga('quejas');
$total_pmhuac = count_by_pmhuac('quejas');
$total_pmlapiedad = count_by_pmlapiedad('quejas');
$total_pmlagu = count_by_pmlagu('quejas');
$total_pmlc = count_by_pmlc('quejas');
$total_pmlosreyes = count_by_pmlosreyes('quejas');
$total_pmmadero = count_by_pmmadero('quejas');
$total_pmmarav = count_by_pmmarav('quejas');
$total_pmmc = count_by_pmmc('quejas');
$total_pmmorelia = count_by_pmmorelia('quejas');
$total_pmmorelos = count_by_pmmorelos('quejas');
$total_pmmugica = count_by_pmmugica('quejas');
$total_pmnahuatzen = count_by_pmnahuatzen('quejas');
$total_pmnocu = count_by_pmnocu('quejas');
$total_pmnparan = count_by_pmnparan('quejas');
$total_pmnurecho = count_by_pmnurecho('quejas');
$total_pmnumaran = count_by_pmnumaran('quejas');
$total_pmocampo = count_by_pmocampo('quejas');
$total_pmpajacuaran = count_by_pmpajacuaran('quejas');
$total_pmpanin = count_by_pmpanin('quejas');
$total_pmparacho = count_by_pmparacho('quejas');
$total_pmpatz = count_by_pmpatz('quejas');
$total_pmpenja = count_by_pmpenja('quejas');
$total_pmperiban = count_by_pmperiban('quejas');
$total_pmpure = count_by_pmpure('quejas');
$total_pmpuruan = count_by_pmpuruan('quejas');
$total_pmqueren = count_by_pmqueren('quejas');
$total_pmquiroga = count_by_pmquiroga('quejas');
$total_pmsahuayo = count_by_pmsahuayo('quejas');
$total_pmsalvesc = count_by_pmsalvesc('quejas');
$total_pmsam = count_by_pmsam('quejas');
$total_pmseng = count_by_pmseng('quejas');
$total_pmtacam = count_by_pmtacam('quejas');
$total_pmtanc = count_by_pmtanc('quejas');
$total_pmtangamandapio = count_by_pmtangamandapio('quejas');
$total_pmtangancicuaro = count_by_pmtangancicuaro('quejas');
$total_pmtanhuato = count_by_pmtanhuato('quejas');
$total_pmtaretan = count_by_pmtaretan('quejas');
$total_pmtarimbaro = count_by_pmtarimbaro('quejas');
$total_tepalcatepec = count_by_pmtepalcatepec('quejas');
$total_pmtingambato = count_by_pmtingambato('quejas');
$total_pmtingu = count_by_pmtingu('quejas');
$total_pmtiqui = count_by_pmtiqui('quejas');
$total_pmtlalpu = count_by_pmtlalpu('quejas');
$total_pmtlaza = count_by_pmtlaza('quejas');
$total_pmtocumbo = count_by_pmtocumbo('quejas');
$total_pmtux = count_by_pmtux('quejas');
$total_pmtuzan = count_by_pmtuzan('quejas');
$total_pmtzintzun = count_by_pmtzintzun('quejas');
$total_pmtzit = count_by_pmtzit('quejas');
$total_pmuruapan = count_by_pmuruapan('quejas');
$total_pmvenus = count_by_pmvenus('quejas');
$total_pmvillamar = count_by_pmvillamar('quejas');
$total_pmvh = count_by_pmvh('quejas');
$total_pmyure = count_by_pmyure('quejas');
$total_pmzaca = count_by_pmzaca('quejas');
$total_pmzamora2 = count_by_pmzamora2('quejas');
$total_pmzinap = count_by_pmzinap('quejas');
$total_pmzinapecuaro = count_by_pmzinapecuaro('quejas');
$total_pmzira = count_by_pmzira('quejas');
$total_pmzita = count_by_pmzita('quejas');
$total_procamich = count_by_procamich('quejas');
$total_padt = count_by_padt('quejas');
$total_pfdt = count_by_pfdt('quejas');
$total_profeco = count_by_profeco('quejas');
$total_qsasr = count_by_qsasr('quejas');
$total_sce = count_by_sce('quejas');
$total_secbien = count_by_secbien('quejas');
$total_scop = count_by_scop('quejas');
$total_sct = count_by_sct('quejas');
$total_sculte = count_by_sculte('quejas');
$total_sde = count_by_sde('quejas');
$total_sdra = count_by_sdra('quejas');
$total_sdsh = count_by_sdsh('quejas');
$total_sdtum = count_by_sdtum('quejas');
$total_see = count_by_see('quejas');
$total_sepf = count_by_sepf('quejas');
$total_sfa = count_by_sfa('quejas');
$total_secgobernacion = count_by_secgobernacion('quejas');
$total_secgobierno = count_by_secgobierno('quejas');
$total_sisdmm = count_by_sisdmm('quejas');
$total_sedena = count_by_sedena('quejas');
$total_sme = count_by_sme('quejas');
$total_marina = count_by_marina('quejas');
$total_sre = count_by_sre('quejas');
$total_ss = count_by_ss('quejas');
$total_ssp = count_by_ssp('quejas');
$total_sspe = count_by_sspe('quejas');
$total_sspf = count_by_sspf('quejas');
$total_sspc = count_by_sspc('quejas');
$total_stps = count_by_stps('quejas');
$total_sifdmsf = count_by_sifdmsf('quejas');
$total_smrt = count_by_smrt('quejas');
$total_dif = count_by_dif('quejas');
$total_stj = count_by_stj('quejas');
$total_tbm = count_by_tbm('quejas');
$total_tcaem = count_by_tcaem('quejas');
$total_tjaem = count_by_tjaem('quejas');
$total_uiim = count_by_uiim('quejas');
$total_umsnh = count_by_umsnh('quejas');
$total_uvem = count_by_uvem('quejas');
$total_vismorelia = count_by_vismorelia('quejas');
$total_visuruapan = count_by_visuruapan('quejas');
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-5">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Quejas por autoridad responsable (más de 20 quejas)</span>
                </strong>
                <!-- <a href="add_capacitacion.php" class="btn btn-info pull-right">Agregar capacitación</a> -->
            </div>
            <div class="panel-body">
                <table class="table table-dark table-bordered table-striped">
                    <a href="estadistica_quejas_autoridadR.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Ver en gráfica
                    </a>
                    <!-- <a href="javascript:abrir()" class="btn btn-primary" style="float: right">Gráfica por rango de fechas</a> -->
                    <br><br>
                    <thead>
                        <tr style="height: 10px;" class="table-info">
                            <th class="text-center" style="width: 40%;">Autoridad Responsable</th>
                            <th class="text-center" style="width: 1%;">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_quejas as $a_quejas) : ?>
                            <?php if ($a_quejas['total'] >= 20) : ?>
                                <tr>
                                    <td><?php echo remove_junk(ucwords($a_quejas['autoridad_responsable'])) ?></td>
                                    <td class="text-center"><?php echo remove_junk(ucwords($a_quejas['total'])) ?></td>
                                </tr>
                                <?php $suma = $suma + $a_quejas['total'] ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <tr>
                            <td style="text-align:right;"><b>Total</b></td>
                            <td><?php echo $suma; ?></td>
                        </tr>
                    </tbody>
                    <!-- <tbody>
                        <tr>
                            <td>Aeropuerto de Morelia</td>
                            <td class="text-center"><?php echo $total_aeropuerto['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Colegio de Bachilleres del Estado de Michoacán COBAEM</td>
                            <td class="text-center"><?php echo $total_cobaem['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Colegio de Estudios Científicos y Tecnológicos del Estado de Michoacán CECYTEM</td>
                            <td class="text-center"><?php echo $total_cecytem['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Colegio Nacional de Educación Profesional Técnica CONALEP</td>
                            <td class="text-center"><?php echo $total_conalep['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Comisión Coordinadora del Transporte Publico en Michoacán</td>
                            <td class="text-center"><?php echo $total_cocotra['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Comisión Ejecutiva Estatal de Atención a Victimas</td>
                            <td class="text-center"><?php echo $total_ceeav['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Comisión Estatal de Cultura Física y Deporte</td>
                            <td class="text-center"><?php echo $total_cecufid['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Comisión Estatal del Agua y Gestión de Cuencas</td>
                            <td class="text-center"><?php echo $total_ceagc['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Comisión Federal de Electricidad CFE</td>
                            <td class="text-center"><?php echo $total_cfe['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Comisión Nacional de los Derechos Humanos CNDH</td>
                            <td class="text-center"><?php echo $total_cndh['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Comisión Nacional del Agua CONAGUA</td>
                            <td class="text-center"><?php echo $total_conagua['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Comisión Nacional Para la Protección y Defensa de los Usuarios de Servicios Financieros CONDUSEF</td>
                            <td class="text-center"><?php echo $total_condusef['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Comisión Para la Regularización de la Tenencia de la Tierra CORETT</td>
                            <td class="text-center"><?php echo $total_corett['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Consejería Jurídica del Ejecutivo del Estado</td>
                            <td class="text-center"><?php echo $total_cjee['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Consejo Nacional Para Prevenir la Discriminación</td>
                            <td class="text-center"><?php echo $total_cnpd['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Coordinación de Comunicación Social</td>
                            <td class="text-center"><?php echo $total_ccs['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Coordinación del Sistema Penitenciario del Estado de Michoacán</td>
                            <td class="text-center"><?php echo $total_cspem['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Defensoría Publica Federal</td>
                            <td class="text-center"><?php echo $total_dpf['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Despacho del C. Gobernador</td>
                            <td class="text-center"><?php echo $total_dcg['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Dirección de Registro Civil</td>
                            <td class="text-center"><?php echo $total_drc['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Dirección de Trabajo y Previsión Social</td>
                            <td class="text-center"><?php echo $total_dtps['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Dirección General de Educación Tecnológica Industrial DGTI</td>
                            <td class="text-center"><?php echo $total_dgti['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Dirección General de Institutos Tecnológicos</td>
                            <td class="text-center"><?php echo $total_dgit['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Fiscalía General en el Estado</td>
                            <td class="text-center"><?php echo $total_fge['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Fiscalía General de la República</td>
                            <td class="text-center"><?php echo $total_fgr['total'] ?></td>
                        </tr>
                        <tr>
                            <td>FOVISSSTE Michoacán</td>
                            <td class="text-center"><?php echo $total_fovissste['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Honorable Congreso del Estado de Michoacán</td>
                            <td class="text-center"><?php echo $total_hcem['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Instituto de la Defensoría Publica del Estado</td>
                            <td class="text-center"><?php echo $total_idpe['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Instituto de la Juventud Michoacana</td>
                            <td class="text-center"><?php echo $total_injuve['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Instituto de Seguridad y Servicios Sociales de los Trabajadores al Servicio del Estado</td>
                            <td class="text-center"><?php echo $total_issste['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Instituto de Vivienda de Michoacán IVEM</td>
                            <td class="text-center"><?php echo $total_ivem['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Instituto del Fondo Nacional de la Vivienda Para los Trabajadores INFONAVIT</td>
                            <td class="text-center"><?php echo $total_infonavit['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Instituto Electoral de Michoacán</td>
                            <td class="text-center"><?php echo $total_iem['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Instituto Mexicano del Seguro Social IMSS</td>
                            <td class="text-center"><?php echo $total_imss['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Instituto Michoacano de Ciencias de la Educación José María Morelos</td>
                            <td class="text-center"><?php echo $total_imced['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Instituto Nacional de Educación Para los Adultos INEA</td>
                            <td class="text-center"><?php echo $total_inea['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Instituto Nacional de Migración</td>
                            <td class="text-center"><?php echo $total_inm['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Junta de Asistencia Privada del Gobierno del Estado</td>
                            <td class="text-center"><?php echo $total_japge['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Junta de Caminos del Estado de Michoacán</td>
                            <td class="text-center"><?php echo $total_jcem['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Junta Local de Conciliación y Arbitraje</td>
                            <td class="text-center"><?php echo $total_jlca['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Parque Zoológico Benito Juárez</td>
                            <td class="text-center"><?php echo $total_zoo['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Pensiones Civiles del Estado</td>
                            <td class="text-center"><?php echo $total_pce['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Acuitzio</td>
                            <td class="text-center"><?php echo $total_pmacu['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Aguililla</td>
                            <td class="text-center"><?php echo $total_pmag['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Álvaro Obregón</td>
                            <td class="text-center"><?php echo $total_pmao['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Angamacutiro</td>
                            <td class="text-center"><?php echo $total_pmangama['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Angangueo</td>
                            <td class="text-center"><?php echo $total_pmangan['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Apatzingán</td>
                            <td class="text-center"><?php echo $total_pmapat['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Aquila</td>
                            <td class="text-center"><?php echo $total_pmaquila['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Ario</td>
                            <td class="text-center"><?php echo $total_pmario['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Arteaga</td>
                            <td class="text-center"><?php echo $total_pmart['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Briseñas</td>
                            <td class="text-center"><?php echo $total_pmbris['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Buenavista</td>
                            <td class="text-center"><?php echo $total_pmbv['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Carácuaro</td>
                            <td class="text-center"><?php echo $total_pmcarac['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Charapan</td>
                            <td class="text-center"><?php echo $total_pmcharapan['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Charo</td>
                            <td class="text-center"><?php echo $total_pmcharo['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Chavinda</td>
                            <td class="text-center"><?php echo $total_pmchav['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Cheran</td>
                            <td class="text-center"><?php echo $total_pmcheran['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Chilchota</td>
                            <td class="text-center"><?php echo $total_pmchil['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Chucándiro</td>
                            <td class="text-center"><?php echo $total_pmchucan['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Churintzio</td>
                            <td class="text-center"><?php echo $total_pmchuri['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Coahuayana</td>
                            <td class="text-center"><?php echo $total_pmcoah['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Coeneo</td>
                            <td class="text-center"><?php echo $total_pmcoeneo['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Cotija</td>
                            <td class="text-center"><?php echo $total_pmcotija['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Cuitzeo</td>
                            <td class="text-center"><?php echo $total_pmcuitzeo['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Ecuandureo</td>
                            <td class="text-center"><?php echo $total_pmecuan['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Epitacio Huerta</td>
                            <td class="text-center"><?php echo $total_pmeh['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Erongarícuaro</td>
                            <td class="text-center"><?php echo $total_pmeron['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Gabriel Zamora</td>
                            <td class="text-center"><?php echo $total_pmzamora['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Hidalgo</td>
                            <td class="text-center"><?php echo $total_pmhidalgo['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Huandacareo</td>
                            <td class="text-center"><?php echo $total_pmhuanda['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Huaniqueo</td>
                            <td class="text-center"><?php echo $total_pmhuani['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Huetamo</td>
                            <td class="text-center"><?php echo $total_pmhuet['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Huiramba</td>
                            <td class="text-center"><?php echo $total_pmhuiramba['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Indaparapeo</td>
                            <td class="text-center"><?php echo $total_pminda['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Irimbo</td>
                            <td class="text-center"><?php echo $total_pmirim['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Ixtlán</td>
                            <td class="text-center"><?php echo $total_pmixt['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Jacona</td>
                            <td class="text-center"><?php echo $total_pmjac['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Jiménez</td>
                            <td class="text-center"><?php echo $total_pmjime['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Jiquilpan</td>
                            <td class="text-center"><?php echo $total_pmjiq['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de José Sixto Verduzco</td>
                            <td class="text-center"><?php echo $total_pmsixver['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Jungapeo</td>
                            <td class="text-center"><?php echo $total_pmjunga['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de la Huacana</td>
                            <td class="text-center"><?php echo $total_pmhuac['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de La Piedad</td>
                            <td class="text-center"><?php echo $total_pmlapiedad['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Lagunillas</td>
                            <td class="text-center"><?php echo $total_pmlagu['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Lázaro Cárdenas</td>
                            <td class="text-center"><?php echo $total_pmlc['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de los Reyes</td>
                            <td class="text-center"><?php echo $total_pmlosreyes['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Madero</td>
                            <td class="text-center"><?php echo $total_pmmadero['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Maravatío</td>
                            <td class="text-center"><?php echo $total_pmmarav['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Marcos Castellanos</td>
                            <td class="text-center"><?php echo $total_pmmc['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Morelia</td>
                            <td class="text-center"><?php echo $total_pmmorelia['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Morelos</td>
                            <td class="text-center"><?php echo $total_pmmorelos['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Múgica</td>
                            <td class="text-center"><?php echo $total_pmmugica['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Nahuatzen</td>
                            <td class="text-center"><?php echo $total_pmnahuatzen['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Nocupétaro</td>
                            <td class="text-center"><?php echo $total_pmnocu['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Nuevo Parangaricutiro</td>
                            <td class="text-center"><?php echo $total_pmnparan['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Nuevo Urecho</td>
                            <td class="text-center"><?php echo $total_pmnurecho['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Numarán</td>
                            <td class="text-center"><?php echo $total_pmnumaran['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Ocampo</td>
                            <td class="text-center"><?php echo $total_pmocampo['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Pajacuarán</td>
                            <td class="text-center"><?php echo $total_pmpajacuaran['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Panindícuaro</td>
                            <td class="text-center"><?php echo $total_pmpanin['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Paracho</td>
                            <td class="text-center"><?php echo $total_pmparacho['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Pátzcuaro</td>
                            <td class="text-center"><?php echo $total_pmpatz['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Penjamillo</td>
                            <td class="text-center"><?php echo $total_pmpenja['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Peribán</td>
                            <td class="text-center"><?php echo $total_pmperiban['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Purépero</td>
                            <td class="text-center"><?php echo $total_pmpure['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Puruándiro</td>
                            <td class="text-center"><?php echo $total_pmpuruan['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Queréndaro</td>
                            <td class="text-center"><?php echo $total_pmqueren['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Quiroga</td>
                            <td class="text-center"><?php echo $total_pmquiroga['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Sahuayo</td>
                            <td class="text-center"><?php echo $total_pmsahuayo['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Salvador Escalante</td>
                            <td class="text-center"><?php echo $total_pmsalvesc['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Santa Ana Maya</td>
                            <td class="text-center"><?php echo $total_pmsam['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Senguio</td>
                            <td class="text-center"><?php echo $total_pmseng['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Tacámbaro</td>
                            <td class="text-center"><?php echo $total_pmtacam['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Tancítaro</td>
                            <td class="text-center"><?php echo $total_pmtanc['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Tangamandapio</td>
                            <td class="text-center"><?php echo $total_pmtangamandapio['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Tangancicuaro</td>
                            <td class="text-center"><?php echo $total_pmtangancicuaro['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Tanhuato</td>
                            <td class="text-center"><?php echo $total_pmtanhuato['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Taretan</td>
                            <td class="text-center"><?php echo $total_pmtaretan['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Tarímbaro</td>
                            <td class="text-center"><?php echo $total_pmtarimbaro['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Tepalcatepec</td>
                            <td class="text-center"><?php echo $total_tepalcatepec['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Tingambato</td>
                            <td class="text-center"><?php echo $total_pmtingambato['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Tingüindín</td>
                            <td class="text-center"><?php echo $total_pmtingu['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Tiquicheo</td>
                            <td class="text-center"><?php echo $total_pmtiqui['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Tlalpujahua</td>
                            <td class="text-center"><?php echo $total_pmtlalpu['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Tlazazalca</td>
                            <td class="text-center"><?php echo $total_pmtlaza['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Tocumbo</td>
                            <td class="text-center"><?php echo $total_pmtocumbo['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Tuxpan</td>
                            <td class="text-center"><?php echo $total_pmtux['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Tuzantla</td>
                            <td class="text-center"><?php echo $total_pmtuzan['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Tzintzuntzan</td>
                            <td class="text-center"><?php echo $total_pmtzintzun['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Tzitzio</td>
                            <td class="text-center"><?php echo $total_pmtzit['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Uruapan</td>
                            <td class="text-center"><?php echo $total_pmuruapan['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Venustiano Carranza</td>
                            <td class="text-center"><?php echo $total_pmvenus['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Villamar</td>
                            <td class="text-center"><?php echo $total_pmvillamar['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Vista Hermosa</td>
                            <td class="text-center"><?php echo $total_pmvh['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Yurécuaro</td>
                            <td class="text-center"><?php echo $total_pmyure['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Zacapu</td>
                            <td class="text-center"><?php echo $total_pmzaca['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Zamora</td>
                            <td class="text-center"><?php echo $total_pmzamora2['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Zináparo</td>
                            <td class="text-center"><?php echo $total_pmzinap['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Zinapécuaro</td>
                            <td class="text-center"><?php echo $total_pmzinapecuaro['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Ziracuaretiro</td>
                            <td class="text-center"><?php echo $total_pmzira['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Presidencia Municipal de Zitácuaro</td>
                            <td class="text-center"><?php echo $total_pmzita['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Procuraduría Agraria En Michoacán</td>
                            <td class="text-center"><?php echo $total_procamich['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Procuraduría Auxiliar de la Defensa del Trabajo</td>
                            <td class="text-center"><?php echo $total_padt['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Procuraduría Federal de la Defensa del Trabajo</td>
                            <td class="text-center"><?php echo $total_pfdt['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Procuraduría Federal del Consumidor PROFECO</td>
                            <td class="text-center"><?php echo $total_profeco['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Quejas Sin Autoridad Señalada Como Responsable</td>
                            <td class="text-center"><?php echo $total_qsasr['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Secretaria de Contraloría del Estado</td>
                            <td class="text-center"><?php echo $total_sce['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Secretaría de Bienestar</td>
                            <td class="text-center"><?php echo $total_secbien['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Secretaria de Comunicaciones y Obras Publicas</td>
                            <td class="text-center"><?php echo $total_scop['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Secretaria de Comunicaciones y Transportes SCT</td>
                            <td class="text-center"><?php echo $total_sct['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Secretaria de Cultura en el Estado</td>
                            <td class="text-center"><?php echo $total_sculte['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Secretaria de Desarrollo Económico</td>
                            <td class="text-center"><?php echo $total_sde['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Secretaria de Desarrollo Rural y Agroalimentario</td>
                            <td class="text-center"><?php echo $total_sdra['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Secretaría de Desarrollo Social y Humano</td>
                            <td class="text-center"><?php echo $total_sdsh['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Secretaria de Desarrollo Territorial Urbano y Movilidad</td>
                            <td class="text-center"><?php echo $total_sdtum['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Secretaria de Educación del Estado</td>
                            <td class="text-center"><?php echo $total_see['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Secretaria de Educación Pública Federal</td>
                            <td class="text-center"><?php echo $total_sepf['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Secretaria de Finanzas y Administración</td>
                            <td class="text-center"><?php echo $total_sfa['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Secretaría de Gobernación</td>
                            <td class="text-center"><?php echo $total_secgobernacion['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Secretaria de Gobierno</td>
                            <td class="text-center"><?php echo $total_secgobierno['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Secretaria de Igualdad Sustantiva y Desarrollo de Las Mujeres Michoacanas</td>
                            <td class="text-center"><?php echo $total_sisdmm['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Secretaria de la Defensa Nacional Ejercito Mexicano</td>
                            <td class="text-center"><?php echo $total_sedena['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Secretaria de los Migrantes En El Extranjero</td>
                            <td class="text-center"><?php echo $total_sme['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Secretaria de Marina y Armada de México</td>
                            <td class="text-center"><?php echo $total_marina['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Secretaria de Relaciones Exteriores SRE</td>
                            <td class="text-center"><?php echo $total_sre['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Secretaria de Salud</td>
                            <td class="text-center"><?php echo $total_ss['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Secretaría de Seguridad Pública</td>
                            <td class="text-center"><?php echo $total_ssp['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Secretaria de Seguridad Pública Estatal</td>
                            <td class="text-center"><?php echo $total_sspe['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Secretaria de Seguridad Pública Federal</td>
                            <td class="text-center"><?php echo $total_sspf['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Secretaria de Seguridad y Protección Ciudadana</td>
                            <td class="text-center"><?php echo $total_sspc['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Secretaria del Trabajo y Previsión Social</td>
                            <td class="text-center"><?php echo $total_stps['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Sistema Integral de Financiamiento para el Desarrollo de Michoacán Si Financia</td>
                            <td class="text-center"><?php echo $total_sifdmsf['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Sistema Michoacano de Radio y Televisión</td>
                            <td class="text-center"><?php echo $total_smrt['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Sistema Para el Desarrollo Integral de la Familia DIF</td>
                            <td class="text-center"><?php echo $total_dif['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Supremo Tribunal de Justicia</td>
                            <td class="text-center"><?php echo $total_stj['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Telebachillerato de Michoacán</td>
                            <td class="text-center"><?php echo $total_tbm['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Tribunal de Conciliación y Arbitraje del Estado de Michoacán</td>
                            <td class="text-center"><?php echo $total_tcaem['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Tribunal de Justicia Administrativa del Estado de Michoacán</td>
                            <td class="text-center"><?php echo $total_tjaem['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Universidad Intercultural Indígena de Michoacán</td>
                            <td class="text-center"><?php echo $total_uiim['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Universidad Michoacana de San Nicolas de Hidalgo UMSNH</td>
                            <td class="text-center"><?php echo $total_umsnh['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Universidad Virtual del Estado de Michoacán</td>
                            <td class="text-center"><?php echo $total_uvem['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Visitaduría Morelia</td>
                            <td class="text-center"><?php echo $total_vismorelia['total'] ?></td>
                        </tr>
                        <tr>
                            <td>Visitaduría Uruapan</td>
                            <td class="text-center"><?php echo $total_visuruapan['total'] ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:right;"><b>Total</b></td>
                            <td>
                                <?php echo $total_aeropuerto['total'] + $total_cobaem['total'] + $total_cecytem['total'] + $total_conalep['total'] + $total_cocotra['total'] +
                                    $total_ceeav['total'] + $total_cecufid['total'] + $total_ceagc['total'] + $total_cfe['total'] + $total_cndh['total'] + $total_conagua['total'] +
                                    $total_condusef['total'] + $total_corett['total'] + $total_cjee['total'] + $total_cnpd['total'] + $total_ccs['total'] + $total_cspem['total'] +
                                    $total_dpf['total'] + $total_dcg['total'] + $total_drc['total'] + $total_dtps['total'] + $total_dgti['total'] + $total_dgit['total'] +
                                    $total_fge['total'] + $total_fgr['total'] + $total_fovissste['total'] + $total_hcem['total'] + $total_idpe['total'] + $total_injuve['total'] +
                                    $total_issste['total'] + $total_ivem['total'] + $total_infonavit['total'] + $total_iem['total'] + $total_imss['total'] + $total_imced['total'] +
                                    $total_inea['total'] + $total_inm['total'] + $total_japge['total'] + $total_jcem['total'] + $total_jlca['total'] + $total_zoo['total'] +
                                    $total_pce['total'] + $total_pmacu['total'] + $total_pmag['total'] + $total_pmao['total'] + $total_pmangama['total'] + $total_pmangan['total'] +
                                    $total_pmapat['total'] + $total_pmaquila['total'] + $total_pmario['total'] + $total_pmart['total'] + $total_pmbris['total'] + $total_pmbv['total'] +
                                    $total_pmcarac['total'] + $total_pmcharapan['total'] + $total_pmcharo['total'] + $total_pmchav['total'] + $total_pmcheran['total'] + $total_pmchil['total'] +
                                    $total_pmchucan['total'] + $total_pmchuri['total'] + $total_pmcoah['total'] + $total_pmcoeneo['total'] + $total_pmcotija['total'] + $total_pmcuitzeo['total'] +
                                    $total_pmecuan['total'] + $total_pmeh['total'] + $total_pmeron['total'] + $total_pmzamora['total'] + $total_pmhidalgo['total'] + $total_pmhuanda['total'] +
                                    $total_pmhuani['total'] + $total_pmhuet['total'] + $total_pmhuiramba['total'] + $total_pminda['total'] + $total_pmirim['total'] + $total_pmixt['total'] +
                                    $total_pmjac['total'] + $total_pmjime['total'] + $total_pmjiq['total'] + $total_pmsixver['total'] + $total_pmjunga['total'] + $total_pmhuac['total'] +
                                    $total_pmlapiedad['total'] + $total_pmlagu['total'] + $total_pmlc['total'] + $total_pmlosreyes['total'] + $total_pmmadero['total'] + $total_pmmarav['total'] +
                                    $total_pmmc['total'] + $total_pmmorelia['total'] + $total_pmmorelos['total'] + $total_pmmugica['total'] + $total_pmnahuatzen['total'] + $total_pmnocu['total'] +
                                    $total_pmnparan['total'] + $total_pmnurecho['total'] + $total_pmnumaran['total'] + $total_pmocampo['total'] + $total_pmpajacuaran['total'] + $total_pmpanin['total'] +
                                    $total_pmparacho['total'] + $total_pmpatz['total'] + $total_pmpenja['total'] + $total_pmperiban['total'] + $total_pmpure['total'] + $total_pmpuruan['total'] +
                                    $total_pmqueren['total'] + $total_pmquiroga['total'] + $total_pmsahuayo['total'] + $total_pmsalvesc['total'] + $total_pmsam['total'] + $total_pmseng['total'] +
                                    $total_pmtacam['total'] + $total_pmtanc['total'] + $total_pmtangamandapio['total'] + $total_pmtangancicuaro['total'] + $total_pmtanhuato['total'] + $total_pmtaretan['total'] +
                                    $total_pmtarimbaro['total'] + $total_tepalcatepec['total'] + $total_pmtingambato['total'] + $total_pmtingu['total'] + $total_pmtiqui['total'] + $total_pmtlalpu['total'] +
                                    $total_pmtlaza['total'] + $total_pmtocumbo['total'] + $total_pmtux['total'] + $total_pmtuzan['total'] + $total_pmtzintzun['total'] + $total_pmtzit['total'] +
                                    $total_pmuruapan['total'] + $total_pmvenus['total'] + $total_pmvillamar['total'] + $total_pmvh['total'] + $total_pmyure['total'] + $total_pmzaca['total'] +
                                    $total_pmzamora2['total'] + $total_pmzinap['total'] + $total_pmzinapecuaro['total'] + $total_pmzira['total'] + $total_pmzita['total'] + $total_procamich['total'] +
                                    $total_padt['total'] + $total_pfdt['total'] + $total_profeco['total'] + $total_qsasr['total'] + $total_sce['total'] + $total_secbien['total'] +
                                    $total_scop['total'] + $total_sct['total'] + $total_sculte['total'] + $total_sde['total'] + $total_sdra['total'] + $total_sdsh['total'] +
                                    $total_sdtum['total'] + $total_see['total'] + $total_sepf['total'] + $total_sfa['total'] + $total_secgobernacion['total'] + $total_secgobierno['total'] +
                                    $total_sisdmm['total'] + $total_sedena['total'] + $total_sme['total'] + $total_marina['total'] + $total_sre['total'] + $total_ss['total'] +
                                    $total_ssp['total'] + $total_sspe['total'] + $total_sspf['total'] + $total_sspc['total'] + $total_stps['total'] + $total_sifdmsf['total'] +
                                    $total_smrt['total'] + $total_dif['total'] + $total_stj['total'] + $total_tbm['total'] + $total_tcaem['total'] + $total_tjaem['total'] +
                                    $total_uiim['total'] + $total_umsnh['total'] + $total_uvem['total'] + $total_vismorelia['total'] + $total_visuruapan['total'];
                                ?>
                            </td>
                        </tr>
                    </tbody> -->
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Quejas por autoridad responsable (menos de 20 quejas)</span>
                </strong>
                <!-- <a href="add_capacitacion.php" class="btn btn-info pull-right">Agregar capacitación</a> -->
            </div>
            <div class="panel-body">
                <table class="table table-dark table-bordered table-striped">
                    <a href="estadistica_quejas_autoridadR2.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Ver en gráfica
                    </a>
                    <!-- <a href="javascript:abrir()" class="btn btn-primary" style="float: right">Gráfica por rango de fechas</a> -->
                    <br><br>
                    <thead>
                        <tr style="height: 10px;" class="table-info">
                            <th class="text-center" style="width: 40%;">Autoridad Responsable</th>
                            <th class="text-center" style="width: 1%;">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_quejas as $a_quejas) : ?>
                            <?php if ($a_quejas['total'] <= 20) : ?>
                                <tr>
                                    <td><?php echo remove_junk(ucwords($a_quejas['autoridad_responsable'])) ?></td>
                                    <td class="text-center"><?php echo remove_junk(ucwords($a_quejas['total'])) ?></td>
                                </tr>
                                <?php $suma = $suma + $a_quejas['total'] ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <tr>
                            <td style="text-align:right;"><b>Total</b></td>
                            <td><?php echo $suma; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="ventana" id="vent">
    <div id="cerrar">
        <a href="javascript:cerrar()"><img src="cerrar.png" height="25px" width="25px"></a>
    </div>
    <span></span>
    <h4 style="margin-top: 5%;">Selecciona el rango a graficar</h4>

    <form class="clearfix" method="post" action="grafica_fecha_autoridadR.php">
        <div class="form-group">
            <label class="form-label">Rango de fechas</label>
            <div class="input-group">
                <input type="text" class="datepicker form-control" name="start-date" placeholder="Desde">
                <span class="input-group-addon"><i class="glyphicon glyphicon-menu-right"></i></span>
                <input type="text" class="datepicker form-control" name="end-date" placeholder="Hasta">
            </div>
        </div>
        <div class="form-group">
            <button type="submit" name="submit" class="btn btn-primary">Generar gráfica</button>
        </div>
    </form>
</div>
<script>
    function abrir() {
        document.getElementById("vent").style.display = "block";
    }

    function cerrar() {
        document.getElementById("vent").style.display = "none"
    }
</script>


<?php include_once('layouts/footer.php'); ?>