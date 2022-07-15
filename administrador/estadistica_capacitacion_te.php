<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Estadísticas de Capacitaciones';
require_once('includes/load.php');

$user = current_user();
$nivel_user = $user['user_level'];
// page_require_area(7);
if ($nivel_user <= 3) {
  page_require_level(3);
}
if ($nivel_user == 5) {
  page_require_level_exacto(5);
}
if ($nivel_user == 7) {
  page_require_level_exacto(7);
}

// if ($nivel_user > 3 && $nivel_user < 7) :
//   redirect('home.php');
// endif;
if ($nivel_user > 7) :
  redirect('home.php');
endif;
$total_capacitacion = count_by_capacitacion('capacitaciones');
$total_conferencia = count_by_conferencia('capacitaciones');
$total_curso = count_by_curso('capacitaciones');
$total_taller = count_by_taller('capacitaciones');
$total_platica = count_by_platica('capacitaciones');
$total_diplomado = count_by_diplomado('capacitaciones');
$total_foro = count_by_foro('capacitaciones');

?>

<?php include_once('layouts/header.php'); ?>
<a href="tabla_estadistica_capacitacion.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
  Regresar
</a><br><br>
<!-- Debemos de tener Canvas en la página -->
<center>
  <button id="btnCrearPdf" style="margin-top: -5%" class="btn btn-pdf btn-md">Guardar en PDF</button>
  <div id="prueba">
    <center>
      <h2 style="margin-top: 5px;">Estadística de Capacitaciones (Por tipo de evento)</h2>
    </center>
    <div class="row" style="display: flex; justify-content: center; align-items: center; margin-left: -10%;">
      <div class="col-md-6" style="width: 40%; height: 20%;">
        <canvas id="myChart"></canvas>
        <!-- Incluímos Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Añadimos el script a la página -->

        <script>
          var yValues = [<?php echo $total_capacitacion['total']; ?>, <?php echo $total_conferencia['total']; ?>, <?php echo $total_curso['total']; ?>,
            <?php echo $total_taller['total']; ?>, <?php echo $total_platica['total']; ?>, <?php echo $total_diplomado['total']; ?>, <?php echo $total_foro['total']; ?>
          ];

          const ctx = document.getElementById('myChart');
          const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: ['Capacitación', 'Conferencia', 'Curso', 'Taller', 'Platica', 'Diplomado', 'Foro'],
              datasets: [{
                label: 'Capacitaciones por tipo de evento',
                data: yValues,
                backgroundColor: [
                  '#60A685',
                  '#91D9B7',
                  '#ACF2D1',
                  '#01401C',
                  '#2F734C',
                  '#015948',
                  '#02A686'
                ],
                borderColor: [
                  '#467860',
                  '#71A88E',
                  '#709E89',
                  '#012912',
                  '#204F35',
                  '#014033',
                  '#018066'
                ],
                borderWidth: 2
              }]
            },
            options: {
              legend: {
                display: false
              },
              // El salto entre cada valor de Y
              ticks: {
                min: 0,
                max: 6000,
                stepSize: 1
              },

            }
          });
        </script>
      </div>
    </div>
    <div class="row" style="display: flex; justify-content: center; align-items: center;">
      <div class="col-md-6" style="margin-top: 3%;">
        <table class="table table-bordered table-striped">
          <thead>
            <tr style="height: 10px;" class="info">
              <th class="text-center" style="width: 70%;">Tipo de Evento</th>
              <th class="text-center" style="width: 30%;">Cantidad</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Capacitación</td>
              <?php if ($total_capacitacion['total'] != 0) { ?>
                <td class="text-center"><?php echo $total_capacitacion['total']; ?></td>
              <?php } else { ?>
                <td class="text-center">0</td>
              <?php } ?>
            </tr>
            <tr>
              <td>Conferencia</td>
              <?php if ($total_conferencia['total'] != 0) { ?>
                <td class="text-center"><?php echo $total_conferencia['total']; ?></td>
              <?php } else { ?>
                <td class="text-center">0</td>
              <?php } ?>
            </tr>
            <tr>
              <td>Curso</td>
              <?php if ($total_curso['total'] != 0) { ?>
                <td class="text-center"><?php echo $total_curso['total']; ?></td>
              <?php } else { ?>
                <td class="text-center">0</td>
              <?php } ?>
            </tr>
            <tr>
              <td>Taller</td>
              <?php if ($total_taller['total'] != 0) { ?>
                <td class="text-center"><?php echo $total_taller['total']; ?></td>
              <?php } else { ?>
                <td class="text-center">0</td>
              <?php } ?>
            </tr>
            <tr>
              <td>Plática</td>
              <?php if ($total_platica['total'] != 0) { ?>
                <td class="text-center"><?php echo $total_platica['total']; ?></td>
              <?php } else { ?>
                <td class="text-center">0</td>
              <?php } ?>
            </tr>
            <tr>
              <td>Diplomado</td>
              <?php if ($total_diplomado['total'] != 0) { ?>
                <td class="text-center"><?php echo $total_diplomado['total']; ?></td>
              <?php } else { ?>
                <td class="text-center">0</td>
              <?php } ?>
            </tr>
            <tr>
              <td>Foro</td>
              <?php if ($total_foro['total'] != 0) { ?>
                <td class="text-center"><?php echo $total_foro['total']; ?></td>
              <?php } else { ?>
                <td class="text-center">0</td>
              <?php } ?>
            </tr>
            <tr>
              <td style="text-align:right;"><b>Total</b></td>
              <td>
                <?php echo $total_capacitacion['total'] + $total_conferencia['total'] + $total_curso['total'] + $total_taller['total'] + $total_platica['total'] +
                  $total_diplomado['total'] + $total_foro['total'];
                ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</center>
<!-- </div> -->

<?php include_once('layouts/footer.php'); ?>