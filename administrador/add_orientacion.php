<?php
error_reporting(E_ALL ^ E_NOTICE);
header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar Orientación';
require_once('includes/load.php');
// $user = current_user();
$user = current_user();
$detalle = $user['id'];
$id_ori_canal = last_id_oricanal();
$id_folio = last_id_folios();


$nivel = $user['user_level'];
$id_user = $user['id'];
$nivel_user = $user['user_level'];

if ($nivel_user <= 2) {
    page_require_level(2);
}
if ($nivel_user == 5) {
    page_require_level_exacto(5);
}
if ($nivel_user == 7) {
    redirect('home.php');
}
if ($nivel_user > 2 && $nivel_user < 5) :
    redirect('home.php');
endif;
if ($nivel_user > 5) :
    redirect('home.php');
endif;
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['add_orientacion'])) {

    $req_fields = array('nombre', 'nestudios', 'ocupacion', 'edad', 'tel', 'sexo', 'calle', 'colonia', 'cpostal', 'municipio', 'entidad', 'nacionalidad', 'medio', 'grupo_vulnerable', 'lengua');
    validate_fields($req_fields);

    if (empty($errors)) {
        $correo   = remove_junk($db->escape($_POST['correo']));
        $nombre   = remove_junk($db->escape($_POST['nombre']));
        $nestudios   = remove_junk($db->escape($_POST['nestudios']));
        $ocupacion   = remove_junk($db->escape($_POST['ocupacion']));
        $edad   = remove_junk(($db->escape($_POST['edad'])));
        $tel   = remove_junk(($db->escape($_POST['tel'])));
        $ext   = remove_junk($db->escape($_POST['ext']));
        $sexo   = remove_junk($db->escape($_POST['sexo']));
        $calle   = remove_junk($db->escape($_POST['calle']));
        $colonia   = remove_junk($db->escape($_POST['colonia']));
        $cpostal   = remove_junk($db->escape($_POST['cpostal']));
        $municipio   = remove_junk($db->escape($_POST['municipio']));
        $entidad   = remove_junk($db->escape($_POST['entidad']));
        $nacionalidad   = remove_junk($db->escape($_POST['nacionalidad']));
        $medio   = remove_junk($db->escape($_POST['medio']));
        $grupo_vulnerable   = remove_junk($db->escape($_POST['grupo_vulnerable']));
        $lengua   = remove_junk($db->escape($_POST['lengua']));
        $observaciones   = remove_junk($db->escape($_POST['observaciones']));
        $adjunto   = remove_junk($db->escape($_POST['adjunto']));
        // $id_creador   = remove_junk($db->escape($_POST['creador']));        

        //Suma el valor del id anterior + 1, para generar ese id para el nuevo resguardo
        //La variable $no_folio sirve para el numero de folio
        if (count($id_ori_canal) == 0) {
            $nuevo_id_ori_canal = 1;
            $no_folio = sprintf('%04d', 1);
        } else {
            foreach ($id_ori_canal as $nuevo) {
                $nuevo_id_ori_canal = (int)$nuevo['id'] + 1;
                $no_folio = sprintf('%04d', (int)$nuevo['id'] + 1);
            }
        }

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
        $folio = 'CEDH/' . $no_folio1 . '/' . $year . '-O';

        $folio_carpeta = 'CEDH-' . $no_folio1 . '-' . $year . '-O';
        $carpeta = 'uploads/orientacioncanalizacion/orientacion/' . $folio_carpeta;

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $name = $_FILES['adjunto']['name'];
        $size = $_FILES['adjunto']['size'];
        $type = $_FILES['adjunto']['type'];
        $temp = $_FILES['adjunto']['tmp_name'];

        $move =  move_uploaded_file($temp, $carpeta . "/" . $name);

        if ($move && $name != '') {
            $query = "INSERT INTO orientacion_canalizacion (";
            $query .= "folio,correo_electronico,nombre_completo,nivel_estudios,ocupacion,edad,telefono,extension,sexo,calle_numero,colonia,codigo_postal,municipio_localidad,entidad,nacionalidad,tipo_solicitud,medio_presentacion,grupo_vulnerable,lengua,observaciones,adjunto,id_creador";
            $query .= ") VALUES (";
            $query .= " '{$folio}','{$correo}','{$nombre}','{$nestudios}','{$ocupacion}','{$edad}','{$tel}','{$ext}','{$sexo}','{$calle}','{$colonia}','{$cpostal}','{$municipio}','{$entidad}','{$nacionalidad}','1','{$medio}','{$grupo_vulnerable}','{$lengua}','{$observaciones}','{$name}','{$detalle}'";
            $query .= ")";

            $query2 = "INSERT INTO folios (";
            $query2 .= "folio, contador";
            $query2 .= ") VALUES (";
            $query2 .= " '{$folio}','{$no_folio1}'";
            $query2 .= ")";
        } else {
            $query = "INSERT INTO orientacion_canalizacion (";
            $query .= "folio,correo_electronico,nombre_completo,nivel_estudios,ocupacion,edad,telefono,extension,sexo,calle_numero,colonia,codigo_postal,municipio_localidad,entidad,nacionalidad,tipo_solicitud,medio_presentacion,grupo_vulnerable,lengua,observaciones,adjunto,id_creador";
            $query .= ") VALUES (";
            $query .= " '{$folio}','{$correo}','{$nombre}','{$nestudios}','{$ocupacion}','{$edad}','{$tel}','{$ext}','{$sexo}','{$calle}','{$colonia}','{$cpostal}','{$municipio}','{$entidad}','{$nacionalidad}','1','{$medio}','{$grupo_vulnerable}','{$lengua}','{$observaciones}','{$name}','{$detalle}'";
            $query .= ")";

            $query2 = "INSERT INTO folios (";
            $query2 .= "folio, contador";
            $query2 .= ") VALUES (";
            $query2 .= " '{$folio}','{$no_folio1}'";
            $query2 .= ")";
        }

        if ($db->query($query) && $db->query($query2)) {
            //sucess
            $session->msg('s', " La orientación ha sido agregada con éxito.");
            redirect('orientaciones.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar la orientación.');
            redirect('add_orientacion.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_orientacion.php', false);
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
                <span>Agregar orientación</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_orientacion.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="correo">Correo Electrónico</label>
                            <input type="text" class="form-control" name="correo" placeholder="ejemplo@correo.com" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nombre">Nombre Completo</label>
                            <input type="text" class="form-control" name="nombre" placeholder="Nombre Completo" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="nestudios">Nivel de Estudios</label>
                            <select class="form-control" name="nestudios">
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ocupacion">Ocupacion</label>
                            <select class="form-control" name="ocupacion">
                                <option value="Agricultor(a)">Agricultor</option>
                                <option value="Albañil">Albañil</option>
                                <option value="Ama de Casa">Ama de Casa</option>
                                <option value="Artista">Artista</option>
                                <option value="Artesano(a)">Artesano</option>
                                <option value="Pescador(a)">Pescador</option>
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
                                <option value="Actividades pesqueras, forestales, caza y similares ">Actividades pesqueras, forestales, caza y similares</option>
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
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="edad">Edad</label>
                            <input type="number" min="1" max="120" class="form-control" name="edad" placeholder="Edad" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="tel">Teléfono</label>
                            <input type="text" class="form-control" maxlength="10" name="tel" placeholder="Teléfono" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="ext">Ext</label>
                            <input type="text" class="form-control" maxlength="3" name="ext" placeholder="Extensión">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="lengua">Dialecto</label>
                            <input type="text" class="form-control" name="lengua" placeholder="Lengua hablada" required>
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
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="sexo">Género</label>
                            <select class="form-control" name="sexo">
                                <option value="M">Mujer</option>
                                <option value="H">Hombre</option>
                                <option value="LGBT">LGBT</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="calle">Calle y número</label>
                            <input type="text" class="form-control" name="calle" placeholder="Calle y número" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="colonia">Colonia</label>
                            <input type="text" class="form-control" name="colonia" placeholder="Colonia" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="cpostal">Código Postal</label>
                            <input type="text" class="form-control" maxlength="5" name="cpostal" placeholder="Código Postal" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="municipio">Municipio/Localidad</label>
                            <input type="text" class="form-control" name="municipio" placeholder="Municipio/Localidad" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="entidad">Entidad</label>
                            <select class="form-control" name="entidad">
                                <option value="">Escoge una opción</option>
                                <option value="Aguascalientes">Aguascalientes</option>
                                <option value="Baja California">Baja California</option>
                                <option value="Baja California Sur">Baja California Sur</option>
                                <option value="Campeche">Campeche</option>
                                <option value="Chiapas">Chiapas</option>
                                <option value="Chihuahua">Chihuahua</option>
                                <option value="Ciudad de México">Ciudad de México</option>
                                <option value="Coahuila">Coahuila</option>
                                <option value="Colima">Colima</option>
                                <option value="Durango">Durango</option>                                
                                <option value="Guanajuato">Guanajuato</option>
                                <option value="Guerrero">Guerrero</option>
                                <option value="Hidalgo">Hidalgo</option>
                                <option value="Jalisco">Jalisco</option>
                                <option value="Estado de México">Estado de México</option>
                                <option value="Michoacán">Michoacán</option>
                                <option value="Morelos">Morelos</option>
                                <option value="Nayarit">Nayarit</option>
                                <option value="Nuevo León">Nuevo León</option>
                                <option value="Oaxaca">Oaxaca</option>
                                <option value="Puebla">Puebla</option>
                                <option value="Querétaro">Querétaro</option>
                                <option value="Quintana Roo">Quintana Roo</option>
                                <option value="San Luis Potosí">San Luis Potosí</option>
                                <option value="Sinaloa">Sinaloa</option>
                                <option value="Sonora">Sonora</option>
                                <option value="Tabasco">Tabasco</option>
                                <option value="Tamaulipas">Tamaulipas</option>
                                <option value="Tlaxcala">Tlaxcala</option>
                                <option value="Veracruz">Veracruz</option>
                                <option value="Yucatán">Yucatán</option>
                                <option value="Zacatecas">Zacatecas</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nacionalidad">Nacionalidad</label>
                            <select class="form-control" name="nacionalidad">
                                <option value="Mexicana">Mexicana</option>
                                <option value="Extranjera">Extranjera</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="medio">Medio de presentación</label>
                            <select class="form-control" name="medio">
                                <option value="">Escoge una opción</option>
                                <option value="Asesor Virtual">Asesor Virtual</option>
                                <option value="Asistente Virtual">Asistente Virtual</option>
                                <option value="Comparecencia">Comparecencia</option>
                                <option value="Escrito">Escrito</option>
                                <option value="Vía telefónica">Vía telefónica</option>
                                <option value="Vía electrónica">Vía electrónica</option>
                                <option value="Comisión Nacional de los Derechos Humanos">Comisión Nacional de los Derechos Humanos</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="adjunto">Archivo adjunto (si es necesario)</label>
                            <input type="file" accept="application/pdf" class="form-control" name="adjunto" id="adjunto">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="observaciones">Observaciones</label><br>
                            <textarea name="observaciones" class="form-control" id="observaciones" cols="50" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="orientaciones.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="add_orientacion" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>