<?php require_once('includes/load.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
    <link rel="stylesheet" href="libs/css/main.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="libs/js/functions.js"></script>
</head>

<body>
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
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="index.php" style="color: #FFFFEF">Iniciar Sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <?php $all_recomendaciones = find_all_recomendaciones(); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <strong>
                        <span class="glyphicon glyphicon-th"></span>
                        <span>Recomendaciones</span>
                    </strong>
                </div>

                <div class="panel-body">
                    <table class="datatable table table-bordered table-striped">
                        <thead>
                            <tr style="height: 10px;" class="info">
                                <th class="text-center" style="width: 2%;">Folio Recomendación</th>
                                <th class="text-center" style="width: 1%;">Folio Queja</th>
                                <th class="text-center" style="width: 4%;">Autoridad Responsable</th>
                                <th class="text-center" style="width: 4%;">Servidor Público</th>
                                <th class="text-center" style="width: 4%;">Fecha de Recomendación</th>
                                <th class="text-center" style="width: 5%;">Observaciones</th>
                                <th class="text-center" style="width: 5%;">Recomendación adjunto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($all_recomendaciones as $a_recomendacion) : ?>
                                <tr>
                                    <td class="text-center"><?php echo remove_junk(ucwords($a_recomendacion['folio_recomendacion'])) ?></td>
                                    <td class="text-center"><?php echo remove_junk(ucwords($a_recomendacion['folio_queja'])) ?></td>
                                    <td><?php echo remove_junk(ucwords($a_recomendacion['autoridad_responsable'])) ?></td>
                                    <td><?php echo remove_junk(ucwords($a_recomendacion['servidor_publico'])) ?></td>
                                    <td><?php echo remove_junk(ucwords($a_recomendacion['fecha_recomendacion'])) ?></td>
                                    <td class="text-center"><?php echo remove_junk(ucwords($a_recomendacion['observaciones'])) ?></td>
                                    <?php
                                    $folio_editar = $a_recomendacion['folio_queja'];
                                    $resultado = str_replace("/", "-", $folio_editar);
                                    ?>
                                    <td><a target="_blank" style="color: #23296B;" href="uploads/quejas/<?php echo $resultado . '/' . 'recomendacion/' . $a_recomendacion['recomendacion_adjunto']; ?>"><?php echo $a_recomendacion['recomendacion_adjunto']; ?></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>