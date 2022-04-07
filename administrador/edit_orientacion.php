<?php
$page_title = 'Editar Orientación';
require_once('includes/load.php');

// page_require_level(5);
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
$nivel_user = $user['user_level'];

if ($nivel_user <= 2) {
    page_require_level(2);
}
if ($nivel_user == 3) {
    redirect('home.php');
}
if ($nivel_user == 4) {
    redirect('home.php');
}
if ($nivel_user == 5) {
    page_require_level_exacto(5);
}
if ($nivel_user == 6) {
    redirect('home.php');
}
if ($nivel_user == 7) {
    redirect('home.php');
}
?>
<?php
$e_detalle = find_by_id_orientacion((int)$_GET['id']);
if (!$e_detalle) {
    $session->msg("d", "id de orientación no encontrado.");
    redirect('orientaciones.php');
}
// $user = current_user();
// $nivel = $user['user_level'];
?>

<?php
if (isset($_POST['edit_orientacion'])) {
    $req_fields = array('nombre', 'nestudios', 'ocupacion', 'edad', 'tel', 'sexo', 'calle', 'colonia', 'cpostal', 'municipio', 'entidad', 'nacionalidad', 'grupo_vulnerable', 'lengua');
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
        //$name = remove_junk((int)$db->escape($_POST['detalle-user']));
        $medio   = remove_junk($db->escape($_POST['medio']));
        $grupo_vulnerable   = remove_junk($db->escape($_POST['grupo_vulnerable']));
        $lengua   = remove_junk($db->escape($_POST['lengua']));
        $adjunto   = remove_junk($db->escape($_POST['adjunto']));
        $observaciones   = remove_junk($db->escape($_POST['observaciones']));
        //$name = remove_junk((int)$db->escape($_POST['detalle-user']));

        $folio_editar = $e_detalle['folio'];
        $resultado = str_replace("/", "-", $folio_editar);
        $carpeta = 'uploads/orientacioncanalizacion/orientacion/' . $resultado;

        $name = $_FILES['adjunto']['name'];
        $size = $_FILES['adjunto']['size'];
        $type = $_FILES['adjunto']['type'];
        $temp = $_FILES['adjunto']['tmp_name'];

        if (is_dir($carpeta)) {
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        }

        // $move =  move_uploaded_file($temp, "uploads/orientacioncanalizacion/" . $name);

        if ($name != '') {
            $sql = "UPDATE orientacion_canalizacion SET correo_electronico='{$correo}', nombre_completo='{$nombre}', nivel_estudios='{$nestudios}', ocupacion='{$ocupacion}', edad='{$edad}', telefono='{$tel}', extension='{$ext}', sexo='{$sexo}', calle_numero='{$calle}', colonia='{$colonia}',codigo_postal='{$cpostal}', municipio_localidad='{$municipio}', entidad='{$entidad}', nacionalidad='{$nacionalidad}', medio_presentacion='{$medio}', grupo_vulnerable='{$grupo_vulnerable}', lengua='{$lengua}', observaciones='{$observaciones}', adjunto='{$name}' WHERE id='{$db->escape($id)}'";
        }
        if ($name == '') {
            $sql = "UPDATE orientacion_canalizacion SET correo_electronico='{$correo}', nombre_completo='{$nombre}', nivel_estudios='{$nestudios}', ocupacion='{$ocupacion}', edad='{$edad}', telefono='{$tel}', extension='{$ext}', sexo='{$sexo}', calle_numero='{$calle}', colonia='{$colonia}',codigo_postal='{$cpostal}', municipio_localidad='{$municipio}', entidad='{$entidad}', nacionalidad='{$nacionalidad}', medio_presentacion='{$medio}', grupo_vulnerable='{$grupo_vulnerable}', lengua='{$lengua}', observaciones='{$observaciones}' WHERE id='{$db->escape($id)}'";
        }
        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            $session->msg('s', "Información Actualizada ");
            redirect('orientaciones.php', false);
        } else {
            $session->msg('d', ' Lo siento no se actualizaron los datos.');
            redirect('orientaciones.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_orientacion.php?id=' . (int)$e_detalle['id'], false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Editar orientación <?php echo $e_detalle['folio']; ?></span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="edit_orientacion.php?id=<?php echo (int)$e_detalle['id']; ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="correo">Correo Electrónico</label>
                            <input type="text" class="form-control" name="correo" placeholder="ejemplo@correo.com" value="<?php echo remove_junk($e_detalle['correo_electronico']); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nombre">Nombre Completo</label>
                            <input type="text" class="form-control" name="nombre" placeholder="Nombre Completo" value="<?php echo remove_junk($e_detalle['nombre_completo']); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
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
                    <div class="col-md-4">
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
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="edad">Edad</label>
                            <input type="number" min="1" max="120" class="form-control" name="edad" placeholder="Edad" value="<?php echo remove_junk($e_detalle['edad']); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
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
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="lengua">Dialecto</label>
                            <input type="text" class="form-control" name="lengua" value="<?php echo remove_junk($e_detalle['lengua']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="grupo_vulnerable">Grupo Vulnerable</label>
                            <select class="form-control" name="grupo_vulnerable">
                                <option <?php if ($e_detalle['grupo_vulnerable'] === 'Comunidad LGBT') echo 'selected="selected"'; ?> value="Comunidad LGBT">Comunidad LGBT</option>
                                <option <?php if ($e_detalle['grupo_vulnerable'] === 'Derecho de las mujeres') echo 'selected="selected"'; ?> value="Derecho de las mujeres">Derecho de las mujeres</option>
                                <option <?php if ($e_detalle['grupo_vulnerable'] === 'Niños y adolescentes') echo 'selected="selected"'; ?> value="Niños y adolescentes">Niños y adolecentes</option>
                                <option <?php if ($e_detalle['grupo_vulnerable'] === 'Personas con discapacidad') echo 'selected="selected"'; ?> value="Personas con discapacidad">Personas con discapacidad</option>
                                <option <?php if ($e_detalle['grupo_vulnerable'] === 'Personas migrantes') echo 'selected="selected"'; ?> value="Personas migrantes">Personas migrantes</option>
                                <option <?php if ($e_detalle['grupo_vulnerable'] === 'Personas que viven con VIH SIDA') echo 'selected="selected"'; ?> value="Personas que viven con VIH SIDA">Personas que viven con VIH SIDA</option>
                                <option <?php if ($e_detalle['grupo_vulnerable'] === 'Grupos indígenas') echo 'selected="selected"'; ?> value="Grupos indígenas">Grupos indígenas</option>
                                <option <?php if ($e_detalle['grupo_vulnerable'] === 'Periodistas') echo 'selected="selected"'; ?> value="Periodistas">Periodistas</option>
                                <option <?php if ($e_detalle['grupo_vulnerable'] === 'Defensores de los derechos humanos') echo 'selected="selected"'; ?> value="Defensores de los derechos humanos">Defensores de los derechos humanos</option>
                                <option <?php if ($e_detalle['grupo_vulnerable'] === 'Adultos mayores') echo 'selected="selected"'; ?> value="Adultos mayores">Adultos mayores</option>
                                <option <?php if ($e_detalle['grupo_vulnerable'] === 'Internos') echo 'selected="selected"'; ?> value="Internos">Internos</option>
                                <option <?php if ($e_detalle['grupo_vulnerable'] === 'Otros') echo 'selected="selected"'; ?> value="Otros">Otros</option>
                            </select>
                        </div>
                    </div>    
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="sexo">Género</label>
                            <select class="form-control" name="sexo">
                                <option <?php if ($e_detalle['sexo'] === 'M') echo 'selected="selected"'; ?> value="M">Mujer</option>
                                <option <?php if ($e_detalle['sexo'] === 'H') echo 'selected="selected"'; ?> value="H">Hombre</option>
                                <option <?php if ($e_detalle['sexo'] === 'LGBT') echo 'selected="selected"'; ?> value="LGBT">LGBT</option>
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
                                <option <?php if ($e_detalle['entidad'] === 'Aguascalientes') echo 'selected="selected"'; ?> value="Aguascalientes">Aguascalientes</option>
                                <option <?php if ($e_detalle['entidad'] === 'Baja California') echo 'selected="selected"'; ?> value="Baja California">Baja California</option>
                                <option <?php if ($e_detalle['entidad'] === 'Baja California Sur') echo 'selected="selected"'; ?> value="Baja California Sur">Baja California Sur</option>
                                <option <?php if ($e_detalle['entidad'] === 'Campeche') echo 'selected="selected"'; ?> value="Campeche">Campeche</option>
                                <option <?php if ($e_detalle['entidad'] === 'Chiapas') echo 'selected="selected"'; ?> value="Chiapas">Chiapas</option>
                                <option <?php if ($e_detalle['entidad'] === 'Chihuahua') echo 'selected="selected"'; ?> value="Chihuahua">Chihuahua</option>
                                <option <?php if ($e_detalle['entidad'] === 'Ciudad de México') echo 'selected="selected"'; ?> value="Ciudad de México">Ciudad de México</option>
                                <option <?php if ($e_detalle['entidad'] === 'Coahuila') echo 'selected="selected"'; ?> value="Coahuila">Coahuila</option>
                                <option <?php if ($e_detalle['entidad'] === 'Colima') echo 'selected="selected"'; ?> value="Colima">Colima</option>
                                <option <?php if ($e_detalle['entidad'] === 'Durango') echo 'selected="selected"'; ?> value="Durango">Durango</option>                                
                                <option <?php if ($e_detalle['entidad'] === 'Guanajuato') echo 'selected="selected"'; ?> value="Guanajuato">Guanajuato</option>
                                <option <?php if ($e_detalle['entidad'] === 'Guerrero') echo 'selected="selected"'; ?> value="Guerrero">Guerrero</option>
                                <option <?php if ($e_detalle['entidad'] === 'Hidalgo') echo 'selected="selected"'; ?> value="Hidalgo">Hidalgo</option>
                                <option <?php if ($e_detalle['entidad'] === 'Jalisco') echo 'selected="selected"'; ?> value="Jalisco">Jalisco</option>
                                <option <?php if ($e_detalle['entidad'] === 'Estado de México') echo 'selected="selected"'; ?> value="Estado de México">Estado de México</option>
                                <option <?php if ($e_detalle['entidad'] === 'Michoacán') echo 'selected="selected"'; ?> value="Michoacán">Michoacán</option>
                                <option <?php if ($e_detalle['entidad'] === 'Morelos') echo 'selected="selected"'; ?> value="Morelos">Morelos</option>
                                <option <?php if ($e_detalle['entidad'] === 'Nayarit') echo 'selected="selected"'; ?> value="Nayarit">Nayarit</option>
                                <option <?php if ($e_detalle['entidad'] === 'Nuevo León') echo 'selected="selected"'; ?> value="Nuevo León">Nuevo León</option>
                                <option <?php if ($e_detalle['entidad'] === 'Oaxaca') echo 'selected="selected"'; ?> value="Oaxaca">Oaxaca</option>
                                <option <?php if ($e_detalle['entidad'] === 'Puebla') echo 'selected="selected"'; ?> value="Puebla">Puebla</option>
                                <option <?php if ($e_detalle['entidad'] === 'Querétaro') echo 'selected="selected"'; ?> value="Querétaro">Querétaro</option>
                                <option <?php if ($e_detalle['entidad'] === 'Quintana Roo') echo 'selected="selected"'; ?> value="Quintana Roo">Quintana Roo</option>
                                <option <?php if ($e_detalle['entidad'] === 'San Luis Potosí') echo 'selected="selected"'; ?> value="San Luis Potosí">San Luis Potosí</option>
                                <option <?php if ($e_detalle['entidad'] === 'Sinaloa') echo 'selected="selected"'; ?> value="Sinaloa">Sinaloa</option>
                                <option <?php if ($e_detalle['entidad'] === 'Sonora') echo 'selected="selected"'; ?> value="Sonora">Sonora</option>
                                <option <?php if ($e_detalle['entidad'] === 'Tabasco') echo 'selected="selected"'; ?> value="Tabasco">Tabasco</option>
                                <option <?php if ($e_detalle['entidad'] === 'Tamaulipas') echo 'selected="selected"'; ?> value="Tamaulipas">Tamaulipas</option>
                                <option <?php if ($e_detalle['entidad'] === 'Tlaxcala') echo 'selected="selected"'; ?> value="Tlaxcala">Tlaxcala</option>
                                <option <?php if ($e_detalle['entidad'] === 'Veracruz') echo 'selected="selected"'; ?> value="Veracruz">Veracruz</option>
                                <option <?php if ($e_detalle['entidad'] === 'Yucatán') echo 'selected="selected"'; ?> value="Yucatán">Yucatán</option>
                                <option <?php if ($e_detalle['entidad'] === 'Zacatecas') echo 'selected="selected"'; ?> value="Zacatecas">Zacatecas</option>                                
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nacionalidad">Nacionalidad</label>
                            <select class="form-control" name="nacionalidad">
                                <option <?php if ($e_detalle['nacionalidad'] === 'Mexicana') echo 'selected="selected"'; ?> value="Mexicana">Mexicana</option>
                                <option <?php if ($e_detalle['nacionalidad'] === 'Extranjera') echo 'selected="selected"'; ?> value="Extranjera">Extranjera</option>
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
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="adjunto">Adjunto</label>
                            <input type="file" accept="application/pdf" class="form-control" name="adjunto" id="adjunto" value="uploads/orientacioncanalizacion/<?php echo $e_detalle['adjunto']; ?>">
                            <label style="font-size:12px; color:#E3054F;">Archivo Actual: <?php echo remove_junk($e_detalle['adjunto']); ?></label>
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
                    <a href="orientaciones.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="edit_orientacion" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>