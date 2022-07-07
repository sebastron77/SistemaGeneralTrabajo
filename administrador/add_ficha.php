<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar Ficha Técnica - Área Médica';
require_once('includes/load.php');
$user = current_user();
$detalle = $user['id'];
$id_folio = last_id_folios_general();
page_require_level(4);
$id_user = $user['id'];
$busca_area = area_usuario($id_user);
$otro = $busca_area['id'];
$areas = find_all_area_orden('area');
page_require_area(4);
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['add_ficha'])) {

    $req_fields = array('funcion', 'area_solicitante', 'visitaduria', 'ocupacion', 'escolaridad', 'hechos', 'autoridad', 'nombre_usuario', 'edad', 'sexo', 'grupo_vulnerable', 'fecha_intervencion', 'resultado', 'documento_emitido', 'nombre_especialista', 'clave_documento');
    validate_fields($req_fields);

    if (empty($errors)) {
        $funcion   = remove_junk($db->escape($_POST['funcion']));
        $num_queja   = remove_junk($db->escape($_POST['num_queja']));
        $visitaduria   = remove_junk($db->escape($_POST['visitaduria']));
        $area_solicitante   = remove_junk($db->escape($_POST['area_solicitante']));
        $ocupacion   = remove_junk(($db->escape($_POST['ocupacion'])));
        $escolaridad   = remove_junk(($db->escape($_POST['escolaridad'])));
        $hechos   = remove_junk(($db->escape($_POST['hechos'])));
        $autoridad   = remove_junk(($db->escape($_POST['autoridad'])));
        $nombre_usuario   = remove_junk($db->escape($_POST['nombre_usuario']));
        $edad   = remove_junk($db->escape($_POST['edad']));
        $sexo   = remove_junk($db->escape($_POST['sexo']));
        $grupo_vulnerable   = remove_junk($db->escape($_POST['grupo_vulnerable']));
        $fecha_intervencion   = remove_junk($db->escape($_POST['fecha_intervencion']));
        $resultado   = remove_junk($db->escape($_POST['resultado']));
        $nombre_especialista   = remove_junk($db->escape($_POST['nombre_especialista']));
        $clave_documento   = remove_junk($db->escape($_POST['clave_documento']));
        $documento_emitido   = remove_junk($db->escape($_POST['documento_emitido']));
        $adjunto   = remove_junk($db->escape($_POST['adjunto']));
        date_default_timezone_set('America/Mexico_City');
        $creacion = date('Y-m-d');

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

        $folio_carpeta = 'CEDH-' . $no_folio1 . '-' . $year . '-FT';
        $carpeta = 'uploads/fichastecnicas/' . $folio_carpeta;

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $name = $_FILES['adjunto']['name'];
        $size = $_FILES['adjunto']['size'];
        $type = $_FILES['adjunto']['type'];
        $temp = $_FILES['adjunto']['tmp_name'];

        $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        if ($move && $name != '') {
            $query = "INSERT INTO fichas (";
            $query .= "folio,funcion,num_queja,visitaduria,area_solicitante,ocupacion,escolaridad,hechos,autoridad,nombre_usuario,edad,sexo,grupo_vulnerable,fecha_intervencion,resultado,documento_emitido,nombre_especialista,clave_documento,ficha_adjunto,fecha_creacion,tipo_ficha,quien_creo";
            $query .= ") VALUES (";
            $query .= " '{$folio}','{$funcion}','{$num_queja}','{$visitaduria}','{$area_solicitante}','{$ocupacion}','{$escolaridad}','{$hechos}','{$autoridad}','{$nombre_usuario}','{$edad}','{$sexo}','{$grupo_vulnerable}','{$fecha_intervencion}','{$resultado}','{$documento_emitido}','{$nombre_especialista}','{$clave_documento}','{$name}','{$creacion}',1,'{$id_user}'";
            $query .= ")";

            $query2 = "INSERT INTO folios_general (";
            $query2 .= "folio, contador";
            $query2 .= ") VALUES (";
            $query2 .= " '{$folio}','{$no_folio1}'";
            $query2 .= ")";
        } else {
            $query = "INSERT INTO fichas (";
            $query .= "folio,funcion,num_queja,visitaduria,area_solicitante,ocupacion,escolaridad,hechos,autoridad,nombre_usuario,edad,sexo,grupo_vulnerable,fecha_intervencion,resultado,documento_emitido,nombre_especialista,clave_documento,fecha_creacion,tipo_ficha,quien_creo";
            $query .= ") VALUES (";
            $query .= " '{$folio}','{$funcion}','{$num_queja}','{$visitaduria}','{$area_solicitante}','{$ocupacion}','{$escolaridad}','{$hechos}','{$autoridad}','{$nombre_usuario}','{$edad}','{$sexo}','{$grupo_vulnerable}','{$fecha_intervencion}','{$resultado}','{$documento_emitido}','{$nombre_especialista}','{$clave_documento}','{$creacion}',1,'{$id_user}'";
            $query .= ")";

            $query2 = "INSERT INTO folios_general (";
            $query2 .= "folio, contador";
            $query2 .= ") VALUES (";
            $query2 .= " '{$folio}','{$no_folio1}'";
            $query2 .= ")";
        }
        if ($db->query($query) && $db->query($query2)) {
            //sucess
            $session->msg('s', " La ficha ha sido agregada con éxito.");
            redirect('fichas.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar la ficha.');
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
                <span>Agregar Ficha Técnica - Área Médica</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_ficha.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="funcion">Función</label>
                            <select class="form-control" name="funcion">
                                <option value="">Escoge una opción</option>
                                <option value="Gestión Hospitalaria">Gestión Hospitalaria</option>
                                <option value="Certificación médica de lesiones">Certificación médica de lesiones</option>
                                <option value="Valoración y/u Orientación Médica">Valoración y/u Orientación Médica</option>
                                <option value="Supervisión y Diagnóstico Institucional">Supervisión y Diagnóstico Institucional</option>
                                <option value="Opinión Médica">Opinión Médica</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="num_queja">No. de Queja</label>
                            <input type="text" class="form-control" name="num_queja">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="area_solicitante">Área Solicitante</label>
                            <select class="form-control" name="area_solicitante">
                                <option value="">Escoge una opción</option>
                                <?php foreach ($areas as $area) : ?>
                                    <option value="<?php echo $area['nombre_area']; ?>"><?php echo ucwords($area['nombre_area']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ocupacion">Ocupación</label>
                            <select class="form-control" name="ocupacion">
                                <option>Escoge una opción</option>
                                <option value="Otro">Otro</option>
                                <option value="Agricultor(a)">Agricultor(a)</option>
                                <option value="Albañil">Albañil</option>
                                <option value="Ama de Casa">Ama de Casa</option>
                                <option value="Artista">Artista</option>
                                <option value="Artesano(a)">Artesano(a)</option>
                                <option value="Pescador(a)">Pescador(a)</option>
                                <option value="Camionero(a)">Camionero(a)</option>
                                <option value="Carpintero(a)">Carpintero(a)</option>
                                <option value="Cocinero(a)">Cocinero(a)</option>
                                <option value="Comerciante">Comerciante</option>
                                <option value="Chofer">Chofer</option>
                                <option value="Deportista">Deportista</option>
                                <option value="Empleada doméstica">Empleada doméstica</option>
                                <option value="Servidor(a) público(a)">Servidor(a) público(a)</option>
                                <option value="Empleado(a) de negocio">Empleado(a) de negocio</option>
                                <option value="Empresario(a)">Empresario(a)</option>
                                <option value="Estilista">Estilista</option>
                                <option value="Estudiante">Estudiante</option>
                                <option value="Ganadero(a)">Ganadero(a)</option>
                                <option value="Intendente">Intendente</option>
                                <option value="Jornalero(a)">Jornalero(a)</option>
                                <option value="Jubilado(a)">Jubilado(a)</option>
                                <option value="Locutor(a)">Locutor(a)</option>
                                <option value="Profesor(a)">Profesor(a)</option>
                                <option value="Mecánico(a)">Mecánico(a)</option>
                                <option value="Migrante">Migrante</option>
                                <option value="Parroco">Parroco</option>
                                <option value="Peluquero(a)">Peluquero(a)</option>
                                <option value="Pensionado(a)">Pensionado(a)</option>
                                <option value="Periodista">Periodista</option>
                                <option value="Plomero(a)">Plomero(a)</option>
                                <option value="Reportero(a)">Reportero(a)</option>
                                <option value="Servidor(a) sexual">Servidor(a) sexual</option>
                                <option value="Taxista">Taxista</option>
                                <option value="Transportista">Transportista</option>
                                <option value="Interno(a)">Interno(a)</option>
                                <option value="Franelero">Franelero</option>
                                <option value="Desempleado">Desempleado</option>
                                <option value="Contratista">Contratista</option>
                                <option value="Policia">Policia</option>
                                <option value="Ninguno">Ninguno</option>
                                <option value="Litigante">Litigante</option>
                                <option value="Defensor(a) civil de los derechos humanos">Defensor(a) civil de los derechos humanos</option>
                                <option value="Profesionista práctica privada">Profesionista práctica privada</option>
                                <option value="Investigador(a)">Investigador(a)</option>
                                <option value="Obrero(a)">Obrero(a)</option>
                                <option value="Enfermera(o) especialista en salud">Enfermera(o) especialista en salud</option>
                                <option value="Auxiliar en actividades administrativas">Auxiliar en actividades administrativas</option>
                                <option value="Secretaria(o)">Secretaria(o)</option>
                                <option value="Cajero(a)">Cajero(a)</option>
                                <option value="Comerciante en establecimiento">Comerciante en establecimiento</option>
                                <option value="Comerciante Ambulante">Comerciante Ambulante</option>
                                <option value="Atención al público">Atención al público</option>
                                <option value="Empleado(a) del sector público">Empleado(a) del sector público</option>
                                <option value="Empleado(a) del sector privado">Empleado(a) del sector privado</option>
                                <option value="Preparación y servicio de alimentos">Preparación y servicio de alimentos</option>
                                <option value="Cuidados personales y del hogar">Cuidados personales y del hogar</option>
                                <option value="Servicios de protección y vigilancia">Servicios de protección y vigilancia</option>
                                <option value="Armada, ejercito y fuerza aérea">Armada, ejercito y fuerza aérea</option>
                                <option value="Actividades agrícolas y ganaderas">Actividades agrícolas y ganaderas</option>
                                <option value="Actividades pesqueras, forestales, caza y similares">Actividades pesqueras, forestales, caza y similares</option>
                                <option value="Operador(a) de maquinaria pesada">Operador(a) de maquinaria pesada</option>
                                <option value="Extracción y edificador de construcciones">Extracción y edificador de construcciones</option>
                                <option value="Ensamblador(a)">Ensamblador(a)</option>
                                <option value="Agente de ventas">Agente de ventas</option>
                                <option value="Pintor(a)">Pintor(a)</option>
                                <option value="Trabajador(a) de apoyo para espectaculos">Trabajador(a) de apoyo para espectaculos</option>
                                <option value="Repartidor(a) de mercancias">Repartidor(a) de mercancias</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="escolaridad">Escolaridad</label>
                            <select class="form-control" name="escolaridad">
                                <option value="">Escoge una opción</option>
                                <option value="Sin estudios">Sin estudios</option>
                                <option value="Primaria">Primaria</option>
                                <option value="Secundaria">Secundaria</option>
                                <option value="Preparatoria">Preparatoria</option>
                                <option value="Licenciatura">Licenciatura</option>
                                <option value="Especialidad">Especialidad</option>
                                <option value="Maestría">Maestría</option>
                                <option value="Doctorado">Doctorado</option>
                                <option value="Pos Doctorado">Pos Doctorado</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="visitaduria">Visitaduria</label>
                            <select class="form-control" name="visitaduria">
                                <option value="">Escoge una opción</option>
                                <option value="Regional de Apatzingán">Regional de Apatzingán</option>
                                <option value="Regional de Lázaro Cárdenas">Regional de Lázaro Cárdenas</option>
                                <option value="Regional de Morelia">Regional de Morelia</option>
                                <option value="Regional de Uruapan">Regional de Uruapan</option>
                                <option value="Auxiliar de Paracho">Auxiliar de Paracho</option>
                                <option value="Regional de Zamora">Regional de Zamora</option>
                                <option value="Auxiliar de La Piedad">Auxiliar de La Piedad</option>
                                <option value="Regional de Zitácuaro">Regional de Zitácuaro</option>
                                <option value="Auxiliar de Huetamo">Auxiliar de Huetamo</option>
                                <option value="No Aplica">No Aplica</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="hechos">Presuntos hechos violatorios</label>
                            <select class="form-control" name="hechos">
                                <option value="">Escoge una opción</option>
                                <option value="Preservar la vida humana">Preservar la vida humana</option>
                                <option value="No ser privado de la vida arbitraria extrajudicial o sumaramente">No ser privado de la vida arbitraria extrajudicial o sumaramente</option>
                                <option value="Preservar la vida del producto de la concepción">Preservar la vida del producto de la concepción</option>
                                <option value="No ser victima de genocidio">No ser victima de genocidio</option>
                                <option value="La libertad de creencia religiosa">La libertad de creencia religiosa</option>
                                <option value="La libertad de objeción de conciencia">La libertad de objeción de conciencia</option>
                                <option value="La libertad de expresión">La libertad de expresión</option>
                                <option value="La libertad de asociación">La libertad de asociación</option>
                                <option value="La libertad de reunión">La libertad de reunión</option>
                                <option value="La libertad de defender a los derechos humanos">La libertad de defender a los derechos humanos</option>
                                <option value="La libertad de procreación">La libertad de procreación</option>
                                <option value="La libertad sexual">La libertad sexual</option>
                                <option value="La libertad de transito">La libertad de transito</option>
                                <option value="No ser sujeto de privación ilegal de la libertad">No ser sujeto de privación ilegal de la libertad</option>
                                <option value="No ser sujeto de retención ilegal">No ser sujeto de retención ilegal</option>
                                <option value="No ser sujeto de detención ilegal">No ser sujeto de detención ilegal</option>
                                <option value="No ser sujeto a trata de personas">No ser sujeto a trata de personas</option>
                                <option value="A la dignidad">A la dignidad</option>
                                <option value="No ser sometido a violencia institucional">No ser sometido a violencia institucional</option>
                                <option value="No ser discriminado">No ser discriminado</option>
                                <option value="La honra">La honra</option>
                                <option value="La intimidad">La intimidad</option>
                                <option value="La identidad">La identidad</option>
                                <option value="Igualdad de oportunidades">Igualdad de oportunidades</option>
                                <option value="Proyecto de vida">Proyecto de vida</option>
                                <option value="La protección de la familia">La protección de la familia</option>
                                <option value="Equidad de género">Equidad de género</option>
                                <option value="Libre desarrollo de la personalidad">Libre desarrollo de la personalidad</option>
                                <option value="Una imagen propia">Una imagen propia</option>
                                <option value="Trato diferenciado y preferente">Trato diferenciado y preferente</option>
                                <option value="Personas con algún tipo de discapacidad">Personas con algún tipo de discapacidad</option>
                                <option value="No ser sometido a tortura">No ser sometido a tortura</option>
                                <option value="No ser sometido a penas o tratos crueles inhumanos y degradantes">No ser sometido a penas o tratos crueles inhumanos y degradantes</option>
                                <option value="No ser sometido al uso desproporcionado o indebido de la fuerza pública">No ser sometido al uso desproporcionado o indebido de la fuerza pública</option>
                                <option value="No ser sujeto de desaparición forzada">No ser sujeto de desaparición forzada</option>
                                <option value="Protección contra toda forma de violencia">Protección contra toda forma de violencia</option>
                                <option value="La posesión y portación de armas">La posesión y portación de armas</option>
                                <option value="Acceso a la justicia">Acceso a la justicia</option>
                                <option value="No ser sujeto de incomunicación">No ser sujeto de incomunicación</option>
                                <option value="Debida diligencia">Debida diligencia</option>
                                <option value="Garantía de audiencia">Garantía de audiencia</option>
                                <option value="La fundamentación y motivación">La fundamentación y motivación</option>
                                <option value="La presunción de inocencia">La presunción de inocencia</option>
                                <option value="La irretroactividad de la ley">La irretroactividad de la ley</option>
                                <option value="Una fianza asequible">Una fianza asequible</option>
                                <option value="La oportuna y adecuada adopción de medidas cautelares">La oportuna y adecuada adopción de medidas cautelares</option>
                                <option value="Del imputado a recibir información">Del imputado a recibir información</option>
                                <option value="Preservar custodiar y  conservar las actuaciones ministeriales">Preservar custodiar y  conservar las actuaciones ministeriales</option>
                                <option value="Una valoración y certificación médica">Una valoración y certificación médica</option>
                                <option value="Una adecuada administración y procuración de justicia">Una adecuada administración y procuración de justicia</option>
                                <option value="Una defensa adecuada">Una defensa adecuada</option>
                                <option value="Que se proporcione traductor o interprete">Que se proporcione traductor o interprete</option>
                                <option value="Una oportuna y adecuada ejecución de los mandamientos judiciales">Una oportuna y adecuada ejecución de los mandamientos judiciales</option>
                                <option value="Los medios alternativos de ejecución de controversias">Los medios alternativos de ejecución de controversias</option>
                                <option value="La inviolabilidad del domicilio">La inviolabilidad del domicilio</option>
                                <option value="La propiedad y a la posesión">La propiedad y a la posesión</option>
                                <option value="La inviolabilidad de la correspondencia">La inviolabilidad de la correspondencia</option>
                                <option value="La confidencialidad de las comunicaciones">La confidencialidad de las comunicaciones</option>
                                <option value="La inviolabilidad del secreto profesional">La inviolabilidad del secreto profesional</option>
                                <option value="Recibir asesoría para la defensa de sus intereses">Recibir asesoría para la defensa de sus intereses</option>
                                <option value="Ser informado de los intereses en que tenga interés legitimo">Ser informado de los intereses en que tenga interés legitimo</option>
                                <option value="Coadyubar con el ministerio público en la investigación de los delitos">Coadyubar con el ministerio público en la investigación de los delitos</option>
                                <option value="Recibir atención médica psicológica y tratamiento especializado">Recibir atención médica psicológica y tratamiento especializado</option>
                                <option value="Reparación integral">Reparación integral</option>
                                <option value="La adopción de medidas cautelares">La adopción de medidas cautelares</option>
                                <option value="Impugnar las resoluciones en su agravio">Impugnar las resoluciones en su agravio</option>
                                <option value="No ser sujeto de victimización secundaria">No ser sujeto de victimización secundaria</option>
                                <option value="Las personas en situación de desplazamiento forzado">Las personas en situación de desplazamiento forzado</option>
                                <option value="Recibir educación de calidad">Recibir educación de calidad</option>
                                <option value="Acceso a la educación">Acceso a la educación</option>
                                <option value="La gratuidad de la educación">La gratuidad de la educación</option>
                                <option value="Educación laica">Educación laica</option>
                                <option value="Recibir educación en igualdad de trato y condiciones">Recibir educación en igualdad de trato y condiciones</option>
                                <option value="La adecuada supervisión de la educación impartida por particulares">La adecuada supervisión de la educación impartida por particulares</option>
                                <option value="La educación especial">La educación especial</option>
                                <option value="La elección de la educación de los hijos">La elección de la educación de los hijos</option>
                                <option value="Una educación libre de violencia">Una educación libre de violencia</option>
                                <option value="Respeto a la situación jurídica">Respeto a la situación jurídica</option>
                                <option value="Una estancia digna y segura">Una estancia digna y segura</option>
                                <option value="Protección de la integridad">Protección de la integridad</option>
                                <option value="Desarrollo de actividades productivas y educativas">Desarrollo de actividades productivas y educativas</option>
                                <option value="La vinculación social del interno">La vinculación social del interno</option>
                                <option value="Mantenimiento del orden y aplicación de sanciones">Mantenimiento del orden y aplicación de sanciones</option>
                                <option value="Atención de grupos especiales dentro de instituciones penitenciarias">Atención de grupos especiales dentro de instituciones penitenciarias</option>
                                <option value="Recibir atención médica integral">Recibir atención médica integral</option>
                                <option value="Una atención médica libre de negligencia">Una atención médica libre de negligencia</option>
                                <option value="La accesibilidad de los servicios de salud">La accesibilidad de los servicios de salud</option>
                                <option value="Recibir un trato digno y respetuoso">Recibir un trato digno y respetuoso</option>
                                <option value="Decidir libremente sobre su atención médica">Decidir libremente sobre su atención médica</option>
                                <option value="Otorgar el consentimiento válidamente informado">Otorgar el consentimiento válidamente informado</option>
                                <option value="Confidencialidad respecto a sus enfermedades o padecimientos">Confidencialidad respecto a sus enfermedades o padecimientos</option>
                                <option value="Tener una segunda opinión médica">Tener una segunda opinión médica</option>
                                <option value="La debida integración del expediente clínico">La debida integración del expediente clínico</option>
                                <option value="Ser atendido cuando se inconforme con la atención médica recibida">Ser atendido cuando se inconforme con la atención médica recibida</option>
                                <option value="Recibir los medicamentos y tratamiento correspondiente a su padecimiento">Recibir los medicamentos y tratamiento correspondiente a su padecimiento</option>
                                <option value="La inmunización universal">La inmunización universal</option>
                                <option value="La educación para la salud alimentación e higiene">La educación para la salud alimentación e higiene</option>
                                <option value="La satisfacción de las necesidades de salud de los grupos de más alto riesgo">La satisfacción de las necesidades de salud de los grupos de más alto riesgo</option>
                                <option value="No ser sometido a esterilización forzada">No ser sometido a esterilización forzada</option>
                                <option value="Las mujeres a recibir información para decidir sobre la interrupción del embarazo">Las mujeres a recibir información para decidir sobre la interrupción del embarazo</option>
                                <option value="Las mujeres a no ser sujetas de violencia obstétrica">Las mujeres a no ser sujetas de violencia obstétrica</option>
                                <option value="La lactancia">La lactancia</option>
                                <option value="Acceso a la información pública">Acceso a la información pública</option>
                                <option value="Acceso rectificación y corrección de la información pública">Acceso rectificación y corrección de la información pública</option>
                                <option value="Buscar recibir o difundir cualquier información pública">Buscar recibir o difundir cualquier información pública</option>
                                <option value="La libertad de trabajo">La libertad de trabajo</option>
                                <option value="Goce de condiciones de trabajo justas equitativas y satisfactorias">Goce de condiciones de trabajo justas equitativas y satisfactorias</option>
                                <option value="No ser sometido a trabajo forzado u obligatorio">No ser sometido a trabajo forzado u obligatorio</option>
                                <option value="Las prestaciones de seguridad social">Las prestaciones de seguridad social</option>
                                <option value="La libertad sindical">La libertad sindical</option>
                                <option value="La seguridad e higiene en el trabajo">La seguridad e higiene en el trabajo</option>
                                <option value="Al descanso al disfrute del tiempo libre y a la limitación razonable de la jornada de trabajo">Al descanso al disfrute del tiempo libre y a la limitación razonable de la jornada de trabajo</option>
                                <option value="Al escalafón">Al escalafón</option>
                                <option value="No ser sometido al hostigamiento laboral">No ser sometido al hostigamiento laboral</option>
                                <option value="Instrumentos y apoyos para el acceso a una vivienda digna">Instrumentos y apoyos para el acceso a una vivienda digna</option>
                                <option value="Una vivienda digna segura decorosa y con acceso a servicios e infraestructura vitales">Una vivienda digna segura decorosa y con acceso a servicios e infraestructura vitales</option>
                                <option value="Protección preservación y cuidado del medio ambiente">Protección preservación y cuidado del medio ambiente</option>
                                <option value="Disfrute de un medio ambiente sano y ecológicamente equilibrado">Disfrute de un medio ambiente sano y ecológicamente equilibrado</option>
                                <option value="La indemnización por DA">La indemnización por DA</option>
                                <option value="Al agua y al saneamiento">Al agua y al saneamiento</option>
                                <option value="Debido cobro de contribuciones e impuestos">Debido cobro de contribuciones e impuestos</option>
                                <option value="Petición">Petición</option>
                                <option value="Obtener servicios públicos de calidad">Obtener servicios públicos de calidad</option>
                                <option value="Seguridad pública">Seguridad pública</option>
                                <option value="Protección civil">Protección civil</option>
                                <option value="Políticas públicas que propicien un mejor nivel de vida">Políticas públicas que propicien un mejor nivel de vida</option>
                                <option value="Una vida en paz">Una vida en paz</option>
                                <option value="Desarrollo">Desarrollo</option>
                                <option value="Cultura física y deporte">Cultura física y deporte</option>
                                <option value="Acceso del internet">Acceso del internet</option>
                                <option value="Formar partidos políticos a agrupaciones políticas a nivel local">Formar partidos políticos a agrupaciones políticas a nivel local</option>
                                <option value="Ejercer el voto libre y sin coacción">Ejercer el voto libre y sin coacción</option>
                                <option value="Ser elegido">Ser elegido</option>
                                <option value="Una valoración y certificación médica o psicológica">Una valoración y certificación médica o psicológica</option>
                                <option value="La percepción puntual de la remuneración pactada o legalmente establecida">La percepción puntual de la remuneración pactada o legalmente establecida</option>
                                <option value="Desarrollo de la colectividad">Desarrollo de la colectividad</option>
                                <option value="Seguridad en los centros educativos">Seguridad en los centros educativos</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="autoridad">Autoridad señalada</label>
                            <select class="form-control" name="autoridad">
                                <option value="">Escoge una opción</option>
                                <option value="Otra">Otra</option>
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
                                <option value="Despacho del C. Gobernador">Despacho del C. Gobernador</option>
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
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nombre_usuario">Nombre del usuario</label>
                            <input type="text" class="form-control" name="nombre_usuario" placeholder="Nombre Completo" required>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="edad">Edad</label>
                            <input type="number" class="form-control" min="1" max="120" name="edad" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="sexo">Género</label>
                            <select class="form-control" name="sexo">
                                <option value="">Escoge una opción</option>
                                <option value="Mujer">Mujer</option>
                                <option value="Hombre">Hombre</option>
                                <option value="LGBTIQ+">LGBTIQ+</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="grupo_vulnerable">Grupo Vulnerable</label>
                            <select class="form-control" name="grupo_vulnerable">
                                <option value="">Escoge una opción</option>
                                <option value="Comunidad LGBTIQ+">Comunidad LGBTIQ+</option>
                                <option value="Derecho de las mujeres">Derecho de las mujeres</option>
                                <option value="Niñas, niños y adolescentes">Niñas, niños y adolescentes</option>
                                <option value="Personas con discapacidad">Personas con discapacidad</option>
                                <option value="Personas migrantes">Personas migrantes</option>
                                <option value="Personas que viven con VIH SIDA">Personas que viven con VIH SIDA</option>
                                <option value="Grupos indígenas">Grupos indígenas</option>
                                <option value="Periodistas">Periodistas</option>
                                <option value="Defensores de los derechos humanos">Defensores de los derechos humanos</option>
                                <option value="Adultos mayores">Adultos mayores</option>
                                <option value="Internos">Internos</option>
                                <option value="Otros">Otros</option>
                                <option value="No Aplica">No Aplica</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha_intervencion">Fecha de Intervención</label>
                            <input type="date" class="form-control" name="fecha_intervencion" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="resultado">Resultado</label>
                            <select class="form-control" name="resultado">
                                <option value="">Escoge una opción</option>
                                <option value="Positivo">Positivo</option>
                                <option value="Negativo">Negativo</option>
                                <option value="No Aplica">No Aplica</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="documento_emitido">Documento Emititdo</label>
                            <select class="form-control" name="documento_emitido">
                                <option value="">Escoge una opción</option>
                                <option value="Certificado Médico">Certificado Médico</option>
                                <option value="Opinión Médica">Opinión Médica</option>
                                <option value="No Aplica">No Aplica</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nombre_usuario">Especialista que emite</label>
                            <input type="text" class="form-control" name="nombre_especialista" placeholder="Nombre Completo del especialista" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nombre_usuario">Clave del documento</label>
                            <input type="text" class="form-control" name="clave_documento" placeholder="Insertar la clave del documento">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="adjunto">Adjuntar documento emitido</label>
                            <input type="file" accept="application/pdf" class="form-control" name="adjunto" id="adjunto">
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