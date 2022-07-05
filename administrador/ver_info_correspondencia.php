<?php
$page_title = 'Ver información - Correspondencia';
require_once('includes/load.php');
?>
<?php
// page_require_level(2);
$a_correspondencia = find_by_id('correspondencia', (int)$_GET['id']);
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
$nivel_user = $user['user_level'];

// if ($nivel_user <= 2) {
//     page_require_level(2);
// }
// if ($nivel_user == 7) {
//     page_require_level_exacto(7);
// }
// if ($nivel_user == 8) {
//     page_require_level_exacto(8);
// }

// if ($nivel_user > 2 && $nivel_user < 7) :
//     redirect('home.php');
// endif;
// if ($nivel_user > 8) :
//     redirect('home.php');
// endif;
?>
<?php include_once('layouts/header.php'); ?>

<a href="correspondencia.php" class="btn btn-success">Regresar</a><br><br>

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
                    <span>Ver Correspondencia <?php echo $a_correspondencia['folio'] ?></span>
                </strong>
            </div>

            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 4%;">Folio</th>
                            <th style="width: 5%;">Fecha Recibido</th>
                            <th style="width: 5%;">Num. Oficio de Recepción</th>
                            <th style="width: 10%;">Remitente</th>
                            <th style="width: 10%;">Institución</th>
                            <th style="width: 10%;">Cargo Funcionario</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo remove_junk(ucwords($a_correspondencia['folio'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_correspondencia['fecha_recibido'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_correspondencia['num_oficio_recepcion'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_correspondencia['nombre_remitente'])) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_correspondencia['nombre_institucion']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_correspondencia['cargo_funcionario']))) ?></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 15%;">Asunto</th>
                            <th style="width: 15%;">Medio de Recepción</th>
                            <th style="width: 15%;">Medio de Entrega</th>
                            <th style="width: 15%;">Área a la que se turnó</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo remove_junk(ucwords(($a_correspondencia['asunto']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_correspondencia['medio_recepcion']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_correspondencia['medio_entrega']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_correspondencia['se_turna_a_area']))) ?></td>
                        </tr>
                    </tbody>
                </table>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 5%;">Fecha en que se turnó</th>
                            <th style="width: 5%;">Fecha para respuesta</th>
                            <th style="width: 5%;">Tipo de Trámite</th>
                            <th style="width: 10%;">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo remove_junk(ucwords($a_correspondencia['fecha_en_que_se_turna'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_correspondencia['fecha_espera_respuesta'])) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_correspondencia['tipo_tramite']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_correspondencia['observaciones']))) ?></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 10%;">Acción Realizada</th>
                            <th style="width: 5%;">Fecha</th>
                            <th style="width: 10%;">Oficio</th>
                            <th style="width: 10%;">Quién realizó</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo remove_junk(ucwords($a_correspondencia['accion_realizada'])) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_correspondencia['fecha']))) ?></td>                            
                            <?php
                            $folio_editar = $a_correspondencia['folio'];
                            $resultado = str_replace("/", "-", $folio_editar);
                            ?>
                            <td><a target="_blank" style="color: #23296B;" href="uploads/correspondencia/<?php echo $resultado . '/' . $a_correspondencia['oficio']; ?>"><?php echo $a_correspondencia['oficio']; ?></a></td>
                            <td><?php echo remove_junk(ucwords(($a_correspondencia['quien_realizo']))) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>