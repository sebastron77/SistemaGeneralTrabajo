<?php
$page_title = 'Canalizaciones';
require_once('includes/load.php');
?>
<?php
// page_require_level(5);
$all_canalizaciones = find_all_canalizaciones();
// $user = current_user();
$user = current_user();
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
    page_require_level_exacto(7);
}
?>
<?php include_once('layouts/header.php'); ?>
<a href="solicitudes_quejas.php" class="btn btn-success">Regresar</a><br><br>
<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Lista de Canalizaciones</span>
                </strong>
                <?php if (($nivel <= 2) || ($nivel == 5)) : ?>
                    <a href="add_canalizacion.php" class="btn btn-info pull-right">Agregar canalización</a>
                <?php endif; ?>
            </div>

            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 10%;">Folio</th>
                            <th style="width: 5%;">Tipo</th>
                            <th style="width: 5%;">Medio presentación</th>
                            <th style="width: 1%;">Adjunto</th>
                            <th style="width: 5%;">Correo</th>
                            <!--SE PUEDE AGREGAR UN LINK QUE TE LLEVE A EDITAR EL USUARIO, COMO EN EL PANEL DE CONTROL EN ULTIMAS ASIGNACIONES-->
                            <th style="width: 5%;">Nombre Completo</th>
                            <th style="width: 5%;">Ocupación</th>
                            <th style="width: 3%;">Creador</th>
                            <?php if (($nivel <= 2) || ($nivel == 5)) : ?>
                                <th style="width: 10%;" class="text-center">Acciones</th>
                            <?php endif ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_canalizaciones as $a_canalizacion) : ?>
                            <tr>
                                <td><?php echo remove_junk(ucwords($a_canalizacion['folio'])) ?></td>
                                <td><?php
                                    if ($a_canalizacion['tipo_solicitud'] == '1') {
                                        echo 'Orientación';
                                    }
                                    if ($a_canalizacion['tipo_solicitud'] == '2') {
                                        echo 'Canalización';
                                    }
                                    ?>
                                </td>
                                <?php
                                $folio_editar = $a_canalizacion['folio'];
                                $resultado = str_replace("/", "-", $folio_editar);
                                ?>
                                <td><?php echo remove_junk(ucwords($a_canalizacion['medio_presentacion'])) ?></td>
                                <td><a target="_blank" href="uploads/orientacioncanalizacion/canalizacion/<?php echo $resultado . '/' . $a_canalizacion['adjunto']; ?>"><?php echo $a_canalizacion['adjunto']; ?></a></td>
                                <td><?php echo remove_junk(ucwords($a_canalizacion['correo_electronico'])) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_canalizacion['nombre_completo']))) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_canalizacion['ocupacion']))) ?></td>
                                <td><?php echo remove_junk($a_canalizacion['nombre'] . " " . $a_canalizacion['apellidos']) ?></td>
                                <?php if (($nivel <= 2) || ($nivel == 5)) : ?>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="ver_info_canal.php?id=<?php echo (int)$a_canalizacion['idcan']; ?>" class="btn btn-md btn-info" data-toggle="tooltip" title="Ver información">
                                                <i class="glyphicon glyphicon-eye-open"></i>
                                            </a>
                                            <a href="edit_canalizacion.php?id=<?php echo (int)$a_canalizacion['idcan']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
                                                <span class="glyphicon glyphicon-edit"></span>
                                            </a>
                                            <?php if ($nivel == 1) : ?>
                                                <!-- <a href="delete_orientacion.php?id=<?php echo (int)$a_canalizacion['id']; ?>" class="btn btn-delete btn-md" title="Eliminar" data-toggle="tooltip" onclick="return confirm('¿Seguro(a) que deseas eliminar esta orientación?');">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </a> -->
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>