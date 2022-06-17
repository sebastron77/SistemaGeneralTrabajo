<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <meta charset="UTF-8">
</head>

<body>

    <h1>Galería de imágenes</h1>
    <?php
    $borrar = filter_input(INPUT_GET, 'borrar');
    if (!empty($borrar)) {
        unlink("uploads/jornadas/CEDH-0103-2022-JOR/" . $borrar);
    }
    ?>
    <hr />
    <div style='display:flex;flex-wrap: wrap;'>
        <?php
        $imagenes = scandir("uploads/jornadas/CEDH-0103-2022-JOR"); //asegurate de añadir la ruta correcta a tu carpeta de imágenes
        for ($i = 2; $i < count($imagenes); $i++) {
        ?>
            <div class="card" style="width:200px">
                <img class="card-img-top" src="uploads/jornadas/CEDH-0103-2022-JOR/<?= $imagenes[$i] ?>" alt="Card image">
                <div class="card-body">
                    <h4 class="card-title"><?= $imagenes[$i] ?></h4>
                    <a href="?borrar=<?= $imagenes[$i] ?>" class="btn btn-danger">Borrar imagen</a>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</body>

</html>