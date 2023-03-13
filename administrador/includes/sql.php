<?php
require_once('load.php');

/*--------------------------------------------------------------*/
/* Funcion para encontrar en una tabla toda la informacion
/*--------------------------------------------------------------*/
function find_all($table)
{
  global $db;
  if (tableExists($table)) {
    return find_by_sql("SELECT * FROM " . $db->escape($table));
  }
}

function find_all_order($table, $order)
{
  global $db;
  if (tableExists($table)) {
    return find_by_sql("SELECT * FROM " . $db->escape($table) . " ORDER BY " . $db->escape($order));
  }
}
function find_all_medio_pres(){
  $sql = "SELECT * FROM cat_medio_pres ORDER BY descripcion ASC";
  $result = find_by_sql($sql);
  return $result;
}
function find_all_aut_res(){
  $sql = "SELECT * FROM cat_autoridades ORDER BY nombre_autoridad ASC";
  $result = find_by_sql($sql);
  return $result;
}
function find_all_estatus_queja(){
  $sql = "SELECT * FROM cat_estatus_queja ORDER BY descripcion ASC";
  $result = find_by_sql($sql);
  return $result;
}
function find_all_cat_localidades(){
  $sql = "SELECT * FROM cat_localidades ORDER BY descripcion ASC";
  $result = find_by_sql($sql);
  return $result;
}
function find_all_cat_municipios(){
  $sql = "SELECT * FROM cat_municipios ORDER BY descripcion ASC";
  $result = find_by_sql($sql);
  return $result;
}
function find_all_quejas(){
  $sql = "SELECT q.id_queja_date, q.folio_queja, q.fecha_presentacion, mp.descripcion as medio_pres, au.nombre_autoridad, q.fecha_avocamiento, q.incompetencia, q.causa_incomp, 
          q.fecha_acuerdo_incomp, q.desechamiento, q.razon_desecha, q.forma_conclusion, q.fecha_conclusion, q.estado_procesal, q.observaciones, cq.nombre as nombre_quejoso, 
          cq.paterno as paterno_quejoso, cq.materno as materno_quejoso, ca.nombre as nombre_agraviado, ca.paterno as paterno_agraviado, ca.materno as materno_agraviado, q.fecha_creacion, 
          q.fecha_actualizacion, eq.descripcion as estatus_queja, q.archivo, q.dom_calle, q.dom_colonia, q.descripcion_hechos, tr.descripcion as tipo_resolucion, 
          q.num_recomendacion, q.fecha_termino
          FROM quejas_dates q 
          LEFT JOIN cat_medio_pres mp ON mp.id_cat_med_pres = q.id_cat_med_pres
          LEFT JOIN cat_autoridades au ON au.id_cat_aut = q.id_cat_aut
          LEFT JOIN cat_quejosos cq ON cq.id_cat_quejoso = q.id_cat_quejoso
          LEFT JOIN cat_agraviados ca ON ca.id_cat_agrav = q.id_cat_agraviado
          LEFT JOIN users u ON u.id_user = q.id_user_asignado
          LEFT JOIN area a ON a.id_area = q.id_area_asignada
          LEFT JOIN cat_estatus_queja eq ON eq.id_cat_est_queja = q.id_estatus_queja
          LEFT JOIN cat_tipo_res tr ON tr.id_cat_tipo_res = q.id_tipo_resolucion;";
  $result = find_by_sql($sql);
  return $result;
}
function find_all_quejosos(){
  $sql = "SELECT q.id_cat_quejoso,q.nombre,q.paterno,q.materno,cg.descripcion as genero,q.edad,cn.descripcion as nacionalidad,cm.descripcion as municipio,
  ce.descripcion as escolaridad,co.descripcion as ocupacion,q.leer_escribir,cgv.descripcion as grupo_vuln,cd.descripcion as discapacidad,cc.descripcion as comunidad,q.telefono,q.email
  FROM cat_quejosos q 
  INNER JOIN cat_genero cg ON cg.id_cat_gen = q.id_cat_gen
  INNER JOIN cat_nacionalidades cn ON cn.id_cat_nacionalidad = q.id_cat_nacionalidad
  INNER JOIN cat_municipios cm ON cm.id_cat_mun = q.id_cat_mun
  INNER JOIN cat_escolaridad ce ON ce.id_cat_escolaridad = q.id_cat_escolaridad
  INNER JOIN cat_ocupaciones co ON co.id_cat_ocup = q.id_cat_ocup
  INNER JOIN cat_grupos_vuln cgv ON cgv.id_cat_grupo_vuln = q.id_cat_grupo_vuln
  INNER JOIN cat_discapacidades cd ON cd.id_cat_disc = q.id_cat_disc
  INNER JOIN cat_comunidades cc ON cc.id_cat_comun = q.id_cat_comun ORDER BY q.nombre ASC";
  $result = find_by_sql($sql);
  return $result;
}
function find_all_agraviados(){
  $sql = "SELECT q.id_cat_agrav,q.nombre,q.paterno,q.materno,cg.descripcion as genero,q.edad,cn.descripcion as nacionalidad,cm.descripcion as municipio,
  ce.descripcion as escolaridad,co.descripcion as ocupacion,q.leer_escribir,cgv.descripcion as grupo_vuln,cd.descripcion as discapacidad,cc.descripcion as comunidad,q.telefono,q.email,q.ppl
  FROM cat_agraviados q 
  INNER JOIN cat_genero cg ON cg.id_cat_gen = q.id_cat_gen
  INNER JOIN cat_nacionalidades cn ON cn.id_cat_nacionalidad = q.id_cat_nacionalidad
  INNER JOIN cat_municipios cm ON cm.id_cat_mun = q.id_cat_mun
  INNER JOIN cat_escolaridad ce ON ce.id_cat_escolaridad = q.id_cat_escolaridad
  INNER JOIN cat_ocupaciones co ON co.id_cat_ocup = q.id_cat_ocup
  INNER JOIN cat_grupos_vuln cgv ON cgv.id_cat_grupo_vuln = q.id_cat_grupo_vuln
  INNER JOIN cat_discapacidades cd ON cd.id_cat_disc = q.id_cat_disc
  INNER JOIN cat_comunidades cc ON cc.id_cat_comun = q.id_cat_comun  ORDER BY q.nombre ASC";
  $result = find_by_sql($sql);
  return $result;
}
/*--------------------------------------------------------------*/
/* Funcion para llevar a cabo queries
/*--------------------------------------------------------------*/
function find_by_sql($sql)
{
  global $db;
  $result = $db->query($sql);
  $result_set = $db->while_loop($result);
  return $result_set;
}
/*--------------------------------------------------------------*/
/*  Funcion para encontrar datos por su id en una tabla
/*--------------------------------------------------------------*/
function find_by_id($table, $id, $nombre_id)
{
  global $db;
  $id = (int)$id;
  if (tableExists($table)) {
    $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE {$db->escape($nombre_id)}='{$db->escape($id)}' LIMIT 1");
    if ($result = $db->fetch_assoc($sql))
      return $result;
    else
      return null;
  }
}
/*--------------------------------------------------------------*/
/*  Funcion para encontrar datos por su id en una tabla
/*--------------------------------------------------------------*/
function find_by_id_user($table, $id, $nombre_id)
{
  global $db;
  $id = (int)$id;
  if (tableExists($table)) {
    $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE {$db->escape($nombre_id)}='{$db->escape($id)}' LIMIT 1");
    if ($result = $db->fetch_assoc($sql))
      return $result;
    else
      return null;
  }
}

/*---------------------------------------------------------------------------------*/
/* Funcion para encontrar el cargo de un detalle de usuario (trabajador) por su ID */
/*---------------------------------------------------------------------------------*/
function find_detalle_cargo($id)
{
  global $db;
  $result = array();
  $sql = "SELECT u.id_cargo, c.nombre_cargo ";
  $sql .= "FROM detalles_usuario u ";
  $sql .= "LEFT JOIN cargos c ";
  $sql .= "ON u.id_cargo=c.id_cargos WHERE u.id_det_usuario='{$db->escape($id)}'";
  $result = find_by_sql($sql);
  return $result;
}
/*--------------------------------------------------------------------------------*/
/* Funcion para cuando se elimina un área, poner en los cargos que estan Sin área */
/*--------------------------------------------------------------------------------*/
function area_default($id)
{
  global $db;
  $sql = "UPDATE cargos SET id_area = 1";
  $sql .= " WHERE id_area=" . $db->escape($id);
  $db->query($sql);
  return ($db->affected_rows() >= 1) ? true : false;
}
/*-----------------------------------------------------------------------------------------------*/
/* Funcion para cuando se elimina un cargo, poner en los detalles de usuario que estan Sin cargo */
/*-----------------------------------------------------------------------------------------------*/
function cargo_default($id)
{
  global $db;
  $sql = "UPDATE detalles_usuario SET id_cargo = 1";
  $sql .= " WHERE id_cargo=" . $db->escape($id);
  $db->query($sql);
  return ($db->affected_rows() >= 1) ? true : false;
}
/*-----------------------------------------------------*/
/* Funcion para eliminar datos de una tabla, por su ID */
/*-----------------------------------------------------*/
function delete_by_id($table, $id, $nombre_id)
{
  global $db;
  if (tableExists($table)) {
    $sql = "DELETE FROM " . $db->escape($table);
    $sql .= " WHERE " . $db->escape($nombre_id) . "=" . $db->escape($id);
    $sql .= " LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
  }
}
/*-----------------------------------------------------*/
/* Funcion para eliminar datos de una tabla, por su ID */
/*-----------------------------------------------------*/
function delete_by_folio_queja($table, $folio)
{
  global $db;
  if (tableExists($table)) {
    $sql = "DELETE FROM " . $db->escape($table);
    $sql .= " WHERE folio = '{$db->escape($folio)}'";
    $sql .= " LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
  }
}
/*------------------------------------------------------*/
/* Funcion para inactivar datos de una tabla, por su ID */
/*------------------------------------------------------*/
function inactivate_by_id($table, $id, $campo_estatus, $nombre_id)
{
  global $db;
  if (tableExists($table)) {
    $sql = "UPDATE " . $db->escape($table) . " SET ";
    $sql .= $db->escape($campo_estatus) . "=0";
    $sql .= " WHERE ".$db->escape($nombre_id)."=" . $db->escape($id);
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
  }
}
/*--------------------------------------------------------------*/
/* Funcion para inactivar datos de una tabla, por su ID
/*--------------------------------------------------------------*/
function inactivate_by_id_user($table, $id, $campo_estatus)
{
  global $db;
  if (tableExists($table)) {
    $sql = "UPDATE " . $db->escape($table) . " SET ";
    $sql .= $db->escape($campo_estatus) . "=0";
    $sql .= " WHERE id_detalle_user=" . $db->escape($id);
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
  }
}

