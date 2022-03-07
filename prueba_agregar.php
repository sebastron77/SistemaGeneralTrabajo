<?php
$page_title = 'Agregar resguardo';
require_once('includes/load.php');

page_require_level(2);
$trabajadores = find_all_trabajadores();
$asignaciones = find_all_asignaciones();
?>

<script>
    a = 0;

    //Para agregar una nueva fila de asignaciones
    function addResguardo() {
        a++;
        var div = document.createElement('div');
        div.setAttribute('class', 'form-inline');
        div.innerHTML = '<div style="clear:both" class=\"col-md-3\"><div class=\"form-group\"><input id=\"inicio\" type=\"date\" class=\"form-control datepicker\" name=\"inicio[]\" data-date-format=\"yyyy-mm-dd\" required></div></div><div class=\"col-md-3\"><div class=\"form-group\"><textarea type=\"text\" id=\"tipo\"class=\"form-control\" name=\"tipo[]\"></textarea></div></div><div class=\"col-md-4\"><select id=\"asignacion\" class=\"form-control\" name=\"asignacion[]\" required><?php foreach ($asignaciones as $asignacion) : ?><?php foreach ($trabajadores as $trabajador) : ?><?php if ($asignacion['id_detalle_usuario'] == $trabajador['detalleID']) : ?><option value=\"<?php echo $asignacion['id']; ?>\"><?php echo ($asignacion['nombre_componente']) . " | " . $asignacion["marca_modelo"] . " | " . ucwords($trabajador['nombre'] . " " . $trabajador['apellidos']) . " | " . ucwords($asignacion['fecha_asignacion']); ?></option><?php endif; ?><?php endforeach; ?><?php endforeach; ?></select></div><br>';
        document.getElementById('resguardos').appendChild(div);
        document.getElementById('resguardos').appendChild(div);
    }

    //Para quitar una fila de asignaciones
    function removeResguardo() {
        let element = document.getElementById("resguardos");
        if (element.lastChild) {
            element.removeChild(element.lastChild);
        }
    }
</script>