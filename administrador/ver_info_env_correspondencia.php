<?php
$page_title = 'Correspondencia';
require_once('includes/load.php');
?>
<?php
// page_require_level(2);
$a_correspondencia = find_by_id('envio_correspondencia', (int)$_GET['id']);
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

<a href="javascript:history.back()" class="btn btn-success">Regresar</a><br><br>

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
                    <span>Ver Correspondencia Interna <?php echo $a_correspondencia['folio'] ?></span>
                </strong>
            </div>

            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 4%;">Folio</th>
                            <th style="width: 5%;">Fecha Emisión</th>
                            <th style="width: 5%;">Asunto</th>
                            <th style="width: 10%;">Medio de envío</th>
                            <th style="width: 10%;">Área a la que se turna</th>
                            <th style="width: 10%;">Fecha en que se turna</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo remove_junk(ucwords($a_correspondencia['folio'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_correspondencia['fecha_emision'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_correspondencia['asunto'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_correspondencia['medio_envio'])) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_correspondencia['se_turna_a_area']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_correspondencia['fecha_en_que_se_turna']))) ?></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 15%;">Fecha en que se espera respuesta</th>
                            <th style="width: 15%;">Tipo de trámite</th>
                            <th style="width: 15%;">Oficio Enviado</th>
                            <th style="width: 15%;">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo remove_junk(ucwords(($a_correspondencia['fecha_espera_respuesta']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_correspondencia['tipo_tramite']))) ?></td>
                            <?php
                            $folio_editar = $a_correspondencia['folio'];
                            $resultado = str_replace("/", "-", $folio_editar);
                            ?>
                            <td><a target="_blank" style="color: #23296B;" href="uploads/correspondencia/<?php echo $resultado . '/' . $a_correspondencia['oficio_enviado']; ?>"><?php echo $a_correspondencia['oficio_enviado']; ?></a></td>
                            <td><?php echo remove_junk(ucwords(($a_correspondencia['observaciones']))) ?></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="info">
                            <th style="width: 10%;">Acción Realizada</th>
                            <th style="width: 5%;">Fecha</th>
                            <th style="width: 10%;">Oficio de respuesta</th>
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
                            <td><a target="_blank" style="color: #23296B;" href="uploads/correspondencia/<?php echo $resultado . '/' . $a_correspondencia['oficio_respuesta']; ?>"><?php echo $a_correspondencia['oficio_respuesta']; ?></a></td>
                            <td><?php echo remove_junk(ucwords(($a_correspondencia['quien_realizo']))) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>