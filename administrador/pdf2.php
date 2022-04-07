<?php
include("includes/config.php");
$page_title = 'Resguardo Vehicular';
require_once('includes/load.php');
require_once('dompdf/autoload.inc.php');

use Dompdf\Dompdf;
use Dompdf\Options;
ob_start(); //Linea para que deje descargar el PDF
$id_resguardo = (int)$_GET['id'];
$resguardos = resguardo_pdf_vehiculo($id_resguardo);
$folio = busca_folio_vehicular((int)$_GET['id']);
//$currentsite = getcwd();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
</head>

<body>
  <!-- <div class="container">     -->
  <div>
    <img src="http://localhost:8080/InventarioSIGIEC/inventario_CEDH/logocedh.png" width="140" height="60"><br><br>
  </div>
  <h2 style="text-align: center;">Resguardo interno de los equipos de cómputo</h2>
  <div style="margin: 0 auto;">
    <div style="display: inline-block; float: left; width: 70%;">Fecha de asignación: <?php echo read_date_fecha($resguardos[0]['fecha_inicio']); ?></div>
    <div style="display: inline-block; float: right; width: 30%;">Folio: <?php echo ($folio['folio']) ?></div><br>
  </div><br><br>

  <div style="background: black; color: white; height: 20px;">
    Datos del equipo
  </div><br><br>

  <table border="1" style="border-collapse: collapse; width: 100%; ">
    <thead>
      <tr>
        <th style="width: 0%;">Placas</th>
        <th style="width: 20%;">Tipo</th>
        <th style="width: 25%;">Descripción</th>
        <th style="width: 25%;">Marca/Modelo</th>
        <th style="width: 30%;">No. de Serie</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($resguardos as $resguardo) : ?>
        <?php if($resguardo['estatus_asignacion'] == 1): ?>
          <tr>
            <td><?php echo remove_junk($resguardo['placas']); ?></td>
            <td><?php echo remove_junk($resguardo['nombre_vehiculo']); ?></td>
            <td>Año: <?php echo remove_junk($resguardo['anio']); ?><br>Color: <?php echo remove_junk($resguardo['color']); ?><br>Motor:<?php echo remove_junk($resguardo['motor']); ?></td>
            <td><?php echo remove_junk($resguardo['marca_modelo']); ?></td>
            <td><?php echo remove_junk($resguardo['no_serie']); ?></td>
          </tr>
        <?php endif ?>
      <?php endforeach ?>
    </tbody>
  </table>
  <br>
  <div>
    Observaciones:
    <div style="border: solid 1px black; height: 130px;">
      <?php foreach ($resguardos as $resguardo) : ?>
        <?php if ($resguardo['estatus_asignacion'] == 1): ?>
          <?php if ($resguardo['observaciones'] == ""): ?>
            <?php echo remove_junk($resguardo['observaciones']); ?><br>
          <?php else: ?>
            <?php echo remove_junk($resguardo['marca_modelo']) . ": " . remove_junk($resguardo['observaciones']); ?><br>
          <?php endif?>
        <?php endif?>
      <?php endforeach ?>
    </div>
  </div><br>
  <div style="background: black; color: white; height: 20px;">
    Datos del resguardante
  </div><br>
  <div>
    <div style="float: left;">
      Nombre:
    </div>
    <div style="margin-left : 20px; float: left; border: solid 1px black; width:89%;">
      <?php echo remove_junk($resguardo['nombre'] . " " . $resguardo['apellidos']); ?>
    </div>
  </div><br><br>
  <div>
    <div style="float: left;">
      Puesto o función:
    </div>
    <div style="margin-left : 20px; float: left; border: solid 1px black; width:40%;">
      <?php echo remove_junk($resguardo['nombre_cargo']); ?>
    </div>
    <div style="margin-left : 40px; float: left; width:20%;">
      Jack:
    </div>
  </div><br><br>
  <div>
    <div style="float: left;">
      Área:
    </div>
    <div style="margin-left : 10px; float: left; border: solid 1px black; width:35%;">
      <?php echo remove_junk($resguardo['nombre_area']); ?>
    </div>
    <div style="margin-left : 5px; float: left;">
      Correo:
    </div>
    <div style="margin-left : 10px; float: left; border: solid 1px black; width:30%;">
      <?php echo remove_junk($resguardo['correo']); ?>
    </div>
    <div style="margin-left : 5px; float: left;">
      Ext:
    </div>
    <div style="margin-left : 10px; float: left; border: solid 1px black; width:10%; height: 45px;">

    </div>
  </div><br>
  <div style="margin-top: 60px;">
    <table border="1" style="border-collapse: collapse; width: 100%; ">
      <thead style="background-color: #61B025;">
        <tr>
          <th>Resguardante</th>
          <th>Área de Soporte Técnico y Mantenimiento</th>
        </tr>
      </thead>
      <tbody>
          <tr>
            <td style="font-size: 10px; width:50%" VALIGN="TOP">*Conozco y Acepto las Políticas establecidas en este resguardo.</td>
            <td style="height: 80px;"></td>          
          </tr>
          <tr style="text-align: center">
            <td style="height: 30px;" VALIGN="TOP ">Nombre y Firma</td>
            <td style="font-weight: bold;" VALIGN="TOP">Mtro. Apolinar Servín Arreguín <br> Responsable del Área</td>
          </tr>
      </tbody>
    </table>
  </div>

</body>

<?php
$options = new Options();
$options->set('isRemoteEnabled', TRUE);
$dompdf = new DOMPDF($options);
$dompdf->loadHtml(ob_get_clean());
$dompdf->setPaper("letter");
$dompdf->render();
//$pdf->image();
$pdf = $dompdf->output();
$filename = "resguardo_vehiculo.pdf";
file_put_contents($filename, $pdf);
$dompdf->stream($filename);

?>