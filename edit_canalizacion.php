<?php
$page_title = 'Editar Canalización';
require_once('includes/load.php');

page_require_level(5);
?>
<?php
$e_detalle = find_by_id_canalizacion((int)$_GET['id']);
if (!$e_detalle) {
    $session->msg("d", "id de canalización no encontrado.");
    redirect('canalizaciones.php');
}
$user = current_user();
$nivel = $user['user_level'];
?>

<?php
if (isset($_POST['edit_canalizacion'])) {
    $req_fields = array('nombre', 'nestudios', 'ocupacion', 'edad', 'tel', 'sexo', 'calle', 'colonia', 'cpostal', 'municipio', 'entidad', 'nacionalidad', 'medio');
    validate_fields($req_fields);
    if (empty($errors)) {
        $id = (int)$e_detalle['id'];
        $correo   = remove_junk($db->escape($_POST['correo']));
        $nombre   = remove_junk($db->escape($_POST['nombre']));
        $nestudios   = remove_junk($db->escape($_POST['nestudios']));
        $ocupacion   = remove_junk($db->escape($_POST['ocupacion']));
        $edad   = remove_junk(upper_case($db->escape($_POST['edad'])));
        $tel   = remove_junk(upper_case($db->escape($_POST['tel'])));
        $ext   = remove_junk($db->escape($_POST['ext']));
        $sexo   = remove_junk($db->escape($_POST['sexo']));
        $calle   = remove_junk($db->escape($_POST['calle']));
        $colonia   = remove_junk($db->escape($_POST['colonia']));
        $cpostal   = remove_junk($db->escape($_POST['cpostal']));
        $municipio   = remove_junk($db->escape($_POST['municipio']));
        $entidad   = remove_junk($db->escape($_POST['entidad']));
        $nacionalidad   = remove_junk($db->escape($_POST['nacionalidad']));
        $medio   = remove_junk($db->escape($_POST['medio']));
        $adjunto   = remove_junk($db->escape($_POST['adjunto']));
        $observaciones   = remove_junk($db->escape($_POST['observaciones']));
        //$name = remove_junk((int)$db->escape($_POST['detalle-user']));

        $folio_editar = $e_detalle['folio'];
        $resultado = str_replace("/", "-", $folio_editar);
        $carpeta = 'uploads/orientacioncanalizacion/canalizacion/' . $resultado;

        $name = $_FILES['adjunto']['name'];
        $size = $_FILES['adjunto']['size'];
        $type = $_FILES['adjunto']['type'];
        $temp = $_FILES['adjunto']['tmp_name'];

        if (is_dir($carpeta)) {
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        }

        if ($name != '') {
            $sql = "UPDATE orientacion_canalizacion SET correo_electronico='{$correo}', nombre_completo='{$nombre}', nivel_estudios='{$nestudios}', ocupacion='{$ocupacion}', edad='{$edad}', telefono='{$tel}', extension='{$ext}', sexo='{$sexo}', calle_numero='{$calle}', colonia='{$colonia}',codigo_postal='{$cpostal}', municipio_localidad='{$municipio}', entidad='{$entidad}', nacionalidad='{$nacionalidad}', medio_presentacion='{$medio}', observaciones='{$observaciones}', adjunto='{$name}' WHERE id='{$db->escape($id)}'";
        }
        if ($name == '') {
            $sql = "UPDATE orientacion_canalizacion SET correo_electronico='{$correo}', nombre_completo='{$nombre}', nivel_estudios='{$nestudios}', ocupacion='{$ocupacion}', edad='{$edad}', telefono='{$tel}', extension='{$ext}', sexo='{$sexo}', calle_numero='{$calle}', colonia='{$colonia}',codigo_postal='{$cpostal}', municipio_localidad='{$municipio}', entidad='{$entidad}', nacionalidad='{$nacionalidad}', medio_presentacion='{$medio}', observaciones='{$observaciones}' WHERE id='{$db->escape($id)}'";
        }
        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            $session->msg('s', "Información Actualizada");
            redirect('canalizaciones.php', false);
        } else {
            $session->msg('d', 'Lo siento no se actualizaron los datos.');
            redirect('canalizaciones.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_canalizacion.php?id=' . (int)$e_detalle['id'], false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Editar canalización <?php echo $e_detalle['folio']; ?></span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="edit_canalizacion.php?id=<?php echo (int)$e_detalle['id']; ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="correo">Correo Electrónico</label>
                            <input type="text" class="form-control" name="correo" placeholder="ejemplo@correo.com" value="<?php echo remove_junk($e_detalle['correo_electronico']); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nombre">Nombre Completo</label>
                            <input type="text" class="form-control" name="nombre" placeholder="Nombre Completo" value="<?php echo remove_junk($e_detalle['nombre_completo']); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nestudios">Nivel de Estudios</label>
                            <select class="form-control" name="nestudios">
                                <option <?php if ($e_detalle['nivel_estudios'] === 'Sin estudios') echo 'selected="selected"'; ?> value="Sin estudios">Sin estudios</option>
                                <option <?php if ($e_detalle['nivel_estudios'] === 'Primaria') echo 'selected="selected"'; ?> value="Primaria">Primaria</option>
                                <option <?php if ($e_detalle['nivel_estudios'] === 'Secundaria') echo 'selected="selected"'; ?> value="Secundaria">Secundaria</option>
                                <option <?php if ($e_detalle['nivel_estudios'] === 'Preparatoria') echo 'selected="selected"'; ?> value="Preparatoria">Preparatoria</option>
                                <option <?php if ($e_detalle['nivel_estudios'] === 'Licenciatura') echo 'selected="selected"'; ?> value="Licenciatura">Licenciatura</option>
                                <option <?php if ($e_detalle['nivel_estudios'] === 'Especialidad') echo 'selected="selected"'; ?> value="Especialidad">Especialidad</option>
                                <option <?php if ($e_detalle['nivel_estudios'] === 'Maestría') echo 'selected="selected"'; ?> value="Maestría">Maestría</option>
                                <option <?php if ($e_detalle['nivel_estudios'] === 'Doctorado') echo 'selected="selected"'; ?> value="Doctorado">Doctorado</option>
                                <option <?php if ($e_detalle['nivel_estudios'] === 'Pos Doctorado') echo 'selected="selected"'; ?> value="Pos Doctorado">Pos Doctorado</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="ocupacion">Ocupacion</label>
                            <select class="form-control" name="ocupacion">
                                <option <?php if ($e_detalle['ocupacion'] === 'Agricultor(a)') echo 'selected="selected"'; ?> value="Agricultor(a)">Agricultor</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Albañil') echo 'selected="selected"'; ?> value="Albañil">Albañil</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Ama de Casa') echo 'selected="selected"'; ?> value="Ama de Casa">Ama de Casa</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Artista') echo 'selected="selected"'; ?> value="Artista">Artista</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Artesano(a)') echo 'selected="selected"'; ?> value="Artesano(a)">Artesano</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Pescador(a)') echo 'selected="selected"'; ?> value="Pescador(a)">Pescador</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Camionero(a)') echo 'selected="selected"'; ?> value="Camionero(a)">Camionero(a)</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Carpintero(a)') echo 'selected="selected"'; ?> value="Carpintero(a)">Carpintero(a)</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Cocinero(a)') echo 'selected="selected"'; ?> value="Cocinero(a)">Cocinero(a)</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Comerciante') echo 'selected="selected"'; ?> value="Comerciante">Comerciante</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Chofer') echo 'selected="selected"'; ?> value="Chofer">Chofer</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Deportista') echo 'selected="selected"'; ?> value="Deportista">Deportista</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Empleada doméstica') echo 'selected="selected"'; ?> value="Empleada doméstica">Empleada doméstica</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Servidor(a) público(a)') echo 'selected="selected"'; ?> value="Servidor(a) público(a)">Servidor(a) público(a)</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Empleado(a) de negocio') echo 'selected="selected"'; ?> value="Empleado(a) de negocio">Empleado(a) de negocio</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Empresario(a)') echo 'selected="selected"'; ?> value="Empresario(a)">Empresario(a)</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Estilista') echo 'selected="selected"'; ?> value="Estilista">Estilista</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Estudiante') echo 'selected="selected"'; ?> value="Estudiante">Estudiante</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Ganadero(a)') echo 'selected="selected"'; ?> value="Ganadero(a)">Ganadero(a)</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Intendente') echo 'selected="selected"'; ?> value="Intendente">Intendente</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Jornalero(a)') echo 'selected="selected"'; ?> value="Jornalero(a)">Jornalero(a)</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Jubilado(a)') echo 'selected="selected"'; ?> value="Jubilado(a)">Jubilado(a)</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Locutor(a)') echo 'selected="selected"'; ?> value="Locutor(a)">Locutor(a)</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Profesor(a)') echo 'selected="selected"'; ?> value="Profesor(a)">Profesor(a)</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Mecánico(a)') echo 'selected="selected"'; ?> value="Mecánico(a)">Mecánico(a)</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Migrante') echo 'selected="selected"'; ?> value="Migrante">Migrante</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Parroco') echo 'selected="selected"'; ?> value="Parroco">Parroco</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Peluquero(a)') echo 'selected="selected"'; ?> value="Peluquero(a)">Peluquero(a)</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Pensionado(a)') echo 'selected="selected"'; ?> value="Pensionado(a)">Pensionado(a)</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Periodista') echo 'selected="selected"'; ?> value="Periodista">Periodista</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Plomero(a)') echo 'selected="selected"'; ?> value="Plomero(a)">Plomero(a)</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Reportero(a)') echo 'selected="selected"'; ?> value="Reportero(a)">Reportero(a)</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Servidor(a) sexual') echo 'selected="selected"'; ?> value="Servidor(a) sexual">Servidor(a) sexual</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Taxista') echo 'selected="selected"'; ?> value="Taxista">Taxista</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Transportista') echo 'selected="selected"'; ?> value="Transportista">Transportista</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Interno(a)') echo 'selected="selected"'; ?> value="Interno(a)">Interno(a)</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Franelero') echo 'selected="selected"'; ?> value="Franelero">Franelero</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Desempleado') echo 'selected="selected"'; ?> value="Desempleado">Desempleado</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Contratista') echo 'selected="selected"'; ?> value="Contratista">Contratista</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Policia') echo 'selected="selected"'; ?> value="Policia">Policia</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Ninguno') echo 'selected="selected"'; ?> value="Ninguno">Ninguno</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Litigante') echo 'selected="selected"'; ?> value="Litigante">Litigante</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Defensor(a) civil de los derechos humanos') echo 'selected="selected"'; ?> value="Defensor(a) civil de los derechos humanos">Defensor(a) civil de los derechos humanos</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Profesionista práctica privada') echo 'selected="selected"'; ?> value="Profesionista práctica privada">Profesionista práctica privada</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Investigador(a)') echo 'selected="selected"'; ?> value="Investigador(a)">Investigador(a)</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Obrero(a)') echo 'selected="selected"'; ?> value="Obrero(a)">Obrero(a)</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Enfermera(o) especialista en salud') echo 'selected="selected"'; ?> value="Enfermera(o) especialista en salud">Enfermera(o) especialista en salud</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Auxiliar en actividades administrativas') echo 'selected="selected"'; ?> value="Auxiliar en actividades administrativas">Auxiliar en actividades administrativas</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Secretaria(o)') echo 'selected="selected"'; ?> value="Secretaria(o)">Secretaria(o)</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Cajero(a)') echo 'selected="selected"'; ?> value="Cajero(a)">Cajero(a)</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Comerciante en establecimiento') echo 'selected="selected"'; ?> value="Comerciante en establecimiento">Comerciante en establecimiento</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Comerciante Ambulante') echo 'selected="selected"'; ?> value="Comerciante Ambulante">Comerciante Ambulante</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Atención al público') echo 'selected="selected"'; ?> value="Atención al público">Atención al público</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Empleado(a) del sector público') echo 'selected="selected"'; ?> value="Empleado(a) del sector público">Empleado(a) del sector público</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Empleado(a) del sector privado') echo 'selected="selected"'; ?> value="Empleado(a) del sector privado">Empleado(a) del sector privado</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Preparación y servicio de alimentos') echo 'selected="selected"'; ?> value="Preparación y servicio de alimentos">Preparación y servicio de alimentos</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Cuidados personales y del hogar') echo 'selected="selected"'; ?> value="Cuidados personales y del hogar">Cuidados personales y del hogar</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Servicios de protección y vigilancia') echo 'selected="selected"'; ?> value="Servicios de protección y vigilancia">Servicios de protección y vigilancia</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Armada, ejercito y fuerza aérea') echo 'selected="selected"'; ?> value="Armada, ejercito y fuerza aérea">Armada, ejercito y fuerza aérea</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Actividades agrícolas y ganaderas') echo 'selected="selected"'; ?> value="Actividades agrícolas y ganaderas">Actividades agrícolas y ganaderas</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Actividades pesqueras, forestales, caza y similares') echo 'selected="selected"'; ?> value="Actividades pesqueras, forestales, caza y similares ">Actividades pesqueras, forestales, caza y similares</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Operador(a) de maquinaria pesada') echo 'selected="selected"'; ?> value="Operador(a) de maquinaria pesada">Operador(a) de maquinaria pesada</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Extracción y edificador de construcciones') echo 'selected="selected"'; ?> value="Extracción y edificador de construcciones">Extracción y edificador de construcciones</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Ensamblador(a)') echo 'selected="selected"'; ?> value="Ensamblador(a)">Ensamblador(a)</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Agente de ventas') echo 'selected="selected"'; ?> value="Agente de ventas">Agente de ventas</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Pintor(a)') echo 'selected="selected"'; ?> value="Pintor(a)">Pintor(a)</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Trabajador(a) de apoyo para espectaculos') echo 'selected="selected"'; ?> value="Trabajador(a) de apoyo para espectaculos">Trabajador(a) de apoyo para espectaculos</option>
                                <option <?php if ($e_detalle['ocupacion'] === 'Repartidor(a) de mercancias') echo 'selected="selected"'; ?> value="Repartidor(a) de mercancias">Repartidor(a) de mercancias</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="edad">Edad</label>
                            <input type="number" min="1" max="120" class="form-control" name="edad" placeholder="Edad" value="<?php echo remove_junk($e_detalle['edad']); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tel">Teléfono</label>
                            <input type="text" class="form-control" maxlength="10" name="tel" placeholder="Teléfono" value="<?php echo remove_junk($e_detalle['telefono']); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="ext">Ext</label>
                            <input type="text" class="form-control" maxlength="3" name="ext" placeholder="Extensión" value="<?php echo remove_junk($e_detalle['extension']); ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="sexo">Sexo</label>
                            <select class="form-control" name="sexo">
                                <option <?php if ($e_detalle['sexo'] === 'M') echo 'selected="selected"'; ?> value="M">Mujer</option>
                                <option <?php if ($e_detalle['sexo'] === 'H') echo 'selected="selected"'; ?> value="H">Hombre</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="calle">Calle y número</label>
                            <input type="text" class="form-control" name="calle" placeholder="Calle y número" value="<?php echo remove_junk($e_detalle['calle_numero']); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="colonia">Colonia</label>
                            <input type="text" class="form-control" name="colonia" placeholder="Colonia" value="<?php echo remove_junk($e_detalle['colonia']); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="cpostal">Código Postal</label>
                            <input type="text" class="form-control" maxlength="5" name="cpostal" placeholder="Código Postal" value="<?php echo remove_junk($e_detalle['codigo_postal']); ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="municipio">Municipio/Localidad</label>
                            <input type="text" class="form-control" name="municipio" placeholder="Municipio/Localidad" value="<?php echo remove_junk($e_detalle['municipio_localidad']); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="entidad">Entidad</label>
                            <select class="form-control" name="entidad">
                                <option <?php if ($e_detalle['entidad'] === 'Michoacán') echo 'selected="selected"'; ?> value="Michoacán">Michoacán</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nacionalidad">Nacionalidad</label>
                            <select class="form-control" name="nacionalidad">
                                <option value="Mexicana" <?php if ($e_detalle['nacionalidad'] === 'Mexicana') echo 'selected="selected"'; ?>>Mexicana</option>
                                <option value="Extranjera" <?php if ($e_detalle['nacionalidad'] === 'Extranjera') echo 'selected="selected"'; ?>>Extranjera</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="medio">Medio de presentación</label>
                            <select class="form-control" name="medio">
                                <option value="Asesor Virtual" <?php if ($e_detalle['medio_presentacion'] === 'Asesor Virtual') echo 'selected="selected"'; ?>>Asesor Virtual</option>
                                <option value="Asistente Virtual" <?php if ($e_detalle['medio_presentacion'] === 'Asistente Virtual') echo 'selected="selected"'; ?>>Asistente Virtual</option>
                                <option value="Comparecencia" <?php if ($e_detalle['medio_presentacion'] === 'Comparecencia') echo 'selected="selected"'; ?>>Comparecencia</option>
                                <option value="Escrito" <?php if ($e_detalle['medio_presentacion'] === 'Escrito') echo 'selected="selected"'; ?>>Escrito</option>
                                <option value="Vía telefónica" <?php if ($e_detalle['medio_presentacion'] === 'Vía telefónica') echo 'selected="selected"'; ?>>Vía telefónica</option>
                                <option value="Vía electrónica" <?php if ($e_detalle['medio_presentacion'] === 'Vía electrónica') echo 'selected="selected"'; ?>>Vía electrónica</option>
                                <option value="Comisión Nacional de los Derechos Humanos" <?php if ($e_detalle['medio_presentacion'] === 'Comisión Nacional de los Derechos Humanos') echo 'selected="selected"'; ?>>Comisión Nacional de los Derechos Humanos</option>
                                <option value="Quejas de oficio" <?php if ($e_detalle['medio_presentacion'] === 'Quejas de oficio') echo 'selected="selected"'; ?>>Quejas de oficio</option>
                                <option value="Quejas remitidas a visitadurias" <?php if ($e_detalle['medio_presentacion'] === 'Quejas remitidas a visitadurias') echo 'selected="selected"'; ?>>Quejas remitidas a visitadurias</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="adjunto">Adjunto</label>
                            <input type="file" accept="application/pdf" class="form-control" name="adjunto" id="adjunto" value="uploads/orientacioncanalizacion/<?php echo $e_detalle['adjunto']; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="observaciones">Observaciones</label><br>
                            <textarea name="observaciones" class="form-control" id="observaciones" cols="50" rows="2" value="<?php echo remove_junk($e_detalle['observaciones']); ?>"><?php echo remove_junk($e_detalle['observaciones']); ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group clearfix">
                    <a href="canalizaciones.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="edit_canalizacion" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>