<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Estadística de Quejas';
require_once('includes/load.php');
?>
<?php
$listar = null;
$directorio = opendir("uploads/atencion/");

// $dir = (isset($_GET['dir'])) ? $_GET['dir'] : "/";
// $directorio = opendir($dir);

// while ($elemento = readdir($directorio)) {
//     if ($elemento != '.' && $elemento != '..')
//         echo "<a href='uploads/atencion/$elemento' target='_blank'>$elemento/</a><br>";
//     elseif ($elemento == '..') {
//         if ($diretorio != '.') {
//             $carpetas = explode("/", $diretorio);
//             array_pop($carpetas);
//             $dir2 = join("/", $carpetas);
//             echo "<a href=\"?directorio=$dir2\">$elemento</a><br>";
//         }
//     } elseif (is_dir("$diretorio/$elemento"))
//         echo "<a href=\"?directorio=$diretorio/$elemento\">$elemento</a><br>";
//     else echo "$elemento<br>";
// }

while($elemento = readdir($directorio))
{
    if($elemento != '.' && $elemento != '..')
    {
        if(is_dir("atencion/" . $elemento))
        {
            $listar .= "<li><a href='uploads/atencion/$elemento' target='_blank'>$elemento/</a></li>";
        }
        else
        {
            $listar .= "<li><a href='uploads/atencion/$elemento' target='_blank'>$elemento</a></li>";
        }
    }
}

?>

<h1>Prueba de Directorios</h1>

<ul>
    <?php echo $listar ?>
</ul>

<?php include_once('layouts/footer.php'); ?>