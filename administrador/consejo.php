<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Consejo';
require_once('includes/load.php');
?>
<?php

$all_consejo = find_all_consejo();

$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
$nivel_user = $user['user_level'];

if ($nivel_user <= 2) {
    page_require_level(2);
}
if ($nivel_user == 7) {
    page_require_level_exacto(7);
}

if ($nivel_user > 2 && $nivel_user < 7):
    redirect('home.php');
endif;

// page_require_level(2);

// page_require_area(4);
?>
<?php include_once('layouts/header.php'); ?>

<a href="solicitudes.php" class="btn btn-success">Regresar</a><br><br>

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
                    <span>Consejo</span>
                </strong>
                <?php if ($nivel_user <= 2) : ?>
                    <a href="add_consejo.php" class="btn btn-info pull-right">Agregar Consejo</a>
                <?php endif; ?>
            </div>

            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 5%;">Folio</th>
                            <th style="width: 1%;">No. Sesión</th>
                            <th style="width: 10%;">Tipo Sesión</th>
                            <th style="width: 5%;">Fecha Sesión</th>
                            <th style="width: 1%;">Hora</th>
                            <th style="width: 2%;">Lugar</th>
                            <th style="width: 1%;">No. Asistentes</th>
                            <th style="width: 5%;">Orden del día</th>
                            <th style="width: 5%;">Acta acuerdos</th>
                            <?php if ($nivel_user <= 2) : ?>
                                <th style="width: 5%;" class="text-center">Acciones</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_consejo as $a_consejo) : ?>
                            <?php
                            $folio_editar = $a_consejo['folio'];
                            $resultado = str_replace("/", "-", $folio_editar);
                            ?>
                            <tr>
                                <td><?php echo remove_junk(ucwords($a_consejo['folio'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_consejo['num_sesion'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_consejo['tipo_sesion'])) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_consejo['fecha_sesion']))) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_consejo['hora']))) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_consejo['lugar']))) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_consejo['num_asistentes']))) ?></td>
                                <td><a target="_blank" style="color: #23296B;" href="uploads/consejo/<?php echo $resultado . '/' . $a_consejo['orden_dia']; ?>"><?php echo $a_consejo['orden_dia']; ?></a></td>
                                <td><a target="_blank" style="color: #23296B;" href="uploads/consejo/<?php echo $resultado . '/' . $a_consejo['acta_acuerdos']; ?>"><?php echo $a_consejo['acta_acuerdos']; ?></a></td>
                                <?php if ($nivel_user <= 2) : ?>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="edit_consejo.php?id=<?php echo (int)$a_consejo['id']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
                                                <span class="glyphicon glyphicon-edit"></span>
                                            </a>
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