/*--------------------------------------------------------------*/
/* Funcion para inactivar cargos en funcion del area inactivada */
/*--------------------------------------------------------------*/
function inactivate_area_cargo($id)
{
  global $db;
  $sql = "UPDATE cargos SET estatus_cargo = 0";
  $sql .= " WHERE id_area=" . $db->escape($id);
  $db->query($sql);
  return ($db->affected_rows() > 0) ? true : false;
}


/*---------------------------------*/
/* Funcion para inactivar un grupo */
/*---------------------------------*/
function inactivate_grupo($table, $id, $campo_estatus)
{
  global $db;
  if (tableExists($table)) {
    $sql = "UPDATE " . $db->escape($table) . " SET ";
    $sql .= $db->escape($campo_estatus) . "=0";
    $sql .= " WHERE nivel_grupo=" . $db->escape($id);
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
  }
}
/*--------------------------------------------------------------*/
/* Funcion para inactivar users en funcion del grupo inactivado */
/*--------------------------------------------------------------*/
function inactivate_user_group($table, $nivel, $campo_estatus)
{
  global $db;

  $sql2 = "UPDATE " . $db->escape($table) . " SET ";
  $sql2 .= $db->escape($campo_estatus) . "=0";
  $sql2 .= " WHERE user_level=" . $db->escape($nivel);
  $db->query($sql2);

  return ($db->affected_rows() >= 0) ? true : false;
}
/*----------------------------------------------------*/
/* Funcion para activar datos de una tabla, por su ID */
/*----------------------------------------------------*/
function activate_by_id($table, $id, $campo_estatus, $nombre_id)
{
  global $db;
  if (tableExists($table)) {
    $sql = "UPDATE " . $db->escape($table) . " SET ";
    $sql .= $campo_estatus . "=1";
    $sql .= " WHERE ".$db->escape($nombre_id)."=" . $db->escape($id);
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
  }
}
/*--------------------------------------------------------------------------*/
/* Funcion para activar un usuario, en funcion del trabajador que se activó */
/*--------------------------------------------------------------------------*/
function activate_by_id_user($table, $id, $campo_estatus)
{
  global $db;
  if (tableExists($table)) {
    $sql = "UPDATE " . $db->escape($table) . " SET ";
    $sql .= $db->escape($campo_estatus) . "=1";
    $sql .= " WHERE id_detalle_user=" . $db->escape($id);
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
  }
}
/*--------------------------------------------------------------*/
/* Funcion para activar usuario en funcion del cargo inactivado */
/*--------------------------------------------------------------*/
function activate_cargo_user($table, $id, $campo_estatus)
{
  global $db;
  $id = (int)$id;
  $id_asig = "SELECT id_cargo FROM detalles_usuario WHERE id_cargo = '{$db->escape($id)}'";
  $id_buscado = find_by_sql($id_asig);

  foreach ($id_buscado as $id_encontrado) {
    $sql2 = "UPDATE " . $db->escape($table) . " SET ";
    $sql2 .= $db->escape($campo_estatus) . "=1";
    $sql2 .= " WHERE id_detalle_user=" . $db->escape($id_encontrado['id_cargo']);
    $db->query($sql2);
  }
  return ($db->affected_rows() >= 0) ? true : false;
}
/*-----------------------------------------------------------------------*/
/* Funcion para activar detalle de usuario en funcion del cargo activado */
function activate_cargo_trabajador($table, $id, $campo_estatus)
{
  global $db;
  if (tableExists($table)) {
    $sql = "UPDATE " . $db->escape($table) . " SET ";
    $sql .= $db->escape($campo_estatus) . "=1";
    $sql .= " WHERE id_cargo=" . $db->escape($id);
    $db->query($sql);
    return ($db->affected_rows() > 0) ? true : false;
  }
}

/*----------------------------------------------------------*/
/* Funcion para activar cargos en funcion del area activada */
/*----------------------------------------------------------*/
function activate_area_cargo($id)
{
  global $db;
  $sql = "UPDATE cargos SET estatus_cargo = 1";
  $sql .= " WHERE id_area=" . $db->escape($id);
  $db->query($sql);
  return ($db->affected_rows() > 0) ? true : false;
}

function activate_grupo($table, $id, $campo_estatus)
{
  global $db;
  if (tableExists($table)) {
    $sql = "UPDATE " . $db->escape($table) . " SET ";
    $sql .= $db->escape($campo_estatus) . "=1";
    $sql .= " WHERE nivel_grupo=" . $db->escape($id);
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
  }
}

/*----------------------------------------------------------*/
/* Funcion para activar users en funcion del grupo activada */
/*----------------------------------------------------------*/
function activate_user_group($id)
{
  global $db;
  $sql = "UPDATE users SET status = 1";
  $sql .= " WHERE user_level=" . $db->escape($id);
  $db->query($sql);
  return ($db->affected_rows() > 0) ? true : false;
}

function correspondencia_pdf($id)
{
  global $db;
  $sql  = "SELECT *";
  $sql .= " FROM envio_correspondencia WHERE id='{$db->escape($id)}'";
  //SELECT * FROM `resguardos` GROUP BY id_asignacion_resguardo DESC
  return find_by_sql($sql);
}

/*------------------------------------------------------------------------*/
/* Funcion para contar los ID de algun campo para saber su cantidad total */
/*------------------------------------------------------------------------*/
function count_by_id($table,$nombre_id)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(".$db->escape($nombre_id).") AS total FROM " . $db->escape($table);
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
/*------------------------------------------------------------------------*/
/* Funcion para contar los ID de orientacion para saber su cantidad total */
/*------------------------------------------------------------------------*/
function count_by_id_orientacion($table,$nombre_id)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(".$db->escape($nombre_id).") AS total FROM " . $db->escape($table) . " WHERE tipo_solicitud = 1";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

/*------------------------------------------------------------------------*/
/* Funcion para contar los ID de canalizacion para saber su cantidad total */
/*------------------------------------------------------------------------*/
function count_by_id_canalizacion($table,$nombre_id)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(".$db->escape($nombre_id).") AS total FROM " . $db->escape($table) . " WHERE tipo_solicitud = 2";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
/*-----------------------------------*/
/* Determina si unaa tabla ya existe */
/*-----------------------------------*/
function tableExists($table)
{
  global $db;
  $table_exit = $db->query('SHOW TABLES FROM ' . DB_NAME . ' LIKE "' . $db->escape($table) . '"');
  if ($table_exit) {
    if ($db->num_rows($table_exit) > 0)
      return true;
    else
      return false;
  }
}
/*-----------------------------------------------*/
/* Login con la informacion proporcionada en el
/* $_POST, que proviene del formulario del login */
/*-----------------------------------------------*/
function authenticate($username = '', $password = '')
{
  global $db;
  $username = $db->escape($username);
  $password = $db->escape($password);
  $sql  = "SELECT id_user,username,password,user_level,status FROM users WHERE username = '{$username}' LIMIT 1";
  $result = $db->query($sql);
  if ($db->num_rows($result)) {
    $user = $db->fetch_assoc($result);
    $password_request = sha1($password);
    if ($password_request === $user['password'] && $user['status'] != 0) {
      return $user['id_user'];
    }
  }
  return false;
}
/*-----------------------------------------------------*/
/* Login con la información proporcionada en el $_POST,
   proveniente del formulario de login_v2.php. */
