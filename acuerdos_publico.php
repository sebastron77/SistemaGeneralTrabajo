<?php require_once('administrador/includes/load.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
    <link rel="stylesheet" href="administrador/libs/css/main.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/css/dataTables.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.1/css/buttons.bootstrap.min.css" type="text/css" />
</head>

<body class="bodyPublico container">
    <nav class="navbar navbar-default" style="background: #075E9A;">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="principal.php" style="color: #FFFFEF;">Libro Electrónico de la CEDH</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a class="boton4" href="acuerdos_publico.php" style="color: #FFFFEF">Acuerdos de No Violación</a></li>
                    <li><a class="boton4" href="recomendaciones_publico.php" style="color: #FFFFEF">Recomendaciones</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <?php $all_acuerdos = find_all_acuerdos(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <strong>
                        <span class="glyphicon glyphicon-th"></span>
                        <span>Acuerdos de No Violación</span>
                    </strong>
                </div>
                <div class="panel-body">
                    <table class="datatable table table-bordered table-striped">
                        <thead>
                            <tr style="height: 10px;" class="info">
                                <th class="text-center" style="width: 2%;">Folio Acuerdo</th>
                                <th class="text-center" style="width: 1%;">Folio Queja</th>
                                <th class="text-center" style="width: 4%;">Autoridad Responsable</th>
                                <th class="text-center" style="width: 4%;">Servidor Público</th>
                                <th class="text-center" style="width: 3%;">Fecha de Acuerdo</th>
                                <th class="text-center" style="width: 5%;">Observaciones</th>
                                <th class="text-center" style="width: 5%;">Acuerdo adjunto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($all_acuerdos as $a_acuerdo) : ?>
                                <tr>
                                    <td><?php echo remove_junk(ucwords($a_acuerdo['folio_acuerdo'])) ?></td>
                                    <td><?php echo remove_junk(ucwords($a_acuerdo['folio_queja'])) ?></td>
                                    <td><?php echo remove_junk(ucwords($a_acuerdo['autoridad_responsable'])) ?></td>
                                    <td><?php echo remove_junk(ucwords($a_acuerdo['servidor_publico'])) ?></td>
                                    <td class="text-center"><?php echo remove_junk(ucwords($a_acuerdo['fecha_acuerdo'])) ?></td>
                                    <td><?php echo remove_junk(ucwords($a_acuerdo['observaciones'])) ?></td>
                                    <?php
                                    $folio_editar = $a_acuerdo['folio_queja'];
                                    $resultado = str_replace("/", "-", $folio_editar);
                                    ?>
                                    <td><a target="_blank" style="color: #23296B;" href="administrador/uploads/quejas/<?php echo $resultado . '/' . 'acuerdosNoViolacion/' . $a_acuerdo['acuerdo_adjunto']; ?>"><?php echo $a_acuerdo['acuerdo_adjunto']; ?></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="administrador/libs/js/functions.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <!-- Responsive extension -->
    <script src="https://cdn.datatables.net/responsive/2.1.0/js/responsive.bootstrap.min.js"></script>
    <!-- Buttons extension -->
    <script src="//cdn.datatables.net/buttons/1.2.1/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.1/js/buttons.bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="administrador/libs/js/pagination.js"></script>
</body>

</html>