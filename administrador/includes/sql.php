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

/*--------------------------------------------------------------*/
/* Funcion para encontrar en una tabla toda la informacion
/*--------------------------------------------------------------*/
function find_all_orden($table)
{
  global $db;
  if (tableExists($table)) {
    return find_by_sql("SELECT * FROM " . $db->escape($table)) . " ORDER BY nombre_componente ASC";
  }
}

function find_all_order($table, $order)
{
  global $db;
  if (tableExists($table)) {
    return find_by_sql("SELECT * FROM " . $db->escape($table) . " ORDER BY " . $db->escape($order));
  }
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
function find_by_id($table, $id)
{
  global $db;
  $id = (int)$id;
  if (tableExists($table)) {
    $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE id='{$db->escape($id)}' LIMIT 1");
    if ($result = $db->fetch_assoc($sql))
      return $result;
    else
      return null;
  }
}
/*--------------------------------------------------------------*/
/*  Funcion para encontrar datos por su id en una tabla
/*--------------------------------------------------------------*/
function find_by_id_cargo($table, $id)
{
  global $db;
  $id = (int)$id;
  if (tableExists($table)) {
    $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE id='{$db->escape($id)}' ORDER BY nombre_cargo LIMIT 1");
    if ($result = $db->fetch_assoc($sql))
      return $result;
    else
      return null;
  }
}

/*--------------------------------------------------------------*/
/*  Funcion para encontrar datos por su id en una tabla
/*--------------------------------------------------------------*/
/*--------------------------------------------------------------*/
/*  Funcion para encontrar datos por su id en una tabla
/*--------------------------------------------------------------*/
function find_by_id_vehiculo($id)
{
  global $db;
  $sql = array();
  $sql  = "SELECT v.id,v.nombre_vehiculo,t.tipo_vehiculo,v.marca,v.modelo,v.anio,v.no_serie,v.color,v.placas,v.motor,v.descripcion,";
  $sql  .= " v.observaciones,v.kilometraje,v.ultimo_servicio,v.proximo_servicio,v.estatus_vehiculo";
  $sql  .= " FROM vehiculos v";
  $sql  .= " LEFT JOIN tipo_vehiculo t ON t.id = v.id_tipo_vehiculo";
  $sql  .= " WHERE v.id='{$db->escape($id)}'";
  $result = find_by_sql($sql);
  return $result;


  // global $db;
  // $result = array();
  // $sql = "SELECT u.id_cargo, c.nombre_cargo ";
  // $sql .= "FROM detalles_usuario u ";
  // $sql .= "LEFT JOIN cargos c ";
  // $sql .= "ON u.id_cargo=c.id WHERE u.id='{$db->escape($id)}'";
  // $result = find_by_sql($sql);
  // return $result;
}

/*--------------------------------------------------------------*/
/*  Funcion para encontrar datos por su id en una tabla
/*--------------------------------------------------------------*/
function find_by_id_detalle($id)
{
  global $db;
  $result = array();
  $sql = "SELECT id_componente, cantidad ";
  $sql .= "FROM asignaciones ";
  $sql .= "WHERE id_detalle_usuario='{$db->escape($id)}' ";
  $result = find_by_sql($sql);
  return $result;
}

/*--------------------------------------------------------------*/
/*  Funcion para encontrar datos por su id en una tabla
/*--------------------------------------------------------------*/
function find_by_id_queja($id)
{
  global $db;
  $id = (int)$id;
  $sql = $db->query("SELECT * FROM quejas WHERE id = '{$db->escape($id)}'");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}

/*--------------------------------------------------------------*/
/*  Funcion para encontrar datos por su id en una tabla
/*--------------------------------------------------------------*/
function find_by_id_detalle_vehiculo($id)
{
  global $db;
  $result = array();
  $sql = "SELECT id_vehiculo ";
  $sql .= "FROM asignaciones_vehiculos ";
  $sql .= "WHERE id_detalle_usuario='{$db->escape($id)}' ";
  $result = find_by_sql($sql);
  return $result;
}
/*-----------------------------------------------------------------------------------------*/
/* Funcion para encontrar todos los resguardos que tengan el mismo id_asignacion_resguardo */
/*-----------------------------------------------------------------------------------------*/
function find_by_id_asignacion_resguardo($table, $id)
{
  global $db;
  $id = (int)$id;
  if (tableExists($table)) {
    $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE id_asignacion_resguardo='{$db->escape($id)}'");
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
  $sql .= "ON u.id_cargo=c.id WHERE u.id='{$db->escape($id)}'";
  $result = find_by_sql($sql);
  return $result;
}
/*----------------------------------------------------------*/
/* Funcion para encontrar el nivel de usuario de un usuario */
/*----------------------------------------------------------*/
function find_user_level($table, $id)
{
  global $db;
  if (tableExists($table)) {
    return find_by_sql("SELECT * FROM " . $db->escape($table) . " WHERE id=" . $db->escape($id));
  }
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
/*----------------------------------------------------------------------------------------------*/
/* Funcion para cuando se elimina una categoría, poner en el componente que estan Sin categoría */
/*----------------------------------------------------------------------------------------------*/
function categoria_default($id)
{
  global $db;
  $sql = "UPDATE componentes SET id_categoria = 1";
  $sql .= " WHERE id_categoria=" . $db->escape($id);
  $db->query($sql);
  return ($db->affected_rows() >= 1) ? true : false;
}
/*----------------------------------------------------------------------------------------------*/
/* Funcion para cuando se elimina un tipo, poner en el vehiculo que estan Sin Tipo */
/*----------------------------------------------------------------------------------------------*/
function tipo_vehiculo_default($id)
{
  global $db;
  $sql = "UPDATE vehiculos SET id_tipo_vehiculo = 1";
  $sql .= " WHERE id_tipo_vehiculo=" . $db->escape($id);
  $db->query($sql);
  return ($db->affected_rows() >= 1) ? true : false;
}
/*-----------------------------------------------------*/
/* Funcion para eliminar datos de una tabla, por su ID */
/*-----------------------------------------------------*/
function delete_by_id($table, $id)
{
  global $db;
  if (tableExists($table)) {
    $sql = "DELETE FROM " . $db->escape($table);
    $sql .= " WHERE id=" . $db->escape($id);
    $sql .= " LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
  }
}

/*-----------------------------------------------------*/
/* Funcion para eliminar un reguardo completo */
/*-----------------------------------------------------*/
function delete_resguardo($id)
{
  global $db;
  $sql = "DELETE FROM resguardos";
  $sql .= " WHERE id_asignacion_resguardo=" . $db->escape($id);
  $db->query($sql);
  return ($db->affected_rows() > 0) ? true : false;
}
/*-----------------------------------------------*/
/* Funcion para eliminar un reguardo de vehiculo */
/*-----------------------------------------------*/
function delete_resguardo_vehiculo($id)
{
  global $db;
  $sql = "DELETE FROM resguardos_vehiculos";
  $sql .= " WHERE id_asignacion_resguardo=" . $db->escape($id);
  $db->query($sql);
  return ($db->affected_rows() > 0) ? true : false;
}
/*-----------------------------------------------------*/
/* Funcion para eliminar una asignacion de un reguardo */
/*-----------------------------------------------------*/
function delete_by_id_asignacion_resguardo($id, $id_asig_resg)
{
  global $db;
  $sql = "DELETE FROM resguardos";
  $sql .= " WHERE id_asignacion=" . $db->escape($id) . " AND id_asignacion_resguardo=" . $db->escape($id_asig_resg);
  $db->query($sql);
  return ($db->affected_rows() > 0) ? true : false;
}
/*---------------------------------------------------------------*/
/* Funcion para eliminar una asignacion de un reguardo vehicular */
/*---------------------------------------------------------------*/
function delete_by_id_asignacion_resguardo_vehiculo($id, $id_asig_resg)
{
  global $db;
  $sql = "DELETE FROM resguardos_vehiculos";
  $sql .= " WHERE id_asignacion_vehiculo=" . $db->escape($id) . " AND id_asignacion_resguardo=" . $db->escape($id_asig_resg);
  $db->query($sql);
  return ($db->affected_rows() > 0) ? true : false;
}
/*------------------------------------------------------*/
/* Funcion para inactivar datos de una tabla, por su ID */
/*------------------------------------------------------*/
function inactivate_by_id($table, $id, $campo_estatus)
{
  global $db;
  if (tableExists($table)) {
    $sql = "UPDATE " . $db->escape($table) . " SET ";
    $sql .= $db->escape($campo_estatus) . "=0";
    $sql .= " WHERE id=" . $db->escape($id);
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
/*-----------------------------------------------------------------------------*/
/* Funcion para inactivar las asignaciones de un trabajador que fue inactivado */
/*-----------------------------------------------------------------------------*/
function inactivate_by_id_asignacion($table, $id, $campo_estatus)
{
  global $db;
  if (tableExists($table)) {
    $sql = "UPDATE " . $db->escape($table) . " SET ";
    $sql .= $db->escape($campo_estatus) . "=0";
    $sql .= " WHERE id_detalle_usuario=" . $db->escape($id);
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
  }
}
/*-----------------------------------------------------------------------------*/
/* Funcion para inactivar las asignaciones de vehiculos de un trabajador que fue inactivado */
/*-----------------------------------------------------------------------------*/
function inactivate_by_id_asignacion_vehiculo($table, $id, $campo_estatus)
{
  global $db;
  if (tableExists($table)) {
    $sql = "UPDATE " . $db->escape($table) . " SET ";
    $sql .= $db->escape($campo_estatus) . "=0";
    $sql .= " WHERE id_detalle_usuario=" . $db->escape($id);
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
  }
}
/*----------------------------------------------*/
/* Funcion para inactivar el resguardo completo */
/*----------------------------------------------*/
function inactivate_by_id_resguardo($table, $id, $campo_estatus)
{
  global $db;
  if (tableExists($table)) {
    $sql = "UPDATE " . $db->escape($table) . " SET ";
    $sql .= $db->escape($campo_estatus) . "=0";
    $sql .= " WHERE id_asignacion_resguardo=" . $db->escape($id);
    $db->query($sql);
    return ($db->affected_rows() > 0) ? true : false;
  }
}
/*---------------------------------------------------------------------------------*/
/* Funcion para inactivar todos los resguardos de un trabajador cuando se inactive */
/*---------------------------------------------------------------------------------*/
function inactivate_resguardo_trabajador($table, $id, $campo_estatus)
{
  global $db;

  global $db;
  $id = (int)$id;
  $id_asig = "SELECT id FROM asignaciones WHERE id_detalle_usuario = '{$db->escape($id)}'";
  $id_buscado = find_by_sql($id_asig);

  foreach ($id_buscado as $id_encontrado) {
    $id_asig_resg = "SELECT id_asignacion_resguardo FROM resguardos WHERE id_asignacion = '{$db->escape($id_encontrado['id'])}'";
    $id_buscado2 = find_by_sql($id_asig_resg);

    foreach ($id_buscado2 as $id_encontrado2) {
      $nuevo_id_asig_resg2 = (int)$id_encontrado2['id_asignacion_resguardo'];
      $sql2 = "UPDATE " . $db->escape($table) . " SET ";
      $sql2 .= $db->escape($campo_estatus) . "=0";
      $sql2 .= " WHERE id_asignacion_resguardo=" . $db->escape($nuevo_id_asig_resg2);
      $db->query($sql2);
    }
  }
  return ($db->affected_rows() >= 0) ? true : false;
}
/*-------------------------------------------------------------------*/
/* Funcion para inactivar trabajador en funcion del cargo inactivado */
/*-------------------------------------------------------------------*/
function inactivate_cargo_trabajador($table, $id, $campo_estatus)
{
  global $db;
  if (tableExists($table)) {
    $sql = "UPDATE " . $db->escape($table) . " SET ";
    $sql .= $db->escape($campo_estatus) . "=0";
    $sql .= " WHERE id_cargo=" . $db->escape($id);
    $db->query($sql);
    return ($db->affected_rows() > 0) ? true : false;
  }
}
/*-------------------------------------------------------------------*/
/* Funcion para inactivar trabajador en funcion del cargo inactivado */
/*-------------------------------------------------------------------*/
function inactivate_cargo_user($table, $id, $campo_estatus)
{
  global $db;
  $id = (int)$id;
  $id_asig = "SELECT id FROM detalles_usuario WHERE id_cargo = '{$db->escape($id)}'";
  $id_buscado = find_by_sql($id_asig);

  foreach ($id_buscado as $id_encontrado) {
    $sql2 = "UPDATE " . $db->escape($table) . " SET ";
    $sql2 .= $db->escape($campo_estatus) . "=0";
    $sql2 .= " WHERE id_detalle_user=" . $db->escape($id_encontrado['id']);
    $db->query($sql2);
  }
  return ($db->affected_rows() >= 0) ? true : false;
}

/*-------------------------------------------------------------------*/
/* Funcion para inactivar asignacion en funcion del cargo inactivado */
/*-------------------------------------------------------------------*/
function inactivate_cargo_asignacion($table, $id_cargo, $campo_estatus)
{
  global $db;
  $id_cargo = (int)$id_cargo;
  $id_detalle = "SELECT id FROM detalles_usuario WHERE id_cargo = '{$db->escape($id_cargo)}'";
  $id_buscado = find_by_sql($id_detalle);

  foreach ($id_buscado as $id_encontrado) {
    $sql2 = "UPDATE " . $db->escape($table) . " SET ";
    $sql2 .= $db->escape($campo_estatus) . "=0";
    $sql2 .= " WHERE id_detalle_usuario=" . $db->escape($id_encontrado['id']);
    $db->query($sql2);
  }
  return ($db->affected_rows() >= 0) ? true : false;
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

/*------------------------------------------------------------------*/
/* Funcion para inactivar trabajador en funcion del area inactivado */
/*------------------------------------------------------------------*/
function inactivate_area_trabajador($table, $id_area, $campo_estatus)
{
  global $db;
  $id_area = (int)$id_area;
  $id_area = "SELECT id FROM cargos WHERE id_area = '{$db->escape($id_area)}'";
  $id_buscado = find_by_sql($id_area);

  foreach ($id_buscado as $id_encontrado) {
    $sql2 = "UPDATE " . $db->escape($table) . " SET ";
    $sql2 .= $db->escape($campo_estatus) . "=0";
    $sql2 .= " WHERE id_cargo=" . $db->escape($id_encontrado['id']);
    $db->query($sql2);
  }
  return ($db->affected_rows() >= 0) ? true : false;
}

/*---------------------------------------------------------------------*/
/* Funcion para inactivar todos los usuario cuando se inactive su area */
/*---------------------------------------------------------------------*/
function inactivate_area_user($table, $id, $campo_estatus)
{
  global $db;
  $id = (int)$id;
  $id_cargo = "SELECT id FROM cargos WHERE id_area = '{$db->escape($id)}'";
  $id_buscado = find_by_sql($id_cargo);

  foreach ($id_buscado as $id_encontrado) {
    $id_detalle = "SELECT id FROM detalles_usuario WHERE id_cargo = '{$db->escape($id_encontrado['id'])}'";
    $id_buscado2 = find_by_sql($id_detalle);
    foreach ($id_buscado2 as $id_encontrado2) {
      $nuevo_id_detalle = (int)$id_encontrado2['id'];
      if (tableExists($table)) {
        $sql2 = "UPDATE " . $db->escape($table) . " SET ";
        $sql2 .= $db->escape($campo_estatus) . "=0";
        $sql2 .= " WHERE id_detalle_user=" . $db->escape($nuevo_id_detalle);
        $db->query($sql2);
      }
    }
  }
  return ($db->affected_rows() >= 0) ? true : false;
}
/*-----------------------------------------------------*/
/* Funcion para inactivar todas las asignaciones de los  
   trabajadores que pertenecen al area que se inactivo */
/*-----------------------------------------------------*/
function inactivate_area_asignacion($table, $id, $campo_estatus)
{
  global $db;
  $id = (int)$id;
  $id_cargo = "SELECT id FROM cargos WHERE id_area = '{$db->escape($id)}'";
  $id_buscado = find_by_sql($id_cargo);

  foreach ($id_buscado as $id_encontrado) {
    $id_detalle = "SELECT id FROM detalles_usuario WHERE id_cargo = '{$db->escape($id_encontrado['id'])}'";
    $id_buscado2 = find_by_sql($id_detalle);

    foreach ($id_buscado2 as $id_encontrado2) {
      $nuevo_id_detalle = (int)$id_encontrado2['id'];

      if (tableExists($table)) {
        $sql2 = "UPDATE " . $db->escape($table) . " SET ";
        $sql2 .= $db->escape($campo_estatus) . "=0";
        $sql2 .= " WHERE id_detalle_usuario=" . $db->escape($nuevo_id_detalle);
        $db->query($sql2);
      }
    }
  }
  return ($db->affected_rows() >= 0) ? true : false;
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
/*--------------------------------------------------------------------------*/
/* Funcion para inactivar asignaciones, segun el componente que se inactivo */
/*--------------------------------------------------------------------------*/
function inactivate_product_asig($table, $id, $campo_estatus)
{
  global $db;
  if (tableExists($table)) {
    $sql = "UPDATE " . $db->escape($table) . " SET ";
    $sql .= $db->escape($campo_estatus) . "=0";
    $sql .= " WHERE id_componente=" . $db->escape($id);
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
  }
}
/*----------------------------------------------------*/
/* Funcion para activar datos de una tabla, por su ID */
/*----------------------------------------------------*/
function activate_by_id($table, $id, $campo_estatus)
{
  global $db;
  if (tableExists($table)) {
    $sql = "UPDATE " . $db->escape($table) . " SET ";
    $sql .= $campo_estatus . "=1";
    $sql .= " WHERE id=" . $db->escape($id);
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
/*-----------------------------------------------------------------------------------------*/
/* Funcion para activar las asignaciones de un trabajador, cuando este se vuelva a activar */
/*-----------------------------------------------------------------------------------------*/
function activate_by_id_asignacion($table, $id, $campo_estatus)
{
  global $db;
  if (tableExists($table)) {
    $sql = "UPDATE " . $db->escape($table) . " SET ";
    $sql .= $db->escape($campo_estatus) . "=1";
    $sql .= " WHERE id_detalle_usuario=" . $db->escape($id);
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
  }
}
/*-----------------------------------------------------------------------------------------*/
/* Funcion para activar las asignaciones de un trabajador, cuando este se vuelva a activar */
/*-----------------------------------------------------------------------------------------*/
function activate_by_id_asignacion_vehiculo($table, $id, $campo_estatus)
{
  global $db;
  if (tableExists($table)) {
    $sql = "UPDATE " . $db->escape($table) . " SET ";
    $sql .= $db->escape($campo_estatus) . "=1";
    $sql .= " WHERE id_detalle_usuario=" . $db->escape($id);
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
  }
}
/*------------------------------------------------------------------------------------*/
/* Funcion para activar las asignaciones de un resguardo, cuando estas sean activadas */
/*------------------------------------------------------------------------------------*/
function activate_by_id_resguardo($table, $id, $campo_estatus)
{
  global $db;
  if (tableExists($table)) {
    $sql = "UPDATE " . $db->escape($table) . " SET ";
    $sql .= $db->escape($campo_estatus) . "=1";
    $sql .= " WHERE id_asignacion_resguardo=" . $db->escape($id);
    $db->query($sql);
    return ($db->affected_rows() > 0) ? true : false;
  }
}
/*-----------------------------------------------------------------------*/
/* Funcion para activar los resguardos de un trabajador cuando se active */
/*-----------------------------------------------------------------------*/
function activate_resguardo_trabajador($table, $id, $campo_estatus)
{
  global $db;

  global $db;
  $id = (int)$id;
  $id_asig = "SELECT id FROM asignaciones WHERE id_detalle_usuario = '{$db->escape($id)}'";
  $id_buscado = find_by_sql($id_asig);

  foreach ($id_buscado as $id_encontrado) {
    $id_asig_resg = "SELECT id_asignacion_resguardo FROM resguardos WHERE id_asignacion = '{$db->escape($id_encontrado['id'])}'";
    $id_buscado2 = find_by_sql($id_asig_resg);

    foreach ($id_buscado2 as $id_encontrado2) {
      $nuevo_id_asig_resg2 = (int)$id_encontrado2['id_asignacion_resguardo'];
      $sql2 = "UPDATE " . $db->escape($table) . " SET ";
      $sql2 .= $db->escape($campo_estatus) . "=1";
      $sql2 .= " WHERE id_asignacion_resguardo=" . $db->escape($nuevo_id_asig_resg2);
      $db->query($sql2);
    }
  }
  return ($db->affected_rows() >= 0) ? true : false;
}

/*--------------------------------------------------------------*/
/* Funcion para activar usuario en funcion del cargo inactivado */
/*--------------------------------------------------------------*/
function activate_cargo_user($table, $id, $campo_estatus)
{
  global $db;
  $id = (int)$id;
  $id_asig = "SELECT id FROM detalles_usuario WHERE id_cargo = '{$db->escape($id)}'";
  $id_buscado = find_by_sql($id_asig);

  foreach ($id_buscado as $id_encontrado) {
    $sql2 = "UPDATE " . $db->escape($table) . " SET ";
    $sql2 .= $db->escape($campo_estatus) . "=1";
    $sql2 .= " WHERE id_detalle_user=" . $db->escape($id_encontrado['id']);
    $db->query($sql2);
  }
  return ($db->affected_rows() >= 0) ? true : false;
}
/*-----------------------------------------------------------------------*/
/* Funcion para activar detalle de usuario en funcion del cargo activado */
/*-----------------------------------------------------------------------*/
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
/*---------------------------------------------------------------*/
/* Funcion para activar asignacion en funcion del cargo activado */
/*---------------------------------------------------------------*/
function activate_cargo_asignacion($table, $id_cargo, $campo_estatus)
{
  global $db;
  $id_cargo = (int)$id_cargo;
  $id_detalle = "SELECT id FROM detalles_usuario WHERE id_cargo = '{$db->escape($id_cargo)}'";
  $id_buscado = find_by_sql($id_detalle);

  foreach ($id_buscado as $id_encontrado) {
    $sql2 = "UPDATE " . $db->escape($table) . " SET ";
    $sql2 .= $db->escape($campo_estatus) . "=1";
    $sql2 .= " WHERE id_detalle_usuario=" . $db->escape($id_encontrado['id']);
    $db->query($sql2);
  }
  return ($db->affected_rows() >= 0) ? true : false;
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
/*------------------------------------------------------------------*/
/* Funcion para inactivar trabajador en funcion del area inactivado */
/*------------------------------------------------------------------*/
function activate_area_trabajador($table, $id_area, $campo_estatus)
{
  global $db;
  $id_area = (int)$id_area;
  $id_area = "SELECT id FROM cargos WHERE id_area = '{$db->escape($id_area)}'";
  $id_buscado = find_by_sql($id_area);

  foreach ($id_buscado as $id_encontrado) {
    $sql2 = "UPDATE " . $db->escape($table) . " SET ";
    $sql2 .= $db->escape($campo_estatus) . "=1";
    $sql2 .= " WHERE id_cargo=" . $db->escape($id_encontrado['id']);
    $db->query($sql2);
  }
  return ($db->affected_rows() >= 0) ? true : false;
}
/*-----------------------------------------------------------------*/
/* Funcion para activar todos los usuario cuando se active su area */
/*-----------------------------------------------------------------*/
function activate_area_user($table, $id, $campo_estatus)
{
  global $db;
  $id = (int)$id;
  $id_cargo = "SELECT id FROM cargos WHERE id_area = '{$db->escape($id)}'";
  $id_buscado = find_by_sql($id_cargo);

  foreach ($id_buscado as $id_encontrado) {
    $id_detalle = "SELECT id FROM detalles_usuario WHERE id_cargo = '{$db->escape($id_encontrado['id'])}'";
    $id_buscado2 = find_by_sql($id_detalle);
    foreach ($id_buscado2 as $id_encontrado2) {
      $nuevo_id_detalle = (int)$id_encontrado2['id'];
      if (tableExists($table)) {
        $sql2 = "UPDATE " . $db->escape($table) . " SET ";
        $sql2 .= $db->escape($campo_estatus) . "=1";
        $sql2 .= " WHERE id_detalle_user=" . $db->escape($nuevo_id_detalle);
        $db->query($sql2);
      }
    }
  }
  return ($db->affected_rows() >= 0) ? true : false;
}

/*-----------------------------------------------------*/
/* Funcion para inactivar todas las asignaciones de los 
/* trabajadores que pertenecen al area que se inactivo */
/*-----------------------------------------------------*/
function activate_area_asignacion($table, $id, $campo_estatus)
{
  global $db;
  $id = (int)$id;
  $id_cargo = "SELECT id FROM cargos WHERE id_area = '{$db->escape($id)}'";
  $id_buscado = find_by_sql($id_cargo);

  foreach ($id_buscado as $id_encontrado) {
    $id_detalle = "SELECT id FROM detalles_usuario WHERE id_cargo = '{$db->escape($id_encontrado['id'])}'";
    $id_buscado2 = find_by_sql($id_detalle);

    foreach ($id_buscado2 as $id_encontrado2) {
      $nuevo_id_detalle = (int)$id_encontrado2['id'];

      if (tableExists($table)) {
        $sql2 = "UPDATE " . $db->escape($table) . " SET ";
        $sql2 .= $db->escape($campo_estatus) . "=1";
        $sql2 .= " WHERE id_detalle_usuario=" . $db->escape($nuevo_id_detalle);
        $db->query($sql2);
      }
    }
  }
  return ($db->affected_rows() >= 0) ? true : false;
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
/*----------------------------------------------------------------------*/
/* Funcion para activar asignaciones, segun el componente que se activo */
/*----------------------------------------------------------------------*/
function activate_product_asig($table, $id, $campo_estatus)
{
  global $db;
  if (tableExists($table)) {
    $sql = "UPDATE " . $db->escape($table) . " SET ";
    $sql .= $db->escape($campo_estatus) . "=1";
    $sql .= " WHERE id_componente=" . $db->escape($id);
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
  }
}
/*------------------------------------------------------------------*/
/* Funcion para encontrar el ultimo id de asignacion-resguardo
   para despues sumarle uno y que el nuevo resguardo tome ese valor */
/*------------------------------------------------------------------*/
function last_id_asignacion_resguardo()
{
  global $db;
  $sql = "SELECT * FROM resguardos ORDER BY id_asignacion_resguardo DESC LIMIT 1";
  $result = find_by_sql($sql);
  return $result;
}
/*------------------------------------------------------------------*/
/* Funcion para encontrar el ultimo id de asignacion-resguardo
   para despues sumarle uno y que el nuevo resguardo tome ese valor */
/*------------------------------------------------------------------*/
function last_id_asignacion_resguardo_vehiculo()
{
  global $db;
  $sql = "SELECT * FROM resguardos_vehiculos ORDER BY id_asignacion_resguardo DESC LIMIT 1";
  $result = find_by_sql($sql);
  return $result;
}
/*-----------------------------------------------------------------------------------*/
/* Funcion para encontrar los resguardos que tengan el mismo id_asignacion_resguardo */
/*-----------------------------------------------------------------------------------*/
function find_asignacion_resguardo($id)
{
  global $db;
  $id = (int)$id;
  $id_asig_resg = "SELECT id_asignacion_resguardo FROM resguardos WHERE id = '{$db->escape($id)}'";
  $id_buscado = find_by_sql($id_asig_resg);

  foreach ($id_buscado as $id_encontrado) {
    $nuevo_id_asig_resg = (int)$id_encontrado['id_asignacion_resguardo'];
  }

  $sql = $db->query("SELECT * FROM resguardos WHERE id_asignacion_resguardo = '{$db->escape($nuevo_id_asig_resg)}'");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}

/*----------------------------------------------------------*/
/* Función para ver la información completa de un resguardo */
/*----------------------------------------------------------*/
function find_all_asignacion_resguardo($id)
{
  global $db;
  $id = (int)$id;
  $id_asig_resg = "SELECT id_asignacion_resguardo FROM resguardos WHERE id = '{$db->escape($id)}'";
  $id_buscado = find_by_sql($id_asig_resg);

  foreach ($id_buscado as $id_encontrado) {
    $nuevo_id_asig_resg = (int)$id_encontrado['id_asignacion_resguardo'];
  }

  $sql = "SELECT * FROM resguardos WHERE id_asignacion_resguardo = '{$db->escape($nuevo_id_asig_resg)}'";
  $result = find_by_sql($sql);
  return $result;
}

/*--------------------------------------------------------------------*/
/* Función para ver la información completa de un resguardo vehicular */
/*--------------------------------------------------------------------*/
function find_all_asignacion_resguardo_vehiculo($id)
{
  global $db;
  $id = (int)$id;
  $id_asig_resg = "SELECT id_asignacion_resguardo FROM resguardos_vehiculos WHERE id = '{$db->escape($id)}'";
  $id_buscado = find_by_sql($id_asig_resg);

  foreach ($id_buscado as $id_encontrado) {
    $nuevo_id_asig_resg = (int)$id_encontrado['id_asignacion_resguardo'];
  }

  $sql = "SELECT * FROM resguardos_vehiculos WHERE id_asignacion_resguardo = '{$db->escape($nuevo_id_asig_resg)}'";
  $result = find_by_sql($sql);
  return $result;
}

/*-----------------------------------------------------------------------------*/
/* Funcion para encontrar todas las asignaciones que pertenecen a un resguardo */
/*-----------------------------------------------------------------------------*/

function find_all_mi_asignacion_resguardo($id)
{
  global $db;
  $id = (int)$id;

  $sql = "SELECT id_asignacion FROM resguardos WHERE id_asignacion_resguardo = '{$db->escape($id)}'";
  $result = find_by_sql($sql);
  return $result;
}

/*---------------------------------------------------------------------------------------*/
/* Funcion para encontrar todas las asignaciones que pertenecen a un resguardo vehicular */
/*---------------------------------------------------------------------------------------*/

function find_all_mi_asignacion_resguardo_vehiculo($id)
{
  global $db;
  $id = (int)$id;

  $sql = "SELECT id_asignacion_vehiculo FROM resguardos_vehiculos WHERE id_asignacion_resguardo = '{$db->escape($id)}'";
  $result = find_by_sql($sql);
  return $result;
}

/*-------------------------------------------------------------------*/
/* Funcion para mostrar el trabajador al que se asigno un componente */
/*-------------------------------------------------------------------*/

function find_nombre_asignacion_resguardo($id)
{
  global $db;
  $id = (int)$id;

  $sql = "SELECT id_detalle_usuario FROM asignaciones WHERE id = '{$db->escape($id)}'";
  $result = find_by_sql($sql);
  return $result;
}

/*-----------------------------------------------------------------*/
/* Funcion para mostrar el trabajador al que se asigno un vehiculo */
/*-----------------------------------------------------------------*/

function find_nombre_asignacion_resguardo_vehiculo($id)
{
  global $db;
  $id = (int)$id;

  $sql = "SELECT id_detalle_usuario FROM asignaciones_vehiculos WHERE id = '{$db->escape($id)}'";
  $result = find_by_sql($sql);
  return $result;
}
/*--------------------------------------------------------------------------*/
/* Funcion para buscar la información que aparecerá en el PDF del resguardo */
/*--------------------------------------------------------------------------*/
function resguardo_pdf($id)
{
  global $db;
  $id = (int)$id;
  $sql1 = "SELECT id_asignacion_resguardo FROM resguardos WHERE id='{$db->escape($id)}'";
  $id_asig_resg = find_by_sql($sql1);

  foreach ($id_asig_resg as $id_encontrado) {
    $nuevo_id_asig_resg = (int)$id_encontrado['id_asignacion_resguardo'];
  }
  $sql  = "SELECT co.nombre_componente, co.descripcion_particular, a.marca_modelo, a.no_serie, a.cantidad, a.estatus_asignacion,";
  $sql .= " r.fecha_inicio, r.observaciones, r.folio, d.nombre, d.apellidos, d.correo, c.nombre_cargo, ar.nombre_area, ar.abreviatura";
  $sql .= " FROM resguardos r";
  $sql .= " LEFT JOIN asignaciones a ON r.id_asignacion = a.id";
  $sql .= " LEFT JOIN componentes co ON co.id = a.id_componente";
  $sql .= " LEFT JOIN detalles_usuario d ON d.id = a.id_detalle_usuario";
  $sql .= " LEFT JOIN cargos c ON c.id = d.id_cargo";
  $sql .= " LEFT JOIN area ar ON ar.id = c.id_area";
  $sql .= " WHERE id_asignacion_resguardo = '{$db->escape($nuevo_id_asig_resg)}'";
  return find_by_sql($sql);
}
/*------------------------------------------------------------------------------------*/
/* Funcion para buscar la información que aparecerá en el PDF del resguardo vehicular */
/*------------------------------------------------------------------------------------*/
function resguardo_pdf_vehiculo($id)
{
  global $db;
  $id = (int)$id;
  $sql1 = "SELECT id_asignacion_resguardo FROM resguardos_vehiculos WHERE id='{$db->escape($id)}'";
  $id_asig_resg = find_by_sql($sql1);

  foreach ($id_asig_resg as $id_encontrado) {
    $nuevo_id_asig_resg = (int)$id_encontrado['id_asignacion_resguardo'];
  }
  $sql  = "SELECT co.nombre_vehiculo, co.descripcion, a.marca_modelo, a.no_serie, a.placas, a.estatus_asignacion, co.anio, co.motor, co.color,";
  $sql .= " r.fecha_inicio, r.observaciones, d.nombre, d.apellidos, d.correo, c.nombre_cargo, ar.nombre_area";
  $sql .= " FROM resguardos_vehiculos r";
  $sql .= " LEFT JOIN asignaciones_vehiculos a ON r.id_asignacion_vehiculo = a.id";
  $sql .= " LEFT JOIN vehiculos co ON co.id = a.id_vehiculo";
  $sql .= " LEFT JOIN detalles_usuario d ON d.id = a.id_detalle_usuario";
  $sql .= " LEFT JOIN cargos c ON c.id = d.id_cargo";
  $sql .= " LEFT JOIN area ar ON ar.id = c.id_area";
  $sql .= " WHERE id_asignacion_resguardo = '{$db->escape($nuevo_id_asig_resg)}'";
  return find_by_sql($sql);
}
/*------------------------------------------------------------------------*/
/* Funcion para contar los ID de algun campo para saber su cantidad total */
/*------------------------------------------------------------------------*/
function count_by_id($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(id) AS total FROM " . $db->escape($table);
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
/*------------------------------------------------------------------------*/
/* Funcion para contar los ID de algun campo para saber su cantidad total */
/*------------------------------------------------------------------------*/
function count_by_id_quejas($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(id) AS total FROM " . $db->escape($table);
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
/*------------------------------------------------------------------------*/
/* Funcion para contar los ID de orientacion para saber su cantidad total */
/*------------------------------------------------------------------------*/
function count_by_id_orientacion($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(id) AS total FROM " . $db->escape($table) . " WHERE tipo_solicitud = 1";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
/*------------------------------------------------------------------------*/
/* Funcion para contar los ID de canalizacion para saber su cantidad total */
/*------------------------------------------------------------------------*/
function count_by_id_canalizacion($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(id) AS total FROM " . $db->escape($table) . " WHERE tipo_solicitud = 2";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
/*------------------------------------------------------------------------*/
/* Funcion para contar los ID de canalizacion para saber su cantidad total */
/*------------------------------------------------------------------------*/
function count_by_id_med_psic($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(id) AS total FROM " . $db->escape($table);
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
/*------------------------------------------------------------------------------*/
/* Funcion para contar los id_asignacion_resguardo para saber su cantidad total */
/*------------------------------------------------------------------------------*/
function count_by_id_asig_resg()
{
  global $db;
  $sql    = "SELECT COUNT(DISTINCT id_asignacion_resguardo) as total FROM resguardos";
  $result = $db->query($sql);
  return ($db->fetch_assoc($result));
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
  $sql  = "SELECT id,username,password,user_level,status FROM users WHERE username = '{$username}' LIMIT 1";
  $result = $db->query($sql);
  if ($db->num_rows($result)) {
    $user = $db->fetch_assoc($result);
    $password_request = sha1($password);
    if ($password_request === $user['password'] && $user['status'] != 0) {
      return $user['id'];
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
      $current_user = find_by_id('users', $user_id);
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
  $sql = "SELECT u.id,u.id_detalle_user,d.nombre,d.apellidos,u.username,u.user_level,u.status,u.ultimo_login,";
  $sql .= "g.nombre_grupo ";

  $sql .= "FROM users u ";
  $sql .= "LEFT JOIN detalles_usuario d ON d.id = u.id_detalle_user ";
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
  $sql = "SELECT u.id,u.nombre_cargo,u.id_area,u.estatus_cargo,a.nombre_area ";

  $sql .= "FROM cargos u ";
  $sql .= "LEFT JOIN area a ";
  $sql .= "ON u.id_area=a.id ORDER BY a.nombre_area";
  $result = find_by_sql($sql);
  return $result;
}
function find_all_cargos2()
{
  global $db;
  $results = array();
  // SELECT c.id, c.nombre_cargo, a.id, a.nombre_area FROM cargos as c LEFT JOIN area as a ON c.id_area = a.id;
  $sql = "SELECT c.id, c.nombre_cargo, a.id, a.nombre_area ";
  $sql .= "FROM cargos as c LEFT JOIN area as a ON c.id_area = a.id ";
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
  $sql = "SELECT d.id as detalleID,d.nombre,d.apellidos,d.correo,d.telefono_casa,d.telefono_celular,d.id_cargo,d.estatus_detalle,c.id,c.nombre_cargo,c.id_area,a.id,a.nombre_area ";
  $sql .= "FROM detalles_usuario d LEFT JOIN cargos c ON c.id = d.id_cargo LEFT JOIN area a ON a.id = c.id_area ORDER BY d.nombre";
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
  $sql = "UPDATE users SET ultimo_login='{$date}' WHERE id ='{$user_id}' LIMIT 1";
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
/* Funcion para encontrar todos los nombres de los componentes
   haciendo JOIN con categorias y media */
/*--------------------------------------------------------------*/
function join_product_table()
{
  global $db;
  $sql  = " SELECT p.id,p.nombre_componente,p.marca, p.modelo,p.serie,p.cantidad,p.descripcion_particular,p.precio_compra,p.media_id,p.fecha_registro,p.estatus_componente,c.nombre_categoria";
  $sql  .= " AS categorie,m.nombre_archivo AS image";
  $sql  .= " FROM componentes p";
  $sql  .= " LEFT JOIN categorias c ON c.id = p.id_categoria";
  $sql  .= " LEFT JOIN media m ON m.id = p.media_id";
  $sql  .= " ORDER BY DATE (p.fecha_registro) DESC";
  return find_by_sql($sql);
}
/* Funcion para encontrar todos los vehiculos
   haciendo JOIN con categorias y media */
/*--------------------------------------------------------------*/
function join_vehicle_table()
{
  global $db;
  $sql  = " SELECT v.id,v.nombre_vehiculo,t.tipo_vehiculo,v.marca,v.modelo,v.anio,v.no_serie,v.color,v.placas,v.motor,v.descripcion,";
  $sql  .= " v.observaciones,v.kilometraje,v.media_id,v.ultimo_servicio,v.proximo_servicio,v.estatus_vehiculo,m.nombre_archivo AS image";
  $sql  .= " FROM vehiculos v";
  $sql  .= " LEFT JOIN tipo_vehiculo t ON t.id = v.id_tipo_vehiculo";
  $sql  .= " LEFT JOIN media m ON m.id = v.media_id";
  $sql  .= " ORDER BY DATE (t.tipo_vehiculo) DESC";
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Funcion para encontrar todos los nombres de producto
   haciendo un request a ajax.php para hacer la auto sugerencia */
/*--------------------------------------------------------------*/

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
/* Funcion para encontrar auto por su tipo */
/*--------------------------------------------------------------*/
function find_vehiculo_by_tipo($tipo)
{
  global $db;
  $t_vehiculo = remove_junk($db->escape($tipo));
  $sql = "SELECT v.nombre_vehiculo, v.marca, v.modelo, v.placas, t.tipo_vehiculo FROM vehiculos v INNER JOIN tipo_vehiculo t ON v.id_tipo_vehiculo = t.id WHERE t.tipo_vehiculo like '%$t_vehiculo%' LIMIT 5";

  $result = find_by_sql($sql);
  return $result;
}

/*--------------------------------------------------------------*/
/* Encontrar componente por su ID */
/*--------------------------------------------------------------*/

function find_product_by_id($p_id)
{
  global $db;
  $sql = "SELECT cantidad FROM componentes WHERE id='{$p_id}'";
  $result = find_by_sql($sql);
  return $result;
}
/*--------------------------------------------------------------*/
/* Encontrar vehículo por su ID */
/*--------------------------------------------------------------*/

// function find_vehicle_by_id($p_id)
// {
//   global $db;
//   $sql = "SELECT cantidad FROM componentes WHERE id='{$p_id}'";
//   $result = find_by_sql($sql);
//   return $result;
// }

/*--------------------------------------------------------------*/
/* Encontrar datos de componente por su ID */
/*--------------------------------------------------------------*/

function find_product_by_id_completo($p_id)
{
  global $db;
  $sql = "SELECT * FROM componentes WHERE id='{$p_id}' LIMIT 1";
  $result = find_by_sql($sql);
  return $result;
}

/*--------------------------------------------------------------*/
/* Encontrar el nombre completo de un trabajador */
/*--------------------------------------------------------------*/

function find_all_nombre($detalle_nombre)
{
  global $db;
  $d_nombre = remove_junk($db->escape($detalle_nombre));
  $sql = "SELECT nombre, apellidos FROM componentes WHERE nombre_componente like '%$d_nombre%' LIMIT 5";
  $result = find_by_sql($sql);
  return $result;
}

/*--------------------------------------------------------------*/
/* Funcion para encontrar toda la informacion de los componentes por nombre del mismo
  /* haciendo Request de ajax.php
  /*--------------------------------------------------------------*/
function find_all_product_info_by_title($title)
{
  global $db;
  $sql  = "SELECT * FROM componentes ";
  $sql .= " WHERE nombre_componente ='{$title}'";
  $sql .= " LIMIT 1";
  return find_by_sql($sql);
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
/* Encontrar todos los vehiculos por nombre de vehiculo, marca
   modelo y placas*/
/*--------------------------------------------------------------*/

function find_all_vehicle_info_by_title_marca($tipo_vehiculo, $marca, $modelo, $placas)
{
  global $db;
  $sql  = "SELECT v.id,v.marca,v.modelo,v.no_serie,v.placas,v.descripcion,t.tipo_vehiculo FROM vehiculos v";
  $sql .= " INNER JOIN tipo_vehiculo t ON v.id_tipo_vehiculo = t.id WHERE t.tipo_vehiculo = '{$tipo_vehiculo}' AND v.marca = '{$marca}'";
  $sql .= " AND v.modelo = '{$modelo}' AND v.placas = '{$placas}'";
  $sql .= " LIMIT 1";
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Funcion para ver si el vehiculo esta disponible */
/*--------------------------------------------------------------*/
function dispo_vehiculo($id, $placas)
{
  global $db;
  $sql  = "SELECT estatus_vehiculo FROM vehiculos";
  $sql .= " WHERE id = '{$id}' AND placas = '{$placas}'";
  $sql .= " LIMIT 1";
  return find_by_sql($sql);
}

/*--------------------------------------------------------------*/
/* Funcion para actualizar a ocupado un vehiculo
/*--------------------------------------------------------------*/
function update_estatus_vehiculo($p_id, $placas)
{
  global $db;
  $id  = (int)$p_id;
  $sql = "UPDATE vehiculos SET estatus_vehiculo=0 WHERE id = '{$id}' AND placas = '{$placas}'";
  $result = $db->query($sql);
  return ($db->affected_rows() === 1 ? true : false);
}

/*--------------------------------------------------------------*/
/* Funcion para actualizar a disponible un vehiculo
/*--------------------------------------------------------------*/
function update_estatus_vehiculo_disponible($p_id, $placas)
{
  global $db;
  $id  = (int)$p_id;
  $sql = "UPDATE vehiculos SET estatus_vehiculo=1 WHERE id = '{$id}' AND placas = '{$placas}'";
  $result = $db->query($sql);
  return ($db->affected_rows() === 1 ? true : false);
}


/*--------------------------------------------------------------*/
/* Funcion para ver si un vehiculo esta asignado
/*--------------------------------------------------------------*/
function vehiculo_asignado($p_id, $placas)
{
  global $db;
  $id  = (int)$p_id;
  $sql = "SELECT COUNT(id_vehiculo) as total, estatus_asignacion FROM asignaciones_vehiculos WHERE id_vehiculo = '{$id}' AND placas = '{$placas}'";
  $a = find_by_sql($sql);
  // foreach($a as $d){
  //   $d['total'];
  // }
  // $res = $d['total'];
  return $a;
}

/*--------------------------------------------------------------*/
/* Funcion para actualizar la cantidad de un producto
/*--------------------------------------------------------------*/
function update_product_qty($qty, $p_id)
{
  global $db;
  $qty = (int) $qty;
  $id  = (int)$p_id;
  $sql = "UPDATE componentes SET cantidad=cantidad -'{$qty}' WHERE id = '{$id}'";
  $result = $db->query($sql);
  return ($db->affected_rows() === 1 ? true : false);
}
/*--------------------------------------------------------------*/
/* Funcion para actualizar la cantidad de un producto
/*--------------------------------------------------------------*/
function update_new_product_qty($qty, $p_id)
{
  global $db;
  $qty = (int) $qty;
  $id  = (int)$p_id;
  $sql = "UPDATE componentes SET cantidad=cantidad -'{$qty}' WHERE id = '{$id}'";
  $result = $db->query($sql);
  return ($db->affected_rows() === 1 ? true : false);
}
/*--------------------------------------------------------------*/
/* Funcion para actualizar la cantidad de un producto
/*--------------------------------------------------------------*/
function update_last_product_qty($qty, $p_id)
{
  global $db;
  $qty = (int) $qty;
  $id  = (int)$p_id;
  $sql = "UPDATE componentes SET cantidad=cantidad +'{$qty}' WHERE id = '{$id}'";
  $result = $db->query($sql);
  return ($db->affected_rows() === 1 ? true : false);
}

/*--------------------------------------------------------------*/
/* Funcion para actualizar el trabajador de la asignacion sin 
   que haya problema cuando el componente asignado tenga 0 en
   el inventario
/*--------------------------------------------------------------*/
function update_trabajador_asignacion($nuevo_detalle, $id_asignacion)
{
  global $db;
  $nuevo_detalle = (int) $nuevo_detalle;
  $id_asignacion  = (int)$id_asignacion;
  $sql = "UPDATE asignaciones SET id_detalle_usuario='{$nuevo_detalle}' WHERE id = '{$id_asignacion}'";
  $result = $db->query($sql);
  return ($db->affected_rows() === 1 ? true : false);
}
/*--------------------------------------------------------------*/
/* Funcion para actualizar la fecha de la asignacion sin 
   que haya problema cuando el componente asignado tenga 0 en
   el inventario
/*--------------------------------------------------------------*/
function update_fecha_asignacion($nueva_fecha, $id_asignacion)
{
  global $db;
  $id_asignacion  = (int)$id_asignacion;
  $sql = "UPDATE asignaciones SET fecha_asignacion='{$nueva_fecha}' WHERE id = '{$id_asignacion}'";
  $result = $db->query($sql);
  return ($db->affected_rows() === 1 ? true : false);
}
/*--------------------------------------------------------------*/
/* Encontrar los productos agregados recientemente
/*--------------------------------------------------------------*/
function encuentra_agregados_recientes($limit)
{
  global $db;
  $sql   = " SELECT p.id,p.nombre_componente,p.precio_compra,p.media_id,c.nombre_categoria AS categoria,";
  $sql  .= "m.nombre_archivo AS image FROM componentes p";
  $sql  .= " LEFT JOIN categorias c ON c.id = p.id_categoria";
  $sql  .= " LEFT JOIN media m ON m.id = p.media_id";
  $sql  .= " ORDER BY p.id DESC LIMIT " . $db->escape((int)$limit);
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Encontrar los componentes más asignados
/*--------------------------------------------------------------*/
function encuentra_componentes_mas_asignados($limit)
{
  global $db;
  $sql  = "SELECT p.nombre_componente, COUNT(s.id_componente) AS totalAsignado, SUM(s.cantidad) AS totalQty";
  $sql .= " FROM asignaciones s";
  $sql .= " LEFT JOIN componentes p ON p.id = s.id_componente ";
  $sql .= " GROUP BY s.id_componente";
  $sql .= " ORDER BY SUM(s.cantidad) DESC LIMIT " . $db->escape((int)$limit);
  return $db->query($sql);
}
/*--------------------------------------------------------------*/
/* Encontrar todas las asignaciones
/*--------------------------------------------------------------*/
function find_all_asignaciones()
{
  global $db;
  $sql  = "SELECT s.id,s.cantidad,s.marca_modelo,s.no_serie,s.id_detalle_usuario,p.precio_compra,p.marca,p.modelo,s.fecha_asignacion,p.nombre_componente";
  $sql .= " FROM asignaciones s";
  $sql .= " LEFT JOIN componentes p ON s.id_componente = p.id";
  $sql .= " ORDER BY s.fecha_asignacion DESC";
  return find_by_sql($sql);
}

/*--------------------------------------------------------------*/
/* Encontrar area para folio en asignaciones
/*--------------------------------------------------------------*/
function area_folio($id_detalle)
{
  // global $db;
  // $id_detalle2 = (int)$id_detalle;
  // $sql  = "SELECT d.nombre, d.apellidos, d.id_cargo, a.nombre_area, a.abreviatura";
  // $sql .= " FROM detalles_usuario d LEFT JOIN cargos c ON d.id_cargo = c.id";
  // $sql .= " LEFT JOIN area a ON c.id_area = a.id";
  // $sql .= " WHERE d.id = '{$id_detalle2}'";
  // return find_by_sql($sql);
  global $db;
  $id = (int)$id_detalle;

  $sql = $db->query("SELECT a.abreviatura FROM area a LEFT JOIN cargos c ON a.id = c.id_area LEFT JOIN detalles_usuario d ON d.id_cargo = c.id LEFT JOIN asignaciones asig ON asig.id_detalle_usuario = d.id WHERE asig.id = '{$id}'");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}

/*--------------------------------------------------------------*/
/* Encontrar todas las asignaciones
/*--------------------------------------------------------------*/
function area_folio_vehiculos($id_detalle)
{
  global $db;
  $id = (int)$id_detalle;

  $sql = $db->query("SELECT a.abreviatura FROM area a LEFT JOIN cargos c ON a.id = c.id_area LEFT JOIN detalles_usuario d ON d.id_cargo = c.id LEFT JOIN asignaciones_vehiculos asig ON asig.id_detalle_usuario = d.id WHERE asig.id = '{$id}'");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}

/*--------------------------------------------------------------*/
/* Busca el folio de un resguardo
/*--------------------------------------------------------------*/
function busca_folio($id)
{
  global $db;
  $id_resguardo = (int)$id;

  $sql = $db->query("SELECT folio FROM resguardos WHERE id = '{$id_resguardo}'");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
/*--------------------------------------------------------------*/
/* Busca el folio de un resguardo vehicular
/*--------------------------------------------------------------*/
function busca_folio_vehicular($id)
{
  global $db;
  $id_resguardo = (int)$id;

  $sql = $db->query("SELECT folio FROM resguardos_vehiculos WHERE id = '{$id_resguardo}'");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}

/*--------------------------------------------------------------*/
/* Encontrar todas los resguardos de componentes
/*--------------------------------------------------------------*/
function find_all_resguardos()
{
  global $db;
  $sql  = "SELECT r.id as idResguardo,r.fecha_inicio,r.fecha_termino,r.observaciones,r.id_asignacion as idAsig,r.folio,r.estatus_resguardo,s.id,r.id_asignacion_resguardo";
  $sql .= " FROM resguardos r";
  $sql .= " LEFT JOIN asignaciones s ON s.id = r.id_asignacion GROUP BY id_asignacion_resguardo DESC";
  //SELECT * FROM `resguardos` GROUP BY id_asignacion_resguardo DESC
  return find_by_sql($sql);
}

/*--------------------------------------------------------------*/
/* Encontrar todas los resguardos vehiculares
/*--------------------------------------------------------------*/
function find_all_resguardos_vehiculo()
{
  global $db;
  $sql  = "SELECT r.id as idResguardo,r.fecha_inicio,r.fecha_termino,r.observaciones,r.id_asignacion_vehiculo as idAsig,r.folio,r.estatus_resguardo,s.id,r.id_asignacion_resguardo";
  $sql .= " FROM resguardos_vehiculos r";
  $sql .= " LEFT JOIN asignaciones_vehiculos s ON s.id = r.id_asignacion_vehiculo GROUP BY id_asignacion_resguardo DESC";
  //SELECT * FROM `resguardos` GROUP BY id_asignacion_resguardo DESC
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Esta funcion es para utilizar la barra de busqueda de asignaciones */
/*--------------------------------------------------------------*/
function find_all_asignaciones_busqueda()
{
  global $db;
  $sql = "SELECT s.id,s.cantidad,s.marca_modelo,s.descripcion,s.no_serie,s.id_detalle_usuario,s.estatus_asignacion,p.precio_compra as precio,";
  $sql .= "s.fecha_asignacion,p.nombre_componente, p.marca, p.modelo, p.serie, d.nombre, d.apellidos FROM asignaciones s LEFT JOIN componentes p ON s.id_componente = p.id ";
  $sql .= "LEFT JOIN detalles_usuario d ON d.id = s.id_detalle_usuario ORDER BY s.fecha_asignacion DESC";

  // $query .= "FROM asignaciones s LEFT JOIN componentes p ON s.id_componente = p.id LEFT JOIN detalles_usuario d ON d.id = s.id_detalle_usuario";
  // $query .= "WHERE p.nombre_componente LIKE '%".$q."%' OR d.nombre LIKE '%".$q."%' OR d.apellidos LIKE '%".$q."%' ORDER BY s.fecha_asignacion DESC";
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Esta funcion es para utilizar la barra de busqueda de asignaciones vehiculares*/
/*--------------------------------------------------------------*/
function find_all_asignaciones_busqueda_vehiculos()
{
  global $db;
  $sql = "SELECT s.id,s.id_vehiculo,s.marca_modelo,s.descripcion,s.no_serie,s.id_detalle_usuario,s.placas,s.estatus_asignacion,t.tipo_vehiculo,v.color,v.motor,";
  $sql .= "s.fecha_asignacion,v.id_tipo_vehiculo, v.marca, v.modelo, v.no_serie, d.nombre, d.apellidos FROM asignaciones_vehiculos s LEFT JOIN vehiculos v ON s.id_vehiculo = v.id ";
  $sql .= "LEFT JOIN tipo_vehiculo t ON v.id_tipo_vehiculo = t.id LEFT JOIN detalles_usuario d ON d.id = s.id_detalle_usuario ORDER BY s.fecha_asignacion DESC";

  // $query .= "FROM asignaciones s LEFT JOIN componentes p ON s.id_componente = p.id LEFT JOIN detalles_usuario d ON d.id = s.id_detalle_usuario";
  // $query .= "WHERE p.nombre_componente LIKE '%".$q."%' OR d.nombre LIKE '%".$q."%' OR d.apellidos LIKE '%".$q."%' ORDER BY s.fecha_asignacion DESC";
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Esta funcion es para utilizar la barra de busqueda de asignaciones */
/*--------------------------------------------------------------*/
function find_all_asignaciones_vehiculos()
{
  global $db;
  $sql = "SELECT s.id,v.nombre_vehiculo,s.id_vehiculo,s.marca_modelo,s.descripcion,s.no_serie,s.placas,s.id_detalle_usuario,";
  $sql .= "s.fecha_asignacion,s.estatus_asignacion,v.id_tipo_vehiculo, v.marca, v.modelo, v.no_serie,v.color,d.nombre, d.apellidos";
  $sql .= " FROM asignaciones_vehiculos s LEFT JOIN tipo_vehiculo t ON s.id_vehiculo = t.id";
  $sql .= " LEFT JOIN vehiculos v ON s.id_vehiculo = v.id";
  $sql .= " LEFT JOIN detalles_usuario d ON d.id = s.id_detalle_usuario";
  $sql .= " ORDER BY s.fecha_asignacion DESC";

  // $query .= "FROM asignaciones s LEFT JOIN componentes p ON s.id_componente = p.id LEFT JOIN detalles_usuario d ON d.id = s.id_detalle_usuario";
  // $query .= "WHERE p.nombre_componente LIKE '%".$q."%' OR d.nombre LIKE '%".$q."%' OR d.apellidos LIKE '%".$q."%' ORDER BY s.fecha_asignacion DESC";
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Esta funcion es para utilizar la barra de busqueda de users */
/*--------------------------------------------------------------*/
function find_all_users_busqueda($q)
{
  global $db;
  $results = array();
  $sql = "SELECT u.id,u.id_detalle_user,d.nombre,d.apellidos,u.username,u.user_level,u.status,u.ultimo_login,";
  $sql .= "g.nombre_grupo ";

  $sql .= "FROM users u ";
  $sql .= "LEFT JOIN detalles_usuario d ON d.id = u.id_detalle_user ";
  $sql .= "LEFT JOIN grupo_usuarios g ";
  $sql .= "ON g.nivel_grupo=u.user_level WHERE d.nombre LIKE '%$q%' OR d.apellidos LIKE '%$q%' OR u.username LIKE '%$q%' ORDER BY d.nombre";
  $result = find_by_sql($sql);
  return $result;
}

/*--------------------------------------------------------------*/
/* Esta funcion es para utilizar la barra de busqueda de detalles de usuario */
/*--------------------------------------------------------------*/
function find_all_detalles_busqueda($q)
{
  global $db;
  $results = array();
  $sql = "SELECT d.id as detalleID,d.nombre,d.apellidos,d.correo,d.telefono_casa,d.telefono_celular,d.id_cargo,d.estatus_detalle,c.id,c.nombre_cargo ";
  $sql .= "FROM detalles_usuario d LEFT JOIN cargos c ON c.id = d.id_cargo WHERE d.nombre LIKE '%$q%' OR d.apellidos LIKE '%$q%' OR d.correo LIKE '%$q%' OR c.nombre_cargo LIKE '%$q%' ORDER BY d.nombre";
  $result = find_by_sql($sql);
  return $result;
}

/*--------------------------------------------------------------*/
/* Funcion para encontrar todas "mis asignaciones" que tiene un trabajador */
/*--------------------------------------------------------------*/
function  misasignacionesBusqueda($id, $q)
{
  global $db;
  $sql = "SELECT s.id,s.cantidad,s.marca_modelo,s.descripcion,s.fecha_asignacion,s.id_componente,p.nombre_componente as componente";
  $sql .= " FROM asignaciones s LEFT JOIN componentes p ON s.id_componente = p.id ";
  $sql .= "WHERE id_detalle_usuario = {$id} AND (p.nombre_componente LIKE '%$q%' OR s.marca_modelo LIKE '%$q%')";
  // $sql .= "LIKE '%$q%' OR d.nombre LIKE '%$q%' OR d.apellidos LIKE '%$q%' ORDER BY s.fecha_asignacion DESC";
  // $sql  = "SELECT * FROM asignaciones WHERE id_detalle_usuario = {$id} AND  ORDER BY fecha_asignacion DESC";
  return find_by_sql($sql);
}

function find_all_products_busqueda($q)
{
  global $db;
  $results = array();
  $sql  = " SELECT p.id,p.nombre_componente,p.marca, p.modelo,p.serie,p.cantidad,p.descripcion_particular,p.precio_compra,p.media_id,p.fecha_registro,c.nombre_categoria";
  $sql  .= " AS categorie,m.nombre_archivo AS image";
  $sql  .= " FROM componentes p";
  $sql  .= " LEFT JOIN categorias c ON c.id = p.id_categoria";
  $sql  .= " LEFT JOIN media m ON m.id = p.media_id";
  $sql .= " WHERE p.nombre_componente LIKE '%$q%' OR p.marca LIKE '%$q%' OR c.nombre_categoria LIKE '%$q%' ORDER BY nombre_componente";
  $result = find_by_sql($sql);
  return $result;
}
/*function find_all_asignaciones(){
  global $db;
  $sql  = "SELECT * FROM asignaciones";
  return find_by_sql($sql);
}*/
/*--------------------------------------------------------------*/
/* Encontrar asignaciones mas recientes
 /*--------------------------------------------------------------*/
function encuentra_asignaciones_mas_recientes($limit)
{
  global $db;
  $sql  = "SELECT s.id,s.cantidad,s.marca_modelo,s.fecha_asignacion,p.nombre_componente";
  $sql .= " FROM asignaciones s";
  $sql .= " LEFT JOIN componentes p ON s.id_componente = p.id";
  $sql .= " ORDER BY s.fecha_asignacion DESC LIMIT " . $db->escape((int)$limit);
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Funcion para generar reporte de asignaciones entre fechas
/*--------------------------------------------------------------*/
function find_asignacion_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = "SELECT s.fecha_asignacion,s.id_detalle_usuario, p.marca, p.modelo, p.nombre_componente,p.precio_compra,d.nombre,d.apellidos, ";
  $sql .= "COUNT(s.id_componente) AS total_records,";
  $sql .= "SUM(s.cantidad) AS total_asignaciones,";
  $sql .= "SUM(p.precio_compra * s.cantidad) AS total_buying_price ";
  $sql .= "FROM asignaciones s ";
  $sql .= "LEFT JOIN detalles_usuario d ON s.id_detalle_usuario = d.id ";
  $sql .= "LEFT JOIN componentes p ON s.id_componente = p.id";
  $sql .= " WHERE s.fecha_asignacion BETWEEN '{$start_date}' AND '{$end_date}'";
  $sql .= " GROUP BY DATE(s.fecha_asignacion),s.id";
  $sql .= " ORDER BY DATE(s.fecha_asignacion) DESC";
  return $db->query($sql);
}
/*--------------------------------------------------------------*/
/* Funcion para generar reporte de resguardos entre fechas
/*--------------------------------------------------------------*/
function find_resguardo_by_dates($start_date, $end_date)
{
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = "SELECT co.nombre_componente, co.descripcion_particular, a.marca_modelo, a.no_serie, a.cantidad, r.id, r.fecha_inicio, r.id_asignacion, r.observaciones, r.id_asignacion_resguardo, d.nombre, d.apellidos, d.correo, c.nombre_cargo, ar.nombre_area ";
  $sql .= "FROM resguardos r ";
  $sql .= "LEFT JOIN asignaciones a ON r.id_asignacion = a.id ";
  $sql .= "LEFT JOIN componentes co ON co.id = a.id_componente ";
  $sql .= "LEFT JOIN detalles_usuario d ON d.id = a.id_detalle_usuario ";
  $sql .= "LEFT JOIN cargos c ON c.id = d.id_cargo ";
  $sql .= "LEFT JOIN area ar ON ar.id = c.id_area ";
  $sql .= "WHERE r.fecha_inicio BETWEEN '{$start_date}' AND '$end_date' ";
  $sql .= "GROUP BY DATE(r.fecha_inicio),d.id ";
  $sql .= "ORDER BY DATE(r.fecha_inicio) DESC";
  return $db->query($sql);
}
/*--------------------------------------------------------------*/
/* Funcion para generar reporte de asignaciones por dia en el mes actual
/*--------------------------------------------------------------*/
function  dailyasignaciones($year, $month)
{
  global $db;
  $sql  = "SELECT s.cantidad,";
  $sql .= " DATE_FORMAT(s.fecha_asignacion, '%Y-%m-%e') AS date,p.nombre_componente,";
  $sql .= "SUM(p.precio_compra * s.cantidad) AS total_asignacion_price";
  $sql .= " FROM asignaciones s";
  $sql .= " LEFT JOIN componentes p ON s.id_componente = p.id";
  $sql .= " WHERE DATE_FORMAT(s.fecha_asignacion, '%Y-%m' ) = '{$year}-{$month}'";
  $sql .= " GROUP BY DATE_FORMAT( s.fecha_asignacion,  '%e' ),s.id";
  return find_by_sql($sql);
}

/*--------------------------------------------------------------*/
/* Funcion para generar reporte de resguardos por dia en el mes actual
/*--------------------------------------------------------------*/
function  dailyresguardos($year, $month)
{
  global $db;
  $sql  = "SELECT r.id as idResguardo,r.fecha_inicio,r.fecha_termino,r.observaciones,r.id_asignacion as idAsig,r.estatus_resguardo,s.id,r.id_asignacion_resguardo";
  $sql .= " FROM resguardos r";
  $sql .= " LEFT JOIN asignaciones s ON s.id = r.id_asignacion";
  $sql .= " WHERE DATE_FORMAT(r.fecha_inicio, '%Y-%m' ) = '{$year}-{$month}'";
  $sql .= " GROUP BY r.id_asignacion_resguardo";
  return find_by_sql($sql);
}

/*--------------------------------------------------------------*/
/* Funcion para encontrar todas las asignaciones que tiene un trabajador */
/*--------------------------------------------------------------*/
function  misasignaciones($id)
{
  global $db;
  $sql  = "SELECT * FROM asignaciones WHERE id_detalle_usuario = {$id} ORDER BY fecha_asignacion DESC";
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Funcion para encontrar todas las asignaciones vehiculares que tiene un trabajador */
/*--------------------------------------------------------------*/
function  misasignaciones_vehiculo($id)
{
  global $db;
  $sql  = "SELECT * FROM asignaciones_vehiculos WHERE id_detalle_usuario = {$id} ORDER BY fecha_asignacion DESC";
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Funcion para encontrar la asignacion que pertenece a un usuario */
/*--------------------------------------------------------------*/
function userdetalle($id)
{
  global $db;
  $sql  = "SELECT s.id_detalle_usuario FROM asignaciones s INNER JOIN users u ON s.id_detalle_usuario = u.id_detalle_user WHERE u.id = {$id} LIMIT 1";
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
/*--------------------------------------------------------------*/
/* Funcion para generar el reporte de asignaciones por mes del año actual
/*--------------------------------------------------------------*/
function  monthlyasignaciones($year)
{
  global $db;
  $sql  = "SELECT s.cantidad,s.id_detalle_usuario, p.marca, p.modelo, p.nombre_componente,p.precio_compra,d.nombre,d.apellidos,";
  $sql .= " DATE_FORMAT(s.fecha_asignacion, '%Y-%m-%e') AS date,p.nombre_componente,";
  $sql .= "SUM(p.precio_compra * s.cantidad) AS total_asignacion_price";
  $sql .= " FROM asignaciones s";
  $sql .= " LEFT JOIN detalles_usuario d ON s.id_detalle_usuario = d.id ";
  $sql .= " LEFT JOIN componentes p ON s.id_componente = p.id";
  $sql .= " WHERE DATE_FORMAT(s.fecha_asignacion, '%Y' ) = '{$year}'";
  $sql .= " GROUP BY DATE_FORMAT( s.fecha_asignacion,  '%c' ),s.id";
  $sql .= " ORDER BY date_format(s.fecha_asignacion, '%Y-%m-%d' ) DESC";
  return find_by_sql($sql);
}

/*--------------------------------------------------------------*/
/* Funcion para generar el reporte de los resguardos por mes del año actual
/*--------------------------------------------------------------*/
function  monthlyresguardos($year)
{
  global $db;
  $sql  = "SELECT r.id as idResguardo,r.fecha_inicio,r.fecha_termino,r.observaciones,r.id_asignacion as idAsig,r.estatus_resguardo,s.id,r.id_asignacion_resguardo";
  $sql .= " FROM resguardos r";
  $sql .= " LEFT JOIN asignaciones s ON s.id = r.id_asignacion";
  $sql .= " WHERE DATE_FORMAT(r.fecha_inicio, '%Y' ) = '{$year}'";
  $sql .= "GROUP BY r.id_asignacion_resguardo";
  $sql .= " ORDER BY date_format(r.fecha_inicio, '%Y-%m-%d' ) DESC";
  // $sql .= " GROUP BY DATE_FORMAT( r.fecha_inicio,  '%c' ),s.id";
  // $sql .= " ORDER BY date_format(r.fecha_inicio, '%Y-%m-%d' ) DESC";
  return find_by_sql($sql);
}



/*----------------------------------------------*/
/* Funcion que encuentra todas las orientaciones */
/*----------------------------------------------*/
function find_all_orientaciones()
{
  global $db;
  $sql = "SELECT o.id as idor,o.folio,o.correo_electronico,o.nombre_completo,o.nivel_estudios,o.ocupacion,o.edad,o.telefono,o.extension,o.sexo,o.calle_numero,
  o.colonia,o.codigo_postal,o.municipio_localidad,o.entidad,o.nacionalidad,o.tipo_solicitud,o.medio_presentacion,o.observaciones,o.adjunto,
  o.id_creador,u.id,u.id_detalle_user,d.nombre,d.apellidos";
  $sql .= " FROM orientacion_canalizacion as o";
  $sql .= " LEFT JOIN users as u ON u.id = o.id_creador";
  $sql .= " LEFT JOIN detalles_usuario as d ON d.id = u.id_detalle_user WHERE tipo_solicitud=1";
  return find_by_sql($sql);
}


/*----------------------------------------------*/
/* Funcion que encuentra todas las orientaciones */
/*----------------------------------------------*/
function find_all_canalizaciones()
{
  global $db;
  $sql = "SELECT o.id as idcan,o.folio,o.correo_electronico,o.nombre_completo,o.nivel_estudios,o.ocupacion,o.edad,o.telefono,o.extension,o.sexo,o.calle_numero,
  o.colonia,o.codigo_postal,o.municipio_localidad,o.entidad,o.nacionalidad,o.tipo_solicitud,o.medio_presentacion,o.observaciones,o.adjunto,
  o.id_creador,u.id,u.id_detalle_user,d.nombre,d.apellidos";
  $sql .= " FROM orientacion_canalizacion as o";
  $sql .= " LEFT JOIN users as u ON u.id = o.id_creador";
  $sql .= " LEFT JOIN detalles_usuario as d ON d.id = u.id_detalle_user WHERE tipo_solicitud=2";
  return find_by_sql($sql);
}

/*----------------------------------------------*/
/* Funcion que encuentra todas las orientaciones */
/*----------------------------------------------*/
function find_all_capacitaciones()
{
  global $db;
  $results = array();
  $sql = "SELECT * FROM capacitaciones ORDER BY fecha";
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
function find_all_recomendaciones()
{
  global $db;
  $results = array();
  $sql = "SELECT * FROM recomendaciones";
  $result = find_by_sql($sql);
  return $result;
}

/*-------------------------------------------------*/
/* Funcion que encuentra todas las fichas técnicas */
/*-------------------------------------------------*/
function find_all_fichas()
{
  global $db;
  $results = array();
  $sql = "SELECT * FROM fichas";
  $result = find_by_sql($sql);
  return $result;
}
/*----------------------------------------------*/
/* Funcion que encuentra todas las resoluciones */
/*----------------------------------------------*/
function find_all_resoluciones()
{
  global $db;
  $results = array();
  $sql = "SELECT * FROM resoluciones";
  $result = find_by_sql($sql);
  return $result;
}
/*----------------------------------------------*/
/* Funcion que encuentra todas las correspondencia */
/*----------------------------------------------*/
function find_all_correspondencia()
{
  global $db;
  $results = array();
  $sql = "SELECT * FROM correspondencia";
  $result = find_by_sql($sql);
  return $result;
}
/*----------------------------------------------*/
/* Funcion que encuentra todas las consejo */
/*----------------------------------------------*/
function find_all_consejo()
{
  global $db;
  $results = array();
  $sql = "SELECT * FROM consejo";
  $result = find_by_sql($sql);
  return $result;
}
/*--------------------------------------------*/
/* Funcion que encuentra todos los  convenios */
/*--------------------------------------------*/
function find_all_convenios()
{
  global $db;
  $results = array();
  $sql = "SELECT * FROM convenios";
  $result = find_by_sql($sql);
  return $result;
}
/*----------------------------------------------------------------------------------*/
/* Funcion que encuentra una ficha técnica por id, que ayudara al momento de editar */
/*----------------------------------------------------------------------------------*/
function find_by_id_ficha($id)
{
  global $db;
  $id = (int)$id;
  $sql = $db->query("SELECT * FROM fichas WHERE id='{$db->escape($id)}' LIMIT 1");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
/*----------------------------------------------------------------------------------*/
/* Funcion que encuentra una resolucion por id, que ayudara al momento de editar */
/*----------------------------------------------------------------------------------*/
function find_by_id_resolucion($id)
{
  global $db;
  $id = (int)$id;
  $sql = $db->query("SELECT * FROM resoluciones WHERE id='{$db->escape($id)}' LIMIT 1");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
/*----------------------------------------------------------------------------------*/
/* Funcion que encuentra una correspondencia por id, que ayudara al momento de editar */
/*----------------------------------------------------------------------------------*/
function find_by_id_correspondencia($id)
{
  global $db;
  $id = (int)$id;
  $sql = $db->query("SELECT * FROM correspondencia WHERE id='{$db->escape($id)}' LIMIT 1");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
/*----------------------------------------------------------------------------------*/
/* Funcion que encuentra una ficha técnica por id, que ayudara al momento de editar */
/*----------------------------------------------------------------------------------*/
function find_by_id_consejo($id)
{
  global $db;
  $id = (int)$id;
  $sql = $db->query("SELECT * FROM consejo WHERE id='{$db->escape($id)}' LIMIT 1");
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
  $sql = $db->query("SELECT * FROM orientacion_canalizacion WHERE id='{$db->escape($id)}' AND tipo_solicitud=1 LIMIT 1");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
/*----------------------------------------------------------------------------*/
/* Funcion que encuentra un convenio por id, que ayudara al momento de editar */
/*----------------------------------------------------------------------------*/
function find_by_id_convenio($id)
{
  global $db;
  $id = (int)$id;
  $sql = $db->query("SELECT * FROM convenios WHERE id='{$db->escape($id)}' LIMIT 1");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
/*------------------------------------------------------------------------------------------------*/
/* Funcion que encuentra una orientación por id para mostrar todos los detalles de la orientacion */
/*------------------------------------------------------------------------------------------------*/
function find_orientacion($id)
{
  global $db;
  $id = (int)$id;
  $sql = "SELECT o.folio,o.correo_electronico,o.nombre_completo,o.nivel_estudios,o.ocupacion,o.edad,o.telefono,o.extension,o.sexo,o.calle_numero,
  o.colonia,o.codigo_postal,o.municipio_localidad,o.entidad,o.nacionalidad,o.tipo_solicitud,o.medio_presentacion,o.observaciones,o.adjunto,
  o.id_creador,u.id,u.id_detalle_user,d.nombre,d.apellidos";
  $sql .= " FROM orientacion_canalizacion as o";
  $sql .= " LEFT JOIN users as u ON u.id = o.id_creador";
  $sql .= " LEFT JOIN detalles_usuario as d ON d.id = u.id_detalle_user WHERE o.id = '{$db->escape($id)}'";
  return find_by_sql($sql);
}

/*----------------------------------------------*/
/* Funcion que encuentra una orientación por id */
/*----------------------------------------------*/
function find_by_id_canalizacion($id)
{
  global $db;
  $id = (int)$id;
  $sql = $db->query("SELECT * FROM orientacion_canalizacion WHERE id='{$db->escape($id)}' AND tipo_solicitud=2 LIMIT 1");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
/*----------------------------------------------*/
/* Funcion que encuentra una capacitación por id */
/*----------------------------------------------*/
function find_by_id_capacitacion($id)
{
  global $db;
  $id = (int)$id;
  $sql = $db->query("SELECT * FROM capacitaciones WHERE id='{$db->escape($id)}' LIMIT 1");
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
  $sql = "SELECT * FROM orientacion_canalizacion ORDER BY id DESC LIMIT 1";
  $result = find_by_sql($sql);
  return $result;
}

/*------------------------------------------------------------------*/
/* Funcion para encontrar el ultimo id de folios de acuerdos para 
   despues sumarle uno y que el nuevo registro tome ese valor */
/*------------------------------------------------------------------*/
function last_id_folios_acuerdos()
{
  global $db;
  $sql = "SELECT * FROM folios_acuerdos ORDER BY id DESC LIMIT 1";
  $result = find_by_sql($sql);
  return $result;
}
/*------------------------------------------------------------------*/
/* Funcion para encontrar el ultimo id de folios de acuerdos para 
   despues sumarle uno y que el nuevo registro tome ese valor */
/*------------------------------------------------------------------*/
function last_id_folios_actividades_sistemas()
{
  global $db;
  $sql = "SELECT * FROM folios_informe_sistemas ORDER BY id DESC LIMIT 1";
  $result = find_by_sql($sql);
  return $result;
}
/*------------------------------------------------------------------*/
/* Funcion para encontrar el ultimo id de folios de recomendaciones
    para despues sumarle uno y que el nuevo registro tome ese valor */
/*------------------------------------------------------------------*/
function last_id_folios_recomendaciones()
{
  global $db;
  $sql = "SELECT * FROM folios_recomendaciones ORDER BY id DESC LIMIT 1";
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
  $sql = "SELECT * FROM folios ORDER BY id DESC LIMIT 1";
  $result = find_by_sql($sql);
  return $result;
}

/* --------------------------------------------------------------------*/
/* Función para obtener el area a la que pertenece el usuario logueado */
/* --------------------------------------------------------------------*/
function area_usuario($id_usuario)
{
  global $db;
  $id_usuario = (int)$id_usuario;

  $sql = $db->query("SELECT g.id 
                      FROM  grupo_usuarios g
                      LEFT JOIN users u ON u.user_level = g.id
                      LEFT JOIN detalles_usuario d ON u.id_detalle_user = d.id 
                      LEFT JOIN cargos c ON c.id = d.id_cargo 
                      LEFT JOIN area a ON a.id = c.id_area 
                      WHERE u.id = '{$db->escape($id_usuario)}' LIMIT 1");
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
  if (($id_area == $require_area) || ($id_area<=2)) {
    return true;
  } else {
    $session->msg("d", "¡Lo siento! tu área no tiene permiso para ver esta página.");
    redirect('home.php', false);
  }
}

/*------------------------------------------------------------------*/
/* Ver todas las quejas que han sido agregadas al libro electrónico */
/*------------------------------------------------------------------*/
function find_all_quejas()
{
  $sql = "SELECT * FROM quejas";
  $result = find_by_sql($sql);
  return $result;
}
/*------------------------------------------------------------------*/
/* Ver todas las quejas que han sido agregadas al libro electrónico */
/*------------------------------------------------------------------*/
function find_all_eventos()
{
  $sql = "SELECT * FROM eventos";
  $result = find_by_sql($sql);
  return $result;
}
/*--------------------------------------------------------------*/
/*  Funcion para encontrar datos por su id en una tabla
/*--------------------------------------------------------------*/
function find_by_ticket_id($table, $id)
{
  global $db;
  $id = (int)$id;
  if (tableExists($table)) {
    $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE ticket_id='{$db->escape($id)}' LIMIT 1");
    if ($result = $db->fetch_assoc($sql))
      return $result;
    else
      return null;
  }
}

/*------------------------------------------------------------------------*/
/* Funcion para contar todas la orientaciones que son de mujeres */
/*------------------------------------------------------------------------*/
function count_by_id_mujer($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(sexo) AS total FROM " . $db->escape($table) . " WHERE sexo = 'M' and tipo_solicitud = 1";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_id_hombre($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(sexo) AS total FROM " . $db->escape($table) . " WHERE sexo = 'H' and tipo_solicitud = 1";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_id_lgbt($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(sexo) AS total FROM " . $db->escape($table) . " WHERE sexo = 'LGBTTTIQA' and tipo_solicitud = 1";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_comLg($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Comunidad LGBTTTIQA' and tipo_solicitud = 1";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_derMuj($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Derecho de las mujeres' and tipo_solicitud = 1";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_nna($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Niñas, niños y adolescentes' and tipo_solicitud = 1";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_disc($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Personas con discapacidad' and tipo_solicitud = 1";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_mig($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Personas migrantes' and tipo_solicitud = 1";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_vih($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Personas que viven con VIH SIDA' and tipo_solicitud = 1";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_gi($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Grupos indígenas' and tipo_solicitud = 1";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_perio($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Periodistas' and tipo_solicitud = 1";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_ddh($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Defensores de los derechos humanos' and tipo_solicitud = 1";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_am($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Adultos mayores' and tipo_solicitud = 1";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_int($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Internos' and tipo_solicitud = 1";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_otros($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'Otros' and tipo_solicitud = 1";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
function count_by_na($table)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(grupo_vulnerable) AS total FROM " . $db->escape($table) . " WHERE grupo_vulnerable = 'No Aplica' and tipo_solicitud = 1";
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}
// global $db;
//   $id = (int)$id;
//   $sql = $db->query("SELECT COUNT(*) FROM quejas WHERE ticket_id = '{$db->escape($id)}'");
//   if ($result = $db->fetch_assoc($sql))
//     return $result;
//   else
//     return 0;