/*----------------------------------------------------*/
function authenticate_v2($username = '', $password = '')
{
  global $db;
  $username = $db->escape($username);
  $password = $db->escape($password);
  $sql  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
  $result = $db->query($sql);
  if ($db->num_rows($result)) {
    $user = $db->fetch_assoc($result);
    $password_request = sha1($password);
    if ($password_request === $user['password']) {
      return $user['id'];
    }
  }
  return false;
}
/*--------------------------------------------------------------------------*/
/* Encuentra el usuario logueado actualmente en la sesion por el ID de esta */
/*--------------------------------------------------------------------------*/
function current_user()
{
  static $current_user;
  global $db;
  if (!$current_user) {
    if (isset($_SESSION['user_id'])) :
      $user_id = intval($_SESSION['user_id']);
      $current_user = find_by_id_user('users', $user_id, 'id_user');
    endif;
  }
  return $current_user;
}
/*----------------------------------------------------------------------------------------*/
/* Encuentra todos los usuarios haciendo union entre users con la tabla de grupo_usuarios */
/*----------------------------------------------------------------------------------------*/
function find_all_cuentas()
{
  global $db;
  $results = array();
  $sql = "SELECT u.id_user,u.id_detalle_user,d.nombre,d.apellidos,u.username,u.user_level,u.status,u.ultimo_login,";
  $sql .= "g.nombre_grupo ";

  $sql .= "FROM users u ";
  $sql .= "LEFT JOIN detalles_usuario d ON d.id_det_usuario = u.id_detalle_user ";
  $sql .= "LEFT JOIN grupo_usuarios g ";
  $sql .= "ON g.nivel_grupo=u.user_level ORDER BY d.nombre";
  $result = find_by_sql($sql);
  return $result;
}
/*-------------------------------------------------------------------------------------------------------------------------------*/
/* Funcion que encuentra todos los cargos y se relaciona con la tabla areas, para obtener el nombre de esta en funcion del cargo */
/*-------------------------------------------------------------------------------------------------------------------------------*/
function find_all_cargos()
{
  global $db;
  $results = array();
  $sql = "SELECT u.id_cargos,u.nombre_cargo,u.id_area,u.estatus_cargo,a.nombre_area ";

  $sql .= "FROM cargos u ";
  $sql .= "LEFT JOIN area a ";
  $sql .= "ON u.id_area=a.id_area ORDER BY a.nombre_area";
  $result = find_by_sql($sql);
  return $result;
}
function find_all_cargos2()
{
  global $db;
  $results = array();
  $sql = "SELECT c.id_cargos, c.nombre_cargo, a.id_area, a.nombre_area ";
  $sql .= "FROM cargos as c LEFT JOIN area as a ON c.id_area = a.id_area ";
  $sql .= "ORDER BY c.nombre_cargo ";
  $result = find_by_sql($sql);
  return $result;
}
/*----------------------------------------------*/
/* Funcion que encuentra todos los trabajadores */
/*----------------------------------------------*/
function find_all_trabajadores()
{
  global $db;
  $results = array();
  $sql = "SELECT d.id_det_usuario as detalleID,d.nombre,d.apellidos,d.correo,d.telefono_casa,d.telefono_celular,d.id_cargo,d.estatus_detalle,c.id_cargos,c.nombre_cargo,c.id_area,a.id_area,a.nombre_area ";
  $sql .= "FROM detalles_usuario d LEFT JOIN cargos c ON c.id_cargos = d.id_cargo LEFT JOIN area a ON a.id_area = c.id_area ORDER BY d.nombre";
  $result = find_by_sql($sql);
  return $result;
}
/*----------------------------------------------------------------------------*/
/* Funcion para actualizar la fecha del ultimo inicio de sesion de un usuario */
/*----------------------------------------------------------------------------*/

function updateLastLogIn($user_id)
{
  global $db;
  $date = make_date();
  $sql = "UPDATE users SET ultimo_login='{$date}' WHERE id_user ='{$user_id}' LIMIT 1";
  $result = $db->query($sql);
  return ($result && $db->affected_rows() === 1 ? true : false);
}
/*---------------------------------------------------*/
/* Encuentra todos los nombres de grupos de usuarios */
/*---------------------------------------------------*/
function find_by_groupName($val)
{
  global $db;
  $sql = "SELECT nombre_grupo FROM grupo_usuarios WHERE nombre_grupo = '{$db->escape($val)}' LIMIT 1 ";
  $result = $db->query($sql);
  return ($db->num_rows($result) === 0 ? true : false);
}
/*-----------------------------------------------------------*/
/* Encuentra todos los nombres de todas las areas de trabajo */
/*-----------------------------------------------------------*/
function find_by_areaName($val)
{
  global $db;
  $sql = "SELECT nombre_area FROM area WHERE nombre_area = '{$db->escape($val)}' LIMIT 1 ";
  $result = $db->query($sql);
  return ($db->num_rows($result) === 0 ? true : false);
}
/*-------------------------------------------*/
/* Encuentra todos los nombres de los cargos */
/*-------------------------------------------*/
function find_by_cargoName($val)
{
  global $db;
  $sql = "SELECT nombre_cargo FROM cargos WHERE nombre_cargo = '{$db->escape($val)}' LIMIT 1 ";
  $result = $db->query($sql);
  return ($db->num_rows($result) === 0 ? true : false);
}
/*--------------------------------*/
/* Encuentra los niveles de grupo */
/*--------------------------------*/
function find_by_groupLevel($level)
{
  global $db;
  $sql = "SELECT nivel_grupo, estatus_grupo FROM grupo_usuarios WHERE nivel_grupo = '{$db->escape($level)}' LIMIT 1 ";
  $result = $db->query($sql);
  return ($db->num_rows($result) === 0 ? true : false);
}
/*----------------------------------------------------------------------*/
/* Funcion para checar cual nivel de usuario tiene acceso a cada pagina */
/*----------------------------------------------------------------------*/
function page_require_level($require_level)
{
  global $session;
  $current_user = current_user();
  $login_level = find_by_groupLevel($current_user['user_level']);
  //si el usuario no esta logueado
  if (!$session->isUserLoggedIn(true)) :
    $session->msg('d', 'Por favor, inicia sesión...');
    redirect('index.php', false);
  //si estatus de grupo de usuario esta desactivado
  elseif (@$login_level['estatus_grupo'] === 0) : //Si se quita el arroba muestra un notice
    $session->msg('d', 'Este nivel de usuario esta inactivo!');
    redirect('home.php', false);
  //checa si el nivel de usuario es menor o igual al requerido
  elseif ($current_user['user_level'] <= (int)$require_level) :
    return true;
  else :
    $session->msg("d", "¡Lo siento! no tienes permiso para ver la página.");
    redirect('home.php', false);
  endif;
}
/*----------------------------------------------------------------------*/
/* Funcion para checar cual nivel de usuario tiene acceso a cada pagina */
/*----------------------------------------------------------------------*/
function page_require_level_exacto($require_level)
{
  global $session;
  $current_user = current_user();
  $login_level = find_by_groupLevel($current_user['user_level']);
  //si el usuario no esta logueado
  if (!$session->isUserLoggedIn(true)) :
    $session->msg('d', 'Por favor, inicia sesión...');
    redirect('index.php', false);
  //si estatus de grupo de usuario esta desactivado
  elseif (@$login_level['estatus_grupo'] === 0) : //Si se quita el arroba muestra un notice
    $session->msg('d', 'Este nivel de usuario esta inactivo!');
    redirect('home.php', false);
  //checa si el nivel de usuario es menor o igual al requerido
  elseif ($current_user['user_level'] == $require_level) :
    return true;
  else :
    $session->msg("d", "¡Lo siento! no tienes permiso para ver la página.");
    redirect('home.php', false);
  endif;
}

/*--------------------------------------------------------------*/
/* Funcion para encontrar componentes por su nombre */
/*--------------------------------------------------------------*/
function find_product_by_title($product_name)
{
  global $db;
  $p_name = remove_junk($db->escape($product_name));
  $sql = "SELECT nombre_componente, id, marca,modelo FROM componentes WHERE nombre_componente like '%$p_name%' LIMIT 5";
  $result = find_by_sql($sql);
  return $result;
}

/*--------------------------------------------------------------*/
/* Encontrar todos los productos por nombre y marca */
/*--------------------------------------------------------------*/
function find_all_product_info_by_title_marca($title, $marca, $modelo)
{
  global $db;
  $sql  = "SELECT * FROM componentes ";
  $sql .= " WHERE nombre_componente = '{$title}' AND marca = '{$marca}' AND modelo = '{$modelo}'";
  $sql .= " LIMIT 1";
  return find_by_sql($sql);
}

/*--------------------------------------------------------------*/
/* Funcion para encontrar el detalle de usuario que le pertenece a un usuario */
/*--------------------------------------------------------------*/
function midetalle($id)
{
  global $db;
  $sql  = "SELECT d.id FROM detalles_usuario d INNER JOIN users u ON u.id_detalle_user = d.id WHERE u.id = {$id} LIMIT 1";
  return find_by_sql($sql);
}

/*----------------------------------------------*/
/* Funcion que encuentra todas las orientaciones */
/*----------------------------------------------*/
function find_all_orientaciones()
{
  global $db;
  $sql = "SELECT o.id_or_can as idor,o.folio,o.correo_electronico,o.nombre_completo,o.nivel_estudios,o.ocupacion,o.edad,o.telefono,o.extension,o.sexo,o.calle_numero,
          o.colonia,o.codigo_postal,o.municipio_localidad,o.entidad,o.nacionalidad,o.tipo_solicitud,o.medio_presentacion,o.observaciones,o.adjunto,o.creacion,o.id_creador,
          u.id_user,u.id_detalle_user,d.nombre,d.apellidos";
  $sql .= " FROM orientacion_canalizacion as o";
  $sql .= " LEFT JOIN users as u ON u.id_user = o.id_creador";
  $sql .= " LEFT JOIN detalles_usuario as d ON d.id_det_usuario = u.id_detalle_user WHERE tipo_solicitud=1";
  return find_by_sql($sql);
}

/*----------------------------------------------*/
/* Funcion que encuentra todas las orientaciones */
/*----------------------------------------------*/
function find_all_canalizaciones()
{
  global $db;
  $sql = "SELECT o.id_or_can as idcan,o.folio,o.correo_electronico,o.nombre_completo,cesc.descripcion,ocup.descripcion,o.edad,o.telefono, o.extension,gen.descripcion as gen,
          o.calle_numero,  o.colonia,o.codigo_postal,o.municipio_localidad,ent.descripcion as descr,nac.descripcion as nac,o.tipo_solicitud,med.descripcion as med,o.observaciones,
          o.adjunto, o.creacion,o.id_creador,u.id_user,u.id_detalle_user,d.nombre,d.apellidos";
  $sql .= " FROM orientacion_canalizacion as o";
  $sql .= " LEFT JOIN users as u ON u.id_user = o.id_creador";
  $sql .= " LEFT JOIN cat_escolaridad as cesc ON cesc.id_cat_escolaridad = o.nivel_estudios";
  $sql .= " LEFT JOIN cat_ocupaciones as ocup ON ocup.id_cat_ocup = o.ocupacion";
  $sql .= " LEFT JOIN cat_grupos_vuln as gvuln ON gvuln.id_cat_grupo_vuln = o.grupo_vulnerable";
  $sql .= " LEFT JOIN cat_genero gen ON gen.id_cat_gen = o.sexo";
  $sql .= " LEFT JOIN cat_autoridades aut ON aut.id_cat_aut = o.institucion_canaliza";
  $sql .= " LEFT JOIN cat_entidad_fed ent ON ent.id_cat_ent_fed = o.entidad";
  $sql .= " LEFT JOIN cat_nacionalidades nac ON nac.id_cat_nacionalidad = o.nacionalidad";
  $sql .= " LEFT JOIN cat_medio_pres med ON med.id_cat_med_pres = o.medio_presentacion";
  $sql .= " LEFT JOIN detalles_usuario as d ON d.id_det_usuario = u.id_detalle_user WHERE tipo_solicitud=2";
  return find_by_sql($sql);
}

/*----------------------------------------------*/
/* Funcion que encuentra todas las actuaciones */
/*----------------------------------------------*/
function find_all_actuaciones()
{
  global $db;
  $results = array();
  $sql = "SELECT a.*, r.nombre_autoridad FROM actuaciones as a LEFT JOIN cat_autoridades as r ON a.autoridades = r.id OR a.autoridades_federales = r.id;";
  $result = find_by_sql($sql);
  return $result;
}

/*----------------------------------------------*/
/* Funcion que encuentra todas las actuaciones */
/*----------------------------------------------*/
function find_all_actuaciones_area($area)
{
  global $db;
  $results = array();
  $sql = "SELECT * FROM actuaciones WHERE area_creacion = '{$area}' ORDER BY fecha_captura_acta";
  $result = find_by_sql($sql);
  return $result;
}
/*----------------------------------------------------------*/
/* Funcion que encuentra todos los acuerdos de no violacion */
/*----------------------------------------------------------*/
function find_all_acuerdos()
{
  global $db;
  $results = array();
  $sql = "SELECT * FROM acuerdos";
  $result = find_by_sql($sql);
  return $result;
}
/*-------------------------------------------------*/
/* Funcion que encuentra todas las recomendaciones */
/*-------------------------------------------------*/
function find_all_recomendacionesTotales()
{
  global $db;
  $results = array();
  $sql = "SELECT * FROM recomendaciones UNION SELECT * FROM recomendaciones_generales ORDER BY fecha_recomendacion";
  $result = find_by_sql($sql);
  return $result;
}
/*----------------------------------------------*/
/* Funcion que verifica el tipo de ficha que es */
/*----------------------------------------------*/
function find_tipo_ficha($id)
{
  global $db;
  $id = (int)$id;
  $sql = $db->query("SELECT tipo_ficha FROM fichas WHERE id='{$db->escape($id)}' LIMIT 1");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
/*---------------------------------------------------------*/
/* Funcion que encuentra todas los trabajadores de un área */
/*---------------------------------------------------------*/
function find_all_trabajadores_area($area)
{
  global $db;
  $results = array();
  $sql = "SELECT d.id,d.nombre, d.apellidos, a.nombre_area FROM detalles_usuario as d LEFT JOIN cargos as c ON c.id = d.id_cargo LEFT JOIN area as a ON a.id = c.id_area WHERE a.nombre_area = '{$area}' ORDER BY d.nombre ASC";
  $result = find_by_sql($sql);
  return $result;
}

function find_all_localidades($id)
{
  $id = $id;
  $sql = "SELECT * FROM cat_localidades WHERE id_cat_municipios = {$id} ORDER BY nnombre_localidad ASC";
  $result = find_by_sql($sql);
  return $result;
}

/*---------------------------------------------------------*/
/* Funcion que encuentra todas las subáreas de un área */
/*---------------------------------------------------------*/
function find_all_subarea_area($id)
{
  $sql = "SELECT nombre_area FROM area WHERE area_padre = {$id} ORDER BY nombre_area ASC";
  $result = find_by_sql($sql);
  return $result;
}

function find_all_areas($id)
{
  $sql = "SELECT * FROM area WHERE area_padre = 0 ORDER BY nombre_area ASC";
  $result = find_by_sql($sql);
  return $result;
}
function find_all_areas2($id)
{
  $sql = "SELECT * FROM area WHERE area_padre = '{$id}' ORDER BY nombre_area ASC";
  $result = find_by_sql($sql);
  return $result;
}

function find_by_id_queja($id)
{
  global $db;
  $id = (int)$id;
  $sql = $db->query("SELECT q.id_queja_date, q.id_cat_med_pres, q.id_cat_aut, q.id_cat_quejoso, q.id_cat_agraviado, q.id_user_creador, q.id_user_asignado, q.id_area_asignada, q.id_estatus_queja,
                      q.id_tipo_resolucion,q.id_tipo_ambito,q.folio_queja, q.fecha_presentacion, mp.descripcion as medio_pres, au.nombre_autoridad, q.fecha_avocamiento, q.id_cat_mun,
                      q.incompetencia, q.causa_incomp, q.fecha_acuerdo_incomp, q.desechamiento, q.razon_desecha, q.forma_conclusion, q.fecha_conclusion, q.estado_procesal, q.observaciones, 
                      cq.nombre as nombre_quejoso, cq.paterno as paterno_quejoso, cq.materno as materno_quejoso, ca.nombre as nombre_agraviado, ca.paterno as paterno_agraviado, 
                      ca.materno as materno_agraviado, q.fecha_creacion, q.fecha_actualizacion, eq.descripcion as estatus_queja, q.archivo, q.dom_calle, q.dom_numero, q.dom_colonia, 
                      q.descripcion_hechos, tr.descripcion as tipo_resolucion, q.num_recomendacion, q.fecha_termino, ta.descripcion as tipo_ambito, u.username, a.nombre_area, q.fecha_vencimiento
                      FROM quejas_dates q
                      LEFT JOIN cat_medio_pres mp ON mp.id_cat_med_pres = q.id_cat_med_pres
                      LEFT JOIN cat_autoridades au ON au.id_cat_aut = q.id_cat_aut
                      LEFT JOIN cat_quejosos cq ON cq.id_cat_quejoso = q.id_cat_quejoso
                      LEFT JOIN cat_agraviados ca ON ca.id_cat_agrav = q.id_cat_agraviado
                      LEFT JOIN users u ON u.id_user = q.id_user_asignado
                      LEFT JOIN area a ON a.id_area = q.id_area_asignada
                      LEFT JOIN cat_estatus_queja eq ON eq.id_cat_est_queja = q.id_estatus_queja
                      LEFT JOIN cat_tipo_res tr ON tr.id_cat_tipo_res = q.id_tipo_resolucion
                      LEFT JOIN cat_tipo_ambito ta ON ta.id_cat_tipo_ambito = q.id_tipo_ambito
                      LEFT JOIN cat_municipios cm ON cm.id_cat_mun = q.id_cat_mun
                      WHERE id_queja_date='{$db->escape($id)}' LIMIT 1");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}

/*--------------------------------------------------------------------------------*/
/* Funcion que encuentra una orientación por id, que ayudara al momento de editar */
/*--------------------------------------------------------------------------------*/
function find_by_id_orientacion($id)
{
  global $db;
  $id = (int)$id;
  $sql = $db->query("SELECT o.id_or_can as idcan,o.folio,o.correo_electronico,o.nombre_completo,cesc.descripcion as cesc,ocup.descripcion as ocup,o.edad,
                      o.telefono,o.extension,o.ocupacion,gen.descripcion as gen,o.calle_numero,o.colonia,o.codigo_postal,o.municipio_localidad,o.lengua,
                      ent.descripcion as ent,nac.descripcion as nac,o.tipo_solicitud,med.descripcion as med,o.observaciones,o.adjunto, o.creacion,o.id_creador,
                      u.id_user,u.id_detalle_user,d.nombre,d.apellidos,gvuln.descripcion as grupo, aut.nombre_autoridad as aut, o.nivel_estudios as est,
                      o.grupo_vulnerable,o.entidad,o.sexo,o.nacionalidad,o.medio_presentacion,o.institucion_canaliza,
                      o.medio_presentacion
                      FROM orientacion_canalizacion as o 
                      LEFT JOIN users as u ON u.id_user = o.id_creador 
                      LEFT JOIN cat_escolaridad as cesc ON cesc.id_cat_escolaridad = o.nivel_estudios
                      LEFT JOIN cat_ocupaciones as ocup ON ocup.id_cat_ocup = o.ocupacion 
                      LEFT JOIN cat_grupos_vuln as gvuln ON gvuln.id_cat_grupo_vuln = o.grupo_vulnerable 
                      LEFT JOIN cat_genero gen ON gen.id_cat_gen = o.sexo 
                      LEFT JOIN cat_autoridades aut ON aut.id_cat_aut = o.institucion_canaliza
                      LEFT JOIN cat_entidad_fed ent ON ent.id_cat_ent_fed = o.entidad 
                      LEFT JOIN cat_nacionalidades nac ON nac.id_cat_nacionalidad = o.nacionalidad 
                      LEFT JOIN cat_medio_pres med ON med.id_cat_med_pres = o.medio_presentacion
                      LEFT JOIN detalles_usuario as d ON d.id_det_usuario = u.id_detalle_user
  WHERE id_or_can='{$db->escape($id)}' AND tipo_solicitud=1 LIMIT 1");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
/*----------------------------------------------*/
/* Funcion que encuentra una orientación por id */
/*----------------------------------------------*/
function find_by_id_canalizacion($id)
{
  global $db;
  $id = (int)$id;
  $sql = $db->query("SELECT o.id_or_can as idcan,o.folio,o.correo_electronico, o.nombre_completo,cesc.descripcion as cesc,ocup.descripcion as ocup,o.edad,
                      o.telefono,o.extension,o.ocupacion,gen.descripcion as gen,o.calle_numero, o.colonia,o.codigo_postal,o.municipio_localidad,o.lengua,
                      ent.descripcion as ent,nac.descripcion as nac,o.tipo_solicitud,med.descripcion as med,o.observaciones,o.adjunto, o.creacion,o.id_creador,
                      u.id_user,u.id_detalle_user,d.nombre,d.apellidos,gvuln.descripcion as grupo, aut.nombre_autoridad as aut, o.nivel_estudios as est,
                      o.grupo_vulnerable,o.entidad,o.sexo,o.nacionalidad,o.medio_presentacion,o.institucion_canaliza,o.medio_presentacion
                      FROM orientacion_canalizacion as o 
                      LEFT JOIN users as u ON u.id_user = o.id_creador 
                      LEFT JOIN cat_escolaridad as cesc ON cesc.id_cat_escolaridad = o.nivel_estudios
                      LEFT JOIN cat_ocupaciones as ocup ON ocup.id_cat_ocup = o.ocupacion 
                      LEFT JOIN cat_grupos_vuln as gvuln ON gvuln.id_cat_grupo_vuln = o.grupo_vulnerable 
                      LEFT JOIN cat_genero gen ON gen.id_cat_gen = o.sexo 
                      LEFT JOIN cat_autoridades aut ON aut.id_cat_aut = o.institucion_canaliza
                      LEFT JOIN cat_entidad_fed ent ON ent.id_cat_ent_fed = o.entidad 
                      LEFT JOIN cat_nacionalidades nac ON nac.id_cat_nacionalidad = o.nacionalidad 
                      LEFT JOIN cat_medio_pres med ON med.id_cat_med_pres = o.medio_presentacion
                      LEFT JOIN detalles_usuario as d ON d.id_det_usuario = u.id_detalle_user
                      WHERE id_or_can='{$db->escape($id)}' AND tipo_solicitud=2 LIMIT 1");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
/*----------------------------------------------*/
/* Funcion que encuentra una orientación por id */
/*----------------------------------------------*/
function find_by_id_cat_quejoso($id)
{
  global $db;
  $id = (int)$id;
  $sql = $db->query("SELECT q.id_cat_quejoso,q.nombre,q.paterno,q.materno,cg.descripcion as genero,q.edad,cn.descripcion as nacionalidad,cm.descripcion as municipio,
  ce.descripcion as escolaridad,co.descripcion as ocupacion,q.leer_escribir,cgv.descripcion as grupo_vuln,cd.descripcion as discapacidad,cc.descripcion as comunidad,q.telefono,q.email
  FROM cat_quejosos q 
  INNER JOIN cat_genero cg ON cg.id_cat_gen = q.id_cat_gen
  INNER JOIN cat_nacionalidades cn ON cn.id_cat_nacionalidad = q.id_cat_nacionalidad
  INNER JOIN cat_municipios cm ON cm.id_cat_mun = q.id_cat_mun
  INNER JOIN cat_escolaridad ce ON ce.id_cat_escolaridad = q.id_cat_escolaridad
  INNER JOIN cat_ocupaciones co ON co.id_cat_ocup = q.id_cat_ocup
  INNER JOIN cat_grupos_vuln cgv ON cgv.id_cat_grupo_vuln = q.id_cat_grupo_vuln
  INNER JOIN cat_discapacidades cd ON cd.id_cat_disc = q.id_cat_disc
  INNER JOIN cat_comunidades cc ON cc.id_cat_comun = q.id_cat_comun WHERE q.id_cat_quejoso = '{$db->escape($id)}'");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
/*------------------------------------------------------------------*/
/* Funcion para encontrar el ultimo id de folios para despues
   sumarle uno y que el nuevo registro tome ese valor */
/*------------------------------------------------------------------*/
function last_id_oricanal()
{
  global $db;
  $sql = "SELECT * FROM orientacion_canalizacion ORDER BY id_or_can DESC LIMIT 1";
  $result = find_by_sql($sql);
  return $result;
}
/*--------------------------------------------------------------------*/
/* Funcion para encontrar el ultimo id de folios para despues
   sumarle uno y que el nuevo registro tome ese valor para las quejas */
/*--------------------------------------------------------------------*/
function last_id_queja()
{
  global $db;
  $sql = "SELECT * FROM quejas_dates ORDER BY id_queja_date DESC LIMIT 1";
  $result = find_by_sql($sql);
  return $result;
}

/*------------------------------------------------------------------*/
/* Funcion para encontrar el ultimo id de orientaciones y canalizaciones
   para despues sumarle uno y que el nuevo registro tome ese valor */
/*------------------------------------------------------------------*/
function last_id_folios()
{
  global $db;
  $sql = "SELECT contador FROM folios ORDER BY id_folio DESC LIMIT 1";
  $result = find_by_sql($sql);
  return $result;
}

/*------------------------------------------------------------------*/
/* Funcion para encontrar el ultimo id de orientaciones y canalizaciones
   para despues sumarle uno y que el nuevo registro tome ese valor */
/*------------------------------------------------------------------*/
function last_id_folios_general()
{
  global $db;
  $sql = "SELECT * FROM folios_general ORDER BY id DESC LIMIT 1";
  $result = find_by_sql($sql);
  return $result;
}

/* ------------------------------------------------------------------------------*/
/* Función para obtener el grupo de usuario al que pertenece el usuario logueado */
/* ------------------------------------------------------------------------------*/
function area_usuario($id_usuario)
{
  global $db;
  $id_usuario = (int)$id_usuario;

  $sql = $db->query("SELECT g.nivel_grupo 
                      FROM  grupo_usuarios g
                      LEFT JOIN users u ON u.user_level = g.nivel_grupo
                      LEFT JOIN detalles_usuario d ON u.id_detalle_user = d.id_det_usuario 
                      LEFT JOIN cargos c ON c.id_cargos= d.id_cargo 
                      LEFT JOIN area a ON a.id_area = c.id_area 
                      WHERE u.id_user = '{$db->escape($id_usuario)}' LIMIT 1");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}

/* ------------------------------------------------------------------------------*/
/* Función para obtener el grupo de usuario al que pertenece el usuario logueado */
/* ------------------------------------------------------------------------------*/
function nombre_usuario($id_usuario)
{
  global $db;
  $id_usuario = (int)$id_usuario;

  $sql = $db->query("SELECT d.nombre, d.apellidos
                      FROM  detalles_usuario d
                      LEFT JOIN users u ON u.user_level = d.id
                      WHERE u.id = '{$db->escape($id_usuario)}' LIMIT 1");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}

/* --------------------------------------------------------------------*/
/* Función para obtener el area a la que pertenece el usuario logueado */
/* --------------------------------------------------------------------*/
function area_usuario2($id_usuario)
{
  global $db;
  $id_usuario = (int)$id_usuario;

  $sql = $db->query("SELECT a.nombre_area FROM  area g LEFT JOIN users u ON u.user_level = g.id LEFT JOIN detalles_usuario d ON u.id_detalle_user = d.id 
                      LEFT JOIN cargos c ON c.id = d.id_cargo LEFT JOIN area a ON a.id = c.id_area WHERE u.id = '{$db->escape($id_usuario)}' LIMIT 1");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}

/* -------------------------------------------------------------------*/
/* Función para obtener el cargo al que pertenece el usuario logueado */
/* -------------------------------------------------------------------*/
function cargo_usuario($id_usuario)
{
  global $db;
  $id_usuario = (int)$id_usuario;

  $sql = $db->query("SELECT c.nombre_cargo FROM  area g LEFT JOIN users u ON u.user_level = g.id LEFT JOIN detalles_usuario d ON u.id_detalle_user = d.id 
                      LEFT JOIN cargos c ON c.id = d.id_cargo LEFT JOIN area a ON a.id = c.id_area WHERE u.id = '{$db->escape($id_usuario)}' LIMIT 1");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}

function cargo_trabajador_pdf($nombre)
{
  global $db;

  $sql = $db->query("SELECT c.nombre_cargo FROM  area g LEFT JOIN users u ON u.user_level = g.id LEFT JOIN detalles_usuario d ON u.id_detalle_user = d.id 
                      LEFT JOIN cargos c ON c.id = d.id_cargo LEFT JOIN area a ON a.id = c.id_area WHERE d.id = '{$db->escape($nombre)}' LIMIT 1");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}

function nombre_trabajador_pdf($nombre)
{
  global $db;

  $sql = $db->query("SELECT d.nombre, d.apellidos FROM  area g LEFT JOIN users u ON u.user_level = g.id LEFT JOIN detalles_usuario d ON u.id_detalle_user = d.id 
                      LEFT JOIN cargos c ON c.id = d.id_cargo LEFT JOIN area a ON a.id = c.id_area WHERE d.id = '{$db->escape($nombre)}' LIMIT 1");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}

/*----------------------------------------------------------------------*/
/* Funcion para checar cual nivel de usuario tiene acceso a cada pagina */
/*----------------------------------------------------------------------*/
function page_require_area($require_area)
{
  global $session;
  $current_user = current_user();
  // $id_user = $current_user['id'];
  $area = area_usuario($current_user['id']);
  $id_area = $area['id'];

  // Le puse || $id_area==2, para que los que son de sistemas
  // si puedan ver todos los módulos
  if (($id_area == $require_area) || ($id_area <= 2)) {
    return true;
  } else {
    $session->msg("d", "¡Lo siento! tu área no tiene permiso para ver esta página.");
    redirect('home.php', false);
  }
}

/*------------------------------------------------------------------*/
/* Ver todas las quejas que han sido agregadas al libro electrónico */
/*------------------------------------------------------------------*/
// function find_all_quejas()
// {
//   $sql = "SELECT * FROM quejas";
//   $result = find_by_sql($sql);
//   return $result;
// }
function find_all_areas_quejas()
{
  $sql = "SELECT * FROM area WHERE RQ=1 ORDER BY nombre_area";
  $result = find_by_sql($sql);
  return $result;
}
function find_all_area_userQ()
{
  $sql = "SELECT u.user_level, d.id_det_usuario, d.nombre, d.apellidos FROM users as u INNER JOIN detalles_usuario as d ON u.id_detalle_user = d.id_det_usuario WHERE u.user_level = 5 ORDER BY d.nombre;";
  $result = find_by_sql($sql);
  return $result;
}
// --------------------------------------------------------------------------- ESTADÍSTICAS ORIENTACIONES ---------------------------------------------------------------------------
// -------------------------------------------------------------------------------- Contar por genero -------------------------------------------------------------------------------
function count_by_id_mujer($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(sexo) AS total FROM " . $db->escape($table) . " WHERE sexo = 'M' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_id_hombre($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(sexo) AS total FROM " . $db->escape($table) . " WHERE sexo = 'H' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_id_lgbt($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(sexo) AS total FROM " . $db->escape($table) . " WHERE sexo = 'LGBTIQ+' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_id_lgbt2($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(sexo) AS total FROM " . $db->escape($table) . " WHERE sexo = 'LGBT' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

// ------------------------------------------------------------------------- Contar por grupo vulnerable -------------------------------------------------------------------------
function count_by_comLg($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Comunidad LGBTIQ+' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_comLg2($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Comunidad LGBT' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_derMuj($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Derecho de las mujeres' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_nna($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Niñas, niños y adolescentes' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_nna2($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Niños y adolescentes' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_disc($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Personas con discapacidad' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_mig($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Personas migrantes' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_vih($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Personas que viven con VIH SIDA' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_gi($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Grupos indígenas' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_perio($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Periodistas' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_ddh($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Defensores de los derechos humanos' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_am($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Adultos mayores' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_int($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Internos' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_otros($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Otros' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_na($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'No Aplica' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

// --------------------------------------------------------------------- Contar por medio de presentación ---------------------------------------------------------------------
function count_by_asesorv($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(medio_presentacion) AS total FROM " . $db->escape($table) . " WHERE medio_presentacion = 'Asesor Virtual' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_asistentev($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(medio_presentacion) AS total FROM " . $db->escape($table) . " WHERE medio_presentacion = 'Asistente Virtual' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_comp($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(medio_presentacion) AS total FROM " . $db->escape($table) . " WHERE medio_presentacion = 'Comparecencia' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_escrito($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(medio_presentacion) AS total FROM " . $db->escape($table) . " WHERE medio_presentacion = 'Escrito' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_vt($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(medio_presentacion) AS total FROM " . $db->escape($table) . " WHERE medio_presentacion = 'Vía telefónica' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_ve($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(medio_presentacion) AS total FROM " . $db->escape($table) . " WHERE medio_presentacion = 'Vía electrónica' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_cndh($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(medio_presentacion) AS total FROM " . $db->escape($table) . " WHERE medio_presentacion = 'Comisión Nacional de los Derechos Humanos' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}


// --------------------------------------------------------------------------- ESTADÍSTICAS CANALIZACIONES --------------------------------------------------------------------------
// -------------------------------------------------------------------------------- Contar por genero -------------------------------------------------------------------------------
function count_by_id_mujerC($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(sexo) AS total FROM " . $db->escape($table) . " WHERE sexo = 'M' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_id_hombreC($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(sexo) AS total FROM " . $db->escape($table) . " WHERE sexo = 'H' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_id_lgbtC($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(sexo) AS total FROM " . $db->escape($table) . " WHERE sexo = 'LGBTIQ+' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

// ------------------------------------------------------------------------- Contar por grupo vulnerable -------------------------------------------------------------------------
function count_by_comLgC($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Comunidad LGBTIQ+' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_derMujC($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Derecho de las mujeres' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_nnaC($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Niñas, niños y adolescentes' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_discC($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Personas con discapacidad' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_migC($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Personas migrantes' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_vihC($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Personas que viven con VIH SIDA' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_giC($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Grupos indígenas' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_perioC($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Periodistas' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_ddhC($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Defensores de los derechos humanos' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_amC($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Adultos mayores' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_intC($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Internos' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_otrosC($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Otros' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_naC($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'No Aplica' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

// --------------------------------------------------------------------- Contar por medio de presentación ---------------------------------------------------------------------
function count_by_asesorvC($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(medio_presentacion) AS total FROM " . $db->escape($table) . " WHERE medio_presentacion = 'Asesor Virtual' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_asistentevC($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(medio_presentacion) AS total FROM " . $db->escape($table) . " WHERE medio_presentacion = 'Asistente Virtual' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_compC($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(medio_presentacion) AS total FROM " . $db->escape($table) . " WHERE medio_presentacion = 'Comparecencia' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_escritoC($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(medio_presentacion) AS total FROM " . $db->escape($table) . " WHERE medio_presentacion = 'Escrito' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_vtC($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(medio_presentacion) AS total FROM " . $db->escape($table) . " WHERE medio_presentacion = 'Vía telefónica' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_veC($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(medio_presentacion) AS total FROM " . $db->escape($table) . " WHERE medio_presentacion = 'Vía electrónica' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_cndhC($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(medio_presentacion) AS total FROM " . $db->escape($table) . " WHERE medio_presentacion = 'Comisión Nacional de los Derechos Humanos' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}


// --------------------------------------------------------------------------- ESTADÍSTICAS CAPACITACIONES ---------------------------------------------------------------------------
// ---------------------------------------------------------------------------- Contar por tipo de evento ----------------------------------------------------------------------------
function count_by_capacitacion($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(tipo_evento) AS total FROM " . $db->escape($table) . " WHERE tipo_evento = 'Capacitación'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_conferencia($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(tipo_evento) AS total FROM " . $db->escape($table) . " WHERE tipo_evento = 'Conferencia'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_curso($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(tipo_evento) AS total FROM " . $db->escape($table) . " WHERE tipo_evento = 'Curso'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_taller($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(tipo_evento) AS total FROM " . $db->escape($table) . " WHERE tipo_evento = 'Taller'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_platica($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(tipo_evento) AS total FROM " . $db->escape($table) . " WHERE tipo_evento = 'Plática'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_diplomado($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(tipo_evento) AS total FROM " . $db->escape($table) . " WHERE tipo_evento = 'Diplomado'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_foro($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(tipo_evento) AS total FROM " . $db->escape($table) . " WHERE tipo_evento = 'Foro'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
/*--------------------------------------------------------------*/
/* Funcion para generar reporte de tipos de evento entre fechas
/*--------------------------------------------------------------*/
function find_capacitacion_tipo_evento_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(tipo_evento) AS total FROM capacitaciones WHERE tipo_evento = 'Capacitación' AND fecha BETWEEN '{$start_date}' AND '$end_date' GROUP BY DATE(fecha),id ORDER BY DATE(fecha) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_conferencia_tipo_evento_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(tipo_evento) AS total FROM capacitaciones WHERE tipo_evento = 'Conferencia' AND fecha BETWEEN '{$start_date}' AND '$end_date' GROUP BY DATE(fecha),id ORDER BY DATE(fecha) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_curso_tipo_evento_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(tipo_evento) AS total FROM capacitaciones WHERE tipo_evento = 'Curso' AND fecha BETWEEN '{$start_date}' AND '$end_date' GROUP BY DATE(fecha),id ORDER BY DATE(fecha) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_taller_tipo_evento_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(tipo_evento) AS total FROM capacitaciones WHERE tipo_evento = 'Taller' AND fecha BETWEEN '{$start_date}' AND '$end_date' GROUP BY DATE(fecha),id ORDER BY DATE(fecha) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_platica_tipo_evento_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(tipo_evento) AS total FROM capacitaciones WHERE tipo_evento = 'Platica' AND fecha BETWEEN '{$start_date}' AND '$end_date' GROUP BY DATE(fecha),id ORDER BY DATE(fecha) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_diplomado_tipo_evento_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(tipo_evento) AS total FROM capacitaciones WHERE tipo_evento = 'Diplomado' AND fecha BETWEEN '{$start_date}' AND '$end_date' GROUP BY DATE(fecha),id ORDER BY DATE(fecha) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_foro_tipo_evento_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(tipo_evento) AS total FROM capacitaciones WHERE tipo_evento = 'Foro' AND fecha BETWEEN '{$start_date}' AND '$end_date' GROUP BY DATE(fecha),id ORDER BY DATE(fecha) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
// ------------------------------------------------------------------------------ Contar por modalidad ------------------------------------------------------------------------------
function count_by_presencial($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(modalidad) AS total FROM " . $db->escape($table) . " WHERE modalidad = 'Presencial'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_en_linea($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(modalidad) AS total FROM " . $db->escape($table) . " WHERE modalidad = 'En línea'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_hibrido($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(modalidad) AS total FROM " . $db->escape($table) . " WHERE modalidad = 'Híbrido'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

// ------------------------------------------------------------------------------ Contar por modalidad ------------------------------------------------------------------------------
function find_presencial_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(modalidad) AS total FROM capacitaciones WHERE modalidad = 'Presencial' AND fecha BETWEEN '{$start_date}' AND '$end_date' GROUP BY DATE(fecha),id ORDER BY DATE(fecha) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}

function find_en_linea_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(modalidad) AS total FROM capacitaciones WHERE modalidad = 'En línea' AND fecha BETWEEN '{$start_date}' AND '$end_date' GROUP BY DATE(fecha),id ORDER BY DATE(fecha) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}

function find_hibrido_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(modalidad) AS total FROM capacitaciones WHERE modalidad = 'Híbrido' AND fecha BETWEEN '{$start_date}' AND '$end_date' GROUP BY DATE(fecha),id ORDER BY DATE(fecha) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}

// --------------------------------------------------------------------- Contar por medio presentacion ---------------------------------------------------------------------
function find_asesorV_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(medio_presentacion) AS total FROM orientacion_canalizacion WHERE medio_presentacion = 'Asesor Virtual' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 1 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_asistenteV_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(medio_presentacion) AS total FROM orientacion_canalizacion WHERE medio_presentacion = 'Asistente Virtual' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 1 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_comparecencia_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(medio_presentacion) AS total FROM orientacion_canalizacion WHERE medio_presentacion = 'Comparecencia' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 1 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_escrito_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(medio_presentacion) AS total FROM orientacion_canalizacion WHERE medio_presentacion = 'Escrito' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 1 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_vTelefonica_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(medio_presentacion) AS total FROM orientacion_canalizacion WHERE medio_presentacion = 'Vía Telefónica' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 1 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_vElectronica_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(medio_presentacion) AS total FROM orientacion_canalizacion WHERE medio_presentacion = 'Vía Electrónica' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 1 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_cndh_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(medio_presentacion) AS total FROM orientacion_canalizacion WHERE medio_presentacion = 'Comisión Nacional de los Derechos Humanos' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 1 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}

// --------------------------------------------------------------------- Contar por grupo vulnerable ---------------------------------------------------------------------
function find_lgbt_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Comunidad LGBTIQ+' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 1 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_lgbt_by_dates2($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Comunidad LGBT' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 1 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_ddm_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Derecho de las mujeres' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 1 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_nna_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Niñas, niños y adolescentes' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 1 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_nna_by_dates2($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Niños y adolescentes' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 1 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_pDiscapacidad_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Personas con discapacidad' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 1 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_pMigrantes_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Personas migrantes' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 1 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_vih_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Personas que viven con VIH SIDA' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 1 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_gIndigenas_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Grupos indígenas' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 1 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_periodistas_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Periodistas' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 1 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_ddh_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Defensores de los Derechos Humanos' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 1 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_aMayores_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Adultos mayores' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 1 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_internos_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Internos' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 1 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_otros_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Otros' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 1 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_na_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'No aplica' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 1 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}

// ---------------------------------------------------------------------------- Contar por género ----------------------------------------------------------------------------
function find_hombre_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(sexo) AS total FROM orientacion_canalizacion WHERE sexo = 'H' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 1 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_mujer_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(sexo) AS total FROM orientacion_canalizacion WHERE sexo = 'M' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 1 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_lgbtiq_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(sexo) AS total FROM orientacion_canalizacion WHERE sexo = 'LGBT' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 1 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_lgbtiq_by_dates2($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(sexo) AS total FROM orientacion_canalizacion WHERE sexo = 'LGBTIQ+' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 1 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}



// --------------------------------------------------------------------- Contar por medio presentacion ---------------------------------------------------------------------
function find_asesorV_by_datesC($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(medio_presentacion) AS total FROM orientacion_canalizacion WHERE medio_presentacion = 'Asesor Virtual' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 2 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_asistenteV_by_datesC($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(medio_presentacion) AS total FROM orientacion_canalizacion WHERE medio_presentacion = 'Asistente Virtual' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 2 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_comparecencia_by_datesC($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(medio_presentacion) AS total FROM orientacion_canalizacion WHERE medio_presentacion = 'Comparecencia' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 2 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_escrito_by_datesC($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(medio_presentacion) AS total FROM orientacion_canalizacion WHERE medio_presentacion = 'Escrito' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 2 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_vTelefonica_by_datesC($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(medio_presentacion) AS total FROM orientacion_canalizacion WHERE medio_presentacion = 'Vía Telefónica' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 2 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_vElectronica_by_datesC($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(medio_presentacion) AS total FROM orientacion_canalizacion WHERE medio_presentacion = 'Vía Electrónica' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 2 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_cndh_by_datesC($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(medio_presentacion) AS total FROM orientacion_canalizacion WHERE medio_presentacion = 'Comisión Nacional de los Derechos Humanos' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 2 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}

// --------------------------------------------------------------------- Contar por grupo vulnerable ---------------------------------------------------------------------
function find_lgbt_by_datesC($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Comunidad LGBTIQ+' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 2 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_lgbt_by_dates2C($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Comunidad LGBT' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 2 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_ddm_by_datesC($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Derecho de las mujeres' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 2 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_nna_by_datesC($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Niñas, niños y adolescentes' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 2 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_nna_by_dates2C($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Niños y adolescentes' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 2 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_pDiscapacidad_by_datesC($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Personas con discapacidad' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 2 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_pMigrantes_by_datesC($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Personas migrantes' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 2 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_vih_by_datesC($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Personas que viven con VIH SIDA' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 2 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_gIndigenas_by_datesC($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Grupos indígenas' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 2 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_periodistas_by_datesC($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Periodistas' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 2 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_ddh_by_datesC($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Defensores de los Derechos Humanos' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 2 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_aMayores_by_datesC($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Adultos mayores' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 2 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_internos_by_datesC($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Internos' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 2 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_otros_by_datesC($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'Otros' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 2 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_na_by_datesC($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(grupo_vulnerable) AS total FROM orientacion_canalizacion WHERE grupo_vulnerable = 'No aplica' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 2 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}

// ---------------------------------------------------------------------------- Contar por género ----------------------------------------------------------------------------
function find_hombre_by_datesC($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(sexo) AS total FROM orientacion_canalizacion WHERE sexo = 'H' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 2 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_mujer_by_datesC($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(sexo) AS total FROM orientacion_canalizacion WHERE sexo = 'M' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 2 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_lgbtiq_by_datesC($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(sexo) AS total FROM orientacion_canalizacion WHERE sexo = 'LGBT' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 2 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_lgbtiq_by_dates2C($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = $db->query("SELECT SUM(total) as totales FROM (SELECT COUNT(sexo) AS total FROM orientacion_canalizacion WHERE sexo = 'LGBTIQ+' AND creacion BETWEEN '{$start_date}' AND '$end_date' AND tipo_solicitud = 2 GROUP BY DATE(creacion),id ORDER BY DATE(creacion) DESC) as total_final");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}

// --------------------------------------------------------------------- Contar por autoridad responsable ---------------------------------------------------------------------
function count_by_aeropuerto($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Aeropuerto de Morelia'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_cobaem($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Colegio de Bachilleres del Estado de Michoacán COBAEM'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_cecytem($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Colegio de Estudios Científicos y Tecnológicos del Estado de Michoacán CECYTEM'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_conalep($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Colegio Nacional de Educación Profesional Técnica CONALEP'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_cocotra($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Comisión Coordinadora del Transporte Publico en Michoacán'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_ceeav($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Comisión Ejecutiva Estatal de Atención a Victimas'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_cecufid($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Comisión Estatal de Cultura Física y Deporte'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_ceagc($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Comisión Estatal del Agua y Gestión de Cuencas'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_cfe($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Comisión Federal de Electricidad CFE'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_cndh4($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Comisión Nacional de los Derechos Humanos CNDH'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_conagua($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Comisión Nacional del Agua CONAGUA'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_condusef($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Comisión Nacional Para la Protección y Defensa de los Usuarios de Servicios Financieros CONDUSEF'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_corett($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Comisión Para la Regularización de la Tenencia de la Tierra CORETT'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_cjee($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Consejería Jurídica del Ejecutivo del Estado'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_cnpd($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Consejo Nacional Para Prevenir la Discriminación'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_ccs($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Coordinación de Comunicación Social'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_cspem($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Coordinación del Sistema Penitenciario del Estado de Michoacán'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_dpf($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Defensoría Publica Federal'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_dcg($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Despacho del C Gobernador'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_drc($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Dirección de Registro Civil'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_dtps($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Dirección de Trabajo y Previsión Social'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_dgti($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Dirección General de Educación Tecnológica Industrial DGTI'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_dgit($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Dirección General de Institutos Tecnológicos'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_fge($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Fiscalía General en el Estado'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_fgr($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Fiscalía General de la República'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_fovissste($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'FOVISSSTE Michoacán'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_hcem($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Honorable Congreso del Estado de Michoacán'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_idpe($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Instituto de la Defensoría Publica del Estado'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_injuve($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Instituto de la Juventud Michoacana'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_issste($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Instituto de Seguridad y Servicios Sociales de los Trabajadores al Servicio del Estado'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_ivem($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Instituto de Vivienda de Michoacán IVEM'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_infonavit($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Instituto del Fondo Nacional de la Vivienda Para los Trabajadores INFONAVIT'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_iem($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Instituto Electoral de Michoacán'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_imss($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Instituto Mexicano del Seguro Social IMSS'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_imced($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Instituto Michoacano de Ciencias de la Educación José María Morelos'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_inea($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Instituto Nacional de Educación Para los Adultos INEA'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_inm($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Instituto Nacional de Migración'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_japge($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Junta de Asistencia Privada del Gobierno del Estado'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_jcem($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Junta de Caminos del Estado de Michoacán'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_jlca($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Junta Local de Conciliación y Arbitraje'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_zoo($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Parque Zoológico Benito Juárez'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pce($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Pensiones Civiles del Estado'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmacu($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Acuitzio'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmag($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Aguililla'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmao($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Álvaro Obregón'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmangama($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Angamacutiro'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmangan($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Angangueo'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmapat($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Apatzingán'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmaquila($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Aquila'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmario($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Ario'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmart($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Arteaga'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmbris($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Briseñas'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmbv($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Buenavista'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmcarac($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Carácuaro'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmcharapan($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Charapan'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmcharo($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Charo'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmchav($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Chavinda'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_cheran($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Cheran'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmchil($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Chilchota'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmchucan($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Chucándiro'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmchuri($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Churintzio'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmcoah($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Coahuayana'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmcoeneo($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Coeneo'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmcotija($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Cotija'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmcuitzeo($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Cuitzeo'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmecuan($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Ecuandureo'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmeh($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Epitacio Huerta'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmeron($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Erongarícuaro'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmzamora($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Gabriel Zamora'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmhidalgo($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Hidalgo'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmhuanda($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Huandacareo'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmhuani($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Huaniqueo'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmhuet($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Huetamo'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmhuiramba($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Huiramba'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pminda($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Indaparapeo'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmirim($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Irimbo'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmixt($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Ixtlán'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmjac($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Jacona'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmjime($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Jiménez'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmjiq($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Jiquilpan'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmsixver($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de José Sixto Verduzco'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmjunga($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Jungapeo'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmhuac($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de la Huacana'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmlapiedad($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de la Piedad'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmlagu($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Lagunillas'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmlc($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Lázaro Cárdenas'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmlosreyes($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de los Reyes'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmmadero($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Madero'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmmarav($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Maravatío'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmmc($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Marcos Castellanos'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmmorelia($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Morelia'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmmorelos($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Morelos'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmmugica($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Múgica'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmnahuatzen($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Nahuatzen'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmnocu($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Nocupétaro'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmnparan($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Nuevo Parangaricutiro'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmnurecho($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Nuevo Urecho'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmnumaran($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Numarán'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmocampo($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Ocampo'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmpajacuaran($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Pajacuarán'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmpanin($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Panindícuaro'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmparacho($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Paracho
    '";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmpatz($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Pátzcuaro'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmpenja($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Penjamillo'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmperiban($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Peribán'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmpure($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Purépero'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmpuruan($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Puruándiro'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmqueren($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Queréndaro'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmquiroga($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Quiroga'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmsahuayo($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Sahuayo'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmsalvesc($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Salvador Escalante'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmsam($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Santa Ana Maya'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmseng($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Senguio'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmtacam($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Tacámbaro'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmtanc($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Tancítaro'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmtangamandapio($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Tangamandapio'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmtangancicuaro($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Tangancicuaro'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmtanhuato($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Tanhuato'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmtaretan($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Taretan'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmtarimbaro($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Tarímbaro'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmtepalcatepec($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Tepalcatepec'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmtingambato($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Tingambato'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmtingu($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Tingüindín'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmtiqui($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Tiquicheo'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmtlalpu($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Tlalpujahua'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmtlaza($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Tlazazalca'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmtocumbo($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Tocumbo'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmtux($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Tuxpan'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmtuzan($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Tuzantla'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmtzintzun($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Tzintzuntzan'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmtzit($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Tzitzio'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmuruapan($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Uruapan'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_pmvenus($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Venustiano Carranza'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_pmvillamar($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Villamar'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_pmvh($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Vista Hermosa'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_pmyure($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Yurécuaro'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_pmzaca($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Zacapu'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_pmzamora2($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Zamora'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_pmzinap($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Zináparo'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_pmzinapecuaro($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Zinapécuaro'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_pmzira($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Ziracuaretiro'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_pmzita($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Presidencia Municipal de Zitácuaro'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_procamich($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Procuraduría Agraria En Michoacán'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_padt($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Procuraduría Auxiliar de la Defensa del Trabajo'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_pfdt($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Procuraduría Federal de la Defensa del Trabajo'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_profeco($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Procuraduría Federal del Consumidor PROFECO'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_qsasr($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Quejas Sin Autoridad Señalada Como Responsable'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_sce($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Secretaria de Contraloría del Estado'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_secbien($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Secretaría de Bienestar'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_scop($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Secretaria de Comunicaciones y Obras Publicas'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_sct($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Secretaria de Comunicaciones y Transportes SCT'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_sculte($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Secretaria de Cultura en el Estado'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_sde($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Secretaria de Desarrollo Económico'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_sdra($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Secretaria de Desarrollo Rural y Agroalimentario'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_sdsh($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Secretaría de Desarrollo Social y Humano'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_sdtum($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Secretaria de Desarrollo Territorial Urbano y Movilidad'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_see($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Secretaria de Educación del Estado'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_sepf($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Secretaria de Educación Pública Federal'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_sfa($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Secretaria de Finanzas y Administración'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_secgobernacion($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Secretaría de Gobernación'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_secgobierno($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Secretaria de Gobierno'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_sisdmm($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Secretaria de Igualdad Sustantiva y Desarrollo de Las Mujeres Michoacanas'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_sedena($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Secretaria de la Defensa Nacional Ejercito Mexicano'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_sme($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Secretaria de los Migrantes En El Extranjero'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}


function count_by_marina($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Secretaria de Marina y Armada de México'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_sre($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Secretaria de Relaciones Exteriores SRE'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_ss($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Secretaria de Salud'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_ssp($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Secretaría de Seguridad Pública'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_sspe($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Secretaria de Seguridad Pública Estatal'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_sspf($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Secretaria de Seguridad Pública Federal'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_sspc($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Secretaria de Seguridad y Protección Ciudadana'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_stps($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Secretaria del Trabajo y Previsión Social'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_sifdmsf($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Sistema Integral de Financiamiento para el Desarrollo de Michoacán Si Financia'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_smrt($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Sistema Michoacano de Radio y Televisión'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_dif($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Sistema Para el Desarrollo Integral de la Familia DIF'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_stj($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Supremo Tribunal de Justicia'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_tbm($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Telebachillerato de Michoacán'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_tcaem($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Tribunal de Conciliación y Arbitraje del Estado de Michoacán'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_tjaem($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Tribunal de Justicia Administrativa del Estado de Michoacán'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_uiim($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Universidad Intercultural Indígena de Michoacán'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_umsnh($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Universidad Michoacana de San Nicolas de Hidalgo UMSNH'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_uvem($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Universidad Virtual del Estado de Michoacán'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_vismorelia($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Visitaduría Morelia'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function count_by_visuruapan($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " WHERE autoridad_responsable = 'Visitaduría Uruapan'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function total_porAutoridad($table)
{
  global $db;
  // if (tableExists($table)) {
  //   return find_by_sql("SELECT autoridad_responsable, COUNT(autoridad_responsable) FROM " . $db->escape($table)) . " GROUP BY autoridad_responsable";
  // }

  global $db;
  $results = array();
  $sql = "SELECT autoridad_responsable, COUNT(autoridad_responsable) AS total FROM " . $db->escape($table) . " GROUP BY autoridad_responsable ORDER BY autoridad_responsable ASC";

  $result = find_by_sql($sql);
  return $result;
}

// ------------------------------------------------------------------------ Contar por nivel de estudios ------------------------------------------------------------------------
function count_by_sin_est($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(nivel_estudios) AS total FROM " . $db->escape($table) . " WHERE nivel_estudios = 'Sin estudios' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_primaria($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(nivel_estudios) AS total FROM " . $db->escape($table) . " WHERE nivel_estudios = 'Primaria' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_secundaria($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(nivel_estudios) AS total FROM " . $db->escape($table) . " WHERE nivel_estudios = 'Secundaria' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_preparatoria($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(nivel_estudios) AS total FROM " . $db->escape($table) . " WHERE nivel_estudios = 'Preparatoria' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_licenciatura($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(nivel_estudios) AS total FROM " . $db->escape($table) . " WHERE nivel_estudios = 'Licenciatura' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_especialidad($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(nivel_estudios) AS total FROM " . $db->escape($table) . " WHERE nivel_estudios = 'Especialidad' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_maestria($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(nivel_estudios) AS total FROM " . $db->escape($table) . " WHERE nivel_estudios = 'Maestría' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_doctorado($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(nivel_estudios) AS total FROM " . $db->escape($table) . " WHERE nivel_estudios = 'Doctorado' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_posdoctorado($table, $tipo)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(nivel_estudios) AS total FROM " . $db->escape($table) . " WHERE nivel_estudios = 'Posdoctorado' and tipo_solicitud = '{$db->escape($tipo)}'";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

/*--------------------------------------------------------------*/
/* Funcion encontrar todas las autoridades
/*--------------------------------------------------------------*/
function find_all_autoridades()
{
  global $db;
  $sql  = "SELECT c.id_cat_aut, c.nombre_autoridad, t.tipo FROM cat_autoridades as c LEFT JOIN tipo_autoridad as t ON t.id_tipo_aut = c.tipo_autoridad ORDER BY c.nombre_autoridad;";
  return $db->query($sql);
}

/*--------------------------------------------------------------*/
/* Funcion para mostrar las quejas
/*--------------------------------------------------------------*/
function quejas()
{
  global $db;
  $sql = "SELECT DISTINCT t.number as Folio_Queja, t.lastupdate as Ultima_Actualizacion, d.subject as Autoridad_Responsable,u.name as Creado_Por,";
  $sql .= " d.priority as Prioridad, s.firstname as Asignado_Nombre, s.lastname as Asignado_Apellido, st.state, t.status_id, t.isoverdue, t.isanswered, t.created, d.ticket_id, d.n_autoridad";
  $sql .= " FROM ost_ticket as t";
  $sql .= " LEFT JOIN ost_ticket__cdata as d ON t.ticket_id = d.ticket_id";
  $sql .= " LEFT JOIN ost_staff as s ON t.staff_id = s.staff_id";
  $sql .= " LEFT JOIN ost_user as u ON u.id = t.user_id";
  $sql .= " LEFT JOIN ost_ticket_status as st ON st.id = t.status_id";
  return find_by_sql2($sql);
}
function find_by_sql2($sql)
{
  global $db;
  $result = $db->query($sql);
  $result_set = $db->while_loop($result);
  return $result_set;
}